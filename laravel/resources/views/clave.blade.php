<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cambiar clave · GEPRO</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gepro.css') }}?v={{ filemtime(public_path('css/gepro.css')) }}">
</head>
<body>
    <main class="gp-ingreso">
        <div class="gp-ingreso-caja">
            <form method="POST" action="{{ route('clave.grabar') }}" novalidate>
                @csrf
                <img class="gp-logo" src="{{ asset('img/gepro_logo.png') }}" alt="GEPRO">
                <h1>{{ $obligatoria ? 'Por seguridad, debe cambiar su clave' : 'Cambiar clave' }}</h1>

                <div class="gp-campo">
                    <label for="actual">Clave actual</label>
                    <div class="gp-entrada">
                        <i class="fa-solid fa-lock"></i>
                        <input id="actual" name="actual" type="password" autocomplete="current-password" maxlength="100" required autofocus>
                    </div>
                    @error('actual')<p class="gp-error">{{ $message }}</p>@enderror
                </div>

                <div class="gp-campo">
                    <label for="clave">Clave nueva (mínimo 6 caracteres)</label>
                    <div class="gp-entrada">
                        <i class="fa-solid fa-key"></i>
                        <input id="clave" name="clave" type="password" autocomplete="new-password" maxlength="100" required>
                    </div>
                    @error('clave')<p class="gp-error">{{ $message }}</p>@enderror
                </div>

                <div class="gp-campo">
                    <label for="clave_confirmation">Repita la clave nueva</label>
                    <div class="gp-entrada">
                        <i class="fa-solid fa-key"></i>
                        <input id="clave_confirmation" name="clave_confirmation" type="password" autocomplete="new-password" maxlength="100" required>
                    </div>
                </div>

                <button type="submit" class="gp-boton"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
            </form>

            <div class="gp-ingreso-pie">
                @if ($obligatoria)
                    <form method="POST" action="{{ route('salir') }}">
                        @csrf
                        <button type="submit" class="fm-enlace">Salir</button>
                    </form>
                @else
                    <a href="{{ route('inicio') }}">Volver</a>
                @endif
            </div>
        </div>
    </main>
</body>
</html>
