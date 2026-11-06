<?php

namespace App\Http\Middleware;

use App\Services\Seguridad;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Exige que el usuario tenga un perfil activo en GEPRO (seguridad.tsusuarioperfil) y comparte
 * con las vistas el usuario, su perfil y el menu de ese perfil.
 */
class AccesoGepro
{
    public function __construct(private Seguridad $seguridad)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $usuario = Auth::user();
        $perfil = $usuario ? $this->seguridad->perfil((int) $usuario->id) : null;
        if (! $perfil) {
            Auth::logout();
            $request->session()->invalidate();
            //EN UNA ACCION DE LIVEWIRE UNA REDIRECCION ABRIRIA EL INGRESO DENTRO DE SU VENTANA DE ERROR
            abort_if($request->hasHeader('X-Livewire'), 403, 'Su usuario ya no tiene un perfil activo en GEPRO.');

            return redirect()->route('login')->withErrors(['usuario' => 'Su usuario no tiene un perfil activo en GEPRO.']);
        }

        //PERFIL Y MODULO PARA LOS CONTROLADORES: $request->attributes->get('perfilGepro')
        $request->attributes->set('perfilGepro', $perfil);
        //LAS ACCIONES DE LIVEWIRE (MIDDLEWARE PERSISTENTE) NO PINTAN EL MENU
        if ($request->hasHeader('X-Livewire')) {
            return $next($request);
        }
        View::share('usuarioGepro', $usuario);
        View::share('menuGepro', $this->seguridad->menu($perfil['perfil'], $perfil['modulo']));

        return $next($request);
    }
}
