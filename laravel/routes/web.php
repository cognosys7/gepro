<?php

use App\Http\Controllers\IngresoController;
use App\Http\Controllers\InicioController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/ingreso', [IngresoController::class, 'formulario'])->name('login');
    Route::post('/ingreso', [IngresoController::class, 'ingresar'])->name('ingreso');
});

Route::post('/salir', [IngresoController::class, 'salir'])->middleware('auth')->name('salir');

//PANTALLAS DE GEPRO: USUARIO CON PERFIL EN GEPRO (EL MENU SALE DE SU PERFIL)
Route::middleware(['auth', 'gepro'])->group(function () {
    Route::get('/', InicioController::class)->name('inicio');
});
