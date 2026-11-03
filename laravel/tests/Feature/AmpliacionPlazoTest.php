<?php

namespace Tests\Feature;

use App\Calculos\AmpliacionPlazo;
use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Ampliacion de plazo del contrato (PROY_CONT_AMPLIACION), contra BDGEPRO. Lo que graba se revierte.
 */
class AmpliacionPlazoTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    public function test_mismo_total_que_el_sistema_actual(): void
    {
        $de = DB::table('dbo.PROY_CONT_AMPLIACION')->where('EST_CONT_AMPLIACION', '<>', '2')
            ->groupBy('IDE_PROYECTO_ACTIVIDAD')->orderByRaw('COUNT(*) DESC')->value('IDE_PROYECTO_ACTIVIDAD');
        if ($de === null) {
            $this->markTestSkipped('No hay ampliaciones de plazo.');
        }
        $de = (string) (int) $de;
        $legado = (int) array_values((array) DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_PROY_CONT_AMPLIACION @TipoAccion='Count', @filtro=?", [' AND T.IDE_PROYECTO_ACTIVIDAD='.$de.' ']))[0];
        $this->assertGreaterThan(0, $legado);
        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_CONT_AMPLIACION', 'de' => $de])
            ->assertViewHas('filas', fn ($f) => $f->total() === $legado);
    }

    public function test_termino_es_inicio_mas_dias(): void
    {
        $c = new AmpliacionPlazo();
        //EL PLAZO CONTRACTUAL DE LA CAPTURA: 2019-07-20 + 600 DIAS = 2021-03-11
        $this->assertSame(['FEC_TERMINO_AMP' => '2021-03-11'], $c->calcular(['FEC_INICIO_AMP' => '2019-07-20', 'CAN_DIAS_CALENDARIO' => '600'], null));
        $this->assertSame([], $c->calcular(['FEC_INICIO_AMP' => '', 'CAN_DIAS_CALENDARIO' => '600'], null));
        $this->assertSame([], $c->calcular(['FEC_INICIO_AMP' => '2019-07-20', 'CAN_DIAS_CALENDARIO' => ''], null));
    }

    public function test_campos_segun_el_tipo_y_un_solo_plazo_contractual(): void
    {
        $this->actingAs($this->usuarioGepro());
        //UN CONTRATO SIN PLAZO CONTRACTUAL
        $de = (string) (int) DB::table('dbo.PROYECTO_ACTIVIDAD')->where('EST_PROYECTO_ACTIVIDAD', '<>', '2')
            ->whereNotIn('IDE_PROYECTO_ACTIVIDAD', DB::table('dbo.PROY_CONT_AMPLIACION')->where('TIP_AMPLIACION', '3')->where('EST_CONT_AMPLIACION', '<>', '2')->select('IDE_PROYECTO_ACTIVIDAD'))
            ->orderByDesc('IDE_PROYECTO_ACTIVIDAD')->value('IDE_PROYECTO_ACTIVIDAD');

        $f = Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_CONT_AMPLIACION', 'de' => $de])->call('nuevo')
            ->assertViewHas('combos', fn ($c) => isset($c['TIP_AMPLIACION']['3']));
        //AMPLIACION: SIN FECHA DE INICIO, CON "TERMINO VIGENTE" Y SIN CALCULO
        $f->set('datos.TIP_AMPLIACION', '4');
        $this->assertFalse($f->instance()->visible('FEC_INICIO_AMP'));
        $this->assertTrue($f->instance()->visible('COD_RESOLUCION'));
        $this->assertSame('Término vigente', $f->instance()->etiqueta('FEC_TERMINO_AMP'));
        $this->assertFalse($f->get('autoCalcular'));
        //PLAZO CONTRACTUAL: EL TERMINO SE CALCULA
        $f->set('datos.TIP_AMPLIACION', '3')->set('datos.FEC_INICIO_AMP', '2019-07-20')->set('datos.CAN_DIAS_CALENDARIO', '600')
            ->assertSet('autoCalcular', true)->assertSet('datos.FEC_TERMINO_AMP', '2021-03-11');
        $this->assertTrue($f->instance()->visible('FEC_INICIO_AMP'));
        $this->assertFalse($f->instance()->visible('COD_RESOLUCION'));
        $f->set('datos.NUM_ORDEN', '1')->call('guardar')->assertHasNoErrors();

        $fila = DB::table('dbo.PROY_CONT_AMPLIACION')->where('IDE_PROYECTO_ACTIVIDAD', $de)->where('TIP_AMPLIACION', '3')->where('EST_CONT_AMPLIACION', '<>', '2')->first();
        $this->assertNotNull($fila);
        $this->assertSame('2021-03-11', substr((string) $fila->FEC_TERMINO_AMP, 0, 10));

        //YA TIENE PLAZO CONTRACTUAL: NO SE OFRECE NI SE ACEPTA OTRO
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_CONT_AMPLIACION', 'de' => $de])->call('nuevo')
            ->assertViewHas('combos', fn ($c) => ! isset($c['TIP_AMPLIACION']['3']) && isset($c['TIP_AMPLIACION']['4']))
            ->set('datos.TIP_AMPLIACION', '3')->call('guardar')->assertHasErrors('datos.TIP_AMPLIACION');
        //AL EDITARLO SI SE CONSERVA
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_CONT_AMPLIACION', 'de' => $de])
            ->call('editar', (string) (int) $fila->IDE_CONT_AMPLIACION)
            ->assertViewHas('combos', fn ($c) => isset($c['TIP_AMPLIACION']['3']))
            ->set('datos.COD_RESOLUCION', 'RES LARAVEL')->call('guardar')->assertHasNoErrors();
        $this->assertSame('3', trim((string) DB::table('dbo.PROY_CONT_AMPLIACION')->where('IDE_CONT_AMPLIACION', $fila->IDE_CONT_AMPLIACION)->value('TIP_AMPLIACION')));
    }
}
