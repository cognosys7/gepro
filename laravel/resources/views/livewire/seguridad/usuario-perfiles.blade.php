<div class="gp-grilla">
    <p class="fm-aviso"><i class="fa-solid fa-circle-info"></i> Un perfil por sistema: al asignar otro, reemplaza al que tenía en ese sistema.</p>
    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            <thead>
                <tr>
                    <th>Software</th>
                    <th>Módulo</th>
                    <th>Perfil actual</th>
                    <th>Cambiar a</th>
                    <th class="gp-col-accion gp-col-fija">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($modulos as $id => $m)
                    @php($actuales = $asignados[$id] ?? [])
                    <tr wire:key="mod-{{ $id }}">
                        <td>{{ $m['sistema'] }}</td>
                        <td>{{ $m['modulo'] }}</td>
                        <td>
                            @forelse ($actuales as $perfil)
                                <span class="gp-estado gp-estado-activo">{{ $m['perfiles'][(string) $perfil] ?? $perfil }}</span>
                            @empty
                                <span class="gp-estado">Sin acceso</span>
                            @endforelse
                        </td>
                        <td>
                            @if ($m['perfiles'])
                                <select wire:model="eleccion.{{ $id }}" aria-label="Perfil en {{ $m['sistema'] }}">
                                    <option value="">Seleccione…</option>
                                    @foreach ($m['perfiles'] as $valor => $texto)
                                        <option value="{{ $valor }}">{{ $texto }}</option>
                                    @endforeach
                                </select>
                            @else
                                <span class="gp-texto-suave">El sistema no tiene perfiles</span>
                            @endif
                        </td>
                        <td class="gp-col-accion gp-col-fija">
                            @if ($m['perfiles'])
                                <button type="button" class="gr-ico gr-verde" title="Asignar el perfil elegido" wire:click="asignar({{ $id }})"><i class="fa-solid fa-check"></i></button>
                            @endif
                            @if ($actuales)
                                <button type="button" class="gr-ico gr-rojo" title="Quitar el perfil" wire:click="quitar({{ $id }})"
                                    wire:confirm="¿Quitar el perfil en {{ $m['sistema'] }}? El usuario ya no entrará a ese sistema."><i class="fa-solid fa-ban"></i></button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
