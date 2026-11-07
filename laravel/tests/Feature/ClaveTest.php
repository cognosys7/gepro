<?php

namespace Tests\Feature;

use App\Auth\LegadoUserProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Tests\UsuariosDePrueba;

/**
 * Cambio de clave. Graba de verdad con seguridad.ActualizaClave3, dentro de una transaccion que se deshace.
 */
class ClaveTest extends TestCase
{
    use UsuariosDePrueba;

    private const ACTUAL = 'ClaveDePrueba1';

    private object $usuario;

    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        $this->usuario = $this->usuarioGepro();
        DB::table('seguridad.tsusuario')->where('idusuario', $this->usuario->id)
            ->update(['usuclave' => LegadoUserProvider::claveParaGuardar($this->usuario->usunombre, self::ACTUAL)]);
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    private function enviar(array $datos)
    {
        return $this->actingAs($this->usuario)->from(route('clave'))->post(route('clave.grabar'), $datos);
    }

    public function test_cambia_la_clave_y_el_ingreso_acepta_la_nueva(): void
    {
        $this->enviar(['actual' => self::ACTUAL, 'clave' => 'NuevaClave9', 'clave_confirmation' => 'NuevaClave9'])
            ->assertSessionHasNoErrors()->assertRedirect(route('inicio'));

        $this->assertTrue(Auth::validate(['usuario' => $this->usuario->usunombre, 'clave' => 'NuevaClave9']));
        $this->assertFalse(Auth::validate(['usuario' => $this->usuario->usunombre, 'clave' => self::ACTUAL]));
    }

    public function test_una_clave_con_caracteres_que_limpia_el_ingreso_tambien_entra(): void
    {
        $this->enviar(['actual' => self::ACTUAL, 'clave' => "Clave'con;signos%", 'clave_confirmation' => "Clave'con;signos%"])
            ->assertSessionHasNoErrors();

        $this->assertTrue(Auth::validate(['usuario' => $this->usuario->usunombre, 'clave' => "Clave'con;signos%"]));
    }

    public function test_exige_la_clave_actual_y_la_confirmacion(): void
    {
        $this->enviar(['actual' => 'otra', 'clave' => 'NuevaClave9', 'clave_confirmation' => 'NuevaClave9'])->assertSessionHasErrors('actual');
        $this->enviar(['actual' => self::ACTUAL, 'clave' => 'NuevaClave9', 'clave_confirmation' => 'distinta'])->assertSessionHasErrors('clave');

        $this->assertTrue(Auth::validate(['usuario' => $this->usuario->usunombre, 'clave' => self::ACTUAL]));
    }

    public function test_rechaza_claves_debiles(): void
    {
        $dni = trim((string) DB::table('general.tgpersona')->where('IdPersona', $this->usuario->idpersona)->value('PerNroDocumento'));
        foreach (['abc12', self::ACTUAL, $this->usuario->usunombre, $dni, 'SELECT;;;;1'] as $debil) {
            $this->enviar(['actual' => self::ACTUAL, 'clave' => $debil, 'clave_confirmation' => $debil])->assertSessionHasErrors('clave');
        }
    }

    public function test_con_la_clave_igual_al_usuario_no_se_puede_seguir_sin_cambiarla(): void
    {
        $sesion = $this->actingAs($this->usuario)->withSession(['cambiar_clave' => true]);

        $sesion->get(route('inicio'))->assertRedirect(route('clave'));
        $sesion->get(route('clave'))->assertOk()->assertSee('debe cambiar su clave');
        $sesion->withHeader('X-Livewire', '1')->get(route('inicio'))->assertForbidden();
    }

    public function test_al_cambiarla_se_libera_la_entrada(): void
    {
        $this->actingAs($this->usuario)->withSession(['cambiar_clave' => true])
            ->post(route('clave.grabar'), ['actual' => self::ACTUAL, 'clave' => 'NuevaClave9', 'clave_confirmation' => 'NuevaClave9'])
            ->assertRedirect(route('inicio'))->assertSessionMissing('cambiar_clave');
    }

    public function test_el_ingreso_con_la_clave_igual_al_usuario_lleva_al_cambio(): void
    {
        DB::table('seguridad.tsusuario')->where('idusuario', $this->usuario->id)
            ->update(['usuclave' => LegadoUserProvider::claveParaGuardar($this->usuario->usunombre, $this->usuario->usunombre)]);

        $this->withSession(['captcha_resultado' => 5])
            ->post(route('ingreso'), ['usuario' => $this->usuario->usunombre, 'clave' => $this->usuario->usunombre, 'captcha' => 5])
            ->assertRedirect(route('clave'))->assertSessionHas('cambiar_clave', true);
    }

    public function test_el_menu_abre_el_cambio_de_clave_de_laravel(): void
    {
        $this->actingAs($this->usuario)->get(route('inicio'))->assertOk()->assertSee(route('clave'), false)->assertDontSee('intranet/Vista');
    }
}
