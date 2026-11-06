<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Asocia un proyecto de inversion (GEN_PIP) a un proyecto, con dbo.SP_PROY_PIP 'Insert'.
 * Ese SP actualizaba PROYECTO con WHERE IDE_PROYECTO = @IDE_PIP: no dejaba los codigos en el proyecto correcto
 * y, si el IDE_PIP coincidia con otro proyecto, le cambiaba sus codigos (corregido en
 * database/sql/2026-11-06_SP_PROY_PIP.sql). Mientras una base no tenga ese script, aqui se guarda el proyecto
 * afectado, se restaura y se escriben los codigos donde corresponde; con el SP corregido no cambia nada.
 */
class ProyectoInversion
{
    /** Los codigos tienen varchar(10) en PROY_PIP y en los parametros del SP */
    private const MAX_CODIGO = 10;

    public static function registrar(array $parametros): void
    {
        $proyecto = (int) $parametros['IDE_PROYECTO'];
        $idPip = (int) $parametros['IDE_PIP'];
        if (DB::table('dbo.PROY_PIP')->where('IDE_PROYECTO', $proyecto)->where('EST_PROY_PIP', '<>', '2')->exists()) {
            throw new RuntimeException('El proyecto ya tiene un proyecto de inversión asociado.');
        }
        $pip = DB::table('dbo.GEN_PIP')->where('IDE_PIP', $idPip)->where('EST_PIP', '<>', '2')->first(['COD_SNIP', 'COD_UNICO', 'COD_PROYECTO']);
        if (! $pip) {
            throw new RuntimeException('El proyecto de inversión elegido ya no existe.');
        }
        //EN LOS REGISTROS RECIENTES EL CODIGO UNICO VIENE EN COD_PROYECTO
        $snip = trim((string) $pip->COD_SNIP);
        $unico = trim((string) $pip->COD_UNICO) ?: trim((string) $pip->COD_PROYECTO);
        if (strlen($snip) > self::MAX_CODIGO || strlen($unico) > self::MAX_CODIGO) {
            throw new RuntimeException('Los códigos de este proyecto de inversión superan los '.self::MAX_CODIGO.' caracteres.');
        }

        $afectado = DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $idPip)->first(['COD_SNIP', 'COD_UNICO']);
        Procedimiento::grabar('dbo.SP_PROY_PIP', 'Insert', ['COD_SNIP' => $snip, 'COD_UNICO' => $unico] + $parametros);

        DB::transaction(function () use ($afectado, $idPip, $proyecto, $snip, $unico) {
            if ($afectado && $idPip !== $proyecto) {
                DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $idPip)->update(['COD_SNIP' => $afectado->COD_SNIP, 'COD_UNICO' => $afectado->COD_UNICO]);
            }
            DB::table('dbo.PROYECTO')->where('IDE_PROYECTO', $proyecto)->update(['COD_SNIP' => $snip ?: null, 'COD_UNICO' => $unico ?: null]);
        });
    }
}
