<div>
    @if ($abierto)
        @php
            //CAMPO DE TEXTO / NUMERO / FECHA
            $campo = function (string $nombre, string $etiqueta, string $tipo = 'text', array $extra = []) {
                return compact('nombre', 'etiqueta', 'tipo', 'extra');
            };
        @endphp
        <div class="fm-fondo" wire:keydown.escape="cerrar">
            <form class="fm-panel" wire:submit="guardar" novalidate>
                <div class="fm-panel-cabecera">
                    <span class="fm-panel-icono"><i class="fa-solid {{ $idProyecto ? 'fa-pen-to-square' : 'fa-plus' }}"></i></span>
                    <div>
                        <h2>{{ $idProyecto ? 'Editar proyecto' : 'Registrar proyecto' }}</h2>
                        <small>{{ $idProyecto ? trim(($datos['COD_INTERNO'] ?? '').' · '.\Illuminate\Support\Str::limit($datos['DES_LARGA_PROYECTO'] ?? '', 80), ' ·') : 'Los campos con * son obligatorios' }}</small>
                    </div>
                    <button type="button" class="fm-panel-cerrar" wire:click="cerrar" title="Cerrar (Esc)">&times;</button>
                </div>

                <div class="fm-panel-cuerpo">
                    @error('general')<p class="fm-aviso fm-aviso-error"><i class="fa-solid fa-triangle-exclamation"></i> {{ $message }}</p>@enderror
                    @if (! $idProyecto)
                        <p class="fm-intro"><i class="fa-solid fa-circle-info"></i> Reúna en un solo lugar los datos, la ubicación y el seguimiento del proyecto.</p>
                    @endif
                    @include('livewire.partes.resumen-errores', ['etiquetas' => $this->etiquetasError()])
                    @if ($idProyecto && $estado !== \App\Livewire\ProyectoFormulario::ESTADO_PROPIO)
                        <p class="fm-aviso"><i class="fa-solid fa-lock"></i> Los datos de origen del proyecto (códigos, descripción, montos, fechas y centro de costo) no se pueden modificar.</p>
                    @endif

                    {{-- DATOS GENERALES --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-folder-open"></i> Datos generales</h3>
                        <div class="fm-campos">
                            @include('livewire.partes.campo', ['c' => $campo('COD_INTERNO', 'Código de proyecto', 'text', ['maxlength' => 12])])
                            @include('livewire.partes.campo', ['c' => $campo('DES_LARGA_PROYECTO', 'Nombre completo del proyecto *', 'textarea', ['ayuda' => 'El nombre oficial, tal como figura en el expediente.', 'maxlength' => 500, 'clase' => 'fm-completo'])])
                            @include('livewire.partes.campo', ['c' => $campo('IDE_ETAPA_CONTRATO', 'Etapa actual del proyecto *', 'select', ['opciones' => $combos['IDE_ETAPA_CONTRATO'], 'clase' => 'fm-ancho'])])
                            <div class="fm-campo">
                                <label>Estado</label>
                                <input type="text" value="{{ $combos['EST_PROYECTO'][$estado] ?? $estado }}" disabled>
                            </div>
                            @include('livewire.partes.campo', ['c' => $campo('IDE_PORTAFOLIO', 'Portafolio *', 'select', ['ayuda' => 'Agrupa proyectos relacionados de una misma intervención.', 'opciones' => $combos['IDE_PORTAFOLIO']])])
                            @include('livewire.partes.campo', ['c' => $campo('IDE_PROGRAMA', 'Programa', 'select', ['ayuda' => 'Conjunto mayor al que pertenece el proyecto. Ej.: una cuenca.', 'opciones' => $combos['IDE_PROGRAMA'], 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('IDE_CENCOSTO', 'Centro de costo', 'select', ['opciones' => $combos['IDE_CENCOSTO'], 'clase' => 'fm-ancho'])])
                        </div>
                    </section>

                    {{-- I. DESCRIPCION DEL PROYECTO --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-location-dot"></i> Ubicación y alcance <small>Ubicación, área de intervención, cuenca hidrográfica, número de PAM's, stakeholder</small></h3>
                        <div class="fm-campos">
                            @include('livewire.partes.campo', ['c' => $campo('DES_UBICACION_PROYECTO', 'Ubicación del proyecto', 'textarea', ['maxlength' => 1000, 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('DES_AREA_INTERVENCION', 'Área de intervención ambiental (m²)', 'textarea', ['maxlength' => 1000, 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('DES_CUENCA_HIDROGRAFICA', 'Cuenca hidrográfica', 'textarea', ['maxlength' => 1000, 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('DES_STAKEHOLDER', 'Actores clave del proyecto', 'textarea', ['ayuda' => 'Personas o grupos a los que afecta el proyecto. Ej.: Comunidad campesina de Quiulacocha.', 'maxlength' => 1000, 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('NUM_PAMS', 'N° de pasivos a remediar', 'number', ['min' => 0, 'step' => 1])])
                            @include('livewire.partes.campo', ['c' => $campo('DES_ESTATUS', 'Componentes de remediación', 'textarea', ['ayuda' => 'Qué se va a remediar. Ej.: 28 bocaminas, 25 desmontes.', 'maxlength' => 4000, 'filas' => 3, 'clase' => 'fm-completo'])])
                        </div>
                    </section>

                    {{-- II. GESTION SOCIAL --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-users"></i> Gestión social</h3>
                        <div class="fm-campos">
                            @include('livewire.partes.campo', ['c' => $campo('DES_ACCION_GESTION_SOCIAL', 'Objetivo general de la gestión social', 'textarea', ['maxlength' => 4000, 'clase' => 'fm-completo'])])
                        </div>
                    </section>

                    {{-- III. PANTALLAS RELACIONADAS (SE ABREN EN LA VENTANA MODAL, ENCIMA DEL FORMULARIO) --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-list-check"></i> Seguimiento del proyecto <small>Describir los objetivos específicos, acciones, oportunidades de mejora, costos y seguimiento</small></h3>
                        @if ($idProyecto)
                            <div class="fm-enlaces">
                                @foreach (\App\Livewire\ProyectoFormulario::RELACIONADAS as $pagina => [$titulo, $icono])
                                    <button type="button" class="fm-enlace" data-modal-url="{{ $this->urlRelacionada($pagina) }}" data-modal-titulo="{{ $titulo }}"
                                        data-modal-subtitulo="{{ trim(($datos['COD_INTERNO'] ?? '').' · '.\Illuminate\Support\Str::limit($datos['DES_LARGA_PROYECTO'] ?? '', 90), ' ·') }}">
                                        <i class="fa-solid {{ $icono }}"></i>{{ $titulo }}
                                    </button>
                                @endforeach
                            </div>
                        @else
                            <p class="fm-nota"><i class="fa-solid fa-circle-info"></i> Disponible después de registrar el proyecto.</p>
                        @endif
                    </section>

                    {{-- PROYECTO DE INVERSION PUBLICA --}}
                    <section class="fm-seccion">
                        <h3><i class="fa-solid fa-briefcase"></i> Inversión pública</h3>
                        <div class="fm-campos">
                            @include('livewire.partes.campo', ['c' => $campo('COD_UNICO', 'Código único', 'text', ['ayuda' => 'CUI del Banco de Inversiones.', 'maxlength' => 10])])
                            @include('livewire.partes.campo', ['c' => $campo('COD_SNIP', 'Código SNIP', 'text', ['maxlength' => 10])])
                            @include('livewire.partes.campo', ['c' => $campo('TIP_PROYECTO', 'Tipo de proyecto', 'select', ['opciones' => $combos['TIP_PROYECTO'], 'clase' => 'fm-ancho'])])
                            @include('livewire.partes.campo', ['c' => $campo('IMP_APROBADO_LOC', 'Monto aprobado (S/)', 'number', ['min' => 0, 'step' => '0.01', 'clase' => 'fm-numero'])])
                            @include('livewire.partes.campo', ['c' => $campo('NUM_BENEFICIARIOS', 'N° de beneficiarios', 'number', ['min' => 0, 'step' => 1, 'clase' => 'fm-numero'])])
                            @include('livewire.partes.campo', ['c' => $campo('FEC_APROBACION', 'Fecha de aprobación', 'date')])
                            @include('livewire.partes.campo', ['c' => $campo('FEC_INICIO_PROY', 'Fecha de inicio', 'date')])
                            @include('livewire.partes.campo', ['c' => $campo('FEC_TERMINO_PROY', 'Fecha de término', 'date')])
                            @include('livewire.partes.campo', ['c' => $campo('DES_PROYECTO_ENGLISH', 'Descripción en inglés', 'textarea', ['maxlength' => 200, 'clase' => 'fm-completo'])])
                        </div>
                    </section>
                </div>

                <div class="fm-panel-pie">
                    <button type="button" class="fm-boton fm-boton-sec" wire:click="cerrar"><i class="fa-solid fa-xmark"></i> Cancelar</button>
                    <button type="submit" class="fm-boton" wire:loading.attr="disabled" wire:target="guardar">
                        <span wire:loading.remove wire:target="guardar"><i class="fa-solid fa-floppy-disk"></i> {{ $idProyecto ? 'Actualizar' : 'Registrar' }}</span>
                        <span wire:loading wire:target="guardar"><i class="fa-solid fa-spinner fa-spin"></i> Grabando…</span>
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>
