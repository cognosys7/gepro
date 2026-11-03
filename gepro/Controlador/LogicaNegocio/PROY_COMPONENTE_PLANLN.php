<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa         : www.cognosys.com.pe
//  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
//                    Edgar David Pisfil Ahumada
//  Propósito       : PROY_COMPONENTE_PLANLN de la tabla PROY_COMPONENTE_PLAN
//  Fecha           : miércoles, 22 de noviembre de 2017 07:27:24 p.m.
//  Desde el Modelo : PDM - AMSAC
//  Modificado      : 16 de Octubre 2017
//
/***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMPONENTE_PLANDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PROY_COMPONENTEDAO.php");



require_once(PATH_CONTROLADOR_DAO . "/GEN_PLANDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/PROY_COMPONENTElni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_COMPONENTE_PLAN";
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


        $PIDE_PROY_COMPONENTE = isset($_REQUEST['PIDE_PROY_COMPONENTE']) ? VerificarInputs($_REQUEST['PIDE_PROY_COMPONENTE']) : "";


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PROY_COMPONENTE = isset($_REQUEST['IDE_PROY_COMPONENTE']) ? VerificarInputs($_REQUEST['IDE_PROY_COMPONENTE']) : "";
        $IDE_PLAN = isset($_REQUEST['IDE_PLAN']) ? VerificarInputs($_REQUEST['IDE_PLAN']) : "";
        $FEC_INICIO = isset($_REQUEST['FEC_INICIO']) ? VerificarInputs($_REQUEST['FEC_INICIO']) : "";
        $FEC_TERMINO = isset($_REQUEST['FEC_TERMINO']) ? VerificarInputs($_REQUEST['FEC_TERMINO']) : "";
        $EST_COMPONENTE_PLAN = isset($_REQUEST['EST_COMPONENTE_PLAN']) ? VerificarInputs($_REQUEST['EST_COMPONENTE_PLAN']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND  PCP.IDE_PROY_COMPONENTE=$PIDE_PROY_COMPONENTE";



        $DataSet_PROY_COMPONENTE_1 = array();
        $Objeto_IDE_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONVOCATORIA,COD_ITEM,SEC_EJEC,DES_ENTIDAD,UPPER(DES_INTERVENCION) AS DES_INTERVENCION,DES_PROYECTO,DES_COMPONENTE,DES_CARTERA,DES_ESTADO,CONVERT(varchar(10), FEC_INICIO_CONTRATO, 103) as FEC_INICIO_CONTRATO, CONVERT(varchar(10), FEC_TERMINO_CONTRATO, 103) as FEC_TERMINO_CONTRATO, IMP_COMPONENTE";
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



        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_COMPONENTE_PLAN_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_PLAN') {
                        $_POST['qtype'] = 'GP.DES_PLAN';
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
            $ogridDAO->Count_PROY_COMPONENTE_PLAN($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_COMPONENTE_PLAN;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_COMPONENTE_PLAN', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_INICIO) > 0) {
                $FEC_INICIO = cambiafecha($FEC_INICIO);
            } else {
                $FEC_INICIO = "";
            }
            if (strlen($FEC_TERMINO) > 0) {
                $FEC_TERMINO = cambiafecha($FEC_TERMINO);
            } else {
                $FEC_TERMINO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_COMPONENTE_PLANM = array();
            $Objeto_PROY_COMPONENTE_PLAN_DAO = new PROY_COMPONENTE_PLAN_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
            }
            if (strlen(rtrim($IDE_PLAN)) > 0) {
                $lstparametrosM['IDE_PLAN'] = $IDE_PLAN;
            }
            if (strlen(rtrim($FEC_INICIO)) > 0) {
                $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            }
            if (strlen(rtrim($FEC_TERMINO)) > 0) {
                $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            }
            if (strlen(rtrim($EST_COMPONENTE_PLAN)) > 0) {
                $lstparametrosM['EST_COMPONENTE_PLAN'] = $EST_COMPONENTE_PLAN;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PLAN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_COMPONENTE_PLAN'], SQLSRV_PARAM_IN), 
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMPONENTE_PLAN_DAO->Insert_PROY_COMPONENTE_PLAN($DataSet_PROY_COMPONENTE_PLAN, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_COMPONENTE_PLAN = array();
            $Objeto_PROY_COMPONENTE_PLAN_DAO = new PROY_COMPONENTE_PLAN_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_COMPONENTE_PLAN_DAO->SelPk_PROY_COMPONENTE_PLAN($DataSet_PROY_COMPONENTE_PLAN, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_COMPONENTE_PLAN) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_COMPONENTE_PLAN

                $IDE_PROY_COMPONENTE = $DataSet_PROY_COMPONENTE_PLAN[0]->IDE_PROY_COMPONENTE;
                $IDE_PLAN = $DataSet_PROY_COMPONENTE_PLAN[0]->IDE_PLAN;
                $FEC_INICIO = $DataSet_PROY_COMPONENTE_PLAN[0]->FEC_INICIO;
                $FEC_TERMINO = $DataSet_PROY_COMPONENTE_PLAN[0]->FEC_TERMINO;
                $EST_COMPONENTE_PLAN = $DataSet_PROY_COMPONENTE_PLAN[0]->EST_COMPONENTE_PLAN;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROY_COMPONENTE', $IDE_PROY_COMPONENTE);
            $lCollection->Add('IDE_PLAN', $IDE_PLAN);
            $lCollection->Add('FEC_INICIO', $FEC_INICIO);
            $lCollection->Add('FEC_TERMINO', $FEC_TERMINO);
            $lCollection->Add('EST_COMPONENTE_PLAN', $EST_COMPONENTE_PLAN);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_INICIO) > 0) {
                $FEC_INICIO = cambiafecha($FEC_INICIO);
            } else {
                $FEC_INICIO = "";
            }
            if (strlen($FEC_TERMINO) > 0) {
                $FEC_TERMINO = cambiafecha($FEC_TERMINO);
            } else {
                $FEC_TERMINO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_COMPONENTE_PLAN = array();
            $Objeto_PROY_COMPONENTE_PLAN_DAO = new PROY_COMPONENTE_PLAN_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
            }
            if (strlen(rtrim($IDE_PLAN)) > 0) {
                $lstparametrosM['IDE_PLAN'] = $IDE_PLAN;
            }
            if (strlen(rtrim($FEC_INICIO)) > 0) {
                $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            }
            if (strlen(rtrim($FEC_TERMINO)) > 0) {
                $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            }
            if (strlen(rtrim($EST_COMPONENTE_PLAN)) > 0) {
                $lstparametrosM['EST_COMPONENTE_PLAN'] = $EST_COMPONENTE_PLAN;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_COMPONENTE_PLAN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMPONENTE_PLAN_DAO->Update_PROY_COMPONENTE_PLAN($DataSet_PROY_COMPONENTE_PLAN, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_COMPONENTE_PLAN = array();
            $Objeto_PROY_COMPONENTE_PLAN_DAO = new PROY_COMPONENTE_PLAN_DAO();
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
            $Objeto_PROY_COMPONENTE_PLAN_DAO->Delete_PROY_COMPONENTE_PLAN($DataSet_PROY_COMPONENTE_PLAN, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_PLAN_1 = array();
        $Objeto_IDE_PLAN_DAO = new GEN_PLAN_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PLAN,DES_PLAN";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PLAN_DAO->SelCampos_GEN_PLAN($DataSet_GEN_PLAN_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_PLAN_1', $DataSet_GEN_PLAN_1);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_COMPONENTE_PLAN_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '13'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_EST_COMPONENTE_PLAN_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        $lCollection->Add('PIDE_PROY_COMPONENTE', $PIDE_PROY_COMPONENTE);
    }
}

//var_dump($lstDepartamento);exit;