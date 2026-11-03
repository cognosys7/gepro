<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Prop�sito       : PLANLN de la tabla PLAN
  //  Fecha           : viernes, 5 de enero de 2018 14:49:51
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLANDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_DIRECTORIODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PLAN";
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

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_DIRECTORIO = isset($_REQUEST['IDE_DIRECTORIO']) ? VerificarInputs($_REQUEST['IDE_DIRECTORIO']) : "";
        $IDE_ENTIDAD_SOLICITANTE = isset($_REQUEST['IDE_ENTIDAD_SOLICITANTE']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD_SOLICITANTE']) : "";
        $IDE_ENTIDAD_EJECUTORA = isset($_REQUEST['IDE_ENTIDAD_EJECUTORA']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD_EJECUTORA']) : "";
        $IDE_INTERVENCION = isset($_REQUEST['IDE_INTERVENCION']) ? VerificarInputs($_REQUEST['IDE_INTERVENCION']) : "";
        $TIP_PLAN = isset($_REQUEST['TIP_PLAN']) ? VerificarInputs($_REQUEST['TIP_PLAN']) : "";
        $COD_PLAN = isset($_REQUEST['COD_PLAN']) ? VerificarInputs($_REQUEST['COD_PLAN']) : "";
        $DES_PLAN = isset($_REQUEST['DES_PLAN']) ? VerificarInputs($_REQUEST['DES_PLAN']) : "";
        $TIP_FUENTE = isset($_REQUEST['TIP_FUENTE']) ? VerificarInputs($_REQUEST['TIP_FUENTE']) : "";
        $IMP_APROBADO = isset($_REQUEST['IMP_APROBADO']) ? VerificarInputs($_REQUEST['IMP_APROBADO']) : "";
        $TIP_GASTO = isset($_REQUEST['TIP_GASTO']) ? VerificarInputs($_REQUEST['TIP_GASTO']) : "";
        $EST_PLAN = isset($_REQUEST['EST_PLAN']) ? VerificarInputs($_REQUEST['EST_PLAN']) : "";
        $DES_ALCANCE = isset($_REQUEST['DES_ALCANCE']) ? VerificarInputs($_REQUEST['DES_ALCANCE']) : "";
        $DES_OBSERVACION = isset($_REQUEST['DES_OBSERVACION']) ? VerificarInputs($_REQUEST['DES_OBSERVACION']) : "";
        $FEC_OBSERVACION = isset($_REQUEST['FEC_OBSERVACION']) ? VerificarInputs($_REQUEST['FEC_OBSERVACION']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PLAN_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'CodPlan') {
                        $_POST['qtype'] = 'PLN.COD_PLAN';
                    }
                    if ($_POST['qtype'] == 'DescripcionPlan') {
                        $_POST['qtype'] = 'PLN.DES_PLAN';
                    }
                    if ($_POST['qtype'] == 'TipoPlan') {
                        $_POST['qtype'] = 'TIPPLAN.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'Intervencion') {
                        $_POST['qtype'] = 'ITV.DES_INTERVENCION';
                    }
                    if ($_POST['qtype'] == 'EntidadSolicitante') {
                        $_POST['qtype'] = 'RTRIM(ENTSOL.DES_ABREVIATURA)';
                    }
                    if ($_POST['qtype'] == 'TipoFuente') {
                        $_POST['qtype'] = 'TIPFTE.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'EstadoPlan') {
                        $_POST['qtype'] = 'ESTPLN.DES_ITEM';
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
            $ogridDAO->Count_PLAN($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PLAN;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PLAN', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_OBSERVACION) > 0) {
                $FEC_OBSERVACION = cambiafecha($FEC_OBSERVACION);
            } else {
                $FEC_OBSERVACION = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PLANM = array();
            $Objeto_PLAN_DAO = new PLAN_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_DIRECTORIO)) > 0) {
                $lstparametrosM['IDE_DIRECTORIO'] = $IDE_DIRECTORIO;
            }
            if (strlen(rtrim($IDE_ENTIDAD_SOLICITANTE)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_SOLICITANTE'] = $IDE_ENTIDAD_SOLICITANTE;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($TIP_PLAN)) > 0) {
                $lstparametrosM['TIP_PLAN'] = $TIP_PLAN;
            }
            if (strlen(rtrim($COD_PLAN)) > 0) {
                $lstparametrosM['COD_PLAN'] = $COD_PLAN;
            }
            if (strlen(rtrim($DES_PLAN)) > 0) {
                $lstparametrosM['DES_PLAN'] = $DES_PLAN;
            }
            if (strlen(rtrim($TIP_FUENTE)) > 0) {
                $lstparametrosM['TIP_FUENTE'] = $TIP_FUENTE;
            }
            if (strlen(rtrim($IMP_APROBADO)) > 0) {
                $lstparametrosM['IMP_APROBADO'] = $IMP_APROBADO;
            }
            if (strlen(rtrim($TIP_GASTO)) > 0) {
                $lstparametrosM['TIP_GASTO'] = $TIP_GASTO;
            }
            if (strlen(rtrim($EST_PLAN)) > 0) {
                $lstparametrosM['EST_PLAN'] = $EST_PLAN;
            }
            if (strlen(rtrim($DES_ALCANCE)) > 0) {
                $lstparametrosM['DES_ALCANCE'] = $DES_ALCANCE;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($FEC_OBSERVACION)) > 0) {
                $lstparametrosM['FEC_OBSERVACION'] = $FEC_OBSERVACION;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_DIRECTORIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTIDAD_SOLICITANTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_FUENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_APROBADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_GASTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ALCANCE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_OBSERVACION'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_DAO->Insert_PLAN($DataSet_PLAN, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[15][0];

            $mensaje = $procedure_parametrosMS[16][0];

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
            $DataSet_PLAN = array();
            $Objeto_PLAN_DAO = new PLAN_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PLAN_DAO->SelPk_PLAN($DataSet_PLAN, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PLAN) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PLAN

                $IDE_DIRECTORIO = $DataSet_PLAN[0]->IDE_DIRECTORIO;
                $IDE_ENTIDAD_SOLICITANTE = $DataSet_PLAN[0]->IDE_ENTIDAD_SOLICITANTE;
                $IDE_ENTIDAD_EJECUTORA = $DataSet_PLAN[0]->IDE_ENTIDAD_EJECUTORA;
                $IDE_INTERVENCION = $DataSet_PLAN[0]->IDE_INTERVENCION;
                $TIP_PLAN = $DataSet_PLAN[0]->TIP_PLAN;
                $COD_PLAN = $DataSet_PLAN[0]->COD_PLAN;
                $DES_PLAN = $DataSet_PLAN[0]->DES_PLAN;
                $TIP_FUENTE = $DataSet_PLAN[0]->TIP_FUENTE;
                $IMP_APROBADO = $DataSet_PLAN[0]->IMP_APROBADO;
                $TIP_GASTO = $DataSet_PLAN[0]->TIP_GASTO;
                $EST_PLAN = $DataSet_PLAN[0]->EST_PLAN;
                $DES_ALCANCE = $DataSet_PLAN[0]->DES_ALCANCE;
                $DES_OBSERVACION = $DataSet_PLAN[0]->DES_OBSERVACION;
                $FEC_OBSERVACION = $DataSet_PLAN[0]->FEC_OBSERVACION;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_DIRECTORIO', $IDE_DIRECTORIO);
            $lCollection->Add('IDE_ENTIDAD_SOLICITANTE', $IDE_ENTIDAD_SOLICITANTE);
            $lCollection->Add('IDE_ENTIDAD_EJECUTORA', $IDE_ENTIDAD_EJECUTORA);
            $lCollection->Add('IDE_INTERVENCION', $IDE_INTERVENCION);
            $lCollection->Add('TIP_PLAN', $TIP_PLAN);
            $lCollection->Add('COD_PLAN', $COD_PLAN);
            $lCollection->Add('DES_PLAN', $DES_PLAN);
            $lCollection->Add('TIP_FUENTE', $TIP_FUENTE);
            $lCollection->Add('IMP_APROBADO', $IMP_APROBADO);
            $lCollection->Add('TIP_GASTO', $TIP_GASTO);
            $lCollection->Add('EST_PLAN', $EST_PLAN);
            $lCollection->Add('DES_ALCANCE', $DES_ALCANCE);
            $lCollection->Add('DES_OBSERVACION', $DES_OBSERVACION);
            $lCollection->Add('FEC_OBSERVACION', $FEC_OBSERVACION);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_OBSERVACION) > 0) {
                $FEC_OBSERVACION = cambiafecha($FEC_OBSERVACION);
            } else {
                $FEC_OBSERVACION = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PLAN = array();
            $Objeto_PLAN_DAO = new PLAN_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_DIRECTORIO)) > 0) {
                $lstparametrosM['IDE_DIRECTORIO'] = $IDE_DIRECTORIO;
            }
            if (strlen(rtrim($IDE_ENTIDAD_SOLICITANTE)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_SOLICITANTE'] = $IDE_ENTIDAD_SOLICITANTE;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($TIP_PLAN)) > 0) {
                $lstparametrosM['TIP_PLAN'] = $TIP_PLAN;
            }
            if (strlen(rtrim($COD_PLAN)) > 0) {
                $lstparametrosM['COD_PLAN'] = $COD_PLAN;
            }
            if (strlen(rtrim($DES_PLAN)) > 0) {
                $lstparametrosM['DES_PLAN'] = $DES_PLAN;
            }
            if (strlen(rtrim($TIP_FUENTE)) > 0) {
                $lstparametrosM['TIP_FUENTE'] = $TIP_FUENTE;
            }
            if (strlen(rtrim($IMP_APROBADO)) > 0) {
                $lstparametrosM['IMP_APROBADO'] = $IMP_APROBADO;
            }
            if (strlen(rtrim($TIP_GASTO)) > 0) {
                $lstparametrosM['TIP_GASTO'] = $TIP_GASTO;
            }
            if (strlen(rtrim($EST_PLAN)) > 0) {
                $lstparametrosM['EST_PLAN'] = $EST_PLAN;
            }
            if (strlen(rtrim($DES_ALCANCE)) > 0) {
                $lstparametrosM['DES_ALCANCE'] = $DES_ALCANCE;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($FEC_OBSERVACION)) > 0) {
                $lstparametrosM['FEC_OBSERVACION'] = $FEC_OBSERVACION;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_DIRECTORIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD_SOLICITANTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_FUENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_APROBADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ALCANCE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_DAO->Update_PLAN($DataSet_PLAN, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[16][0];

            $mensaje = $procedure_parametrosMS[17][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PLAN = array();
            $Objeto_PLAN_DAO = new PLAN_DAO();
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
            $Objeto_PLAN_DAO->Delete_PLAN($DataSet_PLAN, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_DIRECTORIO_1 = array();
        $Objeto_IDE_DIRECTORIO_DAO = new GEN_DIRECTORIO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_DIRECTORIO,DES_DIRECTORIO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_DIRECTORIO_DAO->SelCampos_GEN_DIRECTORIO($DataSet_GEN_DIRECTORIO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_DIRECTORIO_1', $DataSet_GEN_DIRECTORIO_1);

        /* 					 */

        $DataSet_GEN_ENTIDAD_1 = array();
        $Objeto_IDE_ENTIDAD_SOLICITANTE_DAO = new GEN_ENTIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD,DES_ENTIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ENTIDAD_SOLICITANTE_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTIDAD_1', $DataSet_GEN_ENTIDAD_1);

        /* 					 */

        $DataSet_GEN_ENTIDAD_2 = array();
        $Objeto_IDE_ENTIDAD_EJECUTORA_DAO = new GEN_ENTIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD,DES_ENTIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ENTIDAD_EJECUTORA_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTIDAD_2', $DataSet_GEN_ENTIDAD_2);

        /* 					 */

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = "AND NUM_NIVEL=2";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_INTERVENCION_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_PLAN_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA = '14'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PLAN_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_FUENTE_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA = '15'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_FUENTE_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_TIP_GASTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA = '16'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_GASTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_EST_PLAN_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA = '17'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PLAN_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
    }
}

//var_dump($lstDepartamento);exit;
