@extends('layouts.app')

@section('contenido')
    <div class="gp-tarjeta gp-pagina">
        <div class="gp-pagina-cabecera">
            <div>
                <h1><i class="fa-solid {{ $def['icono'] }}"></i> {{ $titulo }}</h1>
                <p>
                    @if ($cadena)
                        {{-- CAMINO DESDE LA RAIZ, CON ENLACES PARA VOLVER A CADA NIVEL --}}
                        <a href="{{ route('catalogos.index', ['pagina' => $pagina]) }}">{{ $menuNombre }}</a>
                        @foreach ($cadena as $i => $f)
                            <i class="fa-solid fa-angle-right gp-separador"></i>
                            @if ($i < count($cadena) - 1)
                                <a href="{{ route('catalogos.index', ['pagina' => $pagina, 'padre' => $f->{$def['id']}]) }}">{{ $nombre($f) }}</a>
                            @else
                                <strong>{{ $nombre($f) }}</strong>
                            @endif
                        @endforeach
                    @else
                        {{ $def['descripcion'] ?? $def['titulo'].'.' }}
                        @if (empty($def['nuevo']) && empty($def['editar']))
                            Solo consulta: estos datos no se registran desde GEPRO.
                        @endif
                    @endif
                </p>
            </div>
            @if ($cadena)
                @php($anterior = count($cadena) > 1 ? $cadena[count($cadena) - 2]->{$def['id']} : null)
                <a class="gp-boton-sec" href="{{ route('catalogos.index', array_filter(['pagina' => $pagina, 'padre' => $anterior])) }}"><i class="fa-solid fa-arrow-left"></i> Volver</a>
            @endif
        </div>
        <livewire:catalogo-tabla :pagina="$pagina" :padre="$padre" :key="'t-'.$pagina.'-'.$padre" />
        <livewire:catalogo-formulario :pagina="$pagina" :padre="$padre" :key="'f-'.$pagina.'-'.$padre" />
    </div>
@endsection
