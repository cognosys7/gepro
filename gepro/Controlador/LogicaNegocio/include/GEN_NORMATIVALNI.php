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
require_once(PATH_CONTROLADOR_DAO . "/GEN_NORMATIVADAO.php");

require_once("/LNinclude.php");
       


function Normativa_Datos($PIDE) {
    
    $IDE_NORMATIVA = $COD_NORMATIVA = null;
    
    $campos = "IDE_NORMATIVA,COD_NORMATIVA";
    
    if($PIDE>0){
        $filtro = " AND IDE_NORMATIVA=".$PIDE;
            $data = VIS_SelCampos ('GEN_NORMATIVA',$campos,$filtro) ;    

        if(count($data)>0) {
            $COD_NORMATIVA       = $data[0]->COD_NORMATIVA ;
        }
    }
    
    $Resultado = array (
        'COD_NORMATIVA' => $COD_NORMATIVA
    ) ;
    
    return $Resultado ;
}

?>