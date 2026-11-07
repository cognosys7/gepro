<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Tableros de Power BI del menu (config/tableros.php)
 */
class TablerosTest extends TestCase
{
    use UsuariosDePrueba;

    public function test_muestra_el_reporte_en_un_marco(): void
    {
        foreach (config('tableros') as $pagina => $url) {
            $usuario = $this->usuarioGepro(false, $pagina);
            if (! $usuario) {
                continue;
            }
            $this->actingAs($usuario)->get(route('tableros.index', ['pagina' => $pagina]))
                ->assertOk()
                ->assertSee('<iframe class="gp-tablero-marco" src="'.e($url).'"', false);

            return;
        }
        $this->markTestSkipped('Ningun usuario tiene acceso a un tablero.');
    }

    public function test_formatos_abre_el_tablero_de_cognosys(): void
    {
        $usuario = $this->usuarioGepro(false, 'PBI_PRY_2CONTRATOS');
        if (! $usuario) {
            $this->markTestSkipped('Ningun usuario tiene acceso a Formatos F1, F2, F6.');
        }
        $this->actingAs($usuario)->get(route('tableros.index', ['pagina' => 'PBI_PRY_2CONTRATOS']))
            ->assertOk()
            ->assertSee('Formatos F1, F2, F6')
            ->assertSee('<iframe class="gp-tablero-marco" src="'.e(config('tableros.PBI_PRY_2CONTRATOS')).'"', false);
    }

    public function test_consolidado_abre_el_tablero_de_cognosys(): void
    {
        $usuario = $this->usuarioGepro(false, 'PBI_FINANCIERO_CONSOLIDADO');
        if (! $usuario) {
            $this->markTestSkipped('Ningun usuario tiene acceso a Tab.Fin. Consolidado.');
        }
        $this->actingAs($usuario)->get(route('tableros.index', ['pagina' => 'PBI_FINANCIERO_CONSOLIDADO']))
            ->assertOk()
            ->assertSee('<iframe class="gp-tablero-marco" src="'.e('https://app.powerbi.com/view?r=eyJrIjoiNDJjZWEyMjItMjhlMi00NTUyLWFmYWYtMzMxYjMzMjg3MGY0IiwidCI6IjljOTkwMDYyLTFmMDEtNDE0MC1iY2U2LTcxNDlmMjRkMmM4YSIsImMiOjR9').'"', false);
    }

    public function test_detallado_abre_el_tablero_de_cognosys(): void
    {
        $usuario = $this->usuarioGepro(false, 'PBI_FINANCIERO_DETALLADO');
        if (! $usuario) {
            $this->markTestSkipped('Ningun usuario tiene acceso a Tab.Fin. Detallado.');
        }
        $this->actingAs($usuario)->get(route('tableros.index', ['pagina' => 'PBI_FINANCIERO_DETALLADO']))
            ->assertOk()
            ->assertSee('<iframe class="gp-tablero-marco" src="'.e('https://app.powerbi.com/view?r=eyJrIjoiOWY4MDg4YjEtNjIyMS00NjEzLTk4ZjgtOWVlMzg3ODJkNDU1IiwidCI6IjljOTkwMDYyLTFmMDEtNDE0MC1iY2U2LTcxNDlmMjRkMmM4YSIsImMiOjR9').'"', false);
    }

    public function test_tableros_financieros_abre_el_reporte_siaf(): void
    {
        $usuario = $this->usuarioGepro(false, 'PBI_TABLEROS_SEGUIMIENTO');
        if (! $usuario) {
            $this->markTestSkipped('Ningun usuario tiene acceso a Tableros Financieros.');
        }
        $this->actingAs($usuario)->get(route('tableros.index', ['pagina' => 'PBI_TABLEROS_SEGUIMIENTO']))
            ->assertOk()
            ->assertSee('<iframe class="gp-tablero-marco" src="'.e('https://app.powerbi.com/view?r=eyJrIjoiZGEyMjFkYTMtYmY2Zi00YWU4LThhYjYtYTM1YmRkODlkNmU3IiwidCI6IjljOTkwMDYyLTFmMDEtNDE0MC1iY2U2LTcxNDlmMjRkMmM4YSIsImMiOjR9').'"', false);
    }

    public function test_pagina_que_no_es_tablero(): void
    {
        $usuario = $this->usuarioGepro();
        $this->actingAs($usuario)->get('/tableros/PROYECTO')->assertNotFound();
    }
}
