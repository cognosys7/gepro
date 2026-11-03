<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_RECURSOLN de la tabla GEN_RECURSO
  //  Fecha           : martes, 16 de enero de 2018 12:58:57 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


//require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/GEN_CARGOlni.php");
require_once("include/GEN_ENTIDADlni.php");
require_once("include/GEN_RECURSOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_RECURSO";
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

/***EDGAR---******************/
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : ""; 
        $PIDE_RECURSO = isset($_REQUEST['PIDE_RECURSO'])? VerificarInputs($_REQUEST['PIDE_RECURSO']) : "";
/***EDGAR---******************/ 
        
        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_ENTIDAD = isset($_REQUEST['IDE_ENTIDAD']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD']) : "";
        $TIP_RECURSO = isset($_REQUEST['TIP_RECURSO']) ? VerificarInputs($_REQUEST['TIP_RECURSO']) : "";
        $COD_RECURSO = isset($_REQUEST['COD_RECURSO']) ? VerificarInputs($_REQUEST['COD_RECURSO']) : "";
        $DES_RECURSO = isset($_REQUEST['DES_RECURSO']) ? VerificarInputs($_REQUEST['DES_RECURSO']) : "";
        $EST_RECURSO = isset($_REQUEST['EST_RECURSO']) ? VerificarInputs($_REQUEST['EST_RECURSO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            


        
        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_RECURSO';
        if ($Pedido == 'Busqueda') {
                    $TipoGrilla = 'SelGrd_GEN_RECURSO_busqueda';
        }
        /* EDGAR */
        
        
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_RECURSO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'NOMBRE_RECURSO') {
                        $_POST['qtype'] = 'GR.DES_RECURSO';
                    }
                    if ($_POST['qtype'] == 'TIPO_RECURSO') {
                        $_POST['qtype'] = 'GTR.DES_ITEM';
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
            $ogridDAO->Count_GEN_RECURSO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_RECURSO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        
        
/***EDGAR---**************/   
        if ($Action == "PasarDatos") { //echo 'entre';die;
//            $DataSet_GEN_RECURSO_1 = array();
//            $Objeto_IDE_RECURSO_DAO = new GEN_RECURSO_DAO();
//            $lstparametrosM = array();
//            $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO,IDE_ENTIDAD";
//            $lstparametrosM['filtro'] = " AND IDE_RECURSO = '".$PIDE_RECURSO."' " ;
//
//            $procedure_parametrosMS = array(
//                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
//                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
//            );
//            $Objeto_IDE_RECURSO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_1, $procedure_parametrosMS);            
//            $lCollection->Add('DataSet_GEN_RECURSO_1', $DataSet_GEN_RECURSO_1);
//
//            $IDE_RECURSO = $DES_RECURSO = $IDE_ENTIDAD = '' ;
//            $listaContador = count($DataSet_GEN_RECURSO_1) > 0 ? true : false;            
//            if (($listaContador == true) || ($listaContador > 0)) {
//                $IDE_RECURSO=$DataSet_GEN_RECURSO_1[0]->IDE_RECURSO;
//                $DES_RECURSO=$DataSet_GEN_RECURSO_1[0]->DES_RECURSO;
//                $IDE_ENTIDAD=$DataSet_GEN_RECURSO_1[0]->IDE_ENTIDAD;
//            }
            
            
            $Data = Recurso_Datos($PIDE_RECURSO);
            $lCollection->Add('BIDE', $Data['IDE_RECURSO']); //var_dump($Data);
            
            $Data1 = Entidad_Datos($Data['IDE_ENTIDAD']);
            $Bdescripcion = $Data['DES_RECURSO']; //.' [ '. $Data1['DES_ENTIDAD'] .' ( RUC: '. $Data1['COD_RUC'] .' ) ]' ;
            
            $lCollection->Add('Bdescripcion', $Bdescripcion);    //var_dump($Data1);        
        }
        
/***EDGAR---**************/  
        
        
        
        
        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_RECURSOM = array();
            $Objeto_GEN_RECURSO_DAO = new GEN_RECURSO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_ENTIDAD)) > 0) {
                $lstparametrosM['IDE_ENTIDAD'] = $IDE_ENTIDAD;
            }
            if (strlen(rtrim($TIP_RECURSO)) > 0) {
                $lstparametrosM['TIP_RECURSO'] = $TIP_RECURSO;
            }
            if (strlen(rtrim($COD_RECURSO)) > 0) {
                $lstparametrosM['COD_RECURSO'] = $COD_RECURSO;
            }
            if (strlen(rtrim($DES_RECURSO)) > 0) {
                $lstparametrosM['DES_RECURSO'] = $DES_RECURSO;
            }
            if (strlen(rtrim($EST_RECURSO)) > 0) {
                $lstparametrosM['EST_RECURSO'] = $EST_RECURSO;
            }

            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_ENTIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_RECURSO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_RECURSO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_RECURSO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_RECURSO_DAO->Insert_GEN_RECURSO($DataSet_GEN_RECURSO, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_RECURSO = array();
            $Objeto_GEN_RECURSO_DAO = new GEN_RECURSO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_RECURSO_DAO->SelPk_GEN_RECURSO($DataSet_GEN_RECURSO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_RECURSO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_RECURSO

                $IDE_ENTIDAD = $DataSet_GEN_RECURSO[0]->IDE_ENTIDAD;
                $TIP_RECURSO = $DataSet_GEN_RECURSO[0]->TIP_RECURSO;
                $COD_RECURSO = $DataSet_GEN_RECURSO[0]->COD_RECURSO;
                $DES_RECURSO = $DataSet_GEN_RECURSO[0]->DES_RECURSO;
                $EST_RECURSO = $DataSet_GEN_RECURSO[0]->EST_RECURSO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_ENTIDAD', $IDE_ENTIDAD);
            $lCollection->Add('TIP_RECURSO', $TIP_RECURSO);
            $lCollection->Add('COD_RECURSO', $COD_RECURSO);
            $lCollection->Add('DES_RECURSO', $DES_RECURSO);
            $lCollection->Add('EST_RECURSO', $EST_RECURSO);
            
            
            
            ////edgar: corrige: 
                $DES_ENTIDAD='';
                        
            $DataSet_GEN_ENTIDAD = array();
            $Objeto_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = " IDE_ENTIDAD, DES_ENTIDAD ";
            $lstparametrosM['filtro'] = "  AND IDE_ENTIDAD ='".$IDE_ENTIDAD."'";            
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_ENTIDAD_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD, $procedure_parametrosMS);            
            $listaContador = count($DataSet_GEN_ENTIDAD) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                $IDE_ENTIDAD=$DataSet_GEN_ENTIDAD[0]->IDE_ENTIDAD;
                $DES_ENTIDAD=$DataSet_GEN_ENTIDAD[0]->DES_ENTIDAD;
            }
            $lCollection->Add('DESCRIPCION_ENTIDAD_SOLICITANTE', $DES_ENTIDAD);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_RECURSO = array();
            $Objeto_GEN_RECURSO_DAO = new GEN_RECURSO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_ENTIDAD)) > 0) {
                $lstparametrosM['IDE_ENTIDAD'] = $IDE_ENTIDAD;
            }
            if (strlen(rtrim($TIP_RECURSO)) > 0) {
                $lstparametrosM['TIP_RECURSO'] = $TIP_RECURSO;
            }
            if (strlen(rtrim($COD_RECURSO)) > 0) {
                $lstparametrosM['COD_RECURSO'] = $COD_RECURSO;
            }
            if (strlen(rtrim($DES_RECURSO)) > 0) {
                $lstparametrosM['DES_RECURSO'] = $DES_RECURSO;
            }
            if (strlen(rtrim($EST_RECURSO)) > 0) {
                $lstparametrosM['EST_RECURSO'] = $EST_RECURSO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_RECURSO_DAO->Update_GEN_RECURSO($DataSet_GEN_RECURSO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_RECURSO = array();
            $Objeto_GEN_RECURSO_DAO = new GEN_RECURSO_DAO();
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
            $Objeto_GEN_RECURSO_DAO->Delete_GEN_RECURSO($DataSet_GEN_RECURSO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_ENTIDAD_1 = array();
        $Objeto_IDE_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD,DES_ENTIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ENTIDAD_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTIDAD_1', $DataSet_GEN_ENTIDAD_1);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_RECURSO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '21'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_RECURSO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_RECURSO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_RECURSO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */
        
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDE_RECURSO', $PIDE_RECURSO);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    }
}

//var_dump($lstDepartamento);exit;