<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Services\Seguridad;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Catalogos de config/catalogos.php contra BDGEPRO. Lo que graba corre dentro de una transaccion
 * que se revierte (DatabaseTransactions): no queda nada grabado.
 */
class CatalogosTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    private function usuario(bool $soloConsulta = false): ?object
    {
        return $this->usuarioGepro($soloConsulta);
    }

    public function test_la_configuracion_coincide_con_la_base(): void
    {
        foreach (config('catalogos') as $pagina => $def) {
            [$esquema, $tabla] = explode('.', $def['tabla']);
            $columnas = DB::table('INFORMATION_SCHEMA.COLUMNS')->where('TABLE_SCHEMA', $esquema)->where('TABLE_NAME', $tabla)->pluck('COLUMN_NAME')->all();
            $this->assertNotEmpty($columnas, "$pagina: no existe la tabla");
            foreach (array_unique(array_merge([$def['id'], $def['estado']], $def['parametros'], array_keys($def['campos']))) as $c) {
                $this->assertContains($c, $columnas, "$pagina: no existe la columna $c");
            }
            $this->assertNotNull(DB::selectOne('SELECT OBJECT_ID(?) AS o', [$def['sp']])->o, "$pagina: no existe {$def['sp']}");
        }
    }

    public function test_mismo_total_que_el_sistema_actual_en_todos(): void
    {
        foreach (config('catalogos') as $pagina => $def) {
            $legado = (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC '.$def['sp']." @TipoAccion='Count', @filtro=''"))[0];
            //SP_GEN_BANCO 'Count' FILTRA POR IDE_BANCO <> '2' (ERROR DEL SISTEMA ACTUAL: DEBIA SER EST_BANCO) Y
            //DEJA FUERA DEL TOTAL AL BANCO 2 AUNQUE SU GRILLA SI LO LISTA; SE SUMA SI ESTA ACTIVO
            if ($pagina === 'GEN_BANCO') {
                $legado += DB::table('dbo.GEN_BANCO')->where('IDE_BANCO', 2)->where('EST_BANCO', '<>', '2')->count();
            }
            Livewire::test(CatalogoTabla::class, ['pagina' => $pagina])
                ->assertViewHas('filas', fn ($f) => $f->total() === $legado);
        }
    }

    public function test_crear_editar_y_eliminar(): void
    {
        $usuario = $this->usuario();
        if (! $usuario) {
            $this->markTestSkipped('No hay usuarios que puedan grabar.');
        }
        $this->actingAs($usuario);
        $marca = 'PRUEBA LARAVEL '.substr(uniqid(), -6);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_TIPO_RIESGO'])
            ->call('nuevo')->assertSet('datos.EST_TIPO_RIESGO', '1')
            ->set('datos.DES_TIPO_RIESGO', $marca)
            ->call('guardar')->assertHasNoErrors()->assertDispatched('catalogo-guardado');
        $fila = DB::table('dbo.GEN_TIPO_RIESGO')->where('DES_TIPO_RIESGO', $marca)->first();
        $this->assertNotNull($fila);
        $this->assertSame('1', trim($fila->EST_TIPO_RIESGO));

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_TIPO_RIESGO'])
            ->call('editar', (int) $fila->IDE_TIPO_RIESGO)
            ->set('datos.EST_TIPO_RIESGO', '3')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame('3', trim(DB::table('dbo.GEN_TIPO_RIESGO')->where('IDE_TIPO_RIESGO', $fila->IDE_TIPO_RIESGO)->value('EST_TIPO_RIESGO')));

        //VALIDACION: OBLIGATORIO, LARGO MAXIMO Y ESTADO DE LA LISTA ("ELIMINADO" NO SE PUEDE ELEGIR)
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_TIPO_RIESGO'])
            ->call('nuevo')->set('datos.DES_TIPO_RIESGO', str_repeat('X', 51))->set('datos.EST_TIPO_RIESGO', '2')
            ->call('guardar')->assertHasErrors(['datos.DES_TIPO_RIESGO', 'datos.EST_TIPO_RIESGO']);

        Livewire::test(CatalogoTabla::class, ['pagina' => 'GEN_TIPO_RIESGO'])
            ->call('eliminar', (int) $fila->IDE_TIPO_RIESGO)->assertDispatched('aviso');
        $this->assertSame('2', trim(DB::table('dbo.GEN_TIPO_RIESGO')->where('IDE_TIPO_RIESGO', $fila->IDE_TIPO_RIESGO)->value('EST_TIPO_RIESGO')));
    }

    public function test_solo_lectura_se_conserva(): void
    {
        $usuario = $this->usuario();
        $fila = DB::table('dbo.GEN_BANCO')->where('EST_BANCO', '<>', '2')->whereNotNull('COD_RUC')->first();
        if (! $usuario || ! $fila) {
            $this->markTestSkipped('Sin datos.');
        }
        $this->actingAs($usuario);
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_BANCO'])
            ->call('editar', (int) $fila->IDE_BANCO)
            ->set('datos.COD_RUC', '99999999999')
            ->set('datos.DES_COMENTARIO', 'COMENTARIO DE PRUEBA')
            ->call('guardar')->assertHasNoErrors();
        $despues = DB::table('dbo.GEN_BANCO')->where('IDE_BANCO', $fila->IDE_BANCO)->first();
        $this->assertSame(trim($fila->COD_RUC), trim($despues->COD_RUC));
        $this->assertSame('COMENTARIO DE PRUEBA', $despues->DES_COMENTARIO);

        //SIN "NUEVO" NI "ELIMINAR" EN BANCOS (COMO EL SISTEMA ACTUAL)
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_BANCO'])->call('nuevo')->assertSet('abierto', false);
    }

    public function test_perfil_solo_consulta_no_graba(): void
    {
        $usuario = $this->usuario(true);
        if (! $usuario) {
            $this->markTestSkipped('No hay usuarios con perfil de solo consulta.');
        }
        $this->actingAs($usuario);
        $fila = DB::table('dbo.GEN_CARGO')->where('EST_CARGO', '<>', '2')->first();
        Livewire::test(CatalogoTabla::class, ['pagina' => 'GEN_CARGO'])->assertDontSee('fa-trash-can', false);
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_CARGO'])
            ->call('nuevo')->assertSet('abierto', false)
            ->call('editar', (int) $fila->IDE_CARGO)->assertSet('abierto', true)
            ->call('guardar')->assertHasErrors(['general']);
    }

    public function test_menu_lleva_a_los_catalogos(): void
    {
        $u = $this->usuario();
        $perfil = app(Seguridad::class)->perfil((int) $u->id);
        $urls = collect(app(Seguridad::class)->menu($perfil['perfil'], $perfil['modulo']))->flatMap(fn ($o) => array_column($o['hijos'], 'url'))->implode(' ');
        $this->assertStringContainsString('/catalogos/GEN_TIPO_RIESGO', $urls);
    }
}
