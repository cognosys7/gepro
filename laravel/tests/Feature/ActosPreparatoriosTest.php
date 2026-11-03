<?php

namespace Tests\Feature;

use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * 13. Actos preparatorios: proceso -> items y cronograma, contra BDGEPRO.
 * Lo que graba corre dentro de una transaccion que se revierte (DatabaseTransactions).
 */
class ActosPreparatoriosTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    /** Codigo de proceso que no existe (la clave la escribe el usuario) */
    private function codigoLibre(): string
    {
        return (string) ((int) DB::table('dbo.PROCESO')->max('IDE_CONVOCATORIA') + 1);
    }

    public function test_items_y_cronograma_con_los_totales_del_sistema_actual(): void
    {
        $proceso = DB::table('dbo.PROCESO')->where('EST_PROCESO', '<>', '2')
            ->whereExists(fn ($q) => $q->from('dbo.PROC_ITEM as I')->whereColumn('I.IDE_CONVOCATORIA', 'PROCESO.IDE_CONVOCATORIA'))
            ->value('IDE_CONVOCATORIA');
        if (! $proceso) {
            $this->markTestSkipped('No hay procesos con items.');
        }
        $proceso = (string) (int) $proceso;
        //SU SelGrd FILTRA EL ESTADO ELIMINADO; SU Count NO (POR ESO SE COMPARA CON LA TABLA)
        $items = DB::table('dbo.PROC_ITEM')->where('IDE_CONVOCATORIA', $proceso)->where('EST_PROCESO_ITEM', '<>', '2')->count();
        $cronograma = DB::table('dbo.PROC_CRONOGRAMA')->where('IDE_CONVOCATORIA', $proceso)->where('EST_PROC_CRONOGRAMA', '<>', '2')->count();
        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROC_ITEM', 'de' => $proceso])->assertViewHas('filas', fn ($f) => $f->total() === $items);
        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROC_CRONOGRAMA', 'de' => $proceso])->assertViewHas('filas', fn ($f) => $f->total() === $cronograma);
    }

    public function test_registrar_proceso_con_su_codigo_item_y_cronograma(): void
    {
        $this->actingAs($this->usuarioGepro());
        $codigo = $this->codigoLibre();
        $entidad = DB::table('dbo.GEN_ENTIDAD')->where('EST_ENTIDAD', '<>', '2')->value('IDE_ENTIDAD');
        $tipo = DB::table('dbo.PROC_TIPO')->where('EST_PROC_TIPO', '1')->value('IDE_TIPO_PROC');

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROCESO'])
            ->call('nuevo')
            ->set('datos.IDE_CONVOCATORIA', $codigo)
            ->set('datos.IDE_ENTIDAD_EJECUTORA', (string) $entidad)
            ->set('datos.IDE_TIPO_PROC', (string) $tipo)
            ->set('datos.TIP_OBJETO', '3')
            ->set('datos.DES_OBJETO', 'PRUEBA LARAVEL PROCESO')
            ->set('datos.IMP_VAL_REFERENCIAL', '150000')
            ->set('datos.NUM_PROC_ESPECIFICO', 'LP-1-2026')
            ->set('datos.NUM_ANO_EJE', '2026')
            ->set('datos.COD_PAC', '12')
            ->set('datos.DES_DEPTO_EJECUTORA', 'LIMA')
            ->set('datos.DES_PROV_EJECUTORA', 'HUARAL')
            ->set('datos.DES_DIST_EJECUTORA', 'CHANCAY')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame('PRUEBA LARAVEL PROCESO', DB::table('dbo.PROCESO')->where('IDE_CONVOCATORIA', $codigo)->value('DES_OBJETO'));

        //EL MISMO CODIGO NO SE PUEDE VOLVER A REGISTRAR
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROCESO'])
            ->call('nuevo')->set('datos.IDE_CONVOCATORIA', $codigo)->call('guardar')->assertHasErrors('datos.IDE_CONVOCATORIA');

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROC_CRONOGRAMA', 'de' => $codigo])
            ->call('nuevo')
            ->set('datos.IDE_ORDEN', '1')
            ->set('datos.DES_ACTIVIDAD', 'CONVOCATORIA')
            ->set('datos.FEC_PUBLICACION', '2026-11-03')
            ->set('datos.FEC_INICIO', '2026-11-04')
            ->set('datos.FEC_TERMINO', '2026-11-10')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame('2026-11-10', substr((string) DB::table('dbo.PROC_CRONOGRAMA')->where('IDE_CONVOCATORIA', $codigo)->value('FEC_TERMINO'), 0, 10));

        //EL ITEM: SU SP TAMBIEN CREA EL PROYECTO DEL ITEM (SP_PROYECTO_ACTIVIDAD)
        $proyectos = DB::table('dbo.PROYECTO_ACTIVIDAD')->count();
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROC_ITEM', 'de' => $codigo])
            ->call('nuevo')
            ->assertSet('datos.EST_PROCESO_ITEM', 'EN PROCESO')
            ->set('datos.COD_ITEM', '1')
            ->set('datos.DES_ITEM', 'PRUEBA LARAVEL ITEM')
            ->set('datos.IMP_VAL_REFERENCIAL_ITEM', '150000')
            ->set('datos.IDE_MODO_EJECUCION', (string) DB::table('dbo.GEN_MODO_EJECUCION')->where('EST_MODO_EJECUCION', '1')->value('IDE_MODO_EJECUCION'))
            ->set('datos.IDE_UNIDAD_MEDIDA', (string) DB::table('dbo.PROC_UNIDAD_MEDIDA')->where('EST_UNIDAD_MEDIDA', '1')->value('IDE_UNIDAD_MEDIDA'))
            ->set('datos.CNT_ITEM', '1')
            ->set('datos.DES_DEPTO_ITEM', 'LIMA')
            ->set('datos.DES_PROV_ITEM', 'HUARAL')
            ->set('datos.DES_DIST_ITEM', 'CHANCAY')
            ->set('datos.FEC_PUBLICACION', '2026-11-03')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame(1, DB::table('dbo.PROC_ITEM')->where('IDE_CONVOCATORIA', $codigo)->where('DES_ITEM', 'PRUEBA LARAVEL ITEM')->count());
        $this->assertSame($proyectos + 1, DB::table('dbo.PROYECTO_ACTIVIDAD')->count());

        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROCESO', 'buscar' => $codigo])
            ->assertViewHas('filas', fn ($f) => $f->total() === 1);
    }

    public function test_editar_conserva_el_codigo_y_eliminar(): void
    {
        $this->actingAs($this->usuarioGepro());
        $proceso = DB::table('dbo.PROCESO')->where('EST_PROCESO', '<>', '2')->first();
        if (! $proceso) {
            $this->markTestSkipped('No hay procesos.');
        }
        $id = (string) (int) $proceso->IDE_CONVOCATORIA;
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROCESO'])
            ->call('editar', $id)
            ->set('datos.IDE_CONVOCATORIA', '999999999')
            ->set('datos.COD_PAC', 'PAC LARAVEL')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame('PAC LARAVEL', DB::table('dbo.PROCESO')->where('IDE_CONVOCATORIA', $id)->value('COD_PAC'));
        $this->assertFalse(DB::table('dbo.PROCESO')->where('IDE_CONVOCATORIA', '999999999')->exists());

        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROCESO'])->call('eliminar', $id);
        $this->assertSame('2', trim((string) DB::table('dbo.PROCESO')->where('IDE_CONVOCATORIA', $id)->value('EST_PROCESO')));
    }

    public function test_acciones_de_la_fila(): void
    {
        $u = $this->usuarioGepro(false, 'PROCESO');
        if (! $u) {
            $this->markTestSkipped('Ningun usuario tiene acceso a Actos preparatorios.');
        }
        $proceso = (string) (int) DB::table('dbo.PROCESO')->where('EST_PROCESO', '<>', '2')->value('IDE_CONVOCATORIA');
        $this->actingAs($u)->get('/catalogos/PROCESO')->assertOk()
            ->assertSee('idConvocatoria='.$proceso, false)
            ->assertSee('/catalogos/PROC_ITEM?de='.$proceso, false);
        $this->get('/catalogos/PROC_CRONOGRAMA?de='.$proceso)->assertOk()->assertSee('Cronograma del proceso');
    }
}
