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
require_once(PATH_CONTROLADOR_DAO . "/CONT_CALIDADdao.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function ContratoCalidad_Datos($PIDE) {
    
    $IDE_CONTRATO = $IDE_ENTREGABLE = $NUM_REVISION = $COD_INFORME = $FEC_INFORME = $IDE_REC_REVISADO = '' ;
    $IDE_REC_VALIDADO = $IDE_REC_APROBADO = $DES_OBSERV_INFORME = $CAN_OBSERVACIONES = $EST_ENTREGABLE = '';
    
    if($PIDE>0) {
        $campos = " IDE_CONTRATO , IDE_ENTREGABLE , NUM_REVISION , COD_INFORME , FEC_INFORME , IDE_REC_REVISADO " ;
        $campos.= ", IDE_REC_VALIDADO , IDE_REC_APROBADO , DES_OBSERV_INFORME , CAN_OBSERVACIONES , EST_ENTREGABLE" ;
        $filtro = "  AND IDE_CONT_CALIDAD =".$PIDE ; 
            $data = VIS_SelCampos ('CONT_CALIDAD',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_CONTRATO           = $data[0]->IDE_CONTRATO ;
            $IDE_ENTREGABLE         = $data[0]->IDE_ENTREGABLE ;
            $NUM_REVISION           = $data[0]->NUM_REVISION ;
            $COD_INFORME            = $data[0]->COD_INFORME ;
            $FEC_INFORME            = $data[0]->FEC_INFORME ;
            $IDE_REC_REVISADO       = $data[0]->IDE_REC_REVISADO ;
            $IDE_REC_VALIDADO       = $data[0]->IDE_REC_VALIDADO ;
            $IDE_REC_APROBADO       = $data[0]->IDE_REC_APROBADO ;
            $DES_OBSERV_INFORME     = $data[0]->DES_OBSERV_INFORME ;
            $CAN_OBSERVACIONES      = $data[0]->CAN_OBSERVACIONES ;
            $EST_ENTREGABLE         = $data[0]->EST_ENTREGABLE ;
        }
    }
    
    $Resultado = array (
        'BIDE'                  => $PIDE ,
        'IDE_CONTRATO'          => $IDE_CONTRATO ,
        'IDE_ENTREGABLE'        => $IDE_ENTREGABLE ,
        'NUM_REVISION'          => $NUM_REVISION ,
        'COD_INFORME'           => $COD_INFORME,
        'FEC_INFORME'           => $FEC_INFORME ,
        'IDE_REC_REVISADO'      => $IDE_REC_REVISADO , 
        'IDE_REC_VALIDADO'      => $IDE_REC_VALIDADO,
        'IDE_REC_APROBADO'      => $IDE_REC_APROBADO,
        'DES_OBSERV_INFORME'    => $DES_OBSERV_INFORME,
        'CAN_OBSERVACIONES'     => $CAN_OBSERVACIONES ,
        'EST_ENTREGABLE'        => $EST_ENTREGABLE
    ) ;
    
    return $Resultado ;
}



function Tabla_ContratoCalidad_Datos ( $PIDE, $Entregable ) {
    
    $Data = ContratoCalidad_Datos($PIDE);
    $DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
    
    $DatosPadre .= '<tr>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'">Entregable ('. $Data['IDE_ENTREGABLE'].') :</td>';
//    $DatosPadre .= '<td>Proyecto :</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'"> ' .$Entregable . '</td>';
    $DatosPadre.=  '<td style="width:'.TBpadre_EtiketaAncho(6).'">Código de Informe:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'">' . $Data['COD_INFORME'] . '</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_EtiketaAncho(6).'">Numero de Revisón:</td>';
    $DatosPadre .= '<td style="width:'.TBpadre_ValorAncho(6).'">' . $Data['NUM_REVISION'] . '</td>';
    $DatosPadre .= '</tr>';
    
    $DatosPadre .= '</table>';
    
    return $DatosPadre ;
}

?>