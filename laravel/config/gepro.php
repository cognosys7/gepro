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
        'PROYECTO' => 'proyectos.index',
    ],

    // Sistema de seguridad (sisSeguridad en el sistema actual): usuarios, perfiles, opciones del menu y accesos.
    // Entra solo quien tiene en ese sistema uno de estos perfiles (decidido el 2026-11-03).
    'seguridad' => [
        'sistema' => env('GEPRO_SEGURIDAD_SISTEMA', 'GESUSU'),
        'perfiles' => ['ADMINISTRADOR', 'GESTOR DE USUARIOS'],
        'legado_vista' => '/sisSeguridad/Vista/',
        // Paginas del menu de seguridad que ya estan en Laravel (/seguridad/{Pagina})
        'paginas' => ['Usuarios', 'Perfil', 'Acceso', 'Opcion', 'Sistema'],
        // Opciones del menu que solo descargan un archivo (PEX_SEG_AUDITORIA: Excel publicado por AMSAC)
        'descargas' => [
            'PEX_SEG_AUDITORIA' => env('GEPRO_SEG_AUDITORIA_URL', 'http://198.150.0.125/SGPAM_archivos/TablerosExcel/SGPAM_SEG_AUDITORIA.xlsm'),
        ],
        // Al registrar un usuario: tipo de documento DNI (general.tgcatalogo) y unidad organica (trpersonal),
        // los mismos valores fijos del sistema actual (UsuariosLN.php / UsuariosVista.php)
        'documento_dni' => 30,
        'unidad_organica' => 59,
    ],

    // Archivos adjuntos (GEN_ARCHIVO): los mismos del sistema actual, en SGPAM_archivos/<carpeta>/.
    // Tabla => [carpeta, titulo, tabla de la base, clave]. Se suben con el prefijo DDMMAAAA_HHMMSS_.
    'archivos' => [
        'raiz' => env('GEPRO_ARCHIVOS', dirname(base_path()).DIRECTORY_SEPARATOR.'SGPAM_archivos'),
        'max_kb' => (int) env('GEPRO_ARCHIVOS_MAX_KB', 51200),
        'extensiones' => ['pdf', 'xlsx', 'xlsm', 'xls', 'csv', 'docx', 'doc', 'pptx', 'ppt', 'jpg', 'jpeg', 'png', 'txt'],
        'tablas' => [
            'CONTRATO' => ['Contrato', 'Contrato', 'dbo.CONTRATO', 'IDE_CONTRATO'],
            'CONTRATO_CONCEPTO' => ['ContratoConcepto', 'Carta fianza del contrato', 'dbo.CONTRATO_CONCEPTO', 'IDE_CONT_CONCEPTO'],
            'CONT_DOCUMENTACION' => ['ContratoDocumentos', 'Documentos del contrato', 'dbo.CONT_DOCUMENTACION', 'IDE_CONT_DOCUM'],
            'CONT_CALIDAD' => ['ContratoEntregables', 'Entregables del contrato', 'dbo.CONT_CALIDAD', 'IDE_CONT_CALIDAD'],
            'PROY_CONT_COMP_CONTROL_DET' => ['ContratoControlDetalle', 'Control mensual del contrato', 'dbo.PROY_CONT_COMP_CONTROL_DET', 'IDE_CONT_ETAPA_CONTROL_DET'],
            'PROY_CONT_AMPLIACION' => ['ContratoAmpliacion', 'Ampliación de plazo del contrato', 'dbo.PROY_CONT_AMPLIACION', 'IDE_CONT_AMPLIACION'],
            'PROY_COMP_SEGUIMIENTO' => ['ContratoComponenteSeguimiento', 'Seguimiento de la etapa del contrato', 'dbo.PROY_COMP_SEGUIMIENTO', 'IDE_SEGUIMIENTO'],
            'PROY_SEGUIMIENTO' => ['ProyectoSeguimiento', 'Seguimiento del proyecto', 'dbo.PROY_SEGUIMIENTO', 'IDE_SEGUIMIENTO'],
            'PROY_GESTION_ACTIVIDADES' => ['ProyectoGestionSocialActividades', 'Actividades de la gestión social del proyecto', 'dbo.PROY_GESTION_ACTIVIDADES', 'IDE_GESTION_ACTIVIDAD'],
            'PROY_GESTION_BENEFICIOS' => ['ProyectoComunidadBeneficios', 'Beneficios de comunidades', 'dbo.PROY_GESTION_BENEFICIOS', 'IDE_BENEF_SOCIAL'],
        ],
    ],

    // Enlaces externos que usan las grillas (los mismos del sistema actual; apuntan a servidores de AMSAC)
    'enlaces' => [
        'sigam' => env('GEPRO_SIGAM_URL', 'http://198.150.0.125/sigam/planes/{codigo}.php'),
        'ficha_tecnica' => env('GEPRO_FICHA_URL', 'https://app.powerbi.com/view?r=eyJrIjoiZDk2MzU1Y2QtNjAxNi00NGFhLWE5MWMtMTViNDUzMTBiNzc0IiwidCI6IjhkNmE0OTg0LThlZTAtNGEzNi1iNDA1LWQ2NzhmNDdmZGE5MSIsImMiOjR9&pageName=ReportSection1f49f22bde5b59240410'),
    ],

];
