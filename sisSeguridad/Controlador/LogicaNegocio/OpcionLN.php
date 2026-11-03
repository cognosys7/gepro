<?php

    require_once(PATH_CONTROLADOR_DAO . "/OpcionDAO.php");   
    require_once(PATH_CONTROLADOR_DAO . "/SistemaDAO.php");   
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Opcion";
        $PermisoOK        = 0;
                
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Tabs'])) {       $tabs = $_POST['Tabs'];} else { $tabs = 0;}
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTENGO LOS POST DEL FORMULARIO
        $Action                 = isset($_POST['ActionForm']) ? htmlspecialchars($_POST['ActionForm']) : "";
        $Codigo                 = isset($_POST['Codigo']) ? htmlspecialchars($_POST['Codigo']) : "";
        $tipoOpcion             = isset($_POST['tipoOpcion']) ? htmlspecialchars($_POST['tipoOpcion']) : "";
        $cboModulo              = isset($_POST['cboModulo']) ? htmlspecialchars($_POST['cboModulo']) : "";
        $cboOpcionPadre         = isset($_POST['cboOpcionPadre']) ? htmlspecialchars($_POST['cboOpcionPadre']) : "";
        $opcionNom              = isset($_POST['opcionNom']) ? htmlspecialchars($_POST['opcionNom']) : "";
        $enlace                 = isset($_POST['enlace']) ? htmlspecialchars($_POST['enlace']) : "";
        $destino                = isset($_POST['destino']) ? htmlspecialchars($_POST['destino']) : "";
        $lightbox               = isset($_POST['lightbox']) ? htmlspecialchars($_POST['lightbox']) : "";
        $ModuloOriginal         = isset($_POST['ModuloOriginal']) ? htmlspecialchars($_POST['ModuloOriginal']) : "";
        $TipoSubBaj             = isset($_POST['TipoSubBaj']) ? htmlspecialchars($_POST['TipoSubBaj']) : "";
        
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
                $oOpcionDAO  = new OpcionDAO();
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
                $oOpcionDAO->CuentaOpcion($lDato, $procedure_paramsP);
                $nTotal = $lDato[0]->idopcion;
                GenerarDatosParaFlexigridSP($oOpcionDAO, 'ListaOpciones',$nTotal, $_POST['page'],$lFiltro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;
            }
            
            if ((isset($_REQUEST["Accion"])) && (trim($_REQUEST["Accion"]) == "LoadOpcionesMainAjax")) 
            {
                $sCodigo            = $_GET['Id'];
                $TipOpc             = $_GET['TipOpc'];
                $lstOpcion          = GeneraMenus($sCodigo,1,0);
                $lCollection->Add('lstOpcionAjax',$lstOpcion);
                $lCollection->Add('TipOpc',$TipOpc);
            }
            
            //OBTENGO UN LISTADO DE LOS SISTEMAS Y MODULOS
            $lstSistemas      = array();
            $objSistemasDAO   = new SistemaDAO();
            $objSistemasDAO->ListaSistemasModulos($lstSistemas);

            if ($Action == "SubirBajar")
            {
                $lstOpcion      = array();
                $objOpcionDAO   = new OpcionDAO();

                $tabs = 0;
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                     = array();
                $lParametroS['IdOpcion']         = $Codigo;
                $lParametroS['TipoSubBaj']       = $TipoSubBaj;
                $lParametroS['Usuario']          = $usuario;
                $lParametroS['PCODIGO']          = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']         = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['IdOpcion'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['TipoSubBaj'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objOpcionDAO->SubirBajarOrdenOpcion($lstOpcion, $procedure_paramsP);
                $mensaje = $procedure_paramsP[3][0];
                
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }
            
            if ($Action == "RegistraOpcion")
            {
                $lstOpcion      = array();
                $objOpcionDAO   = new OpcionDAO();

                $tabs = 0;
                //PARAMETRO PARA REGISTRO DE SISTEMA
                $lParametroS                     = array();
                $lParametroS['opcdescripcion']   = $opcionNom;
                $lParametroS['opcmodulo']        = $cboModulo;
                $lParametroS['opcenlace']        = $enlace;
                $lParametroS['opcdestino']       = $destino;
                $lParametroS['opcnivel']         = $tipoOpcion;
                $lParametroS['opcpadre']         = $cboOpcionPadre;
                $lParametroS['opclightbox']      = $lightbox;
                $lParametroS['Usuario']          = $usuario;
                $lParametroS['PCODIGO']          = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']         = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['opcdescripcion'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcmodulo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcenlace'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcdestino'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcnivel'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcpadre'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opclightbox'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objOpcionDAO->InsertaOpcion($lstOpcion, $procedure_paramsP);
                $mensaje = $procedure_paramsP[8][0];
                
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ActualizaOpcion")
            {
                $lstOpcion      = array();
                $objOpcionDAO   = new OpcionDAO();
                //SE ACTUALIZA
                $tabs    = 0;
                //PARAMETRO PARA OPCION
                $lParametroS                    = array();
                $lParametroS['opcdescripcion']  = $opcionNom;
                $lParametroS['opcenlace']       = $enlace;
                $lParametroS['opcdestino']      = $destino;
                $lParametroS['opcnivel']        = $tipoOpcion;
                $lParametroS['opcpadre']        = $cboOpcionPadre;
                $lParametroS['opclightbox']     = $lightbox;
                $lParametroS['opcmodulo']       = $cboModulo;
                $lParametroS['opcmoduloOrig']   = $ModuloOriginal;
                $lParametroS['Codigo']          = $Codigo;
                $lParametroS['Usuario']         = $usuario;
                $lParametroS['PCODIGO']         = str_repeat("\0", 100);
                $lParametroS['PMENSAJE']        = str_repeat("\0", 200);
                $procedure_paramsP = array(
                      array(&$lParametroS['opcdescripcion'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcenlace'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcdestino'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcnivel'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcpadre'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opclightbox'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcmodulo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['opcmoduloOrig'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lParametroS['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lParametroS['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objOpcionDAO->ActualizaOpcion($lstOpcion, $procedure_paramsP);
                $mensaje = $procedure_paramsP[10][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }
            
            if ($Action == "EliminaOpcion")
            {
                $lstOpcion      = array();
                $objOpcionDAO   = new OpcionDAO();
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
                $objOpcionDAO->EliminaOpcion($lstOpcion, $procedure_paramsP);
                $mensaje = $procedure_paramsP[2][0];
                header("Location: AntiRefresh.php?Pagina=".$PaginaFormulario."&Mensaje=".$mensaje."&Tabs=".$tabs); 
                exit;
            }

            if ($Action == "ModificaOpcion")
            {
                $tabs           = 1;
                $opcdescripcion = "";
                $opcmodulo      = "";
                $opcenlace      = "";
                $opcdestino     = "";
                $opcnivel       = "";
                $opctipoenlace  = "";
                $opcpadre       = "";
                $opclightbox    = "";
                //INSTITUCION
                $lParametroP                = array();
                $objOpcionDAO               = new OpcionDAO();
                $lParametroP['IdOpcion']    = $Codigo;
                $procedure_paramsP = array
                (
                      array(&$lParametroP['IdOpcion'], SQLSRV_PARAM_IN)
                );
                $lstOpcion       = array();
                $objOpcionDAO->VerificaOpcionSeleccionado($lstOpcion,$procedure_paramsP);
                $listaOpcion  = count($lstOpcion) > 0 ? true : false;
                if (($listaOpcion == true) || ($listaOpcion > 0)) 
                {
                    $Codigo           = $lstOpcion[0]->idopcion;
                    $opcdescripcion   = $lstOpcion[0]->opcdescripcion;
                    $opcmodulo        = $lstOpcion[0]->opcmodulo;
                    $opcenlace        = $lstOpcion[0]->opcenlace;
                    $opcdestino       = $lstOpcion[0]->opcdestino;
                    $opcnivel         = $lstOpcion[0]->opcnivel;
                    $opctipoenlace    = $lstOpcion[0]->opctipoenlace;
                    $opcpadre         = $lstOpcion[0]->opcpadre;
                    $opclightbox      = $lstOpcion[0]->opclightbox;
                }
                $lCollection->Add('opcdescripcion', $opcdescripcion);
                $lCollection->Add('opcmodulo', $opcmodulo);
                $lCollection->Add('opcenlace', $opcenlace);
                $lCollection->Add('opcdestino', $opcdestino);
                $lCollection->Add('opcnivel', $opcnivel);
                $lCollection->Add('opctipoenlace', $opctipoenlace);
                $lCollection->Add('opcpadre', $opcpadre);
                $lCollection->Add('opclightbox', $opclightbox);
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