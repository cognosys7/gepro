<?php
require_once('../Configuracion.php');
require_once('Vista.php');
function principal()
{
    $lPagina        = 'Principal';
    $lVistaLocal    = '';
    $lAjax          = '';
    
    if (isset($_GET['Pagina']) && !empty($_GET['Pagina']))
    {
        $lPagina = $_REQUEST['Pagina'];
    }
    if (isset($_POST['Pagina']) && !empty($_POST['Pagina']))
    {
        $lPagina = $_POST['Pagina'];
    }
    if (isset($_GET['AccionLocal']) && !empty($_GET['AccionLocal'])) 
    {
        $lVistaLocal = $_REQUEST['Accion'];
        $lAjax = $_REQUEST['AccionLocal'];
    }

    if (isset($_POST['AccionLocal']) && !empty($_POST['AccionLocal'])) 
    {
        $lVistaLocal = $_POST['Accion'];
        $lAjax = $_POST['AccionLocal'];
    }
    
    Vista($lPagina,$lVistaLocal,$lAjax);
}
principal();
?>