<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : PLAN_SOLPROY_SEGUIMIENTOLN de la tabla PLAN_SOLPROY_SEGUIMIENTO
  //  Fecha           : jueves, 05 de julio de 2018 10:46:13 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLAN_SOLPROY_SEGUIMIENTODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */

/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION ****/
require_once("include/PLAN_SOLPROY_SEGUIMIENTOLNI.php");
/***EDGAR---**************/

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PLAN_SOLPROY_SEGUIMIENTO";
    $PermisoOK = 0;


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
    

    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";


/***EDGAR---******************/
        $PIDE= isset($_REQUEST['PIDE'])? VerificarInputs($_REQUEST['PIDE']) : "";
/***EDGAR---******************/

  
        
        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_SOLICITUD_PROYECTO = isset($_REQUEST['IDE_SOLICITUD_PROYECTO']) ? VerificarInputs($_REQUEST['IDE_SOLICITUD_PROYECTO']) : "";
        $IDE_PLAN_RECURSO = isset($_REQUEST['IDE_PLAN_RECURSO']) ? VerificarInputs($_REQUEST['IDE_PLAN_RECURSO']) : "";
        $TIP_ROL = isset($_REQUEST['TIP_ROL']) ? VerificarInputs($_REQUEST['TIP_ROL']) : "";
        $EST_SEGUIMIENTO = isset($_REQUEST['EST_SEGUIMIENTO']) ? VerificarInputs($_REQUEST['EST_SEGUIMIENTO']) : "";
        $FEC_SEGUIMIENTO = isset($_REQUEST['FEC_SEGUIMIENTO']) ? VerificarInputs($_REQUEST['FEC_SEGUIMIENTO']) : "";
        $DES_SEGUIMIENTO = isset($_REQUEST['DES_SEGUIMIENTO']) ? VerificarInputs($_REQUEST['DES_SEGUIMIENTO']) : "";
        $EST_SOLPROY_SEG = isset($_REQUEST['EST_SOLPROY_SEG']) ? VerificarInputs($_REQUEST['EST_SOLPROY_SEG']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        
/***EDGAR---************** DEFINE DATOS DEL PLAN_INTERVENCION ****/
        $ScriptFLX = " AND T.IDE_SOLICITUD_PROYECTO=".$PIDE ; //echo $ScriptFLX;
        $IDE_SOLICITUD_PROYECTO = $PIDE;
        
        $data = PlanSolicitudProyecto_Datos ($PIDE);
        $VIDE_PIP = $data['IDE_PIP'] ;
        
        $data = PIP_Datos( $VIDE_PIP );
        $lCollection->Add('VCOD_UNICO', $data['COD_PROYECTO']);
        $lCollection->Add('VDES_PIP', $data['DES_PIP']);
/***EDGAR---**************/

 
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PLAN_SOLPROY_SEGUIMIENTO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'Seguimiento_Tipo') {
                        $_POST['qtype'] = 'TT3.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'Seguimiento_Evaluador') {
                        $_POST['qtype'] = 'RRHH.DES_PERSONA';
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
            $ogridDAO->Count_PLAN_SOLPROY_SEGUIMIENTO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_SOLPROY_SEG;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PLAN_SOLPROY_SEGUIMIENTO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_SEGUIMIENTO) > 0) {
                $FEC_SEGUIMIENTO = cambiafecha($FEC_SEGUIMIENTO);
            } else {
                $FEC_SEGUIMIENTO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PLAN_SOLPROY_SEGUIMIENTOM = array();
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO = new PLAN_SOLPROY_SEGUIMIENTO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_SOLICITUD_PROYECTO)) > 0) {
                $lstparametrosM['IDE_SOLICITUD_PROYECTO'] = $IDE_SOLICITUD_PROYECTO;
            }
            if (strlen(rtrim($IDE_PLAN_RECURSO)) > 0) {
                $lstparametrosM['IDE_PLAN_RECURSO'] = $IDE_PLAN_RECURSO;
            }
            if (strlen(rtrim($TIP_ROL)) > 0) {
                $lstparametrosM['TIP_ROL'] = $TIP_ROL;
            }
            if (strlen(rtrim($EST_SEGUIMIENTO)) > 0) {
                $lstparametrosM['EST_SEGUIMIENTO'] = $EST_SEGUIMIENTO;
            }
            if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0) {
                $lstparametrosM['FEC_SEGUIMIENTO'] = $FEC_SEGUIMIENTO;
            }
            if (strlen(rtrim($DES_SEGUIMIENTO)) > 0) {
                $lstparametrosM['DES_SEGUIMIENTO'] = $DES_SEGUIMIENTO;
            }
            if (strlen(rtrim($EST_SOLPROY_SEG)) > 0) {
                $lstparametrosM['EST_SOLPROY_SEG'] = $EST_SOLPROY_SEG;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_SOLICITUD_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PLAN_RECURSO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_ROL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_SEGUIMIENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_SEGUIMIENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SEGUIMIENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_SOLPROY_SEG'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO->Insert_PLAN_SOLPROY_SEGUIMIENTO($DataSet_PLAN_SOLPROY_SEGUIMIENTO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[8][0];

            $mensaje = $procedure_parametrosMS[9][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *  METODO MOSTRAR DATOS DE UN REGISTRO EXISTENTE EN EL FORMULARIO
          /****************************************************************** */
        //
        //LIMPIANDO LAS VARIABLES DE RECUPERACION DE DATOS        
        //$LfIdProveedor= NULL; //Habilitar cuando la tabla depende de otra superior            
        if ($Action == "ModificarRegistro") {
            //var_dump($SeleccionarID); 
            $DataSet_PLAN_SOLPROY_SEGUIMIENTO = array();
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO = new PLAN_SOLPROY_SEGUIMIENTO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO->SelPk_PLAN_SOLPROY_SEGUIMIENTO($DataSet_PLAN_SOLPROY_SEGUIMIENTO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PLAN_SOLPROY_SEGUIMIENTO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PLAN_SOLPROY_SEGUIMIENTO

                $IDE_SOLICITUD_PROYECTO = $DataSet_PLAN_SOLPROY_SEGUIMIENTO[0]->IDE_SOLICITUD_PROYECTO;
                $IDE_PLAN_RECURSO = $DataSet_PLAN_SOLPROY_SEGUIMIENTO[0]->IDE_PLAN_RECURSO;
                $TIP_ROL = $DataSet_PLAN_SOLPROY_SEGUIMIENTO[0]->TIP_ROL;
                $EST_SEGUIMIENTO = $DataSet_PLAN_SOLPROY_SEGUIMIENTO[0]->EST_SEGUIMIENTO;
                $FEC_SEGUIMIENTO = $DataSet_PLAN_SOLPROY_SEGUIMIENTO[0]->FEC_SEGUIMIENTO;
                $DES_SEGUIMIENTO = $DataSet_PLAN_SOLPROY_SEGUIMIENTO[0]->DES_SEGUIMIENTO;
                $EST_SOLPROY_SEG = $DataSet_PLAN_SOLPROY_SEGUIMIENTO[0]->EST_SOLPROY_SEG;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_SOLICITUD_PROYECTO', $IDE_SOLICITUD_PROYECTO);
            $lCollection->Add('IDE_PLAN_RECURSO', $IDE_PLAN_RECURSO);
            $lCollection->Add('TIP_ROL', $TIP_ROL);
            $lCollection->Add('EST_SEGUIMIENTO', $EST_SEGUIMIENTO);
            $lCollection->Add('FEC_SEGUIMIENTO', $FEC_SEGUIMIENTO);
            $lCollection->Add('DES_SEGUIMIENTO', $DES_SEGUIMIENTO);
            $lCollection->Add('EST_SOLPROY_SEG', $EST_SOLPROY_SEG);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_SEGUIMIENTO) > 0) {
                $FEC_SEGUIMIENTO = cambiafecha($FEC_SEGUIMIENTO);
            } else {
                $FEC_SEGUIMIENTO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PLAN_SOLPROY_SEGUIMIENTO = array();
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO = new PLAN_SOLPROY_SEGUIMIENTO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_SOLICITUD_PROYECTO)) > 0) {
                $lstparametrosM['IDE_SOLICITUD_PROYECTO'] = $IDE_SOLICITUD_PROYECTO;
            }
            if (strlen(rtrim($IDE_PLAN_RECURSO)) > 0) {
                $lstparametrosM['IDE_PLAN_RECURSO'] = $IDE_PLAN_RECURSO;
            }
            if (strlen(rtrim($TIP_ROL)) > 0) {
                $lstparametrosM['TIP_ROL'] = $TIP_ROL;
            }
            if (strlen(rtrim($EST_SEGUIMIENTO)) > 0) {
                $lstparametrosM['EST_SEGUIMIENTO'] = $EST_SEGUIMIENTO;
            }
            if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0) {
                $lstparametrosM['FEC_SEGUIMIENTO'] = $FEC_SEGUIMIENTO;
            }
            if (strlen(rtrim($DES_SEGUIMIENTO)) > 0) {
                $lstparametrosM['DES_SEGUIMIENTO'] = $DES_SEGUIMIENTO;
            }
            if (strlen(rtrim($EST_SOLPROY_SEG)) > 0) {
                $lstparametrosM['EST_SOLPROY_SEG'] = $EST_SOLPROY_SEG;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_SOLICITUD_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PLAN_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_ROL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_SOLPROY_SEG'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO->Update_PLAN_SOLPROY_SEGUIMIENTO($DataSet_PLAN_SOLPROY_SEGUIMIENTO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[9][0];

            $mensaje = $procedure_parametrosMS[10][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PLAN_SOLPROY_SEGUIMIENTO = array();
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO = new PLAN_SOLPROY_SEGUIMIENTO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_SOLPROY_SEGUIMIENTO_DAO->Delete_PLAN_SOLPROY_SEGUIMIENTO($DataSet_PLAN_SOLPROY_SEGUIMIENTO, $procedure_parametrosMS); //JCMY
            $CodMensaje = $procedure_parametrosMS[2][0];
            $mensaje = $procedure_parametrosMS[3][0];
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);



        /*         * ******************************************************************************
         *          SECCION DE CODIGO PARA LAS LISTAS DEPLEGABLES O COMBOS
          /****************************************************************************** */


        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
/***EDGAR---******************/        
        $lCollection->Add('PIDE', $PIDE);
 /***EDGAR---******************/
        
    }
}

//var_dump($lstDepartamento);exit;