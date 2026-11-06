<?php

namespace App\Http\Controllers;

use App\Services\Seguridad;
use Illuminate\Http\Request;

/**
 * Tableros de Power BI del menu (las vistas PBI_* del sistema actual): el reporte publicado en un
 * marco dentro de GEPRO. Las URL estan en config/tableros.php.
 */
class TablerosController extends Controller
{
    public function index(Request $request, Seguridad $seguridad, string $pagina)
    {
        $url = config('tableros.'.$pagina);
        abort_unless(is_string($url) && str_starts_with($url, 'https://'), 404);

        $perfil = $request->attributes->get('perfilGepro');
        $menu = $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], $pagina);
        abort_unless($menu, 403, 'Su perfil no tiene acceso a esta opción.');
        $grupo = $menu['padre'] !== $menu['id'] ? $seguridad->nombreOpcion($menu['padre']) : null;

        return view('tableros.index', [
            'titulo' => $menu['nombre'],
            'migas' => array_values(array_filter([$grupo, $menu['nombre']])),
            'url' => $url,
        ]);
    }
}
