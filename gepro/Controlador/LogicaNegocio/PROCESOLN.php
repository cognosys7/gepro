<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROCESOLN de la tabla PROCESO
  //  Fecha           : jueves, 2 de noviembre de 2017 23:30:03
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROCESODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PROC_TIPODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PLANDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

require_once(PATH_CONTROLADOR_DAO . "/GEN_CENTRO_COSTODAO.php");

/* EDGAR */
//// busqueda
require_once("include/PROCESOlni.php");
/* EDGAR */

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROCESO";
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


        /* EDGAR */
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";

        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_CONVOCATORIA = isset($_REQUEST['IDE_CONVOCATORIA']) ? VerificarInputs($_REQUEST['IDE_CONVOCATORIA']) : "";
        $IDE_TIPO_PROC = isset($_REQUEST['IDE_TIPO_PROC']) ? VerificarInputs($_REQUEST['IDE_TIPO_PROC']) : "";
        $IDE_PLAN = isset($_REQUEST['IDE_PLAN']) ? VerificarInputs($_REQUEST['IDE_PLAN']) : "";
        $IDE_ENTIDAD_EJECUTORA = isset($_REQUEST['IDE_ENTIDAD_EJECUTORA']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD_EJECUTORA']) : "";

        $IDE_CENCOSTO = isset($_REQUEST['IDE_CENCOSTO']) ? VerificarInputs($_REQUEST['IDE_CENCOSTO']) : "";
        $COD_PAC = isset($_REQUEST['COD_PAC']) ? VerificarInputs($_REQUEST['COD_PAC']) : "";

        $DES_DEPTO_EJECUTORA = isset($_REQUEST['DES_DEPTO_EJECUTORA']) ? VerificarInputs($_REQUEST['DES_DEPTO_EJECUTORA']) : "";
        $DES_PROV_EJECUTORA = isset($_REQUEST['DES_PROV_EJECUTORA']) ? VerificarInputs($_REQUEST['DES_PROV_EJECUTORA']) : "";
        $DES_DIST_EJECUTORA = isset($_REQUEST['DES_DIST_EJECUTORA']) ? VerificarInputs($_REQUEST['DES_DIST_EJECUTORA']) : "";
        $NUM_ANO_EJE = isset($_REQUEST['NUM_ANO_EJE']) ? VerificarInputs($_REQUEST['NUM_ANO_EJE']) : "";
        $NUM_PROC_ESPECIFICO = isset($_REQUEST['NUM_PROC_ESPECIFICO']) ? VerificarInputs($_REQUEST['NUM_PROC_ESPECIFICO']) : "";
        $DES_OBJETO = isset($_REQUEST['DES_OBJETO']) ? VerificarInputs($_REQUEST['DES_OBJETO']) : "";
        $TIP_OBJETO = isset($_REQUEST['TIP_OBJETO']) ? VerificarInputs($_REQUEST['TIP_OBJETO']) : "";
        $IMP_VAL_REFERENCIAL = isset($_REQUEST['IMP_VAL_REFERENCIAL']) ? VerificarInputs($_REQUEST['IMP_VAL_REFERENCIAL']) : "";
        $DES_URL_PROCESO = isset($_REQUEST['DES_URL_PROCESO']) ? VerificarInputs($_REQUEST['DES_URL_PROCESO']) : "";
        $EST_PROCESO = isset($_REQUEST['EST_PROCESO']) ? VerificarInputs($_REQUEST['EST_PROCESO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;


        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROCESO';

        if ($PIDE > 0) {
            $ScriptFLX = $ScriptFLX . " AND P.IDE_CONVOCATORIA=$PIDE";
        }

        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_PROCESO_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROCESO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_ENTIDAD') {
                        $_POST['qtype'] = 'GE.DES_ENTIDAD';
                    }
                    if ($_POST['qtype'] == 'PROCESO') {
                        $_POST['qtype'] = 'P.IDE_CONVOCATORIA';
                    }
                    if ($_POST['qtype'] == 'DES_OBJETO') {
                        $_POST['qtype'] = 'P.DES_OBJETO';
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
            $lparametroP['pUsuario'] = $usuario;
            $procedure_parametrosP = array(
                array(&$lparametroP['Script'], SQLSRV_PARAM_IN),
                array(&$lparametroP['pUsuario'], SQLSRV_PARAM_IN)
            );
            $ogridDAO->Count_PROCESO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONVOCATORIA;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP1($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $usuario, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data = Proceso_Datos($PIDEbuscado);
            $BIDE = $Data['BIDE'];

            $Bdescripcion = '( ' . $Data['BIDE'] . ' - Proc.Esp: ' . $Data['NUM_PROC_ESPECIFICO'] . ' ) ' . $Data['DES_OBJETO'];

            $lCollection->Add('BIDE', $BIDE);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROCESOM = array();
            $Objeto_PROCESO_DAO = new PROCESO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONVOCATORIA)) > 0) {
                $lstparametrosM['IDE_CONVOCATORIA'] = $IDE_CONVOCATORIA;
            }

            if (strlen(rtrim($IDE_TIPO_PROC)) > 0) {
                $lstparametrosM['IDE_TIPO_PROC'] = $IDE_TIPO_PROC;
            }
            if (strlen(rtrim($IDE_PLAN)) > 0) {
                $lstparametrosM['IDE_PLAN'] = $IDE_PLAN;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }

            if (strlen(rtrim($IDE_CENCOSTO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO'] = $IDE_CENCOSTO;
            }
            if (strlen(rtrim($COD_PAC)) > 0) {
                $lstparametrosM['COD_PAC'] = $COD_PAC;
            }

            if (strlen(rtrim($DES_DEPTO_EJECUTORA)) > 0) {
                $lstparametrosM['DES_DEPTO_EJECUTORA'] = $DES_DEPTO_EJECUTORA;
            }
            if (strlen(rtrim($DES_PROV_EJECUTORA)) > 0) {
                $lstparametrosM['DES_PROV_EJECUTORA'] = $DES_PROV_EJECUTORA;
            }
            if (strlen(rtrim($DES_DIST_EJECUTORA)) > 0) {
                $lstparametrosM['DES_DIST_EJECUTORA'] = $DES_DIST_EJECUTORA;
            }
            if (strlen(rtrim($NUM_ANO_EJE)) > 0) {
                $lstparametrosM['NUM_ANO_EJE'] = $NUM_ANO_EJE;
            }
            if (strlen(rtrim($NUM_PROC_ESPECIFICO)) > 0) {
                $lstparametrosM['NUM_PROC_ESPECIFICO'] = $NUM_PROC_ESPECIFICO;
            }
            if (strlen(rtrim($DES_OBJETO)) > 0) {
                $lstparametrosM['DES_OBJETO'] = $DES_OBJETO;
            }
            if (strlen(rtrim($TIP_OBJETO)) > 0) {
                $lstparametrosM['TIP_OBJETO'] = $TIP_OBJETO;
            }
            if (strlen(rtrim($IMP_VAL_REFERENCIAL)) > 0) {
                $lstparametrosM['IMP_VAL_REFERENCIAL'] = $IMP_VAL_REFERENCIAL;
            }
            if (strlen(rtrim($DES_URL_PROCESO)) > 0) {
                $lstparametrosM['DES_URL_PROCESO'] = $DES_URL_PROCESO;
            }
            if (strlen(rtrim($EST_PROCESO)) > 0) {
                $lstparametrosM['EST_PROCESO'] = $EST_PROCESO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_TIPO_PROC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CENCOSTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_PAC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DEPTO_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROV_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DIST_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_ANO_EJE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_PROC_ESPECIFICO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBJETO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_OBJETO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_VAL_REFERENCIAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_URL_PROCESO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROCESO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );



            $Objeto_PROCESO_DAO->Insert_PROCESO($DataSet_PROCESO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[17][0];

            $mensaje = $procedure_parametrosMS[18][0];

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
            $DataSet_PROCESO = array();
            $Objeto_PROCESO_DAO = new PROCESO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROCESO_DAO->SelPk_PROCESO($DataSet_PROCESO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROCESO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROCESO

                $IDE_TIPO_PROC = $DataSet_PROCESO[0]->IDE_TIPO_PROC;
                $IDE_PLAN = $DataSet_PROCESO[0]->IDE_PLAN;
                $IDE_ENTIDAD_EJECUTORA = $DataSet_PROCESO[0]->IDE_ENTIDAD_EJECUTORA;

                $IDE_CENCOSTO = $DataSet_PROCESO[0]->IDE_CENCOSTO;
                $COD_PAC = $DataSet_PROCESO[0]->COD_PAC;

                $DES_DEPTO_EJECUTORA = $DataSet_PROCESO[0]->DES_DEPTO_EJECUTORA;
                $DES_PROV_EJECUTORA = $DataSet_PROCESO[0]->DES_PROV_EJECUTORA;
                $DES_DIST_EJECUTORA = $DataSet_PROCESO[0]->DES_DIST_EJECUTORA;
                $NUM_ANO_EJE = $DataSet_PROCESO[0]->NUM_ANO_EJE;
                $NUM_PROC_ESPECIFICO = $DataSet_PROCESO[0]->NUM_PROC_ESPECIFICO;
                $DES_OBJETO = $DataSet_PROCESO[0]->DES_OBJETO;
                $TIP_OBJETO = $DataSet_PROCESO[0]->TIP_OBJETO;
                $IMP_VAL_REFERENCIAL = $DataSet_PROCESO[0]->IMP_VAL_REFERENCIAL;
                $DES_URL_PROCESO = $DataSet_PROCESO[0]->DES_URL_PROCESO;
                $EST_PROCESO = $DataSet_PROCESO[0]->EST_PROCESO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_TIPO_PROC', $IDE_TIPO_PROC);
            $lCollection->Add('IDE_PLAN', $IDE_PLAN);
            $lCollection->Add('IDE_ENTIDAD_EJECUTORA', $IDE_ENTIDAD_EJECUTORA);

            $lCollection->Add('IDE_CENCOSTO', $IDE_CENCOSTO);
            $lCollection->Add('COD_PAC', $COD_PAC);

            $lCollection->Add('DES_DEPTO_EJECUTORA', $DES_DEPTO_EJECUTORA);
            $lCollection->Add('DES_PROV_EJECUTORA', $DES_PROV_EJECUTORA);
            $lCollection->Add('DES_DIST_EJECUTORA', $DES_DIST_EJECUTORA);
            $lCollection->Add('NUM_ANO_EJE', $NUM_ANO_EJE);
            $lCollection->Add('NUM_PROC_ESPECIFICO', $NUM_PROC_ESPECIFICO);
            $lCollection->Add('DES_OBJETO', $DES_OBJETO);
            $lCollection->Add('TIP_OBJETO', $TIP_OBJETO);
            $lCollection->Add('IMP_VAL_REFERENCIAL', $IMP_VAL_REFERENCIAL);
            $lCollection->Add('DES_URL_PROCESO', $DES_URL_PROCESO);
            $lCollection->Add('EST_PROCESO', $EST_PROCESO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROCESO = array();
            $Objeto_PROCESO_DAO = new PROCESO_DAO();
			
if (strlen(rtrim($IDE_CONVOCATORIA)) > 0) {
                $lstparametrosM['IDE_CONVOCATORIA'] = $IDE_CONVOCATORIA;
            }			

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_TIPO_PROC)) > 0) {
                $lstparametrosM['IDE_TIPO_PROC'] = $IDE_TIPO_PROC;
            }
            if (strlen(rtrim($IDE_PLAN)) > 0) {
                $lstparametrosM['IDE_PLAN'] = $IDE_PLAN;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }

            if (strlen(rtrim($IDE_CENCOSTO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO'] = $IDE_CENCOSTO;
            }
            if (strlen(rtrim($COD_PAC)) > 0) {
                $lstparametrosM['COD_PAC'] = $COD_PAC;
            }

            if (strlen(rtrim($DES_DEPTO_EJECUTORA)) > 0) {
                $lstparametrosM['DES_DEPTO_EJECUTORA'] = $DES_DEPTO_EJECUTORA;
            }
            if (strlen(rtrim($DES_PROV_EJECUTORA)) > 0) {
                $lstparametrosM['DES_PROV_EJECUTORA'] = $DES_PROV_EJECUTORA;
            }
            if (strlen(rtrim($DES_DIST_EJECUTORA)) > 0) {
                $lstparametrosM['DES_DIST_EJECUTORA'] = $DES_DIST_EJECUTORA;
            }
            if (strlen(rtrim($NUM_ANO_EJE)) > 0) {
                $lstparametrosM['NUM_ANO_EJE'] = $NUM_ANO_EJE;
            }
            if (strlen(rtrim($NUM_PROC_ESPECIFICO)) > 0) {
                $lstparametrosM['NUM_PROC_ESPECIFICO'] = $NUM_PROC_ESPECIFICO;
            }
            if (strlen(rtrim($DES_OBJETO)) > 0) {
                $lstparametrosM['DES_OBJETO'] = $DES_OBJETO;
            }
            if (strlen(rtrim($TIP_OBJETO)) > 0) {
                $lstparametrosM['TIP_OBJETO'] = $TIP_OBJETO;
            }
            if (strlen(rtrim($IMP_VAL_REFERENCIAL)) > 0) {
                $lstparametrosM['IMP_VAL_REFERENCIAL'] = $IMP_VAL_REFERENCIAL;
            }
            if (strlen(rtrim($DES_URL_PROCESO)) > 0) {
                $lstparametrosM['DES_URL_PROCESO'] = $DES_URL_PROCESO;
            }
            if (strlen(rtrim($EST_PROCESO)) > 0) {
                $lstparametrosM['EST_PROCESO'] = $EST_PROCESO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
,array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_TIPO_PROC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CENCOSTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_PAC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DEPTO_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROV_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DIST_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_ANO_EJE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_PROC_ESPECIFICO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBJETO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_OBJETO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_VAL_REFERENCIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_URL_PROCESO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROCESO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROCESO_DAO->Update_PROCESO($DataSet_PROCESO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[18][0];

            $mensaje = $procedure_parametrosMS[19][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROCESO = array();
            $Objeto_PROCESO_DAO = new PROCESO_DAO();
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
            $Objeto_PROCESO_DAO->Delete_PROCESO($DataSet_PROCESO, $procedure_parametrosMS); //JCMY
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

        $DataSet_PROC_TIPO_1 = array();
        $Objeto_IDE_TIPO_PROC_DAO = new PROC_TIPO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_TIPO_PROC,TIPO_PROC";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_TIPO_PROC_DAO->SelCampos_PROC_TIPO($DataSet_PROC_TIPO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_PROC_TIPO_1', $DataSet_PROC_TIPO_1);

        /* 					 */

        $DataSet_PLAN_1 = array();
        $Objeto_IDE_PLAN_DAO = new PLAN_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PLAN,DES_PLAN";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PLAN_DAO->SelCampos_PLAN($DataSet_PLAN_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_PLAN_1', $DataSet_PLAN_1);

        /* 					 */

        $DataSet_GEN_ENTIDAD_1 = array();
        $Objeto_IDE_ENTIDAD_EJECUTORA_DAO = new GEN_ENTIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD,DES_ENTIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ENTIDAD_EJECUTORA_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTIDAD_1', $DataSet_GEN_ENTIDAD_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_OBJETO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '1'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_OBJETO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_PROCESO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROCESO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        $DataSet_GEN_CENTRO_COSTO_1 = array();
        $Objeto_IDE_CENCOSTO_DAO = new GEN_CENTRO_COSTO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CENCOSTO,DES_CENCOSTO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_CENCOSTO_DAO->SelCampos_GEN_CENTRO_COSTO($DataSet_GEN_CENTRO_COSTO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_CENTRO_COSTO_1', $DataSet_GEN_CENTRO_COSTO_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);

        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;