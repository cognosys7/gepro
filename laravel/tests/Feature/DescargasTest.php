<?php

namespace Tests\Feature;

use App\Services\Seguridad;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Descargas de Excel del menu (config/descargas.php) y opciones del menu que aun abren el sistema actual.
 */
class DescargasTest extends TestCase
{
    use UsuariosDePrueba;

    public function test_redirige_al_archivo_si_el_perfil_tiene_la_opcion(): void
    {
        $revisadas = 0;
        foreach (config('descargas') as $pagina => $url) {
            $usuario = $this->usuarioGepro(false, $pagina);
            if (! $usuario) {
                continue;
            }
            $this->actingAs($usuario)->get(route('descargas.index', ['pagina' => $pagina]))->assertRedirect($url);
            $revisadas++;
        }
        $this->assertGreaterThan(0, $revisadas);
    }

    public function test_una_pagina_que_no_es_descarga_no_existe(): void
    {
        $this->actingAs($this->usuarioGepro())->get('/descargas/PROYECTO')->assertNotFound();
    }

    public function test_sin_la_opcion_en_el_perfil_no_descarga(): void
    {
        config(['descargas.PAGINA_QUE_NO_ESTA_EN_EL_MENU' => 'https://ejemplo.invalid/archivo.xlsx']);

        $this->actingAs($this->usuarioGepro())->get('/descargas/PAGINA_QUE_NO_ESTA_EN_EL_MENU')->assertForbidden();
    }

    public function test_la_guia_de_usuario_se_sirve_desde_laravel(): void
    {
        $usuario = $this->usuarioGepro();
        $this->assertSame(route('guia.usuario'), app(Seguridad::class)->url((object) ['IdOpcion' => 1, 'OpcEnlace' => '../../SGPAM_archivos/Manual/E0010_AMSAC_MANUAL_DE_USUARIO.pdf',
            'OpcTipoEnlace' => 2, 'OpcNivel' => 2, 'OpcPadre' => 1]));

        config(['gepro.guia_usuario' => '../CLAUDE.md']);
        $this->actingAs($usuario)->get(route('guia.usuario'))->assertNotFound();

        if (is_file(config('gepro.archivos.raiz').'/Manual/E0010_AMSAC_MANUAL_DE_USUARIO.pdf')) {
            config(['gepro.guia_usuario' => 'Manual/E0010_AMSAC_MANUAL_DE_USUARIO.pdf']);
            $this->actingAs($usuario)->get(route('guia.usuario'))->assertOk()->assertHeader('content-type', 'application/pdf');
        }
    }

    public function test_la_guia_del_menu_de_seguridad_se_sirve_desde_laravel(): void
    {
        $this->assertSame(route('seguridad.guia'), app(Seguridad::class)->urlSeguridad((object) ['OpcEnlace' => '../../SGPAM_archivos/Manual/AMSAC_Manual_Usuario_SGPAM-Seguridad.pdf']));

        $this->get(route('seguridad.guia'))->assertRedirect(route('login'));
    }

    public function test_ninguna_opcion_activa_del_menu_queda_sin_pantalla(): void
    {
        $seguridad = app(Seguridad::class);
        $opciones = DB::table('seguridad.tsopcion as o')->join('seguridad.tsmodulo as m', 'm.idmodulo', '=', 'o.opcmodulo')
            ->where('m.modsistema', $seguridad->sistema())->where('o.opcestado', 1)
            //LOS GRUPOS (OPCIONES CON HIJOS) NO TIENEN ENLACE EN EL MENU
            ->whereNotExists(fn ($q) => $q->from('seguridad.tsopcion as h')->whereColumn('h.opcpadre', 'o.idopcion')->where('h.opcestado', 1))
            ->select('o.IdOpcion', 'o.OpcDescripcion', 'o.OpcEnlace', 'o.OpcTipoEnlace', 'o.OpcNivel', 'o.OpcPadre')->get();
        $this->assertNotEmpty($opciones);

        $pendientes = [];
        foreach ($opciones as $o) {
            if ($seguridad->url($o) === null) {
                $pendientes[] = trim((string) $o->OpcDescripcion).' -> '.trim((string) $o->OpcEnlace);
            }
        }

        $this->assertSame([], $pendientes);
    }
}
