<?php

namespace Tests\Feature;

use App\Calculos\ControlMensual;
use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Support\Catalogo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Contrato -> Etapas -> Control anual -> Control mensual (y Recursos de la etapa) contra BDGEPRO.
 * Lo que graba corre dentro de una transaccion que se revierte (DatabaseTransactions).
 */
class CadenaContratoTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    /** Un control anual con meses registrados, con su etapa y su contrato */
    private function cadena(): object
    {
        $fila = DB::table('dbo.PROY_CONT_ETAPA_CONTROL as E')
            ->join('dbo.PROY_COMPONENTE as C', 'C.IDE_PROY_COMPONENTE', '=', 'E.IDE_PROY_COMPONENTE')
            ->where('E.EST_ETAPA_CONTROL', '<>', '2')->where('C.IDE_ESTADO', '<>', 9)
            ->whereExists(fn ($q) => $q->from('dbo.PROY_CONT_COMP_CONTROL_DET as D')->whereColumn('D.IDE_CONT_ETAPA_CONTROL', 'E.IDE_CONT_ETAPA_CONTROL')->where('D.EST_ETAPA_CONTROL_DET', '<>', '2'))
            ->orderByDesc('E.IDE_CONT_ETAPA_CONTROL')
            ->first(['E.IDE_CONT_ETAPA_CONTROL as anual', 'E.IDE_PROY_COMPONENTE as etapa', 'C.IDE_PROYECTO_ACTIVIDAD as contrato', 'E.IDE_PLAN as plan']);
        if (! $fila) {
            $this->markTestSkipped('No hay controles anuales con meses.');
        }

        return $fila;
    }

    /** Total que cuenta el sistema actual: Count del SP con el filtro que arma su LN */
    private function totalLegado(string $sp, string $filtro): int
    {
        return (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC '.$sp." @TipoAccion='Count', @filtro=?", [$filtro]))[0];
    }

    public function test_mismos_totales_que_el_sistema_actual(): void
    {
        $c = $this->cadena();
        $casos = [
            ['PROY_COMPONENTE', $c->contrato, 'dbo.SP_PROY_COMPONENTE', " AND PC.IDE_PROYECTO_ACTIVIDAD={$c->contrato} "],
            ['PROY_CONT_ETAPA_CONTROL', $c->etapa, 'dbo.SP_PROY_CONT_ETAPA_CONTROL', " AND T.IDE_PROY_COMPONENTE={$c->etapa} "],
            ['PROY_CONT_COMP_CONTROL_DET', $c->anual, 'dbo.SP_PROY_CONT_COMP_CONTROL_DET', " AND T.IDE_CONT_ETAPA_CONTROL={$c->anual} "],
        ];
        foreach ($casos as [$pagina, $de, $sp, $filtro]) {
            $legado = $this->totalLegado($sp, $filtro);
            Livewire::test(CatalogoTabla::class, ['pagina' => $pagina, 'de' => (string) (int) $de])
                ->assertViewHas('filas', fn ($f) => $f->total() === $legado);
        }
    }

    public function test_formula_igual_a_lo_grabado(): void
    {
        //LOS MESES GRABADOS CON EL CALCULO AUTOMATICO DEBEN DAR LO MISMO CON LA FORMULA DE LARAVEL. SE USA
        //UN CONTROL DE EJECUCION REAL (PLAN 2) Y LOS MESES CON SALDO CALCULADO: LOS IMPORTADOS DESDE EXCEL
        //TRAEN IMPORTES AJUSTADOS Y SIN SALDO
        $anual = DB::table('dbo.PROY_CONT_ETAPA_CONTROL as E')->where('E.IDE_PLAN', 2)->where('E.EST_ETAPA_CONTROL', '<>', '2')
            ->whereExists(fn ($q) => $q->from('dbo.PROY_CONT_COMP_CONTROL_DET as D')->whereColumn('D.IDE_CONT_ETAPA_CONTROL', 'E.IDE_CONT_ETAPA_CONTROL')->whereNotNull('D.IMP_SALDO_SIN_IGV')->where('D.EST_ETAPA_CONTROL_DET', '<>', '2'))
            ->orderBy('E.IDE_CONT_ETAPA_CONTROL')->first(['E.*']);
        if (! $anual) {
            $this->markTestSkipped('No hay meses calculados.');
        }
        $meses = DB::table('dbo.PROY_CONT_COMP_CONTROL_DET')->where('IDE_CONT_ETAPA_CONTROL', $anual->IDE_CONT_ETAPA_CONTROL)
            ->where('EST_ETAPA_CONTROL_DET', '<>', '2')->whereNotNull('IMP_SALDO_SIN_IGV')->get();
        $coinciden = 0;
        foreach ($meses as $m) {
            $r = app(ControlMensual::class)->calcular((array) $m, $anual);
            if (abs((float) $r['IMP_NETO'] - (float) $m->IMP_NETO) < 0.02 && abs((float) $r['IMP_PAGO'] - (float) $m->IMP_PAGO) < 0.02) {
                $coinciden++;
            }
        }
        //ALGUNOS MESES PUEDEN HABERSE AJUSTADO A MANO (CALCULO AUTOMATICO DESACTIVADO): LA MAYORIA COINCIDE
        $this->assertGreaterThan(count($meses) * 0.8, $coinciden, "Coinciden $coinciden de ".count($meses));
    }

    public function test_registrar_mes_recalcula_el_control_anual(): void
    {
        $this->actingAs($this->usuarioGepro());
        $c = $this->cadena();

        $f = Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_CONT_COMP_CONTROL_DET', 'de' => (string) (int) $c->anual])
            ->call('nuevo')
            ->assertSet('datos.PCT_IGV', rtrim(rtrim(number_format((float) DB::table('dbo.PROY_CONT_ETAPA_CONTROL')->where('IDE_CONT_ETAPA_CONTROL', $c->anual)->value('PCT_IGV'), 4, '.', ''), '0'), '.') ?: '0')
            ->set('datos.NUM_MES', '12')
            ->set('datos.DES_CONCEPTO_PAGO', 'PRUEBA LARAVEL MES')
            ->set('datos.IMP_BRUTO', '1000');
        //EL CALCULO AUTOMATICO LLENA LOS MONTOS EN VERDE AL ESCRIBIR
        $this->assertSame('1000.00', $f->get('datos.IMP_SALDO_SIN_IGV'));
        $f->call('guardar')->assertHasNoErrors();

        $mes = DB::table('dbo.PROY_CONT_COMP_CONTROL_DET')->where('DES_CONCEPTO_PAGO', 'PRUEBA LARAVEL MES')->first();
        $this->assertSame((int) $c->anual, (int) $mes->IDE_CONT_ETAPA_CONTROL);
        //EL SP SUMA LOS MESES EN EL CONTROL ANUAL
        $suma = DB::table('dbo.PROY_CONT_COMP_CONTROL_DET')->where('IDE_CONT_ETAPA_CONTROL', $c->anual)->where('EST_ETAPA_CONTROL_DET', '<>', '2')->sum('IMP_BRUTO');
        $this->assertEquals(round((float) $suma, 2), round((float) DB::table('dbo.PROY_CONT_ETAPA_CONTROL')->where('IDE_CONT_ETAPA_CONTROL', $c->anual)->value('IMP_BRUTO'), 2));
    }

    public function test_etapas_solo_de_la_fase_del_contrato(): void
    {
        $this->actingAs($this->usuarioGepro());
        $c = $this->cadena();
        $intervencion = DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', $c->contrato)->value('IDE_INTERVENCION');
        $permitidas = DB::table('dbo.GEN_INTERVENCION_COMP')->where('IDE_INTERVENCION', $intervencion)->pluck('IDE_COMPONENTE')->map(fn ($v) => (string) $v)->all();
        $opciones = Catalogo::opciones(config('catalogos.PROY_COMPONENTE.campos.IDE_COMPONENTE'), null, Catalogo::filaDe(config('catalogos.PROY_COMPONENTE'), (string) $c->contrato));
        $this->assertEmpty(array_diff(array_keys($opciones), $permitidas));
    }

    public function test_pagina_embebida_con_acceso(): void
    {
        $c = $this->cadena();
        $u = $this->usuarioGepro(false, 'PROYECTO');
        $this->actingAs($u)->get('/catalogos/PROY_CONT_ETAPA_CONTROL?de='.(int) $c->etapa)
            ->assertOk()->assertSee('Control anual de la etapa')->assertSeeLivewire(CatalogoTabla::class);
        $this->get('/catalogos/PROY_CONT_ETAPA_CONTROL')->assertNotFound();
    }
}
