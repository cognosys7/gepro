<?php
require_once(PATH_CONTROLADOR_DAO . "/ConsultareporteDAO.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(PATH_LIB . '/util.php');

function EjecutaLN() {   
    
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'MuestraVista')) {
    }
    
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'ListarAnio')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                $lData;
                $oConsultareporteDAO = new ConsultareporteDAO();    
                $oConsultareporteDAO->SelectPapeletaAnio($lData);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;

    }  
    
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'ListarMes')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                
                $lData;
                $oConsultareporteDAO = new ConsultareporteDAO();    
                $oConsultareporteDAO->SelectPapeletaMes($lData);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;

    }  
            
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'ListarMotivo')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                
                $lData;
                $oConsultareporteDAO = new ConsultareporteDAO();    
                $oConsultareporteDAO->SelectPapeletaMotivo($lData);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;
    }  
    
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'ListarOficina')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                
                $lData;
                $oConsultareporteDAO = new ConsultareporteDAO();    
                $oConsultareporteDAO->SelectPapeletaOficina($lData);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;

    }  
    
       
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'ListarEstado')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                
                $lData;
                $oConsultareporteDAO = new ConsultareporteDAO();    
                $oConsultareporteDAO->SelectPapeletaEstado($lData);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;
    }  
     if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'ListarSituacion')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                
                $lData;
                $oConsultareporteDAO = new ConsultareporteDAO();    
                $oConsultareporteDAO->SelectPapeletaSituacion($lData);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;
    }  
     if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'MostrarTablaVisitas')) {
                
                $Año                    = isset($_REQUEST['Anio'])? trim($_REQUEST['Anio']) : 0;  
                $Mes                    = isset($_REQUEST['Mes'])? trim($_REQUEST['Mes']) : 0;  
                $IdMotivo               = isset($_REQUEST['IdMotivo'])? trim($_REQUEST['IdMotivo']) : 0;
                $IdOficina              = isset($_REQUEST['IdOficina'])? trim($_REQUEST['IdOficina']) : 0;                
                $IdEstado               = isset($_REQUEST['IdEstado'])? trim($_REQUEST['IdEstado']) : 0;
                $IdSituacion            = isset($_REQUEST['IdSituacion'])? trim($_REQUEST['IdSituacion']) : 0;
                $NombreEmpleado         = isset($_REQUEST['NombreEmpleado'])? trim($_REQUEST['NombreEmpleado']) : '';
                $ApellidoEmpleado       = isset($_REQUEST['ApellidoEmpleado'])? trim($_REQUEST['ApellidoEmpleado']) : '';                
                $RangoFecha             = isset($_REQUEST['RangoFecha'])? trim($_REQUEST['RangoFecha']) : '';        

                $lData = array();
                $oConsultaReporteDAO = new ConsultaReporteDAO();
                
                $lstParametros = array();
                $lstParametros['Año'] = $Año;
                $lstParametros['Mes'] = $Mes;
                $lstParametros['IdMotivo'] = $IdMotivo;
                $lstParametros['IdOficina'] = $IdOficina;
                $lstParametros['IdEstado'] = $IdEstado;
                $lstParametros['IdSituacion'] = $IdSituacion;
                $lstParametros['NombreEmpleado'] = $NombreEmpleado;
                $lstParametros['ApellidoEmpleado'] = $ApellidoEmpleado;
                $lstParametros['RangoFecha'] = $RangoFecha;


                $procedure_paramsS = array(
                       array(&$lstParametros['Año'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['Mes'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['IdMotivo'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['IdOficina'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['IdEstado'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['IdSituacion'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['NombreEmpleado'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['ApellidoEmpleado'], SQLSRV_PARAM_IN)
                     , array(&$lstParametros['RangoFecha'], SQLSRV_PARAM_IN)                    
                );

   
                $oConsultaReporteDAO->SelectReporte_01($lData, $procedure_paramsS);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;
    } 

    
        ValidaSession();

       $lCollection = Collection::Singleton();
//    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "ConsultaReporte";
    $PermisoOK = 0;
    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Tabs'])) {
        $tabs = $_POST['Tabs'];
    } else {
        $tabs = 0;
    }
    if (!empty($_POST['Mensaje'])) {
        $mensaje = $_POST['Mensaje'];
    } else {
        $mensaje = 0;
    }

    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    } else {
        $usuario = 0;
    }
    if (!empty($_SESSION['CodPerfil'])) {
        $perfilsession = $_SESSION['CodPerfil'];
    } else {
        $perfilsession = 0;
    }

    $PermisosPerfil = CallNomPerfil($perfilsession);
    if (($PermisosPerfil == "ADMINISTRADOR")) {
        $PermisoOK = 1;
    }

    $lCollection->Add('PaginaFormulario', $PaginaFormulario);
    $lCollection->Add('Tabs', $tabs);
    $lCollection->Add('Mensaje', $mensaje);
    $lCollection->Add('PermisoOK', $PermisoOK);
}
?>