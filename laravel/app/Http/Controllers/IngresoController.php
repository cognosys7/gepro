<?php

namespace App\Http\Controllers;

use App\Auth\LegadoUserProvider;
use App\Services\Seguridad;
use App\Support\PuenteSesionLegado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Ingreso y salida. La clave se valida igual que en el sistema actual (LegadoUserProvider) y,
 * a diferencia de el, el captcha se valida en el servidor y los intentos fallidos se limitan.
 */
class IngresoController extends Controller
{
    private const INTENTOS = 5;

    public function formulario(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('inicio');
        }

        return view('ingreso', ['captcha' => $this->nuevoCaptcha($request)]);
    }

    public function ingresar(Request $request, Seguridad $seguridad)
    {
        $datos = $request->validate([
            'usuario' => ['required', 'string', 'max:50'],
            'clave' => ['required', 'string', 'max:100'],
            'captcha' => ['required', 'integer'],
        ], [], ['usuario' => 'usuario', 'clave' => 'clave', 'captcha' => 'resultado de la suma']);

        $llave = 'ingreso:'.Str::lower($datos['usuario']).'|'.$request->ip();
        if (RateLimiter::tooManyAttempts($llave, self::INTENTOS)) {
            $segundos = RateLimiter::availableIn($llave);
            throw ValidationException::withMessages(['usuario' => "Demasiados intentos. Vuelva a intentar en {$segundos} segundos."]);
        }

        $esperado = $request->session()->pull('captcha_resultado');
        if ($esperado === null || (int) $datos['captcha'] !== (int) $esperado) {
            RateLimiter::hit($llave, 60);
            throw ValidationException::withMessages(['captcha' => 'El resultado de la suma no es correcto.']);
        }

        if (! Auth::attempt(['usuario' => $datos['usuario'], 'clave' => $datos['clave']])) {
            RateLimiter::hit($llave, 60);
            throw ValidationException::withMessages(['usuario' => 'Usuario o clave incorrectos.']);
        }
        RateLimiter::clear($llave);
        $request->session()->regenerate();

        $usuario = Auth::user();
        if (! $seguridad->perfil((int) $usuario->id)) {
            Auth::logout();
            throw ValidationException::withMessages(['usuario' => 'Su usuario no tiene un perfil activo en GEPRO.']);
        }

        //CLAVE IGUAL AL USUARIO: EL SISTEMA ACTUAL OBLIGA A CAMBIARLA (PANTALLA "Clave" DE intranet)
        $cambiarClave = LegadoUserProvider::usuarioIngresado($datos['usuario']) === LegadoUserProvider::limpiar($datos['clave']);
        PuenteSesionLegado::abrir($usuario, $cambiarClave);
        if ($cambiarClave) {
            return redirect()->away(config('gepro.legado_url').'/intranet/Vista/AntiRefresh.php?Pagina=Clave');
        }

        return redirect()->intended(route('inicio'));
    }

    public function salir(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        PuenteSesionLegado::cerrar();

        return redirect()->route('login');
    }

    /** Suma de dos numeros; el resultado queda solo en la sesion */
    private function nuevoCaptcha(Request $request): string
    {
        $a = random_int(1, 9);
        $b = random_int(1, 9);
        $request->session()->put('captcha_resultado', $a + $b);

        return "{$a} + {$b}";
    }
}
