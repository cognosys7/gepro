<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_POSTORESLN de la tabla PROC_POSTORES
  //  Fecha           : miércoles, 08 de noviembre de 2017 05:04:38 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROC_POSTORESDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PROC_ITEMDAO.php");



require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROC_POSTORES";
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


        $PIDE_PROC_ITEM = isset($_REQUEST['PIDE_PROC_ITEM']) ? VerificarInputs($_REQUEST['PIDE_PROC_ITEM']) : "";


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_POSTOR = isset($_REQUEST['IDE_POSTOR']) ? VerificarInputs($_REQUEST['IDE_POSTOR']) : "";
        $IDE_PROC_ITEM = isset($_REQUEST['IDE_PROC_ITEM']) ? VerificarInputs($_REQUEST['IDE_PROC_ITEM']) : "";
        $RUC_POSTOR = isset($_REQUEST['RUC_POSTOR']) ? VerificarInputs($_REQUEST['RUC_POSTOR']) : "";
        $DES_POSTOR = isset($_REQUEST['DES_POSTOR']) ? VerificarInputs($_REQUEST['DES_POSTOR']) : "";
        $TIP_POSTOR = isset($_REQUEST['TIP_POSTOR']) ? VerificarInputs($_REQUEST['TIP_POSTOR']) : "";
        $VAL_REFERENCIAL_ITEM = isset($_REQUEST['VAL_REFERENCIAL_ITEM']) ? VerificarInputs($_REQUEST['VAL_REFERENCIAL_ITEM']) : "";
        $VAL_OFERTADO_ITEM = isset($_REQUEST['VAL_OFERTADO_ITEM']) ? VerificarInputs($_REQUEST['VAL_OFERTADO_ITEM']) : "";
        $EST_POSTOR = isset($_REQUEST['EST_POSTOR']) ? VerificarInputs($_REQUEST['EST_POSTOR']) : "";
        $FEC_REG_PROPUESTA = isset($_REQUEST['FEC_REG_PROPUESTA']) ? VerificarInputs($_REQUEST['FEC_REG_PROPUESTA']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND PP.IDE_PROC_ITEM=$PIDE_PROC_ITEM";



        $DataSet_PROC_ITEM_1 = array();
        $Objeto_IDE_PROC_ITEM_DAO = new PROC_ITEM_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "						  COD_PROYECTO,						  DES_ITEM,						  IMP_VAL_REFERENCIAL_ITEM				";
        $lstparametrosM['filtro'] = " AND IDE_PROC_ITEM = '$PIDE_PROC_ITEM'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PROC_ITEM_DAO->SelCampos_PROC_ITEM($DataSet_PROC_ITEM_1, $procedure_parametrosMS);


        $VCOD_PROYECTO = $DataSet_PROC_ITEM_1[0]->COD_PROYECTO;
        $lCollection->Add('VCOD_PROYECTO', $VCOD_PROYECTO);
        $VDES_ITEM = $DataSet_PROC_ITEM_1[0]->DES_ITEM;
        $lCollection->Add('VDES_ITEM', $VDES_ITEM);
        $VIMP_VAL_REFERENCIAL_ITEM = $DataSet_PROC_ITEM_1[0]->IMP_VAL_REFERENCIAL_ITEM;
        $lCollection->Add('VIMP_VAL_REFERENCIAL_ITEM', $VIMP_VAL_REFERENCIAL_ITEM);



        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROC_POSTORES_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'RUC_POSTOR') {
                        $_POST['qtype'] = 'PP.RUC_POSTOR';
                    }
                    if ($_POST['qtype'] == 'DES_POSTOR') {
                        $_POST['qtype'] = 'PP.DES_POSTOR';
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
            $ogridDAO->Count_PROC_POSTORES($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_POSTOR;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROC_POSTORES', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_REG_PROPUESTA) > 0) {
                $FEC_REG_PROPUESTA = cambiafecha($FEC_REG_PROPUESTA);
            } else {
                $FEC_REG_PROPUESTA = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROC_POSTORESM = array();
            $Objeto_PROC_POSTORES_DAO = new PROC_POSTORES_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_POSTOR)) > 0) {
                $lstparametrosM['IDE_POSTOR'] = $IDE_POSTOR;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($RUC_POSTOR)) > 0) {
                $lstparametrosM['RUC_POSTOR'] = $RUC_POSTOR;
            }
            if (strlen(rtrim($DES_POSTOR)) > 0) {
                $lstparametrosM['DES_POSTOR'] = $DES_POSTOR;
            }
            if (strlen(rtrim($TIP_POSTOR)) > 0) {
                $lstparametrosM['TIP_POSTOR'] = $TIP_POSTOR;
            }
            if (strlen(rtrim($VAL_REFERENCIAL_ITEM)) > 0) {
                $lstparametrosM['VAL_REFERENCIAL_ITEM'] = $VAL_REFERENCIAL_ITEM;
            }
            if (strlen(rtrim($VAL_OFERTADO_ITEM)) > 0) {
                $lstparametrosM['VAL_OFERTADO_ITEM'] = $VAL_OFERTADO_ITEM;
            }
            if (strlen(rtrim($EST_POSTOR)) > 0) {
                $lstparametrosM['EST_POSTOR'] = $EST_POSTOR;
            }
