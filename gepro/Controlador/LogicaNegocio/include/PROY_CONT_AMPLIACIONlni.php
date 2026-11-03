<?php

require_once(PATH_CONTROLADOR_DAO . "/PROY_CONT_AMPLIACIONdao.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");

function PROY_CONT_AMPLIACION_Datos($PIDE) {
    $IDE_CONT_AMPLIACION = $NUM_ORDEN = $IDE_PROYECTO_ACTIVIDAD = $TIP_AMPLIACION = $NUM_AMPLIACION = $FEC_INICIO_AMP = $CAN_DIAS_CALENDARIO = $FEC_TERMINO_AMP = $COD_RESOLUCION = $EST_CONT_AMPLIACION = $USER_UPDATE = null;

    $campos = "
        IDE_CONT_AMPLIACION,
        NUM_ORDEN,
        IDE_PROYECTO_ACTIVIDAD,
        TIP_AMPLIACION,
        NUM_AMPLIACION,
        CONVERT(VARCHAR(10), FEC_INICIO_AMP, 103) as FEC_INICIO_AMP,
        CAN_DIAS_CALENDARIO,
        CONVERT(VARCHAR(10), FEC_TERMINO_AMP, 103) as FEC_TERMINO_AMP,
        COD_RESOLUCION,
        EST_CONT_AMPLIACION,
        USER_UPDATE
    ";

    if ($PIDE > 0) {
        $filtro = "AND IDE_CONT_AMPLIACION = $PIDE";
        $data = VIS_SelCampos('PROY_CONT_AMPLIACION', $campos, $filtro);

        if (is_array($data) && count($data) > 0) {
            $row = $data[0];
            $IDE_CONT_AMPLIACION = $row->IDE_CONT_AMPLIACION ?? null;
            $NUM_ORDEN = $row->NUM_ORDEN ?? null;
            $IDE_PROYECTO_ACTIVIDAD = $row->IDE_PROYECTO_ACTIVIDAD ?? null;
            $TIP_AMPLIACION = $row->TIP_AMPLIACION ?? null;
            $NUM_AMPLIACION = $row->NUM_AMPLIACION ?? null;
            $FEC_INICIO_AMP = $row->FEC_INICIO_AMP ?? null;
            $CAN_DIAS_CALENDARIO = $row->CAN_DIAS_CALENDARIO ?? null;
            $FEC_TERMINO_AMP = $row->FEC_TERMINO_AMP ?? null;
            $COD_RESOLUCION = $row->COD_RESOLUCION ?? null;
            $EST_CONT_AMPLIACION = $row->EST_CONT_AMPLIACION ?? null;
            $USER_UPDATE = $row->USER_UPDATE ?? null;
        }
    }

    return [
        'BIDE' => $IDE_CONT_AMPLIACION,
        'NUM_ORDEN' => $NUM_ORDEN,
        'IDE_PROYECTO_ACTIVIDAD' => $IDE_PROYECTO_ACTIVIDAD,
        'TIP_AMPLIACION' => $TIP_AMPLIACION,
        'NUM_AMPLIACION' => $NUM_AMPLIACION,
        'FEC_INICIO_AMP' => $FEC_INICIO_AMP,
        'CAN_DIAS_CALENDARIO' => $CAN_DIAS_CALENDARIO,
        'FEC_TERMINO_AMP' => $FEC_TERMINO_AMP,
        'COD_RESOLUCION' => $COD_RESOLUCION,
        'EST_CONT_AMPLIACION' => $EST_CONT_AMPLIACION,
        'USER_UPDATE' => $USER_UPDATE
    ];
}

function Tabla_PROY_CONT_AMPLIACION_Datos($PIDE) {
    $Data = PROY_CONT_AMPLIACION_Datos($PIDE);

    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '">:</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '">' . ($Data['NUM_AMPLIACION'] ?? '') . '</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '">:</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '">' . ($Data['FEC_INICIO_AMP'] ?? '') . '</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_EtiketaAncho(6) . '">:</td>';
    $DatosPadre .= '<td style="width:' . TBpadre_ValorAncho(6) . '">' . ($Data['FEC_TERMINO_AMP'] ?? '') . '</td>';
    $DatosPadre .= '</tr>';
    $DatosPadre .= '</table>';

    return $DatosPadre;
}

function PROY_CONT_AMPLIACION_Datos_Contrato($PIDE, $pTIP_AMPLIACION) {
    $IDE_CONT_AMPLIACION = null;

    $campos = "
        TOP(1) IDE_CONT_AMPLIACION,
        IDE_PROYECTO_ACTIVIDAD
    ";

    if ($PIDE > 0) {
        $filtro = "AND IDE_PROYECTO_ACTIVIDAD = $PIDE AND TIP_AMPLIACION = $pTIP_AMPLIACION";
        $data = VIS_SelCampos('PROY_CONT_AMPLIACION', $campos, $filtro);

        if (is_array($data) && count($data) > 0) {
            $IDE_CONT_AMPLIACION = $data[0]->IDE_CONT_AMPLIACION ?? null;
        }
    }

    return [
        'BIDE' => $IDE_CONT_AMPLIACION
    ];
}
?>
