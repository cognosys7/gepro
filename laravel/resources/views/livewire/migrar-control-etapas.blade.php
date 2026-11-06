<div class="mg-pantalla">
    @php($urlArchivos = route('archivos.index', ['tabla' => \App\Livewire\MigrarControlEtapas::TABLA, 'registro' => $contrato]))

    @if ($resultado)
        <p class="mg-exito"><i class="fa-solid fa-circle-check"></i> El control de etapas se migró correctamente.</p>
        <section class="fm-seccion">
            <h3><i class="fa-solid fa-table-list"></i> Resultado</h3>
            <div class="mg-cuerpo">
                <table class="mg-tabla">
                    <thead><tr><th>Hoja</th><th>Filas migradas</th></tr></thead>
                    <tbody>
                        @foreach ($resultado as $hoja)
                            <tr><td>{{ $hoja['nombre'] }}</td><td>{{ number_format($hoja['migradas']) }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    @endif

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

    @if ($revision)
        <section class="fm-seccion">
            <h3><i class="fa-solid fa-list-check"></i> Revisión del archivo
                <small>Todavía no se grabó nada.</small></h3>
            <div class="mg-cuerpo">
                <table class="mg-tabla">
                    <thead><tr><th>Hoja</th><th>Filas a migrar</th><th>Filas omitidas</th></tr></thead>
                    <tbody>
                        @foreach ($revision['hojas'] as $hoja)
                            <tr><td>{{ $hoja['nombre'] }}</td><td>{{ number_format($hoja['cargar']) }}</td><td>{{ number_format($hoja['omitir']) }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
                <p class="mg-dato"><b>Contrato en el archivo:</b> {{ implode(', ', $revision['contratos']) ?: '—' }}</p>
                @if ($revision['errores'])
                    <div class="fm-aviso fm-aviso-error">
                        <strong>Corrija el Excel y cárguelo de nuevo. No se puede migrar por lo siguiente:</strong>
                        <ul class="mg-lista">
                            @foreach ($revision['errores'] as $texto)
                                <li>{{ $texto }}</li>
                            @endforeach
                        </ul>
                        @if ($revision['mas_errores'])
                            <p>Y {{ number_format($revision['mas_errores']) }} error(es) más.</p>
                        @endif
                    </div>
                @endif
            </div>
        </section>

        @if (! $revision['errores'])
            <section class="fm-seccion">
                <h3><i class="fa-solid fa-circle-info"></i> Qué hará la migración
                    <small>Si algo falla, no se aplica ningún cambio. Una vez terminada, no se puede deshacer.</small></h3>
                <div class="mg-cuerpo">
                    <ul class="mg-lista">
                        <li>Reemplaza el control mensual de este contrato con las filas del archivo.</li>
                        <li>Crea la etapa y el control anual que falten.</li>
                        <li>Borra definitivamente las filas del control mensual que estaban marcadas como eliminadas, <b>en todos los contratos</b>.</li>
                    </ul>
                    @if ($puedeGrabar)
                        <label class="mg-confirma">
                            <input id="mg-entendido" type="checkbox" wire:model.live="entendido">
                            <span>Revisé el resultado y entiendo que reemplazará los datos actuales.</span>
                        </label>
                    @else
                        <p class="fm-aviso">Su perfil es de solo consulta: puede revisar el archivo, pero no migrarlo.</p>
                    @endif
                </div>
            </section>

            @if ($puedeGrabar)
                <div class="mg-pie">
                    <button type="button" class="fm-boton" wire:click="migrar" wire:loading.attr="disabled" wire:target="migrar" @disabled(! $entendido)>
                        <i class="fa-solid fa-file-import"></i>
                        <span wire:loading.remove wire:target="migrar">Migrar</span>
                        <span wire:loading wire:target="migrar">Migrando…</span>
                    </button>
                </div>
            @endif
        @endif
    @endif
</div>
