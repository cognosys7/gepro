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
require_once(PATH_CONTROLADOR_DAO . "/PLAN_RECURSODAO.php");

require_once("/LNinclude.php");
       


function PlanRecurso_x_Usuario_Datos($PIDE) {
    
    $IDE_PLAN_RECURSO = 0;
    
    $campos = " IDE_PLAN_RECURSO ";
    $filtro = " and U.idusuario = ".$PIDE;
        $data = VIS_SelCampos_SQL ('PLAN_RECURSO',$campos,$filtro,"x_Usuario_") ;    
    
    if(count($data)>0) {
        $IDE_PLAN_RECURSO       = $data[0]->IDE_PLAN_RECURSO ;
    }
    
    $Resultado = array (
        'IdPlanRecurso' => $IDE_PLAN_RECURSO
    ) ;
    //var_dump($Resultado); echo " U.idusuario = ".$PIDE; die;
    return $Resultado ;
}

?>