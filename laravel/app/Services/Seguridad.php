<?php

namespace App\Services;

use App\Support\Catalogo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Perfil y menu del usuario en GEPRO, con las mismas tablas que los procedimientos del sistema
 * actual (seguridad.paVerificaDatosUsuarioPerfil, paListaOpcionesMenu, paVerificaAccesoxOpcionPerfil),
 * pero con parametros: paListaOpcionesMenu recibe un trozo de SQL armado a mano.
 */
class Seguridad
{
    private array $perfiles = [];

    /** IdSistema de GEPRO (seguridad.tssistema.sisabreviatura) */
    public function sistema(): ?int
    {
        $id = DB::table('seguridad.tssistema')
            ->where('sisabreviatura', config('gepro.sistema'))
            ->where('sisestado', 1)
            ->value('IdSistema');

        return $id === null ? null : (int) $id;
    }

    /** Perfil que solo consulta: no graba ni elimina (UsuarioEvento en LNinclude.php del sistema actual) */
    public const PERFIL_SOLO_CONSULTA = 'CONSULTA TOTAL';

    /**
     * ['perfil' => upsperfil, 'modulo' => pefmodulo, 'nombre' => pefnombre, 'soloConsulta' => bool]
     * del usuario en GEPRO (o en el sistema de esa abreviatura), o null si no tiene acceso
     */
    public function perfil(int $idUsuario, ?string $sistema = null): ?array
    {
        $sistema ??= (string) config('gepro.sistema');
        $clave = $sistema.'|'.$idUsuario;
        if (array_key_exists($clave, $this->perfiles)) {
            return $this->perfiles[$clave];
        }
        $fila = DB::table('seguridad.tssistema as s')
            ->join('seguridad.tsmodulo as m', 'm.modsistema', '=', 's.IdSistema')
            ->join('seguridad.tsperfil as pf', 'pf.pefmodulo', '=', 'm.idmodulo')
            ->join('seguridad.tsusuarioperfil as up', 'up.upsperfil', '=', 'pf.idperfil')
            ->where('s.sisabreviatura', $sistema)
            ->where('up.upsusuario', $idUsuario)
            ->where('up.upsestado', 1)
            ->where('pf.pefestado', 1)
            ->where('m.modestado', 1)
            ->where('s.sisestado', 1)
            ->select('up.upsperfil as perfil', 'pf.pefmodulo as modulo', 'pf.pefnombre as nombre')
            ->first();

        return $this->perfiles[$clave] = $fila ? [
            'perfil' => (int) $fila->perfil,
            'modulo' => (int) $fila->modulo,
            'nombre' => trim((string) $fila->nombre),
            'soloConsulta' => strtoupper(trim((string) $fila->nombre)) === self::PERFIL_SOLO_CONSULTA,
        ] : null;
    }

    /**
     * Perfil del usuario en el sistema de seguridad (GESUSU), solo si es uno de los que administran
     * usuarios y accesos (config gepro.seguridad.perfiles; en el sistema actual, CallNomPerfil() en cada
     * LN de sisSeguridad). A diferencia del sistema actual, no vale el perfil de GEPRO: alli la sesion es
     * la misma y quien no tenia perfil en seguridad se quedaba con el de GEPRO (decidido el 2026-11-03).
     */
    public function perfilSeguridad(int $idUsuario): ?array
    {
        $perfil = $this->perfil($idUsuario, (string) config('gepro.seguridad.sistema'));
        $permitidos = array_map('strtoupper', (array) config('gepro.seguridad.perfiles'));

        return $perfil && in_array(strtoupper($perfil['nombre']), $permitidos, true) ? $perfil : null;
    }

    /** Si el usuario que ingreso puede registrar, editar y eliminar (su perfil no es de solo consulta) */
    public function puedeGrabar(): bool
    {
        $id = Auth::id();
        $perfil = $id ? $this->perfil((int) $id) : null;

        return $perfil !== null && ! $perfil['soloConsulta'];
    }

