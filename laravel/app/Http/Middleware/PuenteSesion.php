<?php

namespace App\Http\Middleware;

use App\Support\PuenteSesionLegado;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Convivencia con el sistema actual (App\Support\PuenteSesionLegado):
 * - si el usuario ya ingreso por el sistema actual, entra a Laravel sin volver a escribir la clave;
 * - si ingreso por Laravel y la sesion del sistema actual ya no existe (vencio), se vuelve a abrir.
 */
class PuenteSesion
{
    public function handle(Request $request, Closure $next): Response
    {
        $legado = PuenteSesionLegado::usuario();

        if (! Auth::check() && $legado !== null) {
            if (Auth::loginUsingId($legado)) {
                $request->session()->regenerate();
            }
        } elseif (Auth::check() && $legado === null) {
            PuenteSesionLegado::abrir(Auth::user());
        }

        return $next($request);
    }
}
