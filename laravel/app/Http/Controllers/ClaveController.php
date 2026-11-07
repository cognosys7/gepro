<?php

namespace App\Http\Controllers;

use App\Auth\LegadoUserProvider;
use App\Support\Procedimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Cambio de clave del usuario (antes intranet/Vista/ClaveVista.php). Es obligatorio cuando la clave es
 * igual al usuario (middleware ClaveObligatoria). Graba con seguridad.ActualizaClave3 y la misma regla
 * del ingreso: lo que se guarda aqui es lo que LegadoUserProvider compara al entrar.
 */
class ClaveController extends Controller
{
    private const MINIMO = 6;

    public function formulario(Request $request)
    {
        return view('clave', ['obligatoria' => (bool) $request->session()->get('cambiar_clave')]);
    }

    public function cambiar(Request $request)
    {
        $datos = $request->validate([
            'actual' => ['required', 'string', 'max:100'],
            'clave' => ['required', 'string', 'min:'.self::MINIMO, 'max:100', 'confirmed'],
        ], [], ['actual' => 'clave actual', 'clave' => 'clave nueva']);

        $usuario = Auth::user();
        if (! Auth::validate(['usuario' => $usuario->usunombre, 'clave' => $datos['actual']])) {
            throw ValidationException::withMessages(['actual' => 'La clave actual no es correcta.']);
        }

        //SE COMPARA LO QUE REALMENTE SE GUARDA: EL INGRESO QUITA CARACTERES Y PALABRAS DE LA CLAVE
        $nueva = LegadoUserProvider::limpiar($datos['clave']);
        $dni = trim((string) DB::table('general.tgpersona')->where('IdPersona', $usuario->idpersona)->value('PerNroDocumento'));
        if (mb_strlen($nueva) < self::MINIMO) {
            throw ValidationException::withMessages(['clave' => 'La clave nueva tiene caracteres que no se admiten y queda muy corta.']);
        }
        if ($nueva === $dni || strtoupper($nueva) === strtoupper((string) $usuario->usunombre)) {
            throw ValidationException::withMessages(['clave' => 'La clave nueva no puede ser su DNI ni su usuario.']);
        }
        if ($nueva === LegadoUserProvider::limpiar($datos['actual'])) {
            throw ValidationException::withMessages(['clave' => 'La clave nueva debe ser distinta de la actual.']);
        }

        Procedimiento::ejecutar('seguridad.ActualizaClave3', [
            'pClave' => LegadoUserProvider::claveParaGuardar((string) $usuario->usunombre, $datos['clave']),
            //LA IMAGEN DE SEGURIDAD ERA PARA LA RECUPERACION ANTIGUA: SE CONSERVA LA QUE TENGA
            'pUsuRecupera' => DB::table('seguridad.tsusuario')->where('idusuario', $usuario->id)->value('usudatorecupera'),
            'pUsuario' => (int) $usuario->id,
            'pCodigo' => (int) $usuario->id,
        ]);

        $request->session()->forget('cambiar_clave');
        $request->session()->regenerate();

        return redirect()->intended(route('inicio'));
    }
}