    /**
     * Menu del perfil: opciones activas del modulo con acceso del perfil, en arbol (nivel 1 > 2 > 3)
     * y en el orden de OpcOrden. Cada opcion: id, nombre, url, nueva_ventana, icono, hijos.
     * $seguridad: menu del sistema de seguridad (sus enlaces son de sisSeguridad/Vista/).
     */
    public function menu(int $perfil, int $modulo, bool $seguridad = false): array
    {
        $opciones = DB::table('seguridad.tsopcion as o')
            ->join('seguridad.tsacceso as a', function ($j) use ($perfil) {
                $j->on('a.AccOpcion', '=', 'o.IdOpcion')->where('a.AccPerfil', $perfil)->where('a.accestado', 1);
            })
            ->where('o.OpcModulo', $modulo)
            ->where('o.OpcEstado', 1)
            ->orderBy('o.OpcOrden')
            ->get(['o.IdOpcion', 'o.OpcNivel', 'o.OpcPadre', 'o.OpcDescripcion', 'o.OpcEnlace', 'o.OpcTipoEnlace', 'o.OpcDestino', 'o.OpcImagen']);

        $porPadre = [];
        foreach ($opciones as $o) {
            $porPadre[(int) $o->OpcNivel === 1 ? 0 : (int) $o->OpcPadre][] = $o;
        }
        $armar = function (int $padre, int $nivel) use (&$armar, $porPadre, $seguridad) {
            $lista = [];
            foreach ($porPadre[$padre] ?? [] as $o) {
                if ((int) $o->OpcNivel !== $nivel) {
                    continue;
                }
                $hijos = $nivel < 3 ? $armar((int) $o->IdOpcion, $nivel + 1) : [];
                $lista[] = [
                    'id' => (int) $o->IdOpcion,
                    'nombre' => trim((string) $o->OpcDescripcion),
                    'url' => $hijos ? null : ($seguridad ? $this->urlSeguridad($o) : $this->url($o)),
                    'nueva_ventana' => (int) $o->OpcDestino !== 1,
                    'icono' => $nivel === 1 ? $this->icono((string) $o->OpcDescripcion) : null,
                    'hijos' => $hijos,
                ];
            }

            return $lista;
        };

        return $armar(0, 1);
    }

