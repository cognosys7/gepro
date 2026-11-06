<?php

namespace Tests\Feature;

use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectoContratosTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Calidad de entregables del contrato y su contenido contra BDGEPRO. Lo que graba corre dentro de una
 * transaccion que se revierte (DatabaseTransactions).
 */
class CalidadTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    private function totalLegado(string $sp, string $filtro): int
    {
        return (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC '.$sp." @TipoAccion = 'Count', @filtro = ?", [$filtro]))[0];
    }

    /** Una revision vigente cuyo entregable tiene sub-entregables */
    private function revision(): object
    {
        return DB::table('dbo.CONT_CALIDAD as C')->where('C.EST_ENTREGABLE', '<>', '2')
            ->whereExists(fn ($q) => $q->from('dbo.GEN_ENTREGABLE as G')->whereColumn('G.GEN_IDE_ENTREGABLE', 'C.IDE_ENTREGABLE')->where('G.NUM_NIVEL', 2)->where('G.EST_ENTREGABLE', '<>', '2'))
            ->select('C.*')->first();
    }

    private function entregable(int $saltar = 0): object
    {
        return DB::table('dbo.GEN_ENTREGABLE')->where('NUM_NIVEL', 1)->where('EST_ENTREGABLE', '<>', '2')->orderBy('IDE_ENTREGABLE')->skip($saltar)->first();
    }

    private function recurso(): string
    {
        return trim((string) DB::table('dbo.GEN_RECURSO')->where('TIP_RECURSO', '3')->where('EST_RECURSO', '<>', '2')->value('IDE_RECURSO'));
    }

    public function test_abre_en_laravel_desde_los_contratos(): void
    {
        $tabla = new ProyectoContratosTabla();

        $this->assertSame(route('catalogos.index', ['pagina' => 'CONT_CALIDAD', 'de' => 7]),
            $tabla->urlAccion('entregables', (object) ['ID' => 7, 'IDE_PROYECTO' => 1, 'IDE_INTERVENCION' => 1, 'IDE_PROCESO_ITEM' => 0]));
    }

    public function test_las_dos_pantallas_abren_por_su_ruta(): void
    {
        $revision = $this->revision();
        $this->actingAs($this->usuarioGepro());

        $this->get(route('catalogos.index', ['pagina' => 'CONT_CALIDAD', 'de' => (int) $revision->IDE_CONTRATO]))
            ->assertOk()->assertSee('Calidad de entregables')->assertSee(trim((string) $revision->COD_INFORME));
        $this->get(route('catalogos.index', ['pagina' => 'CONT_CAL_CONTENIDO', 'de' => (int) $revision->IDE_CONT_CALIDAD]))
            ->assertOk()->assertSee('Contenido observado del entregable');
    }

    public function test_mismos_totales_que_el_sistema_actual(): void
    {
        $this->actingAs($this->usuarioGepro());
        foreach (DB::table('dbo.CONT_CALIDAD')->distinct()->pluck('IDE_CONTRATO') as $contrato) {
            Livewire::test(CatalogoTabla::class, ['pagina' => 'CONT_CALIDAD', 'de' => (int) $contrato])
                ->assertViewHas('filas', fn ($f) => $f->total() === $this->totalLegado('dbo.SP_CONT_CALIDAD', ' AND T.IDE_CONTRATO='.(int) $contrato));
        }
        foreach (DB::table('dbo.CONT_CAL_CONTENIDO')->distinct()->pluck('IDE_CONT_CALIDAD') as $calidad) {
            if (! DB::table('dbo.CONT_CALIDAD')->where('IDE_CONT_CALIDAD', $calidad)->exists()) {
                continue;
            }
            Livewire::test(CatalogoTabla::class, ['pagina' => 'CONT_CAL_CONTENIDO', 'de' => (int) $calidad])
                ->assertViewHas('filas', fn ($f) => $f->total() === $this->totalLegado('dbo.SP_CONT_CAL_CONTENIDO', ' AND T.IDE_CONT_CALIDAD='.(int) $calidad));
        }
    }

    public function test_registra_edita_y_elimina_una_revision(): void
    {
        $revision = $this->revision();
        $contrato = (int) $revision->IDE_CONTRATO;
        $entregable = $this->entregable();
        $this->actingAs($this->usuarioGepro());

        $formulario = Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CALIDAD', 'de' => $contrato])->call('nuevo')->assertSet('datos.EST_ENTREGABLE', '');
        $formulario->call('elegir', 'IDE_ENTREGABLE', trim((string) $entregable->IDE_ENTREGABLE))
            ->set('datos.NUM_REVISION', '2')->set('datos.COD_INFORME', 'INF-PRUEBA')->set('datos.FEC_INFORME', '2026-03-05')
            ->set('datos.IDE_REC_REVISADO', $this->recurso())->set('datos.EST_ENTREGABLE', '4')->call('guardar')->assertHasNoErrors()->assertSet('abierto', false);
        $fila = DB::table('dbo.CONT_CALIDAD')->where('IDE_CONTRATO', $contrato)->where('COD_INFORME', 'INF-PRUEBA')->first();
        $this->assertNotNull($fila);
        $this->assertSame(trim((string) $entregable->DES_ENTREGABLE), trim((string) $fila->DES_ENTREGABLE));
        $this->assertNull($fila->IDE_REC_VALIDADO);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CALIDAD', 'de' => $contrato])->call('editar', (string) (int) $fila->IDE_CONT_CALIDAD)
            ->set('datos.CAN_OBSERVACIONES', '3')->call('guardar')->assertHasNoErrors();
        $this->assertEquals(3, (int) DB::table('dbo.CONT_CALIDAD')->where('IDE_CONT_CALIDAD', $fila->IDE_CONT_CALIDAD)->value('CAN_OBSERVACIONES'));

        Livewire::test(CatalogoTabla::class, ['pagina' => 'CONT_CALIDAD', 'de' => $contrato])->call('eliminar', (string) (int) $fila->IDE_CONT_CALIDAD);
        $this->assertSame('2', trim((string) DB::table('dbo.CONT_CALIDAD')->where('IDE_CONT_CALIDAD', $fila->IDE_CONT_CALIDAD)->value('EST_ENTREGABLE')));
    }

    public function test_el_texto_guardado_se_conserva_y_solo_cambia_con_otro_entregable(): void
    {
        $revision = DB::table('dbo.CONT_CALIDAD as C')->join('dbo.GEN_ENTREGABLE as G', 'G.IDE_ENTREGABLE', '=', 'C.IDE_ENTREGABLE')
            ->where('C.EST_ENTREGABLE', '<>', '2')->where('C.EST_ENTREGABLE', '<>', '5')->whereColumn('C.DES_ENTREGABLE', '<>', 'G.DES_ENTREGABLE')->select('C.*')->first();
        if (! $revision) {
            $this->markTestSkipped('No hay revisiones con un texto distinto al del catalogo.');
        }
        $id = (int) $revision->IDE_CONT_CALIDAD;
        $de = (int) $revision->IDE_CONTRATO;
        $texto = trim((string) $revision->DES_ENTREGABLE);
        $this->actingAs($this->usuarioGepro());

        //LO QUE SE MUESTRA ES EL TEXTO GUARDADO; GRABAR SIN CAMBIAR EL ENTREGABLE NO LO TOCA
        $formulario = Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CALIDAD', 'de' => $de])->call('editar', (string) $id);
        $this->assertSame($texto, $formulario->instance()->etiquetaBuscador('IDE_ENTREGABLE'));
        $formulario->set('datos.COD_INFORME', 'INF-EDITADO')->call('guardar')->assertHasNoErrors();
        $this->assertSame($texto, trim((string) DB::table('dbo.CONT_CALIDAD')->where('IDE_CONT_CALIDAD', $id)->value('DES_ENTREGABLE')));

        //OTRO ENTREGABLE TRAE SU TEXTO DEL CATALOGO, AUNQUE EL NAVEGADOR ENVIE OTRO
        $otro = (int) $revision->IDE_ENTREGABLE === (int) $this->entregable()->IDE_ENTREGABLE ? $this->entregable(1) : $this->entregable();
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CALIDAD', 'de' => $de])->call('editar', (string) $id)
            ->call('quitar', 'IDE_ENTREGABLE')->call('elegir', 'IDE_ENTREGABLE', trim((string) $otro->IDE_ENTREGABLE))
            ->set('datos.DES_ENTREGABLE', 'TEXTO DEL NAVEGADOR')->call('guardar')->assertHasNoErrors();
        $this->assertSame(trim((string) $otro->DES_ENTREGABLE), trim((string) DB::table('dbo.CONT_CALIDAD')->where('IDE_CONT_CALIDAD', $id)->value('DES_ENTREGABLE')));
    }

    public function test_valida_obligatorios_y_la_capacidad_de_los_numeros(): void
    {
        $contrato = (int) $this->revision()->IDE_CONTRATO;
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CALIDAD', 'de' => $contrato])->call('nuevo')->call('guardar')
            ->assertHasErrors(['datos.IDE_ENTREGABLE', 'datos.NUM_REVISION', 'datos.COD_INFORME', 'datos.FEC_INFORME', 'datos.IDE_REC_REVISADO', 'datos.EST_ENTREGABLE']);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CALIDAD', 'de' => $contrato])->call('nuevo')
            ->set('datos.NUM_REVISION', '1000')->set('datos.CAN_OBSERVACIONES', '1.5')->set('datos.EST_ENTREGABLE', '2')->call('guardar')
            ->assertHasErrors(['datos.NUM_REVISION', 'datos.CAN_OBSERVACIONES', 'datos.EST_ENTREGABLE']);
    }

    public function test_el_nombre_del_responsable_se_ve_y_se_busca(): void
    {
        $revision = DB::table('dbo.CONT_CALIDAD')->where('EST_ENTREGABLE', '<>', '2')->whereNotNull('IDE_REC_REVISADO')->first();
        $nombre = trim((string) DB::table('dbo.GEN_RECURSO')->where('IDE_RECURSO', $revision->IDE_REC_REVISADO)->value('DES_RECURSO'));
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoTabla::class, ['pagina' => 'CONT_CALIDAD', 'de' => (int) $revision->IDE_CONTRATO])->set('buscar', $nombre)
            ->assertViewHas('filas', fn ($f) => $f->total() > 0)->assertSee($nombre);
    }

    public function test_el_contenido_ofrece_los_sub_entregables_y_graba(): void
    {
        $revision = $this->revision();
        $de = (int) $revision->IDE_CONT_CALIDAD;
        $hijo = DB::table('dbo.GEN_ENTREGABLE')->where('GEN_IDE_ENTREGABLE', $revision->IDE_ENTREGABLE)->where('NUM_NIVEL', 2)->where('EST_ENTREGABLE', '<>', '2')->first();
        $ajeno = DB::table('dbo.GEN_ENTREGABLE')->where('NUM_NIVEL', 2)->where('EST_ENTREGABLE', '<>', '2')->where('GEN_IDE_ENTREGABLE', '<>', $revision->IDE_ENTREGABLE)->value('IDE_ENTREGABLE');
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CAL_CONTENIDO', 'de' => $de])->call('nuevo')
            ->set('datos.IDE_ENTREGABLE', trim((string) $ajeno))->set('datos.DES_OBSERV_CONTENIDO', 'NO CORRESPONDE')->call('guardar')->assertHasErrors('datos.IDE_ENTREGABLE');

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CAL_CONTENIDO', 'de' => $de])->call('nuevo')
            ->set('datos.IDE_ENTREGABLE', trim((string) $hijo->IDE_ENTREGABLE))->set('datos.DES_OBSERV_CONTENIDO', 'OBSERVACION DE PRUEBA')->call('guardar')->assertHasNoErrors();
        $fila = DB::table('dbo.CONT_CAL_CONTENIDO')->where('IDE_CONT_CALIDAD', $de)->where('DES_OBSERV_CONTENIDO', 'OBSERVACION DE PRUEBA')->first();
        $this->assertNotNull($fila);

        Livewire::test(CatalogoTabla::class, ['pagina' => 'CONT_CAL_CONTENIDO', 'de' => $de])->call('eliminar', (string) (int) $fila->IDE_CAL_CONTENIDO);
        $this->assertSame('2', trim((string) DB::table('dbo.CONT_CAL_CONTENIDO')->where('IDE_CAL_CONTENIDO', $fila->IDE_CAL_CONTENIDO)->value('EST_CAL_CONTENIDO')));
    }

    public function test_abre_sus_adjuntos_en_laravel(): void
    {
        $tabla = new CatalogoTabla();
        $this->assertSame(route('archivos.index', ['tabla' => 'CONT_CALIDAD', 'registro' => '9']), $tabla->urlAccion(['archivos' => 'CONT_CALIDAD'], (object) ['ID' => 9]));
    }

    public function test_el_perfil_de_consulta_no_graba(): void
    {
        $usuario = $this->usuarioGepro(true);
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario de solo consulta.');
        }
        $this->actingAs($usuario);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_CALIDAD', 'de' => (int) $this->revision()->IDE_CONTRATO])->call('nuevo')->assertSet('abierto', false);
    }
}
