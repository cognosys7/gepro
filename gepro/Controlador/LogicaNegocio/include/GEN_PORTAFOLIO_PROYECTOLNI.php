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
require_once(PATH_CONTROLADOR_DAO . "/GEN_PORTAFOLIO_PROYECTODAO.php");

require_once("/LNinclude.php");
       
function PortafolioProyecto_Datos($PIDE) {
    
    $IDE_PORTAFOLIO = $COD_PORTAFOLIO = $DES_PORTAFOLIO = '';
        
    if($PIDE>0) {
        $campos = " IDE_PORTAFOLIO , COD_PORTAFOLIO , DES_PORTAFOLIO ";
        $filtro = "  AND IDE_PORTAFOLIO =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_PORTAFOLIO_PROYECTO',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PORTAFOLIO     = $data[0]->IDE_PORTAFOLIO ;
            $COD_PORTAFOLIO     = $data[0]->COD_PORTAFOLIO ;
            $DES_PORTAFOLIO     = $data[0]->DES_PORTAFOLIO ;
        }
    }
    
    $Resultado = array (
        'IDE_PORTAFOLIO'        => $IDE_PORTAFOLIO ,
        'COD_PORTAFOLIO'        => $COD_PORTAFOLIO ,
        'DES_PORTAFOLIO'        => $DES_PORTAFOLIO
    ) ;
    
    return $Resultado ;
}

?>