<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Prop�sito       : GEN_INTERVENCION_COMPLN de la tabla GEN_INTERVENCION_COMP
  //  Fecha           : martes, 15 de mayo de 2018 10:57:24
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCION_COMPDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_COMPONENTEDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_MODO_EJECUCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_INTERVENCION_COMP";
    $PermisoOK = 0;

    /* HECTOR */
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
    $PermisoOK = VerificaAccesoMenu($Opcionsession, $perfilsession); // echo $PermisosPerfil; die;
    /* HECTOR */

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
        $IDE_COMPONENTE = isset($_REQUEST['IDE_COMPONENTE']) ? VerificarInputs($_REQUEST['IDE_COMPONENTE']) : "";
        $COMP_PRINCIPAL = isset($_REQUEST['COMP_PRINCIPAL']) ? VerificarInputs($_REQUEST['COMP_PRINCIPAL']) : "";
        $IDE_MODO_EJECUCION = isset($_REQUEST['IDE_MODO_EJECUCION']) ? VerificarInputs($_REQUEST['IDE_MODO_EJECUCION']) : "";
        $IDE_TIPO_PROC = isset($_REQUEST['IDE_TIPO_PROC']) ? VerificarInputs($_REQUEST['IDE_TIPO_PROC']) : "";
        $EST_INTERVENCION_COMP = isset($_REQUEST['EST_INTERVENCION_COMP']) ? VerificarInputs($_REQUEST['EST_INTERVENCION_COMP']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_INTERVENCION_COMP_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'SECTOR') {
                        $_POST['qtype'] = 'SECT.DES_SECTOR_ABREVIATURA';
                    }
                    if ($_POST['qtype'] == 'TIPO_INTERVENCION') {
                        $_POST['qtype'] = 'INTERV.DES_INTERVENCION';
                    }
                    if ($_POST['qtype'] == 'MODALIDAD') {
                        $_POST['qtype'] = 'MODEJE.DES_MODO_EJECUCION';
                    }
                    if ($_POST['qtype'] == 'ESTADO') {
                        $_POST['qtype'] = 'dbo.GEN_TABLAS.DES_ITEM';
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
            $ogridDAO->Count_GEN_INTERVENCION_COMP($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_INTERVENCION_COMP;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_INTERVENCION_COMP', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_INTERVENCION_COMPM = array();
            $Objeto_GEN_INTERVENCION_COMP_DAO = new GEN_INTERVENCION_COMP_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($IDE_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_COMPONENTE'] = $IDE_COMPONENTE;
            }
            if (strlen(rtrim($COMP_PRINCIPAL)) > 0) {
                $lstparametrosM['COMP_PRINCIPAL'] = $COMP_PRINCIPAL;
            }
            if (strlen(rtrim($IDE_MODO_EJECUCION)) > 0) {
                $lstparametrosM['IDE_MODO_EJECUCION'] = $IDE_MODO_EJECUCION;
            }
            if (strlen(rtrim($IDE_TIPO_PROC)) > 0) {
                $lstparametrosM['IDE_TIPO_PROC'] = $IDE_TIPO_PROC;
            }
            if (strlen(rtrim($EST_INTERVENCION_COMP)) > 0) {
                $lstparametrosM['EST_INTERVENCION_COMP'] = $EST_INTERVENCION_COMP;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COMP_PRINCIPAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_MODO_EJECUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_TIPO_PROC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_INTERVENCION_COMP'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_INTERVENCION_COMP_DAO->Insert_GEN_INTERVENCION_COMP($DataSet_GEN_INTERVENCION_COMP, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

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
            $DataSet_GEN_INTERVENCION_COMP = array();
            $Objeto_GEN_INTERVENCION_COMP_DAO = new GEN_INTERVENCION_COMP_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_INTERVENCION_COMP_DAO->SelPk_GEN_INTERVENCION_COMP($DataSet_GEN_INTERVENCION_COMP, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_INTERVENCION_COMP) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_INTERVENCION_COMP

                $IDE_INTERVENCION = $DataSet_GEN_INTERVENCION_COMP[0]->IDE_INTERVENCION;
                $IDE_COMPONENTE = $DataSet_GEN_INTERVENCION_COMP[0]->IDE_COMPONENTE;
                $COMP_PRINCIPAL = $DataSet_GEN_INTERVENCION_COMP[0]->COMP_PRINCIPAL;
                $IDE_MODO_EJECUCION = $DataSet_GEN_INTERVENCION_COMP[0]->IDE_MODO_EJECUCION;
                $IDE_TIPO_PROC = $DataSet_GEN_INTERVENCION_COMP[0]->IDE_TIPO_PROC;
                $EST_INTERVENCION_COMP = $DataSet_GEN_INTERVENCION_COMP[0]->EST_INTERVENCION_COMP;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_INTERVENCION', $IDE_INTERVENCION);
            $lCollection->Add('IDE_COMPONENTE', $IDE_COMPONENTE);
            $lCollection->Add('COMP_PRINCIPAL', $COMP_PRINCIPAL);
            $lCollection->Add('IDE_MODO_EJECUCION', $IDE_MODO_EJECUCION);
            $lCollection->Add('IDE_TIPO_PROC', $IDE_TIPO_PROC);
            $lCollection->Add('EST_INTERVENCION_COMP', $EST_INTERVENCION_COMP);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_INTERVENCION_COMP = array();
            $Objeto_GEN_INTERVENCION_COMP_DAO = new GEN_INTERVENCION_COMP_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($IDE_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_COMPONENTE'] = $IDE_COMPONENTE;
            }
            if (strlen(rtrim($COMP_PRINCIPAL)) > 0) {
                $lstparametrosM['COMP_PRINCIPAL'] = $COMP_PRINCIPAL;
            }
            if (strlen(rtrim($IDE_MODO_EJECUCION)) > 0) {
                $lstparametrosM['IDE_MODO_EJECUCION'] = $IDE_MODO_EJECUCION;
            }
            if (strlen(rtrim($IDE_TIPO_PROC)) > 0) {
                $lstparametrosM['IDE_TIPO_PROC'] = $IDE_TIPO_PROC;
            }
            if (strlen(rtrim($EST_INTERVENCION_COMP)) > 0) {
                $lstparametrosM['EST_INTERVENCION_COMP'] = $EST_INTERVENCION_COMP;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COMP_PRINCIPAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_MODO_EJECUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_TIPO_PROC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_INTERVENCION_COMP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_INTERVENCION_COMP_DAO->Update_GEN_INTERVENCION_COMP($DataSet_GEN_INTERVENCION_COMP, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[8][0];

            $mensaje = $procedure_parametrosMS[9][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_INTERVENCION_COMP = array();
            $Objeto_GEN_INTERVENCION_COMP_DAO = new GEN_INTERVENCION_COMP_DAO();
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
            $Objeto_GEN_INTERVENCION_COMP_DAO->Delete_GEN_INTERVENCION_COMP($DataSet_GEN_INTERVENCION_COMP, $procedure_parametrosMS); //JCMY
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
        $lstparametrosM['filtro'] = " AND NUM_NIVEL=3  AND IDE_SECTOR=14 ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_INTERVENCION_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        $DataSet_GEN_COMPONENTE_1 = array();
        $Objeto_IDE_COMPONENTE_DAO = new GEN_COMPONENTE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_COMPONENTE,DES_ABREVIATURA";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_COMPONENTE_DAO->SelCampos_GEN_COMPONENTE($DataSet_GEN_COMPONENTE_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_COMPONENTE_1', $DataSet_GEN_COMPONENTE_1);

        /* 					 */

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

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_INTERVENCION_COMP_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_INTERVENCION_COMP_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
        
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    }
}

//var_dump($lstDepartamento);exit;
