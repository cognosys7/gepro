<?php
    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    function EjecutaLN() 
    {
        //ValidaSession();
        $lCollection = Collection::Singleton();
        $PaginaFormulario = "Recuperaclave";
        
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
        
        $Action             = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        $Clave1             = isset($_POST['Clave1']) ? htmlspecialchars($_POST['Clave1']) : "";
        $Clave2             = isset($_POST['Clave2']) ? htmlspecialchars($_POST['Clave2']) : "";
        
        if ($Action == "RecuperaClave")
        {
            $_SESSION['SeguridadPass']  = 0;
            $lstUsuario                 = array();
            $lstUsuarioUpd              = array();
//            $objUsuario                 = new Usuario();
            $objUsuarioDAO              = new UsuarioDAO();
            $objUsuarioDAO->VerificaUsuarioSelect($lstUsuario,$usuario);
            $Usunombre                  = $lstUsuario[0]->usunombre;
            $PassEncript                = md5($Usunombre.$Clave2.'Cognosys@SAC');         
            $lstParametrosR                     = array();
            $lstParametrosR['Clave']            = $PassEncript;
            $lstParametrosR['Usuario']          = $usuario;
            $lstParametrosR['Codigo']           = $usuario;
            $lstParametrosR['PCODIGO']          = str_repeat("\0", 200);
            $lstParametrosR['PMENSAJE']         = str_repeat("\0", 200);
            $procedure_paramsRS = array(
                 array(&$lstParametrosR['Clave'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['Codigo'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstParametrosR['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $objUsuarioDAO->ActualizaClaveUsuario($lstUsuarioUpd,$procedure_paramsRS);
            header("Location: AntiRefresh.php?Pagina=Clave");
            exit;
        }
        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        
    }
?>