<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : PLAN_GESTION_TRANSFERENCIALN de la tabla PLAN_GESTION_TRANSFERENCIA
  //  Fecha           : lunes, 09 de julio de 2018 11:06:54 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLAN_GESTION_TRANSFERENCIADAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_NORMATIVADAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PLAN_GESTION_TRANSFERENCIA";
    $PermisoOK = 0;

    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) {
        $mensaje = $_POST['Mensaje'];
    } else {
        $mensaje = 0;
    }

    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) {
        $usuario = $_SESSION['usuario'];
    } else {
        $usuario = 0;
    }
    if (!empty($_SESSION['CodPerfil'])) {
        $perfilsession = $_SESSION['CodPerfil'];
    } else {
        $perfilsession = 0;
    }

    //OBTIENE LOS PERMISOS Y NIVELES DE ACCESO
    $PermisosPerfil = CallNomPerfil($perfilsession);
    //VERIFICA EL ACCESO
    if (($PermisosPerfil == "ADMINISTRADOR") || ($PermisosPerfil == "MACRO 1 - 8") || ($PermisosPerfil == "MACRO INVITADO") || ($PermisosPerfil == "MACRO 2") || ($PermisosPerfil == "MACRO 3") || ($PermisosPerfil == "MACRO 4") || ($PermisosPerfil == "MACRO 5") || ($PermisosPerfil == "MACRO 6") || ($PermisosPerfil == "MACRO 7") || ($PermisosPerfil == "MACRO 8") || ($PermisosPerfil == "MACRO 9")) {
        $PermisoOK = 1;
    }

    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_NORMATIVA = isset($_REQUEST['IDE_NORMATIVA']) ? VerificarInputs($_REQUEST['IDE_NORMATIVA']) : "";
        $FEC_FORMULACION = isset($_REQUEST['FEC_FORMULACION']) ? VerificarInputs($_REQUEST['FEC_FORMULACION']) : "";
        $COD_TRAMITE = isset($_REQUEST['COD_TRAMITE']) ? VerificarInputs($_REQUEST['COD_TRAMITE']) : "";
        $IMP_TOTAL = isset($_REQUEST['IMP_TOTAL']) ? VerificarInputs($_REQUEST['IMP_TOTAL']) : "";
        $DES_OBSERVACION = isset($_REQUEST['DES_OBSERVACION']) ? VerificarInputs($_REQUEST['DES_OBSERVACION']) : "";
        $EST_SOLICITUD = isset($_REQUEST['EST_SOLICITUD']) ? VerificarInputs($_REQUEST['EST_SOLICITUD']) : "";
        $EST_PLAN_GESTION_TRANS = isset($_REQUEST['EST_PLAN_GESTION_TRANS']) ? VerificarInputs($_REQUEST['EST_PLAN_GESTION_TRANS']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PLAN_GESTION_TRANSFERENCIA_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'CodigoTramite') {
                        $_POST['qtype'] = 'GT.COD_TRAMITE';
                    }
                    if ($_POST['qtype'] == 'Estado') {
                        $_POST['qtype'] = 'TT1.DES_ITEM';
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
            $ogridDAO->Count_PLAN_GESTION_TRANSFERENCIA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PLAN_GESTION_TRANS;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PLAN_GESTION_TRANSFERENCIA', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_FORMULACION) > 0) {
                $FEC_FORMULACION = cambiafecha($FEC_FORMULACION);
            } else {
                $FEC_FORMULACION = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PLAN_GESTION_TRANSFERENCIAM = array();
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO = new PLAN_GESTION_TRANSFERENCIA_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_NORMATIVA)) > 0) {
                $lstparametrosM['IDE_NORMATIVA'] = $IDE_NORMATIVA;
            }
            if (strlen(rtrim($FEC_FORMULACION)) > 0) {
                $lstparametrosM['FEC_FORMULACION'] = $FEC_FORMULACION;
            }
            if (strlen(rtrim($COD_TRAMITE)) > 0) {
                $lstparametrosM['COD_TRAMITE'] = $COD_TRAMITE;
            }
            if (strlen(rtrim($IMP_TOTAL)) > 0) {
                $lstparametrosM['IMP_TOTAL'] = $IMP_TOTAL;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_SOLICITUD)) > 0) {
                $lstparametrosM['EST_SOLICITUD'] = $EST_SOLICITUD;
            }
            if (strlen(rtrim($EST_PLAN_GESTION_TRANS)) > 0) {
                $lstparametrosM['EST_PLAN_GESTION_TRANS'] = $EST_PLAN_GESTION_TRANS;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_NORMATIVA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_FORMULACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_TRAMITE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_TOTAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_SOLICITUD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PLAN_GESTION_TRANS'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO->Insert_PLAN_GESTION_TRANSFERENCIA($DataSet_PLAN_GESTION_TRANSFERENCIA, $procedure_parametrosMS); //JCMY

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
            $DataSet_PLAN_GESTION_TRANSFERENCIA = array();
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO = new PLAN_GESTION_TRANSFERENCIA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO->SelPk_PLAN_GESTION_TRANSFERENCIA($DataSet_PLAN_GESTION_TRANSFERENCIA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PLAN_GESTION_TRANSFERENCIA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PLAN_GESTION_TRANSFERENCIA

                $IDE_NORMATIVA = $DataSet_PLAN_GESTION_TRANSFERENCIA[0]->IDE_NORMATIVA;
                $FEC_FORMULACION = $DataSet_PLAN_GESTION_TRANSFERENCIA[0]->FEC_FORMULACION;
                $COD_TRAMITE = $DataSet_PLAN_GESTION_TRANSFERENCIA[0]->COD_TRAMITE;
                $IMP_TOTAL = $DataSet_PLAN_GESTION_TRANSFERENCIA[0]->IMP_TOTAL;
                $DES_OBSERVACION = $DataSet_PLAN_GESTION_TRANSFERENCIA[0]->DES_OBSERVACION;
                $EST_SOLICITUD = $DataSet_PLAN_GESTION_TRANSFERENCIA[0]->EST_SOLICITUD;
                $EST_PLAN_GESTION_TRANS = $DataSet_PLAN_GESTION_TRANSFERENCIA[0]->EST_PLAN_GESTION_TRANS;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_NORMATIVA', $IDE_NORMATIVA);
            $lCollection->Add('FEC_FORMULACION', $FEC_FORMULACION);
            $lCollection->Add('COD_TRAMITE', $COD_TRAMITE);
            $lCollection->Add('IMP_TOTAL', $IMP_TOTAL);
            $lCollection->Add('DES_OBSERVACION', $DES_OBSERVACION);
            $lCollection->Add('EST_SOLICITUD', $EST_SOLICITUD);
            $lCollection->Add('EST_PLAN_GESTION_TRANS', $EST_PLAN_GESTION_TRANS);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_FORMULACION) > 0) {
                $FEC_FORMULACION = cambiafecha($FEC_FORMULACION);
            } else {
                $FEC_FORMULACION = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PLAN_GESTION_TRANSFERENCIA = array();
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO = new PLAN_GESTION_TRANSFERENCIA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_NORMATIVA)) > 0) {
                $lstparametrosM['IDE_NORMATIVA'] = $IDE_NORMATIVA;
            }
            if (strlen(rtrim($FEC_FORMULACION)) > 0) {
                $lstparametrosM['FEC_FORMULACION'] = $FEC_FORMULACION;
            }
            if (strlen(rtrim($COD_TRAMITE)) > 0) {
                $lstparametrosM['COD_TRAMITE'] = $COD_TRAMITE;
            }
            if (strlen(rtrim($IMP_TOTAL)) > 0) {
                $lstparametrosM['IMP_TOTAL'] = $IMP_TOTAL;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_SOLICITUD)) > 0) {
                $lstparametrosM['EST_SOLICITUD'] = $EST_SOLICITUD;
            }
            if (strlen(rtrim($EST_PLAN_GESTION_TRANS)) > 0) {
                $lstparametrosM['EST_PLAN_GESTION_TRANS'] = $EST_PLAN_GESTION_TRANS;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_NORMATIVA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_FORMULACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_TRAMITE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_TOTAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_SOLICITUD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PLAN_GESTION_TRANS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO->Update_PLAN_GESTION_TRANSFERENCIA($DataSet_PLAN_GESTION_TRANSFERENCIA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[9][0];

            $mensaje = $procedure_parametrosMS[10][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PLAN_GESTION_TRANSFERENCIA = array();
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO = new PLAN_GESTION_TRANSFERENCIA_DAO();
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
            $Objeto_PLAN_GESTION_TRANSFERENCIA_DAO->Delete_PLAN_GESTION_TRANSFERENCIA($DataSet_PLAN_GESTION_TRANSFERENCIA, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_NORMATIVA_1 = array();
        $Objeto_IDE_NORMATIVA_DAO = new GEN_NORMATIVA_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_NORMATIVA,COD_NORMATIVA";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_NORMATIVA_DAO->SelCampos_GEN_NORMATIVA($DataSet_GEN_NORMATIVA_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_NORMATIVA_1', $DataSet_GEN_NORMATIVA_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_SOLICITUD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='52'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_SOLICITUD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_PLAN_GESTION_TRANS_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PLAN_GESTION_TRANS_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
    }
}

//var_dump($lstDepartamento);exit;