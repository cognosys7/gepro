<?php

require_once(PATH_CONTROLADOR_DAO . "/GEN_MATRIZ_CONOCIMIENTO_PROCESOdao.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function MatrizConocimiento_Datos($PIDE) {
    
    $TIP_AREA_CONOCIMIENTO = $TIP_GRUPO_PROCESO = $DES_CRUCE_CONOC_PROC = $DES_ABREVIATURA = $COD_ORDEN = $EST_CONOC_PROC = '';
        
    if($PIDE>0) {
        $campos = " TIP_AREA_CONOCIMIENTO, TIP_GRUPO_PROCESO, DES_CRUCE_CONOC_PROC, DES_ABREVIATURA, COD_ORDEN, EST_CONOC_PROC ";
        $filtro = "  AND IDE_CONOC_PROC =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_MATRIZ_CONOCIMIENTO_PROCESO',$campos,$filtro) ;
        if(count($data)>0) {
            $TIP_AREA_CONOCIMIENTO  = $data[0]->TIP_AREA_CONOCIMIENTO ;
            $TIP_GRUPO_PROCESO      = $data[0]->TIP_GRUPO_PROCESO ;
            $DES_CRUCE_CONOC_PROC   = $data[0]->DES_CRUCE_CONOC_PROC ;
            $DES_ABREVIATURA        = $data[0]->DES_ABREVIATURA ;
            $COD_ORDEN              = $data[0]->COD_ORDEN ;
            $EST_CONOC_PROC         = $data[0]->EST_CONOC_PROC ;
        }
    }
    
    $Resultado = array (
        'BIDE'   => $PIDE ,
        'TIP_AREA_CONOCIMIENTO' => $TIP_AREA_CONOCIMIENTO ,
        'TIP_GRUPO_PROCESO'     => $TIP_GRUPO_PROCESO ,
        'DES_CRUCE_CONOC_PROC'  => $DES_CRUCE_CONOC_PROC ,
        'DES_ABREVIATURA'       => $DES_ABREVIATURA ,
        'COD_ORDEN'             => $COD_ORDEN ,
        'EST_CONOC_PROC'        => $EST_CONOC_PROC
    ) ;
    
    return $Resultado ;
}


//function Tabla_Comunidad_Datos ( $PIDE ) {
//    
//    $Data = Comunidad_Datos($PIDE);
//    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
//
//    $DatosPadre .= '<tr>';
//    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(2).'">Comunidad:</td>';
//    $DatosPadre .= '<td colspan="3">' . $Data['DES_COMUNIDAD'] . '</td>';
//    $DatosPadre .= '</tr>';
//    
//    $DatosPadre .= '</table>';
//    
//    return $DatosPadre ;
//}

?>