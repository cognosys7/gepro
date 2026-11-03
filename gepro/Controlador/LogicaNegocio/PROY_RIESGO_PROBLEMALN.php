<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_RIESGO_PROBLEMALN de la tabla PROY_RIESGO_PROBLEMA
  //  Fecha           : martes, 7 de noviembre de 2017 14:13:22
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_RIESGO_PROBLEMADAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PROYECTO_ACTIVIDADDAO.php");



require_once(PATH_CONTROLADOR_DAO . "/GEN_TIPO_RIESGODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_IMPACTO_RIESGODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_PROBABILIDAD_RIESGODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_PRIORIDAD_RIESGODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/GEN_INTERVENCIONlni.php");
/* EDGAR */



function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_RIESGO_PROBLEMA";
    $PermisoOK = 0;

    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}

    
    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
    if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
    if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
    if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}
	$PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);


    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";


        $PIDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) : "";
        $PIDE_PROYECTO = isset($_REQUEST['PIDE_PROYECTO']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO']) : "";


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) : "";
        $IDE_PROC_ITEM = isset($_REQUEST['IDE_PROC_ITEM']) ? VerificarInputs($_REQUEST['IDE_PROC_ITEM']) : "";
        $IDE_TIPO_RIESGO_PROB = isset($_REQUEST['IDE_TIPO_RIESGO_PROB']) ? VerificarInputs($_REQUEST['IDE_TIPO_RIESGO_PROB']) : "";
        $TIP_RIESGO_PROB = isset($_REQUEST['TIP_RIESGO_PROB']) ? VerificarInputs($_REQUEST['TIP_RIESGO_PROB']) : "";
        $DES_NOMBRE = isset($_REQUEST['DES_NOMBRE']) ? VerificarInputs($_REQUEST['DES_NOMBRE']) : "";
        $DES_DETALLE = isset($_REQUEST['DES_DETALLE']) ? VerificarInputs($_REQUEST['DES_DETALLE']) : "";
        $IDE_IMPACTO = isset($_REQUEST['IDE_IMPACTO']) ? VerificarInputs($_REQUEST['IDE_IMPACTO']) : "";
        $IDE_PROBABILIDAD = isset($_REQUEST['IDE_PROBABILIDAD']) ? VerificarInputs($_REQUEST['IDE_PROBABILIDAD']) : "";
        $IDE_PRIORIDAD = isset($_REQUEST['IDE_PRIORIDAD']) ? VerificarInputs($_REQUEST['IDE_PRIORIDAD']) : "";
        $DES_CAUSA_PROBLEMA = isset($_REQUEST['DES_CAUSA_PROBLEMA']) ? VerificarInputs($_REQUEST['DES_CAUSA_PROBLEMA']) : "";
        $DES_CONSECUENCIA_RIESGO = isset($_REQUEST['DES_CONSECUENCIA_RIESGO']) ? VerificarInputs($_REQUEST['DES_CONSECUENCIA_RIESGO']) : "";
        $DES_SOLUCION = isset($_REQUEST['DES_SOLUCION']) ? VerificarInputs($_REQUEST['DES_SOLUCION']) : "";
        $FEC_INICIO_SOLUCION = isset($_REQUEST['FEC_INICIO_SOLUCION']) ? VerificarInputs($_REQUEST['FEC_INICIO_SOLUCION']) : "";
        $FEC_TERMINO_SOLUCION = isset($_REQUEST['FEC_TERMINO_SOLUCION']) ? VerificarInputs($_REQUEST['FEC_TERMINO_SOLUCION']) : "";
        $EST_RIESGO = isset($_REQUEST['EST_RIESGO']) ? VerificarInputs($_REQUEST['EST_RIESGO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND R.IDE_PROYECTO_ACTIVIDAD=$PIDE_PROYECTO_ACTIVIDAD";
        $DataSet_PROYECTO_ACTIVIDAD_1 = array();
        $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD_EJECUTORA, SEC_EJEC, DES_ENTIDAD, COD_PROYECTO, DES_PROYECTO, DES_PROYECTO_ITEM, IMP_COSTO_ACTUAL";
        $lstparametrosM['filtro'] = " AND IDE_PROYECTO_ACTIVIDAD = '$PIDE_PROYECTO_ACTIVIDAD'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO->SelCampos_PROYECTO_ACTIVIDAD2($DataSet_PROYECTO_ACTIVIDAD_1, $procedure_parametrosMS);
        
        $VIDE_ENTIDAD_EJECUTORA = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IDE_ENTIDAD_EJECUTORA;
        $lCollection->Add('VIDE_ENTIDAD_EJECUTORA', $VIDE_ENTIDAD_EJECUTORA);         
        $VSEC_EJEC = $DataSet_PROYECTO_ACTIVIDAD_1[0]->SEC_EJEC;
        $lCollection->Add('VSEC_EJEC', $VSEC_EJEC);        
        $VDES_ENTIDAD = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_ENTIDAD;
        $lCollection->Add('VDES_ENTIDAD', $VDES_ENTIDAD);                
        $VCOD_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD_1[0]->COD_PROYECTO;
        $lCollection->Add('VCOD_PROYECTO', $VCOD_PROYECTO);
        $VDES_PROYECTO_ITEM = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_PROYECTO_ITEM;
        $lCollection->Add('VDES_PROYECTO_ITEM', $VDES_PROYECTO_ITEM);
        $VDES_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_PROYECTO;
        $lCollection->Add('VDES_PROYECTO', $VDES_PROYECTO);
        $VIMP_COSTO_ACTUAL = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IMP_COSTO_ACTUAL;
        $lCollection->Add('VIMP_COSTO_ACTUAL', $VIMP_COSTO_ACTUAL);



            
        $Data3 = ProyectoContrato_Datos2($PIDE_PROYECTO_ACTIVIDAD,$PIDE_PROYECTO);
        $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
//        
        $Data4 = ProyectoActividad_Datos($PIDE_PROYECTO_ACTIVIDAD);
        $lCollection->Add('VIDE_INTERVENCION', $Data4['IDE_INTERVENCION'] ) ;
            

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_RIESGO_PROBLEMA_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'ID') {
                        $_POST['qtype'] = 'R.IDE_RIESGO_PROB';
                    }
                    if ($_POST['qtype'] == 'COD_PROYECTO') {
                        $_POST['qtype'] = 'P.COD_PROYECTO';
                    }
                    if ($_POST['qtype'] == 'PROYECTO') {
                        $_POST['qtype'] = 'P.DES_PROYECTO_ITEM';
                    }
                    if ($_POST['qtype'] == 'TIPO_RIESGO') {
                        $_POST['qtype'] = 'TR.DES_TIPO_RIESGO';
                    }
                    if ($_POST['qtype'] == 'RIESGO_PROBLEMA') {
                        $_POST['qtype'] = 'RP.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'NOMBRE') {
                        $_POST['qtype'] = 'R.DES_NOMBRE';
                    }
                    if ($_POST['qtype'] == 'ESTADO_RIESGO') {
                        $_POST['qtype'] = 'ER.DES_ITEM';
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
            $ogridDAO->Count_PROY_RIESGO_PROBLEMA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_RIESGO_PROB;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_RIESGO_PROBLEMA', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_INICIO_SOLUCION) > 0) {
                $FEC_INICIO_SOLUCION = cambiafecha($FEC_INICIO_SOLUCION);
            } else {
                $FEC_INICIO_SOLUCION = "";
            }
            if (strlen($FEC_TERMINO_SOLUCION) > 0) {
                $FEC_TERMINO_SOLUCION = cambiafecha($FEC_TERMINO_SOLUCION);
            } else {
                $FEC_TERMINO_SOLUCION = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_RIESGO_PROBLEMAM = array();
            $Objeto_PROY_RIESGO_PROBLEMA_DAO = new PROY_RIESGO_PROBLEMA_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($IDE_TIPO_RIESGO_PROB)) > 0) {
                $lstparametrosM['IDE_TIPO_RIESGO_PROB'] = $IDE_TIPO_RIESGO_PROB;
            }
            if (strlen(rtrim($TIP_RIESGO_PROB)) > 0) {
                $lstparametrosM['TIP_RIESGO_PROB'] = $TIP_RIESGO_PROB;
            }
            if (strlen(rtrim($DES_NOMBRE)) > 0) {
                $lstparametrosM['DES_NOMBRE'] = $DES_NOMBRE;
            }
            if (strlen(rtrim($DES_DETALLE)) > 0) {
                $lstparametrosM['DES_DETALLE'] = $DES_DETALLE;
            }
            if (strlen(rtrim($IDE_IMPACTO)) > 0) {
                $lstparametrosM['IDE_IMPACTO'] = $IDE_IMPACTO;
            }
            if (strlen(rtrim($IDE_PROBABILIDAD)) > 0) {
                $lstparametrosM['IDE_PROBABILIDAD'] = $IDE_PROBABILIDAD;
            }
            if (strlen(rtrim($IDE_PRIORIDAD)) > 0) {
                $lstparametrosM['IDE_PRIORIDAD'] = $IDE_PRIORIDAD;
            }
            if (strlen(rtrim($DES_CAUSA_PROBLEMA)) > 0) {
                $lstparametrosM['DES_CAUSA_PROBLEMA'] = $DES_CAUSA_PROBLEMA;
            }
            if (strlen(rtrim($DES_CONSECUENCIA_RIESGO)) > 0) {
                $lstparametrosM['DES_CONSECUENCIA_RIESGO'] = $DES_CONSECUENCIA_RIESGO;
            }
            if (strlen(rtrim($DES_SOLUCION)) > 0) {
                $lstparametrosM['DES_SOLUCION'] = $DES_SOLUCION;
            }
            if (strlen(rtrim($FEC_INICIO_SOLUCION)) > 0) {
                $lstparametrosM['FEC_INICIO_SOLUCION'] = $FEC_INICIO_SOLUCION;
            }
            if (strlen(rtrim($FEC_TERMINO_SOLUCION)) > 0) {
                $lstparametrosM['FEC_TERMINO_SOLUCION'] = $FEC_TERMINO_SOLUCION;
            }
            if (strlen(rtrim($EST_RIESGO)) > 0) {
                $lstparametrosM['EST_RIESGO'] = $EST_RIESGO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_TIPO_RIESGO_PROB'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_RIESGO_PROB'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_NOMBRE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DETALLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_IMPACTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROBABILIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PRIORIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CAUSA_PROBLEMA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CONSECUENCIA_RIESGO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SOLUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO_SOLUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO_SOLUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_RIESGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_RIESGO_PROBLEMA_DAO->Insert_PROY_RIESGO_PROBLEMA($DataSet_PROY_RIESGO_PROBLEMA, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[16][0];

            $mensaje = $procedure_parametrosMS[17][0];

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
            $DataSet_PROY_RIESGO_PROBLEMA = array();
            $Objeto_PROY_RIESGO_PROBLEMA_DAO = new PROY_RIESGO_PROBLEMA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_RIESGO_PROBLEMA_DAO->SelPk_PROY_RIESGO_PROBLEMA($DataSet_PROY_RIESGO_PROBLEMA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_RIESGO_PROBLEMA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_RIESGO_PROBLEMA

                $IDE_PROYECTO_ACTIVIDAD = $DataSet_PROY_RIESGO_PROBLEMA[0]->IDE_PROYECTO_ACTIVIDAD;
                $IDE_PROC_ITEM = $DataSet_PROY_RIESGO_PROBLEMA[0]->IDE_PROC_ITEM;
                $IDE_TIPO_RIESGO_PROB = $DataSet_PROY_RIESGO_PROBLEMA[0]->IDE_TIPO_RIESGO_PROB;
                $TIP_RIESGO_PROB = $DataSet_PROY_RIESGO_PROBLEMA[0]->TIP_RIESGO_PROB;
                $DES_NOMBRE = $DataSet_PROY_RIESGO_PROBLEMA[0]->DES_NOMBRE;
                $DES_DETALLE = $DataSet_PROY_RIESGO_PROBLEMA[0]->DES_DETALLE;
                $IDE_IMPACTO = $DataSet_PROY_RIESGO_PROBLEMA[0]->IDE_IMPACTO;
                $IDE_PROBABILIDAD = $DataSet_PROY_RIESGO_PROBLEMA[0]->IDE_PROBABILIDAD;
                $IDE_PRIORIDAD = $DataSet_PROY_RIESGO_PROBLEMA[0]->IDE_PRIORIDAD;
                $DES_CAUSA_PROBLEMA = $DataSet_PROY_RIESGO_PROBLEMA[0]->DES_CAUSA_PROBLEMA;
                $DES_CONSECUENCIA_RIESGO = $DataSet_PROY_RIESGO_PROBLEMA[0]->DES_CONSECUENCIA_RIESGO;
                $DES_SOLUCION = $DataSet_PROY_RIESGO_PROBLEMA[0]->DES_SOLUCION;
                $FEC_INICIO_SOLUCION = $DataSet_PROY_RIESGO_PROBLEMA[0]->FEC_INICIO_SOLUCION;
                $FEC_TERMINO_SOLUCION = $DataSet_PROY_RIESGO_PROBLEMA[0]->FEC_TERMINO_SOLUCION;
                $EST_RIESGO = $DataSet_PROY_RIESGO_PROBLEMA[0]->EST_RIESGO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO_ACTIVIDAD', $IDE_PROYECTO_ACTIVIDAD);
            $lCollection->Add('IDE_PROC_ITEM', $IDE_PROC_ITEM);
            $lCollection->Add('IDE_TIPO_RIESGO_PROB', $IDE_TIPO_RIESGO_PROB);
            $lCollection->Add('TIP_RIESGO_PROB', $TIP_RIESGO_PROB);
            $lCollection->Add('DES_NOMBRE', $DES_NOMBRE);
            $lCollection->Add('DES_DETALLE', $DES_DETALLE);
            $lCollection->Add('IDE_IMPACTO', $IDE_IMPACTO);
            $lCollection->Add('IDE_PROBABILIDAD', $IDE_PROBABILIDAD);
            $lCollection->Add('IDE_PRIORIDAD', $IDE_PRIORIDAD);
            $lCollection->Add('DES_CAUSA_PROBLEMA', $DES_CAUSA_PROBLEMA);
            $lCollection->Add('DES_CONSECUENCIA_RIESGO', $DES_CONSECUENCIA_RIESGO);
            $lCollection->Add('DES_SOLUCION', $DES_SOLUCION);
            $lCollection->Add('FEC_INICIO_SOLUCION', $FEC_INICIO_SOLUCION);
            $lCollection->Add('FEC_TERMINO_SOLUCION', $FEC_TERMINO_SOLUCION);
            $lCollection->Add('EST_RIESGO', $EST_RIESGO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_INICIO_SOLUCION) > 0) {
                $FEC_INICIO_SOLUCION = cambiafecha($FEC_INICIO_SOLUCION);
            } else {
                $FEC_INICIO_SOLUCION = "";
            }
            if (strlen($FEC_TERMINO_SOLUCION) > 0) {
                $FEC_TERMINO_SOLUCION = cambiafecha($FEC_TERMINO_SOLUCION);
            } else {
                $FEC_TERMINO_SOLUCION = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_RIESGO_PROBLEMA = array();
            $Objeto_PROY_RIESGO_PROBLEMA_DAO = new PROY_RIESGO_PROBLEMA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($IDE_TIPO_RIESGO_PROB)) > 0) {
                $lstparametrosM['IDE_TIPO_RIESGO_PROB'] = $IDE_TIPO_RIESGO_PROB;
            }
            if (strlen(rtrim($TIP_RIESGO_PROB)) > 0) {
                $lstparametrosM['TIP_RIESGO_PROB'] = $TIP_RIESGO_PROB;
            }
            if (strlen(rtrim($DES_NOMBRE)) > 0) {
                $lstparametrosM['DES_NOMBRE'] = $DES_NOMBRE;
            }
            if (strlen(rtrim($DES_DETALLE)) > 0) {
                $lstparametrosM['DES_DETALLE'] = $DES_DETALLE;
            }
            if (strlen(rtrim($IDE_IMPACTO)) > 0) {
                $lstparametrosM['IDE_IMPACTO'] = $IDE_IMPACTO;
            }
            if (strlen(rtrim($IDE_PROBABILIDAD)) > 0) {
                $lstparametrosM['IDE_PROBABILIDAD'] = $IDE_PROBABILIDAD;
            }
            if (strlen(rtrim($IDE_PRIORIDAD)) > 0) {
                $lstparametrosM['IDE_PRIORIDAD'] = $IDE_PRIORIDAD;
            }
            if (strlen(rtrim($DES_CAUSA_PROBLEMA)) > 0) {
                $lstparametrosM['DES_CAUSA_PROBLEMA'] = $DES_CAUSA_PROBLEMA;
            }
            if (strlen(rtrim($DES_CONSECUENCIA_RIESGO)) > 0) {
                $lstparametrosM['DES_CONSECUENCIA_RIESGO'] = $DES_CONSECUENCIA_RIESGO;
            }
            if (strlen(rtrim($DES_SOLUCION)) > 0) {
                $lstparametrosM['DES_SOLUCION'] = $DES_SOLUCION;
            }
            if (strlen(rtrim($FEC_INICIO_SOLUCION)) > 0) {
                $lstparametrosM['FEC_INICIO_SOLUCION'] = $FEC_INICIO_SOLUCION;
            }
            if (strlen(rtrim($FEC_TERMINO_SOLUCION)) > 0) {
                $lstparametrosM['FEC_TERMINO_SOLUCION'] = $FEC_TERMINO_SOLUCION;
            }
            if (strlen(rtrim($EST_RIESGO)) > 0) {
                $lstparametrosM['EST_RIESGO'] = $EST_RIESGO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_TIPO_RIESGO_PROB'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_RIESGO_PROB'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_NOMBRE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DETALLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_IMPACTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROBABILIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PRIORIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CAUSA_PROBLEMA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CONSECUENCIA_RIESGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SOLUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO_SOLUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO_SOLUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_RIESGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_RIESGO_PROBLEMA_DAO->Update_PROY_RIESGO_PROBLEMA($DataSet_PROY_RIESGO_PROBLEMA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[17][0];

            $mensaje = $procedure_parametrosMS[18][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_RIESGO_PROBLEMA = array();
            $Objeto_PROY_RIESGO_PROBLEMA_DAO = new PROY_RIESGO_PROBLEMA_DAO();
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
            $Objeto_PROY_RIESGO_PROBLEMA_DAO->Delete_PROY_RIESGO_PROBLEMA($DataSet_PROY_RIESGO_PROBLEMA, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TIPO_RIESGO_1 = array();
        $Objeto_IDE_TIPO_RIESGO_PROB_DAO = new GEN_TIPO_RIESGO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_TIPO_RIESGO,DES_TIPO_RIESGO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_TIPO_RIESGO_PROB_DAO->SelCampos_GEN_TIPO_RIESGO($DataSet_GEN_TIPO_RIESGO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TIPO_RIESGO_1', $DataSet_GEN_TIPO_RIESGO_1);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_RIESGO_PROB_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '85'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_RIESGO_PROB_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_IMPACTO_RIESGO_1 = array();
        $Objeto_IDE_IMPACTO_DAO = new GEN_IMPACTO_RIESGO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_IMPACTO,DES_IMPACTO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_IMPACTO_DAO->SelCampos_GEN_IMPACTO_RIESGO($DataSet_GEN_IMPACTO_RIESGO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_IMPACTO_RIESGO_1', $DataSet_GEN_IMPACTO_RIESGO_1);

        /* 					 */

        $DataSet_GEN_PROBABILIDAD_RIESGO_1 = array();
        $Objeto_IDE_PROBABILIDAD_DAO = new GEN_PROBABILIDAD_RIESGO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PROBABILIDAD,DES_PROBABILIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PROBABILIDAD_DAO->SelCampos_GEN_PROBABILIDAD_RIESGO($DataSet_GEN_PROBABILIDAD_RIESGO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_PROBABILIDAD_RIESGO_1', $DataSet_GEN_PROBABILIDAD_RIESGO_1);

        /* 					 */

        $DataSet_GEN_PRIORIDAD_RIESGO_1 = array();
        $Objeto_IDE_PRIORIDAD_DAO = new GEN_PRIORIDAD_RIESGO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PRIORIDAD,DES_PRIORIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PRIORIDAD_DAO->SelCampos_GEN_PRIORIDAD_RIESGO($DataSet_GEN_PRIORIDAD_RIESGO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_PRIORIDAD_RIESGO_1', $DataSet_GEN_PRIORIDAD_RIESGO_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_RIESGO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '4'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_RIESGO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */



        $lCollection->Add('PIDE_PROYECTO_ACTIVIDAD', $PIDE_PROYECTO_ACTIVIDAD);
        $lCollection->Add('PIDE_PROYECTO', $PIDE_PROYECTO);
        
    /* EDGAR */
	$lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    /* EDGAR */


    }
}

//var_dump($lstDepartamento);exit;