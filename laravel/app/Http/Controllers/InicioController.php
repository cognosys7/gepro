<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

/**
 * Portada: cifras reales del portafolio y enlaces a las opciones que el perfil tiene en su menu.
 */
class InicioController extends Controller
{
    public function __invoke()
    {
        $enlaces = $this->enlaces(View::shared('menuGepro', []));

        return view('inicio', [
            'indicadores' => $this->indicadores(),
            'urlProyectos' => $this->primero($enlaces, '/proyectos'),
            // Formatos F1, F2, F6: el tablero GEPRO_FORMATOS
            'urlTableros' => $this->primero($enlaces, '/tableros/PBI_PRY_2CONTRATOS'),
        ]);
    }

    /** Mismos registros que las grillas: se excluyen los eliminados (estado 2) */
    private function indicadores(): array
    {
        $vigentes = fn (string $tabla, string $estado) => DB::table($tabla)->where($estado, '<>', '2');

        return [
            ['Proyectos registrados', 'fa-diagram-project', $vigentes('dbo.PROYECTO', 'EST_PROYECTO')->count()],
            // Solo tipo 1 (tabla 65): la mayoria de filas de PROYECTO_ACTIVIDAD no tiene tipo y no son contratos principales
            ['Contratos principales', 'fa-file-signature', $vigentes('dbo.PROYECTO_ACTIVIDAD', 'EST_PROYECTO_ACTIVIDAD')->where('TIP_PROYECTO_ACTIVIDAD', '1')->count()],
            ['Riesgos registrados', 'fa-triangle-exclamation', $vigentes('dbo.PROY_RIESGO_PROBLEMA', 'EST_RIESGO')->count()],
            ['Interesados', 'fa-users', $vigentes('dbo.CONT_INTERESADOS', 'EST_CONT_INTERESADO')->count()],
        ];
    }

    /** Todas las URL del menu, en su orden */
    private function enlaces(array $opciones): array
    {
        $urls = [];
        foreach ($opciones as $o) {
            if ($o['url']) {
                $urls[] = $o['url'];
            }
            $urls = [...$urls, ...$this->enlaces($o['hijos'])];
        }

        return $urls;
    }

    private function primero(array $urls, string $ruta): ?string
    {
        foreach ($urls as $url) {
            if (str_contains((string) parse_url($url, PHP_URL_PATH), $ruta)) {
                return $url;
            }
        }

        return null;
    }
}
