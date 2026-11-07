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
            ->assertSee('Anticipe lo que puede retrasar')
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

    public function test_cada_texto_guia_apunta_a_algo_que_existe(): void
    {
        foreach (config('formularios') as $pagina => $guia) {
            $this->assertArrayHasKey($pagina, config('catalogos'), "{$pagina} no es un catálogo");
            $def = config('catalogos.'.$pagina);
            foreach ($guia['campos'] ?? [] as $campo => $texto) {
                $this->assertArrayHasKey($campo, $def['campos'], "{$pagina}.{$campo} no existe");
                //CON 'segun' LA ETIQUETA CAMBIA CON LO ELEGIDO Y NO SE PUEDE REEMPLAZAR AQUI
                $this->assertFalse(! empty($def['segun']) && is_array($texto) && isset($texto['etiqueta']), "{$pagina}.{$campo}");
            }
            //LOS PASOS SIGUIENTES CITAN ACCIONES REALES DE LA GRILLA
            preg_match_all('/«([^»]+)»/u', $guia['siguiente'] ?? '', $m);
            $acciones = array_map(fn ($a) => $a[3] ?? '', $def['acciones'] ?? []);
            foreach ($m[1] as $accion) {
                $this->assertContains($accion, $acciones, $pagina);
            }
        }
    }

    public function test_todas_las_pantallas_explican_para_que_sirven(): void
    {
        foreach (array_keys(config('catalogos')) as $pagina) {
            $def = Catalogo::definicion($pagina);
            $this->assertNotEmpty($def['descripcion'] ?? null, "{$pagina} sin descripción");
            if (! empty($def['nuevo']) || ! empty($def['editar'])) {
                $this->assertNotEmpty($def['mensajes']['actualizado'] ?? null, "{$pagina} sin mensajes");
            }
        }
    }

    public function test_arma_los_mensajes_con_el_genero_correcto(): void
    {
        $this->assertSame('Queja actualizada.', Catalogo::definicion('PROY_GESTION_QUEJAS')['mensajes']['actualizado']);
        $this->assertSame('Banco actualizado.', Catalogo::definicion('GEN_BANCO')['mensajes']['actualizado']);
        $this->assertStringContainsString('Registre la primera', Catalogo::definicion('PROY_GESTION_QUEJAS')['vacio']);
        $this->assertStringContainsString('Agregue sus postores', Catalogo::definicion('PROC_ITEM')['mensajes']['creado']);
    }

    public function test_cambiar_una_etiqueta_no_cambia_el_titulo_de_la_grilla(): void
    {
        $def = Catalogo::definicion('CONTRATO');

        $this->assertSame('Código de orden', $def['campos']['COD_UNICO_ORDEN'][0]);
        $this->assertSame('Cód. orden', Catalogo::columnasGrilla($def)['COD_UNICO_ORDEN'][0]);
    }

    public function test_el_contrato_del_proyecto_dice_que_falta(): void
    {
        $proyecto = (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->value('IDE_PROYECTO');
        $this->actingAs($this->usuarioGepro(false, 'PROYECTO'));

        Livewire::test(\App\Livewire\ProyectoContratoFormulario::class, ['proyecto' => $proyecto, 'opcion' => 211])
            ->call('nuevo')
            ->call('guardar')
            ->assertSee('Falta revisar')
            ->assertDontSee('Revise los campos marcados');
    }

    public function test_un_texto_largo_se_abre_mostrando_su_contenido_en_un_modal_ancho(): void
    {
        $fila = DB::table('dbo.PROY_ACCION_GESTION')->where('EST_ACCION', '<>', '2')->orderByRaw('LEN(DES_ACCION) DESC')->first();
        $this->assertGreaterThan(1600, mb_strlen($fila->DES_ACCION));
        $this->actingAs($this->usuarioGepro(false, 'PROYECTO'));

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_ACCION_GESTION', 'de' => (int) $fila->IDE_PROYECTO])
            ->call('editar', (int) $fila->IDE_PROY_ACCION_GESTION)
            ->assertSeeHtml('rows="16"')
            ->assertDontSeeHtml('fm-panel-angosto');
    }

    public function test_un_texto_corto_no_estira_el_campo_ni_el_modal(): void
    {
        $fila = DB::table('dbo.GEN_CARGO')->where('EST_CARGO', '<>', '2')->orderByRaw('LEN(DES_CARGO)')->first();
        $this->actingAs($this->usuarioGepro(false, 'GEN_CARGO'));

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'GEN_CARGO'])
            ->call('editar', (int) $fila->IDE_CARGO)
            ->assertSeeHtml('rows="2"')
            ->assertSeeHtml('fm-panel-angosto');
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
            ->assertSee('Registre el primero');
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
            ->assertDontSee('Registre el primero');
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
