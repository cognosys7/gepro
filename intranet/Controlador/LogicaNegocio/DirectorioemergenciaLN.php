<?php
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(PATH_LIB . '/functions.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection        = Collection::Singleton();
        $PaginaFormulario   = "Directorioemergencia";
        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
    }
?>