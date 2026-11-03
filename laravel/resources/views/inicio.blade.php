@extends('layouts.app', ['titulo' => 'Inicio'])

@section('contenido')
    <div class="gp-tarjeta">
        <div class="gp-hero">
            <div class="gp-hero-texto">
                <p class="gp-saludo">Bienvenido, {{ $usuarioGepro->nombreVisible() }}</p>
                <img class="gp-logo" src="{{ asset('img/gepro_logo.png') }}" alt="GEPRO">
                <h2 class="gp-titulo">Sistema Integral para Oficina de Proyectos (PMO)</h2>
                <p class="gp-descripcion">Planifique, ejecute y controle su portafolio de proyectos: contratos, componentes, riesgos, interesados y presupuesto en un solo lugar, con tableros para la toma de decisiones.</p>
                <ul class="gp-modulos">
                    <li><i class="fa-solid fa-gears"></i>Configuración del proyecto</li>
                    <li><i class="fa-solid fa-briefcase"></i>Gestión del proyecto</li>
                    <li><i class="fa-solid fa-sack-dollar"></i>Presupuesto</li>
                    <li><i class="fa-solid fa-chart-column"></i>Tableros BI</li>
                    <li><i class="fa-solid fa-screwdriver-wrench"></i>Mantenimiento</li>
                    <li><i class="fa-solid fa-shield-halved"></i>Seguridad</li>
                </ul>
            </div>
            {{-- ANILLO CON LAS CINCO FASES (PETROLEO Y VERDE DEL LOGO) --}}
            <div class="gp-hero-grafico" aria-hidden="true">
                <svg viewBox="0 0 300 300">
                    <circle cx="150" cy="150" r="128" fill="#ffffff" fill-opacity=".85"/>
                    <g fill="none" stroke-width="22" transform="rotate(-90 150 150)">
                        <circle cx="150" cy="150" r="110" stroke="#007F8F" stroke-dasharray="132 559.15" stroke-dashoffset="0"/>
                        <circle cx="150" cy="150" r="110" stroke="#2A97A4" stroke-dasharray="132 559.15" stroke-dashoffset="-138.23"/>
                        <circle cx="150" cy="150" r="110" stroke="#56B0BA" stroke-dasharray="132 559.15" stroke-dashoffset="-276.46"/>
                        <circle cx="150" cy="150" r="110" stroke="#3E9E3E" stroke-dasharray="132 559.15" stroke-dashoffset="-414.69"/>
                        <circle cx="150" cy="150" r="110" stroke="#007D00" stroke-dasharray="132 559.15" stroke-dashoffset="-552.92"/>
                    </g>
                    <text x="150" y="146" text-anchor="middle" font-family="Segoe UI, Arial" font-size="40" font-weight="700" fill="#007F8F">PMO</text>
                    <text x="150" y="172" text-anchor="middle" font-family="Segoe UI, Arial" font-size="12" fill="#5a6b78">Portafolio · Programas</text>
                    <text x="150" y="188" text-anchor="middle" font-family="Segoe UI, Arial" font-size="12" fill="#5a6b78">Proyectos</text>
                </svg>
            </div>
        </div>

        <div class="gp-ciclo">
            <h3>Ciclo de vida del proyecto</h3>
            <ul class="gp-fases">
                <li><span class="gp-icono-fase"><i class="fa-solid fa-flag"></i></span><strong>Inicio</strong><span class="gp-detalle">Registro del proyecto, portafolio, programa e interesados.</span></li>
                <li><span class="gp-icono-fase"><i class="fa-solid fa-calendar-days"></i></span><strong>Planificación</strong><span class="gp-detalle">Componentes, actividades, cronograma, costos y riesgos.</span></li>
                <li><span class="gp-icono-fase"><i class="fa-solid fa-gears"></i></span><strong>Ejecución</strong><span class="gp-detalle">Contratos, procesos de selección y gestión social.</span></li>
                <li><span class="gp-icono-fase"><i class="fa-solid fa-eye"></i></span><strong>Seguimiento y control</strong><span class="gp-detalle">Avance, indicadores, acciones correctivas y tableros.</span></li>
                <li><span class="gp-icono-fase"><i class="fa-solid fa-check"></i></span><strong>Cierre</strong><span class="gp-detalle">Entregables, lecciones aprendidas y documentación final.</span></li>
            </ul>
        </div>

        <div class="gp-pie">
            <span>GEPRO · Gestión de Proyectos</span>
            <span class="gp-autor">Desarrollado por <img src="{{ asset('img/cognosys_logo.png') }}" alt="COGNOSYS - The Next Level"></span>
        </div>
    </div>
@endsection
