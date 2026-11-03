<?php

    require_once(PATH_CONTROLADOR_DAO . "/PerfilDAO.php");   
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(PATH_LIB . '/util.php');
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "Acceso";
        $PermisoOK        = 0;
                
        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Tabs'])) {       $tabs = $_POST['Tabs'];} else { $tabs = 0;}
        if (!empty($_POST['Mensaje'])) {    $mensaje = $_POST['Mensaje'];} else { $mensaje = 0;}
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
        //OBTENGO LOS POST DEL FORMULARIO
        
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
            
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Tabs', $tabs);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);
        
    }
?>