<?php

namespace Tests\Feature;

use App\Livewire\CatalogoFormulario;
use App\Livewire\CatalogoTabla;
use App\Livewire\ProyectosTabla;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Lugares beneficiados y Gestion social del proyecto (con sus beneficios, interesados, quejas y
 * actividades), contra BDGEPRO. Lo que graba se revierte.
 */
class GestionSocialTest extends TestCase
{
    use DatabaseTransactions;
    use UsuariosDePrueba;

    protected $connectionsToTransact = ['sqlsrv'];

    /** Pagina => [columna "de", columna de estado] */
    private const PANTALLAS = [
        'PROY_ACT_UBIGEO' => ['IDE_PROYECTO_ACTIVIDAD', 'EST_PROY_ACT_UBIGEO'],
        'PROY_GESTION_SOCIAL' => ['IDE_PROYECTO', 'EST_GESTION_SOCIAL'],
        'PROY_GESTION_BENEFICIOS' => ['IDE_GESTION_SOCIAL', 'EST_BENEF_SOCIAL'],
        'PROY_INTERESADOS_SOCIAL' => ['IDE_GESTION_SOCIAL', 'EST_INTERESADO_SOCIAL'],
        'PROY_GESTION_QUEJAS' => ['IDE_GESTION_SOCIAL', 'EST_QUEJA'],
        'PROY_GESTION_ACTIVIDADES' => ['IDE_GESTION_SOCIAL', 'EST_ACTIVIDAD'],
    ];

    private function conMasFilas(string $pagina): string
    {
        [$columna, $estado] = self::PANTALLAS[$pagina];

        return (string) (int) DB::table('dbo.'.$pagina)->where($estado, '<>', '2')->groupBy($columna)->orderByRaw('COUNT(*) DESC')->value($columna);
    }

    /** La grilla lista las mismas filas que su SelGrd: las del registro "de" que no estan eliminadas */
    public function test_mismos_registros_que_el_sistema_actual(): void
    {
        foreach (self::PANTALLAS as $pagina => [$columna, $estado]) {
            $de = $this->conMasFilas($pagina);
            $esperado = DB::table('dbo.'.$pagina)->where($columna, $de)->where($estado, '<>', '2')->count();
            $this->assertGreaterThan(0, $esperado, $pagina);
            Livewire::test(CatalogoTabla::class, ['pagina' => $pagina, 'de' => $de, 'porPagina' => 100])
                ->assertViewHas('filas', fn ($f) => $f->total() === $esperado);
        }
    }

    public function test_grillas_con_descripciones_y_busqueda(): void
    {
        $g = DB::table('dbo.PROY_GESTION_SOCIAL as S')->join('dbo.GEN_COMUNIDAD as C', 'C.IDE_COMUNIDAD', '=', 'S.IDE_COMUNIDAD')
            ->where('S.EST_GESTION_SOCIAL', '<>', '2')->select('S.IDE_PROYECTO', 'C.DES_COMUNIDAD')->first();
        $tabla = Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_GESTION_SOCIAL', 'de' => (string) (int) $g->IDE_PROYECTO])
            ->assertSee(trim($g->DES_COMUNIDAD));
        $tabla->set('buscar', 'TEXTO QUE NO EXISTE XYZ')->assertViewHas('filas', fn ($f) => $f->total() === 0);
        $tabla->set('buscar', trim($g->DES_COMUNIDAD))->assertViewHas('filas', fn ($f) => $f->total() > 0);

        //EL TEXTO DE MAS DE 40 LETRAS TAMBIEN SE ENCUENTRA EN LAS COLUMNAS CALCULADAS
        $largo = DB::table('dbo.PROY_GESTION_SOCIAL as S')->join('dbo.GEN_COMUNIDAD as C', 'C.IDE_COMUNIDAD', '=', 'S.IDE_COMUNIDAD')
            ->where('S.EST_GESTION_SOCIAL', '<>', '2')->whereRaw('LEN(C.DES_COMUNIDAD) > 45')->select('S.IDE_PROYECTO', 'C.DES_COMUNIDAD')->first();
        if ($largo) {
            Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_GESTION_SOCIAL', 'de' => (string) (int) $largo->IDE_PROYECTO])
                ->set('buscar', substr(trim($largo->DES_COMUNIDAD), -6))->assertViewHas('filas', fn ($f) => $f->total() > 0);
        }
    }

