<div class="gp-grilla">
    <div class="gp-grilla-barra">
        <div class="gp-grilla-buscar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" wire:model.live.debounce.400ms="buscar" placeholder="Buscar por código, contrato, descripción, fase, modalidad o estado..." aria-label="Buscar contratos">
        </div>
        <label class="gp-grilla-filas">
            Mostrar
            <select wire:model.live="porPagina">
                @foreach ([10, 25, 50, 100] as $n)
                    <option value="{{ $n }}">{{ $n }}</option>
                @endforeach
            </select>
        </label>
        <span class="gp-grilla-total" wire:loading.remove>{{ number_format($contratos->total()) }} contratos</span>
        <span class="gp-grilla-total" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> Cargando…</span>
        @if ($this->puede('nuevo'))
            <button type="button" class="gp-boton-nuevo" wire:click="$dispatch('contrato-nuevo')"><i class="fa-solid fa-plus"></i> Nuevo contrato</button>
        @endif
    </div>

    @php
        $titulos = ['COD_PROYECTO' => 'Cód. orden det.', 'COD_CONTRATO_ENTIDAD' => 'Cód. contrato', 'DES_PROYECTO' => 'Descripción del servicio',
            'IMP_COSTO_ACTUAL' => 'Costo actual (S/)', 'FEC_INICIO' => 'Inicio', 'FEC_TERMINO' => 'Término', 'INTERVENCION' => 'Fase - componente',
            'TIPO_CONTRATO' => 'Mod. gestión', 'ESTADO' => 'Estado'];
        $conEdicion = $this->puede('editar') || $this->puede('eliminar');
    @endphp

    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            <thead>
                <tr>
                    @foreach ($titulos as $columna => $titulo)
                        <th @class(['gp-ordenable', 'gp-ordenada' => $orden === $columna]) wire:click="ordenarPor('{{ $columna }}')"
                            @if ($columna === 'DES_PROYECTO') style="min-width:280px" @endif>
                            {{ $titulo }}
                            @if ($orden === $columna)
                                <i class="fa-solid {{ $direccion === 'asc' ? 'fa-arrow-up-short-wide' : 'fa-arrow-down-wide-short' }}"></i>
                            @else
                                <i class="fa-solid fa-sort gp-sin-orden"></i>
                            @endif
                        </th>
                    @endforeach
                    @foreach ($acciones as $clave => $accion)
                        <th class="gp-col-accion" title="{{ $accion[0] }}">{{ \Illuminate\Support\Str::of($accion[0])->before(' (')->before(' de ')->ucfirst() }}</th>
                    @endforeach
                    @if ($conEdicion)
                        <th class="gp-col-accion">Acciones</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($contratos as $fila)
                    <tr wire:key="pa-{{ $fila->ID }}">
                        <td class="gp-codigo">{{ $fila->COD_PROYECTO }}</td>
                        <td class="gp-codigo">{{ $fila->COD_CONTRATO_ENTIDAD }}</td>
                        <td>{{ $fila->DES_PROYECTO }}</td>
                        <td class="gp-numero">{{ $fila->IMP_COSTO_ACTUAL !== null ? number_format((float) $fila->IMP_COSTO_ACTUAL, 2) : '' }}</td>
                        <td class="gp-fecha">{{ $fila->FEC_INICIO ? \Illuminate\Support\Carbon::parse($fila->FEC_INICIO)->format('d/m/Y') : '' }}</td>
                        <td class="gp-fecha">{{ $fila->FEC_TERMINO ? \Illuminate\Support\Carbon::parse($fila->FEC_TERMINO)->format('d/m/Y') : '' }}</td>
                        <td>{{ $fila->INTERVENCION }}</td>
                        <td>{{ $fila->TIPO_CONTRATO }}</td>
                        <td>@if ($fila->ESTADO)<span class="gp-estado">{{ $fila->ESTADO }}</span>@endif</td>
                        @foreach ($acciones as $clave => [$titulo, $icono, $color])
                            <td class="gp-col-accion">
                                @if ($this->accionVisible($clave, $fila))
                                    <button type="button" class="gr-ico {{ $color }}" title="{{ $titulo }}"
                                        data-modal-url="{{ $this->urlAccion($clave, $fila) }}" data-modal-titulo="{{ $titulo }}"
                                        data-modal-subtitulo="{{ trim($fila->COD_PROYECTO) }} · {{ \Illuminate\Support\Str::limit($fila->DES_PROYECTO, 90) }}">
                                        <i class="fa-solid {{ $icono }}"></i>
                                    </button>
                                @endif
                            </td>
                        @endforeach
                        @if ($conEdicion)
                            <td class="gp-col-accion">
                                @if ($this->puede('editar'))
                                    <button type="button" class="gr-ico gr-ambar" title="Editar contrato" wire:click="$dispatch('contrato-editar', { id: {{ (int) $fila->ID }} })"><i class="fa-solid fa-pen"></i></button>
                                @endif
                                @if ($this->puede('eliminar') && in_array((int) $fila->TIP_PROYECTO_ACTIVIDAD, \App\Livewire\ProyectoContratosTabla::TIPOS_ELIMINABLES, true))
                                    <button type="button" class="gr-ico gr-rojo" title="Eliminar contrato" wire:click="eliminar({{ (int) $fila->ID }})"
                                        wire:confirm="¿Eliminar el contrato {{ trim($fila->COD_PROYECTO) }}? Dejará de mostrarse en las listas."><i class="fa-solid fa-trash-can"></i></button>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($titulos) + count($acciones) + ($conEdicion ? 1 : 0) }}" class="gp-vacio">
                            <i class="fa-regular fa-folder-open"></i>
                            {{ $buscar !== '' ? 'No hay contratos que coincidan con la búsqueda.' : 'Este proyecto no tiene contratos registrados.' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($contratos->lastPage() > 1)
        <nav class="gp-paginas" aria-label="Páginas">
            <span>Mostrando {{ $contratos->firstItem() }}–{{ $contratos->lastItem() }} de {{ number_format($contratos->total()) }}</span>
            <div>
                <button type="button" wire:click="gotoPage(1)" @disabled($contratos->onFirstPage()) title="Primera"><i class="fa-solid fa-angles-left"></i></button>
                <button type="button" wire:click="previousPage" @disabled($contratos->onFirstPage()) title="Anterior"><i class="fa-solid fa-angle-left"></i></button>
                @foreach (range(max(1, $contratos->currentPage() - 2), min($contratos->lastPage(), $contratos->currentPage() + 2)) as $p)
                    <button type="button" wire:click="gotoPage({{ $p }})" @class(['gp-pagina-actual' => $p === $contratos->currentPage()])>{{ $p }}</button>
                @endforeach
                <button type="button" wire:click="nextPage" @disabled(! $contratos->hasMorePages()) title="Siguiente"><i class="fa-solid fa-angle-right"></i></button>
                <button type="button" wire:click="gotoPage({{ $contratos->lastPage() }})" @disabled(! $contratos->hasMorePages()) title="Última"><i class="fa-solid fa-angles-right"></i></button>
            </div>
        </nav>
    @endif
</div>
