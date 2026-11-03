<div>
    @php($puede = $this->puedeGrabar())
    <div class="gp-grilla">
        <div class="gp-grilla-barra">
            <div class="gp-grilla-buscar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="search" wire:model.live.debounce.400ms="buscar" placeholder="Buscar archivo..." aria-label="Buscar">
            </div>
            <span class="gp-grilla-total" wire:loading.remove>{{ number_format($filas->total()) }} archivos</span>
            <span class="gp-grilla-total" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> Cargando…</span>
            @if ($puede)
                <button type="button" class="gp-boton-nuevo" wire:click="nuevo"><i class="fa-solid fa-upload"></i> Cargar archivo</button>
            @endif
        </div>

        <div class="gp-tabla-caja">
            <table class="gp-tabla">
                <thead>
                    <tr>
                        <th style="width:55%">Archivo</th>
                        <th>Fecha de carga</th>
                        <th>Estado</th>
                        <th class="gp-col-accion gp-col-fija">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($filas as $fila)
                        @php($estado = trim((string) $fila->EST_ARCHIVO))
                        <tr wire:key="arc-{{ (int) $fila->IDE_ARCHIVO }}">
                            <td><i class="fa-regular fa-file"></i> {{ \App\Support\Archivos::nombreVisible(trim((string) $fila->DES_ARCHIVO)) }}</td>
                            <td>{{ $fila->FEC_CARGA ? \Illuminate\Support\Carbon::parse($fila->FEC_CARGA)->format('Y-m-d H:i:s') : '' }}</td>
                            <td><span @class(['gp-estado', 'gp-estado-activo' => $estado === '1'])>{{ $estados[$estado] ?? $estado }}</span></td>
                            <td class="gp-col-accion gp-col-fija">
                                <a class="gr-ico gr-teal" title="Descargar" href="{{ route('archivos.descargar', ['archivo' => (int) $fila->IDE_ARCHIVO]) }}"><i class="fa-solid fa-download"></i></a>
                                @if ($puede)
                                    <button type="button" class="gr-ico gr-ambar" title="Editar" wire:click="editar('{{ (int) $fila->IDE_ARCHIVO }}')"><i class="fa-solid fa-pen"></i></button>
                                    <button type="button" class="gr-ico gr-rojo" title="Eliminar" wire:click="eliminar('{{ (int) $fila->IDE_ARCHIVO }}')"
                                        wire:confirm="¿Eliminar este archivo? Dejará de mostrarse en la lista."><i class="fa-solid fa-trash-can"></i></button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="gp-vacio">
                                <i class="fa-regular fa-folder-open"></i>
                                {{ $buscar !== '' ? 'No hay archivos que coincidan con la búsqueda.' : 'No hay archivos adjuntos.' }}
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
                    <button type="button" wire:click="previousPage" @disabled($filas->onFirstPage()) title="Anterior"><i class="fa-solid fa-angle-left"></i></button>
                    <button type="button" class="gp-pagina-actual">{{ $filas->currentPage() }}</button>
                    <button type="button" wire:click="nextPage" @disabled(! $filas->hasMorePages()) title="Siguiente"><i class="fa-solid fa-angle-right"></i></button>
                </div>
            </nav>
        @endif
    </div>

    @if ($abierto)
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel fm-panel-angosto" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ $idArchivo ? 'fa-pen-to-square' : 'fa-upload' }}"></i></span>
                    <div>
                        <h2>{{ $idArchivo ? 'Editar archivo' : 'Cargar archivo' }}</h2>
                        <small>{{ implode(', ', config('gepro.archivos.extensiones')) }} · hasta {{ (int) round(config('gepro.archivos.max_kb') / 1024) }} MB</small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>
                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    <section class="fm-seccion">
                        <div class="fm-campos">
                            <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('archivo')])>
                                <label for="fm-archivo">{{ $idArchivo ? 'Reemplazar el archivo (opcional)' : 'Archivo *' }}</label>
                                <input id="fm-archivo" type="file" wire:model="archivo" accept=".{{ implode(',.', config('gepro.archivos.extensiones')) }}">
                                <div wire:loading wire:target="archivo"><i class="fa-solid fa-spinner fa-spin"></i> Subiendo…</div>
                                @error('archivo')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                            <div @class(['fm-campo', 'fm-con-error' => $errors->has('estado')])>
                                <label for="fm-estado">Estado *</label>
                                <select id="fm-estado" wire:model="estado">
                                    @foreach ($this->estados() as $valor => $texto)
                                        <option value="{{ $valor }}">{{ $texto }}</option>
                                    @endforeach
                                </select>
                                @error('estado')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </section>
                </div>
                <div class="fm-panel-pie">
                    <button type="button" class="fm-boton fm-boton-sec" wire:click="cerrar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                    <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar,archivo">
                        <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-floppy-disk"></i> {{ $idArchivo ? 'Actualizar' : 'Cargar' }}</span>
                        <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
