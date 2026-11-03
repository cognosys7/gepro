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
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       


function Entidad_Datos($PIDE) {
    
    $IDE_ENTIDAD = $DES_ENTIDAD = $COD_RUC = $DES_ABREVIATURA = $TIP_GOBIERNO = $COD_UBIGEO = null;
    
    $campos = " IDE_ENTIDAD , IDE_ENTIDAD_SUP , IDE_SECTOR , COD_RUC,COD_ENTIDAD , DES_ENTIDAD , COD_PLIEGO , DES_ABREVIATURA , TIP_GOBIERNO , TIP_ENTIDAD , NUM_NIVEL , EST_ENTIDAD , SEC_EJEC , COD_UBIGEO ";
    
    if($PIDE>0){
        $filtro = "  AND IDE_ENTIDAD =".$PIDE ;// echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_ENTIDAD',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_ENTIDAD        = $data[0]->IDE_ENTIDAD ;
            $DES_ENTIDAD        = $data[0]->DES_ENTIDAD ;
            $COD_RUC            = $data[0]->COD_RUC ;
            $DES_ABREVIATURA    = $data[0]->DES_ABREVIATURA ;
            $TIP_GOBIERNO       = $data[0]->TIP_GOBIERNO ;
            $COD_UBIGEO         = $data[0]->COD_UBIGEO ;      
        }
    }
    
    $Resultado = array (
            'IDE_ENTIDAD'       => $IDE_ENTIDAD 
            ,'DES_ENTIDAD'      => $DES_ENTIDAD
            ,'COD_RUC'          => $COD_RUC
            ,'DES_ABREVIATURA'  => $DES_ABREVIATURA
            ,'TIP_GOBIERNO'     => $TIP_GOBIERNO
            ,'COD_UBIGEO'       => $COD_UBIGEO
    ) ;
    
    return $Resultado ;
}

?>