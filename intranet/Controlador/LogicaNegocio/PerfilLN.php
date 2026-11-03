<?php
    require_once(PATH_CONTROLADOR_DAO . "/DirectorioDAO.php");
    require_once(PATH_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        $PaginaFormulario = "Perfil";
        
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
        if (!empty($_SESSION['personaNombre'])) { $personaNombre = $_SESSION['personaNombre'];} else { $personaNombre = 0;}
        if (!empty($_SESSION['centroNombre'])) { $centroNombre = $_SESSION['centroNombre'];} else { $centroNombre = 0;}
        
        $Action             = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        $Codigo             = isset($_POST['Codigo']) ? htmlspecialchars($_POST['Codigo']) : "";
        $DirectoNum         = isset($_POST['DirectoNum']) ? htmlspecialchars($_POST['DirectoNum']) : "615-5960";
        $AnexoNum           = isset($_POST['AnexoNum']) ? htmlspecialchars($_POST['AnexoNum']) : "";
        $CelularNum         = isset($_POST['CelularNum']) ? htmlspecialchars($_POST['CelularNum']) : "";
        $Mail               = isset($_POST['correoInstitucional']) ? htmlspecialchars($_POST['correoInstitucional']) : "";
        
        $objDirectorioDAO   = new DirectorioDAO();
        $lstDirectorio      = array();
        $objDirectorioDAO->VerificaDirectorioSelect($lstDirectorio, $personal);
        $listaDirectorio    = count($lstDirectorio) > 0 ? true : false;
        if (($listaDirectorio == true) || ($listaDirectorio > 0))
        {
            $iddirectorio           = $lstDirectorio[0]->iddirectorio;
            $dirtelfdirecto         = $lstDirectorio[0]->dirtelfdirecto;
            $dirtelfanexo           = $lstDirectorio[0]->dirtelfanexo;
            $dircelular             = $lstDirectorio[0]->dircelular;
            $dircorreo              = $lstDirectorio[0]->dircorreo;
        }
        else
        {
            $iddirectorio           = "";
            $dirtelfdirecto         = "";
            $dirtelfanexo           = "";
            $dircelular             = "";
            $dircorreo              = "";
        }
        
        if ($Action == "RegistraDirectorio")
        {
            //VERIFICO SI TENGO O NO REGISTRADO EN DIRECTORIO CON LOS DATOS
            $lstDirectorioReg       = array();
            $lstDirectorio          = array();
//            $objDirectorio          = new Directorio();
            $objDirectorioDAO       = new DirectorioDAO();
            $objDirectorioDAO->VerificaDirectorioSelect($lstDirectorioReg,$personal);
            $listaDirectorio  = count($lstDirectorioReg) > 0 ? true : false;
            if (($listaDirectorio == true) || ($listaDirectorio > 0)) 
            {
//                $objDirectorio->dirtelfdirecto      = $DirectoNum;
//                $objDirectorio->dirtelfanexo        = $AnexoNum;
//                $objDirectorio->dircelular          = $CelularNum;
//                $objDirectorio->dircorreo           = $Mail;
//                $objDirectorio->dirusuactualiza     = $usuario;
//                $objDirectorio->iddirectorio        = $Codigo;
//                $objDirectorioDAO->ActualizaDirectorio($objDirectorio);
                $lstParametrosR                     = array();
                $lstParametrosR['TelfDirecto']      = $DirectoNum;
                $lstParametrosR['Anexo']            = $AnexoNum;
                $lstParametrosR['Celular']          = $CelularNum;
                $lstParametrosR['Correo']           = $Mail;
                $lstParametrosR['Usuario']          = $usuario;
                $lstParametrosR['Codigo']           = $Codigo;
                $lstParametrosR['PCODIGO']          = str_repeat("\0", 200);
                $lstParametrosR['PMENSAJE']         = str_repeat("\0", 200);
                $procedure_paramsRS = array(
                    array(&$lstParametrosR['TelfDirecto'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Anexo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Celular'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Correo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosR['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objDirectorioDAO->ActualizaDirectorio($lstDirectorio,$procedure_paramsRS);
                header("Location: AntiRefresh.php?Pagina=Dashboard");
                exit;
            }
            else
            {
//                $objDirectorio->dirpersonal         = $personal;
//                $objDirectorio->dirtelfdirecto      = $DirectoNum;
//                $objDirectorio->dirtelfanexo        = $AnexoNum;
//                $objDirectorio->dircelular          = $CelularNum;
//                $objDirectorio->dircorreo           = $Mail;
//                $objDirectorio->dirusuactualiza     = $usuario;
//                $objDirectorioDAO->InsertarDirectorio($objDirectorio);
                $lstParametrosR                     = array();
                $lstParametrosR['Personal']         = $personal;
                $lstParametrosR['TelfDirecto']      = $DirectoNum;
                $lstParametrosR['Anexo']            = $AnexoNum;
                $lstParametrosR['Celular']          = $CelularNum;
                $lstParametrosR['Correo']           = $Mail;
                $lstParametrosR['Usuario']          = $usuario;
                $lstParametrosR['PCODIGO']          = str_repeat("\0", 200);
                $lstParametrosR['PMENSAJE']         = str_repeat("\0", 200);
                $procedure_paramsRS = array(
                     array(&$lstParametrosR['Personal'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['TelfDirecto'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Anexo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Celular'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Correo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosR['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosR['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objDirectorioDAO->InsertarDirectorio($lstDirectorio,$procedure_paramsRS);
                header("Location: AntiRefresh.php?Pagina=Dashboard");
                exit;
            }
            
            $lstParametrosR                     = array();
            $lstParametrosR['dirpersonal']      = $personal;
            $lstParametrosR['dirtelfdirecto']   = $DirectoNum;
            $lstParametrosR['dirtelfanexo']     = $AnexoNum;
            $lstParametrosR['dircelular']       = $CelularNum;
            $lstParametrosR['dircorreo']        = $Mail;
            $lstParametrosR['dirusuactualiza']  = $usuario;
            $lstParametrosR['iddirectorio']     = $Codigo;
            $lstParametrosR['PMENSAJE']          = str_repeat("\0", 200);
            $lstParametrosR['PCODIGO']          = str_repeat("\0", 200);
            $procedure_paramsRS = array(
                  array(&$lstParametrosR['RqFechaRegistro'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqIdPersonal'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqEstadoAtencion'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqAsunto'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqDetalle'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqEstado'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqUsuRegistra'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqTipoIncidente'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqAdjunto'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqIDHardware'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['RqModoRegistro'], SQLSRV_PARAM_IN)
                , array(&$lstParametrosR['PMENSAJE'], SQLSRV_PARAM_OUT)
                , array(&$lstParametrosR['PCODIGO'], SQLSRV_PARAM_OUT)
            );
            $objFilRegDAO->InsertarNuevaIncidencia($lstInformacion,$procedure_paramsRS);
            $mensaje    = $procedure_paramsRS[11][0];
            $IdIncidente= $procedure_paramsRS[12][0];
        }
        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('personaNombre', $personaNombre);
        $lCollection->Add('centroNombre', $centroNombre);
        $lCollection->Add('iddirectorio', $iddirectorio);
        $lCollection->Add('dirtelfdirecto', $dirtelfdirecto);
        $lCollection->Add('dirtelfanexo', $dirtelfanexo);
        $lCollection->Add('dircelular', $dircelular);
        $lCollection->Add('dircorreo', $dircorreo);
        
    }
?>