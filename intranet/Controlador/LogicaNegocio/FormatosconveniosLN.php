<?php
    require_once(PATH_CONTROLADOR_DAO . "/DirectorioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(PATH_LIB . '/functions.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection        = Collection::Singleton();
        $PaginaFormulario   = "Formatosconvenios";

        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
    }
?>