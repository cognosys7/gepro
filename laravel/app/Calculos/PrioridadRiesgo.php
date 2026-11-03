<?php

namespace App\Calculos;

/**
 * Prioridad de un riesgo del contrato (PROY_RIESGO_PROBLEMA), con la misma regla que calcularPrioridad()
 * de PROY_RIESGO_PROBLEMAvista.php: valor = probabilidad x impacto, con
 *   probabilidad 1..5 = 0.2, 0.4, 0.6, 0.8, 1   e   impacto 1..5 = 2, 4, 6, 8, 10;
 *   hasta 1.6 es BAJA, desde 6 es ALTA y en medio MODERADA (GEN_PRIORIDAD_RIESGO 2, 5 y 3).
 */
class PrioridadRiesgo
{
    private const PROBABILIDAD = [1 => 0.2, 2 => 0.4, 3 => 0.6, 4 => 0.8, 5 => 1];

    private const IMPACTO = [1 => 2, 2 => 4, 3 => 6, 4 => 8, 5 => 10];

    public const BAJA = '2';

    public const MODERADA = '3';

    public const ALTA = '5';

    /** Campos de probabilidad, impacto y prioridad (las subclases usan los de su tabla) */
    protected const CAMPOS = ['IDE_PROBABILIDAD', 'IDE_IMPACTO', 'IDE_PRIORIDAD'];

    public function calcular(array $datos, ?object $de): array
    {
        [$campoProbabilidad, $campoImpacto, $campoPrioridad] = static::CAMPOS;
        $probabilidad = self::PROBABILIDAD[(int) ($datos[$campoProbabilidad] ?? 0)] ?? null;
        $impacto = self::IMPACTO[(int) ($datos[$campoImpacto] ?? 0)] ?? null;
        if ($probabilidad === null || $impacto === null) {
            return [$campoPrioridad => ''];
        }
        $valor = $probabilidad * $impacto;

        return [$campoPrioridad => match (true) {
            $valor <= 1.6 => self::BAJA,
            $valor >= 6 => self::ALTA,
            default => self::MODERADA,
        }];
    }
}
