{{-- Opcion del menu (recursiva): grupo con hijos o enlace. Las que siguen en el sistema actual llevan un icono de salida --}}
@php
    $esLegado = $opcion['url'] && ! str_starts_with($opcion['url'], url('/'));
@endphp
@if ($opcion['hijos'])
    <li>
        <details data-abierto="0">
            <summary>
                @if ($nivel === 1)<i class="gp-icono fa-solid {{ $opcion['icono'] }}"></i>@endif
                <span>{{ $opcion['nombre'] }}</span>
                <i class="gp-flecha fa-solid fa-chevron-right"></i>
            </summary>
            <ul class="gp-submenu">
                @foreach ($opcion['hijos'] as $hijo)
                    @include('layouts.menu-opcion', ['opcion' => $hijo, 'nivel' => $nivel + 1])
                @endforeach
            </ul>
        </details>
    </li>
@elseif ($opcion['url'])
    <li>
        <a href="{{ $opcion['url'] }}" @if ($opcion['nueva_ventana']) target="_blank" rel="noopener" @endif>
            @if ($nivel === 1)<i class="gp-icono fa-solid {{ $opcion['icono'] }}"></i>@endif
            <span>{{ $opcion['nombre'] }}</span>
            @if ($esLegado)<i class="gp-externo fa-solid fa-arrow-up-right-from-square" title="Se abre en el sistema actual"></i>@endif
        </a>
    </li>
@endif
