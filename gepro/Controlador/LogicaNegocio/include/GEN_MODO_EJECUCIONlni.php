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
require_once(PATH_CONTROLADOR_DAO . "/GEN_MODO_EJECUCIONdao.php");

require_once("/LNinclude.php");
       
function ModoEjecucion_Datos($PIDE) {
    
    $DES_MODO_EJECUCION = $DES_ABREVIATURA = $EST_MODO_EJECUCION = '';
        
    if($PIDE>0) {
        $campos = " DES_MODO_EJECUCION, DES_ABREVIATURA, EST_MODO_EJECUCION ";
        $filtro = "  AND IDE_MODO_EJECUCION =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_MODO_EJECUCION',$campos,$filtro) ;
        if(count($data)>0) {
            $DES_MODO_EJECUCION  = $data[0]->DES_MODO_EJECUCION ;
            $DES_ABREVIATURA  = $data[0]->DES_ABREVIATURA ;
            $EST_MODO_EJECUCION  = $data[0]->EST_MODO_EJECUCION ;
        }
    }
    
    $Resultado = array (
        'IDE_MODO_EJECUCION' => $PIDE ,
        'DES_MODO_EJECUCION' => $DES_MODO_EJECUCION ,
        'DES_ABREVIATURA' => $DES_ABREVIATURA ,
        'EST_MODO_EJECUCION' => $EST_MODO_EJECUCION 
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