<div>
    @if ($abierto)
        @php
            $campo = fn (string $nombre, string $etiqueta, string $tipo = 'text', array $extra = []) => compact('nombre', 'etiqueta', 'tipo', 'extra');
            $enlazado = $this->contratoEnlazado();
        @endphp
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ $idContrato ? 'fa-pen-to-square' : 'fa-plus' }}"></i></span>
                    <div>
                        <h2>{{ $idContrato ? 'Editar contrato del proyecto' : 'Registrar contrato del proyecto' }}</h2>
                        <small>{{ $idContrato ? trim(($datos['COD_PROYECTO'] ?? '').' · '.\Illuminate\Support\Str::limit($datos['DES_PROYECTO'] ?? '', 80), ' ·') : 'Los campos con * son obligatorios' }}</small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>

                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    @if ($errors->any() && ! $errors->has('general'))
                        <p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> Revise los campos marcados.</p>
                    @endif
                    @if ($idContrato && $estado !== \App\Livewire\ProyectoContratoFormulario::ESTADO_PROPIO)
                        <p class="fm-aviso"><i class="fa-solid fa-lock"></i> El contrato enlazado, la descripción y el costo actual vienen del contrato y no se pueden modificar.</p>
                    @endif

                    {{-- CONTRATO --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-file-contract"></i> Contrato <small>Busque el contrato para copiar su número, descripción, monto y estado</small></h3>
                        <div class="fm-campos">
                            @unless ($this->bloqueado('COD_PROYECTO'))
                                <div class="fm-campo fm-completo fm-buscador">
                                    <label for="fm-buscar-contrato">Buscar contrato</label>
                                    <div class="fm-buscador-caja">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                        <input id="fm-buscar-contrato" type="search" wire:model.live.debounce.400ms="buscarContrato" placeholder="Código del contrato, código de orden o descripción (mínimo 2 letras)" autocomplete="off">
                                    </div>
                                    @if ($encontrados)
                                        <ul class="fm-resultados">
                                            @foreach ($encontrados as $c)
                                                <li wire:key="c-{{ $c->IDE_CONTRATO }}">
                                                    <button type="button" wire:click="elegirContrato({{ (int) $c->IDE_CONTRATO }})">
                                                        <strong>{{ trim($c->COD_CONTRATO_ENTIDAD) }}</strong>
                                                        <span class="fm-res-codigo">{{ trim($c->COD_UNICO_ORDEN) }}</span>
                                                        <span class="fm-res-desc">{{ \Illuminate\Support\Str::limit(trim($c->DES_CONTRATO), 140) }}</span>
                                                        @if ($c->IMP_TOTAL !== null)<span class="fm-res-monto">S/ {{ number_format((float) $c->IMP_TOTAL, 2) }}</span>@endif
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @elseif (mb_strlen(trim($buscarContrato)) >= 2)
                                        <p class="fm-nota-campo">No se encontraron contratos.</p>
                                    @endif
                                </div>
                            @endunless
                            @include('livewire.partes.campo', ['c' => $campo('COD_PROYECTO', 'Número (cód. orden detalle) *', 'text', ['maxlength' => 30])])
                            <div class="fm-campo">
                                <label>Contrato enlazado</label>
                                <input type="text" value="{{ $enlazado ?? 'Sin contrato' }}" disabled>
                            </div>
                            <div class="fm-campo">
                                <label>Estado</label>
                                <input type="text" value="{{ $combos['EST_PROYECTO_ACTIVIDAD'][$datos['EST_PROYECTO_ACTIVIDAD'] ?? ''] ?? ($datos['EST_PROYECTO_ACTIVIDAD'] ?? '') }}" disabled>
                            </div>
                        </div>
                    </section>

                    {{-- DATOS DEL SERVICIO --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-folder-open"></i> Datos del servicio</h3>
                        <div class="fm-campos">
                            @include('livewire.partes.campo', ['c' => $campo('DES_PROYECTO', 'Descripción del servicio *', 'textarea', ['maxlength' => 1000, 'filas' => 3, 'clase' => 'fm-completo'])])
                            @include('livewire.partes.campo', ['c' => $campo('IDE_INTERVENCION', 'Fase - componente *', 'select', ['opciones' => $combos['IDE_INTERVENCION'], 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('TIP_PROYECTO_ACTIVIDAD', 'Modalidad de gestión', 'select', ['opciones' => $combos['TIP_PROYECTO_ACTIVIDAD'], 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('DES_PROYECTO_ABREV', 'Descripción abreviada', 'text', ['maxlength' => 120, 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('DES_UBICACION', 'Ubicación', 'textarea', ['maxlength' => 500, 'clase' => 'fm-ancho'])])
                        </div>
                    </section>

                    {{-- MONTOS --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-sack-dollar"></i> Montos (S/)</h3>
                        <div class="fm-campos">
                            @include('livewire.partes.campo', ['c' => $campo('IMP_INVERSION', 'Monto de inversión *', 'number', ['min' => 0, 'step' => '0.01', 'clase' => 'fm-numero'])])
                            @include('livewire.partes.campo', ['c' => $campo('IMP_FINANCIADO', 'Monto financiado *', 'number', ['min' => 0, 'step' => '0.01', 'clase' => 'fm-numero'])])
                            @include('livewire.partes.campo', ['c' => $campo('IMP_VALOR_REFERENCIAL', 'Valor referencial', 'number', ['min' => 0, 'step' => '0.01', 'clase' => 'fm-numero'])])
                            @include('livewire.partes.campo', ['c' => $campo('IMP_COSTO_ACTUAL', 'Costo actual *', 'number', ['min' => 0, 'step' => '0.01', 'clase' => 'fm-numero'])])
                        </div>
                    </section>
                </div>

                <div class="fm-panel-pie">
                    <button type="button" class="fm-boton fm-boton-sec" wire:click="cerrar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                    <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar">
                        <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-floppy-disk"></i> {{ $idContrato ? 'Actualizar' : 'Registrar' }}</span>
                        <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
