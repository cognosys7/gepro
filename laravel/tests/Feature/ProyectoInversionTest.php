<?php

namespace Tests\Feature;

use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectosTabla;
use App\Support\Catalogo;
use App\Support\ProyectoInversion;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use RuntimeException;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Proyecto de inversion del proyecto (PROY_PIP) contra BDGEPRO. Lo que graba corre dentro de una
 * transaccion que se revierte (DatabaseTransactions).
 */
class ProyectoInversionTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    private function proyectoCon(): int
    {
        return (int) DB::table('dbo.PROY_PIP')->where('EST_PROY_PIP', '<>', '2')->min('IDE_PROYECTO');
    }

    private function proyectoSin(): int
    {
        return (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')
            ->whereNotIn('IDE_PROYECTO', DB::table('dbo.PROY_PIP')->where('EST_PROY_PIP', '<>', '2')->whereNotNull('IDE_PROYECTO')->select('IDE_PROYECTO'))
            ->max('IDE_PROYECTO');
    }

    public function test_mismo_total_que_el_sistema_actual(): void
    {
        $this->actingAs($this->usuarioGepro());
        foreach (DB::table('dbo.PROY_PIP')->whereNotNull('IDE_PROYECTO')->distinct()->pluck('IDE_PROYECTO') as $proyecto) {
            $legado = (int) array_values((array) DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_PROY_PIP @TipoAccion = 'Count', @filtro = ?", [' AND T.IDE_PROYECTO='.(int) $proyecto]))[0];
            Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_PIP', 'de' => (int) $proyecto])
                ->assertViewHas('filas', fn ($f) => $f->total() === $legado);
        }
    }

    public function test_abre_en_laravel_desde_los_proyectos(): void
    {
        $tabla = new ProyectosTabla();
        $tabla->opcion = 110;

        $this->assertSame(route('catalogos.index', ['pagina' => 'PROY_PIP', 'de' => 5]), $tabla->urlAccion('pip', (object) ['IDE_PROYECTO' => 5]));
    }

    public function test_solo_se_asocia_uno_y_no_se_edita_ni_elimina(): void
    {
        $this->actingAs($this->usuarioGepro());

        $con = Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_PIP', 'de' => $this->proyectoCon()]);
        $this->assertFalse($con->instance()->puede('nuevo'));
        $this->assertFalse($con->instance()->puede('eliminar'));
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_PIP', 'de' => $this->proyectoCon()])->call('nuevo')->assertSet('abierto', false);

        $sin = Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_PIP', 'de' => $this->proyectoSin()]);
        $this->assertTrue($sin->instance()->puede('nuevo'));
        $this->assertTrue(empty(config('catalogos.PROY_PIP.editar')));
    }

    public function test_los_codigos_quedan_en_el_proyecto_correcto(): void
    {
        //EL SP ACTUALIZA EL PROYECTO CUYO ID COINCIDE CON EL IDE_PIP: SE ELIGE UN CASO QUE LO PROVOCA
        $proyecto = $this->proyectoSin();
        $otro = DB::table('dbo.PROYECTO as P')->join('dbo.GEN_PIP as G', 'G.IDE_PIP', '=', 'P.IDE_PROYECTO')
            ->where('P.IDE_PROYECTO', '<>', $proyecto)->where('G.EST_PIP', '<>', '2')->whereRaw("LEN(ISNULL(G.COD_SNIP, '')) <= 10 AND LEN(ISNULL(G.COD_UNICO, '')) <= 10")
            ->whereRaw("ISNULL(G.COD_UNICO, '') <> ISNULL(P.COD_UNICO, '') AND ISNULL(G.COD_UNICO, '') <> ''")
            ->select('P.IDE_PROYECTO', 'P.COD_SNIP', 'P.COD_UNICO', 'G.COD_UNICO as UNICO_PIP')->first();
        if (! $otro) {
            $this->markTestSkipped('No hay un proyecto cuyo id coincida con un IDE_PIP.');
        }
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_PIP', 'de' => $proyecto])->call('nuevo')
            ->call('elegir', 'IDE_PIP', (string) (int) $otro->IDE_PROYECTO)->call('guardar')->assertHasNoErrors()->assertSet('abierto', false);

        $this->assertSame(1, DB::table('dbo.PROY_PIP')->where('IDE_PROYECTO', $proyecto)->where('EST_PROY_PIP', '<>', '2')->count());
        $this->assertSame(trim($otro->UNICO_PIP), trim((string) DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $proyecto)->value('COD_UNICO')));
        $ajeno = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $otro->IDE_PROYECTO)->first(['COD_SNIP', 'COD_UNICO']);
        $this->assertSame($otro->COD_UNICO, $ajeno->COD_UNICO);
        $this->assertSame($otro->COD_SNIP, $ajeno->COD_SNIP);
    }

    public function test_exige_elegir_y_rechaza_codigos_largos_o_duplicados(): void
    {
        $proyecto = $this->proyectoSin();
        $this->actingAs($this->usuarioGepro());
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_PIP', 'de' => $proyecto])->call('nuevo')->call('guardar')->assertHasErrors('datos.IDE_PIP');

        $largo = DB::table('dbo.GEN_PIP')->whereRaw('LEN(COD_SNIP) > 10 OR LEN(COD_UNICO) > 10')->value('IDE_PIP');
        if ($largo) {
            try {
                ProyectoInversion::registrar(['IDE_PROYECTO' => $proyecto, 'IDE_PIP' => (int) $largo, 'EST_PROY_PIP' => '1', 'pUsuario' => 1]);
                $this->fail('Debió rechazar los códigos largos.');
            } catch (RuntimeException $e) {
                $this->assertStringContainsString('superan', $e->getMessage());
            }
        }

        $this->expectExceptionMessage('ya tiene un proyecto de inversión');
        ProyectoInversion::registrar(['IDE_PROYECTO' => $this->proyectoCon(), 'IDE_PIP' => 1, 'EST_PROY_PIP' => '1', 'pUsuario' => 1]);
    }

    public function test_enlaces_al_mef_solo_con_codigos_numericos(): void
    {
        $this->actingAs($this->usuarioGepro());
        $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_PIP', 'de' => $this->proyectoCon()])->instance();
        $accion = config('catalogos.PROY_PIP.acciones')[1][4];

        $this->assertSame('https://ofi5.mef.gob.pe/invierte/formato/verProyectoCU/2430852', $tabla->urlAccion($accion, (object) ['ID' => 1, 'VER_UNICO' => '2430852']));
        $this->assertSame('', $tabla->urlAccion($accion, (object) ['ID' => 1, 'VER_UNICO' => 'C00101']));
    }

    public function test_el_buscador_encuentra_por_codigo_y_descripcion(): void
    {
        $campo = Catalogo::definicion('PROY_PIP')['campos']['IDE_PIP'];
        $fila = DB::table('dbo.GEN_PIP')->where('EST_PIP', '<>', '2')->whereNotNull('COD_UNICO')->whereRaw('LEN(COD_UNICO) >= 6')->first(['IDE_PIP', 'COD_UNICO']);

        $this->assertArrayHasKey((int) $fila->IDE_PIP, Catalogo::buscarLista($campo, trim($fila->COD_UNICO)));
    }
}
