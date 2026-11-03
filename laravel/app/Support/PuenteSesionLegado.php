<?php

namespace App\Support;

use App\Auth\UsuarioGepro;
use Illuminate\Support\Facades\DB;

/**
 * Puente con la sesion del sistema actual (sesion nativa de PHP, cookie GEPROSESSID en
 * C:\php85\tmp). Mientras convivan los dos sistemas:
 * - al ingresar por Laravel se abre tambien la sesion del sistema actual, con los mismos datos
 *   que deja su login (intranet/Controlador/LogicaNegocio/PrincipalLN.php), para que las
 *   opciones del menu que siguen alli no pidan la clave otra vez;
 * - si el usuario ya esta en el sistema actual, Laravel lo reconoce (PuenteSesion middleware);
 * - al salir de Laravel se cierran las dos.
 * Las cookies no distinguen el puerto, asi que en localhost funciona aunque cada sistema use
 * su propio puerto. En el servidor deben compartir dominio.
 */
class PuenteSesionLegado
{
    private static function iniciar(?string $id, bool $soloLectura): bool
    {
        if (! config('gepro.puente')) {
            return false;
        }
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        session_name(config('gepro.legado_sesion'));
        if ($ruta = config('gepro.legado_sesion_ruta')) {
            session_save_path($ruta);
        }
        if ($id !== null) {
            if (! preg_match('/^[A-Za-z0-9,-]{16,128}$/', $id)) {
                return false;
            }
            session_id($id);
        }
        session_set_cookie_params(['path' => '/', 'httponly' => true, 'samesite' => 'Lax']);

        return @session_start($soloLectura ? ['read_and_close' => true] : []);
    }

    private static function idCookie(): ?string
    {
        $id = $_COOKIE[config('gepro.legado_sesion')] ?? null;

        return is_string($id) && $id !== '' ? $id : null;
    }

    /** idusuario de la sesion del sistema actual, o null */
    public static function usuario(): ?int
    {
        $id = self::idCookie();
        if ($id === null || ! self::iniciar($id, true)) {
            return null;
        }
        $usuario = $_SESSION['usuario'] ?? null;
        $_SESSION = [];

        return ctype_digit((string) $usuario) ? (int) $usuario : null;
    }

    /** Abre (o actualiza) la sesion del sistema actual para el usuario. $cambiarClave: clave igual al usuario */
    public static function abrir(UsuarioGepro $u, bool $cambiarClave = false): void
    {
        if (! self::iniciar(self::idCookie(), false)) {
            return;
        }
        $_SESSION['usuario'] = (int) $u->id;
        $_SESSION['persona'] = $u->idpersona;
        $_SESSION['personal'] = $u->idpersonal;
        $_SESSION['personaNombre'] = $u->nombre;
        $_SESSION['centroNombre'] = $u->unidad;
        $_SESSION['centroId'] = $u->idunidad;
        $_SESSION['IdPersonaJefe'] = self::jefe((int) $u->idunidad);
        $_SESSION['horaIngreso'] = date('h');
        $_SESSION['minutoIngreso'] = date('i');
        $_SESSION['horarioIngreso'] = date('A');
        $_SESSION['Pantallazo'] = 0;
        $_SESSION['PerfilIntranet'] = 0;
        $_SESSION['SeguridadPass'] = $cambiarClave ? 0 : 1;
        session_write_close();
        $_SESSION = [];
    }

    /** Persona jefe de la unidad organica (como paVerificaUsuarioLoguin), 0 si no tiene */
    private static function jefe(int $idUnidad): int
    {
        $jefe = DB::table('general.UnidadOrganicaJefe as j')
            ->join('general.trpersonal as pr', function ($q) {
                $q->on('j.IdPersonal', '=', 'pr.idpersonal')->where('pr.prhestado', 1);
            })
            ->where('j.estado', 1)
            ->where('j.idunidadorganica', $idUnidad)
            ->value('pr.prhpersona');

        return (int) ($jefe ?? 0);
    }

    /** Cierra la sesion del sistema actual */
    public static function cerrar(): void
    {
        $id = self::idCookie();
        if ($id !== null && self::iniciar($id, false)) {
            $_SESSION = [];
            session_destroy();
        }
        setcookie(config('gepro.legado_sesion'), '', ['expires' => time() - 3600, 'path' => '/', 'httponly' => true, 'samesite' => 'Lax']);
    }
}
