<?php
require_once(PATH_CONTROLADOR_DAO . "/PivotDAO.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(PATH_LIB . '/util.php');

function EjecutaLN() {   
    ValidaSession();
    
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'MuestraVista')) {
    }
    if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'MostrarItemsPivot')) {
                header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
                header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
                header("Cache-Control: no-cache, must-revalidate");
                header("Pragma: no-cache");
                header('Content-type: application/json; charset=utf-8');
                header("Content-type: text/x-json");
                  
		//Obtener lista de datos
                $lData;
                $oPivotDAO = new PivotDAO();    
                $oPivotDAO->SelectPivot_01($lData);
                
                //Dar formato para pivot
                $lDataJson  = array();
                foreach ($lData as $nkey => $oData) {
                    $lDataJson[$nkey] = $oData->getPropertyList();
                }
                $lstData = json_encode($lDataJson); 
                echo $lstData;  
                exit;
    }

    $lCollection = Collection::Singleton();
//    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "Pivot";
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