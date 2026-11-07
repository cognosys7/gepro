<div class="gp-grilla">
    @include('livewire.seguridad.partes.barra', ['placeholder' => 'Buscar software, módulo o perfil...', 'nuevo' => $this->mantenimiento()])
    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            @include('livewire.seguridad.partes.cabecera', ['acciones' => true])
            <tbody>
                @forelse ($filas as $fila)
                    <tr wire:key="pef-{{ $fila->ID }}">
                        <td>{{ trim((string) $fila->sistema) }}</td>
                        <td>{{ trim((string) $fila->modulo) }}</td>
                        <td>{{ trim((string) $fila->perfil) }}</td>
                        <td class="gp-numero">{{ (int) $fila->usuarios }}</td>
                        <td class="gp-col-accion gp-col-fija">
                            <button type="button" class="gr-ico gr-teal" title="Accesos del perfil"
                                data-modal-url="{{ route('seguridad.accesos', ['perfil' => $fila->ID]) }}" data-modal-titulo="Accesos del perfil"
                                data-modal-subtitulo="{{ trim((string) $fila->perfil) }} · {{ trim((string) $fila->sistema) }}">
                                <i class="fa-solid fa-key"></i>
                            </button>
                            @if ($this->mantenimiento())
                                <button type="button" class="gr-ico gr-ambar" title="Editar" wire:click="editar({{ (int) $fila->ID }})"><i class="fa-solid fa-pen"></i></button>
                                <button type="button" class="gr-ico gr-rojo" title="Eliminar" wire:click="eliminar({{ (int) $fila->ID }})"
                                    wire:confirm="¿Eliminar el perfil {{ trim((string) $fila->perfil) }}?{{ (int) $fila->usuarios > 0 ? ' Lo tienen '.(int) $fila->usuarios.' usuario(s): dejarán de entrar con él.' : '' }}"><i class="fa-solid fa-trash-can"></i></button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="gp-vacio"><i class="fa-regular fa-folder-open"></i> Aún no hay perfiles registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('livewire.seguridad.partes.paginas')

    @if ($abierto)
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel fm-panel-angosto" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ $idPerfil ? 'fa-pen-to-square' : 'fa-plus' }}"></i></span>
                    <div>
                        <h2>Perfil</h2>
                        <small>{{ $idPerfil ? $nombre : 'Nuevo registro · los campos con * son obligatorios' }}</small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>
                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-id-card"></i> Datos</h3>
                        <div class="fm-campos">
                            <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('modulo')])>
                                <label for="fm-modulo">Sistema {{ $idPerfil ? '' : '*' }} @if ($idPerfil)<i class="fa-solid fa-lock fm-candado" title="No se puede modificar"></i>@endif</label>
                                @if ($idPerfil)
                                    <input id="fm-modulo" type="text" value="{{ $modulos[$modulo] ?? '' }}" disabled>
                                @else
                                    <select id="fm-modulo" wire:model="modulo">
                                        <option value="">Seleccione…</option>
                                        @foreach ($modulos as $valor => $texto)
                                            <option value="{{ $valor }}">{{ $texto }}</option>
                                        @endforeach
                                    </select>
                                @endif
                                @error('modulo')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                            <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('nombre')])>
                                <label for="fm-nombre">Perfil *</label>
                                <input id="fm-nombre" type="text" wire:model="nombre" maxlength="100">
                                @error('nombre')<p class="fm-error">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </section>
                </div>
                <div class="fm-panel-pie">
                    <button type="button" class="fm-boton fm-boton-sec" wire:click="cerrar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                    <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar">
                        <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-floppy-disk"></i> {{ $idPerfil ? 'Actualizar' : 'Registrar' }}</span>
                        <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
