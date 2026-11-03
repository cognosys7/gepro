<div class="gp-grilla">
    @include('livewire.seguridad.partes.barra', ['placeholder' => 'Buscar opción...', 'nuevo' => true, 'filtros' => [['filtroModulo', 'Sistema', $modulos]]])
    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            <thead>
                <tr>
                    <th>Software</th>
                    <th>Opción</th>
                    <th>Enlace</th>
                    <th>Abrir</th>
                    <th class="gp-col-accion gp-col-fija">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($filas as $fila)
                    <tr wire:key="opc-{{ $fila->idopcion }}">
                        <td>{{ trim((string) $fila->sisnombre) }}</td>
                        <td @class(['gp-opcion-principal' => (int) $fila->opcnivel === 1]) style="padding-left: {{ 10 + ((int) $fila->opcnivel - 1) * 22 }}px">
                            @if ((int) $fila->opcnivel > 1)<i class="fa-solid fa-turn-up fa-rotate-90 gp-texto-suave"></i>@endif
                            {{ trim((string) $fila->opcdescripcion) }}
                        </td>
                        <td class="gp-texto-suave">{{ \Illuminate\Support\Str::limit(trim(html_entity_decode((string) $fila->opcenlace)), 60) }}</td>
                        <td>{{ (int) $fila->opcdestino === 2 ? 'Otra página' : 'Misma página' }}</td>
                        <td class="gp-col-accion gp-col-fija">
                            <button type="button" class="gr-ico gr-gris" title="Subir" wire:click="mover({{ (int) $fila->idopcion }}, true)" @disabled($fila->primera)><i class="fa-solid fa-arrow-up"></i></button>
                            <button type="button" class="gr-ico gr-gris" title="Bajar" wire:click="mover({{ (int) $fila->idopcion }}, false)" @disabled($fila->ultima)><i class="fa-solid fa-arrow-down"></i></button>
                            <button type="button" class="gr-ico gr-ambar" title="Editar" wire:click="editar({{ (int) $fila->idopcion }})"><i class="fa-solid fa-pen"></i></button>
                            <button type="button" class="gr-ico gr-rojo" title="Eliminar" wire:click="eliminar({{ (int) $fila->idopcion }})"
                                wire:confirm="¿Eliminar la opción {{ trim((string) $fila->opcdescripcion) }}? Dejará de verse en el menú."><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="gp-vacio"><i class="fa-regular fa-folder-open"></i> {{ $buscar !== '' ? 'No hay opciones que coincidan con la búsqueda.' : 'No hay opciones.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('livewire.seguridad.partes.paginas')

    @if ($abierto)
        @php($secundaria = ($datos['nivel'] ?? '1') === '2')
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel fm-panel-angosto" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ $idOpcion ? 'fa-pen-to-square' : 'fa-plus' }}"></i></span>
                    <div>
                        <h2>Opción del menú</h2>
                        <small>{{ $idOpcion ? ($datos['nombre'] ?? '') : 'Nuevo registro · los campos con * son obligatorios' }}</small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>
                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-sitemap"></i> Datos</h3>
                        <div class="fm-campos">
                            <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('datos.nivel')])>
                                <label>Tipo *</label>
                                <div class="fm-opciones">
                                    <label><input type="radio" wire:model.live="datos.nivel" value="1"> Opción principal</label>
                                    <label><input type="radio" wire:model.live="datos.nivel" value="2"> Opción secundaria</label>
                                </div>
                                @error('datos.nivel')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                            <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('datos.modulo')])>
                                <label for="fm-modulo">Sistema *</label>
                                <select id="fm-modulo" wire:model.live="datos.modulo">
                                    <option value="">Seleccione…</option>
                                    @foreach ($modulos as $valor => $texto)
                                        <option value="{{ $valor }}">{{ $texto }}</option>
                                    @endforeach
                                </select>
                                @error('datos.modulo')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                            @if ($secundaria)
                                <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('datos.padre')])>
                                    <label for="fm-padre">Opción principal *</label>
                                    <select id="fm-padre" wire:model="datos.padre">
                                        <option value="">Seleccione…</option>
                                        @foreach ($principales as $valor => $texto)
                                            <option value="{{ $valor }}">{{ $texto }}</option>
                                        @endforeach
                                    </select>
                                    @error('datos.padre')<p class="fm-error">{{ $message }}</p>@enderror
                                </div>
                            @endif
                            <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('datos.nombre')])>
                                <label for="fm-nombre">Nombre *</label>
                                <input id="fm-nombre" type="text" wire:model="datos.nombre" maxlength="100">
                                @error('datos.nombre')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                            <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('datos.enlace')])>
                                <label for="fm-enlace">Enlace</label>
                                <input id="fm-enlace" type="text" wire:model="datos.enlace" maxlength="200" placeholder="Antirefresh.php?Pagina=...">
                                @error('datos.enlace')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                            <div @class(['fm-campo', 'fm-con-error' => $errors->has('datos.destino')])>
                                <label for="fm-destino">Abrir *</label>
                                <select id="fm-destino" wire:model="datos.destino">
                                    <option value="1">En la misma página</option>
                                    <option value="2">En otra página</option>
                                </select>
                                @error('datos.destino')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                            <div @class(['fm-campo', 'fm-con-error' => $errors->has('datos.lightbox')])>
                                <label>Lightbox *</label>
                                <div class="fm-opciones">
                                    <label><input type="radio" wire:model="datos.lightbox" value="1"> Sí</label>
                                    <label><input type="radio" wire:model="datos.lightbox" value="0"> No</label>
                                </div>
                                @error('datos.lightbox')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </section>
                </div>
                <div class="fm-panel-pie">
                    <button type="button" class="fm-boton fm-boton-sec" wire:click="cerrar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                    <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar">
                        <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-floppy-disk"></i> {{ $idOpcion ? 'Actualizar' : 'Registrar' }}</span>
                        <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
