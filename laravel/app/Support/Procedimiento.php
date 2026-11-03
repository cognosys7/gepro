<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use PDO;
use RuntimeException;

/**
 * Llama a los procedimientos de BDGEPRO que graban datos (Insert/Update/Delete de SP_<TABLA>), con
 * parametros (nunca texto armado) y leyendo sus parametros de salida @pIdError y @pMensajeError.
 * Los SP atrapan sus errores con TRY/CATCH y los devuelven en esos parametros: si @pMensajeError no
 * es 'OK' se lanza una excepcion con su mensaje.
 */
class Procedimiento
{
    /**
     * @param  string  $sp  p. ej. 'dbo.SP_PROYECTO'
     * @param  array  $parametros  nombre (sin @) => valor; '' se envia como NULL, igual que el sistema actual
     * @return array{id: string, mensaje: string}
     */
    public static function grabar(string $sp, string $accion, array $parametros, bool $exigirOk = true): array
    {
        return self::ejecutar($sp, ['TipoAccion' => $accion] + $parametros, $exigirOk);
    }

    /**
     * Igual que grabar(), para los procedimientos que no tienen @TipoAccion (los de seguridad: p. ej.
     * seguridad.paInsertaDatosPerfil). En ellos @pIdError dice que paso: 1 registrado, 2 ya existe,
     * 3 actualizado, 4 eliminado (siempre con @pMensajeError = 'OK').
     *
     * @return array{id: string, mensaje: string}
     */
    public static function ejecutar(string $sp, array $parametros, bool $exigirOk = true): array
    {
        if (! preg_match('/^[A-Za-z0-9_]+\.[A-Za-z0-9_]+$/', $sp)) {
            throw new RuntimeException('Nombre de procedimiento no válido.');
        }
        $partes = [];
        $valores = [];
        foreach ($parametros as $nombre => $valor) {
            if (! preg_match('/^[A-Za-z0-9_]+$/', $nombre)) {
                throw new RuntimeException('Nombre de parámetro no válido.');
            }
            $partes[] = '@'.$nombre.' = ?';
            $valores[] = ($valor === '' ? null : $valor);
        }
        $partes[] = '@pIdError = ?';
        $partes[] = '@pMensajeError = ?';

        $pdo = DB::connection()->getPdo();
        $sentencia = $pdo->prepare('SET NOCOUNT ON; EXEC '.$sp.' '.implode(', ', $partes));
        $i = 1;
        foreach ($valores as $valor) {
            $sentencia->bindValue($i++, $valor, $valor === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
        }
        $idError = str_repeat(' ', 10);
        $mensaje = str_repeat(' ', 200);
        $sentencia->bindParam($i++, $idError, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 10);
        $sentencia->bindParam($i, $mensaje, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 200);
        $sentencia->execute();
        //LOS PARAMETROS DE SALIDA SE LLENAN AL TERMINAR DE LEER TODOS LOS RESULTADOS
        while ($sentencia->nextRowset()) {
        }

        $resultado = ['id' => trim((string) $idError), 'mensaje' => trim((string) $mensaje)];
        if ($exigirOk && $resultado['mensaje'] !== '' && strtoupper($resultado['mensaje']) !== 'OK') {
            throw new RuntimeException($resultado['mensaje']);
        }

        return $resultado;
    }
}
