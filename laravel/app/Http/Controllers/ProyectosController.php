<?php

namespace App\Http\Controllers;

use App\Livewire\ProyectosTabla;
use App\Services\Seguridad;
use Illuminate\Http\Request;

/**
 * Proyectos (Pagina=PROYECTO del sistema actual). La misma pantalla aparece en varias opciones del
 * menu con distinto Opcion (110 Proyectos, 211 Etapa del Contrato, 310 Gestion Social...): el perfil
 * debe tener acceso a la opcion del menu que la abre con ese Opcion.
 */
class ProyectosController extends Controller
{
    public function index(Request $request, Seguridad $seguridad)
    {
        $opcion = (int) $request->query('opcion', 110);
        abort_unless(array_key_exists($opcion, ProyectosTabla::POR_OPCION), 404);

        $perfil = $request->attributes->get('perfilGepro');
        $menu = $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], 'PROYECTO', ['Opcion' => $opcion]);
        abort_unless($menu, 403, 'Su perfil no tiene acceso a esta opción.');

        $grupo = $menu['padre'] !== $menu['id'] ? $seguridad->nombreOpcion($menu['padre']) : null;

        return view('proyectos.index', [
            'titulo' => $menu['nombre'],
            'migas' => array_values(array_filter([$grupo, $menu['nombre']])),
            'opcion' => $opcion,
            'opcionMenu' => $menu['id'],
        ]);
    }
}
