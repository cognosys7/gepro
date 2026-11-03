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
require_once(PATH_CONTROLADOR_DAO . "/GEN_CARGOdao.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function Cargo_Datos($PIDE) {
    
    $DES_CARGO = $EST_CARGO = '';
        
    if($PIDE>0) {
        $campos = " DES_CARGO, EST_CARGO ";
        $filtro = "  AND IDE_CARGO =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_CARGO',$campos,$filtro) ;
        if(count($data)>0) {
            $DES_CARGO  = $data[0]->DES_CARGO ;
            $EST_CARGO  = $data[0]->EST_CARGO ;
        }
    }
    
    $Resultado = array (
        'IDE_CARGO' => $PIDE ,
        'DES_CARGO' => $DES_CARGO ,
        'EST_CARGO' => $EST_CARGO 
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