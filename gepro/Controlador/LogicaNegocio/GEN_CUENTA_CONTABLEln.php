<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : GEN_CUENTA_CONTABLELN de la tabla GEN_CUENTA_CONTABLE
  //  Fecha           : sábado, 25 de mayo de 2019 23:54:48
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-I
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_CUENTA_CONTABLEDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/GEN_CUENTA_CONTABLElni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_CUENTA_CONTABLE";
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
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $COD_CUENTA_CONTABLE = isset($_REQUEST['COD_CUENTA_CONTABLE']) ? VerificarInputs($_REQUEST['COD_CUENTA_CONTABLE']) : "";
        $DES_CUENTA_CONTABLE = isset($_REQUEST['DES_CUENTA_CONTABLE']) ? VerificarInputs($_REQUEST['DES_CUENTA_CONTABLE']) : "";
        $EST_CUENTA_CONTABLE = isset($_REQUEST['EST_CUENTA_CONTABLE']) ? VerificarInputs($_REQUEST['EST_CUENTA_CONTABLE']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_CUENTA_CONTABLE';

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
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_GEN_CUENTA_CONTABLE_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_CUENTA_CONTABLE_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_CUENTA_CONTABLE') {
                        $_POST['qtype'] = 'T.COD_CUENTA_CONTABLE';
                    }
                    if ($_POST['qtype'] == 'DES_CUENTA_CONTABLE') {
                        $_POST['qtype'] = 'T.DES_CUENTA_CONTABLE';
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
            $ogridDAO->Count_GEN_CUENTA_CONTABLE($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CUENTA_CONTABLE;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
            $Data = CuentaContable_Datos($PIDEbuscado);
            
            $Bdescripcion = '(  '. $Data['COD_CUENTA_CONTABLE'] .' ) '. $Data['DES_CUENTA_CONTABLE'] ;
            
            $lCollection->Add('BIDE', $Data['BIDE']);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_CUENTA_CONTABLEM = array();
            $Objeto_GEN_CUENTA_CONTABLE_DAO = new GEN_CUENTA_CONTABLE_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($COD_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['COD_CUENTA_CONTABLE'] = $COD_CUENTA_CONTABLE;
            }
            if (strlen(rtrim($DES_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['DES_CUENTA_CONTABLE'] = $DES_CUENTA_CONTABLE;
            }
            if (strlen(rtrim($EST_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['EST_CUENTA_CONTABLE'] = $EST_CUENTA_CONTABLE;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['COD_CUENTA_CONTABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CUENTA_CONTABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CUENTA_CONTABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_CUENTA_CONTABLE_DAO->Insert_GEN_CUENTA_CONTABLE($DataSet_GEN_CUENTA_CONTABLE, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[4][0];

            $mensaje = $procedure_parametrosMS[5][0];

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
            $DataSet_GEN_CUENTA_CONTABLE = array();
            $Objeto_GEN_CUENTA_CONTABLE_DAO = new GEN_CUENTA_CONTABLE_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_CUENTA_CONTABLE_DAO->SelPk_GEN_CUENTA_CONTABLE($DataSet_GEN_CUENTA_CONTABLE, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_CUENTA_CONTABLE) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_CUENTA_CONTABLE

                $COD_CUENTA_CONTABLE = $DataSet_GEN_CUENTA_CONTABLE[0]->COD_CUENTA_CONTABLE;
                $DES_CUENTA_CONTABLE = $DataSet_GEN_CUENTA_CONTABLE[0]->DES_CUENTA_CONTABLE;
                $EST_CUENTA_CONTABLE = $DataSet_GEN_CUENTA_CONTABLE[0]->EST_CUENTA_CONTABLE;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('COD_CUENTA_CONTABLE', $COD_CUENTA_CONTABLE);
            $lCollection->Add('DES_CUENTA_CONTABLE', $DES_CUENTA_CONTABLE);
            $lCollection->Add('EST_CUENTA_CONTABLE', $EST_CUENTA_CONTABLE);

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data = UBIGEO_Datos($COD_UBIGEO);
            //$lCollection->Add('DES_UBIGEO', '('.$COD_UBIGEO.') '.$Data['DES_DEPARTAMENTO'].' - '.$Data['DES_PROVINCIA'].' - '.$Data['DES_DISTRITO'] );
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_CUENTA_CONTABLE = array();
            $Objeto_GEN_CUENTA_CONTABLE_DAO = new GEN_CUENTA_CONTABLE_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($COD_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['COD_CUENTA_CONTABLE'] = $COD_CUENTA_CONTABLE;
            }
            if (strlen(rtrim($DES_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['DES_CUENTA_CONTABLE'] = $DES_CUENTA_CONTABLE;
            }
            if (strlen(rtrim($EST_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['EST_CUENTA_CONTABLE'] = $EST_CUENTA_CONTABLE;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_CUENTA_CONTABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CUENTA_CONTABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CUENTA_CONTABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_CUENTA_CONTABLE_DAO->Update_GEN_CUENTA_CONTABLE($DataSet_GEN_CUENTA_CONTABLE, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[5][0];

            $mensaje = $procedure_parametrosMS[6][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_CUENTA_CONTABLE = array();
            $Objeto_GEN_CUENTA_CONTABLE_DAO = new GEN_CUENTA_CONTABLE_DAO();
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
            $Objeto_GEN_CUENTA_CONTABLE_DAO->Delete_GEN_CUENTA_CONTABLE($DataSet_GEN_CUENTA_CONTABLE, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_CUENTA_CONTABLE_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CUENTA_CONTABLE_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;