<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ingreso · GEPRO</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gepro.css') }}?v={{ filemtime(public_path('css/gepro.css')) }}">
</head>
<body>
    <main class="gp-ingreso">
        <form class="gp-ingreso-caja" method="POST" action="{{ route('ingreso') }}" novalidate>
            @csrf
            <img class="gp-logo" src="{{ asset('img/gepro_logo.png') }}" alt="GEPRO">
            <h1>Sistema Integral para Oficina de Proyectos (PMO)</h1>

            <div class="gp-campo">
                <label for="usuario">Usuario</label>
                <div class="gp-entrada">
                    <i class="fa-solid fa-user"></i>
                    <input id="usuario" name="usuario" type="text" value="{{ old('usuario') }}" autocomplete="username" maxlength="50" autofocus required>
                </div>
                @error('usuario')<p class="gp-error">{{ $message }}</p>@enderror
            </div>

            <div class="gp-campo">
                <label for="clave">Clave</label>
                <div class="gp-entrada">
                    <i class="fa-solid fa-lock"></i>
                    <input id="clave" name="clave" type="password" autocomplete="current-password" maxlength="100" required>
                </div>
                @error('clave')<p class="gp-error">{{ $message }}</p>@enderror
            </div>

            <div class="gp-campo">
                <label for="captcha">¿Cuánto es?</label>
                <div class="gp-captcha">
                    <span class="gp-suma">{{ $captcha }} =</span>
                    <div class="gp-entrada" style="flex:1">
                        <input id="captcha" name="captcha" type="text" inputmode="numeric" maxlength="3" autocomplete="off" required>
                    </div>
                </div>
                @error('captcha')<p class="gp-error">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="gp-boton"><i class="fa-solid fa-right-to-bracket"></i> Ingresar</button>

            <div class="gp-ingreso-pie">
                Desarrollado por
                <img src="{{ asset('img/cognosys_logo.png') }}" alt="COGNOSYS">
            </div>
        </form>
    </main>
</body>
</html>
