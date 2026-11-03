<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROC_ITEMLN de la tabla PROC_ITEM
  //  Fecha           : jueves, 02 de noviembre de 2017 10:33:22 a.m.
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROC_ITEMDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROCESODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_MODO_EJECUCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROC_UNIDAD_MEDIDADAO.php");



/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROC_ITEM";
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
        $Proceso = isset($_REQUEST['Proceso'])? VerificarInputs($_REQUEST['Proceso']) : "";
//        $Proceso = 384225 ;

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_CONVOCATORIA = isset($_REQUEST['IDE_CONVOCATORIA']) ? VerificarInputs($_REQUEST['IDE_CONVOCATORIA']) : "";
        $COD_ITEM = isset($_REQUEST['COD_ITEM']) ? VerificarInputs($_REQUEST['COD_ITEM']) : "";
        $COD_PROYECTO = isset($_REQUEST['COD_PROYECTO']) ? VerificarInputs($_REQUEST['COD_PROYECTO']) : "";
        $DES_DEPTO_ITEM = isset($_REQUEST['DES_DEPTO_ITEM']) ? VerificarInputs($_REQUEST['DES_DEPTO_ITEM']) : "";
        $DES_PROV_ITEM = isset($_REQUEST['DES_PROV_ITEM']) ? VerificarInputs($_REQUEST['DES_PROV_ITEM']) : "";
        $DES_DIST_ITEM = isset($_REQUEST['DES_DIST_ITEM']) ? VerificarInputs($_REQUEST['DES_DIST_ITEM']) : "";
        $DES_ITEM = isset($_REQUEST['DES_ITEM']) ? VerificarInputs($_REQUEST['DES_ITEM']) : "";
        $CNT_PROPUESTAS = isset($_REQUEST['CNT_PROPUESTAS']) ? VerificarInputs($_REQUEST['CNT_PROPUESTAS']) : "";
        $FEC_PUBLICACION = isset($_REQUEST['FEC_PUBLICACION']) ? VerificarInputs($_REQUEST['FEC_PUBLICACION']) : "";
        $FEC_BUENA_PRO_INICIAL = isset($_REQUEST['FEC_BUENA_PRO_INICIAL']) ? VerificarInputs($_REQUEST['FEC_BUENA_PRO_INICIAL']) : "";
        $FEC_BUENA_PRO_FINAL = isset($_REQUEST['FEC_BUENA_PRO_FINAL']) ? VerificarInputs($_REQUEST['FEC_BUENA_PRO_FINAL']) : "";
        $FEC_APELACION = isset($_REQUEST['FEC_APELACION']) ? VerificarInputs($_REQUEST['FEC_APELACION']) : "";
        $FEC_ADJUDICACION = isset($_REQUEST['FEC_ADJUDICACION']) ? VerificarInputs($_REQUEST['FEC_ADJUDICACION']) : "";
        $FEC_INICIO_CONTRATO = isset($_REQUEST['FEC_INICIO_CONTRATO']) ? VerificarInputs($_REQUEST['FEC_INICIO_CONTRATO']) : "";
        $FEC_TERMINO_CONTRATO = isset($_REQUEST['FEC_TERMINO_CONTRATO']) ? VerificarInputs($_REQUEST['FEC_TERMINO_CONTRATO']) : "";
        $COD_CONTRATO = isset($_REQUEST['COD_CONTRATO']) ? VerificarInputs($_REQUEST['COD_CONTRATO']) : "";
        $IMP_VAL_REFERENCIAL_ITEM = isset($_REQUEST['IMP_VAL_REFERENCIAL_ITEM']) ? VerificarInputs($_REQUEST['IMP_VAL_REFERENCIAL_ITEM']) : "";
        $IMP_VAL_ADJUDICADO_ITEM = isset($_REQUEST['IMP_VAL_ADJUDICADO_ITEM']) ? VerificarInputs($_REQUEST['IMP_VAL_ADJUDICADO_ITEM']) : "";
        $COD_RUC_POSTOR_GANADOR = isset($_REQUEST['COD_RUC_POSTOR_GANADOR']) ? VerificarInputs($_REQUEST['COD_RUC_POSTOR_GANADOR']) : "";
        $DES_POSTOR_GANADOR = isset($_REQUEST['DES_POSTOR_GANADOR']) ? VerificarInputs($_REQUEST['DES_POSTOR_GANADOR']) : "";
        $EST_PROCESO_ITEM = isset($_REQUEST['EST_PROCESO_ITEM']) ? VerificarInputs($_REQUEST['EST_PROCESO_ITEM']) : "";
        $DES_OBSERVACION = isset($_REQUEST['DES_OBSERVACION']) ? VerificarInputs($_REQUEST['DES_OBSERVACION']) : "";
        $IDE_MODO_EJECUCION = isset($_REQUEST['IDE_MODO_EJECUCION']) ? VerificarInputs($_REQUEST['IDE_MODO_EJECUCION']) : "";
        $IDE_UNIDAD_MEDIDA = isset($_REQUEST['IDE_UNIDAD_MEDIDA']) ? VerificarInputs($_REQUEST['IDE_UNIDAD_MEDIDA']) : "";
        $CNT_ITEM = isset($_REQUEST['CNT_ITEM']) ? VerificarInputs($_REQUEST['CNT_ITEM']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = " AND IDE_CONVOCATORIA=$Proceso";

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROC_ITEM_DAO();
            $Prueba = "ActionFlex";
            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {
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
            $ogridDAO->Count_PROC_ITEM($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROC_ITEM;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROC_ITEM', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_PUBLICACION) > 0) {
                $FEC_PUBLICACION = cambiafecha($FEC_PUBLICACION);
            } else {
                $FEC_PUBLICACION = "";
            }
            if (strlen($FEC_BUENA_PRO_INICIAL) > 0) {
                $FEC_BUENA_PRO_INICIAL = cambiafecha($FEC_BUENA_PRO_INICIAL);
            } else {
                $FEC_BUENA_PRO_INICIAL = "";
            }
            if (strlen($FEC_BUENA_PRO_FINAL) > 0) {
                $FEC_BUENA_PRO_FINAL = cambiafecha($FEC_BUENA_PRO_FINAL);
            } else {
                $FEC_BUENA_PRO_FINAL = "";
            }
            if (strlen($FEC_APELACION) > 0) {
                $FEC_APELACION = cambiafecha($FEC_APELACION);
            } else {
                $FEC_APELACION = "";
            }
            if (strlen($FEC_ADJUDICACION) > 0) {
                $FEC_ADJUDICACION = cambiafecha($FEC_ADJUDICACION);
            } else {
                $FEC_ADJUDICACION = "";
            }
            if (strlen($FEC_INICIO_CONTRATO) > 0) {
                $FEC_INICIO_CONTRATO = cambiafecha($FEC_INICIO_CONTRATO);
            } else {
                $FEC_INICIO_CONTRATO = "";
            }
            if (strlen($FEC_TERMINO_CONTRATO) > 0) {
                $FEC_TERMINO_CONTRATO = cambiafecha($FEC_TERMINO_CONTRATO);
            } else {
                $FEC_TERMINO_CONTRATO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROC_ITEMM = array();
            $Objeto_PROC_ITEM_DAO = new PROC_ITEM_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONVOCATORIA)) > 0) {
                $lstparametrosM['IDE_CONVOCATORIA'] = $IDE_CONVOCATORIA;
            }
            if (strlen(rtrim($COD_ITEM)) > 0) {
                $lstparametrosM['COD_ITEM'] = $COD_ITEM;
            }
            
            $lstparametrosM['COD_PROYECTO'] = $IDE_CONVOCATORIA.'-'.$COD_ITEM;
            
            if (strlen(rtrim($DES_DEPTO_ITEM)) > 0) {
                $lstparametrosM['DES_DEPTO_ITEM'] = $DES_DEPTO_ITEM;
            }
            if (strlen(rtrim($DES_PROV_ITEM)) > 0) {
                $lstparametrosM['DES_PROV_ITEM'] = $DES_PROV_ITEM;
            }
            if (strlen(rtrim($DES_DIST_ITEM)) > 0) {
                $lstparametrosM['DES_DIST_ITEM'] = $DES_DIST_ITEM;
            }
            if (strlen(rtrim($DES_ITEM)) > 0) {
                $lstparametrosM['DES_ITEM'] = $DES_ITEM;
            }
            if (strlen(rtrim($CNT_PROPUESTAS)) > 0) {
                $lstparametrosM['CNT_PROPUESTAS'] = $CNT_PROPUESTAS;
            }
            if (strlen(rtrim($FEC_PUBLICACION)) > 0) {
                $lstparametrosM['FEC_PUBLICACION'] = $FEC_PUBLICACION;
            }
            if (strlen(rtrim($FEC_BUENA_PRO_INICIAL)) > 0) {
                $lstparametrosM['FEC_BUENA_PRO_INICIAL'] = $FEC_BUENA_PRO_INICIAL;
            }
            if (strlen(rtrim($FEC_BUENA_PRO_FINAL)) > 0) {
                $lstparametrosM['FEC_BUENA_PRO_FINAL'] = $FEC_BUENA_PRO_FINAL;
            }
            if (strlen(rtrim($FEC_APELACION)) > 0) {
                $lstparametrosM['FEC_APELACION'] = $FEC_APELACION;
            }
            if (strlen(rtrim($FEC_ADJUDICACION)) > 0) {
                $lstparametrosM['FEC_ADJUDICACION'] = $FEC_ADJUDICACION;
            }
            if (strlen(rtrim($FEC_INICIO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_INICIO_CONTRATO'] = $FEC_INICIO_CONTRATO;
            }
            if (strlen(rtrim($FEC_TERMINO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_TERMINO_CONTRATO'] = $FEC_TERMINO_CONTRATO;
            }
            if (strlen(rtrim($COD_CONTRATO)) > 0) {
                $lstparametrosM['COD_CONTRATO'] = $COD_CONTRATO;
            }
            if (strlen(rtrim($IMP_VAL_REFERENCIAL_ITEM)) > 0) {
                $lstparametrosM['IMP_VAL_REFERENCIAL_ITEM'] = $IMP_VAL_REFERENCIAL_ITEM;
            }
            if (strlen(rtrim($IMP_VAL_ADJUDICADO_ITEM)) > 0) {
                $lstparametrosM['IMP_VAL_ADJUDICADO_ITEM'] = $IMP_VAL_ADJUDICADO_ITEM;
            }
            if (strlen(rtrim($COD_RUC_POSTOR_GANADOR)) > 0) {
                $lstparametrosM['COD_RUC_POSTOR_GANADOR'] = $COD_RUC_POSTOR_GANADOR;
            }
            if (strlen(rtrim($DES_POSTOR_GANADOR)) > 0) {
                $lstparametrosM['DES_POSTOR_GANADOR'] = $DES_POSTOR_GANADOR;
            }
            if (strlen(rtrim($EST_PROCESO_ITEM)) > 0) {
                $lstparametrosM['EST_PROCESO_ITEM'] = $EST_PROCESO_ITEM;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($IDE_MODO_EJECUCION)) > 0) {
                $lstparametrosM['IDE_MODO_EJECUCION'] = $IDE_MODO_EJECUCION;
            }
            if (strlen(rtrim($IDE_UNIDAD_MEDIDA)) > 0) {
                $lstparametrosM['IDE_UNIDAD_MEDIDA'] = $IDE_UNIDAD_MEDIDA;
            }
            if (strlen(rtrim($CNT_ITEM)) > 0) {
                $lstparametrosM['CNT_ITEM'] = $CNT_ITEM;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DEPTO_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROV_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DIST_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CNT_PROPUESTAS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_PUBLICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_BUENA_PRO_INICIAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_BUENA_PRO_FINAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_APELACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_ADJUDICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_VAL_REFERENCIAL_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_VAL_ADJUDICADO_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_RUC_POSTOR_GANADOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_POSTOR_GANADOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROCESO_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_MODO_EJECUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CNT_ITEM'], SQLSRV_PARAM_IN), 
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_ITEM_DAO->Insert_PROC_ITEM($DataSet_PROC_ITEM, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[26][0];

            $mensaje = $procedure_parametrosMS[27][0];

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
            $DataSet_PROC_ITEM = array();
            $Objeto_PROC_ITEM_DAO = new PROC_ITEM_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROC_ITEM_DAO->SelPk_PROC_ITEM($DataSet_PROC_ITEM, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROC_ITEM) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROC_ITEM

                $IDE_CONVOCATORIA = $DataSet_PROC_ITEM[0]->IDE_CONVOCATORIA;
                $COD_ITEM = $DataSet_PROC_ITEM[0]->COD_ITEM;
                $COD_PROYECTO = $DataSet_PROC_ITEM[0]->COD_PROYECTO;
                $DES_DEPTO_ITEM = $DataSet_PROC_ITEM[0]->DES_DEPTO_ITEM;
                $DES_PROV_ITEM = $DataSet_PROC_ITEM[0]->DES_PROV_ITEM;
                $DES_DIST_ITEM = $DataSet_PROC_ITEM[0]->DES_DIST_ITEM;
                $DES_ITEM = $DataSet_PROC_ITEM[0]->DES_ITEM;
                $CNT_PROPUESTAS = $DataSet_PROC_ITEM[0]->CNT_PROPUESTAS;
                $FEC_PUBLICACION = $DataSet_PROC_ITEM[0]->FEC_PUBLICACION;
                $FEC_BUENA_PRO_INICIAL = $DataSet_PROC_ITEM[0]->FEC_BUENA_PRO_INICIAL;
                $FEC_BUENA_PRO_FINAL = $DataSet_PROC_ITEM[0]->FEC_BUENA_PRO_FINAL;
                $FEC_APELACION = $DataSet_PROC_ITEM[0]->FEC_APELACION;
                $FEC_ADJUDICACION = $DataSet_PROC_ITEM[0]->FEC_ADJUDICACION;
                $FEC_INICIO_CONTRATO = $DataSet_PROC_ITEM[0]->FEC_INICIO_CONTRATO;
                $FEC_TERMINO_CONTRATO = $DataSet_PROC_ITEM[0]->FEC_TERMINO_CONTRATO;
                $COD_CONTRATO = $DataSet_PROC_ITEM[0]->COD_CONTRATO;
                $IMP_VAL_REFERENCIAL_ITEM = $DataSet_PROC_ITEM[0]->IMP_VAL_REFERENCIAL_ITEM;
                $IMP_VAL_ADJUDICADO_ITEM = $DataSet_PROC_ITEM[0]->IMP_VAL_ADJUDICADO_ITEM;
                $COD_RUC_POSTOR_GANADOR = $DataSet_PROC_ITEM[0]->COD_RUC_POSTOR_GANADOR;
                $DES_POSTOR_GANADOR = $DataSet_PROC_ITEM[0]->DES_POSTOR_GANADOR;
                $EST_PROCESO_ITEM = $DataSet_PROC_ITEM[0]->EST_PROCESO_ITEM;
                $DES_OBSERVACION = $DataSet_PROC_ITEM[0]->DES_OBSERVACION;
                $IDE_MODO_EJECUCION = $DataSet_PROC_ITEM[0]->IDE_MODO_EJECUCION;
                $IDE_UNIDAD_MEDIDA = $DataSet_PROC_ITEM[0]->IDE_UNIDAD_MEDIDA;
                $CNT_ITEM = $DataSet_PROC_ITEM[0]->CNT_ITEM;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONVOCATORIA', $IDE_CONVOCATORIA);
            $lCollection->Add('COD_ITEM', $COD_ITEM);
            $lCollection->Add('COD_PROYECTO', $COD_PROYECTO);
            $lCollection->Add('DES_DEPTO_ITEM', $DES_DEPTO_ITEM);
            $lCollection->Add('DES_PROV_ITEM', $DES_PROV_ITEM);
            $lCollection->Add('DES_DIST_ITEM', $DES_DIST_ITEM);
            $lCollection->Add('DES_ITEM', $DES_ITEM);
            $lCollection->Add('CNT_PROPUESTAS', $CNT_PROPUESTAS);
            $lCollection->Add('FEC_PUBLICACION', $FEC_PUBLICACION);
            $lCollection->Add('FEC_BUENA_PRO_INICIAL', $FEC_BUENA_PRO_INICIAL);
            $lCollection->Add('FEC_BUENA_PRO_FINAL', $FEC_BUENA_PRO_FINAL);
            $lCollection->Add('FEC_APELACION', $FEC_APELACION);
            $lCollection->Add('FEC_ADJUDICACION', $FEC_ADJUDICACION);
            $lCollection->Add('FEC_INICIO_CONTRATO', $FEC_INICIO_CONTRATO);
            $lCollection->Add('FEC_TERMINO_CONTRATO', $FEC_TERMINO_CONTRATO);
            $lCollection->Add('COD_CONTRATO', $COD_CONTRATO);
            $lCollection->Add('IMP_VAL_REFERENCIAL_ITEM', $IMP_VAL_REFERENCIAL_ITEM);
            $lCollection->Add('IMP_VAL_ADJUDICADO_ITEM', $IMP_VAL_ADJUDICADO_ITEM);
            $lCollection->Add('COD_RUC_POSTOR_GANADOR', $COD_RUC_POSTOR_GANADOR);
            $lCollection->Add('DES_POSTOR_GANADOR', $DES_POSTOR_GANADOR);
            $lCollection->Add('EST_PROCESO_ITEM', $EST_PROCESO_ITEM);
            $lCollection->Add('DES_OBSERVACION', $DES_OBSERVACION);
            $lCollection->Add('IDE_MODO_EJECUCION', $IDE_MODO_EJECUCION);
            $lCollection->Add('IDE_UNIDAD_MEDIDA', $IDE_UNIDAD_MEDIDA);
            $lCollection->Add('CNT_ITEM', $CNT_ITEM);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_PUBLICACION) > 0) {
                $FEC_PUBLICACION = cambiafecha($FEC_PUBLICACION);
            } else {
                $FEC_PUBLICACION = "";
            }
            if (strlen($FEC_BUENA_PRO_INICIAL) > 0) {
                $FEC_BUENA_PRO_INICIAL = cambiafecha($FEC_BUENA_PRO_INICIAL);
            } else {
                $FEC_BUENA_PRO_INICIAL = "";
            }
            if (strlen($FEC_BUENA_PRO_FINAL) > 0) {
                $FEC_BUENA_PRO_FINAL = cambiafecha($FEC_BUENA_PRO_FINAL);
            } else {
                $FEC_BUENA_PRO_FINAL = "";
            }
            if (strlen($FEC_APELACION) > 0) {
                $FEC_APELACION = cambiafecha($FEC_APELACION);
            } else {
                $FEC_APELACION = "";
            }
            if (strlen($FEC_ADJUDICACION) > 0) {
                $FEC_ADJUDICACION = cambiafecha($FEC_ADJUDICACION);
            } else {
                $FEC_ADJUDICACION = "";
            }
            if (strlen($FEC_INICIO_CONTRATO) > 0) {
                $FEC_INICIO_CONTRATO = cambiafecha($FEC_INICIO_CONTRATO);
            } else {
                $FEC_INICIO_CONTRATO = "";
            }
            if (strlen($FEC_TERMINO_CONTRATO) > 0) {
                $FEC_TERMINO_CONTRATO = cambiafecha($FEC_TERMINO_CONTRATO);
            } else {
                $FEC_TERMINO_CONTRATO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROC_ITEM = array();
            $Objeto_PROC_ITEM_DAO = new PROC_ITEM_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONVOCATORIA)) > 0) {
                $lstparametrosM['IDE_CONVOCATORIA'] = $IDE_CONVOCATORIA;
            }
            if (strlen(rtrim($COD_ITEM)) > 0) {
                $lstparametrosM['COD_ITEM'] = $COD_ITEM;
            }            
            $lstparametrosM['COD_PROYECTO'] = $IDE_CONVOCATORIA.'-'.$COD_ITEM;
            
            if (strlen(rtrim($DES_DEPTO_ITEM)) > 0) {
                $lstparametrosM['DES_DEPTO_ITEM'] = $DES_DEPTO_ITEM;
            }
            if (strlen(rtrim($DES_PROV_ITEM)) > 0) {
                $lstparametrosM['DES_PROV_ITEM'] = $DES_PROV_ITEM;
            }
            if (strlen(rtrim($DES_DIST_ITEM)) > 0) {
                $lstparametrosM['DES_DIST_ITEM'] = $DES_DIST_ITEM;
            }
            if (strlen(rtrim($DES_ITEM)) > 0) {
                $lstparametrosM['DES_ITEM'] = $DES_ITEM;
            }
            if (strlen(rtrim($CNT_PROPUESTAS)) > 0) {
                $lstparametrosM['CNT_PROPUESTAS'] = $CNT_PROPUESTAS;
            }
            if (strlen(rtrim($FEC_PUBLICACION)) > 0) {
                $lstparametrosM['FEC_PUBLICACION'] = $FEC_PUBLICACION;
            }
            if (strlen(rtrim($FEC_BUENA_PRO_INICIAL)) > 0) {
                $lstparametrosM['FEC_BUENA_PRO_INICIAL'] = $FEC_BUENA_PRO_INICIAL;
            }
            if (strlen(rtrim($FEC_BUENA_PRO_FINAL)) > 0) {
                $lstparametrosM['FEC_BUENA_PRO_FINAL'] = $FEC_BUENA_PRO_FINAL;
            }
            if (strlen(rtrim($FEC_APELACION)) > 0) {
                $lstparametrosM['FEC_APELACION'] = $FEC_APELACION;
            }
            if (strlen(rtrim($FEC_ADJUDICACION)) > 0) {
                $lstparametrosM['FEC_ADJUDICACION'] = $FEC_ADJUDICACION;
            }
            if (strlen(rtrim($FEC_INICIO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_INICIO_CONTRATO'] = $FEC_INICIO_CONTRATO;
            }
            if (strlen(rtrim($FEC_TERMINO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_TERMINO_CONTRATO'] = $FEC_TERMINO_CONTRATO;
            }
            if (strlen(rtrim($COD_CONTRATO)) > 0) {
                $lstparametrosM['COD_CONTRATO'] = $COD_CONTRATO;
            }
            if (strlen(rtrim($IMP_VAL_REFERENCIAL_ITEM)) > 0) {
                $lstparametrosM['IMP_VAL_REFERENCIAL_ITEM'] = $IMP_VAL_REFERENCIAL_ITEM;
            }
            if (strlen(rtrim($IMP_VAL_ADJUDICADO_ITEM)) > 0) {
                $lstparametrosM['IMP_VAL_ADJUDICADO_ITEM'] = $IMP_VAL_ADJUDICADO_ITEM;
            }
            if (strlen(rtrim($COD_RUC_POSTOR_GANADOR)) > 0) {
                $lstparametrosM['COD_RUC_POSTOR_GANADOR'] = $COD_RUC_POSTOR_GANADOR;
            }
            if (strlen(rtrim($DES_POSTOR_GANADOR)) > 0) {
                $lstparametrosM['DES_POSTOR_GANADOR'] = $DES_POSTOR_GANADOR;
            }
            if (strlen(rtrim($EST_PROCESO_ITEM)) > 0) {
                $lstparametrosM['EST_PROCESO_ITEM'] = $EST_PROCESO_ITEM;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($IDE_MODO_EJECUCION)) > 0) {
                $lstparametrosM['IDE_MODO_EJECUCION'] = $IDE_MODO_EJECUCION;
            }
            if (strlen(rtrim($IDE_UNIDAD_MEDIDA)) > 0) {
                $lstparametrosM['IDE_UNIDAD_MEDIDA'] = $IDE_UNIDAD_MEDIDA;
            }
            if (strlen(rtrim($CNT_ITEM)) > 0) {
                $lstparametrosM['CNT_ITEM'] = $CNT_ITEM;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DEPTO_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROV_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DIST_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CNT_PROPUESTAS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_PUBLICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_BUENA_PRO_INICIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_BUENA_PRO_FINAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_APELACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_ADJUDICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_VAL_REFERENCIAL_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_VAL_ADJUDICADO_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_RUC_POSTOR_GANADOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_POSTOR_GANADOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROCESO_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_MODO_EJECUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CNT_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_ITEM_DAO->Update_PROC_ITEM($DataSet_PROC_ITEM, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[27][0];

            $mensaje = $procedure_parametrosMS[28][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROC_ITEM = array();
            $Objeto_PROC_ITEM_DAO = new PROC_ITEM_DAO();
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
            $Objeto_PROC_ITEM_DAO->Delete_PROC_ITEM($DataSet_PROC_ITEM, $procedure_parametrosMS); //JCMY
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

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
        $DataSet_PROCESO_1 = array();
        $Objeto_IDE_CONVOCATORIA_DAO = new PROCESO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONVOCATORIA, DES_OBJETO, IMP_VAL_REFERENCIAL";
        $lstparametrosM['filtro'] = "AND IDE_CONVOCATORIA='$Proceso'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );        
        $Objeto_IDE_CONVOCATORIA_DAO->SelCampos_PROCESO($DataSet_PROCESO_1, $procedure_parametrosMS);        
        $PIDE_CONVOCATORIA = $DataSet_PROCESO_1[0]->IDE_CONVOCATORIA;        
        $PDES_OBJETO = $DataSet_PROCESO_1[0]->DES_OBJETO;
        $PIMP_VAL_REFERENCIAL = $DataSet_PROCESO_1[0]->IMP_VAL_REFERENCIAL;
        $lCollection->Add('VIDE_CONVOCATORIA', $PIDE_CONVOCATORIA);
        $lCollection->Add('VDES_OBJETO', $PDES_OBJETO);
        $lCollection->Add('VIMP_VAL_REFERENCIAL', $PIMP_VAL_REFERENCIAL);
        
        
        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_MODO_EJECUCION_1 = array();
        $Objeto_IDE_MODO_EJECUCION_DAO = new GEN_MODO_EJECUCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_MODO_EJECUCION,DES_MODO_EJECUCION";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_MODO_EJECUCION_DAO->SelCampos_GEN_MODO_EJECUCION($DataSet_GEN_MODO_EJECUCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_MODO_EJECUCION_1', $DataSet_GEN_MODO_EJECUCION_1);

        /* 					 */

        $DataSet_PROC_UNIDAD_MEDIDA_1 = array();
        $Objeto_IDE_UNIDAD_MEDIDA_DAO = new PROC_UNIDAD_MEDIDA_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_UNIDAD_MEDIDA,UNIDAD_MEDIDA";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_UNIDAD_MEDIDA_DAO->SelCampos_PROC_UNIDAD_MEDIDA($DataSet_PROC_UNIDAD_MEDIDA_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_PROC_UNIDAD_MEDIDA_1', $DataSet_PROC_UNIDAD_MEDIDA_1);
        
        $lCollection->Add('Proceso', $Proceso);

        /* 					 */

        /* 					 */
        
        /* EDGAR */
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;