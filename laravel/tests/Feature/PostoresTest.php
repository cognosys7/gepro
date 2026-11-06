<?php

namespace Tests\Feature;

use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Postores del item (PROC_POSTORES) contra BDGEPRO. Lo que graba corre dentro de una transaccion que
 * se revierte (DatabaseTransactions).
 */
class PostoresTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    private function item(): object
    {
        return DB::table('dbo.PROC_ITEM')->where('EST_PROCESO_ITEM', '<>', '2')->whereNotNull('IMP_VAL_REFERENCIAL_ITEM')->orderByDesc('IDE_PROC_ITEM')->first();
    }

    public function test_el_item_abre_sus_postores_en_laravel(): void
    {
        $item = $this->item();
        $accion = collect(config('catalogos.PROC_ITEM.acciones'))->firstWhere(0, 'Postores');
        $this->actingAs($this->usuarioGepro());

        $url = Livewire::test(CatalogoTabla::class, ['pagina' => 'PROC_ITEM', 'de' => trim((string) $item->IDE_CONVOCATORIA)])->instance()
            ->urlAccion($accion[4], (object) ['ID' => (int) $item->IDE_PROC_ITEM]);

        $this->assertSame(route('catalogos.index', ['pagina' => 'PROC_POSTORES', 'de' => (int) $item->IDE_PROC_ITEM]), $url);
    }

    public function test_mismo_total_que_el_sistema_actual(): void
    {
        $this->actingAs($this->usuarioGepro());
        foreach (DB::table('dbo.PROC_POSTORES')->distinct()->pluck('IDE_PROC_ITEM') as $item) {
            if (! DB::table('dbo.PROC_ITEM')->where('IDE_PROC_ITEM', $item)->exists()) {
                continue;
            }
            $total = (int) array_values((array) DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_PROC_POSTORES @TipoAccion = 'Count', @filtro = ?", [' AND PP.IDE_PROC_ITEM='.(int) $item]))[0];
            Livewire::test(CatalogoTabla::class, ['pagina' => 'PROC_POSTORES', 'de' => (int) $item])
                ->assertViewHas('filas', fn ($f) => $f->total() === $total);
        }
    }

    public function test_registra_edita_y_elimina_un_postor(): void
    {
        $item = $this->item();
        $de = (int) $item->IDE_PROC_ITEM;
        $this->actingAs($this->usuarioGepro());

        $formulario = Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROC_POSTORES', 'de' => $de])->call('nuevo');
        //EL VALOR REFERENCIAL SE PROPONE DESDE EL ITEM
        $this->assertEquals((float) $item->IMP_VAL_REFERENCIAL_ITEM, (float) $formulario->get('datos.VAL_REFERENCIAL_ITEM'));

        $formulario->set('datos.RUC_POSTOR', '20555077999')->set('datos.DES_POSTOR', 'POSTOR DE PRUEBA SAC')->set('datos.TIP_POSTOR', '1')
            ->set('datos.VAL_OFERTADO_ITEM', '1500.50')->set('datos.FEC_REG_PROPUESTA', '2026-02-10')->call('guardar')->assertHasNoErrors()->assertSet('abierto', false);
        $fila = DB::table('dbo.PROC_POSTORES')->where('IDE_PROC_ITEM', $de)->where('RUC_POSTOR', '20555077999')->first();
        $this->assertNotNull($fila);
        $this->assertEquals(1500.5, (float) $fila->VAL_OFERTADO_ITEM);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROC_POSTORES', 'de' => $de])->call('editar', (string) (int) $fila->IDE_POSTOR)
            ->set('datos.DES_POSTOR', 'POSTOR EDITADO SAC')->call('guardar')->assertHasNoErrors();
        $this->assertSame('POSTOR EDITADO SAC', DB::table('dbo.PROC_POSTORES')->where('IDE_POSTOR', $fila->IDE_POSTOR)->value('DES_POSTOR'));

        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROC_POSTORES', 'de' => $de])->call('eliminar', (string) (int) $fila->IDE_POSTOR);
        $this->assertSame('2', trim((string) DB::table('dbo.PROC_POSTORES')->where('IDE_POSTOR', $fila->IDE_POSTOR)->value('EST_POSTOR')));
    }

    public function test_exige_lo_obligatorio_y_el_largo_del_sp(): void
    {
        $de = (int) $this->item()->IDE_PROC_ITEM;
        $this->actingAs($this->usuarioGepro());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROC_POSTORES', 'de' => $de])->call('nuevo')
            ->set('datos.VAL_REFERENCIAL_ITEM', '')->call('guardar')
            ->assertHasErrors(['datos.RUC_POSTOR', 'datos.DES_POSTOR', 'datos.TIP_POSTOR', 'datos.VAL_REFERENCIAL_ITEM']);

        //EL PARAMETRO DEL SP ES varchar(150), AUNQUE LA COLUMNA TENGA 300
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROC_POSTORES', 'de' => $de])->call('nuevo')
            ->set('datos.DES_POSTOR', str_repeat('A', 151))->call('guardar')->assertHasErrors('datos.DES_POSTOR');
    }

    public function test_el_perfil_de_consulta_no_graba(): void
    {
        $usuario = $this->usuarioGepro(true);
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario de solo consulta.');
        }
        $this->actingAs($usuario);

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROC_POSTORES', 'de' => (int) $this->item()->IDE_PROC_ITEM])->call('nuevo')->assertSet('abierto', false);
    }
}
