<?php

namespace Tests\Feature;

use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectosTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Comunicaciones del proyecto y sus interesados contra BDGEPRO. Lo que graba corre dentro de una
 * transaccion que se revierte (DatabaseTransactions).
 */
class ComunicacionesTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    private function totalLegado(string $sp, string $filtro): int
    {
        return (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC '.$sp." @TipoAccion = 'Count', @filtro = ?", [$filtro]))[0];
    }

    public function test_abre_en_laravel_desde_los_proyectos(): void
    {
        $tabla = new ProyectosTabla();
        $tabla->opcion = 510;

        $this->assertSame(route('catalogos.index', ['pagina' => 'PROY_COMUNICACION', 'de' => 5]), $tabla->urlAccion('comunicacion', (object) ['IDE_PROYECTO' => 5]));
    }

    public function test_mismos_totales_que_el_sistema_actual(): void
    {
        $this->actingAs($this->usuarioGepro());
        foreach (DB::table('dbo.PROY_COMUNICACION')->whereNotNull('IDE_PROYECTO')->distinct()->pluck('IDE_PROYECTO') as $proyecto) {
            $total = $this->totalLegado('dbo.SP_PROY_COMUNICACION', ' AND T.IDE_PROYECTO='.(int) $proyecto);
            Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_COMUNICACION', 'de' => (int) $proyecto])
                ->assertViewHas('filas', fn ($f) => $f->total() === $total);
        }
        foreach (DB::table('dbo.PROY_COM_INTERESADOS')->distinct()->pluck('IDE_COMUNICACION') as $comunicacion) {
            if (! DB::table('dbo.PROY_COMUNICACION')->where('IDE_COMUNICACION', $comunicacion)->where('EST_COMUNICACION', '<>', '2')->exists()) {
                continue;
            }
            $total = $this->totalLegado('dbo.SP_PROY_COM_INTERESADOS', ' AND T.IDE_COMUNICACION='.(int) $comunicacion);
            Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_COM_INTERESADOS', 'de' => (int) $comunicacion])
                ->assertViewHas('filas', fn ($f) => $f->total() === $total);
        }
    }

    public function test_registra_edita_y_elimina_una_comunicacion(): void
    {
        $proyecto = (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->min('IDE_PROYECTO');
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_COMUNICACION', 'de' => $proyecto])->call('nuevo')
            ->set('datos.DES_COMUNICACION', 'COMUNICACION DE PRUEBA')->set('datos.FEC_INICIO', '2026-01-10')
            ->set('datos.TIP_FRECUENCIA', '2')->call('guardar')->assertHasNoErrors()->assertSet('abierto', false);
        $fila = DB::table('dbo.PROY_COMUNICACION')->where('IDE_PROYECTO', $proyecto)->where('DES_COMUNICACION', 'COMUNICACION DE PRUEBA')->first();
        $this->assertNotNull($fila);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_COMUNICACION', 'de' => $proyecto])->call('editar', (string) (int) $fila->IDE_COMUNICACION)
            ->set('datos.DES_GLOSARIO_TERMINOS', 'GLOSARIO')->call('guardar')->assertHasNoErrors();
        $this->assertSame('GLOSARIO', DB::table('dbo.PROY_COMUNICACION')->where('IDE_COMUNICACION', $fila->IDE_COMUNICACION)->value('DES_GLOSARIO_TERMINOS'));

        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_COMUNICACION', 'de' => $proyecto])->call('eliminar', (string) (int) $fila->IDE_COMUNICACION);
        $this->assertSame('2', trim((string) DB::table('dbo.PROY_COMUNICACION')->where('IDE_COMUNICACION', $fila->IDE_COMUNICACION)->value('EST_COMUNICACION')));
    }

    public function test_exige_lo_obligatorio(): void
    {
        $proyecto = (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->min('IDE_PROYECTO');
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_COMUNICACION', 'de' => $proyecto])->call('nuevo')->call('guardar')
            ->assertHasErrors(['datos.DES_COMUNICACION', 'datos.FEC_INICIO', 'datos.TIP_FRECUENCIA']);
    }

    public function test_el_interesado_se_elige_entre_los_del_proyecto_y_conserva_el_guardado(): void
    {
        $fila = DB::table('dbo.PROY_COM_INTERESADOS')->where('EST_PROY_COM_INTERESADO', '<>', '2')->first();
        if (! $fila || ! DB::table('dbo.PROY_COMUNICACION')->where('IDE_COMUNICACION', $fila->IDE_COMUNICACION)->where('EST_COMUNICACION', '<>', '2')->exists()) {
            $this->markTestSkipped('No hay interesados de comunicaciones vigentes.');
        }
        $this->actingAs($this->usuarioGepro());

        $formulario = Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_COM_INTERESADOS', 'de' => (int) $fila->IDE_COMUNICACION])
            ->call('editar', (string) (int) $fila->IDE_PROY_COM_INTERESADO)->assertSet('abierto', true);

        //EL VALOR GUARDADO SE ACEPTA AUNQUE HOY QUEDE FUERA DE LA LISTA
        $formulario->set('datos.DES_COMENTARIO', 'COMENTARIO DE PRUEBA')->call('guardar')->assertHasNoErrors();
        $this->assertSame('COMENTARIO DE PRUEBA', DB::table('dbo.PROY_COM_INTERESADOS')->where('IDE_PROY_COM_INTERESADO', $fila->IDE_PROY_COM_INTERESADO)->value('DES_COMENTARIO'));
    }

    public function test_rechaza_un_interesado_de_otro_proyecto(): void
    {
        $comunicacion = DB::table('dbo.PROY_COMUNICACION')->where('EST_COMUNICACION', '<>', '2')->first(['IDE_COMUNICACION', 'IDE_PROYECTO']);
        $unico = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $comunicacion->IDE_PROYECTO)->value('COD_UNICO');
        $ajeno = DB::table('dbo.CONT_INTERESADOS as I')
            ->join('dbo.PROYECTO_ACTIVIDAD as A', 'A.IDE_PROYECTO_ACTIVIDAD', '=', 'I.IDE_CONTRATO')
            ->join('dbo.PROYECTO as P', 'P.IDE_PROYECTO', '=', 'A.IDE_PROYECTO')
            ->where('I.EST_CONT_INTERESADO', '<>', '2')->where('P.COD_UNICO', '<>', (string) $unico)->value('I.IDE_CONT_INTERESADO');
        if (! $ajeno) {
            $this->markTestSkipped('No hay interesados de otro proyecto.');
        }
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_COM_INTERESADOS', 'de' => (int) $comunicacion->IDE_COMUNICACION])->call('nuevo')
            ->set('datos.IDE_CONT_INTERESADO', (string) (int) $ajeno)->set('datos.TIP_RESPONSABILIDAD', '1')
            ->call('guardar')->assertHasErrors('datos.IDE_CONT_INTERESADO');
    }

    public function test_el_perfil_de_consulta_no_graba(): void
    {
        $usuario = $this->usuarioGepro(true);
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario de solo consulta.');
        }
        $proyecto = (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->min('IDE_PROYECTO');
        $this->actingAs($usuario);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_COMUNICACION', 'de' => $proyecto])->call('nuevo')->assertSet('abierto', false);
    }
}
