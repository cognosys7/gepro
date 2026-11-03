<?php

    require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/SistemaDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/PerfilDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/UsuarioPerfilDAO.php");   
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Addusuarioperfil";
        $PermisoOK        = 0;
        $CargaAsignacion  = 0;
        
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Tabs'])) {       $tabs = $_POST['Tabs'];} else { $tabs = 0;}
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTENGO LOS POST DEL FORMULARIO
        $Codigo                 = isset($_REQUEST['Codigo'])? htmlspecialchars($_REQUEST['Codigo']) : "";
        $CodigoM                = isset($_REQUEST['CodigoM'])? htmlspecialchars($_REQUEST['CodigoM']) : "";
        $CodigoP                = isset($_REQUEST['CodigoP'])? htmlspecialchars($_REQUEST['CodigoP']) : "";
        $Action                 = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        
        //LLAMO AL DAO DE LA SEGURIDAD
        $PermisosPerfil         = CallNomPerfil($perfilsession);
        if (($PermisosPerfil == "ADMINISTRADOR" OR $PermisosPerfil == "GESTOR DE USUARIOS"))
        {
            $PermisoOK = 1;
        }
        
        if ($PermisoOK == 1)
        {
            /* FLEXIGRID LISTA LOS SISTEMAS*/
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
            
            /* FLEXIGRID LISTA LOS PERFILES */
            $ScriptFLX2 = " AND pefmodulo = $CodigoM";
            if ((isset($_REQUEST['Accion'])) && (trim($_REQUEST['Accion']) == 'LoadJsonListPerfiles')) 
            {
                $lDato       = array();
                $oUPerfilDAO = new UsuarioPerfilDAO();
                $oPerfilDAO  = new PerfilDAO();
                if($_POST['query']<>'%')
                {
                    if(strlen(trim($_POST['query'])) > 0)
                    {
                        $lFiltro = " AND ".$_POST['qtype']." LIKE '%".$_POST['query']."%' ".$ScriptFLX2;
                    }
                    else
                    {
                        $lFiltro  = $ScriptFLX2;
                    }
                } 
                else
                {
                    $lFiltro  = $ScriptFLX2;
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
                GenerarDatosParaFlexigridSP1($oUPerfilDAO, 'ListaUsuarioPerfil',$nTotal, $_POST['page'],$lFiltro, $Codigo, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;
            }
            
            if ($Action == "AsignaPerfil")
            {
                $CargaAsignacion = 1;
                $tabs            = 1;
            }
            
            //PASO DE VARIABLES POR DEFECTO
            $DatosPersona       = "";
            
            //OBTENGO LOS DATOS DEL USUARIO
            $lParametroP                = array();
            $objUsuarioDAO              = new UsuarioDAO();
            $lParametroP['IdUsuario']    = $Codigo;
            $procedure_paramsP = array
            (
                  array(&$lParametroP['IdUsuario'], SQLSRV_PARAM_IN)
            );
            $lstUsuario       = array();
            $objUsuarioDAO->VerificaUsuarioSelect($lstUsuario,$procedure_paramsP);
            $listaPerfil  = count($lstUsuario) > 0 ? true : false;
            if (($listaPerfil == true) || ($listaPerfil > 0)) 
            {
                $Codigo                = $lstUsuario[0]->idusuario;
                $PerApePaterno         = $lstUsuario[0]->PerApePaterno;
                $PerApeMaterno         = $lstUsuario[0]->PerApeMaterno;
                $PerNombres            = $lstUsuario[0]->PerNombres;
                $DatosPersona          = $PerNombres." ".$PerApePaterno." ".$PerApeMaterno;
            }
            
            if (($Action == "EliminaUsuarioPerfil") || ($Action == "AsignaUsuarioPerfil"))
            {
                if ($Action == "AsignaUsuarioPerfil")
                {
                    $Tipo = 1;
                }
                else
                {
                    $Tipo = 2;
                }
                $lstUsuarioPf    = array();
                $objUsuarioPfDAO = new UsuarioPerfilDAO();
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                    = array();
                $lParametroS['IdUsuario']       = $Codigo;
                $lParametroS['IdPerfil']        = $CodigoP;
                $lParametroS['IdModulo']        = $CodigoM;
                $lParametroS['Tipo']            = $Tipo;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['IdUsuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['IdPerfil'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['IdModulo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Tipo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                
                $objUsuarioPfDAO->AgregaQuitaUsuarioPerfil($lstUsuarioPf, $procedure_paramsP);
                $mensaje = $procedure_paramsP[5][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Accion=muestraVista&AccionLocal=1&Mensaje=".$mensaje."&Cd=".$Codigo); 
                exit;
            }
            
            $lCollection->Add('DatosPersona', $DatosPersona);
            $lCollection->Add('CargaAsignacion', $CargaAsignacion);
            $lCollection->Add('Codigo', $Codigo);
            $lCollection->Add('CodigoM', $CodigoM);
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Tabs', $tabs);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);
        
    }
?>