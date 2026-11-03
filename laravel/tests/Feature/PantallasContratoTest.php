<?php

namespace Tests\Feature;

use App\Calculos\PrioridadRiesgo;
use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectoContratosTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Pantallas que se abren desde los contratos (detalle, riesgos, interesados, documentos) y desde el
 * proyecto (lecciones aprendidas), contra BDGEPRO. Lo que graba se revierte (DatabaseTransactions).
 */
class PantallasContratoTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    /** Registro "de" con mas filas en la tabla (columna que apunta a el) */
    private function conMasFilas(string $tabla, string $columna, string $estado): ?string
    {
        $id = DB::table($tabla)->where($estado, '<>', '2')->whereNotNull($columna)
            ->groupBy($columna)->orderByRaw('COUNT(*) DESC')->value($columna);

        return $id === null ? null : (string) (int) $id;
    }

    private function totalLegado(string $sp, string $filtro): int
    {
        return (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC '.$sp." @TipoAccion='Count', @filtro=?", [$filtro]))[0];
    }

    public function test_mismos_totales_que_el_sistema_actual(): void
    {
        $casos = [
            ['PROY_RIESGO_PROBLEMA', 'dbo.PROY_RIESGO_PROBLEMA', 'IDE_PROYECTO_ACTIVIDAD', 'EST_RIESGO', 'dbo.SP_PROY_RIESGO_PROBLEMA', ' AND R.IDE_PROYECTO_ACTIVIDAD=%s '],
            ['CONT_INTERESADOS', 'dbo.CONT_INTERESADOS', 'IDE_CONTRATO', 'EST_CONT_INTERESADO', 'dbo.SP_CONT_INTERESADOS', ' AND T.IDE_CONTRATO=%s '],
            ['CONT_DOCUMENTACION', 'dbo.CONT_DOCUMENTACION', 'IDE_CONTRATO', 'EST_DOCUMENTO', 'dbo.SP_CONT_DOCUMENTACION', ' AND T.IDE_CONTRATO=%s '],
            ['PROY_LECCION_APRENDIDA', 'dbo.PROY_LECCION_APRENDIDA', 'IDE_PROYECTO', 'EST_LECCION', 'dbo.SP_PROY_LECCION_APRENDIDA', ' AND T.IDE_PROYECTO=%s '],
        ];
        $probados = 0;
        foreach ($casos as [$pagina, $tabla, $columna, $estado, $sp, $filtro]) {
            $de = $this->conMasFilas($tabla, $columna, $estado);
            if ($de === null) {
                continue;
            }
            $legado = $this->totalLegado($sp, sprintf($filtro, $de));
            $this->assertGreaterThan(0, $legado, $pagina);
            Livewire::test(CatalogoTabla::class, ['pagina' => $pagina, 'de' => $de])
                ->assertViewHas('filas', fn ($f) => $f->total() === $legado);
            $probados++;
        }
        $this->assertGreaterThan(0, $probados);
    }

    public function test_detalle_del_contrato_por_su_enlace(): void
    {
        //EL SISTEMA ACTUAL BUSCA EL CONTRATO EN PROY_CONTRATO (ProyectoContrato_Datos2) Y FILTRA POR SU ID
        $enlace = DB::table('dbo.PROY_CONTRATO as PC')->join('dbo.CONTRATO as C', 'C.IDE_CONTRATO', '=', 'PC.IDE_CONTRATO')
            ->where('C.EST_CONTRATO', '<>', '2')->orderByDesc('PC.IDE_PROYECTO_ACTIVIDAD')->first(['PC.IDE_PROYECTO_ACTIVIDAD', 'PC.IDE_CONTRATO']);
        if (! $enlace) {
            $this->markTestSkipped('No hay contratos enlazados.');
        }
        $de = (string) (int) $enlace->IDE_PROYECTO_ACTIVIDAD;
        $esperado = DB::table('dbo.CONTRATO')->where('EST_CONTRATO', '<>', '2')
            ->whereIn('IDE_CONTRATO', DB::table('dbo.PROY_CONTRATO')->where('IDE_PROYECTO_ACTIVIDAD', $de)->select('IDE_CONTRATO'))->count();
        Livewire::test(CatalogoTabla::class, ['pagina' => 'CONTRATO', 'de' => $de])
            ->assertViewHas('filas', fn ($f) => $f->total() === $esperado && $f->getCollection()->contains(fn ($r) => (int) $r->ID === (int) $enlace->IDE_CONTRATO));

        //EDITAR: CONSERVA LO QUE NO ESTA EN EL FORMULARIO (FECHAS, ARCHIVO)
        $this->actingAs($this->usuarioGepro());
        $antes = DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', $enlace->IDE_CONTRATO)->first();
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONTRATO', 'de' => $de])
            ->call('editar', (string) (int) $enlace->IDE_CONTRATO)
            ->set('datos.COD_CONTRATO_ENTIDAD', 'DOC LARAVEL')
            ->call('guardar')->assertHasNoErrors();
        $despues = DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', $enlace->IDE_CONTRATO)->first();
        $this->assertSame('DOC LARAVEL', $despues->COD_CONTRATO_ENTIDAD);
        $this->assertEquals(substr((string) $antes->FEC_INICIO_CONTRATO, 0, 10), substr((string) $despues->FEC_INICIO_CONTRATO, 0, 10));
        $this->assertSame($antes->IMG_CONTRATO, $despues->IMG_CONTRATO);

        //UN CONTRATO DE OTRO PROYECTO_ACTIVIDAD NO SE ABRE NI SE ELIMINA DESDE ESTE
        $otro = DB::table('dbo.CONTRATO')->where('EST_CONTRATO', '<>', '2')
            ->whereNotIn('IDE_CONTRATO', DB::table('dbo.PROY_CONTRATO')->where('IDE_PROYECTO_ACTIVIDAD', $de)->select('IDE_CONTRATO'))->value('IDE_CONTRATO');
        if ($otro) {
            Livewire::test(CatalogoTabla::class, ['pagina' => 'CONTRATO', 'de' => $de])->call('eliminar', (string) (int) $otro);
            $this->assertNotSame('2', trim((string) DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', $otro)->value('EST_CONTRATO')));
        }
    }

    public function test_prioridad_del_riesgo_igual_que_el_sistema_actual(): void
    {
        $c = new PrioridadRiesgo();
        $this->assertSame(PrioridadRiesgo::BAJA, $c->calcular(['IDE_PROBABILIDAD' => '2', 'IDE_IMPACTO' => '2'], null)['IDE_PRIORIDAD']);
        $this->assertSame(PrioridadRiesgo::MODERADA, $c->calcular(['IDE_PROBABILIDAD' => '3', 'IDE_IMPACTO' => '3'], null)['IDE_PRIORIDAD']);
        $this->assertSame(PrioridadRiesgo::ALTA, $c->calcular(['IDE_PROBABILIDAD' => '5', 'IDE_IMPACTO' => '3'], null)['IDE_PRIORIDAD']);
        $this->assertSame('', $c->calcular(['IDE_PROBABILIDAD' => '', 'IDE_IMPACTO' => '3'], null)['IDE_PRIORIDAD']);

        //LO GRABADO DESDE 2020 TIENE LA PRIORIDAD DE ESTA REGLA (LO DE 2019 SE GRABO CON LA REGLA ANTERIOR,
        //QUE QUEDO COMENTADA EN LA VISTA: PROBABILIDAD 0.1..0.9 E IMPACTO 0.05..0.8)
        $filas = DB::table('dbo.PROY_RIESGO_PROBLEMA')->where('EST_RIESGO', '<>', '2')->whereBetween('IDE_PROBABILIDAD', [1, 5])->whereBetween('IDE_IMPACTO', [1, 5])
            ->where('FECHA_INSERT', '>=', '2020-01-01')->get();
        foreach ($filas as $r) {
            $this->assertSame((string) $r->IDE_PRIORIDAD, $c->calcular((array) $r, null)['IDE_PRIORIDAD'], 'Riesgo '.$r->IDE_RIESGO_PROB);
        }
    }

    public function test_registrar_riesgo_interesado_documento_y_leccion(): void
    {
        $this->actingAs($this->usuarioGepro());
        $contrato = (string) (int) DB::table('dbo.PROYECTO_ACTIVIDAD')->where('EST_PROYECTO_ACTIVIDAD', '<>', '2')->orderByDesc('IDE_PROYECTO_ACTIVIDAD')->value('IDE_PROYECTO_ACTIVIDAD');
        $proyecto = (string) (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->orderByDesc('IDE_PROYECTO')->value('IDE_PROYECTO');
        $lista = fn (string $tabla, string $id, string $estado) => (string) DB::table($tabla)->where($estado, '1')->value($id);
        $tabla = fn (string $cod) => trim((string) DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', $cod)->where('EST_ITEM', 1)->value('COD_ITEM'));

        //RIESGO: LA PRIORIDAD SE CALCULA AL ELEGIR PROBABILIDAD E IMPACTO
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_RIESGO_PROBLEMA', 'de' => $contrato])
            ->call('nuevo')
            ->set('datos.IDE_TIPO_RIESGO_PROB', $lista('dbo.GEN_TIPO_RIESGO', 'IDE_TIPO_RIESGO', 'EST_TIPO_RIESGO'))
            ->set('datos.TIP_RIESGO_PROB', '1')
            ->set('datos.DES_NOMBRE', 'RISK-LARAVEL-1')
            ->set('datos.DES_DETALLE', 'PRUEBA LARAVEL RIESGO')
            ->set('datos.IDE_PROBABILIDAD', '5')
            ->set('datos.IDE_IMPACTO', '5')
            ->assertSet('datos.IDE_PRIORIDAD', PrioridadRiesgo::ALTA)
            ->set('datos.FEC_INICIO_SOLUCION', '2026-11-03')
            ->call('guardar')->assertHasNoErrors();
        $riesgo = DB::table('dbo.PROY_RIESGO_PROBLEMA')->where('IDE_PROYECTO_ACTIVIDAD', $contrato)->where('DES_NOMBRE', 'RISK-LARAVEL-1')->first();
        $this->assertSame(PrioridadRiesgo::ALTA, (string) $riesgo->IDE_PRIORIDAD);
        $this->assertSame('1', trim((string) $riesgo->EST_RIESGO));

        //INTERESADO: IDE_CONTRATO GUARDA EL IDE_PROYECTO_ACTIVIDAD
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_INTERESADOS', 'de' => $contrato])
            ->call('nuevo')
            ->set('datos.IDE_RECURSO', $lista('dbo.GEN_RECURSO', 'IDE_RECURSO', 'EST_RECURSO'))
            ->set('datos.DES_LOCALIZACION', 'MUNICIPALIDAD LARAVEL')
            ->set('datos.TIP_INTERNO_EXTERNO', $tabla('70'))
            ->set('datos.DES_REQUERIMIENTOS_PRIMORDIALES', 'REQUERIMIENTO')
            ->set('datos.DES_EXPECTATIVAS_PRINCIPALES', 'EXPECTATIVA')
            ->set('datos.TIP_CLASIFICACION', $tabla('71'))
            ->call('guardar')->assertHasNoErrors();
        $this->assertTrue(DB::table('dbo.CONT_INTERESADOS')->where('IDE_CONTRATO', $contrato)->where('DES_LOCALIZACION', 'MUNICIPALIDAD LARAVEL')->exists());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONT_DOCUMENTACION', 'de' => $contrato])
            ->call('nuevo')
            ->set('datos.IDE_CONOC_PROC', (string) DB::table('dbo.GEN_MATRIZ_CONOCIMIENTO_PROCESO')->where('EST_CONOC_PROC', '<>', '2')->value('IDE_CONOC_PROC'))
            ->set('datos.FEC_DOCUMENTO', '2026-11-03')
            ->set('datos.DES_DOCUMENTO', 'https://sharepoint.ejemplo/plan.pdf')
            ->call('guardar')->assertHasNoErrors();
        $this->assertTrue(DB::table('dbo.CONT_DOCUMENTACION')->where('IDE_CONTRATO', $contrato)->where('DES_DOCUMENTO', 'https://sharepoint.ejemplo/plan.pdf')->exists());
        //"VER CONTENIDO" ABRE LA RUTA SOLO SI ES UN ENLACE
        Livewire::test(CatalogoTabla::class, ['pagina' => 'CONT_DOCUMENTACION', 'de' => $contrato])
            ->assertSee('href="https://sharepoint.ejemplo/plan.pdf"', false);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_LECCION_APRENDIDA', 'de' => $proyecto])
            ->call('nuevo')
            ->set('datos.IDE_FASE_COMPONENTE', (string) DB::table('dbo.GEN_INTERVENCION')->where('NUM_NIVEL', 3)->where('IDE_SECTOR', 14)->where('EST_INTERVENCION', '<>', '2')->value('IDE_INTERVENCION'))
            ->set('datos.TIP_LECCION', '2')
            ->set('datos.TIP_IMPACTO_SITUACION', $tabla('81'))
            ->set('datos.FEC_LECCION', '2026-11-03')
            ->set('datos.DES_LECCION_APRENDIDA', 'PRUEBA LARAVEL LECCION')
            ->call('guardar')->assertHasNoErrors();
        $this->assertTrue(DB::table('dbo.PROY_LECCION_APRENDIDA')->where('IDE_PROYECTO', $proyecto)->where('DES_LECCION_APRENDIDA', 'PRUEBA LARAVEL LECCION')->exists());
    }

    public function test_las_grillas_abren_las_pantallas_de_laravel(): void
    {
        $fila = (object) ['ID' => 5, 'IDE_PROYECTO' => 7, 'IDE_INTERVENCION' => 151, 'IDE_PROCESO_ITEM' => 0];
        $tabla = new ProyectoContratosTabla();
        foreach (['contrato' => 'CONTRATO', 'riesgo' => 'PROY_RIESGO_PROBLEMA', 'interesados' => 'CONT_INTERESADOS', 'documentos' => 'CONT_DOCUMENTACION'] as $accion => $pagina) {
            $this->assertSame(route('catalogos.index', ['pagina' => $pagina, 'de' => 5]), $tabla->urlAccion($accion, $fila));
        }
    }
}
