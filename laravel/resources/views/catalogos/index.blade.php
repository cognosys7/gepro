@extends('layouts.app')

@section('contenido')
    <div class="gp-tarjeta gp-pagina">
        <div class="gp-pagina-cabecera">
            <div>
                <h1><i class="fa-solid {{ $def['icono'] }}"></i> {{ $titulo }}</h1>
                <p>
                    {{ $def['titulo'] }}.
                    @if (empty($def['nuevo']) && empty($def['editar']))
                        Solo consulta: estos datos no se registran desde GEPRO.
                    @endif
                </p>
            </div>
        </div>
        <livewire:catalogo-tabla :pagina="$pagina" />
        <livewire:catalogo-formulario :pagina="$pagina" />
    </div>
@endsection