    public function test_buscador_de_ubigeo_rellena_las_coordenadas(): void
    {
        $this->actingAs($this->usuarioGepro());
        $proyecto = (string) (int) DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->orderByDesc('IDE_PROYECTO')->value('IDE_PROYECTO');
        $f = Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_ACT_UBIGEO', 'de' => $proyecto])->call('nuevo')
            ->set('buscando.COD_UBIGEO', 'yauyos tomas')->assertSee('151030');
        $f->call('elegir', 'COD_UBIGEO', '151030')
            ->assertSet('datos.COD_UBIGEO', '151030')
            ->assertSet('datos.GEO_LONGITUD_UBICACION', '-75.74615')
            ->assertSet('datos.GEO_LATITUD_UBICACION', '-12.23733')
            ->call('guardar')->assertHasNoErrors();
        $fila = DB::table('dbo.PROY_ACT_UBIGEO')->where('IDE_PROYECTO_ACTIVIDAD', $proyecto)->orderByDesc('IDE_PROY_ACT_UBIGEO')->first();
        $this->assertSame('151030', trim($fila->COD_UBIGEO));
        $this->assertSame('-75.74615', trim($fila->GEO_LONGITUD_UBICACION));

        //UN CODIGO QUE NO ESTA EN LA LISTA NO SE ACEPTA (NI ENVIANDOLO DIRECTO)
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_ACT_UBIGEO', 'de' => $proyecto])->call('nuevo')
            ->call('elegir', 'COD_UBIGEO', 'NOEXISTE')->assertSet('datos.COD_UBIGEO', '')
            ->set('datos.COD_UBIGEO', 'NOEXISTE')->call('guardar')->assertHasErrors('datos.COD_UBIGEO');
    }

    public function test_lugar_a_nivel_de_provincia_se_conserva_al_editar(): void
    {
        $this->actingAs($this->usuarioGepro());
        $fila = DB::table('dbo.PROY_ACT_UBIGEO')->where('COD_UBIGEO', '2101')->where('EST_PROY_ACT_UBIGEO', '<>', '2')->first();
        if (! $fila) {
            $this->markTestSkipped('No hay lugares a nivel de provincia.');
        }
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_ACT_UBIGEO', 'de' => (string) (int) $fila->IDE_PROYECTO_ACTIVIDAD])
            ->call('editar', (string) (int) $fila->IDE_PROY_ACT_UBIGEO)
            ->assertSet('datos.COD_UBIGEO', '2101')->call('guardar')->assertHasNoErrors();
        $this->assertSame('2101', trim((string) DB::table('dbo.PROY_ACT_UBIGEO')->where('IDE_PROY_ACT_UBIGEO', $fila->IDE_PROY_ACT_UBIGEO)->value('COD_UBIGEO')));
    }

