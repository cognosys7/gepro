<?php
    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        $PaginaFormulario = "Clave";
        
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
        if (!empty($_SESSION['personaNombre'])) { $personaNombre = $_SESSION['personaNombre'];} else { $personaNombre = 0;}
        if (!empty($_SESSION['centroNombre'])) { $centroNombre = $_SESSION['centroNombre'];} else { $centroNombre = 0;}
        
        $Action             = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        $Clave1             = isset($_POST['Clave1']) ? htmlspecialchars($_POST['Clave1']) : "";
        $Clave2             = isset($_POST['Clave2']) ? htmlspecialchars($_POST['Clave2']) : "";
        $valsec             = isset($_POST['valsec']) ? htmlspecialchars($_POST['valsec']) : "";
        
        $objUsuarioDAO  = new UsuarioDAO();
        $lstUsuarios    = array();
        $objUsuarioDAO->VerificaUsuarioSelect($lstUsuarios, $usuario);
        $listaUsuarios  = count($lstUsuarios) > 0 ? true : false;
        if (($listaUsuarios == true) || ($listaUsuarios > 0))
        {
            $DNIUsuario     = $lstUsuarios[0]->PerNroDocumento;
        }
        
        if ($Action == "ActualizaClave")
        {
            //VERIFICO SI TENGO O NO REGISTRADO EN DIRECTORIO CON LOS DATOS
            $_SESSION['SeguridadPass']  = 1;
            $lstUsuario                 = array();
            $lstUsuarioUpd              = array();
//            $objUsuario                 = new Usuario();
            $objUsuarioDAO              = new UsuarioDAO();
            $objUsuarioDAO->VerificaUsuarioSelect($lstUsuario,$usuario);
            $listaUsuarios  = count($lstUsuario) > 0 ? true : false;
            if (($listaUsuarios == true) || ($listaUsuarios > 0))
            {
                $Usunombre                  = $lstUsuario[0]->usunombre;
                $PassEncript                = md5($Usunombre.$Clave2.'Cognosys@SAC');
                $lstParametrosR                     = array();
                $lstParametrosR['Clave']            = $PassEncript;
                $lstParametrosR['UsuRecup']         = $valsec;
                $lstParametrosR['Usuario']          = $usuario;
                $lstParametrosR['Codigo']           = $usuario;
                $lstParametrosR['PCODIGO']          = str_repeat("\0", 200);
                $lstParametrosR['PMENSAJE']         = str_repeat("\0", 200);
                $procedure_paramsRS = array(
                     array(&$lstParametrosR['Clave'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['UsuRecup'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosR['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objUsuarioDAO->ActualizaClaveUsuario3($lstUsuarioUpd,$procedure_paramsRS);
//                header("Location: AntiRefresh.php?Pagina=Dashboard");
                header("Location: ../../gepro");
                exit;
            }
        }
        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('DNIUsuario', $DNIUsuario);
        $lCollection->Add('personaNombre', $personaNombre);
        
    }
?>