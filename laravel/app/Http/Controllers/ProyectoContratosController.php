<?php

namespace App\Http\Controllers;

use App\Livewire\ProyectoContratosTabla;
use App\Services\Seguridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Contratos de un proyecto (Pagina=PROYECTO_ACTIVIDAD del sistema actual). Se abre en la ventana modal
 * desde la grilla de Proyectos; el perfil debe tener acceso a la opcion del menu de Proyectos con ese Opcion.
 */
class ProyectoContratosController extends Controller
{
    public function index(Request $request, Seguridad $seguridad, int $proyecto)
    {
        $opcion = (int) $request->query('opcion', 0);
        $tipo = (int) $request->query('tipo', 0);
        abort_unless($tipo === 0 || array_key_exists($tipo, ProyectoContratosTabla::TIPOS), 404);

        $perfil = $request->attributes->get('perfilGepro');
        $menu = $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], 'PROYECTO', ['Opcion' => $opcion]);
        abort_unless($menu, 403, 'Su perfil no tiene acceso a esta opción.');

        $fila = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $proyecto)->where('EST_PROYECTO', '<>', '2')
            ->first(['IDE_PROYECTO', 'COD_INTERNO', 'COD_UNICO', 'DES_LARGA_PROYECTO']);
        abort_unless($fila, 404);

        return view('proyectos.contratos', [
            'titulo' => 'Contratos del proyecto',
            'proyecto' => $fila,
            'opcion' => $opcion,
            'tipo' => $tipo,
            'nombreTipo' => $tipo ? ProyectoContratosTabla::TIPOS[$tipo][0] : null,
        ]);
    }
}
