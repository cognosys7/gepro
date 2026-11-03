<?php

namespace App\Calculos;

/**
 * Montos del control mensual de una etapa del contrato (PROY_CONT_COMP_CONTROL_DET), con la misma
 * formula que calcularPrioridad() de PROY_CONT_COMP_CONTROL_DETvista.php:
 *   saldo sin IGV = bruto + reajuste - (amort. adel. directo + amort. adel. materiales) - amortizacion
 *   imponible     = saldo sin IGV - deduc. adel. directo - deduc. adel. materiales
 *   plan 2 (ejecucion real): IGV = % IGV x imponible;     neto = imponible + IGV
 *   otros planes:            IGV = saldo sin IGV x % IGV; neto = saldo + IGV si hay amortizacion,
 *                                                         si no bruto + IGV
 *   a pagar       = neto - penalidad - retencion
 * El plan sale del control anual ($de = PROY_CONT_ETAPA_CONTROL).
 */
class ControlMensual
{
    public const PLAN_EJECUTADO = 2;

    public function calcular(array $datos, ?object $de): array
    {
        $n = fn (string $campo) => (float) str_replace(',', '', (string) ($datos[$campo] ?? 0));

        $saldo = $n('IMP_BRUTO') + $n('IMP_REAJUSTE') - ($n('IMP_AMORT_ADEL_DIR') + $n('IMP_AMORT_ADEL_MAT')) - $n('IMP_AMORTIZACION');
        $imponible = $saldo - $n('IMP_DEDUC_ADEL_DIR') - $n('IMP_DEDUC_ADEL_MAT');
        $pct = $n('PCT_IGV');
        if ((int) ($de->IDE_PLAN ?? 0) === self::PLAN_EJECUTADO) {
            $igv = $pct * $imponible;
            $neto = $imponible + $igv;
        } else {
            $igv = $saldo * $pct;
            $neto = $n('IMP_AMORTIZACION') > 0 ? $saldo + $igv : $n('IMP_BRUTO') + $igv;
        }
        $pago = $neto - $n('IMP_PENALIDAD') - $n('IMP_RETENCION');

        $f = fn (float $v) => number_format(round($v, 2), 2, '.', '');

        return [
            'IMP_SALDO_SIN_IGV' => $f($saldo),
            'IMP_IMPONIBLE' => $f($imponible),
            'IMP_IGV' => $f($igv),
            'IMP_NETO' => $f($neto),
            'IMP_PAGO' => $f($pago),
        ];
    }
}
