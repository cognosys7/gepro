<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PLAN_GESTION_TRANS_PROYLN de la tabla PLAN_GESTION_TRANS_PROY
  //  Fecha           : lunes, 16 de julio de 2018 01:43:47 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLAN_GESTION_TRANS_PROYDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */

/***EDGAR---**************/
require_once(PATH_CONTROLADOR_DAO . "/PLAN_GESTION_TRANSFERENCIADAO.php");
require_once("include/GEN_NORMATIVALNI.php");
require_once("include/PLAN_SOLICITUD_PROYECTOLNI.php");
/***EDGAR---**************/

require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PLAN_GESTION_TRANS_PROY";
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
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";
/***EDGAR---******************/
        
        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PLAN_GESTION_TRANS = isset($_REQUEST['IDE_PLAN_GESTION_TRANS']) ? VerificarInputs($_REQUEST['IDE_PLAN_GESTION_TRANS']) : "";
        $IDE_SOLICITUD_PROYECTO = isset($_REQUEST['IDE_SOLICITUD_PROYECTO']) ? VerificarInputs($_REQUEST['IDE_SOLICITUD_PROYECTO']) : "";
        $DES_OBSERVACION = isset($_REQUEST['DES_OBSERVACION']) ? VerificarInputs($_REQUEST['DES_OBSERVACION']) : "";
        $EST_PLAN_GESTION_TRANS_PROY = isset($_REQUEST['EST_PLAN_GESTION_TRANS_PROY']) ? VerificarInputs($_REQUEST['EST_PLAN_GESTION_TRANS_PROY']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

/***EDGAR---************** DEFINE DATOS DEL PLAN_INTERVENCION ****/
        $ScriptFLX = " AND T.IDE_PLAN_GESTION_TRANS=$PIDE";
        $IDE_PLAN_GESTION_TRANS = $PIDE; /* añadido por julio meza */

        $IDE_NORMATIVA = $VFEC_FORMULACION = $VCOD_TRAMITE = $VIMP_TOTAL = $VCOD_NORMATIVA = null;
        $campos = " IDE_NORMATIVA, CONVERT(VARCHAR(10), FEC_FORMULACION) FEC_FORMULACION, COD_TRAMITE, IMP_TOTAL ";
        $filtro = " AND IDE_PLAN_GESTION_TRANS =".$PIDE;
        
        $data = VIS_SelCampos ('PLAN_GESTION_TRANSFERENCIA',$campos,$filtro) ;
        if(count($data)>0) {
            $IDE_NORMATIVA          = $data[0]->IDE_NORMATIVA ;
            $VFEC_FORMULACION        = $data[0]->FEC_FORMULACION ;
            $VCOD_TRAMITE            = $data[0]->COD_TRAMITE ;
            $VIMP_TOTAL              = 'S/. '.number_format($data[0]->IMP_TOTAL,2) ;
        }
        $lCollection->Add('VFEC_FORMULACION',  $VFEC_FORMULACION );
        $lCollection->Add('VCOD_TRAMITE',  $VCOD_TRAMITE );
        $lCollection->Add('VIMP_TOTAL', $VIMP_TOTAL );
        
        $data1 = Normativa_Datos( $IDE_NORMATIVA );
        $lCollection->Add('VCOD_NORMATIVA',  $data1['COD_NORMATIVA'] );
/***EDGAR---**************/ 
        
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PLAN_GESTION_TRANS_PROY_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'CodUnico') {
                        $_POST['qtype'] = 'P.COD_UNICO';
                    }
                    if ($_POST['qtype'] == 'DescripcionProyecto') {
                        $_POST['qtype'] = 'P.DES_PIP';
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
            $ogridDAO->Count_PLAN_GESTION_TRANS_PROY($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PLAN_GESTION_TRANS_PROY;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PLAN_GESTION_TRANS_PROY', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PLAN_GESTION_TRANS_PROYM = array();
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO = new PLAN_GESTION_TRANS_PROY_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PLAN_GESTION_TRANS)) > 0) {
                $lstparametrosM['IDE_PLAN_GESTION_TRANS'] = $IDE_PLAN_GESTION_TRANS;
            }
            if (strlen(rtrim($IDE_SOLICITUD_PROYECTO)) > 0) {
                $lstparametrosM['IDE_SOLICITUD_PROYECTO'] = $IDE_SOLICITUD_PROYECTO;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_PLAN_GESTION_TRANS_PROY)) > 0) {
                $lstparametrosM['EST_PLAN_GESTION_TRANS_PROY'] = $EST_PLAN_GESTION_TRANS_PROY;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PLAN_GESTION_TRANS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_SOLICITUD_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PLAN_GESTION_TRANS_PROY'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO->Insert_PLAN_GESTION_TRANS_PROY($DataSet_PLAN_GESTION_TRANS_PROY, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[5][0];

            $mensaje = $procedure_parametrosMS[6][0];

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
            $DataSet_PLAN_GESTION_TRANS_PROY = array();
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO = new PLAN_GESTION_TRANS_PROY_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO->SelPk_PLAN_GESTION_TRANS_PROY($DataSet_PLAN_GESTION_TRANS_PROY, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PLAN_GESTION_TRANS_PROY) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PLAN_GESTION_TRANS_PROY

                $IDE_PLAN_GESTION_TRANS = $DataSet_PLAN_GESTION_TRANS_PROY[0]->IDE_PLAN_GESTION_TRANS;
                $IDE_SOLICITUD_PROYECTO = $DataSet_PLAN_GESTION_TRANS_PROY[0]->IDE_SOLICITUD_PROYECTO;
                $DES_OBSERVACION = $DataSet_PLAN_GESTION_TRANS_PROY[0]->DES_OBSERVACION;
                $EST_PLAN_GESTION_TRANS_PROY = $DataSet_PLAN_GESTION_TRANS_PROY[0]->EST_PLAN_GESTION_TRANS_PROY;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PLAN_GESTION_TRANS', $IDE_PLAN_GESTION_TRANS);
            $lCollection->Add('IDE_SOLICITUD_PROYECTO', $IDE_SOLICITUD_PROYECTO);
            $lCollection->Add('DES_OBSERVACION', $DES_OBSERVACION);
            $lCollection->Add('EST_PLAN_GESTION_TRANS_PROY', $EST_PLAN_GESTION_TRANS_PROY);
            
/***EDGAR---**************/ 
            $Data = PlanSolicitudProyecto_Datos($IDE_SOLICITUD_PROYECTO);
            
            $Data_1 = PIP_Datos($Data['IDE_PIP']);
            $lCollection->Add('VCOD_UNICO', $Data_1['COD_UNICO']);
/***EDGAR---**************/
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PLAN_GESTION_TRANS_PROY = array();
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO = new PLAN_GESTION_TRANS_PROY_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PLAN_GESTION_TRANS)) > 0) {
                $lstparametrosM['IDE_PLAN_GESTION_TRANS'] = $IDE_PLAN_GESTION_TRANS;
            }
            if (strlen(rtrim($IDE_SOLICITUD_PROYECTO)) > 0) {
                $lstparametrosM['IDE_SOLICITUD_PROYECTO'] = $IDE_SOLICITUD_PROYECTO;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_PLAN_GESTION_TRANS_PROY)) > 0) {
                $lstparametrosM['EST_PLAN_GESTION_TRANS_PROY'] = $EST_PLAN_GESTION_TRANS_PROY;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PLAN_GESTION_TRANS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_SOLICITUD_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PLAN_GESTION_TRANS_PROY'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO->Update_PLAN_GESTION_TRANS_PROY($DataSet_PLAN_GESTION_TRANS_PROY, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[6][0];

            $mensaje = $procedure_parametrosMS[7][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PLAN_GESTION_TRANS_PROY = array();
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO = new PLAN_GESTION_TRANS_PROY_DAO();
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
            $Objeto_PLAN_GESTION_TRANS_PROY_DAO->Delete_PLAN_GESTION_TRANS_PROY($DataSet_PLAN_GESTION_TRANS_PROY, $procedure_parametrosMS); //JCMY
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
        $Objeto_EST_PLAN_GESTION_TRANS_PROY_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PLAN_GESTION_TRANS_PROY_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

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