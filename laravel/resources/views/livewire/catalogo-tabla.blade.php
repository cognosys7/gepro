<div class="gp-grilla">
    <div class="gp-grilla-barra">
        <div class="gp-grilla-buscar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" wire:model.live.debounce.400ms="buscar" placeholder="Buscar..." aria-label="Buscar">
        </div>
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
        @if ($this->puede('nuevo'))
            <button type="button" class="gp-boton-nuevo" wire:click="$dispatch('catalogo-nuevo')"><i class="fa-solid fa-plus"></i> Nuevo</button>
        @endif
    </div>

    {{-- TODAS LAS ACCIONES DE LA FILA EN UNA COLUMNA FIJA A LA DERECHA: SE VEN AUNQUE LA GRILLA SE DESPLACE --}}
    @php($conAcciones = ! empty($def['editar']) || $this->puede('eliminar') || $this->conHijos() || ! empty($def['acciones']))
    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            <thead>
                <tr>
                    @foreach ($columnas as $columna => [$titulo, $tipo])
                        <th @class(['gp-ordenable', 'gp-ordenada' => $orden === $columna, 'gp-numero' => $tipo === 'numero'])
                            wire:click="ordenarPor('{{ $columna }}')" @if ($tipo === 'area') style="width:50%" @endif>
                            {{ $titulo }}
                            @if ($orden === $columna)
                                <i class="fa-solid {{ $direccion === 'asc' ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short' }}"></i>
                            @else
                                <i class="fa-solid fa-sort gp-sin-orden"></i>
                            @endif
                        </th>
                    @endforeach
                    @if ($conAcciones)
                        <th class="gp-col-accion gp-col-fija">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($filas as $fila)
                    <tr wire:key="cat-{{ $fila->ID }}">
                        @foreach ($columnas as $columna => [, $tipo])
                            @php($valor = trim((string) $fila->{$columna}))
                            @if ($tipo === 'combo' && $columna === $def['estado'])
                                <td>@if ($valor !== '')<span @class(['gp-estado', 'gp-estado-activo' => $valor === '1'])>{{ $etiquetas[$columna][$valor] ?? $valor }}</span>@endif</td>
                            @elseif ($tipo === 'combo')
                                <td>{{ $etiquetas[$columna][$valor] ?? $valor }}</td>
                            @elseif ($tipo === 'fecha')
                                <td class="gp-fecha">{{ $valor !== '' ? \Illuminate\Support\Carbon::parse(substr($valor, 0, 10))->format('d/m/Y') : '' }}</td>
                            @elseif ($tipo === 'numero')
                                {{-- IMPORTES (IMP_*) SIEMPRE CON DOS DECIMALES; LOS DEMAS NUMEROS SIN CEROS DE SOBRA --}}
                                <td class="gp-numero">{{ $valor === '' ? '' : (str_starts_with($columna, 'IMP_') ? number_format((float) $valor, 2, '.', ',') : rtrim(rtrim(number_format((float) $valor, 2, '.', ','), '0'), '.')) }}</td>
                            @else
                                <td>{{ $valor }}</td>
                            @endif
                        @endforeach
                        @if ($conAcciones)
                            <td class="gp-col-accion gp-col-fija">
                                {{-- ACCIONES DE LA DEFINICION: ABREN OTRA PANTALLA EN LA VENTANA MODAL --}}
                                @php($primera = array_key_first($columnas))
                                @foreach ($def['acciones'] ?? [] as $accion)
                                    @if (isset($accion[4]['url']))
                                    <a class="gr-ico {{ $accion[2] }}" title="{{ $accion[3] ?? $accion[0] }}" href="{{ $this->urlAccion($accion[4], $fila) }}" target="_blank" rel="noopener"><i class="fa-solid {{ $accion[1] }}"></i></a>
                                    @continue
                                    @endif
                                    <button type="button" class="gr-ico {{ $accion[2] }}" title="{{ $accion[3] ?? $accion[0] }}"
                                        data-modal-url="{{ $this->urlAccion($accion[4], $fila) }}" data-modal-titulo="{{ $accion[3] ?? $accion[0] }}"
                                        data-modal-subtitulo="{{ $etiquetas[$primera][trim((string) $fila->{$primera})] ?? trim((string) $fila->{$primera}) }}">
                                        <i class="fa-solid {{ $accion[1] }}"></i>
                                    </button>
                                @endforeach
                                @if ($this->conHijos())
                                    @php([$textoHijos, $iconoHijos] = $def['jerarquia']['boton'])
                                    <a class="gr-ico gr-teal" title="{{ $textoHijos }}" href="{{ $this->urlHijos(trim((string) $fila->ID)) }}"><i class="fa-solid {{ $iconoHijos }}"></i></a>
                                @endif
                                @if ($this->puede('editar'))
                                    <button type="button" class="gr-ico gr-ambar" title="Editar" wire:click="$dispatch('catalogo-editar', { id: {{ \Illuminate\Support\Js::from(trim((string) $fila->ID)) }} })"><i class="fa-solid fa-pen"></i></button>
                                @elseif (! empty($def['editar']))
                                    {{-- PERFIL DE SOLO CONSULTA: VE EL FORMULARIO SIN GRABAR --}}
                                    <button type="button" class="gr-ico gr-azul" title="Ver" wire:click="$dispatch('catalogo-editar', { id: {{ \Illuminate\Support\Js::from(trim((string) $fila->ID)) }} })"><i class="fa-solid fa-eye"></i></button>
                                @endif
                                @if ($this->puede('eliminar'))
                                    <button type="button" class="gr-ico gr-rojo" title="Eliminar" wire:click="eliminar({{ \Illuminate\Support\Js::from(trim((string) $fila->ID)) }})"
                                        wire:confirm="¿Eliminar este registro? Dejará de mostrarse en las listas."><i class="fa-solid fa-trash-can"></i></button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columnas) + ($conAcciones ? 1 : 0) }}" class="gp-vacio">
                            <i class="fa-regular fa-folder-open"></i>
                            {{ $buscar !== '' ? 'No hay registros que coincidan con la búsqueda.' : 'No hay registros.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($filas->lastPage() > 1)
        <nav class="gp-paginas" aria-label="Páginas">
            <span>Mostrando {{ $filas->firstItem() }}–{{ $filas->lastItem() }} de {{ number_format($filas->total()) }}</span>
            <div>
                <button type="button" wire:click="gotoPage(1)" @disabled($filas->onFirstPage()) title="Primera"><i class="fa-solid fa-angles-left"></i></button>
                <button type="button" wire:click="previousPage" @disabled($filas->onFirstPage()) title="Anterior"><i class="fa-solid fa-angle-left"></i></button>
                @foreach (range(max(1, $filas->currentPage() - 2), min($filas->lastPage(), $filas->currentPage() + 2)) as $p)
                    <button type="button" wire:click="gotoPage({{ $p }})" @class(['gp-pagina-actual' => $p === $filas->currentPage()])>{{ $p }}</button>
                @endforeach
                <button type="button" wire:click="nextPage" @disabled(! $filas->hasMorePages()) title="Siguiente"><i class="fa-solid fa-angle-right"></i></button>
                <button type="button" wire:click="gotoPage({{ $filas->lastPage() }})" @disabled(! $filas->hasMorePages()) title="Última"><i class="fa-solid fa-angles-right"></i></button>
            </div>
        </nav>
    @endif
</div>
