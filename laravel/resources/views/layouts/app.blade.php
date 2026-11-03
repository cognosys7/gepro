<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $titulo ?? 'Inicio' }} · GEPRO</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gepro.css') }}?v={{ filemtime(public_path('css/gepro.css')) }}">
    @livewireStyles
    @stack('estilos')
</head>
<body>
    <header class="gp-barra">
        <button type="button" class="gp-barra-menu" id="gp-abrir-menu" title="Menú"><i class="fa-solid fa-bars"></i></button>
        <a href="{{ route('inicio') }}" class="gp-barra-marca"><img src="{{ asset('img/cognosys_barra.png') }}" alt="COGNOSYS"></a>
        <div class="gp-barra-titulo">{{ ! empty($areaSeguridad) ? 'SEGURIDAD DEL SISTEMA' : 'SISTEMA INTEGRAL PARA OFICINA DE PROYECTOS (PMO)' }}</div>
        <div class="gp-usuario">
            <button type="button" id="gp-usuario-boton" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-circle-user"></i>
                <span>{{ $usuarioGepro->nombre }}</span>
                <i class="fa-solid fa-caret-down"></i>
            </button>
            <div class="gp-usuario-menu" id="gp-usuario-menu" hidden>
                <div class="gp-usuario-datos">
                    <strong>{{ $usuarioGepro->nombreVisible() }}</strong>
                    {{ $usuarioGepro->unidad }}
                </div>
                <a href="{{ config('gepro.legado_url') }}/intranet/Vista/AntiRefresh.php?Pagina=Clave"><i class="fa-solid fa-key"></i> Cambiar clave</a>
                <form method="POST" action="{{ route('salir') }}">
                    @csrf
                    <button type="submit"><i class="fa-solid fa-right-from-bracket"></i> Salir</button>
                </form>
            </div>
        </div>
    </header>

    <nav class="gp-menu" aria-label="Menú principal">
        <div class="gp-menu-buscar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="gp-menu-buscar" placeholder="Buscar opción..." autocomplete="off">
        </div>
        <ul>
            @if (! empty($areaSeguridad))
                {{-- SISTEMA DE SEGURIDAD: SU MENU, CON UN ENLACE PARA VOLVER A GEPRO --}}
                <li>
                    <a href="{{ route('inicio') }}"><i class="gp-icono fa-solid fa-arrow-left"></i> Volver a GEPRO</a>
                </li>
            @else
                <li @class(['gp-activo' => request()->routeIs('inicio')])>
                    <a href="{{ route('inicio') }}"><i class="gp-icono fa-solid fa-gauge-high"></i> Inicio</a>
                </li>
            @endif
            @foreach ($menuGepro as $opcion)
                @include('layouts.menu-opcion', ['opcion' => $opcion, 'nivel' => 1])
            @endforeach
        </ul>
    </nav>

    <main class="gp-contenido">
        <div class="gp-migas">
            <i class="fa-solid fa-house"></i>
            <a href="{{ route('inicio') }}">Inicio</a>
            @if (! empty($areaSeguridad))
                <i class="fa-solid fa-angle-right"></i>
                <a href="{{ route('seguridad.inicio') }}">Seguridad del sistema</a>
            @endif
            @foreach (($migas ?? []) as $miga)
                <i class="fa-solid fa-angle-right"></i>
                <span class="gp-actual">{{ $miga }}</span>
            @endforeach
        </div>
        {{ $slot ?? '' }}
        @yield('contenido')
    </main>

    <footer class="gp-pie-pagina">PMO - COGNOSYS · SISTEMA PARA OFICINA DE PROYECTOS</footer>

    @livewireScripts
    @include('layouts.partes.modal-avisos')
    <script>
        //MENU DEL USUARIO
        (function () {
            var boton = document.getElementById('gp-usuario-boton');
            var menu = document.getElementById('gp-usuario-menu');
            boton.addEventListener('click', function (e) {
                e.stopPropagation();
                menu.hidden = !menu.hidden;
                boton.setAttribute('aria-expanded', String(!menu.hidden));
            });
            document.addEventListener('click', function () { menu.hidden = true; });
            document.getElementById('gp-abrir-menu').addEventListener('click', function () {
                document.body.classList.toggle('gp-menu-abierto');
            });
        })();

        //BUSCADOR DEL MENU: FILTRA SIN DISTINGUIR MAYUSCULAS NI TILDES; ESC LIMPIA
        (function () {
            var entrada = document.getElementById('gp-menu-buscar');
            var normalizar = function (t) { return t.toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g, ''); };
            var filtrar = function (li, buscado) {
                var detalles = li.querySelector(':scope > details');
                var propio = normalizar(li.querySelector(':scope > a, :scope > details > summary').textContent);
                if (!detalles) {
                    var ve = buscado === '' || propio.indexOf(buscado) >= 0;
                    li.hidden = !ve;
                    return ve;
                }
                var hijos = detalles.querySelectorAll(':scope > ul > li');
                var alguno = false;
                var coincideGrupo = buscado !== '' && propio.indexOf(buscado) >= 0;
                hijos.forEach(function (h) { if (filtrar(h, coincideGrupo ? '' : buscado)) alguno = true; });
                var ve = buscado === '' || coincideGrupo || alguno;
                li.hidden = !ve;
                if (buscado !== '') detalles.open = ve; else detalles.open = detalles.dataset.abierto === '1';
                return ve;
            };
            entrada.addEventListener('input', function () {
                var buscado = normalizar(entrada.value.trim());
                document.querySelectorAll('.gp-menu > ul > li').forEach(function (li) { filtrar(li, buscado); });
            });
            entrada.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') { entrada.value = ''; entrada.dispatchEvent(new Event('input')); }
            });
        })();

        //OPCION ACTIVA DEL MENU: LA QUE LLEVA A ESTA PAGINA (MISMA RUTA Y MISMA opcion); SU GRUPO QUEDA ABIERTO
        (function () {
            var aqui = new URL(location.href);
            document.querySelectorAll('.gp-menu a[href]').forEach(function (a) {
                var destino = new URL(a.href, location.href);
                if (destino.origin !== aqui.origin || destino.pathname !== aqui.pathname || destino.pathname === '/') return;
                if ((destino.searchParams.get('opcion') || '') !== (aqui.searchParams.get('opcion') || '')) return;
                a.classList.add('gp-activo');
                for (var d = a.closest('details'); d; d = d.parentElement.closest('details')) {
                    d.open = true;
                    d.dataset.abierto = '1';
                }
            });
        })();

    </script>
    @stack('scripts')
</body>
</html>
