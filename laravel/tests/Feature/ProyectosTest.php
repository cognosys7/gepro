<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use App\Livewire\ProyectosTabla;
use App\Services\Seguridad;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Grilla de Proyectos contra BDGEPRO (solo lectura).
 */
class ProyectosTest extends TestCase
{
    /** Usuario con acceso a Proyectos con la opcion indicada */
    private function usuarioConAcceso(int $opcion): object
    {
        $seguridad = app(Seguridad::class);
        $ids = DB::table('seguridad.tsusuarioperfil as up')
            ->join('seguridad.tsperfil as pf', 'pf.idperfil', '=', 'up.upsperfil')
            ->join('seguridad.tsmodulo as m', 'm.idmodulo', '=', 'pf.pefmodulo')
            ->join('seguridad.tssistema as s', 's.IdSistema', '=', 'm.modsistema')
            ->where('s.sisabreviatura', 'GEPRO')->where('up.upsestado', 1)->where('pf.pefestado', 1)
            ->orderBy('up.upsusuario')->pluck('up.upsusuario');
        foreach ($ids as $id) {
            $u = (new LegadoUserProvider())->retrieveById($id);
            $p = $u ? $seguridad->perfil((int) $id) : null;
            if ($p && $seguridad->opcionDePagina($p['perfil'], $p['modulo'], 'PROYECTO', ['Opcion' => $opcion])) {
                return $u;
            }
        }
        $this->markTestSkipped("Ningún usuario con acceso a Proyectos (Opcion={$opcion}).");
    }

    /** Proyectos que muestra el sistema actual (misma condicion que SelGrd de SP_PROYECTO) */
    private function totalSistemaActual(): int
    {
        return (int) DB::selectOne("SELECT COUNT(*) AS n FROM dbo.PROYECTO T WHERE T.EST_PROYECTO <> '2' AND T.IDE_PROYECTO IN (SELECT IDE_PROYECTO FROM dbo.FN_PROYECTO(1))")->n;
    }

    public function test_pagina_y_migas(): void
    {
        $usuario = $this->usuarioConAcceso(110);
        $this->actingAs($usuario)->get('/proyectos?opcion=110')
            ->assertOk()
            ->assertSee('Gestión Proyecto')
            ->assertSeeLivewire(ProyectosTabla::class);
    }

    public function test_opcion_desconocida(): void
    {
        $usuario = $this->usuarioConAcceso(110);
        $this->actingAs($usuario)->get('/proyectos?opcion=999')->assertNotFound();
    }

    public function test_mismo_total_que_el_sistema_actual(): void
    {
        $total = $this->totalSistemaActual();
        Livewire::test(ProyectosTabla::class, ['opcion' => 110])
            ->assertViewHas('proyectos', fn ($p) => $p->total() === $total);
    }

    public function test_busqueda_con_caracteres_especiales(): void
    {
        $fila = DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->whereNotNull('COD_UNICO')->where('COD_UNICO', '<>', '')->first();
        Livewire::test(ProyectosTabla::class, ['opcion' => 110])
            ->set('buscar', trim($fila->COD_UNICO))
            ->assertViewHas('proyectos', fn ($p) => $p->total() >= 1)
            ->set('buscar', "x' OR 1=1 --")
            ->assertViewHas('proyectos', fn ($p) => $p->total() === 0);
    }

    public function test_orden_antes_de_paginar(): void
    {
        //EL PRIMERO EN ORDEN DESCENDENTE DEBE SER EL MAYOR DE TODOS, NO SOLO DE LA PRIMERA PAGINA
        $mayor = DB::selectOne("SELECT MAX(COD_INTERNO) AS c FROM dbo.PROYECTO T WHERE T.EST_PROYECTO <> '2' AND T.IDE_PROYECTO IN (SELECT IDE_PROYECTO FROM dbo.FN_PROYECTO(1))")->c;
        //EL ORDEN INICIAL ES COD_INTERNO ASCENDENTE: UN CLIC LO PASA A DESCENDENTE
        Livewire::test(ProyectosTabla::class, ['opcion' => 110])
            ->call('ordenarPor', 'COD_INTERNO')
            ->assertSet('direccion', 'desc')
            ->assertViewHas('proyectos', fn ($p) => $p->items()[0]->COD_INTERNO === $mayor);
    }

    public function test_orden_solo_por_columnas_permitidas(): void
    {
        Livewire::test(ProyectosTabla::class, ['opcion' => 110])
            ->call('ordenarPor', 'IDE_PROYECTO; DROP TABLE X')
            ->assertSet('orden', 'COD_INTERNO');
    }

    public function test_acciones_segun_la_opcion(): void
    {
        Livewire::test(ProyectosTabla::class, ['opcion' => 211])
            ->assertViewHas('acciones', fn ($a) => array_keys($a) === ProyectosTabla::POR_OPCION[211])
            ->assertSee('Pagina=PROYECTO_ACTIVIDAD', false)
            ->assertSee('Pfiltro=2', false);
        Livewire::test(ProyectosTabla::class, ['opcion' => 510])
            ->assertViewHas('acciones', fn ($a) => array_keys($a) === ['comunicacion']);
    }
}
