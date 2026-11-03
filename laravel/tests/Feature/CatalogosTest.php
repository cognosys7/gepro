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
            $columnasDef = array_keys(array_filter($def['campos'], fn ($c) => empty($c[2]['expresion'])));
            foreach (array_unique(array_merge([$def['id'], $def['estado']], $def['parametros'], $columnasDef)) as $c) {
                $this->assertContains($c, $columnas, "$pagina: no existe la columna $c");
            }
            $this->assertNotNull(DB::selectOne('SELECT OBJECT_ID(?) AS o', [$def['sp']])->o, "$pagina: no existe {$def['sp']}");
        }
    }

    public function test_mismo_total_que_el_sistema_actual_en_todos(): void
    {
        //CATALOGOS JERARQUICOS: SE COMPARA LA RAIZ, CON EL FILTRO QUE ARMA SU LN (CADA SP USA SU ALIAS)
        $filtroRaiz = [
            'GEN_TABLAS' => ' AND P.COD_TABLA=0 ',
            'GEN_ENTREGABLE' => ' AND T.NUM_NIVEL=1 ',
            'GEN_CONCEPTO_SOCIAL' => ' AND T.NUM_NIVEL=11 ',
            'GEN_INTERVENCION' => ' AND DET.NUM_NIVEL=1 ',
        ];
        foreach (config('catalogos') as $pagina => $def) {
            //LAS PANTALLAS QUE DEPENDEN DE OTRO REGISTRO SE PRUEBAN EN CadenaContratoTest
            if (! empty($def['de'])) {
                continue;
            }
            $legado = (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC '.$def['sp']." @TipoAccion='Count', @filtro=?", [$filtroRaiz[$pagina] ?? '']))[0];
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

    public function test_jerarquia_tablas_maestras(): void
    {
        $this->actingAs($this->usuario());
        //LOS VALORES DE LA TABLA 99 (ESTADOS): MISMO TOTAL QUE EL SP CON EL FILTRO DE SU LN
        $tabla = DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', '0')->where('COD_ITEM', '99')->where('EST_ITEM', '<>', '2')->first();
        $legado = (int) array_values((array) DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_GEN_TABLAS @TipoAccion='Count', @filtro=' AND P.COD_TABLA=99 '"))[0];
        Livewire::test(CatalogoTabla::class, ['pagina' => 'GEN_TABLAS', 'padre' => (string) $tabla->IDE_TABLA])
            ->assertSet('nivel', 2)
            ->assertViewHas('filas', fn ($f) => $f->total() === $legado)
            ->assertDontSee('Ver valores');

        //REGISTRAR UN VALOR DENTRO DE LA TABLA: SE GRABA CON SU COD_TABLA AUNQUE EL NAVEGADOR ENVIE OTRO
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_TABLAS', 'padre' => (string) $tabla->IDE_TABLA])
            ->call('nuevo')
            ->set('datos.COD_ITEM', '77')->set('datos.DES_ITEM', 'PRUEBA LARAVEL')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame('99', trim(DB::table('dbo.GEN_TABLAS')->where('DES_ITEM', 'PRUEBA LARAVEL')->value('COD_TABLA')));

        //LA PAGINA DEL HIJO MUESTRA EL CAMINO; NO SE PUEDE BAJAR UN NIVEL MAS
        $this->get('/catalogos/GEN_TABLAS?padre='.$tabla->IDE_TABLA)->assertOk()->assertSee(trim($tabla->DES_ITEM))->assertSee('Volver');
        $valor = DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', '99')->first();
        $this->get('/catalogos/GEN_TABLAS?padre='.$valor->IDE_TABLA)->assertNotFound();
    }

    public function test_jerarquia_conceptos_sube_el_nivel(): void
    {
        $this->actingAs($this->usuario());
        $rubro = DB::table('dbo.GEN_CONCEPTO_SOCIAL')->where('NUM_NIVEL', 11)->where('EST_CONCEPTO', '<>', '2')->first();
        if (! $rubro) {
            $this->markTestSkipped('No hay rubros.');
        }
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_CONCEPTO_SOCIAL', 'padre' => (string) $rubro->IDE_CONCEPTO])
            ->call('nuevo')
            ->set('datos.DES_CONCEPTO', 'PRUEBA LARAVEL CONCEPTO')
            ->set('datos.TIP_UNIDAD_MEDIDA', (string) DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', '79')->where('EST_ITEM', 1)->value('COD_ITEM'))
            ->call('guardar')->assertHasNoErrors();
        $nuevo = DB::table('dbo.GEN_CONCEPTO_SOCIAL')->where('DES_CONCEPTO', 'PRUEBA LARAVEL CONCEPTO')->first();
        $this->assertSame(12, (int) $nuevo->NUM_NIVEL);
        $this->assertSame((int) $rubro->IDE_CONCEPTO, (int) $nuevo->IDE_RUBRO);
    }

    public function test_ubigeo_con_clave_de_texto(): void
    {
        $this->actingAs($this->usuario());
        //UN DISTRITO CUYO CODIGO EMPIEZA CON CERO: @pCodigo DEL SP ES ENTERO Y SQL SERVER LO COMPARA CON EL TEXTO.
        //(LAS REGIONES Y EL CODIGO '00' NO SE PUEDEN EDITAR NI AQUI NI EN EL SISTEMA ACTUAL: SP_GEN_UBIGEO
        //CALCULA COD_UBIGEO_SUP QUITANDO DOS DIGITOS Y EL RESULTADO NO EXISTE -> CLAVE FORANEA)
        $fila = DB::table('dbo.GEN_UBIGEO')->where('EST_UBIGEO', '<>', '2')->where('NUM_NIVEL', 3)->where('COD_UBIGEO', 'like', '0%')->orderBy('COD_UBIGEO')->first()
            ?? DB::table('dbo.GEN_UBIGEO')->where('EST_UBIGEO', '<>', '2')->where('NUM_NIVEL', 3)->first();
        $codigo = trim($fila->COD_UBIGEO);
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_UBIGEO'])
            ->call('editar', $codigo)->assertSet('abierto', true)
            ->set('datos.COD_UBIGEO', '999999')
            ->set('datos.GEO_LATITUD', '-11.5')
            ->set('datos.GEO_LONGITUD', '-77.1')
            ->call('guardar')->assertHasNoErrors();
        $despues = DB::table('dbo.GEN_UBIGEO')->where('COD_UBIGEO', $fila->COD_UBIGEO)->first();
        //EL CODIGO NO CAMBIA (SOLO LECTURA AL EDITAR) Y LOS DEMAS DATOS SI
        $this->assertNotNull($despues);
        $this->assertSame('-11.5', trim($despues->GEO_LATITUD));

        //CODIGO REPETIDO AL REGISTRAR
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_UBIGEO'])
            ->call('nuevo')
            ->set('datos.COD_UBIGEO', $codigo)->set('datos.NUM_NIVEL', '3')->set('datos.DES_DEPARTAMENTO', 'X')
            ->set('datos.GEO_LONGITUD', '1')->set('datos.GEO_LATITUD', '1')
            ->call('guardar')->assertHasErrors(['datos.COD_UBIGEO']);
    }

    public function test_invierte_solo_edita_denominacion_y_estado(): void
    {
        $this->actingAs($this->usuario());
        $fila = DB::table('dbo.GEN_PIP')->where('EST_PIP', '<>', '2')->whereNotNull('COD_PROYECTO')->whereNotNull('IMP_MONTO_VIABLE')->first();
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_PIP'])
            ->call('nuevo')->assertSet('abierto', false)
            ->call('editar', (string) (int) $fila->IDE_PIP)
            ->set('datos.IMP_MONTO_VIABLE', '1')
            ->set('datos.DES_PIP', 'PRUEBA LARAVEL PIP')
            ->call('guardar')->assertHasNoErrors();
        $despues = DB::table('dbo.GEN_PIP')->where('IDE_PIP', $fila->IDE_PIP)->first();
        $this->assertSame('PRUEBA LARAVEL PIP', $despues->DES_PIP);
        $this->assertEquals((float) $fila->IMP_MONTO_VIABLE, (float) $despues->IMP_MONTO_VIABLE);
        $this->assertSame(substr((string) $fila->FEC_REGISTRO, 0, 10), substr((string) $despues->FEC_REGISTRO, 0, 10));
        $this->assertSame(trim((string) $fila->COD_UNICO), trim((string) $despues->COD_UNICO));
    }

    public function test_menu_lleva_a_los_catalogos(): void
    {
        $u = $this->usuario();
        $perfil = app(Seguridad::class)->perfil((int) $u->id);
        $urls = collect(app(Seguridad::class)->menu($perfil['perfil'], $perfil['modulo']))->flatMap(fn ($o) => array_column($o['hijos'], 'url'))->implode(' ');
        $this->assertStringContainsString('/catalogos/GEN_TIPO_RIESGO', $urls);
    }
}
