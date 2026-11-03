@extends('layouts.app')

@section('contenido')
    <div class="gp-tarjeta gp-pagina">
        <div class="gp-pagina-cabecera">
            <div>
                <h1><i class="fa-solid fa-briefcase"></i> {{ $titulo }}</h1>
                <p>Proyectos vigentes del portafolio. Use los iconos de cada fila para ver sus contratos, gestión social y demás información.</p>
            </div>
        </div>
        <livewire:proyectos-tabla :opcion="$opcion" />
        <livewire:proyecto-formulario :opcion="$opcion" />
    </div>
@endsection
