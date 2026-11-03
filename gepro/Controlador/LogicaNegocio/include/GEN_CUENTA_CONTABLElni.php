<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : GEN_CUENTA_CONTABLE de la tabla GEN_CUENTA_CONTABLE
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_CUENTA_CONTABLEdao.php");

require_once("/LNinclude.php");
       
function CuentaContable_Datos($PIDE) {
    
    $COD_CUENTA_CONTABLE = $DES_CUENTA_CONTABLE = $EST_CUENTA_CONTABLE = '';
        
    if($PIDE>0) {
        $campos = " COD_CUENTA_CONTABLE, DES_CUENTA_CONTABLE, EST_CUENTA_CONTABLE ";
        $filtro = "  AND IDE_CUENTA_CONTABLE =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_CUENTA_CONTABLE',$campos,$filtro) ;
        if(count($data)>0) {
            $COD_CUENTA_CONTABLE    = $data[0]->COD_CUENTA_CONTABLE ;
            $DES_CUENTA_CONTABLE    = $data[0]->DES_CUENTA_CONTABLE ;
            $EST_CUENTA_CONTABLE    = $data[0]->EST_CUENTA_CONTABLE ;
        }
    }
    
    $Resultado = array (
        'BIDE'                  => $PIDE ,
        'COD_CUENTA_CONTABLE'   => $COD_CUENTA_CONTABLE ,
        'DES_CUENTA_CONTABLE'   => $DES_CUENTA_CONTABLE ,
        'EST_CUENTA_CONTABLE'   => $EST_CUENTA_CONTABLE
    ) ;
    
    return $Resultado ;
}

//
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