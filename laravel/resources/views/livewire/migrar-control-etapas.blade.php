<div class="mg-pantalla">
    @php($urlArchivos = route('archivos.index', ['tabla' => \App\Livewire\MigrarControlEtapas::TABLA, 'registro' => $contrato]))
    @php($urlImportar = $this->urlImportar())

    <section class="fm-seccion">
        <h3><i class="fa-solid fa-file-excel"></i> Archivo Excel
            <small>Se usa el último archivo cargado para este contrato.</small></h3>
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
                <p class="mg-vacio">Este contrato todavía no tiene un archivo. Cargue el Excel de control para continuar.</p>
            @endif
            <div class="mg-acciones">
                @if ($archivo && $importable)
                    <a class="fm-boton fm-boton-sec" href="{{ route('archivos.descargar', ['archivo' => (int) $archivo->IDE_ARCHIVO]) }}"><i class="fa-solid fa-download"></i> Descargar</a>
                @endif
                @if ($puedeGrabar)
                    <button type="button" class="fm-boton fm-boton-sec" data-modal-url="{{ $urlArchivos }}" data-modal-titulo="Archivos para migrar" data-modal-subtitulo="Cargue aquí el Excel de control">
                        <i class="fa-solid fa-upload"></i> {{ $archivo ? 'Cambiar archivo' : 'Cargar archivo' }}
                    </button>
                @endif
            </div>
        </div>
    </section>

    <section class="fm-seccion">
        <h3><i class="fa-solid fa-circle-info"></i> Qué hará la migración
            <small>Esta operación no se puede deshacer.</small></h3>
        <div class="mg-cuerpo">
            <ul class="mg-lista">
                <li>Lee las hojas 1 Programado, 2 Real y 3 Reprogramado, solo en las filas con <b>CARGAR = 1</b>.</li>
                <li><b>Toma los contratos de la columna CONTRATO del Excel</b>, aunque sean distintos del contrato abierto aquí.</li>
                <li>Reemplaza el control mensual de esos contratos, y crea la etapa y el control anual que falten.</li>
            </ul>
            @if ($puedeGrabar)
                <label class="mg-confirma">
                    <input id="mg-entendido" type="checkbox" wire:model.live="entendido" @disabled(! $importable)>
                    <span>Revisé el archivo y entiendo que reemplazará los datos actuales.</span>
                </label>
            @else
                <p class="fm-aviso">Su perfil es de solo consulta: puede ver el archivo, pero no migrarlo.</p>
            @endif
        </div>
    </section>

    @if ($puedeGrabar)
        <div class="mg-pie">
            <button type="button" class="fm-boton" data-modal-url="{{ $urlImportar }}" data-modal-titulo="Resultado de la migración" data-modal-subtitulo="{{ $archivo ? \App\Support\Archivos::nombreVisible((string) $archivo->DES_ARCHIVO) : '' }}" @disabled(! $importable || ! $entendido)>
                <i class="fa-solid fa-file-import"></i> Migrar
            </button>
        </div>
    @endif
</div>
