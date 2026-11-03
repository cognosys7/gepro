<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $titulo ?? 'GEPRO' }} · GEPRO</title>
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gepro.css') }}?v={{ filemtime(public_path('css/gepro.css')) }}">
    @livewireStyles
</head>
{{-- PANTALLAS DE LARAVEL QUE SE ABREN DENTRO DE LA VENTANA MODAL (SIN BARRA NI MENU) --}}
<body class="gp-embebido">
    @yield('contenido')

    @livewireScripts
    @include('layouts.partes.modal-avisos')
    <script>
        //ESC: CIERRA LA VENTANA MODAL DE LA PAGINA PADRE, SALVO QUE AQUI HAYA UN FORMULARIO O UNA VENTANA ABIERTOS
        document.addEventListener('keydown', function (e) {
            if (e.key !== 'Escape' || document.querySelector('.fm-fondo') || document.getElementById('gp-modal').open) return;
            if (window.parent !== window) window.parent.postMessage('gepro:cerrar', location.origin);
        });
    </script>
</body>
</html>
