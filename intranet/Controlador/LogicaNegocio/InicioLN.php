<?php
    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    function EjecutaLN() 
    {
        $lCollection = Collection::Singleton();
        ValidaSession();

        $usuariosession = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
        $PerfilIntranet = isset($_SESSION['PerfilIntranet']) ? $_SESSION['PerfilIntranet'] : 0;
        $mensaje        = 0;
        
        

    }
?>