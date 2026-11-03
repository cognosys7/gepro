<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PLAN_TRANSFERENCIALN de la tabla PLAN_TRANSFERENCIA
  //  Fecha           : viernes, 5 de enero de 2018 22:58:16
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLAN_TRANSFERENCIADAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PLANDAO.php");



require_once(PATH_CONTROLADOR_DAO . "/GEN_NORMATIVADAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PLAN_TRANSFERENCIA";
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


        $PIDE_PLAN = isset($_REQUEST['PIDE_PLAN']) ? VerificarInputs($_REQUEST['PIDE_PLAN']) : "";


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PLAN = isset($_REQUEST['IDE_PLAN']) ? VerificarInputs($_REQUEST['IDE_PLAN']) : "";
        $IDE_NORMATIVA = isset($_REQUEST['IDE_NORMATIVA']) ? VerificarInputs($_REQUEST['IDE_NORMATIVA']) : "";
        $IMP_TRANSFERIDO = isset($_REQUEST['IMP_TRANSFERIDO']) ? VerificarInputs($_REQUEST['IMP_TRANSFERIDO']) : "";
        $DES_ALCANCE = isset($_REQUEST['DES_ALCANCE']) ? VerificarInputs($_REQUEST['DES_ALCANCE']) : "";
        $EST_TRANSFERENCIA = isset($_REQUEST['EST_TRANSFERENCIA']) ? VerificarInputs($_REQUEST['EST_TRANSFERENCIA']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND PLNTR.IDE_PLAN=$PIDE_PLAN";
        $IDE_PLAN = $PIDE_PLAN; /* añadido por julio meza */

//echo 'IDE_PLAN:'.$IDE_PLAN;// exit;
$VDES_PLAN= $VIMP_APROBADO = $VCOD_PLAN = '';
//        $DataSet_PLAN_1 = array();
//        $Objeto_IDE_PLAN_DAO = new PLAN_DAO();
//        $lstparametrosM = array();
//        $lstparametrosM['campos'] = " COD_PLAN,  DES_PLAN, IMP_APROBADO ";
//        $lstparametrosM['filtro'] = " AND IDE_PLAN = '$PIDE_PLAN'";
//        $procedure_parametrosMS = array(
//            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
//            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
//        );
//        $Objeto_IDE_PLAN_DAO->SelCampos_PLAN($DataSet_PLAN_1, $procedure_parametrosMS);

//        $VCOD_PLAN = $DataSet_PLAN_1[0]->COD_PLAN;
        $lCollection->Add('VCOD_PLAN', $VCOD_PLAN);
//        $VDES_PLAN = $DataSet_PLAN_1[0]->DES_PLAN;
        $lCollection->Add('VDES_PLAN', $VDES_PLAN);
//        $VIMP_APROBADO = $DataSet_PLAN_1[0]->IMP_APROBADO;
        $lCollection->Add('VIMP_APROBADO', $VIMP_APROBADO);
//echo '/// eror $VCOD_PLAN:'.$IDE_PLAN; exit;


        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PLAN_TRANSFERENCIA_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'CodPlan') {
                        $_POST['qtype'] = 'PLN.COD_PLAN';
                    }
                    if ($_POST['qtype'] == 'Decreto') {
                        $_POST['qtype'] = 'DECRET.COD_NORMATIVA';
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
            $ogridDAO->Count_PLAN_TRANSFERENCIA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_TRANSFERENCIA;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PLAN_TRANSFERENCIA', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PLAN_TRANSFERENCIAM = array();
            $Objeto_PLAN_TRANSFERENCIA_DAO = new PLAN_TRANSFERENCIA_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PLAN)) > 0) {
                $lstparametrosM['IDE_PLAN'] = $IDE_PLAN;
            }
            if (strlen(rtrim($IDE_NORMATIVA)) > 0) {
                $lstparametrosM['IDE_NORMATIVA'] = $IDE_NORMATIVA;
            }
            if (strlen(rtrim($IMP_TRANSFERIDO)) > 0) {
                $lstparametrosM['IMP_TRANSFERIDO'] = $IMP_TRANSFERIDO;
            }
            if (strlen(rtrim($DES_ALCANCE)) > 0) {
                $lstparametrosM['DES_ALCANCE'] = $DES_ALCANCE;
            }
            if (strlen(rtrim($EST_TRANSFERENCIA)) > 0) {
                $lstparametrosM['EST_TRANSFERENCIA'] = $EST_TRANSFERENCIA;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_NORMATIVA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_TRANSFERIDO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ALCANCE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_TRANSFERENCIA'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_TRANSFERENCIA_DAO->Insert_PLAN_TRANSFERENCIA($DataSet_PLAN_TRANSFERENCIA, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[6][0];

            $mensaje = $procedure_parametrosMS[7][0];

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
            $DataSet_PLAN_TRANSFERENCIA = array();
            $Objeto_PLAN_TRANSFERENCIA_DAO = new PLAN_TRANSFERENCIA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PLAN_TRANSFERENCIA_DAO->SelPk_PLAN_TRANSFERENCIA($DataSet_PLAN_TRANSFERENCIA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PLAN_TRANSFERENCIA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PLAN_TRANSFERENCIA

                $IDE_PLAN = $DataSet_PLAN_TRANSFERENCIA[0]->IDE_PLAN;
                $IDE_NORMATIVA = $DataSet_PLAN_TRANSFERENCIA[0]->IDE_NORMATIVA;
                $IMP_TRANSFERIDO = $DataSet_PLAN_TRANSFERENCIA[0]->IMP_TRANSFERIDO;
                $DES_ALCANCE = $DataSet_PLAN_TRANSFERENCIA[0]->DES_ALCANCE;
                $EST_TRANSFERENCIA = $DataSet_PLAN_TRANSFERENCIA[0]->EST_TRANSFERENCIA;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PLAN', $IDE_PLAN);
            $lCollection->Add('IDE_NORMATIVA', $IDE_NORMATIVA);
            $lCollection->Add('IMP_TRANSFERIDO', $IMP_TRANSFERIDO);
            $lCollection->Add('DES_ALCANCE', $DES_ALCANCE);
            $lCollection->Add('EST_TRANSFERENCIA', $EST_TRANSFERENCIA);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PLAN_TRANSFERENCIA = array();
            $Objeto_PLAN_TRANSFERENCIA_DAO = new PLAN_TRANSFERENCIA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PLAN)) > 0) {
                $lstparametrosM['IDE_PLAN'] = $IDE_PLAN;
            }
            if (strlen(rtrim($IDE_NORMATIVA)) > 0) {
                $lstparametrosM['IDE_NORMATIVA'] = $IDE_NORMATIVA;
            }
            if (strlen(rtrim($IMP_TRANSFERIDO)) > 0) {
                $lstparametrosM['IMP_TRANSFERIDO'] = $IMP_TRANSFERIDO;
            }
            if (strlen(rtrim($DES_ALCANCE)) > 0) {
                $lstparametrosM['DES_ALCANCE'] = $DES_ALCANCE;
            }
            if (strlen(rtrim($EST_TRANSFERENCIA)) > 0) {
                $lstparametrosM['EST_TRANSFERENCIA'] = $EST_TRANSFERENCIA;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_NORMATIVA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_TRANSFERIDO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ALCANCE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_TRANSFERENCIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_TRANSFERENCIA_DAO->Update_PLAN_TRANSFERENCIA($DataSet_PLAN_TRANSFERENCIA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PLAN_TRANSFERENCIA = array();
            $Objeto_PLAN_TRANSFERENCIA_DAO = new PLAN_TRANSFERENCIA_DAO();
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
            $Objeto_PLAN_TRANSFERENCIA_DAO->Delete_PLAN_TRANSFERENCIA($DataSet_PLAN_TRANSFERENCIA, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_TRANSFERENCIA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_TRANSFERENCIA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */



        $lCollection->Add('PIDE_PLAN', $PIDE_PLAN);
    }
}

//var_dump($lstDepartamento);exit;