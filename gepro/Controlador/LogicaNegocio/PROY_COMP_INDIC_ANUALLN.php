<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_INDIC_ANUALLN de la tabla PROY_COMP_INDIC_ANUAL
  //  Fecha           : sábado, 6 de enero de 2018 22:17:28
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMP_INDIC_ANUALDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PROY_COMPONENTEDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMPONENTE_PLANDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMP_ACTIVIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_INDICADORDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/PROY_COMPONENTElni.php");
require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/PROYECTOlni.php");
/* EDGAR */

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_COMP_INDIC_ANUAL";
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
    if (!empty($_SESSION['personal'])) {
        $personal = $_SESSION['personal'];
    } else {
        $personal = 0;
    }
    if (!empty($_SESSION['Oc'])) {
        $Opcionsession = $_SESSION['Oc'];
    } else {
        $Opcionsession = 0;
    }
    $PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession, $perfilsession);

    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";


        $PIDE_PROY_COMPONENTE = isset($_REQUEST['PIDE_PROY_COMPONENTE']) ? VerificarInputs($_REQUEST['PIDE_PROY_COMPONENTE']) : "";


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_COMPONENTE_PLAN = isset($_REQUEST['IDE_COMPONENTE_PLAN']) ? VerificarInputs($_REQUEST['IDE_COMPONENTE_PLAN']) : "";
        $IDE_PROY_COMPONENTE = isset($_REQUEST['IDE_PROY_COMPONENTE']) ? VerificarInputs($_REQUEST['IDE_PROY_COMPONENTE']) : "";
        $IDE_INDICADOR = isset($_REQUEST['IDE_INDICADOR']) ? VerificarInputs($_REQUEST['IDE_INDICADOR']) : "";
        $IDE_COMP_ACTIVIDAD = isset($_REQUEST['IDE_COMP_ACTIVIDAD']) ? VerificarInputs($_REQUEST['IDE_COMP_ACTIVIDAD']) : "";
        $COD_ANHO = isset($_REQUEST['COD_ANHO']) ? VerificarInputs($_REQUEST['COD_ANHO']) : "";
        $NUM_VALOR = isset($_REQUEST['NUM_VALOR']) ? VerificarInputs($_REQUEST['NUM_VALOR']) : "";
        $EST_COMP_INDIC_ANUAL = isset($_REQUEST['EST_COMP_INDIC_ANUAL']) ? VerificarInputs($_REQUEST['EST_COMP_INDIC_ANUAL']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " "; //" AND  IDE_PROY_COMPONENTE=$PIDE_PROY_COMPONENTE";



        $DataSet_PROY_COMPONENTE_1 = array();
        $Objeto_IDE_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONVOCATORIA,COD_ITEM,SEC_EJEC,DES_ENTIDAD,UPPER(DES_INTERVENCION) AS DES_INTERVENCION,   DES_PROYECTO  ,DES_PROYECTO_ITEM,DES_COMPONENTE,DES_CARTERA,DES_ESTADO,CONVERT(varchar(10), FEC_INICIO_CONTRATO, 103) as FEC_INICIO_CONTRATO, CONVERT(varchar(10), FEC_TERMINO_CONTRATO, 103) as FEC_TERMINO_CONTRATO, IMP_COMPONENTE, DATEDIFF(day, FEC_INICIO_CONTRATO, FEC_TERMINO_CONTRATO)+1 AS DIAS_CONTRACTUALES ";
        $lstparametrosM['filtro'] = " AND PC.IDE_PROY_COMPONENTE = '$PIDE_PROY_COMPONENTE'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_PROY_COMPONENTE_DAO->SelCampos_PROY_COMPONENTE2($DataSet_PROY_COMPONENTE_1, $procedure_parametrosMS);
        $VIDE_CONVOCATORIA = $DataSet_PROY_COMPONENTE_1[0]->IDE_CONVOCATORIA;
        $lCollection->Add('VIDE_CONVOCATORIA', $VIDE_CONVOCATORIA);
        $VCOD_ITEM = $DataSet_PROY_COMPONENTE_1[0]->COD_ITEM;
        $lCollection->Add('VCOD_ITEM', $VCOD_ITEM);
        $VSEC_EJEC = $DataSet_PROY_COMPONENTE_1[0]->SEC_EJEC;
        $lCollection->Add('VSEC_EJEC', $VSEC_EJEC);
        $VDES_ENTIDAD = $DataSet_PROY_COMPONENTE_1[0]->DES_ENTIDAD;
        $lCollection->Add('VDES_ENTIDAD', $VDES_ENTIDAD);
        $VDES_INTERVENCION = $DataSet_PROY_COMPONENTE_1[0]->DES_INTERVENCION;
        $lCollection->Add('VDES_INTERVENCION', $VDES_INTERVENCION);
        $VDES_PROYECTO_ITEM = $DataSet_PROY_COMPONENTE_1[0]->DES_PROYECTO_ITEM;
        $lCollection->Add('VDES_PROYECTO_ITEM', $VDES_PROYECTO_ITEM);

        $VDES_PROYECTO = $DataSet_PROY_COMPONENTE_1[0]->DES_PROYECTO;
        $lCollection->Add('VDES_PROYECTO', $VDES_PROYECTO);

        $VDES_COMPONENTE = $DataSet_PROY_COMPONENTE_1[0]->DES_COMPONENTE;
        $lCollection->Add('VDES_COMPONENTE', $VDES_COMPONENTE);
        $VDES_CARTERA = $DataSet_PROY_COMPONENTE_1[0]->DES_CARTERA;
        $lCollection->Add('VDES_CARTERA', $VDES_CARTERA);
        $VDES_ESTADO = $DataSet_PROY_COMPONENTE_1[0]->DES_ESTADO;
        $lCollection->Add('VDES_ESTADO', $VDES_ESTADO);
        $VFEC_INICIO_CONTRATO = $DataSet_PROY_COMPONENTE_1[0]->FEC_INICIO_CONTRATO;
        $lCollection->Add('VFEC_INICIO_CONTRATO', $VFEC_INICIO_CONTRATO);
        $VFEC_TERMINO_CONTRATO = $DataSet_PROY_COMPONENTE_1[0]->FEC_TERMINO_CONTRATO;
        $lCollection->Add('VFEC_TERMINO_CONTRATO', $VFEC_TERMINO_CONTRATO);
        $VIMP_COMPONENTE = $DataSet_PROY_COMPONENTE_1[0]->IMP_COMPONENTE;
        $lCollection->Add('VIMP_COMPONENTE', $VIMP_COMPONENTE);
        $VDIAS_CONTRACTUALES = $DataSet_PROY_COMPONENTE_1[0]->DIAS_CONTRACTUALES;
        $lCollection->Add('VDIAS_CONTRACTUALES', $VDIAS_CONTRACTUALES);



        /* EDGAR */
        $Data11 = ProyectoComponente_Datos($PIDE_PROY_COMPONENTE);
        $Data12 = ProyectoActividad_Datos($Data11['IDE_PROYECTO_ACTIVIDAD']);
        $lCollection->Add('VCOD_PROYECTO', $Data12['COD_PROYECTO']);

        $lCollection->Add('VIDE_PROYECTO', $Data12['IDE_PROYECTO']);
        /* EDGAR */




        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_COMP_INDIC_ANUAL_DAO();


            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'INDICADOR') {
                        $_POST['qtype'] = 'NULL';
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
            $lparametroP['IDE_PROY_COMPONENTE'] = $PIDE_PROY_COMPONENTE;

            $procedure_parametrosP = array(
                array(&$lparametroP['Script'], SQLSRV_PARAM_IN),
                array(&$lparametroP['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN)
            );
            $ogridDAO->Count_PROY_COMP_INDIC_ANUAL($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_COMP_INDIC_ANUAL;
            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP1($ogridDAO, 'SelGrd_PROY_COMP_INDIC_ANUAL', $nTotal, $_POST['page'], $lparametro, $PIDE_PROY_COMPONENTE, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */

        if ($Action == "RegistraDatos") {


            $DataSet_PROY_COMP_INDIC_ANUALM = array();
            $Objeto_PROY_COMP_INDIC_ANUAL_DAO = new PROY_COMP_INDIC_ANUAL_DAO();
            $lstparametrosM = array();
            $lstparametrosM['IDE_PROY_COMPONENTE'] = $PIDE_PROY_COMPONENTE;
            if (strlen(rtrim($IDE_COMPONENTE_PLAN)) > 0) {
                $lstparametrosM['IDE_COMPONENTE_PLAN'] = $IDE_COMPONENTE_PLAN;
            }
            if (strlen(rtrim($IDE_INDICADOR)) > 0) {
                $lstparametrosM['IDE_INDICADOR'] = $IDE_INDICADOR;
            }
            if (strlen(rtrim($IDE_COMP_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_COMP_ACTIVIDAD'] = $IDE_COMP_ACTIVIDAD;
            }
            if (strlen(rtrim($COD_ANHO)) > 0) {
                $lstparametrosM['COD_ANHO'] = $COD_ANHO;
            }
            if (strlen(rtrim($NUM_VALOR)) > 0) {
                $lstparametrosM['NUM_VALOR'] = $NUM_VALOR;
            }
            if (strlen(rtrim($EST_COMP_INDIC_ANUAL)) > 0) {
                $lstparametrosM['EST_COMP_INDIC_ANUAL'] = $EST_COMP_INDIC_ANUAL;
            }

            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_COMPONENTE_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_INDICADOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_COMP_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ANHO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_VALOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_COMP_INDIC_ANUAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMP_INDIC_ANUAL_DAO->Insert_PROY_COMP_INDIC_ANUAL($DataSet_PROY_COMP_INDIC_ANUAL, $procedure_parametrosMS); //JCMY

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
        /*
          if ($Action == "ModificarRegistro") {
          //var_dump($SeleccionarID);
          $DataSet_PROY_COMP_INDIC_ANUAL = array();
          $Objeto_PROY_COMP_INDIC_ANUAL_DAO = new PROY_COMP_INDIC_ANUAL_DAO();
          $lstparametrosM = array();
          $lstparametrosM['SeleccionarID'] = $SeleccionarID;
          $procedure_parametrosMS = array(
          array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
          );
          $Objeto_PROY_COMP_INDIC_ANUAL_DAO->SelPk_PROY_COMP_INDIC_ANUAL($DataSet_PROY_COMP_INDIC_ANUAL, $procedure_parametrosMS); // JCMY
          //var_dump($procedure_parametrosMS);
          $listaContador = count($DataSet_PROY_COMP_INDIC_ANUAL) > 0 ? true : false; //JCMY
          //var_dump($listaContador);exit;
          if (($listaContador == true) || ($listaContador > 0)) {
          //Recuperando Valores del arreglo $DataSet_PROY_COMP_INDIC_ANUAL

          $IDE_COMPONENTE_PLAN = $DataSet_PROY_COMP_INDIC_ANUAL[0]->IDE_COMPONENTE_PLAN;
          $IDE_INDICADOR = $DataSet_PROY_COMP_INDIC_ANUAL[0]->IDE_INDICADOR;
          $IDE_COMP_ACTIVIDAD = $DataSet_PROY_COMP_INDIC_ANUAL[0]->IDE_COMP_ACTIVIDAD;
          $COD_ANHO = $DataSet_PROY_COMP_INDIC_ANUAL[0]->COD_ANHO;
          $NUM_VALOR = $DataSet_PROY_COMP_INDIC_ANUAL[0]->NUM_VALOR;
          $EST_COMP_INDIC_ANUAL = $DataSet_PROY_COMP_INDIC_ANUAL[0]->EST_COMP_INDIC_ANUAL;
          }
          $lCollection->Add('SeleccionarID', $SeleccionarID);
          $lCollection->Add('IDE_COMPONENTE_PLAN', $IDE_COMPONENTE_PLAN);
          $lCollection->Add('IDE_INDICADOR', $IDE_INDICADOR);
          $lCollection->Add('IDE_COMP_ACTIVIDAD', $IDE_COMP_ACTIVIDAD);
          $lCollection->Add('COD_ANHO', $COD_ANHO);
          $lCollection->Add('NUM_VALOR', $NUM_VALOR);
          $lCollection->Add('EST_COMP_INDIC_ANUAL', $EST_COMP_INDIC_ANUAL);
          }
         */
        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        /*
          if ($Action == "ActualizarForm") {


          //var_dump($FechaHoraRegistro);exit;

          $DataSet_PROY_COMP_INDIC_ANUAL = array();
          $Objeto_PROY_COMP_INDIC_ANUAL_DAO = new PROY_COMP_INDIC_ANUAL_DAO();

          $lstparametrosM['SeleccionarID'] = $SeleccionarID;
          if (strlen(rtrim($IDE_COMPONENTE_PLAN)) > 0) {
          $lstparametrosM['IDE_COMPONENTE_PLAN'] = $IDE_COMPONENTE_PLAN;
          }
          if (strlen(rtrim($IDE_INDICADOR)) > 0) {
          $lstparametrosM['IDE_INDICADOR'] = $IDE_INDICADOR;
          }
          if (strlen(rtrim($IDE_COMP_ACTIVIDAD)) > 0) {
          $lstparametrosM['IDE_COMP_ACTIVIDAD'] = $IDE_COMP_ACTIVIDAD;
          }
          if (strlen(rtrim($COD_ANHO)) > 0) {
          $lstparametrosM['COD_ANHO'] = $COD_ANHO;
          }
          if (strlen(rtrim($NUM_VALOR)) > 0) {
          $lstparametrosM['NUM_VALOR'] = $NUM_VALOR;
          }
          if (strlen(rtrim($EST_COMP_INDIC_ANUAL)) > 0) {
          $lstparametrosM['EST_COMP_INDIC_ANUAL'] = $EST_COMP_INDIC_ANUAL;
          }
          $lstparametrosM['Usuario'] = $usuario;
          $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
          $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

          $procedure_parametrosMS = array(
          array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['IDE_COMPONENTE_PLAN'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['IDE_INDICADOR'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['IDE_COMP_ACTIVIDAD'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['COD_ANHO'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['NUM_VALOR'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['EST_COMP_INDIC_ANUAL'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
          , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
          );
          $Objeto_PROY_COMP_INDIC_ANUAL_DAO->Update_PROY_COMP_INDIC_ANUAL($DataSet_PROY_COMP_INDIC_ANUAL, $procedure_parametrosMS);   //JCMY

          $CodMensaje = $procedure_parametrosMS[8][0];

          $mensaje = $procedure_parametrosMS[9][0];

          $lCollection->Add('CodMensaje', $CodMensaje);
          $lCollection->Add('Mensaje', $mensaje);
          }
         */

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */

        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_COMP_INDIC_ANUAL = array();
            $Objeto_PROY_COMP_INDIC_ANUAL_DAO = new PROY_COMP_INDIC_ANUAL_DAO();
            $lstparametrosM = array();
            //$lstparametrosM['SeleccionarID'] = $SeleccionarID;
//            if (strlen(rtrim($IDE_COMPONENTE_PLAN)) > 0) {
                $lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
//            }
//            if (strlen(rtrim($IDE_INDICADOR)) > 0) {
                $lstparametrosM['IDE_INDICADOR'] = $IDE_INDICADOR;
//            }
//            if (strlen(rtrim($COD_ANHO)) > 0) {
                $lstparametrosM['COD_ANHO'] = $COD_ANHO;
//            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);
            $procedure_parametrosMS = array(
                //array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_INDICADOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ANHO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMP_INDIC_ANUAL_DAO->Delete_PROY_COMP_INDIC_ANUAL($DataSet_PROY_COMP_INDIC_ANUAL, $procedure_parametrosMS);  
//            var_dump($procedure_parametrosMS); 
//            echo $IDE_COMPONENTE_PLAN .'-'. $IDE_INDICADOR .'-'. $COD_ANHO;
            //echo 'SeleccionarID:' . $SeleccionarID;
            //exit; //JCMY
            $CodMensaje = $procedure_parametrosMS[4][0];
            $mensaje = $procedure_parametrosMS[5][0];
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }


        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);



        /*         * ******************************************************************************
         *          SECCION DE CODIGO PARA LAS LISTAS DEPLEGABLES O COMBOS
          /****************************************************************************** */


        /* 					 
          $DataSet_PROY_COMPONENTE_PLAN_1 = array();
          $Objeto_IDE_COMPONENTE_PLAN_DAO = new PROY_COMPONENTE_PLAN_DAO();
          $lstparametrosM = array();
          $lstparametrosM['campos'] = "IDE_COMPONENTE_PLAN,DES_PLAN";
          $lstparametrosM['filtro'] = " AND IDE_PROY_COMPONENTE = '$PIDE_PROY_COMPONENTE' ";

          $procedure_parametrosMS = array(
          array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
          );

          $Objeto_IDE_COMPONENTE_PLAN_DAO->SelCampos_PROY_COMPONENTE_PLAN2($DataSet_PROY_COMPONENTE_PLAN_1, $procedure_parametrosMS);
          $lCollection->Add('DataSet_PROY_COMPONENTE_PLAN_1', $DataSet_PROY_COMPONENTE_PLAN_1);

         */
        /*
          $DataSet_PROY_COMP_ACTIVIDAD_1 = array();
          $Objeto_IDE_COMP_ACTIVIDAD_DAO = new PROY_COMP_ACTIVIDAD_DAO();
          $lstparametrosM = array();
          $lstparametrosM['campos'] = "IDE_COMP_ACTIVIDAD,NUM_DIAS";
          $lstparametrosM['filtro'] = "";

          $procedure_parametrosMS = array(
          array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
          , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
          );

          $Objeto_IDE_COMP_ACTIVIDAD_DAO->SelCampos_PROY_COMP_ACTIVIDAD($DataSet_PROY_COMP_ACTIVIDAD_1, $procedure_parametrosMS);
          $lCollection->Add('DataSet_PROY_COMP_ACTIVIDAD_1', $DataSet_PROY_COMP_ACTIVIDAD_1);
         */
        /* 					 */

        /* 					 */

        $DataSet_GEN_INDICADOR_1 = array();
        $Objeto_IDE_INDICADOR_DAO = new GEN_INDICADOR_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INDICADOR,DES_INDICADOR";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_INDICADOR_DAO->SelCampos_GEN_INDICADOR($DataSet_GEN_INDICADOR_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INDICADOR_1', $DataSet_GEN_INDICADOR_1);

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_COMP_INDIC_ANUAL_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_COMP_INDIC_ANUAL_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        $lCollection->Add('PIDE_PROY_COMPONENTE', $PIDE_PROY_COMPONENTE);


        /* EDGAR */
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID, $usuario, $PermisosPerfil));
        $lCollection->Add('crudEliminar', crudEliminar($usuario, $PermisosPerfil));
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;