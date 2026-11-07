<div>
    @if ($abierto)
        @php
            $puede = $this->puedeGrabar();
            $tipos = ['texto' => 'text', 'area' => 'textarea', 'numero' => 'number', 'combo' => 'select', 'fecha' => 'date', 'buscador' => 'buscador'];
            //DATO QUE IDENTIFICA EL REGISTRO EN LA CABECERA: 'principal' O EL PRIMER TEXTO DEL FORMULARIO
            $principal = $def['principal'] ?? collect($def['campos'])->filter(fn ($c) => in_array($c[1], ['texto', 'area'], true) && \App\Support\Catalogo::esColumna($c))->keys()->first();
            $resumen = ($def['campos'][$principal ?? ''][1] ?? '') === 'buscador' ? $this->etiquetaBuscador($principal) : ($datos[$principal ?? ''] ?? '');
            //CAMPOS DEL FORMULARIO AGRUPADOS POR SECCION ('seccion' en el campo; por defecto "Datos")
            $secciones = [];
            foreach ($def['campos'] as $campo => $c) {
                if (empty($c[2]['oculto']) && \App\Support\Catalogo::esColumna($c) && $this->visible($campo)) {
                    $secciones[$c[2]['seccion'] ?? 'Datos'][$campo] = $c;
                }
            }
            $conCalculo = ! empty($def['calculo']);
            //CON 'segun', LOS CAMPOS SE MUESTRAN AL ELEGIR (LA LISTA DE 'segun' ENVIA SU VALOR AL MOMENTO)
            $campoSegun = $def['segun']['campo'] ?? null;
            //MODAL ANCHO SI TIENE MUCHOS CAMPOS O ADMITE TEXTOS LARGOS
            $textoLargo = collect($def['campos'])->contains(fn ($c) => $c[1] === 'area' && (int) ($c[2]['max'] ?? 0) >= 500);
            $ancho = count($def['campos']) > 10 || $textoLargo ? '' : 'fm-panel-angosto';
        @endphp
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel {{ $ancho }}" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ ! $puede ? 'fa-eye' : ($idRegistro ? 'fa-pen-to-square' : 'fa-plus') }}"></i></span>
                    <div>
                        <h2>{{ $def['titulo'] }}</h2>
                        <small>{{ ! $puede ? 'Solo consulta' : ($idRegistro ? \Illuminate\Support\Str::limit($resumen, 90) : 'Nuevo registro · los campos con * son obligatorios') }}</small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>

                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    @if (! empty($def['descripcion']) && ! $idRegistro)
                        <p class="fm-intro"><i class="fa-solid fa-circle-info"></i> {{ $def['descripcion'] }}</p>
                    @endif
                    @include('livewire.partes.resumen-errores', ['etiquetas' => collect($def['campos'])->keys()->mapWithKeys(fn ($c) => [$c => $this->etiqueta($c)])->all()])
                    @foreach ($secciones as $nombreSeccion => $camposSeccion)
                        <section class="fm-seccion">
                            <h3>
                                <i class="fa-solid {{ $loop->first ? $def['icono'] : 'fa-calculator' }}"></i> {{ $nombreSeccion }}
                                @if ($conCalculo && $puede && ! $loop->first && $this->calculoAplica())
                                    {{-- CALCULO AUTOMATICO: LOS MONTOS EN VERDE SE CALCULAN SOLOS --}}
                                    <label class="fm-auto-calculo"><input type="checkbox" wire:model.live="autoCalcular"> {{ $def['calculo_texto'] ?? 'Calcular montos automáticamente' }} (en verde)</label>
                                @endif
                            </h3>
                            <div class="fm-campos">
                                @foreach ($camposSeccion as $campo => [$etiqueta, $tipo, $o])
                                    @include('livewire.partes.campo', ['c' => [
                                        'nombre' => $campo,
                                        'etiqueta' => $this->etiqueta($campo).(! empty($o['requerido']) && ! $this->bloqueado($campo) ? ' *' : ''),
                                        'tipo' => $tipos[$tipo],
                                        'extra' => array_filter([
                                            'opciones' => $combos[$campo] ?? null,
                                            'ayuda' => $o['ayuda'] ?? null,
                                            'maxlength' => $o['max'] ?? null,
                                            'step' => $tipo === 'numero' ? 'any' : null,
                                            'clase' => in_array($tipo, ['area', 'buscador'], true) ? 'fm-completo' : ($tipo === 'numero' ? 'fm-numero' : null),
                                            'live' => ($conCalculo && in_array($tipo, ['numero', 'combo', 'fecha'], true)) || $campo === $campoSegun ? true : null,
                                            'auto' => ! empty($o['auto']) && $this->bloqueado($campo) && $puede ? true : null,
                                        ], fn ($v) => $v !== null),
                                    ]])
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>

                <div class="fm-panel-pie">
                    <button type="button" class="fm-boton fm-boton-sec" wire:click="cerrar"><i class="fa-solid fa-xmark"></i> {{ $puede ? 'Cancelar' : 'Cerrar' }}</button>
                    @if ($puede)
                        <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar">
                            <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-floppy-disk"></i> {{ $idRegistro ? 'Actualizar' : 'Registrar' }}</span>
                            <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
                        </button>
                    @endif
                </div>
            </form>
        </div>
    @endif
</div>
