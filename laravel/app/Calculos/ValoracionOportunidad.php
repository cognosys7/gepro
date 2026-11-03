<?php

namespace App\Calculos;

/**
 * Valoracion (P x I) de una oportunidad de mejora y analisis de riesgo del proyecto (PROY_OPORTUNIDAD_RIESGO):
 * la misma regla que la prioridad del riesgo del contrato (calValoracion() de PROY_OPORTUNIDAD_RIESGOvista.php).
 */
class ValoracionOportunidad extends PrioridadRiesgo
{
    protected const CAMPOS = ['NUM_PROBABILIDAD', 'NUM_IMPACTO', 'NUM_VALORACION'];
}
