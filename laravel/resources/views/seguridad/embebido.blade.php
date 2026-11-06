@extends('layouts.embebido')

{{-- VENTANAS DEL SISTEMA DE SEGURIDAD QUE SE ABREN EN LA MODAL: ACCESOS DE UN PERFIL Y PERFILES DE UN USUARIO --}}
@section('contenido')
    <div class="gp-embebido-cabecera">
        <div>
            <span class="gp-etiqueta-tipo"><i class="fa-solid {{ $icono }}"></i> {{ $titulo }}</span>
        </div>
        <p>{{ $subtitulo }}</p>
    </div>
    @livewire($componente, $parametros, key($componente.'-'.implode('-', $parametros)))
@endsection
