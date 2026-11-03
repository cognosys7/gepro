<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_CONTRATO_GASTO_DIRLN de la tabla PROY_CONTRATO_GASTO_DIR
  //  Fecha           : martes, 28 de mayo de 2019 21:00:04
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-I
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_CONTRATO_GASTO_DIRDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_CENTRO_COSTODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_FUENTE_FINANCIAMIENTODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/GEN_CUENTA_CONTABLElni.php");
require_once("include/GEN_ESPECIFICA_GASTOlni.php");
require_once("include/PROY_COMPONENTElni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_CONTRATO_GASTO_DIR";
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
        $COD_ANHO_EJECUCION = isset($_REQUEST['COD_ANHO_EJECUCION']) ? VerificarInputs($_REQUEST['COD_ANHO_EJECUCION']) : "";
        $IDE_CENCOSTO = isset($_REQUEST['IDE_CENCOSTO']) ? VerificarInputs($_REQUEST['IDE_CENCOSTO']) : "";
        $IDE_ESPECIFICA_GASTO = isset($_REQUEST['IDE_ESPECIFICA_GASTO']) ? VerificarInputs($_REQUEST['IDE_ESPECIFICA_GASTO']) : "";
        $IDE_CUENTA_CONTABLE = isset($_REQUEST['IDE_CUENTA_CONTABLE']) ? VerificarInputs($_REQUEST['IDE_CUENTA_CONTABLE']) : "";
        $IDE_FTE_FTO = isset($_REQUEST['IDE_FTE_FTO']) ? VerificarInputs($_REQUEST['IDE_FTE_FTO']) : "";
        $IMP_PIA = isset($_REQUEST['IMP_PIA']) ? VerificarInputs($_REQUEST['IMP_PIA']) : "";
        $IMP_PIM = isset($_REQUEST['IMP_PIM']) ? VerificarInputs($_REQUEST['IMP_PIM']) : "";
        $IMP_COMPROMISO = isset($_REQUEST['IMP_COMPROMISO']) ? VerificarInputs($_REQUEST['IMP_COMPROMISO']) : "";
        $IMP_DEVENGADO = isset($_REQUEST['IMP_DEVENGADO']) ? VerificarInputs($_REQUEST['IMP_DEVENGADO']) : "";
        $IMP_GIRADO = isset($_REQUEST['IMP_GIRADO']) ? VerificarInputs($_REQUEST['IMP_GIRADO']) : "";
        $EST_CONT_PRESUPUESTO = isset($_REQUEST['EST_CONT_PRESUPUESTO']) ? VerificarInputs($_REQUEST['EST_CONT_PRESUPUESTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROY_CONTRATO_GASTO_DIR';

       if ( $PIDE>0 ){
             
//             $pAuxiliar = '';
//              
//             $IDE_CONTRATO_ETAPA = $PIDE; /* añadido por julio meza */
//            
             $Data = ProyectoComponente_Datos2($PIDE);
             $IDE_CONTRATO_ETAPA = $Data['IDE_PROY_COMPONENTE'];
             $lCollection->Add('VIDE_CONTRATO_ETAPA', $IDE_CONTRATO_ETAPA );
             
             $ScriptFLX = $ScriptFLX." AND T.IDE_CONTRATO_ETAPA=$IDE_CONTRATO_ETAPA";
//             $lCollection->Add('VDES_ITEM', $Data['ProyectoComponente_Datos'] );
//             $lCollection->Add('VDES_ABREVIATURA', $Data['DES_ABREVIATURA'] );
//             $lCollection->Add('VCOD_TABLA', $Data['COD_TABLA'] );
       } 
//           else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_PROY_CONTRATO_GASTO_DIR_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_CONTRATO_GASTO_DIR_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_ANHO_EJECUCION') {
                        $_POST['qtype'] = 'T.COD_ANHO_EJECUCION';
                    }
                    if ($_POST['qtype'] == 'IDE_CENCOSTO') {
                        $_POST['qtype'] = 'CC.DES_CENCOSTO';
                    }
                    if ($_POST['qtype'] == 'COD_ESPECIFICA_GASTO') {
                        $_POST['qtype'] = 'EG.COD_ESPECIFICA_GASTO';
                    }
                    if ($_POST['qtype'] == 'DES_ESPECIFICA_GASTO') {
                        $_POST['qtype'] = 'EG.DES_ESPECIFICA_GASTO';
                    }
                    if ($_POST['qtype'] == 'IDE_CUENTA_CONTABLE') {
                        $_POST['qtype'] = 'CU.DES_CUENTA_CONTABLE';
                    }
                    if ($_POST['qtype'] == 'IDE_FTE_FTO') {
                        $_POST['qtype'] = 'FF.DES_FTE_FTO';
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
            $ogridDAO->Count_PROY_CONTRATO_GASTO_DIR($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONTRATO_ETAPA;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data = Comunidad_Datos($PIDEbuscado);
            $lCollection->Add('VCOD_UBIGEO', $Data['COD_UBIGEO']);
            $lCollection->Add('VDES_COMUNIDAD', $Data['DES_COMUNIDAD']);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROY_CONTRATO_GASTO_DIRM = array();
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO = new PROY_CONTRATO_GASTO_DIR_DAO();
            $lstparametrosM = array();
            
            if (strlen(rtrim($IDE_CONTRATO_ETAPA)) > 0) {
                $lstparametrosM['IDE_CONTRATO_ETAPA'] = $IDE_CONTRATO_ETAPA;
            }
            if (strlen(rtrim($COD_ANHO_EJECUCION)) > 0) {
                $lstparametrosM['COD_ANHO_EJECUCION'] = $COD_ANHO_EJECUCION;
            }
            if (strlen(rtrim($IDE_CENCOSTO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO'] = $IDE_CENCOSTO;
            }
            if (strlen(rtrim($IDE_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['IDE_ESPECIFICA_GASTO'] = $IDE_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($IDE_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['IDE_CUENTA_CONTABLE'] = $IDE_CUENTA_CONTABLE;
            }
            if (strlen(rtrim($IDE_FTE_FTO)) > 0) {
                $lstparametrosM['IDE_FTE_FTO'] = $IDE_FTE_FTO;
            }
            if (strlen(rtrim($IMP_PIA)) > 0) {
                $lstparametrosM['IMP_PIA'] = $IMP_PIA;
            }
            if (strlen(rtrim($IMP_PIM)) > 0) {
                $lstparametrosM['IMP_PIM'] = $IMP_PIM;
            }
            if (strlen(rtrim($IMP_COMPROMISO)) > 0) {
                $lstparametrosM['IMP_COMPROMISO'] = $IMP_COMPROMISO;
            }
            if (strlen(rtrim($IMP_DEVENGADO)) > 0) {
                $lstparametrosM['IMP_DEVENGADO'] = $IMP_DEVENGADO;
            }
            if (strlen(rtrim($IMP_GIRADO)) > 0) {
                $lstparametrosM['IMP_GIRADO'] = $IMP_GIRADO;
            }
            if (strlen(rtrim($EST_CONT_PRESUPUESTO)) > 0) {
                $lstparametrosM['EST_CONT_PRESUPUESTO'] = $EST_CONT_PRESUPUESTO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONTRATO_ETAPA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ANHO_EJECUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CENCOSTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CUENTA_CONTABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_FTE_FTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_PIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_PIM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_COMPROMISO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_DEVENGADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_GIRADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CONT_PRESUPUESTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO->Insert_PROY_CONTRATO_GASTO_DIR($DataSet_PROY_CONTRATO_GASTO_DIR, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[13][0];

            $mensaje = $procedure_parametrosMS[14][0];

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
            $DataSet_PROY_CONTRATO_GASTO_DIR = array();
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO = new PROY_CONTRATO_GASTO_DIR_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO->SelPk_PROY_CONTRATO_GASTO_DIR($DataSet_PROY_CONTRATO_GASTO_DIR, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_CONTRATO_GASTO_DIR) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_CONTRATO_GASTO_DIR
                
                $IDE_CONTRATO_ETAPA = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IDE_CONTRATO_ETAPA;
                $COD_ANHO_EJECUCION = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->COD_ANHO_EJECUCION;
                $IDE_CENCOSTO = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IDE_CENCOSTO;
                $IDE_ESPECIFICA_GASTO = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IDE_ESPECIFICA_GASTO;
                $IDE_CUENTA_CONTABLE = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IDE_CUENTA_CONTABLE;
                $IDE_FTE_FTO = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IDE_FTE_FTO;
                $IMP_PIA = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IMP_PIA;
                $IMP_PIM = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IMP_PIM;
                $IMP_COMPROMISO = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IMP_COMPROMISO;
                $IMP_DEVENGADO = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IMP_DEVENGADO;
                $IMP_GIRADO = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->IMP_GIRADO;
                $EST_CONT_PRESUPUESTO = $DataSet_PROY_CONTRATO_GASTO_DIR[0]->EST_CONT_PRESUPUESTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONTRATO_ETAPA', $IDE_CONTRATO_ETAPA);
            $lCollection->Add('COD_ANHO_EJECUCION', $COD_ANHO_EJECUCION);
            $lCollection->Add('IDE_CENCOSTO', $IDE_CENCOSTO);
            $lCollection->Add('IDE_ESPECIFICA_GASTO', $IDE_ESPECIFICA_GASTO);
            $lCollection->Add('IDE_CUENTA_CONTABLE', $IDE_CUENTA_CONTABLE);
            $lCollection->Add('IDE_FTE_FTO', $IDE_FTE_FTO);
            $lCollection->Add('IMP_PIA', $IMP_PIA);
            $lCollection->Add('IMP_PIM', $IMP_PIM);
            $lCollection->Add('IMP_COMPROMISO', $IMP_COMPROMISO);
            $lCollection->Add('IMP_DEVENGADO', $IMP_DEVENGADO);
            $lCollection->Add('IMP_GIRADO', $IMP_GIRADO);
            $lCollection->Add('EST_CONT_PRESUPUESTO', $EST_CONT_PRESUPUESTO);

            
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data = CuentaContable_Datos($IDE_CUENTA_CONTABLE);
            $Data1 = EspecificaGasto_Datos($IDE_ESPECIFICA_GASTO);
            
            $B_CUENTA_CONTABLE = '(  '. $Data['COD_CUENTA_CONTABLE'] .' ) '. $Data['DES_CUENTA_CONTABLE'] ;
            $B_ESPECIFICA_GASTO = '(  '. $Data1['COD_ESPECIFICA_GASTO'] .' ) '. $Data1['DES_ESPECIFICA_GASTO'] ;
            
            $lCollection->Add('B_ESPECIFICA_GASTO', $B_ESPECIFICA_GASTO);
            $lCollection->Add('B_CUENTA_CONTABLE', $B_CUENTA_CONTABLE);
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_CONTRATO_GASTO_DIR = array();
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO = new PROY_CONTRATO_GASTO_DIR_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONTRATO_ETAPA)) > 0) {
                $lstparametrosM['IDE_CONTRATO_ETAPA'] = $IDE_CONTRATO_ETAPA;
            }
            if (strlen(rtrim($COD_ANHO_EJECUCION)) > 0) {
                $lstparametrosM['COD_ANHO_EJECUCION'] = $COD_ANHO_EJECUCION;
            }
            if (strlen(rtrim($IDE_CENCOSTO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO'] = $IDE_CENCOSTO;
            }
            if (strlen(rtrim($IDE_ESPECIFICA_GASTO)) > 0) {
                $lstparametrosM['IDE_ESPECIFICA_GASTO'] = $IDE_ESPECIFICA_GASTO;
            }
            if (strlen(rtrim($IDE_CUENTA_CONTABLE)) > 0) {
                $lstparametrosM['IDE_CUENTA_CONTABLE'] = $IDE_CUENTA_CONTABLE;
            }
            if (strlen(rtrim($IDE_FTE_FTO)) > 0) {
                $lstparametrosM['IDE_FTE_FTO'] = $IDE_FTE_FTO;
            }
            if (strlen(rtrim($IMP_PIA)) > 0) {
                $lstparametrosM['IMP_PIA'] = $IMP_PIA;
            }
            if (strlen(rtrim($IMP_PIM)) > 0) {
                $lstparametrosM['IMP_PIM'] = $IMP_PIM;
            }
            if (strlen(rtrim($IMP_COMPROMISO)) > 0) {
                $lstparametrosM['IMP_COMPROMISO'] = $IMP_COMPROMISO;
            }
            if (strlen(rtrim($IMP_DEVENGADO)) > 0) {
                $lstparametrosM['IMP_DEVENGADO'] = $IMP_DEVENGADO;
            }
            if (strlen(rtrim($IMP_GIRADO)) > 0) {
                $lstparametrosM['IMP_GIRADO'] = $IMP_GIRADO;
            }
            if (strlen(rtrim($EST_CONT_PRESUPUESTO)) > 0) {
                $lstparametrosM['EST_CONT_PRESUPUESTO'] = $EST_CONT_PRESUPUESTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONTRATO_ETAPA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ANHO_EJECUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CENCOSTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ESPECIFICA_GASTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CUENTA_CONTABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_FTE_FTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_PIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_PIM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_COMPROMISO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_DEVENGADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_GIRADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CONT_PRESUPUESTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO->Update_PROY_CONTRATO_GASTO_DIR($DataSet_PROY_CONTRATO_GASTO_DIR, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[14][0];

            $mensaje = $procedure_parametrosMS[15][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_CONTRATO_GASTO_DIR = array();
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO = new PROY_CONTRATO_GASTO_DIR_DAO();
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
            $Objeto_PROY_CONTRATO_GASTO_DIR_DAO->Delete_PROY_CONTRATO_GASTO_DIR($DataSet_PROY_CONTRATO_GASTO_DIR, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_CENTRO_COSTO_1 = array();
        $Objeto_IDE_CENCOSTO_DAO = new GEN_CENTRO_COSTO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CENCOSTO,DES_CENCOSTO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_CENCOSTO_DAO->SelCampos_GEN_CENTRO_COSTO($DataSet_GEN_CENTRO_COSTO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_CENTRO_COSTO_1', $DataSet_GEN_CENTRO_COSTO_1);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_FUENTE_FINANCIAMIENTO_1 = array();
        $Objeto_IDE_FTE_FTO_DAO = new GEN_FUENTE_FINANCIAMIENTO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_FTE_FTO,DES_FTE_FTO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_FTE_FTO_DAO->SelCampos_GEN_FUENTE_FINANCIAMIENTO($DataSet_GEN_FUENTE_FINANCIAMIENTO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_FUENTE_FINANCIAMIENTO_1', $DataSet_GEN_FUENTE_FINANCIAMIENTO_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_CONT_PRESUPUESTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CONT_PRESUPUESTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
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