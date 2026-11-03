<?php
// Plantilla. Copiar a C:\gepro_config\config.php (fuera del web root) y completar.
// Otra ruta: definir la variable de entorno GEPRO_CONFIG con la ruta completa del archivo.
return [
    'db' => [
        'host'     => 'SERVIDOR\INSTANCIA',
        'database' => 'BDGEPRO',
        'user'     => 'usuario_gepro',
        'password' => '',
    ],
    'db_reniec' => [
        'host'     => 'SERVIDOR\INSTANCIA',
        'database' => 'BDRENIEC',
        'user'     => 'usuario_gepro',
        'password' => '',
    ],
];
