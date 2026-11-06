<?php

namespace Tests\Feature;

use App\Livewire\MigrarInteresados;
use App\Livewire\ProyectosTabla;
use App\Support\ImportarInteresados;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RuntimeException;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Importacion de la matriz de interesados. Lo que graba corre dentro de una transaccion que se revierte
 * (DatabaseTransactions); nunca abre la pagina de importacion del sistema actual.
 */
class ImportarInteresadosTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    /** Matriz real del equipo que se puede migrar: [nombre, ruta] */
    private function matrizReal(): ?array
    {
        $carpeta = rtrim((string) config('gepro.archivos.raiz'), '\\/').DIRECTORY_SEPARATOR.'etl_Interesados';
        foreach (array_reverse(glob($carpeta.DIRECTORY_SEPARATOR.'*.xls*') ?: []) as $ruta) {
            try {
                if (! ImportarInteresados::revisar(ImportarInteresados::leer($ruta), 0)['errores']) {
                    return [basename($ruta), $ruta];
                }
            } catch (RuntimeException) {
                continue;
            }
        }

        return null;
    }

    private function excel(array $filas, string $tituloB = 'COD_UNICO'): string
    {
        $libro = new Spreadsheet();
        $hoja = $libro->getActiveSheet();
        $hoja->setCellValue('A1', 'CARGAR')->setCellValue('B1', $tituloB);
        foreach ($filas as $n => $fila) {
            $hoja->fromArray($fila, null, 'A'.($n + 2));
        }
        $ruta = tempnam(sys_get_temp_dir(), 'int').'.xlsx';
        (new Xlsx($libro))->save($ruta);
        $this->beforeApplicationDestroyed(fn () => @unlink($ruta));

        return $ruta;
    }

    /** Registra la matriz real como el archivo vigente de la entidad */
    private function archivoVigente(array $real): void
    {
        DB::table('dbo.GEN_ARCHIVO')->insert([
            'IDE_TABLA' => MigrarInteresados::TABLA, 'IDE_REGISTRO' => ImportarInteresados::REGISTRO,
            'DES_RUTA' => '../../SGPAM_archivos/etl_Interesados/', 'DES_ARCHIVO' => $real[0],
            'FEC_CARGA' => now()->format('Y-m-d H:i:s'), 'EST_ARCHIVO' => '1',
        ]);
    }

    public function test_rechaza_un_archivo_que_no_es_una_matriz(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('no tiene el formato esperado');
        ImportarInteresados::leer($this->excel([], 'TIPO'));
    }

    public function test_detecta_lo_que_perderia_filas_sin_grabar_nada(): void
    {
        $antes = DB::table('dbo.etl_INTERESADOS')->count();
        $vacios = array_fill(0, 7, '');
        $revision = ImportarInteresados::revisar(ImportarInteresados::leer($this->excel([
            ['1', 'PROYECTO-RARO', 'CONTRATO-RARO', '', 'PERSONA'],
            ['9', 'PROYECTO-RARO', 'CONTRATO-RARO', '', 'PERSONA'],
            ['0', 'PROYECTO-RARO', 'CONTRATO-RARO', '', 'PERSONA'],
            ['1', 'PROYECTO-RARO', 'CONTRATO-RARO', '', ''],
            array_merge(['1', 'PROYECTO-RARO', 'CONTRATO-RARO', '', 'PERSONA'], $vacios, ['', 'FUERTE']),
        ])), 0);

        $errores = implode(' | ', $revision['errores']);
        $this->assertStringContainsString('no se reconoce el proyecto', $errores);
        $this->assertStringContainsString('CARGAR debe ser 0, 1 o 2', $errores);
        $this->assertStringContainsString('falta el nombre del interesado', $errores);
        $this->assertSame(1, $revision['omitir']);
        //UN DATO OPCIONAL FUERA DEL CATALOGO SOLO SE AVISA
        $this->assertStringContainsString('FUERTE', implode(' | ', $revision['avisos']));
        $this->assertSame($antes, DB::table('dbo.etl_INTERESADOS')->count());
    }

    public function test_migra_la_matriz_real_y_repetirla_no_duplica(): void
    {
        $real = $this->matrizReal();
        if (! $real) {
            $this->markTestSkipped('No hay una matriz de interesados válida en este equipo.');
        }
        $revision = ImportarInteresados::revisar(ImportarInteresados::leer($real[1]), 0);
        $total = DB::table('dbo.CONT_INTERESADOS')->count();

        $primera = ImportarInteresados::importar($real[1], 0);

        $this->assertSame($revision['nuevos'], $primera['interesados']);
        $this->assertSame($total + $revision['nuevos'], DB::table('dbo.CONT_INTERESADOS')->count());

        $segunda = ImportarInteresados::importar($real[1], 0);

        $this->assertSame(0, $segunda['interesados']);
        $this->assertSame(0, $segunda['sociales']);
        $this->assertSame($total + $revision['nuevos'], DB::table('dbo.CONT_INTERESADOS')->count());
    }

    public function test_la_pantalla_revisa_antes_de_migrar(): void
    {
        $real = $this->matrizReal();
        $usuario = $this->usuarioGepro();
        if (! $real || ! $usuario) {
            $this->markTestSkipped('No hay una matriz válida o un usuario que pueda grabar.');
        }
        $this->archivoVigente($real);
        $this->actingAs($usuario);

        Livewire::test(MigrarInteresados::class, ['proyecto' => 0])
            ->assertSee('Revisar archivo')->assertDontSee('Qué hará la migración')
            ->set('entendido', true)->call('migrar')->assertSet('resultado', null)
            ->call('revisar')->assertSee('Qué hará la migración')->assertSee('Interesados nuevos')
            ->assertSee('El archivo no incluye el proyecto')
            ->call('migrar')->assertSet('resultado', null)
            ->set('entendido', true)->call('migrar')
            ->assertSee('se migraron correctamente')->assertSet('revision', null);
    }

    public function test_el_perfil_de_consulta_no_migra(): void
    {
        $real = $this->matrizReal();
        $usuario = $this->usuarioGepro(true);
        if (! $real || ! $usuario) {
            $this->markTestSkipped('No hay una matriz válida o un usuario de solo consulta.');
        }
        $this->archivoVigente($real);
        $this->actingAs($usuario);
        $antes = DB::table('dbo.CONT_INTERESADOS')->count();

        Livewire::test(MigrarInteresados::class, ['proyecto' => 0])
            ->call('revisar')->assertSee('solo consulta')
            ->set('entendido', true)->call('migrar')->assertSet('resultado', null);
        $this->assertSame($antes, DB::table('dbo.CONT_INTERESADOS')->count());
    }

    public function test_abre_en_laravel_y_valida_el_acceso(): void
    {
        $tabla = new ProyectosTabla();
        $tabla->opcion = 200;
        $this->assertSame(route('proyectos.migrar-interesados', ['proyecto' => 5, 'opcion' => 200]), $tabla->urlAccion('migrar', (object) ['IDE_PROYECTO' => 5]));

        foreach ([10, 200, 211, 310] as $opcion) {
            $usuario = $this->usuarioGepro(false, 'PROYECTO', ['Opcion' => $opcion]);
            if ($usuario) {
                break;
            }
        }
        if (! $usuario) {
            $this->markTestSkipped('No hay un usuario con la acción de migrar.');
        }
        $proyecto = (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->value('IDE_PROYECTO');
        $this->actingAs($usuario);

        $this->get(route('proyectos.migrar-interesados', ['proyecto' => $proyecto, 'opcion' => $opcion]))->assertOk()->assertSee('sola matriz');
        //OPCION DEL MENU SIN LA ACCION, O PROYECTO QUE NO EXISTE
        $this->get(route('proyectos.migrar-interesados', ['proyecto' => $proyecto, 'opcion' => 110]))->assertNotFound();
        $this->get(route('proyectos.migrar-interesados', ['proyecto' => 0, 'opcion' => $opcion]))->assertNotFound();
        //EL ARCHIVO GENERAL SOLO EXISTE CON EL REGISTRO 1
        $this->get(route('archivos.index', ['tabla' => MigrarInteresados::TABLA, 'registro' => 1]))->assertOk();
        $this->get(route('archivos.index', ['tabla' => MigrarInteresados::TABLA, 'registro' => 2]))->assertNotFound();
    }
}
