<?php

namespace App\Http\Controllers;

use App\Services\Seguridad;
use App\Support\Archivos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Archivos adjuntos de un registro (GEN_ARCHIVO del sistema actual): se abren en la ventana modal desde
 * las pantallas del proyecto y del contrato, asi que el acceso se valida con la pagina PROYECTO.
 */
class ArchivosController extends Controller
{
    private function validarAcceso(Request $request, Seguridad $seguridad): void
    {
        $perfil = $request->attributes->get('perfilGepro');
        abort_unless($seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], 'PROYECTO'), 403, 'Su perfil no tiene acceso a esta opción.');
    }

    public function index(Request $request, Seguridad $seguridad, string $tabla, string $registro)
    {
        $this->validarAcceso($request, $seguridad);
        $t = Archivos::tabla($tabla);
        abort_unless($t, 404);
        [, $titulo, $tablaBase, $clave] = $t;
        //SIN TABLA BASE: ARCHIVO GENERAL DE LA ENTIDAD, SIEMPRE CON EL REGISTRO 1
        abort_unless($tablaBase ? DB::table($tablaBase)->where($clave, $registro)->exists() : $registro === '1', 404);

        return view('archivos.index', ['tabla' => $tabla, 'registro' => $registro, 'titulo' => $titulo]);
    }

    public function descargar(Request $request, Seguridad $seguridad, string $archivo)
    {
        $this->validarAcceso($request, $seguridad);
        $fila = DB::table('dbo.GEN_ARCHIVO')->where('IDE_ARCHIVO', $archivo)->where('EST_ARCHIVO', '<>', '2')->first();
        abort_unless($fila && Archivos::tabla(trim((string) $fila->IDE_TABLA)), 404);
        $real = Archivos::rutaReal($fila);
        abort_unless($real, 404, 'No se encontró el archivo.');

        return response()->download($real, Archivos::nombreVisible((string) $fila->DES_ARCHIVO), [
            'X-Content-Type-Options' => 'nosniff',
            'Cache-Control' => 'private, no-store',
        ]);
    }
}
