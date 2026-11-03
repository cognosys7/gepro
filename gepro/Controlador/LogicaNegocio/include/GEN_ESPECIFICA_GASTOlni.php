<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : GEN_ESPECIFICA_GASTO de la tabla GEN_ESPECIFICA_GASTO
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_ESPECIFICA_GASTOdao.php");

require_once("/LNinclude.php");
       
function EspecificaGasto_Datos($PIDE) {
    
    $NUM_ANHO = $COD_ESPECIFICA_GASTO = $DES_ESPECIFICA_GASTO = $COD_GENERICA = $DES_GENERICA = $COD_SUBGENERICA = $DES_SUBGENERICA = '';
    $COD_SUBGENERICA_DET = $DES_SUBGNERICA_DET = $COD_ESPECIFICA = $DES_ESPECIFICA = $COD_ESPECIFICA_DET = $DES_ESPECIFICA_DET = $EST_ESPECIFICA_GASTO = '';
        
    if($PIDE>0) {
        $campos = " NUM_ANHO, COD_ESPECIFICA_GASTO, DES_ESPECIFICA_GASTO, COD_GENERICA, DES_GENERICA, COD_SUBGENERICA, DES_SUBGENERICA, ";
        $campos .= " COD_SUBGENERICA_DET, DES_SUBGNERICA_DET, COD_ESPECIFICA, DES_ESPECIFICA, COD_ESPECIFICA_DET, DES_ESPECIFICA_DET, EST_ESPECIFICA_GASTO ";
        
        $filtro = "  AND IDE_ESPECIFICA_GASTO =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_ESPECIFICA_GASTO',$campos,$filtro) ;
        if(count($data)>0) {
            $NUM_ANHO               = $data[0]->NUM_ANHO ;
            $COD_ESPECIFICA_GASTO   = $data[0]->COD_ESPECIFICA_GASTO ;
            $DES_ESPECIFICA_GASTO   = $data[0]->DES_ESPECIFICA_GASTO ;
            $COD_GENERICA           = $data[0]->COD_GENERICA ;
            $DES_GENERICA           = $data[0]->DES_GENERICA ;
            $COD_SUBGENERICA        = $data[0]->COD_SUBGENERICA ;
            $DES_SUBGENERICA        = $data[0]->DES_SUBGENERICA ;
            $COD_SUBGENERICA_DET    = $data[0]->COD_SUBGENERICA_DET ;
            $DES_SUBGNERICA_DET     = $data[0]->DES_SUBGNERICA_DET ;
            $COD_ESPECIFICA         = $data[0]->COD_ESPECIFICA ;
            $DES_ESPECIFICA         = $data[0]->DES_ESPECIFICA ;
            $COD_ESPECIFICA_DET     = $data[0]->COD_ESPECIFICA_DET ;
            $DES_ESPECIFICA_DET     = $data[0]->DES_ESPECIFICA_DET ;
            $EST_ESPECIFICA_GASTO   = $data[0]->EST_ESPECIFICA_GASTO ;
        }
    }
    
    $Resultado = array (
        'BIDE'                  => $PIDE ,
        'NUM_ANHO'              => $NUM_ANHO ,
        'COD_ESPECIFICA_GASTO'  => $COD_ESPECIFICA_GASTO ,
        'DES_ESPECIFICA_GASTO'  => $DES_ESPECIFICA_GASTO ,
        'COD_GENERICA'          => $COD_GENERICA ,
        'DES_GENERICA'          => $DES_GENERICA ,
        'COD_SUBGENERICA'       => $COD_SUBGENERICA ,
        'DES_SUBGENERICA'       => $DES_SUBGENERICA ,
        'COD_SUBGENERICA_DET'   => $COD_SUBGENERICA_DET ,
        'DES_SUBGNERICA_DET'    => $DES_SUBGNERICA_DET ,
        'COD_ESPECIFICA'        => $COD_ESPECIFICA ,
        'DES_ESPECIFICA'        => $DES_ESPECIFICA ,
        'COD_ESPECIFICA_DET'    => $COD_ESPECIFICA_DET ,
        'DES_ESPECIFICA_DET'    => $DES_ESPECIFICA_DET ,
        'EST_ESPECIFICA_GASTO'  => $EST_ESPECIFICA_GASTO
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