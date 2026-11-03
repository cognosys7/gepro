<?php

namespace App\Http\Controllers;

use App\Services\Seguridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Sistema de seguridad (antes sisSeguridad): Usuarios, Perfil, Acceso, Opcion y Software, mas las
 * ventanas que se abren desde ellos (perfiles de un usuario y accesos de un perfil). Cada pagina exige
 * acceso a su opcion en el menu del perfil de seguridad (middleware 'seguridad').
 */
class SeguridadController extends Controller
{
    /** Pagina del sistema actual => [componente Livewire, icono, descripcion] */
    private const PAGINAS = [
        'Usuarios' => ['seguridad.usuarios', 'fa-users', 'Usuarios del sistema, su clave y sus perfiles.'],
        'Perfil' => ['seguridad.perfiles', 'fa-id-card', 'Perfiles de cada sistema.'],
        'Acceso' => ['seguridad.perfiles', 'fa-key', 'Opciones del menú a las que entra cada perfil.'],
        'Opcion' => ['seguridad.opciones', 'fa-sitemap', 'Opciones del menú de cada sistema y su orden.'],
        'Sistema' => ['seguridad.sistemas', 'fa-cubes', 'Sistemas y módulos registrados. Solo consulta.'],
    ];

    /** Primera pagina del menu a la que entra el perfil */
    public function inicio(Request $request, Seguridad $seguridad)
    {
        $perfil = $request->attributes->get('perfilSeguridad');
        foreach (array_keys(self::PAGINAS) as $pagina) {
            if ($seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], $pagina)) {
                return redirect()->route('seguridad.pagina', ['pagina' => $pagina]);
            }
        }
        abort(403, 'Su perfil no tiene acceso a ninguna opción del sistema de seguridad.');
    }

    public function pagina(Request $request, Seguridad $seguridad, string $pagina)
    {
        abort_unless(isset(self::PAGINAS[$pagina]) && in_array($pagina, (array) config('gepro.seguridad.paginas'), true), 404);
        $menu = $this->opcion($request, $seguridad, $pagina);
        [$componente, $icono, $descripcion] = self::PAGINAS[$pagina];
        $grupo = $menu['padre'] !== $menu['id'] ? $seguridad->nombreOpcion($menu['padre']) : null;

        return view('seguridad.index', [
            'titulo' => $menu['nombre'],
            'migas' => array_values(array_filter([$grupo, $menu['nombre']])),
            'pagina' => $pagina,
            'componente' => $componente,
            //PERFIL Y ACCESO USAN LA MISMA GRILLA DE PERFILES (EN ACCESO SOLO SE ABREN SUS ACCESOS)
            'parametros' => $componente === 'seguridad.perfiles' ? ['pagina' => $pagina] : [],
            'icono' => $icono,
            'descripcion' => $descripcion,
        ]);
    }

    /** Tablero de Power BI del menu de seguridad (PBI_SEG_USUARIOS_ROL) */
    public function tablero(Request $request, Seguridad $seguridad, string $pagina)
    {
        $url = config('tableros.'.$pagina);
        abort_unless(is_string($url) && str_starts_with($url, 'https://'), 404);
        $menu = $this->opcion($request, $seguridad, $pagina);
        $grupo = $menu['padre'] !== $menu['id'] ? $seguridad->nombreOpcion($menu['padre']) : null;

        return view('tableros.index', [
            'titulo' => $menu['nombre'],
            'migas' => array_values(array_filter([$grupo, $menu['nombre']])),
            'url' => $url,
        ]);
    }

    /** Accesos de un perfil (antes Addacceso): se abre en la ventana modal desde Acceso */
    public function accesos(Request $request, Seguridad $seguridad, int $perfil)
    {
        $this->opcion($request, $seguridad, 'Acceso', 'Perfil');
        $fila = DB::table('seguridad.tsperfil as pf')
            ->join('seguridad.tsmodulo as m', 'm.idmodulo', '=', 'pf.pefmodulo')
            ->join('seguridad.tssistema as s', 's.IdSistema', '=', 'm.modsistema')
            ->where('pf.idperfil', $perfil)->where('pf.pefestado', 1)->where('m.modestado', 1)->where('s.sisestado', 1)
            ->first(['pf.idperfil', 'pf.pefnombre', 'm.modnombre', 's.sisnombre']);
        abort_unless($fila, 404);

        return view('seguridad.embebido', [
            'titulo' => 'Accesos del perfil',
            'icono' => 'fa-key',
            'subtitulo' => trim((string) $fila->pefnombre).' · '.trim((string) $fila->sisnombre),
            'componente' => 'seguridad.perfil-accesos',
            'parametros' => ['perfil' => (int) $fila->idperfil],
        ]);
    }

    /** Perfiles de un usuario en cada sistema (antes Addusuarioperfil): se abre desde Usuarios */
    public function usuarioPerfiles(Request $request, Seguridad $seguridad, int $usuario)
    {
        $this->opcion($request, $seguridad, 'Usuarios');
        $fila = DB::table('seguridad.tsusuario as u')
            ->join('general.tgpersona as p', 'p.IdPersona', '=', 'u.usupersona')
            ->where('u.idusuario', $usuario)->where('u.usuestado', 1)->where('p.PerEstado', 1)
            ->first(['u.idusuario', 'u.usunombre', 'p.PerNombres', 'p.PerApePaterno', 'p.PerApeMaterno']);
        abort_unless($fila, 404);

        return view('seguridad.embebido', [
            'titulo' => 'Perfiles del usuario',
            'icono' => 'fa-id-card',
            'subtitulo' => trim($fila->PerNombres.' '.$fila->PerApePaterno.' '.$fila->PerApeMaterno).' · DNI '.trim((string) $fila->usunombre),
            'componente' => 'seguridad.usuario-perfiles',
            'parametros' => ['usuario' => (int) $fila->idusuario],
        ]);
    }

    /** Opcion del menu de seguridad que abre alguna de esas paginas (403 si el perfil no tiene acceso) */
    private function opcion(Request $request, Seguridad $seguridad, string ...$paginas): array
    {
        $perfil = $request->attributes->get('perfilSeguridad');
        foreach ($paginas as $pagina) {
            $menu = $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], $pagina);
            if ($menu) {
                return $menu;
            }
        }
        abort(403, 'Su perfil no tiene acceso a esta opción.');
    }
}
