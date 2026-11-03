<?php

namespace App\Providers;

use App\Auth\LegadoUserProvider;
use App\Services\Seguridad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(Seguridad::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //USUARIOS DE BDGEPRO (seguridad.tsusuario) CON LA REGLA DE CLAVE DEL SISTEMA ACTUAL
        Auth::provider('legado', fn () => new LegadoUserProvider());
    }
}
