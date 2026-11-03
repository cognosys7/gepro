@extends('layouts.embebido')

{{-- ARCHIVOS ADJUNTOS DE UN REGISTRO (SE ABRE EN LA VENTANA MODAL) --}}
@section('contenido')
    <div class="gp-embebido-cabecera">
        <div>
            <span class="gp-etiqueta-tipo"><i class="fa-solid fa-paperclip"></i> Archivos adjuntos</span>
        </div>
        <p>{{ $titulo }}</p>
    </div>
    <livewire:archivos-adjuntos :tabla="$tabla" :registro="$registro" :key="'a-'.$tabla.'-'.$registro" />
@endsection
