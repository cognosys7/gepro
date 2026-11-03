<div>
    @if ($abierto)
        @php
            $puede = $this->puedeGrabar();
            $tipos = ['texto' => 'text', 'area' => 'textarea', 'numero' => 'number', 'combo' => 'select', 'fecha' => 'date'];
            $principal = collect($def['campos'])->filter(fn ($c) => in_array($c[1], ['texto', 'area'], true))->keys()->first();
        @endphp
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel fm-panel-angosto" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ ! $puede ? 'fa-eye' : ($idRegistro ? 'fa-pen-to-square' : 'fa-plus') }}"></i></span>
                    <div>
                        <h2>{{ $def['titulo'] }}</h2>
                        <small>{{ ! $puede ? 'Solo consulta' : ($idRegistro ? \Illuminate\Support\Str::limit($datos[$principal] ?? '', 90) : 'Nuevo registro · los campos con * son obligatorios') }}</small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>

                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    @if ($errors->any() && ! $errors->has('general'))
                        <p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> Revise los campos marcados.</p>
                    @endif
                    <section class="fm-seccion">
                        <h3><i class="fa-solid {{ $def['icono'] }}"></i> Datos</h3>
                        <div class="fm-campos">
                            @foreach ($def['campos'] as $campo => [$etiqueta, $tipo, $o])
                                @continue(! empty($o['oculto']))
                                @include('livewire.partes.campo', ['c' => [
                                    'nombre' => $campo,
                                    'etiqueta' => $etiqueta.(! empty($o['requerido']) && ! $this->bloqueado($campo) ? ' *' : ''),
                                    'tipo' => $tipos[$tipo],
                                    'extra' => array_filter([
                                        'opciones' => $combos[$campo] ?? null,
                                        'maxlength' => $o['max'] ?? null,
                                        'step' => $tipo === 'numero' ? 'any' : null,
                                        'clase' => $tipo === 'area' ? 'fm-completo' : ($tipo === 'numero' ? 'fm-numero' : null),
                                    ], fn ($v) => $v !== null),
                                ]])
                            @endforeach
                        </div>
                    </section>
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
