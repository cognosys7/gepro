<?php

/*
|--------------------------------------------------------------------------
| GEPRO en Laravel
|--------------------------------------------------------------------------
| Mientras dure la migracion por modulos, Laravel convive con el sistema actual (PHP) sobre la
| misma base BDGEPRO. Las opciones del menu que aun no estan en Laravel se abren en el sistema
| actual, y el puente de sesion (App\Support\PuenteSesionLegado) mantiene al usuario dentro de
| los dos sin volver a pedir la clave.
*/

return [

    // seguridad.tssistema.sisabreviatura del sistema (el menu y los perfiles salen de ahi)
    'sistema' => 'GEPRO',

    // Sistema actual: URL base (sin barra final) y carpeta de sus paginas
    'legado_url' => rtrim((string) env('GEPRO_LEGADO_URL', 'http://localhost:8086'), '/'),
    'legado_vista' => '/gepro/Vista/',

    // Puente de sesion con el sistema actual (se apaga en las pruebas automaticas)
    'puente' => (bool) env('GEPRO_PUENTE', true),

    // Sesion del sistema actual: nombre de la cookie (session.name) y carpeta de las sesiones
    'legado_sesion' => env('GEPRO_LEGADO_SESION', 'GEPROSESSID'),
    'legado_sesion_ruta' => env('GEPRO_LEGADO_SESION_RUTA', ini_get('session.save_path') ?: null),

    // Paginas ya migradas: Pagina del sistema actual => nombre de la ruta de Laravel.
    // El menu las abre en Laravel; las demas siguen en el sistema actual.
    'paginas_migradas' => [
        // 'PROYECTO' => 'proyectos.index',
    ],

];
