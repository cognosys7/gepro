<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : GEN_PROVEEDORLN de la tabla GEN_PROVEEDOR
  //  Fecha           : martes, 7 de mayo de 2019 14:18:07
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-D
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_PROVEEDORDAO.php");
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
    $PaginaFormulario = "GEN_PROVEEDOR";
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

        /* EDGAR */
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $COD_PROVEEDOR = isset($_REQUEST['COD_PROVEEDOR']) ? VerificarInputs($_REQUEST['COD_PROVEEDOR']) : "";
        $COD_RUC = isset($_REQUEST['COD_RUC']) ? VerificarInputs($_REQUEST['COD_RUC']) : "";
        $DES_PROVEEDOR = isset($_REQUEST['DES_PROVEEDOR']) ? VerificarInputs($_REQUEST['DES_PROVEEDOR']) : "";
        $DES_DIRECCION = isset($_REQUEST['DES_DIRECCION']) ? VerificarInputs($_REQUEST['DES_DIRECCION']) : "";
        $DES_COMENTARIO = isset($_REQUEST['DES_COMENTARIO']) ? VerificarInputs($_REQUEST['DES_COMENTARIO']) : "";
        $EST_PROVEEDOR = isset($_REQUEST['EST_PROVEEDOR']) ? VerificarInputs($_REQUEST['EST_PROVEEDOR']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
//       if ( $PIDE>0 ){
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
//             $Data = GenTablas_Datos1($PIDE);
//             $lCollection->Add('VDES_ITEM', $Data['DES_ITEM'] );
//             $lCollection->Add('VDES_ABREVIATURA', $Data['DES_ABREVIATURA'] );
//             $lCollection->Add('VCOD_TABLA', $Data['COD_TABLA'] );
//       } else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_PROVEEDOR_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_PROVEEDOR') {
                        $_POST['qtype'] = 'T.COD_PROVEEDOR';
                    }
                    if ($_POST['qtype'] == 'COD_RUC') {
                        $_POST['qtype'] = 'T.COD_RUC';
                    }
                    if ($_POST['qtype'] == 'DES_PROVEEDOR') {
                        $_POST['qtype'] = 'T.DES_PROVEEDOR';
                    }
                    if ($_POST['qtype'] == 'Estado') {
                        $_POST['qtype'] = 'T1.DES_ITEM';
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
            $ogridDAO->Count_GEN_PROVEEDOR($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROVEEDOR;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_PROVEEDOR', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_PROVEEDORM = array();
            $Objeto_GEN_PROVEEDOR_DAO = new GEN_PROVEEDOR_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($COD_PROVEEDOR)) > 0) {
                $lstparametrosM['COD_PROVEEDOR'] = $COD_PROVEEDOR;
            }
            if (strlen(rtrim($COD_RUC)) > 0) {
                $lstparametrosM['COD_RUC'] = $COD_RUC;
            }
            if (strlen(rtrim($DES_PROVEEDOR)) > 0) {
                $lstparametrosM['DES_PROVEEDOR'] = $DES_PROVEEDOR;
            }
            if (strlen(rtrim($DES_DIRECCION)) > 0) {
                $lstparametrosM['DES_DIRECCION'] = $DES_DIRECCION;
            }
            if (strlen(rtrim($DES_COMENTARIO)) > 0) {
                $lstparametrosM['DES_COMENTARIO'] = $DES_COMENTARIO;
            }
            if (strlen(rtrim($EST_PROVEEDOR)) > 0) {
                $lstparametrosM['EST_PROVEEDOR'] = $EST_PROVEEDOR;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['COD_PROVEEDOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_RUC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROVEEDOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DIRECCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_COMENTARIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROVEEDOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_PROVEEDOR_DAO->Insert_GEN_PROVEEDOR($DataSet_GEN_PROVEEDOR, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_PROVEEDOR = array();
            $Objeto_GEN_PROVEEDOR_DAO = new GEN_PROVEEDOR_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_PROVEEDOR_DAO->SelPk_GEN_PROVEEDOR($DataSet_GEN_PROVEEDOR, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_PROVEEDOR) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_PROVEEDOR

                $COD_PROVEEDOR = $DataSet_GEN_PROVEEDOR[0]->COD_PROVEEDOR;
                $COD_RUC = $DataSet_GEN_PROVEEDOR[0]->COD_RUC;
                $DES_PROVEEDOR = $DataSet_GEN_PROVEEDOR[0]->DES_PROVEEDOR;
                $DES_DIRECCION = $DataSet_GEN_PROVEEDOR[0]->DES_DIRECCION;
                $DES_COMENTARIO = $DataSet_GEN_PROVEEDOR[0]->DES_COMENTARIO;
                $EST_PROVEEDOR = $DataSet_GEN_PROVEEDOR[0]->EST_PROVEEDOR;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('COD_PROVEEDOR', $COD_PROVEEDOR);
            $lCollection->Add('COD_RUC', $COD_RUC);
            $lCollection->Add('DES_PROVEEDOR', $DES_PROVEEDOR);
            $lCollection->Add('DES_DIRECCION', $DES_DIRECCION);
            $lCollection->Add('DES_COMENTARIO', $DES_COMENTARIO);
            $lCollection->Add('EST_PROVEEDOR', $EST_PROVEEDOR);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_PROVEEDOR = array();
            $Objeto_GEN_PROVEEDOR_DAO = new GEN_PROVEEDOR_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($COD_PROVEEDOR)) > 0) {
                $lstparametrosM['COD_PROVEEDOR'] = $COD_PROVEEDOR;
            }
            if (strlen(rtrim($COD_RUC)) > 0) {
                $lstparametrosM['COD_RUC'] = $COD_RUC;
            }
            if (strlen(rtrim($DES_PROVEEDOR)) > 0) {
                $lstparametrosM['DES_PROVEEDOR'] = $DES_PROVEEDOR;
            }
            if (strlen(rtrim($DES_DIRECCION)) > 0) {
                $lstparametrosM['DES_DIRECCION'] = $DES_DIRECCION;
            }
            if (strlen(rtrim($DES_COMENTARIO)) > 0) {
                $lstparametrosM['DES_COMENTARIO'] = $DES_COMENTARIO;
            }
            if (strlen(rtrim($EST_PROVEEDOR)) > 0) {
                $lstparametrosM['EST_PROVEEDOR'] = $EST_PROVEEDOR;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_PROVEEDOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_RUC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROVEEDOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DIRECCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_COMENTARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROVEEDOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_PROVEEDOR_DAO->Update_GEN_PROVEEDOR($DataSet_GEN_PROVEEDOR, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[8][0];

            $mensaje = $procedure_parametrosMS[9][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_PROVEEDOR = array();
            $Objeto_GEN_PROVEEDOR_DAO = new GEN_PROVEEDOR_DAO();
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
            $Objeto_GEN_PROVEEDOR_DAO->Delete_GEN_PROVEEDOR($DataSet_GEN_PROVEEDOR, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_PROVEEDOR_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROVEEDOR_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;