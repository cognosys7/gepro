<?php

namespace Tests;

use App\Auth\LegadoUserProvider;
use App\Services\Seguridad;
use Illuminate\Support\Facades\DB;

/**
 * Usuarios reales de BDGEPRO para las pruebas (solo se leen).
 */
trait UsuariosDePrueba
{
    /**
     * Usuario activo con perfil en GEPRO que puede grabar ($soloConsulta = false) o con el perfil de
     * solo consulta ($soloConsulta = true). Si se indica, ademas con acceso a esa Pagina y parametros.
     */
    protected function usuarioGepro(bool $soloConsulta = false, ?string $pagina = null, array $parametros = []): ?object
    {
        $seguridad = app(Seguridad::class);
        foreach (DB::table('seguridad.tsusuarioperfil')->where('upsestado', 1)->orderBy('upsusuario')->pluck('upsusuario')->unique() as $id) {
            $perfil = $seguridad->perfil((int) $id);
            if (! $perfil || $perfil['soloConsulta'] !== $soloConsulta) {
                continue;
            }
            if ($pagina && ! $seguridad->opcionDePagina($perfil['perfil'], $perfil['modulo'], $pagina, $parametros)) {
                continue;
            }
            $usuario = (new LegadoUserProvider())->retrieveById($id);
            if ($usuario) {
                return $usuario;
            }
        }

        return null;
    }
}