    /** Enlace guardado en tsopcion; algunos tienen entidades HTML ("&amp;Opcion=110") */
    private function enlace(object $o): string
    {
        return trim(html_entity_decode((string) $o->OpcEnlace, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
    }

    /**
     * URL de una opcion: si su pagina ya esta en Laravel (config gepro.paginas_migradas) la ruta de
     * Laravel, con los demas parametros del enlace (Opcion=110 -> ?opcion=110); si no, la del sistema
     * actual. Los enlaces guardados son relativos a gepro/Vista/ ("Antirefresh.php?Pagina=X",
     * "../../SisSeguridad/...") y, como en su menu (ConfigPages.php), las opciones de primer nivel
     * llevan &Op=<opcion> y las de los niveles siguientes &Op=<grupo>&Oc=<opcion>: cada pagina del
     * sistema actual valida el acceso con Oc.
     */
    public function url(object $o): ?string
    {
        $enlace = $this->enlace($o);
        if ($enlace === '') {
            return null;
        }
        //SISTEMA DE SEGURIDAD ("../../SisSeguridad/Vista/mainpage.php?"): YA ESTA EN LARAVEL
        if (preg_match('#(^|/)sisSeguridad/#i', $enlace)) {
            return route('seguridad.inicio');
        }
        if (preg_match('/[?&]Pagina=([A-Za-z0-9_]+)/', $enlace, $m)) {
            //CATALOGOS (config/catalogos.php): TODOS EN LA MISMA PANTALLA DE LARAVEL
            if (Catalogo::existe($m[1])) {
                return route('catalogos.index', ['pagina' => $m[1]]);
            }
            //TABLEROS DE POWER BI (config/tableros.php)
            if (is_string(config('tableros.'.$m[1]))) {
                return route('tableros.index', ['pagina' => $m[1]]);
            }
            $ruta = config('gepro.paginas_migradas.'.$m[1]);
            if ($ruta) {
                parse_str((string) parse_url($enlace, PHP_URL_QUERY), $parametros);
                unset($parametros['Pagina']);

                return route($ruta, array_change_key_case($parametros, CASE_LOWER));
            }
        }
        if ((int) $o->OpcTipoEnlace === 1) {
            $enlace .= (int) $o->OpcNivel === 1
                ? '&Op='.(int) $o->IdOpcion
                : '&Op='.(int) $o->OpcPadre.'&Oc='.(int) $o->IdOpcion;
        }
        if (preg_match('#^https?://#i', $enlace)) {
            return $enlace;
        }

        return $this->urlLegado($enlace);
    }

    /**
     * URL de una opcion del menu del sistema de seguridad: sus paginas (config gepro.seguridad.paginas) y
     * su tablero de Power BI estan en Laravel; la descarga de la auditoria es un archivo externo; lo demas
     * (la guia de usuario) es relativo a sisSeguridad/Vista/.
     */
    public function urlSeguridad(object $o): ?string
    {
        $enlace = $this->enlace($o);
        if ($enlace === '') {
            return null;
        }
        if (preg_match('/[?&]Pagina=([A-Za-z0-9_]+)/', $enlace, $m)) {
            if (in_array($m[1], (array) config('gepro.seguridad.paginas'), true)) {
                return route('seguridad.pagina', ['pagina' => $m[1]]);
            }
            if (is_string(config('tableros.'.$m[1]))) {
                return route('seguridad.tablero', ['pagina' => $m[1]]);
            }
            $descarga = config('gepro.seguridad.descargas.'.$m[1]);
            if (is_string($descarga) && $descarga !== '') {
                return $descarga;
            }
        }
        if (preg_match('#^https?://#i', $enlace)) {
            return $enlace;
        }

        return $this->urlLegado($enlace, (string) config('gepro.seguridad.legado_vista'));
    }

    /**
     * Opcion del menu del perfil que abre la pagina indicada con esos parametros
     * (p. ej. PROYECTO con Opcion=211 -> "2.1 Etapa del Contrato"), o null si el perfil no tiene acceso.
     * Devuelve id, padre y nombre.
     */
    public function opcionDePagina(int $perfil, int $modulo, string $pagina, array $parametros = []): ?array
    {
        $opciones = DB::table('seguridad.tsopcion as o')
            ->join('seguridad.tsacceso as a', function ($j) use ($perfil) {
                $j->on('a.AccOpcion', '=', 'o.IdOpcion')->where('a.AccPerfil', $perfil)->where('a.accestado', 1);
            })
            ->where('o.OpcModulo', $modulo)
            ->where('o.OpcEstado', 1)
            ->where('o.OpcEnlace', 'like', '%Pagina='.$pagina.'%')
            ->get(['o.IdOpcion', 'o.OpcPadre', 'o.OpcNivel', 'o.OpcDescripcion', 'o.OpcEnlace']);

        foreach ($opciones as $o) {
            parse_str((string) parse_url($this->enlace($o), PHP_URL_QUERY), $enlace);
            if (($enlace['Pagina'] ?? '') !== $pagina) {
                continue;
            }
            foreach ($parametros as $clave => $valor) {
                if ((string) ($enlace[$clave] ?? '') !== (string) $valor) {
                    continue 2;
                }
            }

            return [
                'id' => (int) $o->IdOpcion,
                'padre' => (int) $o->OpcNivel === 1 ? (int) $o->IdOpcion : (int) $o->OpcPadre,
                'nombre' => trim((string) $o->OpcDescripcion),
            ];
        }

        return null;
    }

    /** Nombre de una opcion del menu (para las migas) */
    public function nombreOpcion(int $id): string
    {
        return trim((string) DB::table('seguridad.tsopcion')->where('IdOpcion', $id)->value('OpcDescripcion'));
    }

    /**
     * Resuelve un enlace relativo a gepro/Vista/ (u otra carpeta $base) del sistema actual
     * ("../../SisSeguridad/x" -> /SisSeguridad/x)
     */
    public function urlLegado(string $relativo, ?string $base = null): string
    {
        $partes = explode('/', trim($base ?? config('gepro.legado_vista'), '/'));
        [$ruta, $consulta] = array_pad(explode('?', $relativo, 2), 2, null);
        foreach (explode('/', $ruta) as $p) {
            if ($p === '..') {
                array_pop($partes);
            } elseif ($p !== '' && $p !== '.') {
                $partes[] = $p;
            }
        }

        return config('gepro.legado_url').'/'.implode('/', $partes).($consulta !== null ? '?'.$consulta : '');
    }

    /** Icono (Font Awesome 6) del grupo del menu segun su nombre */
    public function icono(string $nombre): string
    {
        $n = mb_strtolower($nombre, 'UTF-8');
        $iconos = [
            'tablero' => 'fa-chart-column',
            'configuraci' => 'fa-gears',
            'gesti' => 'fa-briefcase',
            'mantenimiento' => 'fa-screwdriver-wrench',
            'reporte' => 'fa-file-lines',
            'ayuda' => 'fa-circle-question',
            'seguridad' => 'fa-shield-halved',
        ];
        foreach ($iconos as $clave => $icono) {
            if (str_contains($n, $clave)) {
                return $icono;
            }
        }

        return 'fa-table-list';
    }
}
