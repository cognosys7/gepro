<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Las acciones de Livewire vuelven a validar el perfil de GEPRO (middleware persistente).
 * Se usa una peticion real a la ruta de Livewire porque Livewire::test no aplica estos filtros.
 * La baja del perfil corre dentro de una transaccion que se revierte (DatabaseTransactions).
 */
class AccesoLivewireTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    /** Abre Proyectos y devuelve el snapshot de su grilla, como lo haria el navegador */
    private function snapshotDeLaGrilla(object $usuario): string
    {
        $html = $this->actingAs($usuario)->get(route('proyectos.index', ['opcion' => 110]))->assertOk()->getContent();
        preg_match_all('/wire:snapshot="([^"]+)"/', $html, $coincidencias);
        foreach ($coincidencias[1] as $crudo) {
            $snapshot = html_entity_decode($crudo, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if ((json_decode($snapshot, true)['memo']['name'] ?? '') === 'proyectos-tabla') {
                return $snapshot;
            }
        }
        $this->fail('La pantalla no trae el componente proyectos-tabla.');
    }

    /** Da de baja el perfil; cada peticion real empieza sin el perfil guardado en Seguridad */
    private function quitarPerfil(object $usuario): void
    {
        DB::table('seguridad.tsusuarioperfil')->where('upsusuario', (int) $usuario->id)->update(['upsestado' => 0]);
        $this->app->forgetScopedInstances();
    }

    private function accion(string $snapshot)
    {
        return $this->withHeaders(['X-Livewire' => '1'])->postJson(route('default-livewire.update'), [
            '_token' => csrf_token(),
            'components' => [['snapshot' => $snapshot, 'updates' => ['buscar' => 'a'], 'calls' => []]],
        ]);
    }

    public function test_con_perfil_la_accion_de_livewire_responde(): void
    {
        $usuario = $this->usuarioGepro(false, 'PROYECTO', ['Opcion' => 110]);
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario con acceso a Proyectos.');
        }

        $this->accion($this->snapshotDeLaGrilla($usuario))->assertOk();
    }

    /** Solo una accion por prueba: Livewire no repite los filtros de la misma ruta en un mismo proceso */
    public function test_sin_perfil_la_accion_de_livewire_no_pasa(): void
    {
        $usuario = $this->usuarioGepro(false, 'PROYECTO', ['Opcion' => 110]);
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario con acceso a Proyectos.');
        }
        $snapshot = $this->snapshotDeLaGrilla($usuario);

        //SE LE QUITA EL PERFIL CON LA PANTALLA ABIERTA
        $this->quitarPerfil($usuario);
        $this->accion($snapshot)->assertForbidden();
        $this->assertGuest();
    }

    public function test_sin_perfil_la_pagina_sigue_llevando_al_ingreso(): void
    {
        $usuario = $this->usuarioGepro(false, 'PROYECTO', ['Opcion' => 110]);
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario con acceso a Proyectos.');
        }
        $this->quitarPerfil($usuario);

        $this->actingAs($usuario)->get(route('proyectos.index', ['opcion' => 110]))->assertRedirect(route('login'));
    }

    public function test_salir_cierra_la_sesion(): void
    {
        $usuario = $this->usuarioGepro();
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario con perfil en GEPRO.');
        }

        $this->actingAs($usuario)->post(route('salir'))->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
