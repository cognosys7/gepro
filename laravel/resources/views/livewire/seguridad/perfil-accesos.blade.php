<div class="gp-grilla">
    <div class="gp-grilla-barra">
        <div class="gp-grilla-buscar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="search" wire:model.live.debounce.400ms="buscar" placeholder="Buscar opción..." aria-label="Buscar">
        </div>
        <span class="gp-grilla-total" wire:loading.remove>{{ $conAcceso }} de {{ $total }} opciones con acceso</span>
        <span class="gp-grilla-total" wire:loading><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
    </div>
    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            <thead>
                <tr>
                    <th>Opción</th>
                    <th>Enlace</th>
                    <th>Acceso</th>
                    <th class="gp-col-accion gp-col-fija">Otorgar / Quitar</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($filas as $fila)
                    <tr wire:key="acc-{{ $fila->idopcion }}">
                        <td @class(['gp-opcion-principal' => (int) $fila->opcnivel === 1]) style="padding-left: {{ 10 + ((int) $fila->opcnivel - 1) * 22 }}px">
                            @if ((int) $fila->opcnivel > 1)<i class="fa-solid fa-turn-up fa-rotate-90 gp-texto-suave"></i>@endif
                            {{ trim((string) $fila->opcdescripcion) }}
                        </td>
                        <td class="gp-texto-suave">{{ \Illuminate\Support\Str::limit(trim(html_entity_decode((string) $fila->opcenlace)), 60) }}</td>
                        <td>
                            @if ((int) $fila->acceso === 1)
                                <span class="gp-estado gp-estado-activo"><i class="fa-solid fa-check"></i> Con acceso</span>
                            @else
                                <span class="gp-estado">Sin acceso</span>
                            @endif
                        </td>
                        <td class="gp-col-accion gp-col-fija">
                            @if ((int) $fila->acceso === 1)
                                <button type="button" class="gr-ico gr-rojo" title="Quitar acceso" wire:click="cambiar({{ (int) $fila->idopcion }}, false)"><i class="fa-solid fa-ban"></i></button>
                            @else
                                <button type="button" class="gr-ico gr-verde" title="Otorgar acceso" wire:click="cambiar({{ (int) $fila->idopcion }}, true)"><i class="fa-solid fa-check"></i></button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="gp-vacio"><i class="fa-regular fa-folder-open"></i> {{ $buscar !== '' ? 'No hay opciones que coincidan con la búsqueda.' : 'El sistema no tiene opciones.' }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
