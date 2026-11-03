<?php
    require_once(PATH_CONTROLADOR_DAO . "/FamiliaDAO.php");
    require_once(PATH_CONTROLADOR_DAO . "/UbigeoDAO.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(RECURSOSGEN_LIB . "/util.php");
    require_once(PATH_LIB . '/util.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        
        //OBTENGO LAS SESIONES
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}

        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Familia";
        $PermisoOK        = 0;
        
        $PermisosPerfil         = CallNomPerfil($perfilsession);
        //echo "<center>"; var_dump($PaginaFormulario, $usuario, $perfilsession, $PermisosPerfil); echo "</center>";
        
        if (($PermisosPerfil == "ADMINISTRADOR") || ($PermisosPerfil == "MACRO 1 - 8") || ($PermisosPerfil == "MACRO INVITADO") || ($PermisosPerfil == "MACRO 2") || ($PermisosPerfil == "MACRO 3") || ($PermisosPerfil == "MACRO 4") || ($PermisosPerfil == "MACRO 5") || ($PermisosPerfil == "MACRO 6") || ($PermisosPerfil == "MACRO 7") || ($PermisosPerfil == "MACRO 8") || ($PermisosPerfil == "MACRO 9"))
        {
            $PermisoOK = 1;
        }

        if ($PermisoOK == 1)
        {
            //ACCIONES PARA EL FORMULARIO
            $Action             = isset($_REQUEST['ActionForm'])? VerificarInputs($_REQUEST['ActionForm']) : "";
            $ActionFlex         = isset($_REQUEST['Accion'])? VerificarInputs($_REQUEST['Accion']) : "";
            //$CPerfil            = 54;
            $CPerfil            = 0;
            $Codigo             = isset($_REQUEST['Codigo'])? VerificarInputs($_REQUEST['Codigo']) : "";
            $Familia            = isset($_REQUEST['Familia'])? VerificarInputs($_REQUEST['Familia']) : "";
            $cboDepartamento    = isset($_REQUEST['cboDepartamento'])? VerificarInputs($_REQUEST['cboDepartamento']) : "";

            //echo "<center>"; var_dump($Action, $ActionFlex, $CPerfil, $Codigo, $cboDepartamento); echo "</center>";
            
            /* FLEXIGRID */
            $ScriptFLX = ""; //" AND P1.IdPerfil = $CPerfil ";

            if ($ActionFlex == "LoadJsonList")
            {
                $lDato      = array();
                $ogridDAO   = new FamiliaDAO();
                if($_POST['query']<>'%')
                {
                    if(strlen(VerificarInputs($_POST['query'])) > 0)
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
                $ogridDAO->CuentaFamilias($lDato, $procedure_paramsP);
                $nTotal = $lDato[0]->IDE_Familia;
                GenerarDatosParaFlexigridSP($ogridDAO, 'ListaFamiliaFlexigrid',$nTotal, $_POST['page'],$lFiltro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
                exit;
            }
            
            if ($Action == "RegistraDatos")
            {
                $lstPerfilM     = array();
                $objPerfilMDAO  = new FamiliaDAO();
                $lstParametrosM   = array();
                $lstParametrosM['Familia']           = $Familia;
                $lstParametrosM['Departamento']      = $cboDepartamento;
                $lstParametrosM['Usuario']           = $usuario;
                $lstParametrosM['PCODIGO']           = str_repeat("\0", 100);
                $lstParametrosM['PMENSAJE']          = str_repeat("\0", 200);
                $procedure_paramsMS = array(
                      array(&$lstParametrosM['Familia'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Departamento'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objPerfilMDAO->InsertaFamilia($lstPerfilM, $procedure_paramsMS);
                //var_dump($procedure_paramsMS); exit();
                $CodMensaje = $procedure_paramsMS[3][0];
                $mensaje    = $procedure_paramsMS[4][0];
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }
            
            if ($Action == "EliminaRegistro")
            {
                $lstPerfilM                     = array();
                $objPerfilMDAO                  = new FamiliaDAO();
                $lstParametrosM                 = array();
                $lstParametrosM['Codigo']       = $Codigo;
                $lstParametrosM['Usuario']      = $usuario;
                $lstParametrosM['PCODIGO']      = str_repeat("\0", 100);
                $lstParametrosM['PMENSAJE']     = str_repeat("\0", 200);
                $procedure_paramsMS = array(
                      array(&$lstParametrosM['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                $objPerfilMDAO->EliminaFamilia($lstPerfilM, $procedure_paramsMS);
                $CodMensaje = $procedure_paramsMS[2][0];
                $mensaje    = $procedure_paramsMS[3][0];
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }
            
            //$IdUbigeo = "";
            if ($Action == "ModificarRegistro")
            {
                $lstPerfilM       = array();
                $objPerfilMDAO    = new FamiliaDAO();
                $lstParametrosM   = array();
                $lstParametrosM['Codigo']       = $Codigo;
                $procedure_paramsMS = array(
                      array(&$lstParametrosM['Codigo'], SQLSRV_PARAM_IN)
                );
                $objPerfilMDAO->VerFamiliaSeleccionada($lstPerfilM, $procedure_paramsMS);
                $listaContador  = count($lstPerfilM) > 0 ? true : false;
                
                if (($listaContador == true) || ($listaContador > 0)) 
                {
                    $Codigo                         = $lstPerfilM[0]->IDE_Familia;
                    $Familia                        = $lstPerfilM[0]->Familia;
                    $IdUbigeo                       = $lstPerfilM[0]->IDE_UBIGEO;
                }

                $lCollection->Add('Codigo', $Codigo);
                $lCollection->Add('Familia', $Familia);
                $lCollection->Add('IdUbigeo', $IdUbigeo);
            }
            
            if ($Action == "ActualizarForm")
            {
                $lstPerfilM       = array();
                $objPerfilMDAO    = new FamiliaDAO();
                $lstParametrosM   = array();
                $lstParametrosM['Codigo']            = $Codigo;
                $lstParametrosM['Familia']           = $Familia;
                $lstParametrosM['Departamento']      = $cboDepartamento;
                $lstParametrosM['Usuario']           = $usuario;
                $lstParametrosM['PCODIGO']           = str_repeat("\0", 100);
                $lstParametrosM['PMENSAJE']          = str_repeat("\0", 200);
                $procedure_paramsMS = array(
                      array(&$lstParametrosM['Codigo'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Familia'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Departamento'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['Usuario'], SQLSRV_PARAM_IN)
                    , array(&$lstParametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                    , array(&$lstParametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
                );
                //var_dump($procedure_paramsMS);                exit();
                $objPerfilMDAO->ActualizaFamilia($lstPerfilM, $procedure_paramsMS);
                $CodMensaje = $procedure_paramsMS[4][0];
                $mensaje    = $procedure_paramsMS[5][0];
                $lCollection->Add('CodMensaje', $CodMensaje);
                $lCollection->Add('Mensaje', $mensaje);
            }
            
            //OBTENGO LOS DATOS DEL PERFIL
            $lstPerfil       = array();
            $objPerfilDAO    = new FamiliaDAO();
            $lstParametros     = array();
            $lstParametros['Codigo']       = $CPerfil;
            $procedure_paramsS = array(
                  array(&$lstParametros['Codigo'], SQLSRV_PARAM_IN)
            );
            
            $Familia = "";
            $objPerfilDAO->VerFamiliaSeleccionada($lstPerfil, $procedure_paramsS);
            $listaContador  = count($lstPerfil) > 0 ? true : false;
            if (($listaContador == true) || ($listaContador > 0)) 
            {
                $Familia       = $lstPerfil[0]->Familia;
            }
            
            //LISTADO DE DEPARTAMENTOS
            $lstDepartamento      = array();
            $objDepartamentoDAO   = new UbigeoDAO();
            $objDepartamentoDAO->SelectListDepartamento($lstDepartamento);
            
            //$lCollection->Add('CPerfil', $CPerfil);
            //$lCollection->Add('NombrePerfilR', $NombrePerfilR);
        
            $lCollection->Add('lstDepartamento', $lstDepartamento);
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);
        }
?>