//            var_dump($FEC_REG_PROPUESTA);exit;
            if (strlen(rtrim($FEC_REG_PROPUESTA)) > 0) {
                $lstparametrosM['FEC_REG_PROPUESTA'] = $FEC_REG_PROPUESTA;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['RUC_POSTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_POSTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_POSTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['VAL_REFERENCIAL_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['VAL_OFERTADO_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_POSTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_REG_PROPUESTA'], SQLSRV_PARAM_IN), 
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_POSTORES_DAO->Insert_PROC_POSTORES($DataSet_PROC_POSTORES, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[9][0];

            $mensaje = $procedure_parametrosMS[10][0];

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
            $DataSet_PROC_POSTORES = array();
            $Objeto_PROC_POSTORES_DAO = new PROC_POSTORES_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROC_POSTORES_DAO->SelPk_PROC_POSTORES($DataSet_PROC_POSTORES, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROC_POSTORES) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROC_POSTORES

                $IDE_POSTOR = $DataSet_PROC_POSTORES[0]->IDE_POSTOR;
                $IDE_PROC_ITEM = $DataSet_PROC_POSTORES[0]->IDE_PROC_ITEM;
                $RUC_POSTOR = $DataSet_PROC_POSTORES[0]->RUC_POSTOR;
                $DES_POSTOR = $DataSet_PROC_POSTORES[0]->DES_POSTOR;
                $TIP_POSTOR = $DataSet_PROC_POSTORES[0]->TIP_POSTOR;
                $VAL_REFERENCIAL_ITEM = $DataSet_PROC_POSTORES[0]->VAL_REFERENCIAL_ITEM;
                $VAL_OFERTADO_ITEM = $DataSet_PROC_POSTORES[0]->VAL_OFERTADO_ITEM;
                $EST_POSTOR = $DataSet_PROC_POSTORES[0]->EST_POSTOR;
                $FEC_REG_PROPUESTA = $DataSet_PROC_POSTORES[0]->FEC_REG_PROPUESTA;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_POSTOR', $IDE_POSTOR);
            $lCollection->Add('IDE_PROC_ITEM', $IDE_PROC_ITEM);
            $lCollection->Add('RUC_POSTOR', $RUC_POSTOR);
            $lCollection->Add('DES_POSTOR', $DES_POSTOR);
            $lCollection->Add('TIP_POSTOR', $TIP_POSTOR);
            $lCollection->Add('VAL_REFERENCIAL_ITEM', $VAL_REFERENCIAL_ITEM);
            $lCollection->Add('VAL_OFERTADO_ITEM', $VAL_OFERTADO_ITEM);
            $lCollection->Add('EST_POSTOR', $EST_POSTOR);
            $lCollection->Add('FEC_REG_PROPUESTA', $FEC_REG_PROPUESTA);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_REG_PROPUESTA) > 0) {
                $FEC_REG_PROPUESTA = cambiafecha($FEC_REG_PROPUESTA);
            } else {
                $FEC_REG_PROPUESTA = null;
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROC_POSTORES = array();
            $Objeto_PROC_POSTORES_DAO = new PROC_POSTORES_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_POSTOR)) > 0) {
                $lstparametrosM['IDE_POSTOR'] = $IDE_POSTOR;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($RUC_POSTOR)) > 0) {
                $lstparametrosM['RUC_POSTOR'] = $RUC_POSTOR;
            }
            if (strlen(rtrim($DES_POSTOR)) > 0) {
                $lstparametrosM['DES_POSTOR'] = $DES_POSTOR;
            }
            if (strlen(rtrim($TIP_POSTOR)) > 0) {
                $lstparametrosM['TIP_POSTOR'] = $TIP_POSTOR;
            }
            if (strlen(rtrim($VAL_REFERENCIAL_ITEM)) > 0) {
                $lstparametrosM['VAL_REFERENCIAL_ITEM'] = $VAL_REFERENCIAL_ITEM;
            }
            if (strlen(rtrim($VAL_OFERTADO_ITEM)) > 0) {
                $lstparametrosM['VAL_OFERTADO_ITEM'] = $VAL_OFERTADO_ITEM;
            }
            if (strlen(rtrim($EST_POSTOR)) > 0) {
                $lstparametrosM['EST_POSTOR'] = $EST_POSTOR;
            }
            if (strlen(rtrim($FEC_REG_PROPUESTA)) > 0) {
                $lstparametrosM['FEC_REG_PROPUESTA'] = $FEC_REG_PROPUESTA;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)                
                , array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['RUC_POSTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_POSTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_POSTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['VAL_REFERENCIAL_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['VAL_OFERTADO_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_POSTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_REG_PROPUESTA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_POSTORES_DAO->Update_PROC_POSTORES($DataSet_PROC_POSTORES, $procedure_parametrosMS);   //JCMY
            $CodMensaje = $procedure_parametrosMS[10][0];
            $mensaje = $procedure_parametrosMS[11][0];
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROC_POSTORES = array();
            $Objeto_PROC_POSTORES_DAO = new PROC_POSTORES_DAO();
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
            $Objeto_PROC_POSTORES_DAO->Delete_PROC_POSTORES($DataSet_PROC_POSTORES, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_POSTOR_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '3'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_POSTOR_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_POSTOR_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_POSTOR_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */
        $lCollection->Add('PIDE_PROC_ITEM', $PIDE_PROC_ITEM);
        
        /* EDGAR */
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

