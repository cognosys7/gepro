<?php

namespace App\Http\Controllers;

use App\Services\Seguridad;
use App\Support\Catalogo;
use App\Support\PuenteSesionLegado;
use Illuminate\Http\Request;

/**
 * Catalogos de config/catalogos.php (Configuracion Proyecto y Mantenimiento). El perfil debe tener
 * acceso a la opcion del menu que abre esa Pagina.
 */
class CatalogosController extends Controller
{
    public function index(Request $request, Seguridad $seguridad, string $pagina)
    {
        $def = Catalogo::definicion($pagina);

        $perfil = $request->attributes->get('perfilGepro');
        $menu = $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], $pagina);
        abort_unless($menu, 403, 'Su perfil no tiene acceso a esta opción.');
        PuenteSesionLegado::marcarOpcion($menu['padre'], $menu['id'], $perfil['perfil'], (int) $seguridad->sistema());

        $grupo = $menu['padre'] !== $menu['id'] ? $seguridad->nombreOpcion($menu['padre']) : null;

        //JERARQUIA: ?padre=<id> LISTA LOS HIJOS DE ESE REGISTRO; LAS MIGAS MUESTRAN EL CAMINO DESDE LA RAIZ
        $padre = $request->query('padre');
        $cadena = [];
        if ($padre !== null && ! empty($def['jerarquia'])) {
            abort_unless(is_scalar($padre) && preg_match('/^[A-Za-z0-9_-]{1,30}$/', (string) $padre), 404);
            $fila = Catalogo::fila($def, (string) $padre);
            abort_unless($fila, 404);
            $cadena = Catalogo::cadena($def, $fila);
            abort_unless(count($cadena) < $def['jerarquia']['niveles'], 404);
        } else {
            $padre = null;
        }
        $nombre = fn ($f) => trim((string) $f->{$def['jerarquia']['titulo']});

        return view('catalogos.index', [
            'titulo' => $cadena ? $nombre(end($cadena)) : $menu['nombre'],
            'migas' => array_values(array_filter(array_merge([$grupo, $menu['nombre']], array_map($nombre, $cadena)))),
            'pagina' => $pagina,
            'def' => $def,
            'padre' => $padre !== null ? (string) $padre : null,
            'cadena' => $cadena,
            'nombre' => $nombre,
            'menuNombre' => $menu['nombre'],
        ]);
    }
}
