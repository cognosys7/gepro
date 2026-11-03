<?php

namespace Tests\Feature;

use App\Livewire\ArchivosAdjuntos;
use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectoContratosTabla;
use App\Support\Archivos;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Archivos adjuntos (GEN_ARCHIVO), cartas fianza (CONTRATO_CONCEPTO), recursos del riesgo y el proceso
 * de adquisicion del contrato. Los archivos se suben a una carpeta temporal, no a SGPAM_archivos.
 */
class ArchivosYConceptosTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    private string $raiz;

    protected function setUp(): void
    {
        parent::setUp();
        $this->raiz = sys_get_temp_dir().DIRECTORY_SEPARATOR.'gepro_archivos_'.uniqid();
        mkdir($this->raiz);
        config(['gepro.archivos.raiz' => $this->raiz]);
    }

    protected function tearDown(): void
    {
        foreach (glob($this->raiz.'/*/*') ?: [] as $f) {
            unlink($f);
        }
        foreach (glob($this->raiz.'/*') ?: [] as $d) {
            rmdir($d);
        }
        rmdir($this->raiz);
        parent::tearDown();
    }

    private function contrato(): string
    {
        return (string) (int) DB::table('dbo.CONTRATO')->where('EST_CONTRATO', '<>', '2')->orderByDesc('IDE_CONTRATO')->value('IDE_CONTRATO');
    }

    public function test_nombre_con_que_se_guarda(): void
    {
        $momento = new \DateTimeImmutable('2026-11-03 14:05:09');
        $this->assertSame('03112026_140509_Carta_fianza_N_1.pdf', Archivos::nombreGuardado('Carta fianza Nº 1.PDF', $momento));
        $this->assertSame('Carta_fianza_N_1.pdf', Archivos::nombreVisible('03112026_140509_Carta_fianza_N_1.pdf'));
        $this->assertLessThanOrEqual(100, strlen(Archivos::nombreGuardado(str_repeat('a', 300).'.xlsx', $momento)));
        //SOLO DENTRO DE SGPAM_archivos/<carpeta>/
        $this->assertNull(Archivos::rutaReal((object) ['DES_RUTA' => '../../otra/', 'DES_ARCHIVO' => 'x.pdf']));
        $this->assertNull(Archivos::rutaReal((object) ['DES_RUTA' => '../../SGPAM_archivos/Contrato/', 'DES_ARCHIVO' => '../x.pdf']));
    }

    public function test_cargar_descargar_reemplazar_y_eliminar(): void
    {
        $usuario = $this->usuarioGepro(false, 'PROYECTO');
        if (! $usuario) {
            $this->markTestSkipped('Ningun usuario puede grabar en proyectos.');
        }
        $this->actingAs($usuario);
        $contrato = $this->contrato();

        Livewire::test(ArchivosAdjuntos::class, ['tabla' => 'CONTRATO', 'registro' => $contrato])
            ->call('nuevo')
            ->set('archivo', UploadedFile::fake()->createWithContent('Contrato firmado.pdf', '%PDF-1.4 prueba'))
            ->call('guardar')->assertHasNoErrors();
        $fila = DB::table('dbo.GEN_ARCHIVO')->where('IDE_TABLA', 'CONTRATO')->where('IDE_REGISTRO', $contrato)->orderByDesc('IDE_ARCHIVO')->first();
        $this->assertSame('../../SGPAM_archivos/Contrato/', $fila->DES_RUTA);
        $this->assertMatchesRegularExpression('/^\d{8}_\d{6}_Contrato_firmado\.pdf$/', $fila->DES_ARCHIVO);
        $this->assertFileExists($this->raiz.'/Contrato/'.$fila->DES_ARCHIVO);

        //DESCARGA CON EL NOMBRE SIN PREFIJO
        $this->get(route('archivos.descargar', ['archivo' => (int) $fila->IDE_ARCHIVO]))
            ->assertOk()->assertDownload('Contrato_firmado.pdf');

        //EDITAR: CAMBIA EL ESTADO SIN TOCAR EL ARCHIVO
        Livewire::test(ArchivosAdjuntos::class, ['tabla' => 'CONTRATO', 'registro' => $contrato])
            ->call('editar', (string) (int) $fila->IDE_ARCHIVO)->set('estado', '3')->call('guardar')->assertHasNoErrors();
        $editado = DB::table('dbo.GEN_ARCHIVO')->where('IDE_ARCHIVO', $fila->IDE_ARCHIVO)->first();
        $this->assertSame('3', trim((string) $editado->EST_ARCHIVO));
        $this->assertSame($fila->DES_ARCHIVO, $editado->DES_ARCHIVO);

        //TIPOS NO PERMITIDOS
        Livewire::test(ArchivosAdjuntos::class, ['tabla' => 'CONTRATO', 'registro' => $contrato])
            ->call('nuevo')->set('archivo', UploadedFile::fake()->createWithContent('script.php', '<?php echo 1;'))
            ->call('guardar')->assertHasErrors('archivo');

        //UN ARCHIVO DE OTRO REGISTRO NO SE ELIMINA DESDE ESTE
        $otro = (string) (int) DB::table('dbo.CONTRATO')->where('IDE_CONTRATO', '<>', $contrato)->value('IDE_CONTRATO');
        Livewire::test(ArchivosAdjuntos::class, ['tabla' => 'CONTRATO', 'registro' => $otro])->call('eliminar', (string) (int) $fila->IDE_ARCHIVO);
        $this->assertNotSame('2', trim((string) DB::table('dbo.GEN_ARCHIVO')->where('IDE_ARCHIVO', $fila->IDE_ARCHIVO)->value('EST_ARCHIVO')));

        Livewire::test(ArchivosAdjuntos::class, ['tabla' => 'CONTRATO', 'registro' => $contrato])->call('eliminar', (string) (int) $fila->IDE_ARCHIVO);
        $this->assertSame('2', trim((string) DB::table('dbo.GEN_ARCHIVO')->where('IDE_ARCHIVO', $fila->IDE_ARCHIVO)->value('EST_ARCHIVO')));
        $this->get(route('archivos.descargar', ['archivo' => (int) $fila->IDE_ARCHIVO]))->assertNotFound();
    }

    public function test_pantalla_y_total_de_archivos(): void
    {
        $u = $this->usuarioGepro(false, 'PROYECTO');
        if (! $u) {
            $this->markTestSkipped('Ningun usuario tiene acceso a proyectos.');
        }
        $registro = (string) (int) DB::table('dbo.GEN_ARCHIVO')->where('IDE_TABLA', 'CONTRATO_CONCEPTO')->where('EST_ARCHIVO', '<>', '2')->value('IDE_REGISTRO');
        $total = DB::table('dbo.GEN_ARCHIVO')->where('IDE_TABLA', 'CONTRATO_CONCEPTO')->where('IDE_REGISTRO', $registro)->where('EST_ARCHIVO', '<>', '2')->count();
        $legado = (int) array_values((array) DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_GEN_ARCHIVO @TipoAccion='Count', @filtro=?", [" AND T.IDE_TABLA='CONTRATO_CONCEPTO' AND T.IDE_REGISTRO=$registro"]))[0];
        $this->assertSame($legado, $total);
        $this->actingAs($u)->get(route('archivos.index', ['tabla' => 'CONTRATO_CONCEPTO', 'registro' => $registro]))
            ->assertOk()->assertSee('Carta fianza del contrato')->assertSeeLivewire(ArchivosAdjuntos::class);
        Livewire::test(ArchivosAdjuntos::class, ['tabla' => 'CONTRATO_CONCEPTO', 'registro' => $registro])
            ->assertViewHas('filas', fn ($f) => $f->total() === $total);
        //TABLAS QUE NO ADMITEN ADJUNTOS
        $this->get('/archivos/seguridad_tsusuario/1')->assertNotFound();
    }

    public function test_cartas_fianza_y_recursos_del_riesgo(): void
    {
        $contrato = (string) (int) DB::table('dbo.CONTRATO_CONCEPTO')->where('EST_CONT_CONCEPTO', '<>', '2')
            ->groupBy('IDE_CONTRATO')->orderByRaw('COUNT(*) DESC')->value('IDE_CONTRATO');
        $legado = (int) array_values((array) DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_CONTRATO_CONCEPTO @TipoAccion='Count', @filtro=?", [" AND T.IDE_CONTRATO=$contrato"]))[0];
        Livewire::test(CatalogoTabla::class, ['pagina' => 'CONTRATO_CONCEPTO', 'de' => $contrato])
            ->assertViewHas('filas', fn ($f) => $f->total() === $legado)
            ->assertSee('/archivos/CONTRATO_CONCEPTO/', false);

        $riesgo = (string) (int) DB::table('dbo.PROY_RIESGO_RECURSO')->where('EST_RECURSO_RIESGO', '<>', '2')->value('IDE_RIESGO_PROB');
        if ($riesgo !== '0') {
            $legado = (int) array_values((array) DB::selectOne("SET NOCOUNT ON; EXEC dbo.SP_PROY_RIESGO_RECURSO @TipoAccion='Count', @filtro=?", [" AND R.IDE_RIESGO_PROB=$riesgo"]))[0];
            Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_RIESGO_RECURSO', 'de' => $riesgo])->assertViewHas('filas', fn ($f) => $f->total() === $legado);
        }

        //REGISTRAR UNA CARTA FIANZA Y UN RECURSO
        $this->actingAs($this->usuarioGepro());
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'CONTRATO_CONCEPTO', 'de' => $contrato])
            ->call('nuevo')
            ->set('datos.TIP_CONCEPTO', '1')
            ->set('datos.COD_TIPO_DOCUMENTO', 'CF-LARAVEL-1')
            ->set('datos.TIP_DOCUMENTO', trim((string) DB::table('dbo.GEN_TABLAS')->where('COD_TABLA', '67')->where('EST_ITEM', 1)->value('COD_ITEM')))
            ->set('datos.IDE_BANCO', (string) DB::table('dbo.GEN_BANCO')->where('EST_BANCO', '1')->value('IDE_BANCO'))
            ->set('datos.IMP_CONCEPTO', '2782969.08')
            ->set('datos.FEC_INICIO', '2026-11-03')
            ->set('datos.FEC_TERMINO', '2027-02-03')
            ->call('guardar')->assertHasNoErrors();
        $this->assertTrue(DB::table('dbo.CONTRATO_CONCEPTO')->where('IDE_CONTRATO', $contrato)->where('COD_TIPO_DOCUMENTO', 'CF-LARAVEL-1')->exists());

        $riesgo = (string) (int) DB::table('dbo.PROY_RIESGO_PROBLEMA')->where('EST_RIESGO', '<>', '2')->value('IDE_RIESGO_PROB');
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_RIESGO_RECURSO', 'de' => $riesgo])
            ->call('nuevo')
            ->set('datos.IDE_RECURSO', (string) DB::table('dbo.GEN_RECURSO')->where('EST_RECURSO', '1')->value('IDE_RECURSO'))
            ->call('guardar')->assertHasNoErrors();
        $this->assertTrue(DB::table('dbo.PROY_RIESGO_RECURSO')->where('IDE_RIESGO_PROB', $riesgo)->exists());
    }

    public function test_proceso_de_adquisicion_del_contrato(): void
    {
        $fila = DB::table('dbo.PROYECTO_ACTIVIDAD as A')->join('dbo.PROC_ITEM as I', 'I.IDE_PROC_ITEM', '=', 'A.IDE_PROCESO_ITEM')
            ->join('dbo.PROCESO as P', 'P.IDE_CONVOCATORIA', '=', 'I.IDE_CONVOCATORIA')->where('P.EST_PROCESO', '<>', '2')
            ->first(['A.IDE_PROYECTO_ACTIVIDAD', 'P.IDE_CONVOCATORIA']);
        if (! $fila) {
            $this->markTestSkipped('No hay contratos con proceso.');
        }
        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROCESO_CONTRATO', 'de' => (string) (int) $fila->IDE_PROYECTO_ACTIVIDAD])
            ->assertViewHas('filas', fn ($f) => $f->total() === 1 && (int) $f->first()->ID === (int) $fila->IDE_CONVOCATORIA)
            ->assertSee('/catalogos/PROC_ITEM?de='.(int) $fila->IDE_CONVOCATORIA, false);

        $tabla = new ProyectoContratosTabla();
        $this->assertSame(route('catalogos.index', ['pagina' => 'PROCESO_CONTRATO', 'de' => 5]),
            $tabla->urlAccion('adquisicion', (object) ['ID' => 5, 'IDE_PROYECTO' => 7, 'IDE_INTERVENCION' => 151, 'IDE_PROCESO_ITEM' => 0]));
    }
}
