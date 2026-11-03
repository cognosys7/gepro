<div class="gp-grilla">
    {{-- BARRA: BUSCADOR, FILAS POR PAGINA Y TOTAL --}}
    <div class="gp-grilla-barra">
        <div class="gp-grilla-buscar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" wire:model.live.debounce.400ms="buscar" placeholder="Buscar por código, código único o descripción..." aria-label="Buscar proyectos">
        </div>
        <label class="gp-grilla-filas">
            Mostrar
            <select wire:model.live="porPagina">
                @foreach ([10, 25, 50, 100] as $n)
                    <option value="{{ $n }}">{{ $n }}</option>
                @endforeach
            </select>
        </label>
        <span class="gp-grilla-total" wire:loading.remove>{{ number_format($proyectos->total()) }} proyectos</span>
        <span class="gp-grilla-total" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> Cargando…</span>
        @if ($this->puede('nuevo'))
            <button type="button" class="gp-boton-nuevo" wire:click="$dispatch('proyecto-nuevo')"><i class="fa-solid fa-plus"></i> Nuevo proyecto</button>
        @endif
    </div>

    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            <thead>
                <tr>
                    @foreach (\App\Livewire\ProyectosTabla::COLUMNAS as $columna => $titulo)
                        <th @class(['gp-ordenable', 'gp-ordenada' => $orden === $columna]) wire:click="ordenarPor('{{ $columna }}')" @if ($columna === 'DES_LARGA_PROYECTO') style="width:100%" @endif>
                            {{ $titulo }}
                            @if ($orden === $columna)
                                <i class="fa-solid {{ $direccion === 'asc' ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short' }}"></i>
                            @else
                                <i class="fa-solid fa-sort gp-sin-orden"></i>
                            @endif
                        </th>
                    @endforeach
                    @foreach ($acciones as $clave => [$titulo, $icono])
                        <th class="gp-col-accion" title="{{ $titulo }}">{{ \Illuminate\Support\Str::of($titulo)->before(' (')->replace('Contratos de ', '')->ucfirst() }}</th>
                    @endforeach
                    @if ($this->puede('editar') || $this->puede('eliminar'))
                        <th class="gp-col-accion">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($proyectos as $fila)
                    <tr wire:key="proy-{{ $fila->IDE_PROYECTO }}">
                        <td class="gp-codigo">{{ $fila->COD_INTERNO }}</td>
                        <td class="gp-codigo">{{ $fila->COD_UNICO }}</td>
                        <td>{{ $fila->DES_LARGA_PROYECTO }}</td>
                        @foreach ($acciones as $clave => [$titulo, $icono, $color, $pagina])
                            @php($url = $this->urlAccion($clave, $fila))
                            <td class="gp-col-accion">
                                @if ($pagina === null)
                                    <a class="gr-ico {{ $color }}" href="{{ $url }}" target="_blank" rel="noopener" title="{{ $titulo }}"><i class="fa-solid {{ $icono }}"></i></a>
                                @else
                                    <button type="button" class="gr-ico {{ $color }}" title="{{ $titulo }}"
                                        data-modal-url="{{ $url }}" data-modal-titulo="{{ $titulo }}" data-modal-subtitulo="{{ trim($fila->COD_INTERNO) }} · {{ \Illuminate\Support\Str::limit($fila->DES_LARGA_PROYECTO, 90) }}">
                                        <i class="fa-solid {{ $icono }}"></i>
                                    </button>
                                @endif
                            </td>
                        @endforeach
                        @if ($this->puede('editar') || $this->puede('eliminar'))
                            <td class="gp-col-accion">
                                @if ($this->puede('editar'))
                                    <button type="button" class="gr-ico gr-ambar" title="Editar proyecto" wire:click="$dispatch('proyecto-editar', { id: {{ (int) $fila->IDE_PROYECTO }} })"><i class="fa-solid fa-pen"></i></button>
                                @endif
                                @if ($this->puede('eliminar'))
                                    <button type="button" class="gr-ico gr-rojo" title="Eliminar proyecto"
                                        wire:click="eliminar({{ (int) $fila->IDE_PROYECTO }})"
                                        wire:confirm="¿Eliminar el proyecto {{ trim($fila->COD_INTERNO) }}? Dejará de mostrarse en las listas."><i class="fa-solid fa-trash-can"></i></button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ 4 + count($acciones) }}" class="gp-vacio">
                            <i class="fa-regular fa-folder-open"></i>
                            {{ $buscar !== '' ? 'No hay proyectos que coincidan con la búsqueda.' : 'No hay proyectos registrados.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINACION --}}
    @if ($proyectos->lastPage() > 1)
        <nav class="gp-paginas" aria-label="Páginas">
            <span>Mostrando {{ $proyectos->firstItem() }}–{{ $proyectos->lastItem() }} de {{ number_format($proyectos->total()) }}</span>
            <div>
                <button type="button" wire:click="gotoPage(1)" @disabled($proyectos->onFirstPage()) title="Primera"><i class="fa-solid fa-angles-left"></i></button>
                <button type="button" wire:click="previousPage" @disabled($proyectos->onFirstPage()) title="Anterior"><i class="fa-solid fa-angle-left"></i></button>
                @foreach (range(max(1, $proyectos->currentPage() - 2), min($proyectos->lastPage(), $proyectos->currentPage() + 2)) as $p)
                    <button type="button" wire:click="gotoPage({{ $p }})" @class(['gp-pagina-actual' => $p === $proyectos->currentPage()])>{{ $p }}</button>
                @endforeach
                <button type="button" wire:click="nextPage" @disabled(! $proyectos->hasMorePages()) title="Siguiente"><i class="fa-solid fa-angle-right"></i></button>
                <button type="button" wire:click="gotoPage({{ $proyectos->lastPage() }})" @disabled(! $proyectos->hasMorePages()) title="Última"><i class="fa-solid fa-angles-right"></i></button>
            </div>
        </nav>
    @endif
</div>
