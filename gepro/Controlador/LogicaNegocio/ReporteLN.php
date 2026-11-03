<?php
require_once(PATH_CONTROLADOR_DAO . "/ReporteDAO.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(PATH_LIB . '/util.php');

function EjecutaLN() {   
    
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'MuestraVista')) {
    }
    
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'ListarDepartamento')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                
                $lData;
                $oReporteDAO = new ReporteDAO();
                $oReporteDAO->SelectDepartamento($lData);
                
                //Dar formato
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;
    }  
            
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'MostrarTablaFamilias')) {
                
                $Familia                = isset($_REQUEST['FAMILIA'])? trim($_REQUEST['FAMILIA']) : '';
                $Ide_Ubigeo             = isset($_REQUEST['IDE_UBIGEO'])? trim($_REQUEST['IDE_UBIGEO']) : 0;

                $lData = array();
                $oReporteDAO = new ReporteDAO();
                
                $lstParametros = array();
                $lstParametros['FAMILIA'] = $Familia;
                $lstParametros['IDE_UBIGEO'] = $Ide_Ubigeo;

                $procedure_paramsS = array(
                      array(&$lstParametros['FAMILIA'], SQLSRV_PARAM_IN)
                    , array(&$lstParametros['IDE_UBIGEO'], SQLSRV_PARAM_IN)
                );
   
                $oReporteDAO->SelectReporteFamilia($lData, $procedure_paramsS);
                
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
    $PaginaFormulario = "Reporte";
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