<?php

namespace App\Http\Middleware;

use App\Services\Seguridad;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

/**
 * Sistema de seguridad (usuarios, perfiles, opciones y accesos): exige que el usuario tenga en ese
 * sistema (GESUSU) el perfil ADMINISTRADOR o GESTOR DE USUARIOS (Seguridad::perfilSeguridad) y
 * comparte con las vistas el menu de ese perfil.
 */
class AccesoSeguridad
{
    public function __construct(private Seguridad $seguridad)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $usuario = Auth::user();
        $perfil = $usuario ? $this->seguridad->perfilSeguridad((int) $usuario->id) : null;
        abort_unless($perfil, 403, 'Su usuario no tiene un perfil de administración en el sistema de seguridad.');

        //PERFIL Y MODULO PARA LOS CONTROLADORES: $request->attributes->get('perfilSeguridad')
        $request->attributes->set('perfilSeguridad', $perfil);
        //LAS ACCIONES DE LIVEWIRE (MIDDLEWARE PERSISTENTE) NO PINTAN EL MENU
        if ($request->hasHeader('X-Livewire')) {
            return $next($request);
        }
        View::share('usuarioGepro', $usuario);
        View::share('menuGepro', $this->seguridad->menu($perfil['perfil'], $perfil['modulo'], true));
        View::share('areaSeguridad', true);

        return $next($request);
    }
}
