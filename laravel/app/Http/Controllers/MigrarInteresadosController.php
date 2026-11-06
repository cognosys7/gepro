<?php

namespace App\Http\Controllers;

use App\Livewire\ProyectosTabla;
use App\Services\Seguridad;
use App\Support\PuenteSesionLegado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Migrar interesados (Pagina=migrar_CONT_INTERESADOS del sistema actual). Se abre en la ventana modal
 * desde los proyectos, solo en las opciones del menu que muestran esa accion.
 */
class MigrarInteresadosController extends Controller
{
    public function index(Request $request, Seguridad $seguridad, int $proyecto)
    {
        $opcion = (int) $request->query('opcion', 0);
        abort_unless(in_array('migrar', ProyectosTabla::POR_OPCION[$opcion] ?? [], true), 404);

        $perfil = $request->attributes->get('perfilGepro');
        $menu = $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], 'PROYECTO', ['Opcion' => $opcion]);
        abort_unless($menu, 403, 'Su perfil no tiene acceso a esta opción.');

        $fila = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $proyecto)->where('EST_PROYECTO', '<>', '2')
            ->first(['IDE_PROYECTO', 'COD_INTERNO', 'DES_LARGA_PROYECTO']);
        abort_unless($fila, 404);

        PuenteSesionLegado::marcarOpcion($menu['padre'], $menu['id'], $perfil['perfil'], (int) $seguridad->sistema());

        return view('proyectos.migrar-interesados', ['titulo' => 'Migrar interesados', 'proyecto' => $fila]);
    }
}
