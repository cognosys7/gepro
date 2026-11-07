<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use App\Services\Seguridad;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Ingreso, portada y menu contra BDGEPRO (solo lectura).
 */
class IngresoTest extends TestCase
{
    /** Un usuario activo con perfil en GEPRO */
    private function usuarioConPerfil(): object
    {
        $id = DB::table('seguridad.tsusuarioperfil as up')
            ->join('seguridad.tsperfil as pf', 'pf.idperfil', '=', 'up.upsperfil')
            ->join('seguridad.tsmodulo as m', 'm.idmodulo', '=', 'pf.pefmodulo')
            ->join('seguridad.tssistema as s', 's.IdSistema', '=', 'm.modsistema')
            ->where('s.sisabreviatura', 'GEPRO')->where('up.upsestado', 1)->where('pf.pefestado', 1)
            ->orderBy('up.upsusuario')->pluck('up.upsusuario');
        foreach ($id as $idUsuario) {
            $u = (new LegadoUserProvider())->retrieveById($idUsuario);
            if ($u) {
                return $u;
            }
        }
        $this->markTestSkipped('No hay usuarios activos con perfil en GEPRO.');
    }

    public function test_sin_sesion_lleva_al_ingreso(): void
    {
        $this->get('/')->assertRedirect(route('login'));
        $this->get('/ingreso')->assertOk()->assertSee('¿Cuánto es?');
    }

    public function test_captcha_incorrecto(): void
    {
        $this->withSession(['captcha_resultado' => 5])
            ->post('/ingreso', ['usuario' => 'X', 'clave' => 'Y', 'captcha' => 4])
            ->assertSessionHasErrors('captcha');
    }

    public function test_usuario_o_clave_incorrectos(): void
    {
        $this->withSession(['captcha_resultado' => 5])
            ->post('/ingreso', ['usuario' => 'NO_EXISTE_GEPRO', 'clave' => 'x', 'captcha' => 5])
            ->assertSessionHasErrors(['usuario' => 'Usuario o clave incorrectos.']);
    }

    public function test_portada_y_menu_del_perfil(): void
    {
        $usuario = $this->usuarioConPerfil();
        $perfil = app(Seguridad::class)->perfil((int) $usuario->id);
        $menu = app(Seguridad::class)->menu($perfil['perfil'], $perfil['modulo']);

        $respuesta = $this->actingAs($usuario)->get('/')->assertOk()
            ->assertSeeText('Ciclo de vida del proyecto')
            ->assertSee($usuario->nombreVisible());
        foreach ($menu as $opcion) {
            if ($opcion['hijos'] || $opcion['url']) {
                $respuesta->assertSee($opcion['nombre']);
            }
        }
    }
}
