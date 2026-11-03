<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");

//require_once("/LNinclude.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function GenIntervencion_Datos($PIDE) {
    
    $DES_INTERVENCION = $NUM_NIVEL = $DES_RUBRO = $TIP_SECTOR_PIRCC = $EST_INTERVENCION = $IDE_SECTOR = $IDE_INTERVENCION_SUP = '';
        
    if($PIDE>0) {
        $campos = " DES_INTERVENCION, NUM_NIVEL, DES_RUBRO, TIP_SECTOR_PIRCC , EST_INTERVENCION , IDE_SECTOR , IDE_INTERVENCION_SUP ";
        $filtro = "  AND IDE_INTERVENCION =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_INTERVENCION',$campos,$filtro) ;
        if(count($data)>0) {
            $DES_INTERVENCION       = $data[0]->DES_INTERVENCION ;
            $NUM_NIVEL              = $data[0]->NUM_NIVEL ;
            $DES_RUBRO              = $data[0]->DES_RUBRO ;
            $TIP_SECTOR_PIRCC       = $data[0]->TIP_SECTOR_PIRCC ;
            $EST_INTERVENCION       = $data[0]->EST_INTERVENCION ;
            $IDE_SECTOR             = $data[0]->IDE_SECTOR ;
            $IDE_INTERVENCION_SUP   = $data[0]->IDE_INTERVENCION_SUP ;
        }
    }
    
    $Resultado = array (
        'DES_INTERVENCION'      => $DES_INTERVENCION ,
        'NUM_NIVEL'             => $NUM_NIVEL ,
        'DES_RUBRO'             => $DES_RUBRO ,
        //'TIP_SECTOR_PIRCC'      => $TIP_SECTOR_PIRCC ,
        'EST_INTERVENCION'      => $EST_INTERVENCION , 
        'IDE_SECTOR'            => $IDE_SECTOR,
        'IDE_INTERVENCION_SUP'  => $IDE_INTERVENCION_SUP
    ) ;
    
    return $Resultado ;
}


function Tabla_Intervencion_Datos ( $PIDE ) {
    
    $Data = GenIntervencion_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
    
    $DatosPadre .= '<tr>';
//    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Fase - Componente' .'('. $PIDE.')' . ':</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'">Fase - Componente :</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> <span style="color: #aa0000;">' . $Data['DES_INTERVENCION'] . '</span></td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(4).'"> </td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(4).'"> </td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}

?>