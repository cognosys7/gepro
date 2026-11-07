<?php

namespace Tests\Feature;

use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectoFormulario;
use App\Support\Catalogo;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Textos que guian al usuario en los formularios: ayudas, descripcion, resumen de lo que falta y mensajes.
 */
class FormulariosGuiaTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    private function contrato(bool $conRiesgos): int
    {
        $q = DB::table('dbo.PROYECTO_ACTIVIDAD as a')->where('a.EST_PROYECTO_ACTIVIDAD', '<>', '2');
        $sub = fn ($s) => $s->select(DB::raw(1))->from('dbo.PROY_RIESGO_PROBLEMA as r')->whereColumn('r.IDE_PROYECTO_ACTIVIDAD', 'a.IDE_PROYECTO_ACTIVIDAD')->where('r.EST_RIESGO', '<>', '2');

        return (int) ($conRiesgos ? $q->whereExists($sub) : $q->whereNotExists($sub))->value('a.IDE_PROYECTO_ACTIVIDAD');
    }

    public function test_el_formulario_de_riesgos_guia_al_usuario(): void
    {
        $this->actingAs($this->usuarioGepro(false, 'PROYECTO'));

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_RIESGO_PROBLEMA', 'de' => $this->contrato(false)])
            ->call('nuevo')
            ->assertSee('Anticipa lo que puede retrasar')
            ->assertSee('¿Qué podría pasar?')
            ->assertSee('Identificador corto dentro del contrato')
            ->assertSee('Evitar: eliminar la causa')
            ->assertDontSee('Tipo de estrategia');
    }

    public function test_dice_que_datos_faltan_en_lugar_de_un_aviso_generico(): void
    {
        $this->actingAs($this->usuarioGepro(false, 'PROYECTO'));

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_RIESGO_PROBLEMA', 'de' => $this->contrato(false)])
            ->call('nuevo')
            ->call('guardar')
            ->assertHasErrors(['datos.DES_DETALLE'])
            ->assertSee('Falta revisar')
            ->assertSee('¿Qué podría pasar?')
            ->assertDontSee('Revise los campos marcados');

        Livewire::test(ProyectoFormulario::class, ['opcion' => 110])
            ->call('nuevo')
            ->call('guardar')
            ->assertSee('Falta revisar 3 datos: Nombre completo, Etapa actual y Portafolio.');
    }

    public function test_los_formularios_sin_textos_propios_tambien_listan_lo_que_falta(): void
    {
        $pagina = null;
        foreach (config('catalogos') as $clave => $def) {
            $requerido = collect($def['campos'] ?? [])->contains(fn ($c) => ! empty($c[2]['requerido']));
            if (! empty($def['nuevo']) && empty($def['de']) && empty($def['descripcion']) && $requerido && $this->usuarioGepro(false, $clave)) {
                $pagina = $clave;
                break;
            }
        }
        $this->assertNotNull($pagina);
        $this->actingAs($this->usuarioGepro(false, $pagina));

        Livewire::test(CatalogoFormulario::class, ['pagina' => $pagina])
            ->call('nuevo')
            ->call('guardar')
            ->assertSee('Falta revisar')
            ->assertDontSee('Revise los campos marcados');
    }

    public function test_la_grilla_conserva_titulos_cortos(): void
    {
        $columnas = Catalogo::columnasGrilla(Catalogo::definicion('PROY_RIESGO_PROBLEMA'));

        $this->assertSame('Estrategia', $columnas['TIP_RIESGO_PROB'][0]);
        $this->assertSame('Descripción del riesgo', $columnas['DES_DETALLE'][0]);
    }

    public function test_sin_riesgos_invita_a_registrar_el_primero(): void
    {
        $this->actingAs($this->usuarioGepro(false, 'PROYECTO'));

        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_RIESGO_PROBLEMA', 'de' => $this->contrato(false)])
            ->assertSee('Registra el primero');
    }

    public function test_quien_solo_consulta_no_recibe_la_invitacion(): void
    {
        $usuario = $this->usuarioGepro(true, 'PROYECTO');
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario de solo consulta con esta opción.');
        }
        $this->actingAs($usuario);

        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_RIESGO_PROBLEMA', 'de' => $this->contrato(false)])
            ->assertSee('No hay registros.')
            ->assertDontSee('Registra el primero');
    }

    public function test_el_formulario_de_proyecto_usa_el_lenguaje_nuevo(): void
    {
        $this->actingAs($this->usuarioGepro());

        Livewire::test(ProyectoFormulario::class, ['opcion' => 110])
            ->call('nuevo')
            ->assertSee('Nombre completo del proyecto')
            ->assertSee('Etapa actual del proyecto')
            ->assertSee('Actores clave del proyecto')
            ->assertSee('CUI del Banco de Inversiones')
            ->assertDontSee('Stakeholder')
            ->assertDontSee('III. Objetivos');
    }
}
