@extends('layouts.embebido')

{{-- PANTALLA QUE DEPENDE DE OTRO REGISTRO (SE ABRE EN LA VENTANA MODAL): CABECERA CON ESE REGISTRO --}}
@section('contenido')
    <div class="gp-embebido-cabecera">
        <div>
            <span class="gp-etiqueta-tipo"><i class="fa-solid {{ $def['icono'] }}"></i> {{ $def['titulo'] }}</span>
        </div>
        <p>{{ $filaDe->TITULO_DE }}</p>
        @if (! empty($def['descripcion']))<p class="gp-embebido-proposito">{{ $def['descripcion'] }}</p>@endif
    </div>
    <livewire:catalogo-tabla :pagina="$pagina" :de="$de" :key="'t-'.$pagina.'-'.$de" />
    <livewire:catalogo-formulario :pagina="$pagina" :de="$de" :key="'f-'.$pagina.'-'.$de" />
@endsection
