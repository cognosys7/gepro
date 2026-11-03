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
require_once(PATH_CONTROLADOR_DAO . "/GEN_PROGRAMA_PROYECTODAO.php");

require_once("/LNinclude.php");
       
function ProgramaProyecto_Datos($PIDE) {
    
    $IDE_PORTAFOLIO = $DES_PROGRAMA = '';
        
    if($PIDE>0) {
        $campos = " IDE_PROGRAMA , DES_PROGRAMA ";
        $filtro = "  AND IDE_PROGRAMA =".$PIDE ; //echo $campos.''.$filtro.'-';die;
            $data = VIS_SelCampos ('GEN_PROGRAMA_PROYECTO',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_PORTAFOLIO     = $data[0]->IDE_PORTAFOLIO ;
            $DES_PROGRAMA       = $data[0]->DES_PROGRAMA ;
        }
    }
    
    $Resultado = array (
        'IDE_PORTAFOLIO'        => $IDE_PORTAFOLIO ,
        'DES_PROGRAMA'          => $DES_PROGRAMA 
    ) ;
    
    return $Resultado ;
}

?>