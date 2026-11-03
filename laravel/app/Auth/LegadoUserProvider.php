<?php

namespace App\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Support\Facades\DB;

/**
 * Usuarios de la base actual (BDGEPRO, esquema seguridad), con la misma regla de clave que el
 * login del sistema actual (intranet/Controlador/LogicaNegocio/PrincipalLN.php):
 *   usuclave = md5(USUNOMBRE + clave + 'Cognosys@SAC')
 * donde usuario y clave pasan antes por Reemplazar(), addslashes() y htmlspecialchars(), y se
 * puede ingresar con usunombre o con usuldap.
 * Mientras convivan los dos sistemas las claves siguen en md5; el paso a password_hash se hace
 * cuando el login quede solo en Laravel.
 */
class LegadoUserProvider implements UserProvider
{
    private const SAL = 'Cognosys@SAC';

    //CONSULTA BASE: USUARIO ACTIVO CON PERSONA, PERSONAL Y UNIDAD ORGANICA ACTIVOS (COMO paVerificaUsuarioLoguin)
    private function consulta()
    {
        return DB::table('seguridad.tsusuario as u')
            ->join('general.tgpersona as p', 'p.IdPersona', '=', 'u.usupersona')
            ->join('general.trpersonal as r', 'r.prhpersona', '=', 'p.IdPersona')
            ->join('general.tgunidadorganica as uo', 'uo.IdUnidadOrganica', '=', 'r.prhunidadorganica')
            ->where('u.usuestado', 1)
            ->where('p.PerEstado', 1)
            ->where('r.prhestado', 1)
            ->where('uo.UorEstado', 1)
            ->select([
                'u.idusuario as id',
                'u.usunombre',
                DB::raw('UPPER(u.usuldap) as usuldap'),
                DB::raw("p.PerApePaterno + ' ' + p.PerApeMaterno + ' ' + p.PerNombres as nombre"),
                'p.IdPersona as idpersona',
                'r.idpersonal',
                'uo.UorNombre as unidad',
                'uo.IdUnidadOrganica as idunidad',
            ]);
    }

    private function usuario(?object $fila, bool $conClave = false): ?UsuarioGepro
    {
        if (! $fila) {
            return null;
        }
        $datos = (array) $fila;
        if (! $conClave) {
            unset($datos['usuclave']);
        }

        return new UsuarioGepro($datos);
    }

    public function retrieveById($identifier)
    {
        if (! ctype_digit((string) $identifier)) {
            return null;
        }

        return $this->usuario($this->consulta()->where('u.idusuario', (int) $identifier)->first());
    }

    public function retrieveByToken($identifier, #[\SensitiveParameter] $token)
    {
        return null;
    }

    public function updateRememberToken(Authenticatable $user, #[\SensitiveParameter] $token)
    {
        //SIN "RECORDARME": LA SESION DURA LO QUE DURA EL NAVEGADOR
    }

    public function retrieveByCredentials(#[\SensitiveParameter] array $credentials)
    {
        $usuario = self::usuarioIngresado($credentials['usuario'] ?? '');
        if ($usuario === '') {
            return null;
        }
        $fila = $this->consulta()
            ->addSelect('u.usuclave')
            ->where(function ($q) use ($usuario) {
                $q->where('u.usunombre', $usuario)->orWhereRaw('UPPER(u.usuldap) = ?', [$usuario]);
            })
            ->first();

        return $this->usuario($fila, true);
    }

    public function validateCredentials(Authenticatable $user, #[\SensitiveParameter] array $credentials)
    {
        $guardada = strtolower(trim((string) ($user->usuclave ?? '')));
        $calculada = self::claveLegado($credentials['usuario'] ?? '', $credentials['clave'] ?? '', (string) $user->usunombre, (string) $user->usuldap);

        return $guardada !== '' && $calculada !== null && hash_equals($guardada, $calculada);
    }

    public function rehashPasswordIfRequired(Authenticatable $user, #[\SensitiveParameter] array $credentials, bool $force = false)
    {
        //LAS CLAVES LAS COMPARTE EL SISTEMA ACTUAL: NO SE CAMBIAN DESDE AQUI
    }

    /** Limpieza que el login actual aplica a lo que escribe el usuario (Reemplazar + addslashes + htmlspecialchars) */
    public static function limpiar(string $valor): string
    {
        $valor = str_ireplace(["'", ';', '%', 'SELECT', 'UPDATE', 'DELETE'], ['0', '', '', '', '', ''], $valor);

        return htmlspecialchars(addslashes(trim($valor)));
    }

    public static function usuarioIngresado(string $usuario): string
    {
        return strtoupper(self::limpiar($usuario));
    }

    /** md5 que guarda seguridad.tsusuario.usuclave, o null si el usuario no coincide con usunombre ni con usuldap */
    public static function claveLegado(string $usuario, #[\SensitiveParameter] string $clave, string $usunombre, string $usuldap): ?string
    {
        $usuario = self::usuarioIngresado($usuario);
        if ($usuario === $usunombre) {
            $base = $usuario;
        } elseif ($usuario === $usuldap) {
            $base = $usunombre;
        } else {
            return null;
        }

        return md5($base.self::limpiar($clave).self::SAL);
    }
}
