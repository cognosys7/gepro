<?php

    require_once(PATH_CONTROLADOR_DAO . "/PerfilDAO.php");   
    require_once(PATH_CONTROLADOR_DAO . "/SistemaDAO.php");   
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Perfil";
        $PermisoOK        = 0;
                
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Tabs'])) {       $tabs = $_POST['Tabs'];} else { $tabs = 0;}
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTENGO LOS POST DEL FORMULARIO
        $Action                 = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        $Codigo                 = isset($_POST['Codigo']) ? htmlspecialchars($_POST['Codigo']) : "";
        $perfilNom              = isset($_POST['perfilNom']) ? htmlspecialchars($_POST['perfilNom']) : "";
        $cboModulo              = isset($_POST['cboModulo']) ? htmlspecialchars($_POST['cboModulo']) : "";
        
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
                $oPerfilDAO = new PerfilDAO();
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
                $oPerfilDAO->CuentaPerfil($lDato, $procedure_paramsP);
                $nTotal = $lDato[0]->idperfil;
                GenerarDatosParaFlexigridSP($oPerfilDAO, 'ListaPerfil',$nTotal, $_POST['page'],$lFiltro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;
            }
            
            //OBTENGO UN LISTADO DE LOS SISTEMAS Y MODULOS
            $lstSistemas      = array();
            $objSistemasDAO   = new SistemaDAO();
            $objSistemasDAO->ListaSistemasModulos($lstSistemas);

            if ($Action == "RegistraPerfil")
            {
                $lstPerfil      = array();
                $objPerfilDAO   = new PerfilDAO();

                $tabs = 0;
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                    = array();
                $lParametroS['nomPerfil']       = $perfilNom;
                $lParametroS['IdModulo']        = $cboModulo;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['nomPerfil'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['IdModulo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objPerfilDAO->InsertaPerfil($lstPerfil, $procedure_paramsP);
                $mensaje = $procedure_paramsP[3][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ActualizaPerfil")
            {
                $lstPerfil      = array();
                $objPerfilDAO   = new PerfilDAO();
                //SE ACTUALIZA
                $tabs    = 0;
                //PARAMETRO PARA INSTITUCION
                $lParametroS                    = array();
                $lParametroS['Codigo']          = $Codigo;
                $lParametroS['IdModulo']        = $cboModulo;
                $lParametroS['nomPerfil']       = $perfilNom;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['IdModulo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['nomPerfil'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objPerfilDAO->ActualizaPerfil($lstPerfil, $procedure_paramsP);
                $mensaje = $procedure_paramsP[4][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }
            
            if ($Action == "EliminaPerfil")
            {
                $lstPerfil      = array();
                $objPerfilDAO   = new PerfilDAO();
                //SE ACTUALIZA
                $tabs    = 0;
                //PARAMETRO PARA INSTITUCION
                $lParametroS                    = array();
                $lParametroS['Codigo']          = $Codigo;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objPerfilDAO->EliminaPerfil($lstPerfil, $procedure_paramsP);
                $mensaje = $procedure_paramsP[2][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ModificaPerfil")
            {
                $tabs           = 1;
                $pefnombre      = "";
                $sisnombre      = "";
                $modnombre      = "";
                //INSTITUCION
                $lParametroP                = array();
                $objPerfilDAO               = new PerfilDAO();
                $lParametroP['IdPerfil']    = $Codigo;
                $procedure_paramsP = array
                (
                      array(&$lParametroP['IdPerfil'], SQLSRV_PARAM_IN)
                );
                $lstPerfil       = array();
                $objPerfilDAO->VerificaPerfilxID($lstPerfil,$procedure_paramsP);
                $listaPerfil  = count($lstPerfil) > 0 ? true : false;
                if (($listaPerfil == true) || ($listaPerfil > 0)) 
                {
                    $Codigo           = $lstPerfil[0]->idperfil;
                    $pefnombre        = $lstPerfil[0]->pefnombre;
                    $sisnombre        = $lstPerfil[0]->sisnombre;
                    $modnombre        = $lstPerfil[0]->modnombre;
                    $idmodulo         = $lstPerfil[0]->idmodulo;
                }
                $lCollection->Add('pefnombre', $pefnombre);
                $lCollection->Add('sisnombre', $sisnombre);
                $lCollection->Add('modnombre', $modnombre);
                $lCollection->Add('idmodulo', $idmodulo);
            }
            
            $lCollection->Add('lstSistemas', $lstSistemas);
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Tabs', $tabs);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('Codigo', $Codigo);
        $lCollection->Add('PermisoOK', $PermisoOK);
        
    }
?>