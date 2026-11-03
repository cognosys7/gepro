<?php

namespace App\Services;

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

    /** ['perfil' => upsperfil, 'modulo' => pefmodulo] del usuario en GEPRO, o null si no tiene acceso */
    public function perfil(int $idUsuario): ?array
    {
        if (array_key_exists($idUsuario, $this->perfiles)) {
            return $this->perfiles[$idUsuario];
        }
        $fila = DB::table('seguridad.tssistema as s')
            ->join('seguridad.tsmodulo as m', 'm.modsistema', '=', 's.IdSistema')
            ->join('seguridad.tsperfil as pf', 'pf.pefmodulo', '=', 'm.idmodulo')
            ->join('seguridad.tsusuarioperfil as up', 'up.upsperfil', '=', 'pf.idperfil')
            ->where('s.sisabreviatura', config('gepro.sistema'))
            ->where('up.upsusuario', $idUsuario)
            ->where('up.upsestado', 1)
            ->where('pf.pefestado', 1)
            ->where('m.modestado', 1)
            ->where('s.sisestado', 1)
            ->select('up.upsperfil as perfil', 'pf.pefmodulo as modulo')
            ->first();

        return $this->perfiles[$idUsuario] = $fila ? ['perfil' => (int) $fila->perfil, 'modulo' => (int) $fila->modulo] : null;
    }

    /**
     * Menu del perfil: opciones activas del modulo con acceso del perfil, en arbol (nivel 1 > 2 > 3)
     * y en el orden de OpcOrden. Cada opcion: id, nombre, url, nueva_ventana, icono, hijos.
     */
    public function menu(int $perfil, int $modulo): array
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
        $armar = function (int $padre, int $nivel) use (&$armar, $porPadre) {
            $lista = [];
            foreach ($porPadre[$padre] ?? [] as $o) {
                if ((int) $o->OpcNivel !== $nivel) {
                    continue;
                }
                $hijos = $nivel < 3 ? $armar((int) $o->IdOpcion, $nivel + 1) : [];
                $lista[] = [
                    'id' => (int) $o->IdOpcion,
                    'nombre' => trim((string) $o->OpcDescripcion),
                    'url' => $hijos ? null : $this->url($o),
                    'nueva_ventana' => (int) $o->OpcDestino !== 1,
                    'icono' => $nivel === 1 ? $this->icono((string) $o->OpcDescripcion) : null,
                    'hijos' => $hijos,
                ];
            }

            return $lista;
        };

        return $armar(0, 1);
    }

    /**
     * URL de una opcion: si su pagina ya esta en Laravel (config gepro.paginas_migradas) la ruta de
     * Laravel; si no, la del sistema actual. Los enlaces guardados son relativos a gepro/Vista/
     * ("Antirefresh.php?Pagina=X", "../../SisSeguridad/...") y las paginas del sistema llevan &Op=.
     */
    public function url(object $o): ?string
    {
        //ALGUNOS ENLACES ESTAN GUARDADOS CON ENTIDADES HTML ("&amp;Opcion=110")
        $enlace = trim(html_entity_decode((string) $o->OpcEnlace, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        if ($enlace === '') {
            return null;
        }
        if (preg_match('/[?&]Pagina=([A-Za-z0-9_]+)/', $enlace, $m)) {
            $ruta = config('gepro.paginas_migradas.'.$m[1]);
            if ($ruta) {
                return route($ruta);
            }
        }
        if ((int) $o->OpcTipoEnlace === 1) {
            $enlace .= '&Op='.(int) $o->IdOpcion;
        }
        if (preg_match('#^https?://#i', $enlace)) {
            return $enlace;
        }

        return $this->urlLegado($enlace);
    }

    /** Resuelve un enlace relativo a gepro/Vista/ del sistema actual ("../../SisSeguridad/x" -> /SisSeguridad/x) */
    public function urlLegado(string $relativo): string
    {
        $partes = explode('/', trim(config('gepro.legado_vista'), '/'));
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
