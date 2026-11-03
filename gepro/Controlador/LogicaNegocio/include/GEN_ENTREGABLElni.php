<?php

require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTREGABLEdao.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function Entregable_Datos($PIDE) {
    
    $IDE_FASE_COMPONENTE = $GEN_IDE_ENTREGABLE = $DES_ENTREGABLE = $DES_ABREVIATURA = $NUM_NIVEL = $NUM_ORDEN = $EST_ENTREGABLE = '';
        
    if($PIDE>0) {
        $campos = " IDE_FASE_COMPONENTE , GEN_IDE_ENTREGABLE , DES_ENTREGABLE , DES_ABREVIATURA , NUM_NIVEL , NUM_ORDEN , EST_ENTREGABLE ";
        $filtro = "  AND IDE_ENTREGABLE =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_ENTREGABLE',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_FASE_COMPONENTE    = $data[0]->IDE_FASE_COMPONENTE ;
            $GEN_IDE_ENTREGABLE     = $data[0]->GEN_IDE_ENTREGABLE ;
            $DES_ENTREGABLE         = $data[0]->DES_ENTREGABLE ;
            $DES_ABREVIATURA        = $data[0]->DES_ABREVIATURA ;
            $NUM_NIVEL              = $data[0]->NUM_NIVEL ;
            $NUM_ORDEN              = $data[0]->NUM_ORDEN ;
            $EST_ENTREGABLE         = $data[0]->EST_ENTREGABLE ;
        }
    }
    
    $Resultado = array (
        'BIDE' => $PIDE ,
        'IDE_FASE_COMPONENTE' => $IDE_FASE_COMPONENTE ,
        'GEN_IDE_ENTREGABLE' => $GEN_IDE_ENTREGABLE,
        'DES_ENTREGABLE' => $DES_ENTREGABLE ,
        'DES_ABREVIATURA' => $DES_ABREVIATURA ,
        'NUM_NIVEL' => $NUM_NIVEL ,
        'NUM_ORDEN' => $NUM_ORDEN ,
        'EST_ENTREGABLE' => $EST_ENTREGABLE 
    ) ;
    
    return $Resultado ;
}


function Tabla_Entregable_Datos ( $PIDE ) {
    
    $Data = Entregable_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';

    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(2).'">Entregable Superior:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(2).'">' . $Data['DES_ENTREGABLE'] . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}
?>