    public function test_registrar_gestion_social_y_sus_hijas(): void
    {
        $this->actingAs($this->usuarioGepro());
        //UN PROYECTO QUE TIENE INTERESADOS EN SUS CONTRATOS
        $datos = DB::selectOne("SELECT TOP 1 PA.IDE_PROYECTO AS P, CI.IDE_CONT_INTERESADO AS I FROM dbo.CONT_INTERESADOS CI
            INNER JOIN dbo.PROYECTO_ACTIVIDAD PA ON PA.IDE_PROYECTO_ACTIVIDAD = CI.IDE_CONTRATO
            INNER JOIN dbo.PROYECTO Y ON Y.IDE_PROYECTO = PA.IDE_PROYECTO
            WHERE CI.EST_CONT_INTERESADO <> '2' AND Y.EST_PROYECTO <> '2' ORDER BY CI.IDE_CONT_INTERESADO DESC");
        $proyecto = (string) (int) $datos->P;
        $interesado = (string) (int) $datos->I;
        $comunidad = (string) (int) DB::table('dbo.GEN_COMUNIDAD')->where('EST_COMUNIDAD', '<>', '2')->orderBy('IDE_COMUNIDAD')->value('IDE_COMUNIDAD');
        $fase = (string) (int) DB::table('dbo.GEN_INTERVENCION')->where('NUM_NIVEL', '3')->where('IDE_SECTOR', '14')->where('EST_INTERVENCION', '<>', '2')->value('IDE_INTERVENCION');

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_GESTION_SOCIAL', 'de' => $proyecto])->call('nuevo')
            ->call('elegir', 'IDE_COMUNIDAD', $comunidad)
            ->set('datos.IDE_ETAPA_CONTRATO', $fase)->set('datos.NUM_BENEFICIARIOS', '150')->set('datos.TIP_UNIDAD_BENEFICIARIO', '1')
            ->set('datos.EST_MATRIZ_RC', '2')->set('datos.EST_ACTA_APROBACION', '1')
            ->call('guardar')->assertHasNoErrors();
        $social = (string) (int) DB::table('dbo.PROY_GESTION_SOCIAL')->where('IDE_PROYECTO', $proyecto)->max('IDE_GESTION_SOCIAL');
        $this->assertSame($comunidad, (string) (int) DB::table('dbo.PROY_GESTION_SOCIAL')->where('IDE_GESTION_SOCIAL', $social)->value('IDE_COMUNIDAD'));

        //BENEFICIOS: EL ESTADO NO TRAE VALOR POR DEFECTO Y SIN "ELIMINADO" EN LA LISTA
        $concepto = (string) (int) DB::table('dbo.GEN_CONCEPTO_SOCIAL')->where('NUM_NIVEL', 12)->where('EST_CONCEPTO', '<>', '2')->value('IDE_CONCEPTO');
        $b = Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_GESTION_BENEFICIOS', 'de' => $social])->call('nuevo')
            ->assertSet('datos.EST_BENEF_SOCIAL', '')
            ->set('datos.IDE_CONCEPTO', $concepto)->set('datos.DES_ACTIVIDAD', 'BENEFICIO LARAVEL')->set('datos.CAN_CONCEPTO', '10')
            ->set('datos.EST_BENEF_SOCIAL', '2')->call('guardar')->assertHasErrors('datos.EST_BENEF_SOCIAL');
        $b->set('datos.EST_BENEF_SOCIAL', '3')->call('guardar')->assertHasNoErrors();
        $this->assertTrue(DB::table('dbo.PROY_GESTION_BENEFICIOS')->where('IDE_GESTION_SOCIAL', $social)->where('DES_ACTIVIDAD', 'BENEFICIO LARAVEL')->exists());

        //SIN FECHAS OPCIONALES SE GRABA NULL
        $this->assertNull(DB::table('dbo.PROY_GESTION_BENEFICIOS')->where('IDE_GESTION_SOCIAL', $social)->value('FEC_INICIO'));

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_INTERESADOS_SOCIAL', 'de' => $social])->call('nuevo')
            ->set('datos.IDE_CONT_INTERESADO', $interesado)->call('guardar')->assertHasNoErrors();
        $this->assertTrue(DB::table('dbo.PROY_INTERESADOS_SOCIAL')->where('IDE_GESTION_SOCIAL', $social)->where('IDE_CONT_INTERESADO', $interesado)->exists());

        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_GESTION_QUEJAS', 'de' => $social])->call('nuevo')
            ->set('datos.IDE_CONT_INTERESADO', $interesado)->set('datos.DES_QUEJA', 'QUEJA LARAVEL')->set('datos.TIP_IMPACTO', '1')
            ->set('datos.TIP_CANALIZA', '2')->set('datos.EST_ATENDIDO', '2')->set('datos.FEC_QUEJA', '2026-01-15')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame('QUEJA LARAVEL', DB::table('dbo.PROY_GESTION_QUEJAS')->where('IDE_GESTION_SOCIAL', $social)->value('DES_QUEJA'));

        //ACTIVIDADES: LO PROGRAMADO SOLO SE VE EN LAS ACTIVIDADES PROGRAMADAS
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_GESTION_ACTIVIDADES', 'de' => $social])->call('nuevo')
            ->set('datos.TIP_ACTIVIDAD', '2')->assertDontSee('Actividad programada')
            ->set('datos.TIP_ACTIVIDAD', '1')->assertSee('Actividad programada')
            ->set('datos.DES_ACTIV_PROGRAMADA', 'PROGRAMADA')->set('datos.DES_ACTIV_REALIZADA', 'REALIZADA LARAVEL')
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame('PROGRAMADA', DB::table('dbo.PROY_GESTION_ACTIVIDADES')->where('IDE_GESTION_SOCIAL', $social)->value('DES_ACTIV_PROGRAMADA'));

        //ELIMINAR ES BAJA LOGICA Y SOLO DE LAS PROPIAS FILAS
        Livewire::test(CatalogoTabla::class, ['pagina' => 'PROY_GESTION_SOCIAL', 'de' => $proyecto])->call('eliminar', $social);
        $this->assertSame('2', trim((string) DB::table('dbo.PROY_GESTION_SOCIAL')->where('IDE_GESTION_SOCIAL', $social)->value('EST_GESTION_SOCIAL')));
    }

    /** Hay interesados de otros proyectos ya grabados: editar no los pierde aunque hoy no se puedan elegir */
    public function test_interesado_fuera_de_la_lista_se_conserva_al_editar(): void
    {
        $this->actingAs($this->usuarioGepro());
        $fila = DB::selectOne("SELECT TOP 1 T.IDE_INTERESADO_SOCIAL AS ID, T.IDE_GESTION_SOCIAL AS DE, T.IDE_CONT_INTERESADO AS I FROM dbo.PROY_INTERESADOS_SOCIAL T
            INNER JOIN dbo.PROY_GESTION_SOCIAL S ON S.IDE_GESTION_SOCIAL = T.IDE_GESTION_SOCIAL
            INNER JOIN dbo.PROYECTO P ON P.IDE_PROYECTO = S.IDE_PROYECTO
            INNER JOIN dbo.CONT_INTERESADOS CI ON CI.IDE_CONT_INTERESADO = T.IDE_CONT_INTERESADO
            WHERE T.EST_INTERESADO_SOCIAL <> '2' AND CI.IDE_CONTRATO NOT IN (SELECT PA.IDE_PROYECTO_ACTIVIDAD FROM dbo.PROYECTO_ACTIVIDAD PA
                INNER JOIN dbo.PROYECTO Y ON Y.IDE_PROYECTO = PA.IDE_PROYECTO WHERE Y.COD_UNICO = P.COD_UNICO)");
        if (! $fila) {
            $this->markTestSkipped('Todos los interesados son de su proyecto.');
        }
        $id = (string) (int) $fila->ID;
        Livewire::test(CatalogoFormulario::class, ['pagina' => 'PROY_INTERESADOS_SOCIAL', 'de' => (string) (int) $fila->DE])
            ->call('editar', $id)->assertSet('datos.IDE_CONT_INTERESADO', (string) (int) $fila->I)
            ->call('guardar')->assertHasNoErrors();
        $this->assertSame((string) (int) $fila->I, (string) (int) DB::table('dbo.PROY_INTERESADOS_SOCIAL')->where('IDE_INTERESADO_SOCIAL', $id)->value('IDE_CONT_INTERESADO'));
    }

    public function test_la_grilla_de_proyectos_las_abre_en_laravel(): void
    {
        $this->actingAs($this->usuarioGepro());
        $fila = (object) ['IDE_PROYECTO' => 1];
        $tabla = new ProyectosTabla();
        $this->assertSame(route('catalogos.index', ['pagina' => 'PROY_ACT_UBIGEO', 'de' => 1]), $tabla->urlAccion('ubigeo', $fila));
        $this->assertSame(route('catalogos.index', ['pagina' => 'PROY_GESTION_SOCIAL', 'de' => 1]), $tabla->urlAccion('social', $fila));
    }
}
