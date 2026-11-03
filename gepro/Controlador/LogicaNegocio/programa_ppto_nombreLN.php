<?php

/* * ******************************************************************************
  //  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA      
  //  Propósito       : programa_ppto_nombreLN de la tabla programa_ppto_nombre
  //  Fecha           : miércoles, 01 de noviembre de 2017 08:56:06 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/programa_ppto_nombreDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */




    function EjecutaLN() 
    {
        ValidaSession();
        $lCollection = Collection::Singleton();
        
        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "programa_ppto_nombre";
        $PermisoOK        = 0;

/***EDGAR---**************/    
    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}
    
    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
    if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
    if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
    if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}	
    $PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);// echo $PermisosPerfil; die;
/***EDGAR---**************/ 

        
        if ($PermisoOK == 1)       
        {

        /*******************************************************************
        *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
        /*******************************************************************/        
        //ACCIONES PARA EL FORMULARIO
        $Action     = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";        
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";
        $PIDE= isset($_REQUEST['PIDE'])? VerificarInputs($_REQUEST['PIDE']) : "";
        
        $ScriptFLX = ""; 

        /*******************************************************************
        *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
        /*******************************************************************/
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new programa_ppto_nombre_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {

                    if ($_POST['qtype'] == 'ID') {
                        $_POST['qtype'] = 'PROGRAMA_PPTO';
                    }
                    if ($_POST['qtype'] == 'DefinicionProgramaPTTO') {
                        $_POST['qtype'] = 'NOMBRE';
                    }
                    

                    $lparametro = " AND " . $_POST['qtype'] . " LIKE '%" . $_POST['query'] . "%' " . $ScriptFLX;
                } else {
                    $lparametro = $ScriptFLX;
                }
            } else {
                $lparametro = $ScriptFLX;
            }
            $lparametroP = array();
            $lparametroP['Script'] = $lparametro;
            $procedure_parametrosP = array(
                array(&$lparametroP['Script'], SQLSRV_PARAM_IN)
            ); 
            $ogridDAO->Count_programa_ppto_nombre($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->PROGRAMA_PPTO;

            $lCollection->Add('nTotal', $nTotal);
           // echo $nTotal; die;
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_programa_ppto_nombre', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        
        if ($Action == "PasarDatos") {
            
            $DataSet_programa_ppto_nombre = array();
            $Objeto_programa_ppto_nombre_DAO = new programa_ppto_nombre_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = " ANO_EJE, PROGRAMA_PPTO, NOMBRE ";
            $lstparametrosM['filtro'] = " AND PROGRAMA_PPTO='".$PIDE."'";            
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            
            $PANO_EJE = $POMPONENTE = $PNOMBRE = "" ;
            $Objeto_programa_ppto_nombre_DAO->SelCampos_programa_ppto_nombre($DataSet_programa_ppto_nombre, $procedure_parametrosMS);            
            $listaContador = count($DataSet_programa_ppto_nombre) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                $PANO_EJE = $DataSet_programa_ppto_nombre[0]->ANO_EJE;
                $PPROGRAMA_PPTO = $DataSet_programa_ppto_nombre[0]->PROGRAMA_PPTO;
                $PNOMBRE = $DataSet_programa_ppto_nombre[0]->NOMBRE;
            }
            $lCollection->Add('PANO_EJE', $PANO_EJE);
            $lCollection->Add('PPROGRAMA_PPTO', $PPROGRAMA_PPTO);
            $lCollection->Add('PNOMBRE', $PNOMBRE);     
            
        }
        
        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);
    }
}

//var_dump($lstDepartamento);exit;