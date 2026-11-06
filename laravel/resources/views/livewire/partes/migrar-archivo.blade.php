{{-- ARCHIVO DE UNA MIGRACION DESDE EXCEL: datos del ultimo archivo y botones de cambiar y revisar --}}
<section class="fm-seccion">
    <h3><i class="fa-solid fa-file-excel"></i> Archivo Excel
        <small>{{ $ayuda }}</small></h3>
    <div class="mg-cuerpo">
        @if ($archivo)
            <div class="mg-archivo">
                <i class="fa-solid fa-file-excel"></i>
                <div>
                    <strong>{{ \App\Support\Archivos::nombreVisible((string) $archivo->DES_ARCHIVO) }}</strong>
                    <span>Cargado el {{ \Illuminate\Support\Carbon::parse($archivo->FEC_CARGA)->format('d/m/Y H:i') }}</span>
                </div>
            </div>
            @unless ($importable)
                <p class="fm-aviso fm-aviso-error">No se puede usar este archivo: no está en el servidor o no es un Excel. Cargue otro.</p>
            @endunless
        @else
            <p class="mg-vacio">Todavía no hay un archivo. Cárguelo para continuar.</p>
        @endif
        <div class="mg-acciones">
            @if ($archivo && $importable)
                <a class="fm-boton fm-boton-sec" href="{{ route('archivos.descargar', ['archivo' => (int) $archivo->IDE_ARCHIVO]) }}"><i class="fa-solid fa-download"></i> Descargar</a>
            @endif
            @if ($puedeGrabar)
                <button type="button" class="fm-boton fm-boton-sec" data-modal-url="{{ $urlArchivos }}" data-modal-titulo="Archivos para migrar" data-modal-subtitulo="Cargue aquí el Excel">
                    <i class="fa-solid fa-upload"></i> {{ $archivo ? 'Cambiar archivo' : 'Cargar archivo' }}
                </button>
            @endif
            @if ($importable && ! $revision)
                <button type="button" class="fm-boton" wire:click="revisar" wire:loading.attr="disabled" wire:target="revisar">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <span wire:loading.remove wire:target="revisar">Revisar archivo</span>
                    <span wire:loading wire:target="revisar">Revisando…</span>
                </button>
            @endif
        </div>
        @if ($error)
            <p class="fm-aviso fm-aviso-error">{{ $error }}</p>
        @endif
    </div>
</section>
