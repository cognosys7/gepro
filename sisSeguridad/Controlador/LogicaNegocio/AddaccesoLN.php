<?php

    require_once(PATH_CONTROLADOR_DAO . "/OpcionDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/AccesoDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/PerfilDAO.php");   
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Addacceso";
        $PermisoOK        = 0;
                
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Tabs'])) {       $tabs = $_POST['Tabs'];} else { $tabs = 0;}
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTENGO LOS POST DEL FORMULARIO
        $IdPerfil               = isset($_REQUEST['IP'])? htmlspecialchars($_REQUEST['IP']) : "";
        $IdModulo               = isset($_REQUEST['IM'])? htmlspecialchars($_REQUEST['IM']) : "";
        $IdOpcion               = isset($_POST['IO']) ? htmlspecialchars($_POST['IO']) : "";
        $Action                 = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        
        //LLAMO AL DAO DE LA SEGURIDAD
        $PermisosPerfil         = CallNomPerfil($perfilsession);
        if (($PermisosPerfil == "ADMINISTRADOR" OR $PermisosPerfil == "GESTOR DE USUARIOS"))
        {
            $PermisoOK = 1;
        }
        
        if ($PermisoOK == 1)
        {
            /* FLEXIGRID */
            $ScriptFLX = " AND S1.opcmodulo = $IdModulo";
            if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJsonList')) 
            {
                $lDato       = array();
                $oPerfilDAO = new OpcionDAO();
                if($_POST['query']<>'%')
                {
                    if(strlen(trim($_POST['query'])) > 0)
                    {
                        $lFiltro = " AND ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ".$ScriptFLX;
                    }
                    else
                    {
                        $lFiltro  = $ScriptFLX;
                    }
                } 
                else
                {
                    $lFiltro  = $ScriptFLX;
                }
                //LLAMO AL CONTADOR
                //PARAMETRO PARA CONTADOR
                $lParametroP                 = array();
                $lParametroP['Script']       = $lFiltro;
                $procedure_paramsP = array(
                      array(&$lParametroP['Script'], SQLSRV_PARAM_IN)
                );
                $oPerfilDAO->CuentaOpcion($lDato, $procedure_paramsP);
                $nTotal = $lDato[0]->idopcion;
                GenerarDatosParaFlexigridSP1($oPerfilDAO, 'ListaOpcionesAcceso',$nTotal, $_POST['page'],$lFiltro,$IdPerfil, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;
            }
            
            if ($Action == "AgregarAcceso")
            {
                $lstAcceso      = array();
                $objAccesoDAO   = new AccesoDAO();
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                    = array();
                $lParametroS['Opcion']          = $IdOpcion;
                $lParametroS['Perfil']          = $IdPerfil;
                $lParametroS['Tipo']            = 1;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['Opcion'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Perfil'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Tipo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                
                $objAccesoDAO->AgregaQuitaAcceso($lstAcceso, $procedure_paramsP);
                $mensaje = $procedure_paramsP[4][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Accion=muestraVista&AccionLocal=1&Mensaje=".$mensaje."&IP=".$IdPerfil."&IM=".$IdModulo); 
                exit;
            }
            
            if ($Action == "QuitarAcceso")
            {
                $lstAcceso      = array();
                $objAccesoDAO   = new AccesoDAO();
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                    = array();
                $lParametroS['Opcion']          = $IdOpcion;
                $lParametroS['Perfil']          = $IdPerfil;
                $lParametroS['Tipo']            = 2;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['Opcion'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Perfil'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Tipo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objAccesoDAO->AgregaQuitaAcceso($lstAcceso, $procedure_paramsP);
                $mensaje = $procedure_paramsP[4][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Accion=muestraVista&AccionLocal=1&Mensaje=".$mensaje."&IP=".$IdPerfil."&IM=".$IdModulo); 
                exit;
            }
            
            $pefnombre      = "";
            $sisnombre      = "";
            //PERFIL
            $lParametroP                = array();
            $objPerfilDAO               = new PerfilDAO();
            $lParametroP['IdPerfil']    = $IdPerfil;
            $procedure_paramsP = array
            (
                  array(&$lParametroP['IdPerfil'], SQLSRV_PARAM_IN)
            );
            $lstPerfil       = array();
            $objPerfilDAO->VerificaPerfilxID($lstPerfil,$procedure_paramsP);
            $listaPerfil  = count($lstPerfil) > 0 ? true : false;
            if (($listaPerfil == true) || ($listaPerfil > 0)) 
            {
                $pefnombre        = $lstPerfil[0]->pefnombre;
                $sisnombre        = $lstPerfil[0]->sisnombre;
            }
            $lCollection->Add('pefnombre', $pefnombre);
            $lCollection->Add('sisnombre', $sisnombre); 
            $lCollection->Add('IdModulo', $IdModulo);
            $lCollection->Add('IdPerfil', $IdPerfil);
            
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Tabs', $tabs);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);
        
    }
?>