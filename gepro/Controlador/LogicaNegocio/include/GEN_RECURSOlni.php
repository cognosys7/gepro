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
require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSOdao.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function Recurso_Datos($PIDE) {
    
    $IDE_RECURSO = $IDE_ENTIDAD = $TIP_RECURSO = $COD_RECURSO = $DES_RECURSO = $EST_RECURSO = '';
        
    if($PIDE>0) {
        $campos = " IDE_ENTIDAD, TIP_RECURSO, COD_RECURSO, DES_RECURSO, EST_RECURSO ";
        $filtro = "  AND IDE_RECURSO =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_RECURSO',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_ENTIDAD    = $data[0]->IDE_ENTIDAD ;
            $TIP_RECURSO    = $data[0]->TIP_RECURSO ;
            $COD_RECURSO    = $data[0]->COD_RECURSO ;
            $DES_RECURSO    = $data[0]->DES_RECURSO ;
            $EST_RECURSO    = $data[0]->EST_RECURSO ;
        }
    }
    
    $Resultado = array (
        'IDE_RECURSO'   => $PIDE ,
        'IDE_ENTIDAD'   => $IDE_ENTIDAD ,
        'TIP_RECURSO'   => $TIP_RECURSO ,
        'COD_RECURSO'   => $COD_RECURSO ,
        'DES_RECURSO'   => $DES_RECURSO ,
        'EST_RECURSO'   => $EST_RECURSO 
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