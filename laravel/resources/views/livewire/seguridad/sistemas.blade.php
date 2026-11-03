<div class="gp-grilla">
    @include('livewire.seguridad.partes.barra', ['placeholder' => 'Buscar software o módulo...'])
    <div class="gp-tabla-caja">
        <table class="gp-tabla">
            @include('livewire.seguridad.partes.cabecera')
            <tbody>
                @forelse ($filas as $fila)
                    <tr wire:key="sis-{{ $fila->ID }}">
                        <td>{{ trim((string) $fila->sistema) }}</td>
                        <td>{{ trim((string) $fila->abreviatura) }}</td>
                        <td>{{ trim((string) $fila->modulo) }}</td>
                        <td>{{ trim((string) $fila->url) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="gp-vacio"><i class="fa-regular fa-folder-open"></i> No hay registros.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('livewire.seguridad.partes.paginas')
</div>
