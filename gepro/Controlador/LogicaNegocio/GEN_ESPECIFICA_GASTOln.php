<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : GEN_ESPECIFICA_GASTOLN de la tabla GEN_ESPECIFICA_GASTO
  //  Fecha           : domingo, 26 de mayo de 2019 2:36:59
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-I
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_ESPECIFICA_GASTODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/GEN_ESPECIFICA_GASTOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_ESPECIFICA_GASTO";
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
        $NUM_ANHO = isset($_REQUEST['NUM_ANHO']) ? VerificarInputs($_REQUEST['NUM_ANHO']) : "";
        $COD_ESPECIFICA_GASTO = isset($_REQUEST['COD_ESPECIFICA_GASTO']) ? VerificarInputs($_REQUEST['COD_ESPECIFICA_GASTO']) : "";
        $DES_ESPECIFICA_GASTO = isset($_REQUEST['DES_ESPECIFICA_GASTO']) ? VerificarInputs($_REQUEST['DES_ESPECIFICA_GASTO']) : "";
        $COD_GENERICA = isset($_REQUEST['COD_GENERICA']) ? VerificarInputs($_REQUEST['COD_GENERICA']) : "";
        $DES_GENERICA = isset($_REQUEST['DES_GENERICA']) ? VerificarInputs($_REQUEST['DES_GENERICA']) : "";
        $COD_SUBGENERICA = isset($_REQUEST['COD_SUBGENERICA']) ? VerificarInputs($_REQUEST['COD_SUBGENERICA']) : "";
        $DES_SUBGENERICA = isset($_REQUEST['DES_SUBGENERICA']) ? VerificarInputs($_REQUEST['DES_SUBGENERICA']) : "";
        $COD_SUBGENERICA_DET = isset($_REQUEST['COD_SUBGENERICA_DET']) ? VerificarInputs($_REQUEST['COD_SUBGENERICA_DET']) : "";
        $DES_SUBGNERICA_DET = isset($_REQUEST['DES_SUBGNERICA_DET']) ? VerificarInputs($_REQUEST['DES_SUBGNERICA_DET']) : "";
        $COD_ESPECIFICA = isset($_REQUEST['COD_ESPECIFICA']) ? VerificarInputs($_REQUEST['COD_ESPECIFICA']) : "";
        $DES_ESPECIFICA = isset($_REQUEST['DES_ESPECIFICA']) ? VerificarInputs($_REQUEST['DES_ESPECIFICA']) : "";
        $COD_ESPECIFICA_DET = isset($_REQUEST['COD_ESPECIFICA_DET']) ? VerificarInputs($_REQUEST['COD_ESPECIFICA_DET']) : "";
        $DES_ESPECIFICA_DET = isset($_REQUEST['DES_ESPECIFICA_DET']) ? VerificarInputs($_REQUEST['DES_ESPECIFICA_DET']) : "";
        $EST_ESPECIFICA_GASTO = isset($_REQUEST['EST_ESPECIFICA_GASTO']) ? VerificarInputs($_REQUEST['EST_ESPECIFICA_GASTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_ESPECIFICA_GASTO';

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
            $TipoGrilla = 'SelGrd_GEN_ESPECIFICA_GASTO_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_ESPECIFICA_GASTO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'NUM_ANHO') {
                        $_POST['qtype'] = 'T.NUM_ANHO';
                    }
                    if ($_POST['qtype'] == 'COD_ESPECIFICA_GASTO') {
                        $_POST['qtype'] = 'T.COD_ESPECIFICA_GASTO';
                    }
                    if ($_POST['qtype'] == 'DES_ESPECIFICA_GASTO') {
                        $_POST['qtype'] = 'T.DES_ESPECIFICA_GASTO';
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
            $ogridDAO->Count_GEN_ESPECIFICA_GASTO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_ESPECIFICA_GASTO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
            $Data = EspecificaGasto_Datos($PIDEbuscado);
            
            $Bdescripcion = '(  '. $Data['COD_ESPECIFICA_GASTO'] .' ) '. $Data['DES_ESPECIFICA_GASTO'] ;
            
            $lCollection->Add('BIDE', $Data['BIDE']);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_ESPECIFICA_GASTOM = array();
            $Objeto_GEN_ESPECIFICA_GASTO_DAO = new GEN_ESPECIFICA_GASTO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($NUM_ANHO)) > 0) {
                $lstparametrosM['NUM_ANHO'] = $NUM_ANHO;
            }
            if (strlen(rtrim($COD_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['COD_ESPECIFICA_GASTO'] = $COD_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($DES_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['DES_ESPECIFICA_GASTO'] = $DES_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($COD_GENERICA)) > 0) {
                $lstparametrosM['COD_GENERICA'] = $COD_GENERICA;
            }
            if (strlen(rtrim($DES_GENERICA)) > 0) {
                $lstparametrosM['DES_GENERICA'] = $DES_GENERICA;
            }
            if (strlen(rtrim($COD_SUBGENERICA)) > 0) {
                $lstparametrosM['COD_SUBGENERICA'] = $COD_SUBGENERICA;
            }
            if (strlen(rtrim($DES_SUBGENERICA)) > 0) {
                $lstparametrosM['DES_SUBGENERICA'] = $DES_SUBGENERICA;
            }
            if (strlen(rtrim($COD_SUBGENERICA_DET)) > 0) {
                $lstparametrosM['COD_SUBGENERICA_DET'] = $COD_SUBGENERICA_DET;
            }
            if (strlen(rtrim($DES_SUBGNERICA_DET)) > 0) {
                $lstparametrosM['DES_SUBGNERICA_DET'] = $DES_SUBGNERICA_DET;
            }
            if (strlen(rtrim($COD_ESPECIFICA)) > 0) {
                $lstparametrosM['COD_ESPECIFICA'] = $COD_ESPECIFICA;
            }
            if (strlen(rtrim($DES_ESPECIFICA)) > 0) {
                $lstparametrosM['DES_ESPECIFICA'] = $DES_ESPECIFICA;
            }
            if (strlen(rtrim($COD_ESPECIFICA_DET)) > 0) {
                $lstparametrosM['COD_ESPECIFICA_DET'] = $COD_ESPECIFICA_DET;
            }
            if (strlen(rtrim($DES_ESPECIFICA_DET)) > 0) {
                $lstparametrosM['DES_ESPECIFICA_DET'] = $DES_ESPECIFICA_DET;
            }
            if (strlen(rtrim($EST_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['EST_ESPECIFICA_GASTO'] = $EST_ESPECIFICA_GASTO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['NUM_ANHO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_GENERICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_GENERICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_SUBGENERICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SUBGENERICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_SUBGENERICA_DET'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SUBGNERICA_DET'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ESPECIFICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ESPECIFICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ESPECIFICA_DET'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ESPECIFICA_DET'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ESPECIFICA_GASTO_DAO->Insert_GEN_ESPECIFICA_GASTO($DataSet_GEN_ESPECIFICA_GASTO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[15][0];

            $mensaje = $procedure_parametrosMS[16][0];

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
            $DataSet_GEN_ESPECIFICA_GASTO = array();
            $Objeto_GEN_ESPECIFICA_GASTO_DAO = new GEN_ESPECIFICA_GASTO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_ESPECIFICA_GASTO_DAO->SelPk_GEN_ESPECIFICA_GASTO($DataSet_GEN_ESPECIFICA_GASTO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_ESPECIFICA_GASTO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_ESPECIFICA_GASTO

                $NUM_ANHO = $DataSet_GEN_ESPECIFICA_GASTO[0]->NUM_ANHO;
                $COD_ESPECIFICA_GASTO = $DataSet_GEN_ESPECIFICA_GASTO[0]->COD_ESPECIFICA_GASTO;
                $DES_ESPECIFICA_GASTO = $DataSet_GEN_ESPECIFICA_GASTO[0]->DES_ESPECIFICA_GASTO;
                $COD_GENERICA = $DataSet_GEN_ESPECIFICA_GASTO[0]->COD_GENERICA;
                $DES_GENERICA = $DataSet_GEN_ESPECIFICA_GASTO[0]->DES_GENERICA;
                $COD_SUBGENERICA = $DataSet_GEN_ESPECIFICA_GASTO[0]->COD_SUBGENERICA;
                $DES_SUBGENERICA = $DataSet_GEN_ESPECIFICA_GASTO[0]->DES_SUBGENERICA;
                $COD_SUBGENERICA_DET = $DataSet_GEN_ESPECIFICA_GASTO[0]->COD_SUBGENERICA_DET;
                $DES_SUBGNERICA_DET = $DataSet_GEN_ESPECIFICA_GASTO[0]->DES_SUBGNERICA_DET;
                $COD_ESPECIFICA = $DataSet_GEN_ESPECIFICA_GASTO[0]->COD_ESPECIFICA;
                $DES_ESPECIFICA = $DataSet_GEN_ESPECIFICA_GASTO[0]->DES_ESPECIFICA;
                $COD_ESPECIFICA_DET = $DataSet_GEN_ESPECIFICA_GASTO[0]->COD_ESPECIFICA_DET;
                $DES_ESPECIFICA_DET = $DataSet_GEN_ESPECIFICA_GASTO[0]->DES_ESPECIFICA_DET;
                $EST_ESPECIFICA_GASTO = $DataSet_GEN_ESPECIFICA_GASTO[0]->EST_ESPECIFICA_GASTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('NUM_ANHO', $NUM_ANHO);
            $lCollection->Add('COD_ESPECIFICA_GASTO', $COD_ESPECIFICA_GASTO);
            $lCollection->Add('DES_ESPECIFICA_GASTO', $DES_ESPECIFICA_GASTO);
            $lCollection->Add('COD_GENERICA', $COD_GENERICA);
            $lCollection->Add('DES_GENERICA', $DES_GENERICA);
            $lCollection->Add('COD_SUBGENERICA', $COD_SUBGENERICA);
            $lCollection->Add('DES_SUBGENERICA', $DES_SUBGENERICA);
            $lCollection->Add('COD_SUBGENERICA_DET', $COD_SUBGENERICA_DET);
            $lCollection->Add('DES_SUBGNERICA_DET', $DES_SUBGNERICA_DET);
            $lCollection->Add('COD_ESPECIFICA', $COD_ESPECIFICA);
            $lCollection->Add('DES_ESPECIFICA', $DES_ESPECIFICA);
            $lCollection->Add('COD_ESPECIFICA_DET', $COD_ESPECIFICA_DET);
            $lCollection->Add('DES_ESPECIFICA_DET', $DES_ESPECIFICA_DET);
            $lCollection->Add('EST_ESPECIFICA_GASTO', $EST_ESPECIFICA_GASTO);

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
            $DataSet_GEN_ESPECIFICA_GASTO = array();
            $Objeto_GEN_ESPECIFICA_GASTO_DAO = new GEN_ESPECIFICA_GASTO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($NUM_ANHO)) > 0) {
                $lstparametrosM['NUM_ANHO'] = $NUM_ANHO;
            }
            if (strlen(rtrim($COD_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['COD_ESPECIFICA_GASTO'] = $COD_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($DES_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['DES_ESPECIFICA_GASTO'] = $DES_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($COD_GENERICA)) > 0) {
                $lstparametrosM['COD_GENERICA'] = $COD_GENERICA;
            }
            if (strlen(rtrim($DES_GENERICA)) > 0) {
                $lstparametrosM['DES_GENERICA'] = $DES_GENERICA;
            }
            if (strlen(rtrim($COD_SUBGENERICA)) > 0) {
                $lstparametrosM['COD_SUBGENERICA'] = $COD_SUBGENERICA;
            }
            if (strlen(rtrim($DES_SUBGENERICA)) > 0) {
                $lstparametrosM['DES_SUBGENERICA'] = $DES_SUBGENERICA;
            }
            if (strlen(rtrim($COD_SUBGENERICA_DET)) > 0) {
                $lstparametrosM['COD_SUBGENERICA_DET'] = $COD_SUBGENERICA_DET;
            }
            if (strlen(rtrim($DES_SUBGNERICA_DET)) > 0) {
                $lstparametrosM['DES_SUBGNERICA_DET'] = $DES_SUBGNERICA_DET;
            }
            if (strlen(rtrim($COD_ESPECIFICA)) > 0) {
                $lstparametrosM['COD_ESPECIFICA'] = $COD_ESPECIFICA;
            }
            if (strlen(rtrim($DES_ESPECIFICA)) > 0) {
                $lstparametrosM['DES_ESPECIFICA'] = $DES_ESPECIFICA;
            }
            if (strlen(rtrim($COD_ESPECIFICA_DET)) > 0) {
                $lstparametrosM['COD_ESPECIFICA_DET'] = $COD_ESPECIFICA_DET;
            }
            if (strlen(rtrim($DES_ESPECIFICA_DET)) > 0) {
                $lstparametrosM['DES_ESPECIFICA_DET'] = $DES_ESPECIFICA_DET;
            }
            if (strlen(rtrim($EST_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['EST_ESPECIFICA_GASTO'] = $EST_ESPECIFICA_GASTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_ANHO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_GENERICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_GENERICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_SUBGENERICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SUBGENERICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_SUBGENERICA_DET'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SUBGNERICA_DET'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ESPECIFICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ESPECIFICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ESPECIFICA_DET'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ESPECIFICA_DET'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ESPECIFICA_GASTO_DAO->Update_GEN_ESPECIFICA_GASTO($DataSet_GEN_ESPECIFICA_GASTO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[16][0];

            $mensaje = $procedure_parametrosMS[17][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_ESPECIFICA_GASTO = array();
            $Objeto_GEN_ESPECIFICA_GASTO_DAO = new GEN_ESPECIFICA_GASTO_DAO();
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
            $Objeto_GEN_ESPECIFICA_GASTO_DAO->Delete_GEN_ESPECIFICA_GASTO($DataSet_GEN_ESPECIFICA_GASTO, $procedure_parametrosMS); //JCMY
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

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_ESPECIFICA_GASTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ESPECIFICA_GASTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;