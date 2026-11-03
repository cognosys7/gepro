{{-- Barra de la grilla: busqueda, filtros ($filtros: [propiedad, etiqueta, valor => texto]), filas por pagina, total y (si $nuevo) el boton Nuevo --}}
<div class="gp-grilla-barra">
    <div class="gp-grilla-buscar">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="search" wire:model.live.debounce.400ms="buscar" placeholder="{{ $placeholder ?? 'Buscar...' }}" aria-label="Buscar">
    </div>
    @foreach ($filtros ?? [] as [$propiedad, $etiqueta, $opciones])
        <label class="gp-grilla-filas">
            {{ $etiqueta }}
            <select wire:model.live="{{ $propiedad }}">
                <option value="">Todos</option>
                @foreach ($opciones as $valor => $texto)
                    <option value="{{ $valor }}">{{ $texto }}</option>
                @endforeach
            </select>
        </label>
    @endforeach
    <label class="gp-grilla-filas">
        Mostrar
        <select wire:model.live="porPagina">
            @foreach ([10, 25, 50, 100] as $n)
                <option value="{{ $n }}">{{ $n }}</option>
            @endforeach
        </select>
    </label>
    <span class="gp-grilla-total" wire:loading.remove>{{ number_format($filas->total()) }} registros</span>
    <span class="gp-grilla-total" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> Cargando…</span>
    @if (! empty($nuevo))
        <button type="button" class="gp-boton-nuevo" wire:click="nuevo"><i class="fa-solid fa-plus"></i> Nuevo</button>
    @endif
</div>
