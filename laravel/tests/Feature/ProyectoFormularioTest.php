<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use App\Livewire\ProyectoFormulario;
use App\Livewire\ProyectosTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * Registrar, editar y eliminar proyectos con dbo.SP_PROYECTO. Cada prueba corre dentro de una
 * transaccion que se revierte al terminar (DatabaseTransactions): no queda nada grabado en BDGEPRO.
 */
class ProyectoFormularioTest extends TestCase
{
    use DatabaseTransactions;

    protected $connectionsToTransact = ['sqlsrv'];

    private function usuario(): object
    {
        $id = DB::table('seguridad.tsusuario')->where('usuestado', 1)->orderBy('idusuario')->value('idusuario');
        $u = (new LegadoUserProvider())->retrieveById($id);
        $u ??= collect(DB::table('seguridad.tsusuario')->where('usuestado', 1)->pluck('idusuario'))
            ->map(fn ($i) => (new LegadoUserProvider())->retrieveById($i))->filter()->first();

        return $u;
    }

    private function datosMinimos(string $marca): array
    {
        return [
            'DES_LARGA_PROYECTO' => $marca,
            'IDE_ETAPA_CONTRATO' => (string) DB::table('dbo.GEN_INTERVENCION')->where('EST_INTERVENCION', '<>', '2')->where('IDE_SECTOR', 14)->where('NUM_NIVEL', 3)->value('IDE_INTERVENCION'),
            'IDE_PORTAFOLIO' => (string) DB::table('dbo.GEN_PORTAFOLIO_PROYECTO')->where('EST_PORTAFOLIO', '<>', '2')->value('IDE_PORTAFOLIO'),
            'NUM_PAMS' => '3',
            'IMP_APROBADO_LOC' => '1500.50',
            'FEC_INICIO_PROY' => '2026-01-15',
            'FEC_TERMINO_PROY' => '2026-12-31',
        ];
    }

    public function test_obligatorios(): void
    {
        $this->actingAs($this->usuario());
        Livewire::test(ProyectoFormulario::class, ['opcion' => 110])
            ->call('nuevo')
            ->call('guardar')
            ->assertHasErrors(['datos.DES_LARGA_PROYECTO', 'datos.IDE_ETAPA_CONTRATO', 'datos.IDE_PORTAFOLIO']);
    }

    public function test_fechas_en_orden(): void
    {
        $this->actingAs($this->usuario());
        $datos = $this->datosMinimos('PRUEBA LARAVEL FECHAS');
        $datos['FEC_TERMINO_PROY'] = '2025-01-01';
        $c = Livewire::test(ProyectoFormulario::class, ['opcion' => 110])->call('nuevo');
        foreach ($datos as $k => $v) {
            $c->set('datos.'.$k, $v);
        }
        $c->call('guardar')->assertHasErrors(['datos.FEC_TERMINO_PROY']);
    }

    public function test_registrar_editar_y_eliminar(): void
    {
        $usuario = $this->usuario();
        $this->actingAs($usuario);
        $marca = 'PRUEBA LARAVEL '.uniqid();

        //REGISTRAR: NACE CON ESTADO 98 Y CON EL USUARIO QUE LO REGISTRA
        $c = Livewire::test(ProyectoFormulario::class, ['opcion' => 110])->call('nuevo');
        foreach ($this->datosMinimos($marca) as $k => $v) {
            $c->set('datos.'.$k, $v);
        }
        $c->call('guardar')->assertHasNoErrors()->assertSet('abierto', false)->assertDispatched('proyecto-guardado');
        $fila = DB::table('dbo.PROYECTO')->where('DES_LARGA_PROYECTO', $marca)->first();
        $this->assertNotNull($fila);
        $this->assertSame('98', trim($fila->EST_PROYECTO));
        $this->assertSame((string) $usuario->id, trim((string) $fila->USER_INSERT));
        $this->assertEquals(1500.5, (float) $fila->IMP_APROBADO_LOC);
        $this->assertSame('2026-01-15', substr($fila->FEC_INICIO_PROY, 0, 10));

        //EDITAR: UN PROYECTO PROPIO (98) SE EDITA POR COMPLETO
        Livewire::test(ProyectoFormulario::class, ['opcion' => 110])
            ->call('editar', (int) $fila->IDE_PROYECTO)
            ->assertSet('datos.FEC_INICIO_PROY', '2026-01-15')
            ->set('datos.COD_UNICO', '1234567')
            ->set('datos.DES_LARGA_PROYECTO', $marca.' EDITADO')
            ->call('guardar')->assertHasNoErrors();
        $editado = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $fila->IDE_PROYECTO)->first();
        $this->assertSame('1234567', trim($editado->COD_UNICO));
        $this->assertSame($marca.' EDITADO', $editado->DES_LARGA_PROYECTO);
        $this->assertSame('98', trim($editado->EST_PROYECTO));

        //ELIMINAR: BAJA LOGICA (EST_PROYECTO = '2'), SOLO EN LAS OPCIONES 10 Y 200
        Livewire::test(ProyectosTabla::class, ['opcion' => 110])->call('eliminar', (int) $fila->IDE_PROYECTO);
        $this->assertNotSame('2', trim(DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $fila->IDE_PROYECTO)->value('EST_PROYECTO')));
        Livewire::test(ProyectosTabla::class, ['opcion' => 200])->call('eliminar', (int) $fila->IDE_PROYECTO)->assertDispatched('aviso');
        $this->assertSame('2', trim(DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $fila->IDE_PROYECTO)->value('EST_PROYECTO')));
    }

    public function test_proyecto_no_propio_conserva_los_datos_de_origen(): void
    {
        $this->actingAs($this->usuario());
        $fila = DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '1')->first();
        if (! $fila) {
            $this->markTestSkipped('No hay proyectos en estado 1.');
        }

        //AUNQUE EL NAVEGADOR ENVIE OTRO CODIGO, EL CAMPO BLOQUEADO SE GRABA CON EL VALOR DE LA BASE
        Livewire::test(ProyectoFormulario::class, ['opcion' => 211])
            ->call('editar', (int) $fila->IDE_PROYECTO)
            ->set('datos.COD_INTERNO', 'CAMBIADO')
            ->set('datos.DES_STAKEHOLDER', 'STAKEHOLDER DE PRUEBA')
            ->call('guardar')->assertHasNoErrors();
        $despues = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $fila->IDE_PROYECTO)->first();
        $this->assertSame(trim((string) $fila->COD_INTERNO), trim((string) $despues->COD_INTERNO));
        $this->assertSame('STAKEHOLDER DE PRUEBA', $despues->DES_STAKEHOLDER);
        $this->assertSame('1', trim($despues->EST_PROYECTO));
    }

    public function test_opcion_sin_permiso_no_graba(): void
    {
        $this->actingAs($this->usuario());
        //510 (Comunicaciones) NO PERMITE REGISTRAR NI EDITAR
        Livewire::test(ProyectoFormulario::class, ['opcion' => 510])
            ->call('nuevo')->assertSet('abierto', false)
            ->call('guardar')->assertHasErrors(['general']);
    }
}
