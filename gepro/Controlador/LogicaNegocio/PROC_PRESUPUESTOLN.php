<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_PRESUPUESTOLN de la tabla PROC_PRESUPUESTO
  //  Fecha           : viernes, 10 de noviembre de 2017 09:53:57 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROC_PRESUPUESTODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PROC_ITEMDAO.php");



require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA   
    $PaginaFormulario = "PROC_PRESUPUESTO";
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

        $PIDE_CONVOCATORIA = isset($_REQUEST['PIDE_CONVOCATORIA']) ? VerificarInputs($_REQUEST['PIDE_CONVOCATORIA']) : "";
        $PIDE_PROC_ITEM = isset($_REQUEST['PIDE_PROC_ITEM']) ? VerificarInputs($_REQUEST['PIDE_PROC_ITEM']) : "";


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PRESUPUESTO = isset($_REQUEST['IDE_PRESUPUESTO']) ? VerificarInputs($_REQUEST['IDE_PRESUPUESTO']) : "";
        $IDE_CONVOCATORIA = isset($_REQUEST['PIDE_CONVOCATORIA']) ? VerificarInputs($_REQUEST['PIDE_CONVOCATORIA']) : "";
        $IDE_PROC_ITEM = isset($_REQUEST['IDE_PROC_ITEM']) ? VerificarInputs($_REQUEST['PIDE_PROC_ITEM']) : "";
        $SEC_FUNC = isset($_REQUEST['SEC_FUNC']) ? VerificarInputs($_REQUEST['SEC_FUNC']) : "";
        $COD_FTE_FTO = isset($_REQUEST['COD_FTE_FTO']) ? VerificarInputs($_REQUEST['COD_FTE_FTO']) : "";
        $COD_ESPECIFICA_GASTO = isset($_REQUEST['COD_ESPECIFICA_GASTO']) ? VerificarInputs($_REQUEST['COD_ESPECIFICA_GASTO']) : "";
        $COD_CERTIFICADO_PRES = isset($_REQUEST['COD_CERTIFICADO_PRES']) ? VerificarInputs($_REQUEST['COD_CERTIFICADO_PRES']) : "";
        $SEC_EJEC = isset($_REQUEST['SEC_EJEC']) ? VerificarInputs($_REQUEST['SEC_EJEC']) : "";
        $COD_EXPEDIENTE_SIAF = isset($_REQUEST['COD_EXPEDIENTE_SIAF']) ? VerificarInputs($_REQUEST['COD_EXPEDIENTE_SIAF']) : "";
        $DES_FTE_FTO = isset($_REQUEST['DES_FTE_FTO']) ? VerificarInputs($_REQUEST['DES_FTE_FTO']) : "";
        $DES_ESPECIFICA_GASTO = isset($_REQUEST['DES_ESPECIFICA_GASTO']) ? VerificarInputs($_REQUEST['DES_ESPECIFICA_GASTO']) : "";
        $IMP_CERTIFICADO_PRES = isset($_REQUEST['IMP_CERTIFICADO_PRES']) ? VerificarInputs($_REQUEST['IMP_CERTIFICADO_PRES']) : "";
        $USER_INSERT = isset($_REQUEST['USER_INSERT']) ? VerificarInputs($_REQUEST['USER_INSERT']) : "";
        $FECHA_INSERT = isset($_REQUEST['FECHA_INSERT']) ? VerificarInputs($_REQUEST['FECHA_INSERT']) : "";
        $USER_UPDATE = isset($_REQUEST['USER_UPDATE']) ? VerificarInputs($_REQUEST['USER_UPDATE']) : "";
        $FECHA_UPDATE = isset($_REQUEST['FECHA_UPDATE']) ? VerificarInputs($_REQUEST['FECHA_UPDATE']) : "";
        $EST_PROC_PRESUPUESTO = isset($_REQUEST['EST_PROC_PRESUPUESTO']) ? VerificarInputs($_REQUEST['EST_PROC_PRESUPUESTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND IDE_PROC_ITEM=$PIDE_PROC_ITEM";



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
            $ogridDAO = new PROC_PRESUPUESTO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'SEC_FUNC') {
                        $_POST['qtype'] = 'PP.SEC_FUNC';
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
            $ogridDAO->Count_PROC_PRESUPUESTO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PRESUPUESTO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROC_PRESUPUESTO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FECHA_INSERT) > 0) {
                $FECHA_INSERT = cambiafecha($FECHA_INSERT);
            } else {
                $FECHA_INSERT = "";
            }
            if (strlen($FECHA_UPDATE) > 0) {
                $FECHA_UPDATE = cambiafecha($FECHA_UPDATE);
            } else {
                $FECHA_UPDATE = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROC_PRESUPUESTOM = array();
            $Objeto_PROC_PRESUPUESTO_DAO = new PROC_PRESUPUESTO_DAO();
            $lstparametrosM = array();            
            if (strlen(rtrim($IDE_CONVOCATORIA)) > 0) {
                $lstparametrosM['IDE_CONVOCATORIA'] = $IDE_CONVOCATORIA;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($SEC_FUNC)) > 0) {
                $lstparametrosM['SEC_FUNC'] = $SEC_FUNC;
            }
            if (strlen(rtrim($COD_FTE_FTO)) > 0) {
                $lstparametrosM['COD_FTE_FTO'] = $COD_FTE_FTO;
            }
            if (strlen(rtrim($COD_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['COD_ESPECIFICA_GASTO'] = $COD_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($COD_CERTIFICADO_PRES)) > 0) {
                $lstparametrosM['COD_CERTIFICADO_PRES'] = $COD_CERTIFICADO_PRES;
            }
            if (strlen(rtrim($SEC_EJEC)) > 0) {
                $lstparametrosM['SEC_EJEC'] = $SEC_EJEC;
            }
            if (strlen(rtrim($COD_EXPEDIENTE_SIAF)) > 0) {
                $lstparametrosM['COD_EXPEDIENTE_SIAF'] = $COD_EXPEDIENTE_SIAF;
            }
            if (strlen(rtrim($DES_FTE_FTO)) > 0) {
                $lstparametrosM['DES_FTE_FTO'] = $DES_FTE_FTO;
            }
            if (strlen(rtrim($DES_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['DES_ESPECIFICA_GASTO'] = $DES_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($IMP_CERTIFICADO_PRES)) > 0) {
                $lstparametrosM['IMP_CERTIFICADO_PRES'] = $IMP_CERTIFICADO_PRES;
            }
            if (strlen(rtrim($USER_INSERT)) > 0) {
                $lstparametrosM['USER_INSERT'] = $USER_INSERT;
            }
            if (strlen(rtrim($FECHA_INSERT)) > 0) {
                $lstparametrosM['FECHA_INSERT'] = $FECHA_INSERT;
            }
            if (strlen(rtrim($USER_UPDATE)) > 0) {
                $lstparametrosM['USER_UPDATE'] = $USER_UPDATE;
            }
            if (strlen(rtrim($FECHA_UPDATE)) > 0) {
                $lstparametrosM['FECHA_UPDATE'] = $FECHA_UPDATE;
            }
            if (strlen(rtrim($EST_PROC_PRESUPUESTO)) > 0) {
                $lstparametrosM['EST_PROC_PRESUPUESTO'] = $EST_PROC_PRESUPUESTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(                
                array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['SEC_FUNC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_FTE_FTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_CERTIFICADO_PRES'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['SEC_EJEC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_EXPEDIENTE_SIAF'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_FTE_FTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_CERTIFICADO_PRES'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROC_PRESUPUESTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_PRESUPUESTO_DAO->Insert_PROC_PRESUPUESTO($DataSet_PROC_PRESUPUESTO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[13][0];

            $mensaje = $procedure_parametrosMS[14][0];

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
            $DataSet_PROC_PRESUPUESTO = array();
            $Objeto_PROC_PRESUPUESTO_DAO = new PROC_PRESUPUESTO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROC_PRESUPUESTO_DAO->SelPk_PROC_PRESUPUESTO($DataSet_PROC_PRESUPUESTO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROC_PRESUPUESTO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROC_PRESUPUESTO               
                $IDE_CONVOCATORIA = $DataSet_PROC_PRESUPUESTO[0]->IDE_CONVOCATORIA;
                $IDE_PROC_ITEM = $DataSet_PROC_PRESUPUESTO[0]->IDE_PROC_ITEM;
                $SEC_FUNC = $DataSet_PROC_PRESUPUESTO[0]->SEC_FUNC;
                $COD_FTE_FTO = $DataSet_PROC_PRESUPUESTO[0]->COD_FTE_FTO;
                $COD_ESPECIFICA_GASTO = $DataSet_PROC_PRESUPUESTO[0]->COD_ESPECIFICA_GASTO;
                $COD_CERTIFICADO_PRES = $DataSet_PROC_PRESUPUESTO[0]->COD_CERTIFICADO_PRES;
                $SEC_EJEC = $DataSet_PROC_PRESUPUESTO[0]->SEC_EJEC;
                $COD_EXPEDIENTE_SIAF = $DataSet_PROC_PRESUPUESTO[0]->COD_EXPEDIENTE_SIAF;
                $DES_FTE_FTO = $DataSet_PROC_PRESUPUESTO[0]->DES_FTE_FTO;
                $DES_ESPECIFICA_GASTO = $DataSet_PROC_PRESUPUESTO[0]->DES_ESPECIFICA_GASTO;
                $IMP_CERTIFICADO_PRES = $DataSet_PROC_PRESUPUESTO[0]->IMP_CERTIFICADO_PRES;                
                $EST_PROC_PRESUPUESTO = $DataSet_PROC_PRESUPUESTO[0]->EST_PROC_PRESUPUESTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);            
            $lCollection->Add('IDE_CONVOCATORIA', $PIDE_CONVOCATORIA);
            $lCollection->Add('IDE_PROC_ITEM', $IDE_PROC_ITEM);
            $lCollection->Add('SEC_FUNC', $SEC_FUNC);
            $lCollection->Add('COD_FTE_FTO', $COD_FTE_FTO);
            $lCollection->Add('COD_ESPECIFICA_GASTO', $COD_ESPECIFICA_GASTO);
            $lCollection->Add('COD_CERTIFICADO_PRES', $COD_CERTIFICADO_PRES);
            $lCollection->Add('SEC_EJEC', $SEC_EJEC);
            $lCollection->Add('COD_EXPEDIENTE_SIAF', $COD_EXPEDIENTE_SIAF);
            $lCollection->Add('DES_FTE_FTO', $DES_FTE_FTO);
            $lCollection->Add('DES_ESPECIFICA_GASTO', $DES_ESPECIFICA_GASTO);
            $lCollection->Add('IMP_CERTIFICADO_PRES', $IMP_CERTIFICADO_PRES);
            $lCollection->Add('EST_PROC_PRESUPUESTO', $EST_PROC_PRESUPUESTO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FECHA_INSERT) > 0) {
                $FECHA_INSERT = cambiafecha($FECHA_INSERT);
            } else {
                $FECHA_INSERT = "";
            }
            if (strlen($FECHA_UPDATE) > 0) {
                $FECHA_UPDATE = cambiafecha($FECHA_UPDATE);
            } else {
                $FECHA_UPDATE = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROC_PRESUPUESTO = array();
            $Objeto_PROC_PRESUPUESTO_DAO = new PROC_PRESUPUESTO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PRESUPUESTO)) > 0) {
                $lstparametrosM['IDE_PRESUPUESTO'] = $IDE_PRESUPUESTO;
            }
            if (strlen(rtrim($IDE_CONVOCATORIA)) > 0) {
                $lstparametrosM['IDE_CONVOCATORIA'] = $PIDE_CONVOCATORIA;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($SEC_FUNC)) > 0) {
                $lstparametrosM['SEC_FUNC'] = $SEC_FUNC;
            }
            if (strlen(rtrim($COD_FTE_FTO)) > 0) {
                $lstparametrosM['COD_FTE_FTO'] = $COD_FTE_FTO;
            }
            if (strlen(rtrim($COD_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['COD_ESPECIFICA_GASTO'] = $COD_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($COD_CERTIFICADO_PRES)) > 0) {
                $lstparametrosM['COD_CERTIFICADO_PRES'] = $COD_CERTIFICADO_PRES;
            }
            if (strlen(rtrim($SEC_EJEC)) > 0) {
                $lstparametrosM['SEC_EJEC'] = $SEC_EJEC;
            }
            if (strlen(rtrim($COD_EXPEDIENTE_SIAF)) > 0) {
                $lstparametrosM['COD_EXPEDIENTE_SIAF'] = $COD_EXPEDIENTE_SIAF;
            }
            if (strlen(rtrim($DES_FTE_FTO)) > 0) {
                $lstparametrosM['DES_FTE_FTO'] = $DES_FTE_FTO;
            }
            if (strlen(rtrim($DES_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['DES_ESPECIFICA_GASTO'] = $DES_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($IMP_CERTIFICADO_PRES)) > 0) {
                $lstparametrosM['IMP_CERTIFICADO_PRES'] = $IMP_CERTIFICADO_PRES;
            }            
            if (strlen(rtrim($EST_PROC_PRESUPUESTO)) > 0) {
                $lstparametrosM['EST_PROC_PRESUPUESTO'] = $EST_PROC_PRESUPUESTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['SEC_FUNC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_FTE_FTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_CERTIFICADO_PRES'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['SEC_EJEC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_EXPEDIENTE_SIAF'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_FTE_FTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_CERTIFICADO_PRES'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROC_PRESUPUESTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            
            //var_dump($procedure_parametrosMS);exit;
            $Objeto_PROC_PRESUPUESTO_DAO->Update_PROC_PRESUPUESTO($DataSet_PROC_PRESUPUESTO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[14][0];

            $mensaje = $procedure_parametrosMS[15][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROC_PRESUPUESTO = array();
            $Objeto_PROC_PRESUPUESTO_DAO = new PROC_PRESUPUESTO_DAO();
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
            $Objeto_PROC_PRESUPUESTO_DAO->Delete_PROC_PRESUPUESTO($DataSet_PROC_PRESUPUESTO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_PROC_PRESUPUESTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROC_PRESUPUESTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        $lCollection->Add('PIDE_PROC_ITEM', $PIDE_PROC_ITEM);
        $lCollection->Add('PIDE_CONVOCATORIA', $PIDE_CONVOCATORIA);
        
    }
}

//var_dump($lstDepartamento);exit;