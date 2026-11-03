<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMPONENTELN de la tabla PROY_COMPONENTE
  //  Fecha           : lunes, 20 de noviembre de 2017 11:41:10 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMPONENTEDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */

require_once(PATH_CONTROLADOR_DAO . "/PROYECTO_ACTIVIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROY_CARTERADAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_MODO_EJECUCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROC_ITEMDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ESTADODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_COMPONENTEDAO.php");


/* EDGAR */
require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/GEN_INTERVENCIONlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_COMPONENTE";
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


        $PIDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) : "";
        $PIDE_INTERVENCION = isset($_REQUEST['PIDE_INTERVENCION']) ? VerificarInputs($_REQUEST['PIDE_INTERVENCION']) : ""; //TOMA EL VALOR DEL ID        

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID

        $IDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) : "";
        $IDE_CARTERA = isset($_REQUEST['IDE_CARTERA']) ? VerificarInputs($_REQUEST['IDE_CARTERA']) : "";
        $IDE_COMPONENTE = isset($_REQUEST['IDE_COMPONENTE']) ? VerificarInputs($_REQUEST['IDE_COMPONENTE']) : "";
        $NUM_SEC_COMPONENTE = isset($_REQUEST['NUM_SEC_COMPONENTE']) ? VerificarInputs($_REQUEST['NUM_SEC_COMPONENTE']) : "";
        $IDE_MODO_EJECUCION = isset($_REQUEST['IDE_MODO_EJECUCION']) ? VerificarInputs($_REQUEST['IDE_MODO_EJECUCION']) : "";
        $IDE_PROC_ITEM = isset($_REQUEST['IDE_PROC_ITEM']) ? VerificarInputs($_REQUEST['IDE_PROC_ITEM']) : "";
        $IMP_COMPONENTE = isset($_REQUEST['IMP_COMPONENTE']) ? VerificarInputs($_REQUEST['IMP_COMPONENTE']) : "";
        $IDE_ESTADO = isset($_REQUEST['IDE_ESTADO']) ? VerificarInputs($_REQUEST['IDE_ESTADO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND PC.IDE_PROYECTO_ACTIVIDAD=$PIDE_PROYECTO_ACTIVIDAD";


        $DataSet_PROYECTO_ACTIVIDAD_1 = array();
        $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = " IDE_ENTIDAD_EJECUTORA, SEC_EJEC, DES_ENTIDAD, COD_PROYECTO, DES_PROYECTO_ITEM, IMP_COSTO_ACTUAL, DES_INTERVENCION";
        $lstparametrosM['filtro'] = " AND IDE_PROYECTO_ACTIVIDAD = '$PIDE_PROYECTO_ACTIVIDAD'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO->SelCampos_PROYECTO_ACTIVIDAD2($DataSet_PROYECTO_ACTIVIDAD_1, $procedure_parametrosMS);

        $VIDE_ENTIDAD_EJECUTORA = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IDE_ENTIDAD_EJECUTORA;
        $lCollection->Add('VIDE_ENTIDAD_EJECUTORA', $VIDE_ENTIDAD_EJECUTORA);
        $VSEC_EJEC = $DataSet_PROYECTO_ACTIVIDAD_1[0]->SEC_EJEC;
        $lCollection->Add('VSEC_EJEC', $VSEC_EJEC);
        $VDES_ENTIDAD = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_ENTIDAD;
        $lCollection->Add('VDES_ENTIDAD', $VDES_ENTIDAD);
        $VCOD_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD_1[0]->COD_PROYECTO;
        $lCollection->Add('VCOD_PROYECTO', $VCOD_PROYECTO);
        $VDES_PROYECTO_ITEM = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_PROYECTO_ITEM;
        $lCollection->Add('VDES_PROYECTO_ITEM', $VDES_PROYECTO_ITEM);
        $VIMP_COSTO_ACTUAL = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IMP_COSTO_ACTUAL;
        $lCollection->Add('VIMP_COSTO_ACTUAL', $VIMP_COSTO_ACTUAL);

        $VDES_INTERVENCION = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_INTERVENCION;
        $lCollection->Add('VDES_INTERVENCION', $VDES_INTERVENCION);        

        
        
        
        $Data2 = ProyectoActividad_Datos($PIDE_PROYECTO_ACTIVIDAD);
        $PIDE_PROYECTO = $Data2['IDE_PROYECTO'] ;
        $lCollection->Add('VIDE_PROYECTO', $PIDE_PROYECTO ) ;
        
        $Data3 = ProyectoContrato_Datos2($PIDE_PROYECTO_ACTIVIDAD,$PIDE_PROYECTO);
        $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
        
        $lCollection->Add('VIDE_INTERVENCION', $PIDE_INTERVENCION ) ;
        
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_COMPONENTE_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {
                    if ($_POST['qtype'] == 'DES_COMPONENTE') {
                        $_POST['qtype'] = 'GC.DES_COMPONENTE';
                    }
                    if ($_POST['qtype'] == 'DES_MODO_EJECUCION') {
                        $_POST['qtype'] = 'GME.DES_MODO_EJECUCION';
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
            $ogridDAO->Count_PROY_COMPONENTE($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROY_COMPONENTE;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_COMPONENTE', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROY_COMPONENTEM = array();
            $Objeto_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($IDE_CARTERA)) > 0) {
                $lstparametrosM['IDE_CARTERA'] = $IDE_CARTERA;
            }
            if (strlen(rtrim($IDE_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_COMPONENTE'] = $IDE_COMPONENTE;
            }
            if (strlen(rtrim($NUM_SEC_COMPONENTE)) > 0) {
                $lstparametrosM['NUM_SEC_COMPONENTE'] = $NUM_SEC_COMPONENTE;
            }
            if (strlen(rtrim($IDE_MODO_EJECUCION)) > 0) {
                $lstparametrosM['IDE_MODO_EJECUCION'] = $IDE_MODO_EJECUCION;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($IMP_COMPONENTE)) > 0) {
                $lstparametrosM['IMP_COMPONENTE'] = ConvertirMontos($IMP_COMPONENTE);
            }
            if (strlen(rtrim($IDE_ESTADO)) > 0) {
                $lstparametrosM['IDE_ESTADO'] = $IDE_ESTADO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CARTERA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_SEC_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_MODO_EJECUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ESTADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMPONENTE_DAO->Insert_PROY_COMPONENTE($DataSet_PROY_COMPONENTE, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_COMPONENTE = array();
            $Objeto_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_COMPONENTE_DAO->SelPk_PROY_COMPONENTE($DataSet_PROY_COMPONENTE, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_COMPONENTE) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_COMPONENTE
                $IDE_PROYECTO_ACTIVIDAD = $DataSet_PROY_COMPONENTE[0]->IDE_PROYECTO_ACTIVIDAD;
                $IDE_CARTERA = $DataSet_PROY_COMPONENTE[0]->IDE_CARTERA;
                $IDE_COMPONENTE = $DataSet_PROY_COMPONENTE[0]->IDE_COMPONENTE;
                $NUM_SEC_COMPONENTE = $DataSet_PROY_COMPONENTE[0]->NUM_SEC_COMPONENTE;
                $IDE_MODO_EJECUCION = $DataSet_PROY_COMPONENTE[0]->IDE_MODO_EJECUCION;
                $IDE_PROC_ITEM = $DataSet_PROY_COMPONENTE[0]->IDE_PROC_ITEM;
                $IMP_COMPONENTE = $DataSet_PROY_COMPONENTE[0]->IMP_COMPONENTE;
                $IDE_ESTADO = $DataSet_PROY_COMPONENTE[0]->IDE_ESTADO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO_ACTIVIDAD', $IDE_PROYECTO_ACTIVIDAD);
            $lCollection->Add('IDE_CARTERA', $IDE_CARTERA);
            $lCollection->Add('IDE_COMPONENTE', $IDE_COMPONENTE);
            $lCollection->Add('NUM_SEC_COMPONENTE', $NUM_SEC_COMPONENTE);
            $lCollection->Add('IDE_MODO_EJECUCION', $IDE_MODO_EJECUCION);
            $lCollection->Add('IDE_PROC_ITEM', $IDE_PROC_ITEM);
            $lCollection->Add('IMP_COMPONENTE', $IMP_COMPONENTE);
            $lCollection->Add('IDE_ESTADO', $IDE_ESTADO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */
            $DataSet_PROY_COMPONENTE = array();
            $Objeto_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($IDE_CARTERA)) > 0) {
                $lstparametrosM['IDE_CARTERA'] = $IDE_CARTERA;
            }            
            if (strlen(rtrim($IDE_MODO_EJECUCION)) > 0) {
                $lstparametrosM['IDE_MODO_EJECUCION'] = $IDE_MODO_EJECUCION;
            }
            if (strlen(rtrim($IDE_PROC_ITEM)) > 0) {
                $lstparametrosM['IDE_PROC_ITEM'] = $IDE_PROC_ITEM;
            }
            if (strlen(rtrim($IMP_COMPONENTE)) > 0) {
                $lstparametrosM['IMP_COMPONENTE'] = ConvertirMontos($IMP_COMPONENTE);
            }
            if (strlen(rtrim($IDE_ESTADO)) > 0) {
                $lstparametrosM['IDE_ESTADO'] = $IDE_ESTADO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CARTERA'], SQLSRV_PARAM_IN)                
                , array(&$lstparametrosM['IDE_MODO_EJECUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROC_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ESTADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMPONENTE_DAO->Update_PROY_COMPONENTE($DataSet_PROY_COMPONENTE, $procedure_parametrosMS);   //JCMY
            $CodMensaje = $procedure_parametrosMS[8][0];
            $mensaje = $procedure_parametrosMS[9][0];                        
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_COMPONENTE = array();
            $Objeto_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();
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
            $Objeto_PROY_COMPONENTE_DAO->Delete_PROY_COMPONENTE($DataSet_PROY_COMPONENTE, $procedure_parametrosMS); //JCMY
            $CodMensaje = $procedure_parametrosMS[2][0];
            $mensaje = $procedure_parametrosMS[3][0];
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);

        /********************************************************************************
        *          SECCION DE CODIGO PARA LAS LISTAS DEPLEGABLES O COMBOS
        /****************************************************************************** */
        //if ($Action == "ModificarRegistro" or $Action == "RegistraDatos"){
        $DataSet_GEN_COMPONENTE_1 = array();
        $Objeto_IDE_COMPONENTE_DAO = new GEN_COMPONENTE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_COMPONENTE,DES_COMPONENTE";       
        $lstparametrosM['filtro'] = " AND IDE_COMPONENTE IN (SELECT IDE_COMPONENTE FROM GEN_INTERVENCION_COMP WHERE IDE_INTERVENCION=$PIDE_INTERVENCION) ";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_COMPONENTE_DAO->SelCampos_GEN_COMPONENTE($DataSet_GEN_COMPONENTE_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_COMPONENTE_1', $DataSet_GEN_COMPONENTE_1);
        //}

        /* 					 */        

        $DataSet_PROY_CARTERA_1 = array();
        $Objeto_IDE_CARTERA_DAO = new PROY_CARTERA_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CARTERA,DES_CARTERA";
        $lstparametrosM['filtro'] = "";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_CARTERA_DAO->SelCampos_PROY_CARTERA($DataSet_PROY_CARTERA_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_PROY_CARTERA_1', $DataSet_PROY_CARTERA_1);

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

        $DataSet_PROC_ITEM_1 = array();
        $Objeto_IDE_PROC_ITEM_DAO = new PROC_ITEM_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PROC_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_PROYECTO='$VCOD_PROYECTO'"; // AND COD_PROYECTO='395369-1''
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_PROC_ITEM_DAO->SelCampos_PROC_ITEM($DataSet_PROC_ITEM_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_PROC_ITEM_1', $DataSet_PROC_ITEM_1);

        /* 					 */

        /* 					 */
        $DataSet_GEN_ESTADO_1 = array();
        $Objeto_IDE_ESTADO_DAO = new GEN_ESTADO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ESTADO,DES_ESTADO";
        $lstparametrosM['filtro'] = "";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_ESTADO_DAO->SelCampos_GEN_ESTADO($DataSet_GEN_ESTADO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ESTADO_1', $DataSet_GEN_ESTADO_1);

        /* 					 */
        $lCollection->Add('PIDE_PROYECTO_ACTIVIDAD', $PIDE_PROYECTO_ACTIVIDAD);
        $lCollection->Add('PIDE_INTERVENCION', $PIDE_INTERVENCION);
        $lCollection->Add('VDES_INTERVENCION', $VDES_INTERVENCION);
        
        
    /* EDGAR */
	$lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    /* EDGAR */
    }
}