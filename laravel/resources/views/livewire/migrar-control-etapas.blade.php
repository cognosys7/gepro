<div class="mg-pantalla">
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

    @include('livewire.partes.migrar-archivo', [
        'ayuda' => 'Se usa el último archivo cargado para este contrato.',
        'urlArchivos' => route('archivos.index', ['tabla' => \App\Livewire\MigrarControlEtapas::TABLA, 'registro' => $contrato]),
    ])

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
