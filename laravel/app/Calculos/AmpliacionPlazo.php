<?php

namespace App\Calculos;

use Illuminate\Support\Carbon;

/**
 * Fecha de termino de una ampliacion de plazo del contrato (PROY_CONT_AMPLIACION), como calTermino()
 * de PROY_CONT_AMPLIACIONvista.php: termino = inicio + dias calendario. El sistema actual lo hace solo
 * en el plazo contractual, la recepcion y la liquidacion ('segun' de la definicion).
 */
class AmpliacionPlazo
{
    public function calcular(array $datos, ?object $de): array
    {
        $inicio = (string) ($datos['FEC_INICIO_AMP'] ?? '');
        $dias = (string) ($datos['CAN_DIAS_CALENDARIO'] ?? '');
        if (! preg_match('/^\d{4}-\d{2}-\d{2}$/', $inicio) || ! preg_match('/^-?\d+$/', $dias)) {
            return [];
        }

        return ['FEC_TERMINO_AMP' => Carbon::createFromFormat('Y-m-d', $inicio)->startOfDay()->addDays((int) $dias)->format('Y-m-d')];
    }
}
