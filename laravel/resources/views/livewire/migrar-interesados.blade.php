<div class="mg-pantalla">
    @if ($resultado)
        <p class="mg-exito"><i class="fa-solid fa-circle-check"></i> Los interesados se migraron correctamente.</p>
        <section class="fm-seccion">
            <h3><i class="fa-solid fa-table-list"></i> Resultado</h3>
            <div class="mg-cuerpo">
                <table class="mg-tabla">
                    <tbody>
                        <tr><td>Interesados agregados</td><td>{{ number_format($resultado['interesados']) }}</td></tr>
                        <tr><td>Enlaces a gestión social agregados</td><td>{{ number_format($resultado['sociales']) }}</td></tr>
                        <tr><td>Interesados que ya existían, sin cambios</td><td>{{ number_format($resultado['existentes']) }}</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    @endif

    @include('livewire.partes.migrar-archivo', [
        'ayuda' => 'Es una sola matriz para toda la entidad y puede incluir varios proyectos.',
        'urlArchivos' => route('archivos.index', ['tabla' => \App\Livewire\MigrarInteresados::TABLA, 'registro' => \App\Support\ImportarInteresados::REGISTRO]),
    ])

    @if ($revision)
        <section class="fm-seccion">
            <h3><i class="fa-solid fa-list-check"></i> Revisión del archivo
                <small>Todavía no se grabó nada.</small></h3>
            <div class="mg-cuerpo">
                <table class="mg-tabla">
                    <tbody>
                        <tr><td>Filas a cargar</td><td>{{ number_format($revision['cargar']) }}</td></tr>
                        <tr><td>Filas omitidas (CARGAR = 0)</td><td>{{ number_format($revision['omitir']) }}</td></tr>
                        <tr><td>Interesados nuevos</td><td>{{ number_format($revision['nuevos']) }}</td></tr>
                        <tr><td>Ya existen y no cambiarán</td><td>{{ number_format($revision['existentes']) }}</td></tr>
                        <tr><td>Filas con gestión social (CARGAR = 2)</td><td>{{ number_format($revision['social']) }}</td></tr>
                        <tr><td>Contratos</td><td>{{ number_format($revision['contratos']) }}</td></tr>
                    </tbody>
                </table>
                <p class="mg-dato"><b>Proyectos en el archivo:</b> {{ implode(', ', $revision['proyectos']) ?: '—' }}</p>
                @unless ($revision['incluyeAbierto'])
                    <p class="fm-aviso">El archivo no incluye el proyecto desde el que abrió esta pantalla.</p>
                @endunless
                @if (array_sum($revision['catalogos']))
                    <p class="mg-dato"><b>Se crearán en los catálogos:</b> {{ $revision['catalogos']['DES_RECURSO'] }} recurso(s), {{ $revision['catalogos']['DES_ROL'] }} rol(es) y {{ $revision['catalogos']['DES_CARGO'] }} cargo(s).</p>
                @endif
                @if ($revision['avisos'])
                    <div class="fm-aviso">
                        <strong>Avisos. No impiden migrar:</strong>
                        <ul class="mg-lista">
                            @foreach ($revision['avisos'] as $texto)
                                <li>{{ $texto }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                        <li>Agrega los interesados nuevos a <b>todos los proyectos del archivo</b>, no solo al proyecto abierto.</li>
                        <li>No cambia ni borra a quienes ya están en el contrato.</li>
                        <li>Crea en los catálogos los recursos, roles y cargos que no existan.</li>
                    </ul>
                    @if ($puedeGrabar)
                        <label class="mg-confirma">
                            <input id="mg-entendido" type="checkbox" wire:model.live="entendido">
                            <span>Revisé el resultado y entiendo qué se agregará.</span>
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
