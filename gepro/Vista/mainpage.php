<?php
require_once('../Configuracion.php');
require_once(SEG_CONTROLADOR_LN . "/DetectionLN.php");
require_once('Vista.php');
function principal() {
    $lPagina = 'Principal';
    $lVistaLocal = '';
    $lAjax ='';
    
    isset($_SESSION['Op'])? $_SESSION['Op'] : "";
    isset($_SESSION['Oc'])? $_SESSION['Oc'] : "";
    
    if (isset($_GET['Op']) && !empty($_GET['Op']))
    {
        $_SESSION['Op'] = $_GET['Op'];
    }
    if (isset($_GET['Oc']) && !empty($_GET['Oc']))
    {
        $_SESSION['Oc'] = $_GET['Oc'];
    }

    if (isset($_REQUEST['Pagina']) && !empty($_REQUEST['Pagina']))
    {
        $lPagina = $_REQUEST['Pagina'];
    }

    if (isset($_REQUEST['AccionLocal']) && !empty($_REQUEST['AccionLocal'])) 
    {
        $lVistaLocal = $_REQUEST['Accion'];
        $lAjax       = $_REQUEST['AccionLocal'];
    }
    
    if ($lPagina == "Principal")
    {
        $_SESSION['Op'] = "";
        $_SESSION['Oc'] = "";
    }

    Vista($lPagina,$lVistaLocal,$lAjax);
}
principal();
?>