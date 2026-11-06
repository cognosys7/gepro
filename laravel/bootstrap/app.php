<?php

use App\Http\Middleware\AccesoGepro;
use App\Http\Middleware\AccesoSeguridad;
use App\Http\Middleware\PuenteSesion;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //PUENTE CON LA SESION DEL SISTEMA ACTUAL EN TODAS LAS PAGINAS (ANTES DE auth Y guest)
        $middleware->web(append: [PuenteSesion::class]);
        $middleware->alias(['gepro' => AccesoGepro::class, 'seguridad' => AccesoSeguridad::class]);
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(fn () => route('inicio'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
