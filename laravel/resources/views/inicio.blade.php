@extends('layouts.app', ['titulo' => 'Inicio'])

@section('contenido')
    @php
        $servicios = [
            ['fa-chart-gantt', 'Seguimiento de proyectos', 'Controle el avance, los hitos, el cronograma y el cumplimiento del plan.', $urlProyectos],
            ['fa-file-contract', 'Control contractual', 'Gestione contratos, cartas fianza, ampliaciones de plazo y control mensual.', $urlProyectos],
            ['fa-shield-halved', 'Gestión de riesgos', 'Identifique y valore a tiempo lo que afecta el plazo, el costo o la calidad.', $urlProyectos],
            ['fa-chart-column', 'Información ejecutiva', 'Tableros e indicadores claros para decidir con mayor confianza.', $urlTableros],
        ];
        $fases = [
            ['Inicio', 'Registro del proyecto, portafolio, programa e interesados.'],
            ['Planificación', 'Componentes, actividades, cronograma, costos y riesgos.'],
            ['Ejecución', 'Contratos, procesos de selección y gestión social.'],
            ['Seguimiento y control', 'Avance, indicadores, acciones correctivas y tableros.'],
            ['Cierre', 'Entregables, lecciones aprendidas y documentación final.'],
        ];
    @endphp

    <div class="gp-tarjeta gp-portada">
        <section class="gp-hero">
            <div class="gp-hero-texto">
                <div class="gp-marca">
                    <img class="gp-logo" src="{{ asset('img/gepro.png') }}" alt="GEPRO">
                    <span>Gestión de portafolio de proyectos</span>
                </div>
                <h1>Todos sus proyectos, <span class="gp-resalte">un solo tablero de control.</span></h1>
                <p class="gp-descripcion">Bienvenido, {{ $usuarioGepro->nombreVisible() }}. Planifique, ejecute y controle su portafolio: contratos, riesgos, interesados y presupuesto en un solo lugar.</p>
                <div class="gp-hero-acciones">
                    @if ($urlProyectos)
                        <a class="gp-accion-principal" href="{{ $urlProyectos }}">Ver proyectos <i class="fa-solid fa-arrow-right"></i></a>
                    @endif
                    @if ($urlTableros)
                        <a class="gp-accion-secundaria" href="{{ $urlTableros }}">Abrir tableros</a>
                    @endif
                </div>
            </div>

            <div class="gp-panel">
                <div class="gp-panel-cabecera">
                    <div>
                        <strong>Panel de control GEPRO</strong>
                        <span>Portafolio de proyectos</span>
                    </div>
                    <em>HOY</em>
                </div>
                <ul class="gp-indicadores">
                    @foreach ($indicadores as [$nombre, $icono, $valor])
                        <li>
                            <i class="fa-solid {{ $icono }}"></i>
                            <b>{{ number_format($valor) }}</b>
                            <span>{{ $nombre }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>

        <section class="gp-seccion gp-seccion-suave">
            <p class="gp-antetitulo">Qué incluye</p>
            <h2>Control y visibilidad <span class="gp-resalte">de cada proyecto</span></h2>
            <div class="gp-servicios">
                @foreach ($servicios as [$icono, $nombre, $detalle, $url])
                    <{{ $url ? 'a' : 'div' }} class="gp-servicio" @if ($url) href="{{ $url }}" @endif>
                        <span class="gp-servicio-icono"><i class="fa-solid {{ $icono }}"></i></span>
                        <strong>{{ $nombre }}</strong>
                        <span>{{ $detalle }}</span>
                    </{{ $url ? 'a' : 'div' }}>
                @endforeach
            </div>
        </section>

        <section class="gp-seccion">
            <p class="gp-antetitulo">Metodología</p>
            <h2>Ciclo de vida <span class="gp-resalte">del proyecto</span></h2>
            <ol class="gp-fases">
                @foreach ($fases as [$nombre, $detalle])
                    <li>
                        <span class="gp-numero">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <strong>{{ $nombre }}</strong>
                        <span>{{ $detalle }}</span>
                    </li>
                @endforeach
            </ol>
        </section>

        <div class="gp-pie">
            <span>GEPRO · Sistema Integral para Oficina de Proyectos (PMO)</span>
            <span class="gp-autor">Desarrollado por <img src="{{ asset('img/cognosys_logo.png') }}" alt="COGNOSYS - The Next Level"></span>
        </div>
    </div>
@endsection
