<?php

namespace Tests\Feature;

use App\Livewire\CatalogoTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Gasto consolidado del contrato. La vista dbo.BIDM_GASTO_CONSOLIDA lee un data mart que no existe en este
 * servidor: las pruebas la reemplazan por una tabla temporal con sus columnas, en la misma conexion.
 */
class GastosTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    private const ORIGEN = '#GASTO_PRUEBA';

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->usuarioGepro());

        DB::unprepared('CREATE TABLE '.self::ORIGEN.' (IDE_BIDM_GASTO_CONSOLIDA bigint, EST_BIDM_GASTO_CONSOLIDA varchar(1), AsientoPeriodo nvarchar(255), AsientoIde nvarchar(255),
            AsientoNumDocumento nvarchar(255), AsientoMontoSoles numeric(18,2), ContratoOrden nvarchar(255), OrdenCodigo nvarchar(255), ActorNombre nvarchar(255),
            Componente nvarchar(255), ProyectoNombreCorto nvarchar(255), FuenteAbrev nvarchar(255), CtaNomPartida nvarchar(255))');
        config(['catalogos.BIDM_GASTO_CONSOLIDA.tabla' => self::ORIGEN]);

        foreach ([
            [1, '202201', 'GL-C-059-2022', 'O-1', 1000.10, 'PROVEEDOR UNO'],
            [2, '202202', ' GL-C-059-2022 ', 'O-2', 250.25, 'PROVEEDOR DOS'],
            [3, '202203', 'OTRO-CONTRATO', 'O-77', 40.00, 'PROVEEDOR TRES'],
            [4, '202204', 'OTRO-CONTRATO', 'O-78', 60.00, 'PROVEEDOR CUATRO'],
            [5, '202205', 'SIN-ORDEN', '', 999.00, 'PROVEEDOR SIN ORDEN'],
        ] as [$id, $periodo, $contrato, $orden, $monto, $proveedor]) {
            DB::table(self::ORIGEN)->insert(['IDE_BIDM_GASTO_CONSOLIDA' => $id, 'EST_BIDM_GASTO_CONSOLIDA' => '1', 'AsientoPeriodo' => $periodo, 'ContratoOrden' => $contrato,
                'OrdenCodigo' => $orden, 'AsientoMontoSoles' => $monto, 'ActorNombre' => $proveedor]);
        }
    }

    private function contrato(?string $entidad, ?string $orden): int
    {
        $id = (int) DB::table('dbo.CONTRATO')->max('IDE_CONTRATO');
        DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', $id)->update(['COD_CONTRATO_ENTIDAD' => $entidad, 'COD_ORDEN' => $orden]);

        return $id;
    }

    private function ids($componente): array
    {
        return collect($componente->viewData('filas')->items())->pluck('ID')->map(fn ($v) => (int) $v)->sort()->values()->all();
    }

    public function test_el_contrato_abre_sus_gastos_en_laravel(): void
    {
        $accion = collect(config('catalogos.CONTRATO.acciones'))->firstWhere(0, 'Gastos');

        $this->assertSame(['catalogo' => 'BIDM_GASTO_CONSOLIDA'], $accion[4]);
    }

    public function test_un_contrato_gl_se_busca_por_su_documento_interno(): void
    {
        $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato('GL-C-059-2022', 'O-77')]);

        $this->assertSame([1, 2], $this->ids($tabla));
        $this->assertEquals(1250.35, (float) $tabla->viewData('suma'));
        $tabla->assertSee('Monto total: S/ 1,250.35')->assertSee('1,000.10');
    }

    public function test_los_demas_contratos_se_buscan_por_su_orden(): void
    {
        $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato('OS-2023-0003', ' O-77 ')]);
        $this->assertSame([3], $this->ids($tabla));

        //SIN DOCUMENTO INTERNO TAMBIEN SE BUSCA POR LA ORDEN
        $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato(null, 'O-78')]);
        $this->assertSame([4], $this->ids($tabla));
    }

    public function test_un_contrato_sin_orden_no_trae_los_gastos_sin_orden(): void
    {
        foreach (['', null] as $orden) {
            $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato('OS-2023-0003', $orden)]);
            $this->assertSame([], $this->ids($tabla));
            $this->assertEquals(0, (float) $tabla->viewData('suma'));
        }
    }

    public function test_la_busqueda_no_cambia_el_monto_total(): void
    {
        $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato('GL-C-059-2022', null)])->set('buscar', 'PROVEEDOR DOS');

        $this->assertSame([2], $this->ids($tabla));
        $this->assertEquals(1250.35, (float) $tabla->viewData('suma'));

        //EL MONTO TAMBIEN SE BUSCA
        $this->assertSame([1], $this->ids($tabla->set('buscar', '1000.1')));
    }

    public function test_es_solo_consulta(): void
    {
        $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato('GL-C-059-2022', null)]);

        $this->assertFalse($tabla->instance()->puede('nuevo'));
        $this->assertFalse($tabla->instance()->puede('editar'));
        $this->assertFalse($tabla->instance()->puede('eliminar'));
        $tabla->assertDontSee('Acciones');
    }

    public function test_avisa_si_no_existe_el_origen(): void
    {
        config(['catalogos.BIDM_GASTO_CONSOLIDA.tabla' => 'dbo.BIDM_GASTO_CONSOLIDA']);

        Livewire::test(CatalogoTabla::class, ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato('GL-C-059-2022', null)])
            ->assertOk()->assertSee('El gasto consolidado no está disponible');
    }

    public function test_la_pantalla_abre_con_la_vista_real(): void
    {
        config(['catalogos.BIDM_GASTO_CONSOLIDA.tabla' => 'dbo.BIDM_GASTO_CONSOLIDA']);

        $this->get(route('catalogos.index', ['pagina' => 'BIDM_GASTO_CONSOLIDA', 'de' => $this->contrato('GL-C-059-2022', null)]))
            ->assertOk()->assertSee('Gasto consolidado del contrato')->assertSee('GL-C-059-2022');
    }

    public function test_otro_catalogo_no_oculta_un_error_de_la_base(): void
    {
        config(['catalogos.GEN_BANCO.tabla' => 'dbo.TABLA_QUE_NO_EXISTE']);

        $this->expectExceptionMessage('TABLA_QUE_NO_EXISTE');
        Livewire::test(CatalogoTabla::class, ['pagina' => 'GEN_BANCO']);
    }
}
