<div class="gp-grilla">
    @include('livewire.seguridad.partes.barra', ['placeholder' => 'Buscar DNI, usuario o persona...', 'nuevo' => true])
    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            @include('livewire.seguridad.partes.cabecera', ['acciones' => true])
            <tbody>
                @forelse ($filas as $fila)
                    @php($persona = trim((string) $fila->persona))
                    <tr wire:key="usu-{{ $fila->ID }}">
                        <td>{{ trim((string) $fila->dni) }}</td>
                        <td>{{ trim((string) $fila->usuario) }}</td>
                        <td>{{ $persona }}</td>
                        <td class="gp-texto-suave">{{ trim((string) $fila->perfiles) }}</td>
                        <td class="gp-col-accion gp-col-fija">
                            <button type="button" class="gr-ico gr-teal" title="Perfiles del usuario"
                                data-modal-url="{{ route('seguridad.usuario-perfiles', ['usuario' => $fila->ID]) }}" data-modal-titulo="Perfiles del usuario"
                                data-modal-subtitulo="{{ $persona }}"><i class="fa-solid fa-id-card"></i></button>
                            <button type="button" class="gr-ico gr-violeta" title="Reiniciar clave" wire:click="reiniciarClave({{ (int) $fila->ID }})"
                                wire:confirm="¿Reiniciar la clave de {{ $persona }}? Su nueva clave será su DNI."><i class="fa-solid fa-key"></i></button>
                            <button type="button" class="gr-ico gr-ambar" title="Editar" wire:click="editar({{ (int) $fila->ID }})"><i class="fa-solid fa-pen"></i></button>
                            @if ((int) $fila->ID !== (int) auth()->id())
                                <button type="button" class="gr-ico gr-rojo" title="Eliminar" wire:click="eliminar({{ (int) $fila->ID }})"
                                    wire:confirm="¿Eliminar el usuario de {{ $persona }}? Ya no podrá ingresar."><i class="fa-solid fa-trash-can"></i></button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="gp-vacio"><i class="fa-regular fa-folder-open"></i> {{ $buscar !== '' ? 'No hay usuarios que coincidan con la búsqueda.' : 'No hay usuarios.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('livewire.seguridad.partes.paginas')

    @if ($abierto)
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel fm-panel-angosto" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ $idUsuario ? 'fa-pen-to-square' : 'fa-user-plus' }}"></i></span>
                    <div>
                        <h2>Usuario</h2>
                        <small>
                            @if ($idUsuario)
                                {{ trim(($datos['paterno'] ?? '').' '.($datos['materno'] ?? '').' '.($datos['nombres'] ?? '')) }}
                            @elseif ($paso === 'dni')
                                Nuevo usuario · escriba el DNI de la persona
                            @else
                                Nuevo usuario · los campos con * son obligatorios
                            @endif
                        </small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>
                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    @if ($paso === 'dni')
                        <section class="fm-seccion">
                            <h3><i class="fa-solid fa-id-badge"></i> Verificar DNI</h3>
                            <div class="fm-campos">
                                <div @class(['fm-campo', 'fm-completo', 'fm-con-error' => $errors->has('datos.dni')])>
                                    <label for="fm-dni">DNI *</label>
                                    <input id="fm-dni" type="text" wire:model="datos.dni" maxlength="8" inputmode="numeric" autocomplete="off" autofocus>
                                    @error('datos.dni')<p class="fm-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </section>
                    @else
                        @if (! $idUsuario)
                            <p class="fm-aviso">
                                <i class="fa-solid fa-circle-info"></i>
                                @if ($origen === 'persona')
                                    La persona ya estaba registrada; se usan sus datos.
                                @elseif ($origen === 'reniec')
                                    Datos tomados de RENIEC; revíselos antes de registrar.
                                @else
                                    No se encontró el DNI en RENIEC: escriba los datos de la persona.
                                @endif
                                La clave inicial será su DNI.
                            </p>
                        @endif
                        <section class="fm-seccion">
                            <h3><i class="fa-solid fa-user"></i> Datos</h3>
                            <div class="fm-campos">
                                <div class="fm-campo">
                                    <label for="fm-dni">DNI <i class="fa-solid fa-lock fm-candado" title="No se puede modificar"></i></label>
                                    <input id="fm-dni" type="text" value="{{ $datos['dni'] ?? '' }}" disabled>
                                </div>
                                <div @class(['fm-campo', 'fm-con-error' => $errors->has('datos.usuario')])>
                                    <label for="fm-usuario">Usuario</label>
                                    <input id="fm-usuario" type="text" wire:model="datos.usuario" maxlength="20" autocomplete="off" title="Nombre con el que también puede ingresar (además del DNI)">
                                    @error('datos.usuario')<p class="fm-error">{{ $message }}</p>@enderror
                                </div>
                                {{-- PERSONA YA REGISTRADA: paInsertaDatosUsuarioPersonal NO CAMBIA SUS NOMBRES (SE EDITAN LUEGO) --}}
                                @php($bloqueado = ! $idUsuario && $origen === 'persona')
                                @foreach (['paterno' => ['Apellido paterno', 30], 'materno' => ['Apellido materno', 30], 'nombres' => ['Nombres', 40]] as $campo => [$etiqueta, $max])
                                    <div @class(['fm-campo', 'fm-con-error' => $errors->has('datos.'.$campo)])>
                                        <label for="fm-{{ $campo }}">{{ $etiqueta }} *@if ($bloqueado) <i class="fa-solid fa-lock fm-candado" title="Se editan después de registrar"></i>@endif</label>
                                        <input id="fm-{{ $campo }}" type="text" wire:model="datos.{{ $campo }}" maxlength="{{ $max }}" style="text-transform: uppercase" @disabled($bloqueado)>
                                        @error('datos.'.$campo)<p class="fm-error">{{ $message }}</p>@enderror
                                    </div>
                                @endforeach
                                <div @class(['fm-campo', 'fm-con-error' => $errors->has('datos.nacimiento')])>
                                    <label for="fm-nacimiento">Fecha de nacimiento *</label>
                                    <input id="fm-nacimiento" type="date" wire:model="datos.nacimiento" max="{{ now()->subDay()->format('Y-m-d') }}">
                                    @error('datos.nacimiento')<p class="fm-error">{{ $message }}</p>@enderror
                                </div>
                                <div @class(['fm-campo', 'fm-con-error' => $errors->has('datos.sexo')])>
                                    <label>Sexo *</label>
                                    <div class="fm-opciones">
                                        <label><input type="radio" wire:model="datos.sexo" value="1"> Hombre</label>
                                        <label><input type="radio" wire:model="datos.sexo" value="0"> Mujer</label>
                                    </div>
                                    @error('datos.sexo')<p class="fm-error">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
                <div class="fm-panel-pie">
                    @if (! $idUsuario && $paso === 'datos')
                        <button type="button" class="fm-boton fm-boton-sec" wire:click="otroDni"><i class="fa-solid fa-arrow-left"></i> Otro DNI</button>
                    @endif
                    <button type="button" class="fm-boton fm-boton-sec" wire:click="cerrar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                    @if ($paso === 'dni')
                        <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar">
                            <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-magnifying-glass"></i> Verificar</span>
                            <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Buscando…</span>
                        </button>
                    @else
                        <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar">
                            <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-floppy-disk"></i> {{ $idUsuario ? 'Actualizar' : 'Registrar' }}</span>
                            <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endif
</div>
