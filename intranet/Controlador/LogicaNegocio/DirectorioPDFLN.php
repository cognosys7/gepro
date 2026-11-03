<?php
require_once(PATH_CONTROLADOR_DAO . "/DirectorioDAO.php");
require_once(PATH_LIB . "/Collection.php");
require_once(PATH_LIB . '/util.php');
require_once(PATH_LIB . '/functions.php');

function EjecutaLN() 
{
    $sMensaje = 1;
    $lReporte = array();
    $lFiltro = null;
    
    $TipoBusqueda     = isset($_REQUEST['TipoBusqueda'])? $_REQUEST['TipoBusqueda'] : '';
    
    if ((isset($_REQUEST['Action'])) && ($_REQUEST['Action'] == 'Generar')) 
    {       
        $objDirectorioDAO = new DirectorioDAO();
        $objDirectorioDAO->ListadoDirectorio($lReporte);
        $sMensaje = count($lReporte) > 0 ? 2 : 3;
    }

    $lCollection = Collection::Singleton();
    $lCollection->Add('lReporte', $lReporte);
    $lCollection->Add('lFiltro', $lFiltro);
    $lCollection->Add('sMensaje', $sMensaje);
    $lCollection->Add('TipoBusqueda', $TipoBusqueda);
}

?>