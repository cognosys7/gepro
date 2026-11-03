<?php
/*
 * DESCARGA DE LOS ARCHIVOS ADJUNTOS (SGPAM_archivos), USADA POR "DESCARGAR" EN GEN_ARCHIVO.
 * - Exige sesion iniciada.
 * - Solo entrega archivos dentro de SGPAM_archivos (se valida la carpeta y el nombre, sin "..").
 * - Descarga con el nombre original: quita el prefijo DDMMAAAA_HHMMSS_ que se agrega al subir.
 * - Se llama desde un iframe oculto (GEN_ARCHIVO.js): si hay un error se avisa con alert en la ventana.
 *
 * Parametros (GET): ruta = carpeta guardada en GEN_ARCHIVO.DES_RUTA (p. ej. ../../SGPAM_archivos/Contrato/)
 *                   archivo = GEN_ARCHIVO.DES_ARCHIVO
 */

//Configuracion.php TIENE BOM: SE DESCARTA CUALQUIER SALIDA ANTES DEL ARCHIVO
ob_start();
require_once(dirname(__DIR__) . '/Configuracion.php');
ob_end_clean();

function DescargarError($codigo, $mensaje)
{
    http_response_code($codigo);
    header('Content-Type: text/html; charset=utf-8');
    echo '<script>try { parent.alert(' . json_encode($mensaje) . '); } catch (e) { }</script>';
    echo htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8');
    exit;
}

if (empty($_SESSION['usuario'])) {
    DescargarError(403, 'Su sesión terminó. Vuelva a ingresar al sistema para descargar el archivo.');
}

$ruta = isset($_GET['ruta']) ? (string)$_GET['ruta'] : '';
$archivo = isset($_GET['archivo']) ? (string)$_GET['archivo'] : '';

//CARPETA: SOLO SGPAM_archivos/<Subcarpeta>/
if (!preg_match('#^(\.\./)*SGPAM_archivos/([A-Za-z0-9_]+)/?$#', str_replace('\\', '/', $ruta), $m)) {
    DescargarError(404, 'El archivo no está disponible para descarga.');
}
$subcarpeta = $m[2];

//NOMBRE: SIN CARPETAS NI CARACTERES DE CONTROL
if ($archivo === '' || $archivo !== basename(str_replace('\\', '/', $archivo)) || preg_match('/[\x00-\x1F]/', $archivo)) {
    DescargarError(404, 'El archivo no está disponible para descarga.');
}

$base = realpath(dirname(__DIR__, 2) . '/SGPAM_archivos');
$real = $base ? realpath($base . DIRECTORY_SEPARATOR . $subcarpeta . DIRECTORY_SEPARATOR . $archivo) : false;
if (!$real || strpos($real, $base . DIRECTORY_SEPARATOR) !== 0 || !is_file($real)) {
    DescargarError(404, 'No se encontró el archivo "' . $archivo . '".');
}

//NOMBRE DE DESCARGA: SIN EL PREFIJO DE FECHA Y HORA DE LA CARGA
$nombre = preg_replace('/^\d{8}_\d{6}_/', '', $archivo);
if ($nombre === '') {
    $nombre = $archivo;
}

$tipos = array(
    'pdf'  => 'application/pdf',
    'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
    'xls'  => 'application/vnd.ms-excel',
    'csv'  => 'text/csv',
    'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
    'doc'  => 'application/msword',
    'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
    'ppt'  => 'application/vnd.ms-powerpoint',
    'jpg'  => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png'  => 'image/png',
    'txt'  => 'text/plain',
);
$extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));
$tipo = isset($tipos[$extension]) ? $tipos[$extension] : 'application/octet-stream';

//NOMBRE PARA NAVEGADORES ANTIGUOS (SOLO ASCII) Y NOMBRE COMPLETO EN UTF-8 (RFC 6266)
$nombreAscii = preg_replace('/[^A-Za-z0-9._ -]/', '_', $nombre);

header('Content-Type: ' . $tipo);
header('Content-Disposition: attachment; filename="' . $nombreAscii . '"; filename*=UTF-8\'\'' . rawurlencode($nombre));
header('Content-Length: ' . filesize($real));
header('X-Content-Type-Options: nosniff');
header('Cache-Control: private, no-store');
readfile($real);
exit;
