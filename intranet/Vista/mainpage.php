<?php
require_once('../Configuracion.php');
require_once(PATH_CONTROLADOR_LN . "/DetectionLN.php");
require_once('Inicio.php');
function principal() 
{
    $lPagina = 'Dashboard';
    $lVistaLocal = '';
    $lAjax   = '';
    
    if (isset($_REQUEST['Pagina']) && !empty($_REQUEST['Pagina']))
    {
        $lPagina        = $_REQUEST['Pagina'];
    }
    
    if (isset($_REQUEST['AccionLocal']) && !empty($_REQUEST['AccionLocal'])) 
    {
        $lVistaLocal    = $_REQUEST['Accion'];
        $lAjax          = $_REQUEST['AccionLocal'];
    }
    Vista($lPagina,$lVistaLocal,$lAjax);

}
principal();
?>