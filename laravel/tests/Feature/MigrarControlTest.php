<?php

namespace Tests\Feature;

use App\Livewire\MigrarControlEtapas;
use App\Livewire\ProyectoContratosTabla;
use App\Support\Archivos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Pantalla previa a la migracion. Estas pruebas solo leen: NUNCA abren la pagina de importacion del
 * sistema actual, porque corre al abrirla (TRUNCATE de las tablas etl_ y reemplazo del control mensual).
 */
class MigrarControlTest extends TestCase
{
    use UsuariosDePrueba;

    private function contratoConArchivo(): ?int
    {
        $id = DB::table('dbo.GEN_ARCHIVO as A')
            ->join('dbo.PROYECTO_ACTIVIDAD as P', 'P.IDE_PROYECTO_ACTIVIDAD', '=', 'A.IDE_REGISTRO')
            ->where('A.IDE_TABLA', MigrarControlEtapas::TABLA)->where('A.EST_ARCHIVO', '<>', '2')
            ->where('P.EST_PROYECTO_ACTIVIDAD', '<>', '2')->max('P.IDE_PROYECTO_ACTIVIDAD');

        return $id ? (int) $id : null;
    }

    private function opcionConMigrar(object $usuario): ?int
    {
        foreach (ProyectoContratosTabla::POR_OPCION as $opcion => $acciones) {
            if (in_array('migrar', $acciones, true) && $this->usuarioGepro(false, 'PROYECTO', ['Opcion' => $opcion])?->id === $usuario->id) {
                return $opcion;
            }
        }

        return null;
    }

    public function test_abre_en_laravel_desde_los_contratos(): void
    {
        $tabla = new ProyectoContratosTabla();
        $tabla->opcion = 211;
        $url = $tabla->urlAccion('migrar', (object) ['ID' => 5, 'IDE_PROYECTO' => 1, 'IDE_INTERVENCION' => 1, 'IDE_PROCESO_ITEM' => 1]);

        $this->assertSame(route('contratos.migrar-control', ['contrato' => 5, 'opcion' => 211]), $url);
    }

    public function test_muestra_el_ultimo_archivo_y_valida_la_opcion(): void
    {
        $contrato = $this->contratoConArchivo();
        $usuario = $this->usuarioGepro(false, 'PROYECTO', ['Opcion' => 211]) ?? $this->usuarioGepro(false, 'PROYECTO', ['Opcion' => 200]);
        if (! $contrato || ! $usuario) {
            $this->markTestSkipped('No hay un contrato con archivo o un usuario con esa opción.');
        }
        $opcion = $this->opcionConMigrar($usuario);
        $ultimo = DB::table('dbo.GEN_ARCHIVO')->where('IDE_TABLA', MigrarControlEtapas::TABLA)
            ->where('IDE_REGISTRO', $contrato)->where('EST_ARCHIVO', '<>', '2')->orderByDesc('IDE_ARCHIVO')->first();

        $this->actingAs($usuario)->get(route('contratos.migrar-control', ['contrato' => $contrato, 'opcion' => $opcion]))
            ->assertOk()->assertSee(Archivos::nombreVisible((string) $ultimo->DES_ARCHIVO));

        //OPCIONES DEL MENU QUE NO MUESTRAN LA ACCION, O CONTRATO QUE NO EXISTE
        $this->actingAs($usuario)->get(route('contratos.migrar-control', ['contrato' => $contrato, 'opcion' => 110]))->assertNotFound();
        $this->actingAs($usuario)->get(route('contratos.migrar-control', ['contrato' => 0, 'opcion' => $opcion]))->assertNotFound();
    }

    public function test_el_boton_migrar_exige_archivo_y_confirmacion(): void
    {
        $usuario = $this->usuarioGepro();
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario que pueda grabar.');
        }
        $this->actingAs($usuario);

        //SIN ARCHIVO NO SE PUEDE CONFIRMAR NI SE HABILITA EL BOTON
        $sinArchivo = Livewire::test(MigrarControlEtapas::class, ['contrato' => 0])->set('entendido', true);
        $this->assertFalse($sinArchivo->instance()->esImportable($sinArchivo->instance()->archivo()));
        $sinArchivo->assertSee('Cargar archivo');
        $this->assertMatchesRegularExpression('/data-modal-url="[^"]*migrar_Importar_sqlserver[^>]*disabled/s', $sinArchivo->html());

        //AL CERRAR UNA VENTANA SE VUELVE A PEDIR LA CONFIRMACION
        $sinArchivo->dispatch('gepro-modal-cerrada')->assertSet('entendido', false);
    }

    public function test_el_perfil_de_consulta_no_puede_migrar(): void
    {
        $usuario = $this->usuarioGepro(true);
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario de solo consulta.');
        }
        $html = Livewire::actingAs($usuario)->test(MigrarControlEtapas::class, ['contrato' => 0])->html();

        $this->assertFalse(Str::contains($html, 'migrar_Importar_sqlserver'));
        $this->assertStringContainsString('solo consulta', $html);
    }
}
