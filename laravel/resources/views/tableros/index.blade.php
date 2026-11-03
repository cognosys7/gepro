@extends('layouts.app')

@section('contenido')
    <div class="gp-tarjeta gp-tablero">
        <div class="gp-tablero-cabecera">
            <h1><i class="fa-solid fa-chart-column"></i> {{ $titulo }}</h1>
            <a class="gp-boton-sec" href="{{ $url }}" target="_blank" rel="noopener"><i class="fa-solid fa-up-right-and-down-left-from-center"></i> Abrir en pantalla completa</a>
        </div>
        <iframe class="gp-tablero-marco" src="{{ $url }}" title="{{ $titulo }}" allowfullscreen></iframe>
    </div>
@endsection
