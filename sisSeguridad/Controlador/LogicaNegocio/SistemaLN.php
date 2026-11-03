<?php

    require_once(PATH_CONTROLADOR_DAO . "/SistemaDAO.php");    
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Sistema";
        $PermisoOK        = 0;
                
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Tabs'])) {       $tabs = $_POST['Tabs'];} else { $tabs = 0;}
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTENGO LOS POST DEL FORMULARIO
        $Action                 = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        $CodigoS                = isset($_POST['CodigoS']) ? htmlspecialchars($_POST['CodigoS']) : "";
        $CodigoM                = isset($_POST['CodigoM']) ? htmlspecialchars($_POST['CodigoM']) : "";
        $sistemaNom             = isset($_POST['sistemaNom']) ? htmlspecialchars($_POST['sistemaNom']) : "";
        $moduloNom              = isset($_POST['moduloNom']) ? htmlspecialchars($_POST['moduloNom']) : "";
        $enlace                 = isset($_POST['enlace']) ? htmlspecialchars($_POST['enlace']) : "";
        $abreviatura            = isset($_POST['abreviatura']) ? htmlspecialchars($_POST['abreviatura']) : "";
        
        //LLAMO AL DAO DE LA SEGURIDAD
        $PermisosPerfil         = CallNomPerfil($perfilsession);
        if (($PermisosPerfil == "ADMINISTRADOR" OR $PermisosPerfil == "GESTOR DE USUARIOS"))
        {
            $PermisoOK = 1;
        }
        
        if ($PermisoOK == 1)
        {
            /* FLEXIGRID */
            $ScriptFLX = " ";
            if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJsonList')) 
            {
                $lDato       = array();
                $oSistemaDAO = new SistemaDAO();
                if($_POST['query']<>'%')
                {
                    if(strlen(trim($_POST['query'])) > 0)
                    {
                        $lFiltro = " AND ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ".$ScriptFLX;
                    }
                    else
                    {
                        $lFiltro  = "";
                    }
                } 
                else
                {
                    $lFiltro  = "";
                }
                //LLAMO AL CONTADOR
                //PARAMETRO PARA CONTADOR
                $lParametroP                 = array();
                $lParametroP['Script']       = $lFiltro;
                $procedure_paramsP = array(
                      array(&$lParametroP['Script'], SQLSRV_PARAM_IN)
                );
                $oSistemaDAO->CuentaSistema($lDato, $procedure_paramsP);
                $nTotal = $lDato[0]->idsistema;
                GenerarDatosParaFlexigridSP($oSistemaDAO, 'ListaSistemas',$nTotal, $_POST['page'],$lFiltro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;
            }

            if ($Action == "RegistraSistema")
            {
                $lstSistema      = array();
                $objSistemaDAO   = new SistemaDAO();

                $tabs = 0;
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                    = array();
                $lParametroS['sisnombre']       = $sistemaNom;
                $lParametroS['sisurl']          = $enlace;
                $lParametroS['sisabreviatura']  = $abreviatura;
                $lParametroS['modnombre']       = $moduloNom;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsS = array(
                      array(&$lParametroS['sisnombre'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['sisurl'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['sisabreviatura'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['modnombre'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objSistemaDAO->InsertaSistema($lstSistema, $procedure_paramsS);
                $mensaje = $procedure_paramsS[5][0];
                
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ActualizaSistema")
            {
                $lstSistema      = array();
                $objSistemaDAO   = new SistemaDAO();
                //SE ACTUALIZA
                $tabs    = 0;
                //PARAMETRO PARA INSTITUCION
                $lParametroS                    = array();
                $lParametroS['CodigoS']         = $CodigoS;
                $lParametroS['CodigoM']         = $CodigoM;
                $lParametroS['sisnombre']       = $sistemaNom;
                $lParametroS['sisurl']          = $enlace;
                $lParametroS['sisabreviatura']  = $abreviatura;
                $lParametroS['modnombre']       = $moduloNom;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsS = array(
                      array(&$lParametroS['CodigoS'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['CodigoM'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['sisnombre'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['sisurl'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['sisabreviatura'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['modnombre'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objSistemaDAO->ActualizaSistema($lstSistema, $procedure_paramsS);
                $mensaje = $procedure_paramsS[7][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }
            
            if ($Action == "EliminaSistema")
            {
                $lstSistema      = array();
                $objSistemaDAO   = new SistemaDAO();
                //SE ACTUALIZA
                $tabs    = 0;
                //PARAMETRO PARA INSTITUCION
                $lParametroS                    = array();
                $lParametroS['CodigoS']         = $CodigoS;
                $lParametroS['CodigoM']         = $CodigoM;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsS = array(
                      array(&$lParametroS['CodigoS'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['CodigoM'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objSistemaDAO->EliminaSistema($lstSistema, $procedure_paramsS);
                $mensaje = $procedure_paramsS[3][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ModificaSistema")
            {
                $tabs           = 1;
                $sisnombre      = "";
                $sisurl         = "";
                $sisabreviatura = "";
                $CodigoM        = "";
                $modnombre      = "";
                //INSTITUCION
                $lParametroS                = array();
                $objSistemaDAO              = new SistemaDAO();
                $lParametroS['IdSistema']   = $CodigoS;
                $procedure_paramsS = array
                (
                      array(&$lParametroS['IdSistema'], SQLSRV_PARAM_IN)
                );
                $lstSistema       = array();
                $objSistemaDAO->VerSistemaSeleccionado($lstSistema,$procedure_paramsS);
                $listaSistema  = count($lstSistema) > 0 ? true : false;
                if (($listaSistema == true) || ($listaSistema > 0)) 
                {
                    $CodigoS          = $lstSistema[0]->idsistema;
                    $sisnombre        = $lstSistema[0]->sisnombre;
                    $sisurl           = $lstSistema[0]->sisurl;
                    $sisabreviatura   = $lstSistema[0]->sisabreviatura;
                    $CodigoM          = $lstSistema[0]->idmodulo;
                    $modnombre        = $lstSistema[0]->modnombre;
                }
                $lCollection->Add('sisnombre', $sisnombre);
                $lCollection->Add('sisurl', $sisurl);
                $lCollection->Add('sisabreviatura', $sisabreviatura);
                $lCollection->Add('modnombre', $modnombre);
            }
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Tabs', $tabs);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('CodigoS', $CodigoS);
        $lCollection->Add('CodigoM', $CodigoM);
        $lCollection->Add('PermisoOK', $PermisoOK);
        
    }
?>