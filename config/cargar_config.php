<?php
// Lee las credenciales desde fuera del web root (ver config.example.php).
if (!function_exists('gepro_config')) {
    function gepro_config() {
        static $config = null;
        if ($config === null) {
            $ruta = getenv('GEPRO_CONFIG') ?: 'C:/gepro_config/config.php';
            if (!is_file($ruta)) {
                error_log("GEPRO: no existe el archivo de configuracion $ruta");
                http_response_code(500);
                exit('Error de configuración del servidor.');
            }
            $config = require $ruta;
        }
        return $config;
    }
}
