<?php

use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\ProyectoContratosController;
use App\Http\Controllers\ProyectosController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/ingreso', [IngresoController::class, 'formulario'])->name('login');
    Route::post('/ingreso', [IngresoController::class, 'ingresar'])->name('ingreso');
});

Route::post('/salir', [IngresoController::class, 'salir'])->middleware('auth')->name('salir');

//PANTALLAS DE GEPRO: USUARIO CON PERFIL EN GEPRO (EL MENU SALE DE SU PERFIL)
Route::middleware(['auth', 'gepro'])->group(function () {
    Route::get('/', InicioController::class)->name('inicio');
    Route::get('/proyectos', [ProyectosController::class, 'index'])->name('proyectos.index');
    Route::get('/catalogos/{pagina}', [CatalogosController::class, 'index'])->where('pagina', '[A-Za-z0-9_]+')->name('catalogos.index');
    Route::get('/proyectos/{proyecto}/contratos', [ProyectoContratosController::class, 'index'])->whereNumber('proyecto')->name('proyectos.contratos');
});
