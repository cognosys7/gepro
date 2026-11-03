<?php

require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");

function GenTablas_Datos($PIDE1, $PIDE2) {
    $DES_ITEM = $DES_ABREVIATURA = $COD_ITEM = $EST_ITEM = '';
    $COD_TABLA = 0;

    $campos = "DES_ITEM, DES_ABREVIATURA, COD_TABLA, COD_ITEM, EST_ITEM";
    $filtro = "AND COD_TABLA = '" . $PIDE1 . "' AND COD_ITEM = '" . $PIDE2 . "'";
    $data = VIS_SelCampos('GEN_TABLAS', $campos, $filtro);

    if (is_array($data) && count($data) > 0) {
        $DES_ITEM = $data[0]->DES_ITEM ?? '';
        $DES_ABREVIATURA = $data[0]->DES_ABREVIATURA ?? '';
        $COD_TABLA = $data[0]->COD_TABLA ?? 0;
        $COD_ITEM = $data[0]->COD_ITEM ?? '';
        $EST_ITEM = $data[0]->EST_ITEM ?? '';
    }

    return [
        'DES_ITEM' => $DES_ITEM,
        'DES_ABREVIATURA' => $DES_ABREVIATURA,
        'COD_TABLA' => $COD_TABLA,
        'COD_ITEM' => $COD_ITEM,
        'EST_ITEM' => $EST_ITEM
    ];
}

function GenTablas_Datos1($PIDE1) {
    $DES_ITEM = $DES_ABREVIATURA = $COD_TABLA = $COD_ITEM = $EST_ITEM = $COD_ORDEN = '';

    $campos = "DES_ITEM, DES_ABREVIATURA, COD_TABLA, COD_ITEM, EST_ITEM, COD_ORDEN";
    $filtro = "AND COD_TABLA = '0' AND COD_ITEM = '" . $PIDE1 . "'";
    $data = VIS_SelCampos('GEN_TABLAS', $campos, $filtro);

    if (is_array($data) && count($data) > 0) {
        $DES_ITEM = $data[0]->DES_ITEM ?? '';
        $DES_ABREVIATURA = $data[0]->DES_ABREVIATURA ?? '';
        $COD_TABLA = $data[0]->COD_TABLA ?? '';
        $COD_ITEM = $data[0]->COD_ITEM ?? '';
        $EST_ITEM = $data[0]->EST_ITEM ?? '';
        $COD_ORDEN = $data[0]->COD_ORDEN ?? '';
    }

    return [
        'DES_ITEM' => $DES_ITEM,
        'DES_ABREVIATURA' => $DES_ABREVIATURA,
        'COD_TABLA' => $COD_TABLA,
        'COD_ITEM' => $COD_ITEM,
        'EST_ITEM' => $EST_ITEM,
        'COD_ORDEN' => $COD_ORDEN
    ];
}

function GenTablas_RolAbrev($PIDE) {
    $COD_ITEM = $DES_ABREVIATURA = '';

    $campos = "COD_ITEM, DES_ABREVIATURA";
    $filtro = "AND COD_TABLA = '49' AND DES_ITEM = '" . $PIDE . "'";
    $data = VIS_SelCampos('GEN_TABLAS', $campos, $filtro);

    if (is_array($data) && count($data) > 0) {
        $COD_ITEM = $data[0]->COD_ITEM ?? '';
        $DES_ABREVIATURA = $data[0]->DES_ABREVIATURA ?? '';
    }

    return [
        'COD_ITEM' => $COD_ITEM,
        'DES_ABREVIATURA' => $DES_ABREVIATURA
    ];
}

?>
