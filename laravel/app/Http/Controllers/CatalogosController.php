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

        return view('catalogos.index', [
            'titulo' => $menu['nombre'],
            'migas' => array_values(array_filter([$grupo, $menu['nombre']])),
            'pagina' => $pagina,
            'def' => $def,
        ]);
    }
}
