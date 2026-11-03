<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use App\Livewire\ProyectoContratoFormulario;
use App\Livewire\ProyectoContratosTabla;
use App\Services\Seguridad;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Contratos del proyecto contra BDGEPRO. Las pruebas que graban corren dentro de una transaccion
 * que se revierte (DatabaseTransactions): no queda nada grabado.
 */
class ProyectoContratosTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    /** Proyecto con contratos y con CUI simple (para armar el filtro del SP en la comparacion) */
    private function proyectoConContratos(): object
    {
        $fila = DB::table('dbo.PROYECTO as P')
            ->join('dbo.PROYECTO_ACTIVIDAD as PRY', 'PRY.IDE_PROYECTO', '=', 'P.IDE_PROYECTO')
            ->where('P.EST_PROYECTO', '<>', '2')->where('PRY.EST_PROYECTO_ACTIVIDAD', '<>', '2')
            ->whereRaw("P.COD_UNICO NOT LIKE '%''%'")
            ->groupBy('P.IDE_PROYECTO', 'P.COD_UNICO')
            ->orderByRaw('COUNT(*) DESC')
            ->first(['P.IDE_PROYECTO', 'P.COD_UNICO']);
        if (! $fila) {
            $this->markTestSkipped('No hay proyectos con contratos.');
        }

        return $fila;
    }

    /** Total que cuenta el sistema actual (SP_PROYECTO_ACTIVIDAD 'Count' con el mismo filtro que arma su LN) */
    private function totalSistemaActual(string $cui, string $extra = ''): int
    {
        $filtro = " AND P.COD_UNICO='".$cui."'".$extra;
        $fila = DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_PROYECTO_ACTIVIDAD @TipoAccion='Count', @filtro=?, @pUsuario=0", [$filtro]);

        return (int) $fila->IDE_PROYECTO_ACTIVIDAD;
    }

    private function usuario(): object
    {
        //USUARIO CON PERFIL EN GEPRO QUE PUEDE GRABAR (tests/UsuariosDePrueba.php)
        $u = $this->usuarioGepro();
        if (! $u) {
            $this->markTestSkipped('No hay usuarios con perfil en GEPRO que puedan grabar.');
        }

        return $u;
    }

    public function test_mismo_total_que_el_sistema_actual(): void
    {
        $p = $this->proyectoConContratos();
        Livewire::test(ProyectoContratosTabla::class, ['proyecto' => (int) $p->IDE_PROYECTO, 'opcion' => 211, 'tipo' => 0])
            ->assertViewHas('contratos', fn ($c) => $c->total() === $this->totalSistemaActual((string) $p->COD_UNICO));
        Livewire::test(ProyectoContratosTabla::class, ['proyecto' => (int) $p->IDE_PROYECTO, 'opcion' => 211, 'tipo' => 2])
            ->assertViewHas('contratos', fn ($c) => $c->total() === $this->totalSistemaActual((string) $p->COD_UNICO, ' AND PRY.IDE_INTERVENCION IN ( 151 ) '));
    }

    public function test_acciones_y_edicion_segun_la_opcion(): void
    {
        //CON UN USUARIO QUE PUEDE GRABAR (EL PERFIL "CONSULTA TOTAL" NO VE "NUEVO")
        $this->actingAs($this->usuario());
        $p = $this->proyectoConContratos();
        Livewire::test(ProyectoContratosTabla::class, ['proyecto' => (int) $p->IDE_PROYECTO, 'opcion' => 211, 'tipo' => 0])
            ->assertViewHas('acciones', fn ($a) => array_keys($a) === ['etapas', 'contrato', 'ampliacion', 'interesados', 'migrar'])
            ->assertSee('Pagina=PROY_COMPONENTE', false)
            ->assertSee('Nuevo contrato');
        Livewire::test(ProyectoContratosTabla::class, ['proyecto' => (int) $p->IDE_PROYECTO, 'opcion' => 214, 'tipo' => 0])
            ->assertViewHas('acciones', fn ($a) => array_keys($a) === ['interesados'])
            ->assertDontSee('Nuevo contrato');
    }

    public function test_pagina_con_acceso(): void
    {
        $p = $this->proyectoConContratos();
        $seguridad = app(Seguridad::class);
        $usuario = collect(DB::table('seguridad.tsusuarioperfil')->where('upsestado', 1)->pluck('upsusuario'))
            ->first(function ($id) use ($seguridad) {
                $perfil = $seguridad->perfil((int) $id);

                return $perfil && (new LegadoUserProvider())->retrieveById($id)
                    && $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], 'PROYECTO', ['Opcion' => 211]);
            });
        if (! $usuario) {
            $this->markTestSkipped('Ningún usuario con acceso a la opción 211.');
        }
        $this->actingAs((new LegadoUserProvider())->retrieveById($usuario))
            ->get("/proyectos/{$p->IDE_PROYECTO}/contratos?opcion=211&tipo=2")
            ->assertOk()->assertSee('Contratos de obras')
            ->assertSeeLivewire(ProyectoContratosTabla::class);
    }

    public function test_registrar_eligiendo_contrato_y_eliminar(): void
    {
        $this->actingAs($this->usuario());
        $p = $this->proyectoConContratos();
        $contrato = DB::table('dbo.CONTRATO')->where('EST_CONTRATO', '5')->whereNotNull('COD_UNICO_ORDEN')->first();
        $intervencion = DB::table('dbo.GEN_INTERVENCION')->where('EST_INTERVENCION', '<>', '2')->where('IDE_SECTOR', 14)->where('NUM_NIVEL', 3)->value('IDE_INTERVENCION');

        //ELEGIR UN CONTRATO COPIA SUS DATOS (ESTADO 5 -> 4) Y SU ID VA EN IMP_TRANSFERIDO
        $f = Livewire::test(ProyectoContratoFormulario::class, ['proyecto' => (int) $p->IDE_PROYECTO, 'opcion' => 211])
            ->call('nuevo')
            ->call('elegirContrato', (int) $contrato->IDE_CONTRATO)
            ->assertSet('datos.COD_PROYECTO', trim($contrato->COD_UNICO_ORDEN))
            ->assertSet('datos.IMP_TRANSFERIDO', (string) (int) $contrato->IDE_CONTRATO)
            ->assertSet('datos.EST_PROYECTO_ACTIVIDAD', '4')
            ->set('datos.IDE_INTERVENCION', (string) $intervencion)
            ->set('datos.TIP_PROYECTO_ACTIVIDAD', '27')
            ->set('datos.IMP_INVERSION', '100')
            ->set('datos.IMP_FINANCIADO', '100')
            ->call('guardar')->assertHasNoErrors()->assertDispatched('contrato-guardado');

        //QUEDA ENLAZADO AL PROYECTO Y AL CONTRATO (PROY_CONTRATO LO CREA EL SP)
        $nuevo = DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO', $p->IDE_PROYECTO)->orderByDesc('IDE_PROYECTO_ACTIVIDAD')->first();
        $this->assertSame(trim($contrato->COD_UNICO_ORDEN), trim($nuevo->COD_PROYECTO));
        $this->assertSame('4', trim($nuevo->EST_PROYECTO_ACTIVIDAD));
        $this->assertSame((int) $contrato->IDE_CONTRATO, (int) DB::table('dbo.PROY_CONTRATO')->where('IDE_PROYECTO_ACTIVIDAD', $nuevo->IDE_PROYECTO_ACTIVIDAD)->value('IDE_CONTRATO'));

        //ELIMINAR: SOLO TIPOS 27 A 34 Y SOLO EN LAS OPCIONES QUE EDITAN; ES BAJA LOGICA
        Livewire::test(ProyectoContratosTabla::class, ['proyecto' => (int) $p->IDE_PROYECTO, 'opcion' => 214, 'tipo' => 0])
            ->call('eliminar', (int) $nuevo->IDE_PROYECTO_ACTIVIDAD);
        $this->assertNotSame('2', trim(DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', $nuevo->IDE_PROYECTO_ACTIVIDAD)->value('EST_PROYECTO_ACTIVIDAD')));
        Livewire::test(ProyectoContratosTabla::class, ['proyecto' => (int) $p->IDE_PROYECTO, 'opcion' => 211, 'tipo' => 0])
            ->call('eliminar', (int) $nuevo->IDE_PROYECTO_ACTIVIDAD)->assertDispatched('aviso');
        $this->assertSame('2', trim(DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', $nuevo->IDE_PROYECTO_ACTIVIDAD)->value('EST_PROYECTO_ACTIVIDAD')));
    }

    public function test_contrato_existente_conserva_lo_bloqueado(): void
    {
        $this->actingAs($this->usuario());
        $fila = DB::table('dbo.PROYECTO_ACTIVIDAD')->where('EST_PROYECTO_ACTIVIDAD', '<>', '2')->where('EST_PROYECTO_ACTIVIDAD', '<>', '98')
            ->whereNotNull('IDE_INTERVENCION')->whereNotNull('IMP_INVERSION')->whereNotNull('IMP_FINANCIADO')->whereNotNull('IMP_COSTO_ACTUAL')->first();
        if (! $fila) {
            $this->markTestSkipped('No hay contratos para editar.');
        }
        Livewire::test(ProyectoContratoFormulario::class, ['proyecto' => (int) $fila->IDE_PROYECTO, 'opcion' => 211])
            ->call('editar', (int) $fila->IDE_PROYECTO_ACTIVIDAD)
            ->set('datos.DES_PROYECTO', 'CAMBIADO')
            ->set('datos.DES_UBICACION', 'UBICACION DE PRUEBA')
            ->call('guardar')->assertHasNoErrors();
        $despues = DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', $fila->IDE_PROYECTO_ACTIVIDAD)->first();
        $this->assertSame($fila->DES_PROYECTO, $despues->DES_PROYECTO);
        $this->assertSame('UBICACION DE PRUEBA', $despues->DES_UBICACION);
        $this->assertSame(trim((string) $fila->EST_PROYECTO_ACTIVIDAD), trim((string) $despues->EST_PROYECTO_ACTIVIDAD));
        $this->assertSame((float) $fila->IMP_TRANSFERIDO, (float) $despues->IMP_TRANSFERIDO);
    }
}
