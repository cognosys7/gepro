<?php

require_once(PATH_CONTROLADOR_DAO . "/FichaDAO.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/util.php");

function EjecutaLN() {
    $lCollection = Collection::Singleton();
    //ValidaSession();

    $PaginaFormulario = "FichaProyecto";
    $MostrarReporte = 0;

    //OBTENGOS LOS POST ANTIREFRESH
    $mensaje = isset($_REQUEST['Mensaje']) ? VerificarInputs($_REQUEST['Mensaje']) : "";
    $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
    $nCodigo = isset($_REQUEST['Codigo']) ? VerificarInputs($_REQUEST['Codigo']) : "";
    //var_dump($nCodigo); exit;

    $sMensaje = 1;
    $oFicha = new DynamicModel();

    //if ($Action == "VerReporte") {
    $MostrarReporte = 1;
    
    //Ocurrencias
    $oFichaDAO = new FichaDAO();
    $lFicha = array();
    
   //var_dump($nCodigo); exit;
    $lParametros['Codigo'] = $nCodigo;
    $procedure_paramsSO = array(
        array(&$lParametros['Codigo'], SQLSRV_PARAM_IN)
    );
    $oFichaDAO->Select_Ficha_Familia($lFicha, $procedure_paramsSO);
    
    if (count($lFicha) > 0)
        $oFicha = $lFicha[0];
    //var_dump($oFicha);

    //J
//    $lAccion1 = array();
//    $lParametros['Codigo'] = $nCodigo;
//    $procedure_paramsSAC = array(
//        array(&$lParametros['Codigo'], SQLSRV_PARAM_IN)
//    );
    //J $oFichaDAO->select_ActaConstatacion($lAccion1, $procedure_paramsSAC);

    //J
//    $lAccion2 = array();
//    $lParametros['Codigo'] = $nCodigo;
//    $procedure_paramsSAV = array(
//        array(&$lParametros['Codigo'], SQLSRV_PARAM_IN)
//    );
    //J $oFichaDAO->select_ActaVerificacion($lAccion2, $procedure_paramsSAV);
    
    //J
//    $lAccion3 = array();
//    $lParametros['Codigo'] = $nCodigo;
//    $procedure_paramsSACO = array(
//        array(&$lParametros['Codigo'], SQLSRV_PARAM_IN)
//    );
    //J $oFichaDAO->select_ActaConformidad($lAccion3, $procedure_paramsSACO);
    
    //J
//    $lAccion = array();
//    $lParametros['Codigo'] = $nCodigo;
//    $procedure_paramsSO = array(
//        array(&$lParametros['Codigo'], SQLSRV_PARAM_IN)
//    );
    //J $oFichaDAO->select_Documentacion_Familia($lAccion, $procedure_paramsSO);
    //var_dump($lAccion);exit;

    $lCollection->Add('oFicha', $oFicha);
    //$lCollection->Add('oObservacion', $oObservacion);
    //J $lCollection->Add('lAccion', $lAccion);
    //J $lCollection->Add('lAccion1', $lAccion1);
    //J $lCollection->Add('lAccion2', $lAccion2);
    //J $lCollection->Add('lAccion3', $lAccion3);
    //var_dump($oFicha,$oObservacion,$lAccion);exit;
}
?>
