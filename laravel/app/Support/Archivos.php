<?php

namespace App\Support;

/**
 * Archivos adjuntos (GEN_ARCHIVO), guardados como en el sistema actual: el archivo queda en
 * SGPAM_archivos/<carpeta>/ con el prefijo DDMMAAAA_HHMMSS_, DES_RUTA guarda la carpeta relativa a
 * gepro/Vista ("../../SGPAM_archivos/Contrato/") y DES_ARCHIVO el nombre. La raiz fisica sale de
 * config('gepro.archivos.raiz').
 */
class Archivos
{
    /** [carpeta, titulo, tabla, clave] de una tabla que admite adjuntos, o null */
    public static function tabla(string $tabla): ?array
    {
        $t = config('gepro.archivos.tablas.'.$tabla);

        return is_array($t) ? $t : null;
    }

    /** DES_RUTA que guarda el sistema actual para esa carpeta */
    public static function rutaGuardada(string $carpeta): string
    {
        return '../../SGPAM_archivos/'.$carpeta.'/';
    }

    /** Carpeta fisica de una tabla (se crea si no existe) */
    public static function carpetaFisica(string $carpeta): string
    {
        $ruta = rtrim((string) config('gepro.archivos.raiz'), '\\/').DIRECTORY_SEPARATOR.$carpeta;
        if (! is_dir($ruta)) {
            mkdir($ruta, 0775, true);
        }

        return $ruta;
    }

    /**
     * Nombre con que se guarda un archivo subido: prefijo de fecha y hora, sin tildes ni caracteres
     * raros, y que entre en DES_ARCHIVO (varchar 100)
     */
    public static function nombreGuardado(string $original, ?\DateTimeInterface $momento = null): string
    {
        $momento ??= now();
        $extension = strtolower(pathinfo($original, PATHINFO_EXTENSION));
        $base = pathinfo($original, PATHINFO_FILENAME);
        $base = strtr($base, ['á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u', 'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U', 'ñ' => 'n', 'Ñ' => 'N', 'ü' => 'u', 'Ü' => 'U']);
        $base = trim(preg_replace('/_+/', '_', preg_replace('/[^A-Za-z0-9._-]/', '_', $base)), '_.') ?: 'archivo';
        $prefijo = $momento->format('dmY_His').'_';
        $base = substr($base, 0, 100 - strlen($prefijo) - strlen($extension) - 1);

        return $prefijo.$base.'.'.$extension;
    }

    /** Nombre para mostrar y descargar: sin el prefijo de fecha y hora */
    public static function nombreVisible(string $guardado): string
    {
        return preg_replace('/^\d{8}_\d{6}_/', '', $guardado) ?: $guardado;
    }

    /**
     * Ruta fisica del archivo de una fila de GEN_ARCHIVO, solo si esta dentro de la raiz, en la
     * carpeta que corresponde y existe (misma validacion que gepro/Vista/DescargarArchivo.php)
     */
    public static function rutaReal(object $fila): ?string
    {
        if (! preg_match('#^(\.\./)*SGPAM_archivos/([A-Za-z0-9_]+)/?$#', str_replace('\\', '/', (string) $fila->DES_RUTA), $m)) {
            return null;
        }
        $nombre = (string) $fila->DES_ARCHIVO;
        if ($nombre === '' || $nombre !== basename(str_replace('\\', '/', $nombre)) || preg_match('/[\x00-\x1F]/', $nombre)) {
            return null;
        }
        $raiz = realpath((string) config('gepro.archivos.raiz'));
        $real = $raiz ? realpath($raiz.DIRECTORY_SEPARATOR.$m[2].DIRECTORY_SEPARATOR.$nombre) : false;

        return $real && str_starts_with($real, $raiz.DIRECTORY_SEPARATOR) && is_file($real) ? $real : null;
    }
}
