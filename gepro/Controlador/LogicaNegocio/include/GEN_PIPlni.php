<?php
/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : PLAN_SOLIC_PROY_INTERVENCIONDATA de la tabla GEN_PIP
  //  Fecha           : martes, 19 de junio de 2018 02:38:39 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_PIPDAO.php");

require_once("/LNinclude.php");
       
function PIP_Datos($PIDE) {
    
    $COD_PROYECTO = $DES_PIP = $COD_SNIP = $COD_UNICO = $COD_PROYECTO = '';
    $IMP_MONTO_VIABLE = null;
    
    if($PIDE>0) {
        $campos = " COD_PROYECTO, DES_PIP, IMP_MONTO_VIABLE, COD_SNIP, COD_UNICO ";
        $filtro = "  AND IDE_PIP =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_PIP',$campos,$filtro) ;
        if(count($data)>0) {
            $COD_PROYECTO      = $data[0]->COD_PROYECTO ;
            $DES_PIP           = $data[0]->DES_PIP ;
            $IMP_MONTO_VIABLE  = $data[0]->IMP_MONTO_VIABLE ;
            $COD_SNIP          = $data[0]->COD_SNIP ;
            $COD_UNICO         = $data[0]->COD_UNICO ;
            $COD_PROYECTO      = $data[0]->COD_PROYECTO ;
        }
    }
    
    $Resultado = array (
        'BIDE'               => $PIDE ,
        'COD_PROYECTO'      => $COD_PROYECTO ,
        'DES_PIP'           => $DES_PIP ,
        'IMP_MONTO_VIABLE'  => $IMP_MONTO_VIABLE ,
        'des_IMP_MONTO_VIABLE'  => 'S/. '.number_format($IMP_MONTO_VIABLE,2),
        'COD_SNIP'          => $COD_SNIP ,
        'COD_UNICO'         => $COD_UNICO ,
        'COD_PROYECTO'      => $COD_PROYECTO 
    ) ;
    
    return $Resultado ;
}

?>