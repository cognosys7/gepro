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
require_once(PATH_CONTROLADOR_DAO . "/GEN_ESTADOdao.php");

require_once("/LNinclude.php");
       
function Estado_Datos($PIDE) {
    
    $IDE_ESTADO = $DES_ESTADO = $DES_ABREVIATURA = $EST_ESTADO = '';
        
    if($PIDE>0) {
        $campos = " DES_ESTADO,  EST_ESTADO ";
        $filtro = "  AND IDE_ESTADO =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_ESTADO',$campos,$filtro) ;
        if(count($data)>0) {
            $DES_ESTADO         = $data[0]->DES_ESTADO ;
            $DES_ABREVIATURA    = $data[0]->DES_ABREVIATURA ;
            $EST_ESTADO         = $data[0]->EST_ESTADO ;
        }
    }
    
    $Resultado = array (
        'IDE_ESTADO'        => $PIDE ,
        'DES_ESTADO'        => $DES_ESTADO ,
        'DES_ABREVIATURA'   => $DES_ABREVIATURA ,
        'EST_ESTADO'        => $EST_ESTADO  
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