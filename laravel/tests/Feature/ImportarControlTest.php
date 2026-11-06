<?php

namespace Tests\Feature;

use App\Livewire\MigrarControlEtapas;
use App\Support\Archivos;
use App\Support\ExcelEtl;
use App\Support\ImportarControl;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use RuntimeException;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Importacion del Excel de control. Las pruebas que graban corren dentro de una transaccion que se
 * revierte (DatabaseTransactions); nunca abren la pagina de importacion del sistema actual.
 */
class ImportarControlTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    /** Contrato con su ultimo Excel disponible en este equipo: [contrato, ruta] */
    private function contratoConExcel(): ?array
    {
        $ultimos = DB::table('dbo.GEN_ARCHIVO')->where('IDE_TABLA', MigrarControlEtapas::TABLA)->where('EST_ARCHIVO', '<>', '2')
            ->selectRaw('IDE_REGISTRO, MAX(IDE_ARCHIVO) AS id')->groupBy('IDE_REGISTRO')->get();
        foreach ($ultimos as $u) {
            $ruta = Archivos::rutaReal(DB::table('dbo.GEN_ARCHIVO')->where('IDE_ARCHIVO', $u->id)->first());
            if ($ruta) {
                return [(int) $u->IDE_REGISTRO, $ruta];
            }
        }

        return null;
    }

    /** Excel de prueba con tres hojas: cada hoja recibe filas [columna A.. => valor] */
    private function excel(array $filas = [], ?string $tituloA = 'CARGAR'): string
    {
        $libro = new Spreadsheet();
        foreach ([0, 1, 2] as $i) {
            $hoja = $i === 0 ? $libro->getActiveSheet() : $libro->createSheet();
            $hoja->setCellValue('A1', $tituloA."\nSI = 1\nNO = 0")->setCellValue('C1', 'CONTRATO');
            foreach ($filas as $n => $fila) {
                $hoja->fromArray($fila, null, 'A'.($n + 2));
            }
        }
        $ruta = tempnam(sys_get_temp_dir(), 'ctrl').'.xlsx';
        (new Xlsx($libro))->save($ruta);
        $this->beforeApplicationDestroyed(fn () => @unlink($ruta));

        return $ruta;
    }

    public function test_rechaza_un_archivo_sin_el_formato_esperado(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('no tiene el formato esperado');
        ImportarControl::leer($this->excel([], 'OTRA COSA'));
    }

    public function test_detecta_lo_que_impide_migrar_sin_grabar_nada(): void
    {
        $antes = DB::table('dbo.etl_OBR_PROG')->count();
        $revision = ImportarControl::revisar(ImportarControl::leer($this->excel([
            ['1', '', 'CONTRATO-QUE-NO-EXISTE', '', '', 'CONCEPTO RARO', '', 1900, 13, '', 'abc', 1.0E+30],
            ['X', '', 'CONTRATO-QUE-NO-EXISTE'],
            ['0', '', 'CONTRATO-QUE-NO-EXISTE'],
        ])), 1);

        $errores = implode(' | ', $revision['errores']);
        $this->assertStringContainsString('no existe en GEPRO', $errores);
        $this->assertStringContainsString('CARGAR debe ser 1 o 0', $errores);
        $this->assertStringContainsString('no se reconoce el concepto', $errores);
        $this->assertStringContainsString('no se reconoce el mes', $errores);
        $this->assertStringContainsString('AVANCE no es un número', $errores);
        $this->assertStringContainsString('MONTO_BRUTO es demasiado grande', $errores);
        $this->assertSame(1, $revision['hojas']['PROG']['omitir']);
        $this->assertSame($antes, DB::table('dbo.etl_OBR_PROG')->count());
    }

    public function test_no_migra_el_excel_de_otro_contrato(): void
    {
        $real = $this->contratoConExcel();
        if (! $real) {
            $this->markTestSkipped('No hay un Excel de control en este equipo.');
        }
        [$contrato, $ruta] = $real;
        $antes = DB::table('dbo.PROY_CONT_COMP_CONTROL_DET')->count();
        $otro = (int) DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', '<>', $contrato)->value('IDE_PROYECTO_ACTIVIDAD');

        try {
            ImportarControl::importar($ruta, $otro);
            $this->fail('Debió rechazar el archivo.');
        } catch (RuntimeException $e) {
            $this->assertStringContainsString('distinto del contrato abierto', $e->getMessage());
        }
        $this->assertSame($antes, DB::table('dbo.PROY_CONT_COMP_CONTROL_DET')->count());
    }

    public function test_migra_el_excel_real_del_contrato(): void
    {
        $real = $this->contratoConExcel();
        if (! $real) {
            $this->markTestSkipped('No hay un Excel de control en este equipo.');
        }
        [$contrato, $ruta] = $real;
        $revision = ImportarControl::revisar(ImportarControl::leer($ruta), $contrato);
        $this->assertSame([], $revision['errores']);

        $resultado = ImportarControl::importar($ruta, $contrato);

        foreach ($resultado as $clave => $hoja) {
            $this->assertSame($revision['hojas'][$clave]['cargar'], $hoja['migradas']);
        }
        //EL DETALLE GRABADO SUMA LAS FILAS DEL ARCHIVO
        $detalle = DB::table('dbo.PROY_CONT_COMP_CONTROL_DET as D')
            ->join('dbo.PROY_CONT_ETAPA_CONTROL as E', 'E.IDE_CONT_ETAPA_CONTROL', '=', 'D.IDE_CONT_ETAPA_CONTROL')
            ->join('dbo.PROY_COMPONENTE as C', 'C.IDE_PROY_COMPONENTE', '=', 'E.IDE_PROY_COMPONENTE')
            ->where('C.IDE_PROYECTO_ACTIVIDAD', $contrato)->where('C.IDE_COMPONENTE', 55)
            ->where('D.EST_ETAPA_CONTROL_DET', '<>', '2')->count();
        $this->assertGreaterThanOrEqual(array_sum(array_column($resultado, 'migradas')), $detalle);
    }

    public function test_si_falla_un_sp_el_mensaje_es_claro(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No se aplicó ningún cambio');
        ExcelEtl::ejecutarSp('sp_que_no_existe');
    }

    public function test_la_pantalla_revisa_antes_de_migrar(): void
    {
        $real = $this->contratoConExcel();
        $usuario = $this->usuarioGepro();
        if (! $real || ! $usuario) {
            $this->markTestSkipped('No hay un Excel de control o un usuario que pueda grabar.');
        }
        $this->actingAs($usuario);

        Livewire::test(MigrarControlEtapas::class, ['contrato' => $real[0]])
            ->assertSee('Revisar archivo')->assertDontSee('Qué hará la migración')
            //SIN REVISAR, EL METODO NO HACE NADA AUNQUE LO LLAMEN DIRECTAMENTE
            ->set('entendido', true)->call('migrar')->assertSet('resultado', null)
            ->call('revisar')->assertSee('Qué hará la migración')->assertSee('Filas a migrar')
            //SIN CONFIRMAR TAMPOCO
            ->call('migrar')->assertSet('resultado', null)
            ->set('entendido', true)->call('migrar')
            ->assertSee('se migró correctamente')->assertSet('revision', null);
    }

    public function test_el_perfil_de_consulta_no_migra(): void
    {
        $real = $this->contratoConExcel();
        $usuario = $this->usuarioGepro(true);
        if (! $real || ! $usuario) {
            $this->markTestSkipped('No hay un Excel de control o un usuario de solo consulta.');
        }
        $this->actingAs($usuario);
        $antes = DB::table('dbo.etl_OBR_PROG')->count();

        Livewire::test(MigrarControlEtapas::class, ['contrato' => $real[0]])
            ->call('revisar')->assertSee('solo consulta')->assertDontSee('Migrando…')
            ->set('entendido', true)->call('migrar')->assertSet('resultado', null);
        $this->assertSame($antes, DB::table('dbo.etl_OBR_PROG')->count());
    }
}
