<?php

namespace App\Http\Controllers;

use App\Services\Seguridad;
use Illuminate\Http\Request;

/**
 * Descargas de Excel del menu (las vistas PEX_* del sistema actual): valida el acceso del perfil y
 * redirige al archivo publicado. Las URL estan en config/descargas.php.
 */
class DescargasController extends Controller
{
    public function index(Request $request, Seguridad $seguridad, string $pagina)
    {
        $url = config('descargas.'.$pagina);
        abort_unless(is_string($url) && preg_match('#^https?://#i', $url), 404);

        $perfil = $request->attributes->get('perfilGepro');
        abort_unless($seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], $pagina), 403, 'Su perfil no tiene acceso a esta opción.');

        return redirect()->away($url);
    }

    /** Guia de usuario del menu: el PDF de config('gepro.guia_usuario') */
    public function guia()
    {
        return $this->pdf((string) config('gepro.guia_usuario'));
    }

    /** Guia del menu del sistema de seguridad: el PDF de config('gepro.seguridad.guia') */
    public function guiaSeguridad()
    {
        return $this->pdf((string) config('gepro.seguridad.guia'));
    }

    /** Sirve un archivo relativo a la carpeta de archivos, sin salir de ella */
    private function pdf(string $relativo)
    {
        $raiz = realpath((string) config('gepro.archivos.raiz'));
        $real = $raiz ? realpath($raiz.DIRECTORY_SEPARATOR.$relativo) : false;
        abort_unless($real && str_starts_with($real, $raiz.DIRECTORY_SEPARATOR) && is_file($real), 404);

        return response()->file($real);
    }
}
