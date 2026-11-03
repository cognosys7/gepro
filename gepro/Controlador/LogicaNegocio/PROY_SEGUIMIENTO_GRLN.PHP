<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_SEGUIMIENTO_GRLN de la tabla PROY_SEGUIMIENTO_GR
  //  Fecha           : domingo, 16 de setiembre de 2018 01:28:27
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_SEGUIMIENTO_GRDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */
require_once(PATH_CONTROLADOR_DAO . "/PROYECTO_ACTIVIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


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
    $PaginaFormulario = "PROY_SEGUIMIENTO_GR";
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


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) : "";
        $DES_ADVERTENCIA = isset($_REQUEST['DES_ADVERTENCIA']) ? VerificarInputs($_REQUEST['DES_ADVERTENCIA']) : "";
        $DES_MEDIDA = isset($_REQUEST['DES_MEDIDA']) ? VerificarInputs($_REQUEST['DES_MEDIDA']) : "";
        $FEC_SEGUIMIENTO = isset($_REQUEST['FEC_SEGUIMIENTO']) ? VerificarInputs($_REQUEST['FEC_SEGUIMIENTO']) : "";
        $EST_PROY_SEGUIMIENTO = isset($_REQUEST['EST_PROY_SEGUIMIENTO']) ? VerificarInputs($_REQUEST['EST_PROY_SEGUIMIENTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR

        
        
        

        $ScriptFLX = " AND IDE_PROYECTO_ACTIVIDAD=$PIDE_PROYECTO_ACTIVIDAD";
        $DataSet_PROYECTO_ACTIVIDAD_1 = array();
        $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD_EJECUTORA, SEC_EJEC, DES_ENTIDAD, COD_PROYECTO, DES_PROYECTO_ITEM, FORMAT(IMP_COSTO_ACTUAL, 'c', 'es-PE') AS IMP_COSTO_ACTUAL";
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


       /* EDGAR */
        $Data2 = ProyectoActividad_Datos($PIDE_PROYECTO_ACTIVIDAD);
        $PIDE_PROYECTO = $Data2['IDE_PROYECTO'] ;
        $lCollection->Add('VIDE_PROYECTO', $PIDE_PROYECTO ) ;
        
        $Data3 = ProyectoContrato_Datos2($PIDE_PROYECTO_ACTIVIDAD,$PIDE_PROYECTO);
        $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
        
        $Data4 = ProyectoActividad_Datos($PIDE_PROYECTO_ACTIVIDAD);
        $lCollection->Add('VIDE_INTERVENCION', $Data4['IDE_INTERVENCION'] ) ;
        /* EDGAR */    

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_SEGUIMIENTO_GR_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_ADVERTENCIA') {
                        $_POST['qtype'] = 'DES_ADVERTENCIA';
                    }
                    if ($_POST['qtype'] == 'DES_MEDIDA') {
                        $_POST['qtype'] = 'DES_MEDIDA';
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
            $ogridDAO->Count_PROY_SEGUIMIENTO_GR($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_SEGUIMIENTO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_SEGUIMIENTO_GR', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_SEGUIMIENTO) > 0) {
                $FEC_SEGUIMIENTO = cambiafecha($FEC_SEGUIMIENTO);
            } else {
                $FEC_SEGUIMIENTO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_SEGUIMIENTO_GRM = array();
            $Objeto_PROY_SEGUIMIENTO_GR_DAO = new PROY_SEGUIMIENTO_GR_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_ADVERTENCIA)) > 0) {
                $lstparametrosM['DES_ADVERTENCIA'] = $DES_ADVERTENCIA;
            }
            if (strlen(rtrim($DES_MEDIDA)) > 0) {
                $lstparametrosM['DES_MEDIDA'] = $DES_MEDIDA;
            }
            if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0) {
                $lstparametrosM['FEC_SEGUIMIENTO'] = $FEC_SEGUIMIENTO;
            }
            if (strlen(rtrim($EST_PROY_SEGUIMIENTO)) > 0) {
                $lstparametrosM['EST_PROY_SEGUIMIENTO'] = $EST_PROY_SEGUIMIENTO;
            }

            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ADVERTENCIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_MEDIDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_SEGUIMIENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROY_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_SEGUIMIENTO_GR_DAO->Insert_PROY_SEGUIMIENTO_GR($DataSet_PROY_SEGUIMIENTO_GR, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_SEGUIMIENTO_GR = array();
            $Objeto_PROY_SEGUIMIENTO_GR_DAO = new PROY_SEGUIMIENTO_GR_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_SEGUIMIENTO_GR_DAO->SelPk_PROY_SEGUIMIENTO_GR($DataSet_PROY_SEGUIMIENTO_GR, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_SEGUIMIENTO_GR) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_SEGUIMIENTO_GR

                $IDE_PROYECTO_ACTIVIDAD = $DataSet_PROY_SEGUIMIENTO_GR[0]->IDE_PROYECTO_ACTIVIDAD;
                $DES_ADVERTENCIA = $DataSet_PROY_SEGUIMIENTO_GR[0]->DES_ADVERTENCIA;
                $DES_MEDIDA = $DataSet_PROY_SEGUIMIENTO_GR[0]->DES_MEDIDA;
                $FEC_SEGUIMIENTO = $DataSet_PROY_SEGUIMIENTO_GR[0]->FEC_SEGUIMIENTO;
                $EST_PROY_SEGUIMIENTO = $DataSet_PROY_SEGUIMIENTO_GR[0]->EST_PROY_SEGUIMIENTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO_ACTIVIDAD', $IDE_PROYECTO_ACTIVIDAD);
            $lCollection->Add('DES_ADVERTENCIA', $DES_ADVERTENCIA);
            $lCollection->Add('DES_MEDIDA', $DES_MEDIDA);
            $lCollection->Add('FEC_SEGUIMIENTO', $FEC_SEGUIMIENTO);
            $lCollection->Add('EST_PROY_SEGUIMIENTO', $EST_PROY_SEGUIMIENTO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_SEGUIMIENTO) > 0) {
                $FEC_SEGUIMIENTO = cambiafecha($FEC_SEGUIMIENTO);
            } else {
                $FEC_SEGUIMIENTO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_SEGUIMIENTO_GR = array();
            $Objeto_PROY_SEGUIMIENTO_GR_DAO = new PROY_SEGUIMIENTO_GR_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_ADVERTENCIA)) > 0) {
                $lstparametrosM['DES_ADVERTENCIA'] = $DES_ADVERTENCIA;
            }
            if (strlen(rtrim($DES_MEDIDA)) > 0) {
                $lstparametrosM['DES_MEDIDA'] = $DES_MEDIDA;
            }
            if (strlen(rtrim($FEC_SEGUIMIENTO)) > 0) {
                $lstparametrosM['FEC_SEGUIMIENTO'] = $FEC_SEGUIMIENTO;
            }
            if (strlen(rtrim($EST_PROY_SEGUIMIENTO)) > 0) {
                $lstparametrosM['EST_PROY_SEGUIMIENTO'] = $EST_PROY_SEGUIMIENTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ADVERTENCIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_MEDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROY_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_SEGUIMIENTO_GR_DAO->Update_PROY_SEGUIMIENTO_GR($DataSet_PROY_SEGUIMIENTO_GR, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_SEGUIMIENTO_GR = array();
            $Objeto_PROY_SEGUIMIENTO_GR_DAO = new PROY_SEGUIMIENTO_GR_DAO();
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
            $Objeto_PROY_SEGUIMIENTO_GR_DAO->Delete_PROY_SEGUIMIENTO_GR($DataSet_PROY_SEGUIMIENTO_GR, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_PROY_SEGUIMIENTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROY_SEGUIMIENTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        $lCollection->Add('PIDE_PROYECTO_ACTIVIDAD', $PIDE_PROYECTO_ACTIVIDAD);
        
    /* EDGAR */
	$lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    /* EDGAR */
        
    }
}

//var_dump($lstDepartamento);exit;