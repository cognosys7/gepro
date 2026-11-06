<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mientras la clave sea igual al usuario, solo se puede cambiarla o salir (IngresoController deja la
 * marca en la sesion, como SeguridadPass en el sistema anterior).
 */
class ClaveObligatoria
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('cambiar_clave') && ! $request->routeIs('clave', 'clave.grabar', 'salir')) {
            //EN UNA ACCION DE LIVEWIRE UNA REDIRECCION ABRIRIA LA PANTALLA DENTRO DE SU VENTANA DE ERROR
            abort_if($request->hasHeader('X-Livewire'), 403, 'Debe cambiar su clave.');

            return redirect()->route('clave');
        }

        return $next($request);
    }
}
