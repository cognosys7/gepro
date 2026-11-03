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
require_once(PATH_CONTROLADOR_DAO . "/PROY_CARTERAdao.php");

require_once("/LNinclude.php");
       
function Cartera_Datos($PIDE) {
    
    $IDE_FASE = $DES_CARTERA = $EST_CARTERA = '';
        
    if($PIDE>0) {
        $campos = " IDE_FASE, DES_CARTERA, EST_CARTERA ";
        $filtro = "  AND IDE_CARTERA =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('PROY_CARTERA',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_FASE  = $data[0]->IDE_FASE ;
            $DES_CARTERA  = $data[0]->DES_CARTERA ;
            $EST_CARTERA  = $data[0]->EST_CARTERA ;
        }
    }
    
    $Resultado = array (
        'IDE_CARTERA'   => $PIDE ,
        'IDE_FASE'      => $IDE_FASE ,
        'DES_CARTERA'   => $DES_CARTERA ,
        'EST_CARTERA'   => $EST_CARTERA 
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