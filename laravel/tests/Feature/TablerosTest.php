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

    public function test_pagina_que_no_es_tablero(): void
    {
        $usuario = $this->usuarioGepro();
        $this->actingAs($usuario)->get('/tableros/PROYECTO')->assertNotFound();
    }
}
