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
require_once(PATH_CONTROLADOR_DAO . "/PROY_CONTRATOdao.php");

require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
       
function ProyectoContrato_Datos2($PIDE,$PIDE2) {
    
    $IDE_PROYECTO = $IDE_PROYECTO_ACTIVIDAD = $IDE_CONTRATO = $IDE_PROY_CONTRATO =$data ='';
    
    if($PIDE>0) {
        $campos = " IDE_PROYECTO, IDE_PROYECTO_ACTIVIDAD, IDE_CONTRATO , IDE_PROY_CONTRATO ";
        $filtro = "  AND IDE_PROYECTO_ACTIVIDAD =".$PIDE ."  AND IDE_PROYECTO =".$PIDE2 ; //echo $campos.' // '.$filtro;exit;
            $data = VIS_SelCampos ('PROY_CONTRATO',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_CONTRATO           = $data[0]->IDE_CONTRATO ;
            $IDE_PROY_CONTRATO      = $data[0]->IDE_PROY_CONTRATO ;
        }
    }
    
    $Resultado = array (
        'IDE_CONTRATO'              => $IDE_CONTRATO ,
        'IDE_PROY_CONTRATO'         => $IDE_PROY_CONTRATO 
    ) ;
    
    return $Resultado ;
}


       
function ProyectoContrato_Datos3($PIDE) {
    
    $IDE_PROYECTO = $IDE_PROYECTO_ACTIVIDAD = $IDE_CONTRATO = $IDE_PROY_CONTRATO =$data ='';
    
    if($PIDE>0) {
        $campos = " IDE_PROYECTO, IDE_PROYECTO_ACTIVIDAD, IDE_CONTRATO , IDE_PROY_CONTRATO ";
        $filtro = "  AND IDE_CONTRATO =".$PIDE ; //echo $campos.' // '.$filtro;exit;
            $data = VIS_SelCampos ('PROY_CONTRATO',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_CONTRATO = $data[0]->IDE_CONTRATO ;
            $IDE_PROY_CONTRATO = $data[0]->IDE_PROY_CONTRATO ;
            $IDE_PROYECTO_ACTIVIDAD = $data[0]->IDE_PROYECTO_ACTIVIDAD ;
            $IDE_PROY_CONTRATO = $data[0]->IDE_PROY_CONTRATO ;
        }
    }
    
    $Resultado = array (
        'BIDE' => $IDE_CONTRATO ,
        'IDE_PROY_CONTRATO' => $IDE_PROY_CONTRATO ,
        'IDE_PROYECTO_ACTIVIDAD' => $IDE_PROYECTO_ACTIVIDAD ,
        'IDE_PROYECTO' => $IDE_PROYECTO 
    ) ;
    
    return $Resultado ;
}

?>