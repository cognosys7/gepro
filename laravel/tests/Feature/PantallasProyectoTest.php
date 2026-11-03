<?php

namespace Tests\Feature;

use App\Calculos\ValoracionOportunidad;
use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectoFormulario;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Pantallas relacionadas del proyecto (seccion III de su formulario), contra BDGEPRO. Lo que graba se revierte.
 */
class PantallasProyectoTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    /** Pagina => [columna de estado, valores minimos para registrar] */
    private const PANTALLAS = [
        'PROY_SOCIAL_OBJETIVO_ESP' => ['EST_OBJETIVO_ESP', ['FEC_OBJETIVO' => '2026-01-15', 'DES_OBJETIVO_ESPECIFICO' => 'OBJETIVO LARAVEL', 'DES_META' => 'META', 'DES_INDICADOR' => 'INDICADOR', 'DES_ACTIVIDAD' => 'ACTIVIDAD']],
        'PROY_ACCION_GESTION' => ['EST_ACCION', ['FEC_ACCION' => '2026-01-15', 'TIP_COMPONENTE' => '4', 'DES_ACCION' => 'ACCION LARAVEL']],
        'PROY_ACCION_CORRECTIVA' => ['EST_ACCION', ['FEC_ACCION' => '2026-01-15', 'TIP_COMPONENTE' => '3', 'DES_DESVIACION_IDENTIFICADA' => 'DESVIACION LARAVEL', 'DES_ACCION_CORRECTIVA' => 'CORRECTIVA']],
        'PROY_OPORTUNIDAD_RIESGO' => ['EST_RIESGO', ['FEC_RIESGO' => '2026-01-15', 'TIP_COMPONENTE' => '3', 'DES_RIESGO' => 'RIESGO LARAVEL', 'NUM_PROBABILIDAD' => '4', 'NUM_IMPACTO' => '4']],
        'PROY_COSTO_COMPONENTE' => ['EST_CAMBIO', ['FEC_CAMBIO' => '2026-01-15', 'TIP_COMPONENTE_ACT' => '4', 'IMP_CTO_OBRA' => '1500.5', 'PCT_AVANCE_FISICO' => '25']],
        'PROY_SEGUIMIENTO' => ['EST_SEGUIMIENTO', ['FEC_SEGUIMIENTO' => '2026-01-15', 'DES_SEGUIMIENTO' => 'SEGUIMIENTO LARAVEL']],
    ];

    public function test_mismos_totales_que_el_sistema_actual(): void
    {
        $probados = 0;
        foreach (self::PANTALLAS as $pagina => [$estado]) {
            $de = DB::table('dbo.'.$pagina)->where($estado, '<>', '2')->groupBy('IDE_PROYECTO')->orderByRaw('COUNT(*) DESC')->value('IDE_PROYECTO');
            if ($de === null) {
                continue;
            }
            $de = (string) (int) $de;
            $legado = (int) array_values((array) DB::selectOne('SET NOCOUNT ON; EXEC dbo.SP_'.$pagina." @TipoAccion='Count', @filtro=?", [' AND T.IDE_PROYECTO='.$de.' ']))[0];
            $this->assertGreaterThan(0, $legado, $pagina);
            Livewire::test(CatalogoTabla::class, ['pagina' => $pagina, 'de' => $de])
                ->assertViewHas('filas', fn ($f) => $f->total() === $legado);
            $probados++;
        }
        $this->assertGreaterThan(0, $probados);
    }

    public function test_valoracion_igual_que_lo_grabado(): void
    {
        $c = new ValoracionOportunidad();
        $filas = DB::table('dbo.PROY_OPORTUNIDAD_RIESGO')->where('EST_RIESGO', '<>', '2')->whereNotNull('NUM_VALORACION')->get();
        foreach ($filas as $r) {
            $this->assertSame((string) (int) $r->NUM_VALORACION, $c->calcular(['NUM_PROBABILIDAD' => (string) (int) $r->NUM_PROBABILIDAD, 'NUM_IMPACTO' => (string) (int) $r->NUM_IMPACTO], null)['NUM_VALORACION'], 'Oportunidad '.$r->IDE_PROY_OPORTUNIDAD);
        }
    }

    public function test_grilla_muestra_descripciones_de_claves_con_decimales(): void
    {
        $de = DB::table('dbo.PROY_OPORTUNIDAD_RIESGO')->where('EST_RIESGO', '<>', '2')->whereNotNull('NUM_IMPACTO')->value('IDE_PROYECTO');
        if ($de === null) {
            $this->markTestSkipped('No hay oportunidades de mejora.');
        }
        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_OPORTUNIDAD_RIESGO', 'de' => (string) (int) $de])
            ->assertDontSee('.000');
    }

    public function test_registrar_y_editar_en_cada_pantalla(): void
    {
        $this->actingAs($this->usuarioGepro());
        $proyecto = (string) (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->orderByDesc('IDE_PROYECTO')->value('IDE_PROYECTO');
        foreach (self::PANTALLAS as $pagina => [$estado, $valores]) {
            $f = Livewire::test(CatalogoFormulario::class, ['pagina' => $pagina, 'de' => $proyecto])->call('nuevo');
            foreach ($valores as $campo => $valor) {
                $f->set('datos.'.$campo, $valor);
            }
            $f->call('guardar')->assertHasNoErrors();
            $id = Livewire::test(CatalogoTabla::class, ['pagina' => $pagina, 'de' => $proyecto])->viewData('filas')->getCollection()->max('ID');
            $fila = DB::table('dbo.'.$pagina)->where(config('catalogos.'.$pagina.'.id'), $id)->first();
            $this->assertSame($proyecto, (string) (int) $fila->IDE_PROYECTO, $pagina);
            $this->assertSame('1', trim((string) $fila->{$estado}), $pagina);
            //EDITAR CONSERVA LOS VALORES (LAS CLAVES CON DECIMALES SE LEEN COMO ENTEROS)
            $e = Livewire::test(CatalogoFormulario::class, ['pagina' => $pagina, 'de' => $proyecto])->call('editar', (string) (int) $id);
            foreach ($valores as $campo => $valor) {
                $this->assertEquals($valor, $e->get('datos.'.$campo), $pagina.' '.$campo);
            }
            $e->call('guardar')->assertHasNoErrors();
        }
        //ALTAMENTE PROBABLE X ALTO = 6.4: ALTA
        $this->assertSame(5, (int) DB::table('dbo.PROY_OPORTUNIDAD_RIESGO')->where('IDE_PROYECTO', $proyecto)->where('DES_RIESGO', 'RIESGO LARAVEL')->value('NUM_VALORACION'));
    }

    public function test_el_formulario_del_proyecto_las_abre_en_laravel(): void
    {
        $this->actingAs($this->usuarioGepro());
        $proyecto = (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->orderByDesc('IDE_PROYECTO')->value('IDE_PROYECTO');
        $f = new ProyectoFormulario();
        $f->idProyecto = $proyecto;
        foreach (array_keys(ProyectoFormulario::RELACIONADAS) as $pagina) {
            $this->assertSame(route('catalogos.index', ['pagina' => $pagina, 'de' => $proyecto]), $f->urlRelacionada($pagina));
        }
    }
}
