@extends('layouts.app')

{{-- PAGINAS DEL SISTEMA DE SEGURIDAD: Usuarios, Perfil, Acceso, Opcion y Sistema (Software) --}}
@section('contenido')
    <div class="gp-tarjeta gp-pagina">
        <div class="gp-pagina-cabecera">
            <div>
                <h1><i class="fa-solid {{ $icono }}"></i> {{ $titulo }}</h1>
                <p>{{ $descripcion }}</p>
            </div>
        </div>
        @livewire($componente, $parametros, key('seg-'.$pagina))
    </div>
@endsection
