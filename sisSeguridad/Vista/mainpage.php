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
    
    if (isset($_GET['Pagina']) && !empty($_GET['Pagina']))
        $lPagina = $_REQUEST['Pagina'];

    if (isset($_POST['Pagina']) && !empty($_POST['Pagina']))
        $lPagina = $_POST['Pagina'];

    if (isset($_GET['AccionLocal']) && !empty($_GET['AccionLocal'])) {
        $lVistaLocal = $_REQUEST['Accion'];
        $lAjax       = $_REQUEST['AccionLocal'];
    }

    if (isset($_POST['AccionLocal']) && !empty($_POST['AccionLocal'])) {
        $lVistaLocal = $_POST['Accion'];
        $lAjax       = $_POST['AccionLocal'];
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