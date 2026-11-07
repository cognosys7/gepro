<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use App\Services\Seguridad;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Portada: las cifras son las de la base y los enlaces, los del menu del perfil
 */
class InicioTest extends TestCase
{
    use UsuariosDePrueba;

    public function test_muestra_las_cifras_reales(): void
    {
        $proyectos = DB::table('dbo.PROYECTO')->where('EST_PROYECTO', '<>', '2')->count();
        $contratos = DB::table('dbo.PROYECTO_ACTIVIDAD')->where('EST_PROYECTO_ACTIVIDAD', '<>', '2')->where('TIP_PROYECTO_ACTIVIDAD', '1')->count();

        $this->actingAs($this->usuarioGepro())->get('/')
            ->assertOk()
            ->assertSee('un solo tablero de control')
            ->assertSee('Proyectos registrados')
            ->assertSeeInOrder(['<b>'.number_format($proyectos).'</b>', 'Proyectos registrados'], false)
            ->assertSeeInOrder(['<b>'.number_format($contratos).'</b>', 'Contratos principales'], false);
    }

    public function test_abrir_tableros_lleva_a_formatos(): void
    {
        $seguridad = app(Seguridad::class);
        $url = route('tableros.index', ['pagina' => 'PBI_PRY_2CONTRATOS']);
        foreach (DB::table('seguridad.tsusuarioperfil')->where('upsestado', 1)->orderBy('upsusuario')->pluck('upsusuario')->unique() as $id) {
            $perfil = $seguridad->perfil((int) $id);
            $usuario = $perfil ? (new LegadoUserProvider())->retrieveById($id) : null;
            if ($usuario && str_contains(json_encode($seguridad->menu($perfil['perfil'], $perfil['modulo']), JSON_UNESCAPED_SLASHES), $url)) {
                $this->actingAs($usuario)->get('/')
                    ->assertOk()
                    ->assertSee('<a class="gp-accion-secundaria" href="'.e($url), false);

                return;
            }
        }
        $this->markTestSkipped('Ningun perfil tiene Formatos F1, F2, F6 en su menu.');
    }

    public function test_el_boton_abre_una_opcion_del_perfil(): void
    {
        $usuario = $this->usuarioGepro(false, 'PROYECTO');
        if (! $usuario) {
            $this->markTestSkipped('Ningun usuario tiene acceso a Proyectos.');
        }

        $this->actingAs($usuario)->get('/')
            ->assertOk()
            ->assertSee('Ver proyectos')
            ->assertSee(url('/proyectos'), false);
    }
}
