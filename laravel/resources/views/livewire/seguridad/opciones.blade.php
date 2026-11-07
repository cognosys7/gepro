<div class="op" x-data>
    {{-- UNA PESTAÑA POR SISTEMA --}}
    <div class="op-pestanas" role="tablist" aria-label="Sistema">
        @foreach ($modulos as $id => $nombre)
            <button type="button" role="tab" @class(['op-pestana', 'op-pestana-activa' => (string) $id === $filtroModulo])
                aria-selected="{{ (string) $id === $filtroModulo ? 'true' : 'false' }}" wire:click="verModulo('{{ $id }}')">
                <i class="fa-solid fa-cube"></i> {{ \Illuminate\Support\Str::before($nombre, ' · ') }}
                <span class="op-contador">{{ $cuentas[$id] ?? 0 }}</span>
            </button>
        @endforeach
    </div>

    <div class="gp-grilla-barra">
        <div class="gp-grilla-buscar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" wire:model.live.debounce.400ms="buscar" placeholder="Buscar opción..." aria-label="Buscar">
        </div>
        <button type="button" class="gp-boton-sec" x-on:click="$dispatch('op-todas', true)"><i class="fa-solid fa-angles-down"></i> Expandir</button>
        <button type="button" class="gp-boton-sec" x-on:click="$dispatch('op-todas', false)"><i class="fa-solid fa-angles-up"></i> Contraer</button>
        <span class="gp-grilla-total" wire:loading.remove>{{ count(array_filter($grupos, fn ($g) => $g['principal'])) }} principales · {{ $total }} opciones</span>
        <span class="gp-grilla-total" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> Cargando…</span>
        <button type="button" class="gp-boton-nuevo" wire:click="nuevo"><i class="fa-solid fa-plus"></i> Nueva opción principal</button>
    </div>

    <div class="op-grupos">
        @forelse ($grupos as $g)
            @php($p = $g['principal'])
            {{-- LA CLAVE LLEVA LA BUSQUEDA: AL BUSCAR, LOS GRUPOS VUELVEN A ABRIRSE --}}
            <section class="op-grupo" wire:key="grp-{{ $p?->idopcion ?? 'sueltas' }}-{{ md5($buscar) }}"
                x-data="{ abierto: true }" x-on:op-todas.window="abierto = $event.detail" :class="{ 'op-cerrado': ! abierto }">
                <header class="op-grupo-cabecera">
                    <button type="button" class="op-plegar" x-on:click="abierto = ! abierto" :aria-expanded="abierto" title="Mostrar u ocultar sus opciones">
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <span class="op-grupo-icono"><i class="fa-solid {{ $p ? 'fa-folder-open' : 'fa-triangle-exclamation' }}"></i></span>
                    <div class="op-grupo-titulo">
                        @if ($p)
                            <strong>{{ trim((string) $p->opcdescripcion) }}</strong>
                            <small>
                                {{ count($g['hijas']) }} {{ count($g['hijas']) === 1 ? 'opción' : 'opciones' }}
                                @if (($d = \App\Livewire\Seguridad\Opciones::destino($p->opcenlace)) !== '')
                                    · abre <code>{{ $d }}</code>
                                @endif
                            </small>
                        @else
                            <strong>Sin opción principal</strong>
                            <small>Su opción principal ya no existe: edítelas para moverlas a otra.</small>
                        @endif
                    </div>
                    @if ($p)
                        @include('livewire.seguridad.partes.opcion-perfiles', ['o' => $p])
                        <button type="button" class="gp-boton-sec op-agregar" wire:click="nuevaSecundaria({{ (int) $p->idopcion }})" title="Agregar una opción dentro de {{ trim((string) $p->opcdescripcion) }}">
                            <i class="fa-solid fa-plus"></i> Secundaria
                        </button>
                        @include('livewire.seguridad.partes.opcion-acciones', ['o' => $p])
                    @endif
                </header>
                <ul class="op-hijas" x-show="abierto">
                    @forelse ($g['hijas'] as $h)
                        @php($d = \App\Livewire\Seguridad\Opciones::destino($h->opcenlace))
                        <li class="op-hija" wire:key="opc-{{ $h->idopcion }}">
                            <span class="op-hija-nombre">{{ trim((string) $h->opcdescripcion) }}</span>
                            <span class="op-destino" title="{{ trim(html_entity_decode((string) $h->opcenlace)) }}">
                                @if ($d !== '')
                                    <code>{{ \Illuminate\Support\Str::limit($d, 45) }}</code>
                                @else
                                    <em>Sin enlace</em>
                                @endif
                                @if ((int) $h->opcdestino === 2)
                                    <i class="fa-solid fa-arrow-up-right-from-square" title="Se abre en otra página"></i>
                                @endif
                            </span>
                            @include('livewire.seguridad.partes.opcion-perfiles', ['o' => $h])
                            @include('livewire.seguridad.partes.opcion-acciones', ['o' => $h])
                        </li>
                    @empty
                        <li class="op-hija op-hija-vacia">
                            Sin opciones secundarias.
                            <button type="button" class="op-enlace" wire:click="nuevaSecundaria({{ (int) $p->idopcion }})">Agregar la primera</button>
                        </li>
                    @endforelse
                </ul>
            </section>
        @empty
            <div class="gp-vacio"><i class="fa-regular fa-folder-open"></i> {{ $buscar !== '' ? 'No hay opciones que coincidan con la búsqueda.' : 'Este sistema no tiene opciones.' }}</div>
        @endforelse
    </div>

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
                                <label>Abrir en ventana emergente *</label>
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
