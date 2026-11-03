<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_INDICADORLN de la tabla GEN_INDICADOR
  //  Fecha           : miércoles, 03 de enero de 2018 04:36:59 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_INDICADORDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_INDICADOR";
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
        $IDE_INTERVENCION = isset($_REQUEST['IDE_INTERVENCION']) ? VerificarInputs($_REQUEST['IDE_INTERVENCION']) : "";
        $DES_INDICADOR = isset($_REQUEST['DES_INDICADOR']) ? VerificarInputs($_REQUEST['DES_INDICADOR']) : "";
        $TIP_INDICADOR = isset($_REQUEST['TIP_INDICADOR']) ? VerificarInputs($_REQUEST['TIP_INDICADOR']) : "";
        $TIP_PRIORIDAD = isset($_REQUEST['TIP_PRIORIDAD']) ? VerificarInputs($_REQUEST['TIP_PRIORIDAD']) : "";
        $TIP_PERIODO_PROGRAMACION = isset($_REQUEST['TIP_PERIODO_PROGRAMACION']) ? VerificarInputs($_REQUEST['TIP_PERIODO_PROGRAMACION']) : "";
        $TIP_PERIODO_EJECUCION = isset($_REQUEST['TIP_PERIODO_EJECUCION']) ? VerificarInputs($_REQUEST['TIP_PERIODO_EJECUCION']) : "";
        $DES_UNIDAD_MEDIDA = isset($_REQUEST['DES_UNIDAD_MEDIDA']) ? VerificarInputs($_REQUEST['DES_UNIDAD_MEDIDA']) : "";
        $EST_INDICADOR = isset($_REQUEST['EST_INDICADOR']) ? VerificarInputs($_REQUEST['EST_INDICADOR']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_INDICADOR_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_INDICADOR') {
                        $_POST['qtype'] = 'GI.DES_INDICADOR';
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
            $ogridDAO->Count_GEN_INDICADOR($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_INDICADOR;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_INDICADOR', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_INDICADORM = array();
            $Objeto_GEN_INDICADOR_DAO = new GEN_INDICADOR_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($DES_INDICADOR)) > 0) {
                $lstparametrosM['DES_INDICADOR'] = $DES_INDICADOR;
            }
            if (strlen(rtrim($TIP_INDICADOR)) > 0) {
                $lstparametrosM['TIP_INDICADOR'] = $TIP_INDICADOR;
            }
            if (strlen(rtrim($TIP_PRIORIDAD)) > 0) {
                $lstparametrosM['TIP_PRIORIDAD'] = $TIP_PRIORIDAD;
            }
            if (strlen(rtrim($TIP_PERIODO_PROGRAMACION)) > 0) {
                $lstparametrosM['TIP_PERIODO_PROGRAMACION'] = $TIP_PERIODO_PROGRAMACION;
            }
            if (strlen(rtrim($TIP_PERIODO_EJECUCION)) > 0) {
                $lstparametrosM['TIP_PERIODO_EJECUCION'] = $TIP_PERIODO_EJECUCION;
            }
            if (strlen(rtrim($DES_UNIDAD_MEDIDA)) > 0) {
                $lstparametrosM['DES_UNIDAD_MEDIDA'] = $DES_UNIDAD_MEDIDA;
            }
            if (strlen(rtrim($EST_INDICADOR)) > 0) {
                $lstparametrosM['EST_INDICADOR'] = $EST_INDICADOR;
            }

            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_INDICADOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_INDICADOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PRIORIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PERIODO_PROGRAMACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PERIODO_EJECUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_INDICADOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_INDICADOR_DAO->Insert_GEN_INDICADOR($DataSet_GEN_INDICADOR, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_INDICADOR = array();
            $Objeto_GEN_INDICADOR_DAO = new GEN_INDICADOR_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_INDICADOR_DAO->SelPk_GEN_INDICADOR($DataSet_GEN_INDICADOR, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_INDICADOR) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_INDICADOR

                $IDE_INTERVENCION = $DataSet_GEN_INDICADOR[0]->IDE_INTERVENCION;
                $DES_INDICADOR = $DataSet_GEN_INDICADOR[0]->DES_INDICADOR;
                $TIP_INDICADOR = $DataSet_GEN_INDICADOR[0]->TIP_INDICADOR;
                $TIP_PRIORIDAD = $DataSet_GEN_INDICADOR[0]->TIP_PRIORIDAD;
                $TIP_PERIODO_PROGRAMACION = $DataSet_GEN_INDICADOR[0]->TIP_PERIODO_PROGRAMACION;
                $TIP_PERIODO_EJECUCION = $DataSet_GEN_INDICADOR[0]->TIP_PERIODO_EJECUCION;
                $DES_UNIDAD_MEDIDA = $DataSet_GEN_INDICADOR[0]->DES_UNIDAD_MEDIDA;
                $EST_INDICADOR = $DataSet_GEN_INDICADOR[0]->EST_INDICADOR;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_INTERVENCION', $IDE_INTERVENCION);
            $lCollection->Add('DES_INDICADOR', $DES_INDICADOR);
            $lCollection->Add('TIP_INDICADOR', $TIP_INDICADOR);
            $lCollection->Add('TIP_PRIORIDAD', $TIP_PRIORIDAD);
            $lCollection->Add('TIP_PERIODO_PROGRAMACION', $TIP_PERIODO_PROGRAMACION);
            $lCollection->Add('TIP_PERIODO_EJECUCION', $TIP_PERIODO_EJECUCION);
            $lCollection->Add('DES_UNIDAD_MEDIDA', $DES_UNIDAD_MEDIDA);
            $lCollection->Add('EST_INDICADOR', $EST_INDICADOR);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_INDICADOR = array();
            $Objeto_GEN_INDICADOR_DAO = new GEN_INDICADOR_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($DES_INDICADOR)) > 0) {
                $lstparametrosM['DES_INDICADOR'] = $DES_INDICADOR;
            }
            if (strlen(rtrim($TIP_INDICADOR)) > 0) {
                $lstparametrosM['TIP_INDICADOR'] = $TIP_INDICADOR;
            }
            if (strlen(rtrim($TIP_PRIORIDAD)) > 0) {
                $lstparametrosM['TIP_PRIORIDAD'] = $TIP_PRIORIDAD;
            }
            if (strlen(rtrim($TIP_PERIODO_PROGRAMACION)) > 0) {
                $lstparametrosM['TIP_PERIODO_PROGRAMACION'] = $TIP_PERIODO_PROGRAMACION;
            }
            if (strlen(rtrim($TIP_PERIODO_EJECUCION)) > 0) {
                $lstparametrosM['TIP_PERIODO_EJECUCION'] = $TIP_PERIODO_EJECUCION;
            }
            if (strlen(rtrim($DES_UNIDAD_MEDIDA)) > 0) {
                $lstparametrosM['DES_UNIDAD_MEDIDA'] = $DES_UNIDAD_MEDIDA;
            }
            if (strlen(rtrim($EST_INDICADOR)) > 0) {
                $lstparametrosM['EST_INDICADOR'] = $EST_INDICADOR;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_INDICADOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_INDICADOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PRIORIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PERIODO_PROGRAMACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PERIODO_EJECUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_INDICADOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_INDICADOR_DAO->Update_GEN_INDICADOR($DataSet_GEN_INDICADOR, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[10][0];

            $mensaje = $procedure_parametrosMS[11][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_INDICADOR = array();
            $Objeto_GEN_INDICADOR_DAO = new GEN_INDICADOR_DAO();
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
            $Objeto_GEN_INDICADOR_DAO->Delete_GEN_INDICADOR($DataSet_GEN_INDICADOR, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = " and  NUM_NIVEL=2 ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_INTERVENCION_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_INDICADOR_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '9'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_INDICADOR_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_PRIORIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '10'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PRIORIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_TIP_PERIODO_PROGRAMACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '11'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PERIODO_PROGRAMACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_TIP_PERIODO_EJECUCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '11'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PERIODO_EJECUCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_5 = array();
        $Objeto_EST_INDICADOR_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_INDICADOR_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_5, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_5', $DataSet_GEN_TABLAS_5);

        /* 					 */
        
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    }
}

//var_dump($lstDepartamento);exit;