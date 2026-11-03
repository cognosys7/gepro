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
require_once(PATH_CONTROLADOR_DAO . "/GEN_SECTORDAO.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function GenSector_Datos($PIDE) {
    
    $IDE_SECTOR = $COD_SECTOR = $DES_SECTOR = $DES_SECTOR_ABREVIATURA = $EST_SECTOR = '';
        
    if($PIDE>0) {
        $campos = " IDE_SECTOR, COD_SECTOR, DES_SECTOR, DES_SECTOR_ABREVIATURA, EST_SECTOR ";
        $filtro = "  AND IDE_SECTOR =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_SECTOR',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_SECTOR             = $data[0]->IDE_SECTOR ;
            $COD_SECTOR             = $data[0]->COD_SECTOR ;
            $DES_SECTOR             = $data[0]->DES_SECTOR ;
            $DES_SECTOR_ABREVIATURA = $data[0]->DES_SECTOR_ABREVIATURA ;
            $EST_SECTOR             = $data[0]->EST_SECTOR ;
        }
    }
    
    $Resultado = array (
        'IDE_SECTOR'                => $IDE_SECTOR ,
        'COD_SECTOR'                => $COD_SECTOR ,
        'DES_SECTOR'                => $DES_SECTOR ,
        'DES_SECTOR_ABREVIATURA'    => $DES_SECTOR_ABREVIATURA ,
        'EST_SECTOR'                => $EST_SECTOR 
    ) ;
    
    return $Resultado ;
}

?>