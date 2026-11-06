<?php

namespace App\Http\Controllers;

use App\Livewire\ProyectoContratosTabla;
use App\Services\Seguridad;
use App\Support\PuenteSesionLegado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Migrar control de etapas (Pagina=migrar_CONT_ETAPA_CONTROL del sistema actual). Se abre en la ventana
 * modal desde los contratos del proyecto, solo en las opciones del menu que muestran esa accion.
 */
class MigrarControlController extends Controller
{
    public function index(Request $request, Seguridad $seguridad, int $contrato)
    {
        $opcion = (int) $request->query('opcion', 0);
        abort_unless(in_array('migrar', ProyectoContratosTabla::POR_OPCION[$opcion] ?? [], true), 404);

        $perfil = $request->attributes->get('perfilGepro');
        $menu = $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], 'PROYECTO', ['Opcion' => $opcion]);
        abort_unless($menu, 403, 'Su perfil no tiene acceso a esta opción.');

        $fila = DB::table('dbo.PROYECTO_ACTIVIDAD')->where('IDE_PROYECTO_ACTIVIDAD', $contrato)
            ->where('EST_PROYECTO_ACTIVIDAD', '<>', '2')->first(['IDE_PROYECTO_ACTIVIDAD', 'COD_PROYECTO', 'DES_PROYECTO']);
        abort_unless($fila, 404);

        //LA IMPORTACION DEL SISTEMA ACTUAL VALIDA EL ACCESO CON ESTA OPCION (Oc)
        PuenteSesionLegado::marcarOpcion($menu['padre'], $menu['id'], $perfil['perfil'], (int) $seguridad->sistema());

        return view('contratos.migrar-control', ['titulo' => 'Migrar control de etapas', 'contrato' => $fila]);
    }
}
