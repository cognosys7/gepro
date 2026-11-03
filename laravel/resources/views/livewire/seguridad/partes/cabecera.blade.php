{{-- Cabecera de la grilla: columnas que se ordenan con un clic y (si $acciones) la columna fija de acciones --}}
<thead>
    <tr>
        @foreach ($this->columnas() as $columna => [$titulo])
            <th @class(['gp-ordenable', 'gp-ordenada' => $orden === $columna]) wire:click="ordenarPor('{{ $columna }}')">
                {{ $titulo }}
                @if ($orden === $columna)
                    <i class="fa-solid {{ $direccion === 'asc' ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short' }}"></i>
                @else
                    <i class="fa-solid fa-sort gp-sin-orden"></i>
                @endif
            </th>
        @endforeach
        @if (! empty($acciones))
            <th class="gp-col-accion gp-col-fija">Acciones</th>
        @endif
    </tr>
</thead>
