<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                        Edgar David Pisfil Ahumada
  //  Propósito       : PROC_CRONOGRAMALN de la tabla PROC_CRONOGRAMA
  //  Fecha           : miércoles, 1 de noviembre de 2017 20:55:33
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROC_CRONOGRAMADAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROCESODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROC_CRONOGRAMA";
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
        $Proceso = isset($_REQUEST['Proceso']) ? VerificarInputs($_REQUEST['Proceso']) : "";
        //$ProcesoDescripcion = isset($_REQUEST['ProcesoDescripcion'])? VerificarInputs($_REQUEST['ProcesoDescripcion']) : "";



        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_CONVOCATORIA = isset($_REQUEST['IDE_CONVOCATORIA']) ? VerificarInputs($_REQUEST['IDE_CONVOCATORIA']) : "";
        $NUM_CONVOCATORIA = isset($_REQUEST['NUM_CONVOCATORIA']) ? VerificarInputs($_REQUEST['NUM_CONVOCATORIA']) : "";
        $IDE_ORDEN = isset($_REQUEST['IDE_ORDEN']) ? VerificarInputs($_REQUEST['IDE_ORDEN']) : "";
        $FEC_PUBLICACION = isset($_REQUEST['FEC_PUBLICACION']) ? VerificarInputs($_REQUEST['FEC_PUBLICACION']) : "";
        $DES_ACTIVIDAD = isset($_REQUEST['DES_ACTIVIDAD']) ? VerificarInputs($_REQUEST['DES_ACTIVIDAD']) : "";
        $FEC_INICIO = isset($_REQUEST['FEC_INICIO']) ? VerificarInputs($_REQUEST['FEC_INICIO']) : "";
        $FEC_TERMINO = isset($_REQUEST['FEC_TERMINO']) ? VerificarInputs($_REQUEST['FEC_TERMINO']) : "";
        $EST_PROC_CRONOGRAMA = isset($_REQUEST['EST_PROC_CRONOGRAMA']) ? VerificarInputs($_REQUEST['EST_PROC_CRONOGRAMA']) : "";

        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR        
        $ScriptFLX = " AND IDE_CONVOCATORIA=$Proceso";
        //$ScriptFLX = " AND IDE_CONVOCATORIA='400791'";
        //var_dump($ScriptFLX);exit;

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROC_CRONOGRAMA_DAO();
            $Prueba = "ActionFlex";
            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {
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
            $ogridDAO->Count_PROC_CRONOGRAMA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CRONOGRAMA;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROC_CRONOGRAMA', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_PUBLICACION) > 0) {
                $FEC_PUBLICACION = cambiafecha($FEC_PUBLICACION);
            } else {
                $FEC_PUBLICACION = "";
            }
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

            $DataSet_PROC_CRONOGRAMAM = array();
            $Objeto_PROC_CRONOGRAMA_DAO = new PROC_CRONOGRAMA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['IDE_CONVOCATORIA'] = $IDE_CONVOCATORIA;
            $lstparametrosM['NUM_CONVOCATORIA'] = $NUM_CONVOCATORIA;
            $lstparametrosM['IDE_ORDEN'] = $IDE_ORDEN;
            $lstparametrosM['FEC_PUBLICACION'] = $FEC_PUBLICACION;
            $lstparametrosM['DES_ACTIVIDAD'] = $DES_ACTIVIDAD;
            $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            $lstparametrosM['EST_PROC_CRONOGRAMA'] = $EST_PROC_CRONOGRAMA;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_CONVOCATORIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ORDEN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_PUBLICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROC_CRONOGRAMA'], SQLSRV_PARAM_IN), 
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_CRONOGRAMA_DAO->Insert_PROC_CRONOGRAMA($DataSet_PROC_CRONOGRAMA, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROC_CRONOGRAMA = array();
            $Objeto_PROC_CRONOGRAMA_DAO = new PROC_CRONOGRAMA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROC_CRONOGRAMA_DAO->SelPk_PROC_CRONOGRAMA($DataSet_PROC_CRONOGRAMA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROC_CRONOGRAMA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROC_CRONOGRAMA

                $IDE_CONVOCATORIA = $DataSet_PROC_CRONOGRAMA[0]->IDE_CONVOCATORIA;
                $NUM_CONVOCATORIA = $DataSet_PROC_CRONOGRAMA[0]->NUM_CONVOCATORIA;
                $IDE_ORDEN = $DataSet_PROC_CRONOGRAMA[0]->IDE_ORDEN;
                $FEC_PUBLICACION = $DataSet_PROC_CRONOGRAMA[0]->FEC_PUBLICACION;
                $DES_ACTIVIDAD = $DataSet_PROC_CRONOGRAMA[0]->DES_ACTIVIDAD;
                $FEC_INICIO = $DataSet_PROC_CRONOGRAMA[0]->FEC_INICIO;
                $FEC_TERMINO = $DataSet_PROC_CRONOGRAMA[0]->FEC_TERMINO;
                $EST_PROC_CRONOGRAMA = $DataSet_PROC_CRONOGRAMA[0]->EST_PROC_CRONOGRAMA;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONVOCATORIA', $IDE_CONVOCATORIA);
            $lCollection->Add('NUM_CONVOCATORIA', $NUM_CONVOCATORIA);
            $lCollection->Add('IDE_ORDEN', $IDE_ORDEN);
            $lCollection->Add('FEC_PUBLICACION', $FEC_PUBLICACION);
            $lCollection->Add('DES_ACTIVIDAD', $DES_ACTIVIDAD);
            $lCollection->Add('FEC_INICIO', $FEC_INICIO);
            $lCollection->Add('FEC_TERMINO', $FEC_TERMINO);
            $lCollection->Add('EST_PROC_CRONOGRAMA', $EST_PROC_CRONOGRAMA);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_PUBLICACION) > 0) {
                $FEC_PUBLICACION = cambiafecha($FEC_PUBLICACION);
            } else {
                $FEC_PUBLICACION = "";
            }
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
            $DataSet_PROC_CRONOGRAMA = array();
            $Objeto_PROC_CRONOGRAMA_DAO = new PROC_CRONOGRAMA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $lstparametrosM['IDE_CONVOCATORIA'] = $IDE_CONVOCATORIA;
            $lstparametrosM['NUM_CONVOCATORIA'] = $NUM_CONVOCATORIA;
            $lstparametrosM['IDE_ORDEN'] = $IDE_ORDEN;
            $lstparametrosM['FEC_PUBLICACION'] = $FEC_PUBLICACION;
            $lstparametrosM['DES_ACTIVIDAD'] = $DES_ACTIVIDAD;
            $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            $lstparametrosM['EST_PROC_CRONOGRAMA'] = $EST_PROC_CRONOGRAMA;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONVOCATORIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_CONVOCATORIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ORDEN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_PUBLICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROC_CRONOGRAMA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_CRONOGRAMA_DAO->Update_PROC_CRONOGRAMA($DataSet_PROC_CRONOGRAMA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[10][0];

            $mensaje = $procedure_parametrosMS[11][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROC_CRONOGRAMA = array();
            $Objeto_PROC_CRONOGRAMA_DAO = new PROC_CRONOGRAMA_DAO();
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
            $Objeto_PROC_CRONOGRAMA_DAO->Delete_PROC_CRONOGRAMA($DataSet_PROC_CRONOGRAMA, $procedure_parametrosMS); //JCMY
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

        $DataSet_PROCESO_1 = array();
        $Objeto_IDE_CONVOCATORIA_DAO = new PROCESO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONVOCATORIA, DES_OBJETO, IMP_VAL_REFERENCIAL";
        $lstparametrosM['filtro'] = "AND IDE_CONVOCATORIA='$Proceso'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_CONVOCATORIA_DAO->SelCampos_PROCESO($DataSet_PROCESO_1, $procedure_parametrosMS);
        $VIDE_CONVOCATORIA = $DataSet_PROCESO_1[0]->IDE_CONVOCATORIA;
        $VDES_OBJETO = $DataSet_PROCESO_1[0]->DES_OBJETO;
        $VIMP_VAL_REFERENCIAL = $DataSet_PROCESO_1[0]->IMP_VAL_REFERENCIAL;
        $lCollection->Add('VIDE_CONVOCATORIA', $VIDE_CONVOCATORIA);
        $lCollection->Add('VDES_OBJETO', $VDES_OBJETO);
        $lCollection->Add('VIMP_VAL_REFERENCIAL', $VIMP_VAL_REFERENCIAL);
        
        
        
        $DataSet_GEN_TABLAS = array();
        $Objeto_EST_PROC_CRONOGRAMA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROC_CRONOGRAMA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS', $DataSet_GEN_TABLAS);

        $lCollection->Add('Proceso', $Proceso);
        //$lCollection->Add('Proceso', $ProcesoDescripcion);

        /* 					 */
        
        /* EDGAR */
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;