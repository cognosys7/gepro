<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                     
//  Propósito       : PROY_CONT_COMP_CONTROL_DETln de la tabla PROY_CONT_COMP_CONTROL_DET
//  Fecha           : martes, 25 de mayo de 2021 14:16:41
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:16:41
//******************************************************************************/

require_once(PATH_CONTROLADOR_DAO . "/PROY_CONT_COMP_CONTROL_DETDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROY_COMPONENTElni.php");
require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/PROYECTOlni.php");
require_once("include/PROY_CONT_ETAPA_CONTROLlni.php");
require_once("include/PROY_CONT_COMP_CONTROL_DETlni.php");

//// busqueda lni
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_CONT_COMP_CONTROL_DET";
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
    $PermisoOK = VerificaAccesoMenu($Opcionsession, $perfilsession); // echo $PermisosPerfil; die;



    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";



        /* EDGAR */
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";
        $lCollection->Add('PIDE', $PIDE);

        ////// TIPO DE VENTANA: MANTENIMIENTO O BUSQUEDA-SELECCION
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $lCollection->Add('Pedido', $Pedido);

        ////// IDE: BUSQUEDA-SELECCION
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);

        ////// PARAMETROS DE FILTRO: RECURSIVO, O PERSONALIZACION DE TABLAS 
        $Recursiva_Nivel_Actual = isset($_REQUEST['Recursiva_Nivel_Actual']) ? VerificarInputs($_REQUEST['Recursiva_Nivel_Actual']) : "";

        /* EDGAR */



        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_CONT_ETAPA_CONTROL = isset($_REQUEST['IDE_CONT_ETAPA_CONTROL']) ? VerificarInputs($_REQUEST['IDE_CONT_ETAPA_CONTROL']) : "";
        $NUM_ITEM = isset($_REQUEST['NUM_ITEM']) ? VerificarInputs($_REQUEST['NUM_ITEM']) : "";
        $NUM_ANIO = isset($_REQUEST['NUM_ANIO']) ? VerificarInputs($_REQUEST['NUM_ANIO']) : "";
        $NUM_MES = isset($_REQUEST['NUM_MES']) ? VerificarInputs($_REQUEST['NUM_MES']) : "";
        
        $DES_CONCEPTO_PAGO = isset($_REQUEST['DES_CONCEPTO_PAGO']) ? VerificarInputs($_REQUEST['DES_CONCEPTO_PAGO']) : "";
        $PCT_AVANCE = isset($_REQUEST['PCT_AVANCE']) ? VerificarInputs($_REQUEST['PCT_AVANCE']) : "";
        $IMP_BRUTO = isset($_REQUEST['IMP_BRUTO']) ? VerificarInputs($_REQUEST['IMP_BRUTO']) : "";
        $IMP_REAJUSTE = isset($_REQUEST['IMP_REAJUSTE']) ? VerificarInputs($_REQUEST['IMP_REAJUSTE']) : "";
        $IMP_AMORT_ADEL_DIR = isset($_REQUEST['IMP_AMORT_ADEL_DIR']) ? VerificarInputs($_REQUEST['IMP_AMORT_ADEL_DIR']) : "";
        $IMP_AMORT_ADEL_MAT = isset($_REQUEST['IMP_AMORT_ADEL_MAT']) ? VerificarInputs($_REQUEST['IMP_AMORT_ADEL_MAT']) : "";
        $IMP_AMORTIZACION = isset($_REQUEST['IMP_AMORTIZACION']) ? VerificarInputs($_REQUEST['IMP_AMORTIZACION']) : "";
        $IMP_SALDO_SIN_IGV = isset($_REQUEST['IMP_SALDO_SIN_IGV']) ? VerificarInputs($_REQUEST['IMP_SALDO_SIN_IGV']) : "";
        $IMP_DEDUC_ADEL_DIR = isset($_REQUEST['IMP_DEDUC_ADEL_DIR']) ? VerificarInputs($_REQUEST['IMP_DEDUC_ADEL_DIR']) : "";
        $IMP_DEDUC_ADEL_MAT = isset($_REQUEST['IMP_DEDUC_ADEL_MAT']) ? VerificarInputs($_REQUEST['IMP_DEDUC_ADEL_MAT']) : "";
        $IMP_IMPONIBLE = isset($_REQUEST['IMP_IMPONIBLE']) ? VerificarInputs($_REQUEST['IMP_IMPONIBLE']) : "";
        $PCT_IGV = isset($_REQUEST['PCT_IGV']) ? VerificarInputs($_REQUEST['PCT_IGV']) : "";
        $IMP_IGV = isset($_REQUEST['IMP_IGV']) ? VerificarInputs($_REQUEST['IMP_IGV']) : "";
        $IMP_NETO = isset($_REQUEST['IMP_NETO']) ? VerificarInputs($_REQUEST['IMP_NETO']) : "";
        $IMP_PENALIDAD = isset($_REQUEST['IMP_PENALIDAD']) ? VerificarInputs($_REQUEST['IMP_PENALIDAD']) : "";
        $IMP_RETENCION = isset($_REQUEST['IMP_RETENCION']) ? VerificarInputs($_REQUEST['IMP_RETENCION']) : "";
        $IMP_PAGO = isset($_REQUEST['IMP_PAGO']) ? VerificarInputs($_REQUEST['IMP_PAGO']) : "";
        $EST_ETAPA_CONTROL_DET = isset($_REQUEST['EST_ETAPA_CONTROL_DET']) ? VerificarInputs($_REQUEST['EST_ETAPA_CONTROL_DET']) : "";
        
        $NUM_MES_PROVISION = isset($_REQUEST['NUM_MES_PROVISION']) ? VerificarInputs($_REQUEST['NUM_MES_PROVISION']) : "";
        $NUM_ANIO_PROVISION = isset($_REQUEST['NUM_ANIO_PROVISION']) ? VerificarInputs($_REQUEST['NUM_ANIO_PROVISION']) : "";

        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        ////// GRILLA PREDETERMINADA
        $TipoGrilla = 'SelGrd_PROY_CONT_COMP_CONTROL_DET';
        $Recursiva_hide = 'true';
        $Tabla_DatosPadre = '';

        ////// SI TIENE UN REGISTRO PADRE, ENTONCES SE DIBUJA CABEZERA
        if ($PIDE > 0) {
            $ScriptFLX .= " AND T.IDE_CONT_ETAPA_CONTROL=$PIDE";
            $Tabla_DatosPadre = Tabla_PROY_CONT_ETAPA_CONTROL_Datos($PIDE);
            $Data00 = PROY_CONT_ETAPA_CONTROL_Datos($PIDE);
            $PIDE_PROY_COMPONENTE = $Data00['IDE_PROY_COMPONENTE'];
            $VTIP_CONCEPTO = $Data00['TIP_CONCEPTO'];
        }

        ////// SI ES UN REGISTRO RECURSIVO
        $Recursiva = 'NO';



        /* ------------------------------------ */

        $DataSet_PROY_COMPONENTE_1 = array();
        $Objeto_IDE_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONVOCATORIA,COD_ITEM,SEC_EJEC,DES_ENTIDAD,UPPER(DES_INTERVENCION) AS DES_INTERVENCION,   DES_PROYECTO  ,DES_PROYECTO_ITEM,DES_COMPONENTE,DES_CARTERA,DES_ESTADO,CONVERT(varchar(10), FEC_INICIO_CONTRATO, 103) as FEC_INICIO_CONTRATO, CONVERT(varchar(10), FEC_TERMINO_CONTRATO, 103) as FEC_TERMINO_CONTRATO, IMP_COMPONENTE, DATEDIFF(day, FEC_INICIO_CONTRATO, FEC_TERMINO_CONTRATO)+1 AS DIAS_CONTRACTUALES ";
        $lstparametrosM['filtro'] = " AND PC.IDE_PROY_COMPONENTE = '$PIDE_PROY_COMPONENTE'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_PROY_COMPONENTE_DAO->SelCampos_PROY_COMPONENTE2($DataSet_PROY_COMPONENTE_1, $procedure_parametrosMS);
        $VIDE_CONVOCATORIA = $DataSet_PROY_COMPONENTE_1[0]->IDE_CONVOCATORIA;
        $lCollection->Add('VIDE_CONVOCATORIA', $VIDE_CONVOCATORIA);
        $VCOD_ITEM = $DataSet_PROY_COMPONENTE_1[0]->COD_ITEM;
        $lCollection->Add('VCOD_ITEM', $VCOD_ITEM);
        $VSEC_EJEC = $DataSet_PROY_COMPONENTE_1[0]->SEC_EJEC;
        $lCollection->Add('VSEC_EJEC', $VSEC_EJEC);
        $VDES_ENTIDAD = $DataSet_PROY_COMPONENTE_1[0]->DES_ENTIDAD;
        $lCollection->Add('VDES_ENTIDAD', $VDES_ENTIDAD);
        $VDES_INTERVENCION = $DataSet_PROY_COMPONENTE_1[0]->DES_INTERVENCION;
        $lCollection->Add('VDES_INTERVENCION', $VDES_INTERVENCION);
        $VDES_PROYECTO_ITEM = $DataSet_PROY_COMPONENTE_1[0]->DES_PROYECTO_ITEM;
        $lCollection->Add('VDES_PROYECTO_ITEM', $VDES_PROYECTO_ITEM);

        $VDES_PROYECTO = $DataSet_PROY_COMPONENTE_1[0]->DES_PROYECTO;
        $lCollection->Add('VDES_PROYECTO', $VDES_PROYECTO);

        $VDES_COMPONENTE = $DataSet_PROY_COMPONENTE_1[0]->DES_COMPONENTE;
        $lCollection->Add('VDES_COMPONENTE', $VDES_COMPONENTE);
        $VDES_CARTERA = $DataSet_PROY_COMPONENTE_1[0]->DES_CARTERA;
        $lCollection->Add('VDES_CARTERA', $VDES_CARTERA);
        $VDES_ESTADO = $DataSet_PROY_COMPONENTE_1[0]->DES_ESTADO;
        $lCollection->Add('VDES_ESTADO', $VDES_ESTADO);
        $VFEC_INICIO_CONTRATO = $DataSet_PROY_COMPONENTE_1[0]->FEC_INICIO_CONTRATO;
        $lCollection->Add('VFEC_INICIO_CONTRATO', $VFEC_INICIO_CONTRATO);
        $VFEC_TERMINO_CONTRATO = $DataSet_PROY_COMPONENTE_1[0]->FEC_TERMINO_CONTRATO;
        $lCollection->Add('VFEC_TERMINO_CONTRATO', $VFEC_TERMINO_CONTRATO);
        $VIMP_COMPONENTE = $DataSet_PROY_COMPONENTE_1[0]->IMP_COMPONENTE;
        $lCollection->Add('VIMP_COMPONENTE', $VIMP_COMPONENTE);
        $VDIAS_CONTRACTUALES = $DataSet_PROY_COMPONENTE_1[0]->DIAS_CONTRACTUALES;
        $lCollection->Add('VDIAS_CONTRACTUALES', $VDIAS_CONTRACTUALES);

        /* EDGAR */
        $Data11 = ProyectoComponente_Datos($PIDE_PROY_COMPONENTE);
        $Data12 = ProyectoActividad_Datos($Data11['IDE_PROYECTO_ACTIVIDAD']);
        $lCollection->Add('VCOD_PROYECTO', $Data12['COD_PROYECTO']); //echo 'COD_PROYECTO:'.$Data12['COD_PROYECTO'];
        $lCollection->Add('VIDE_INTERVENCION', $Data12['IDE_INTERVENCION']);

        $lCollection->Add('VIDE_PROYECTO', $Data12['IDE_PROYECTO']);
        $lCollection->Add('PIDE_PROY_COMPONENTE', $PIDE_PROY_COMPONENTE);
        $VIDE_PLAN = $Data00['IDE_PLAN'] ;
        $lCollection->Add('VIDE_PLAN', $VIDE_PLAN) ;
        $lCollection->Add('VTIP_CONCEPTO', $VTIP_CONCEPTO) ;
        
        $VTIP_PROYECTO_ACTIVIDAD = $DataSet_PROY_COMPONENTE_1[0]->TIP_PROYECTO_ACTIVIDAD;
        $lCollection->Add('VTIP_PROYECTO_ACTIVIDAD', $VTIP_PROYECTO_ACTIVIDAD);
        
        $Data21 = GenTablas_Datos('104','1');
        $lCollection->Add('BPCT_IGV', $Data21['DES_ITEM']);
        
        //$IMP_AMORTIZACION = $IMP_AMORT_ADEL_DIR + $IMP_AMORT_ADEL_MAT ;
        /* // si funciona pero se envo todo al javascript de la vista
        $IMP_SALDO_SIN_IGV = $IMP_BRUTO + $IMP_REAJUSTE - ($IMP_AMORT_ADEL_DIR + $IMP_AMORT_ADEL_MAT) - $IMP_AMORTIZACION ;
        $IMP_IMPONIBLE = $IMP_SALDO_SIN_IGV - $IMP_DEDUC_ADEL_DIR - $IMP_DEDUC_ADEL_MAT ;

        if($VIDE_PLAN==2){//EJECUTADO
                $IMP_IGV = round($PCT_IGV * $IMP_IMPONIBLE,2) ;
                $IMP_NETO = $IMP_IMPONIBLE + $IMP_IGV ;
        } else {//PROGRAMADO Y REPROGRAMADO
                $IMP_IGV = $IMP_BRUTO * $PCT_IGV ;
                $IMP_NETO = $IMP_BRUTO + $IMP_IGV ;
        }

        $IMP_PAGO = $IMP_NETO - $IMP_PENALIDAD - $IMP_RETENCION ;
        */
        /* EDGAR */

        /* ------------------------------------ */

        ////// PASE DE PARAMETROS DE GRILLA        
        $lCollection->Add('Tabla_DatosPadre', $Tabla_DatosPadre);
        $lCollection->Add('Recursiva_hide', $Recursiva_hide);

        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_CONT_COMP_CONTROL_DET_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'NUM_ITEM') {
                        $_POST['qtype'] = 'T.NUM_ITEM';
                    }
                    if ($_POST['qtype'] == 'NUM_ANIO') {
                        $_POST['qtype'] = 'TT101.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'NUM_MES') {
                        $_POST['qtype'] = 'TT18.COD_ITEM';
                    }
                    if ($_POST['qtype'] == 'DES_CONCEPTO_PAGO') {
                        $_POST['qtype'] = 'T.DES_CONCEPTO_PAGO';
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
            $ogridDAO->Count_PROY_CONT_COMP_CONTROL_DET($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONT_ETAPA_CONTROL_DET;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
//            $Data = Interesados_Datos($PIDEbuscado);
//            $Data1 = Recurso_Datos($Data['IDE_RECURSO']);
//            $Bdescripcion = $Data1['DES_RECURSO']  ;
//            $lCollection->Add('BIDE', $PIDEbuscado);
//            $lCollection->Add('Bdescripcion', $Bdescripcion);
//            echo 'entre'. $PIDEbuscado . ' - '.$Bdescripcion ; exit;
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROY_CONT_COMP_CONTROL_DETM = array();
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO = new PROY_CONT_COMP_CONTROL_DET_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONT_ETAPA_CONTROL)) > 0) {
                $lstparametrosM['IDE_CONT_ETAPA_CONTROL'] = $IDE_CONT_ETAPA_CONTROL;
            }
            if (strlen(rtrim($NUM_ITEM)) > 0) {
                $lstparametrosM['NUM_ITEM'] = $NUM_ITEM;
            }
            if (strlen(rtrim($NUM_ANIO)) > 0) {
                $lstparametrosM['NUM_ANIO'] = $NUM_ANIO;
            }
            if (strlen(rtrim($NUM_MES)) > 0) {
                $lstparametrosM['NUM_MES'] = $NUM_MES;
            }

            if (strlen(rtrim($DES_CONCEPTO_PAGO)) > 0) {
                $lstparametrosM['DES_CONCEPTO_PAGO'] = $DES_CONCEPTO_PAGO;
            }
            if (strlen(rtrim($PCT_AVANCE)) > 0) {
                $lstparametrosM['PCT_AVANCE'] = $PCT_AVANCE;
            }
            if (strlen(rtrim($IMP_BRUTO)) > 0) {
                $lstparametrosM['IMP_BRUTO'] = $IMP_BRUTO;
            }
            if (strlen(rtrim($IMP_REAJUSTE)) > 0) {
                $lstparametrosM['IMP_REAJUSTE'] = $IMP_REAJUSTE;
            }
            if (strlen(rtrim($IMP_AMORT_ADEL_DIR)) > 0) {
                $lstparametrosM['IMP_AMORT_ADEL_DIR'] = $IMP_AMORT_ADEL_DIR;
            }
            if (strlen(rtrim($IMP_AMORT_ADEL_MAT)) > 0) {
                $lstparametrosM['IMP_AMORT_ADEL_MAT'] = $IMP_AMORT_ADEL_MAT;
            }
            if (strlen(rtrim($IMP_AMORTIZACION)) > 0) {
                $lstparametrosM['IMP_AMORTIZACION'] = $IMP_AMORTIZACION;
            }
            if (strlen(rtrim($IMP_SALDO_SIN_IGV)) > 0) {
                $lstparametrosM['IMP_SALDO_SIN_IGV'] = $IMP_SALDO_SIN_IGV;
            }
            if (strlen(rtrim($IMP_DEDUC_ADEL_DIR)) > 0) {
                $lstparametrosM['IMP_DEDUC_ADEL_DIR'] = $IMP_DEDUC_ADEL_DIR;
            }
            if (strlen(rtrim($IMP_DEDUC_ADEL_MAT)) > 0) {
                $lstparametrosM['IMP_DEDUC_ADEL_MAT'] = $IMP_DEDUC_ADEL_MAT;
            }
            if (strlen(rtrim($IMP_IMPONIBLE)) > 0) {
                $lstparametrosM['IMP_IMPONIBLE'] = $IMP_IMPONIBLE;
            }
            if (strlen(rtrim($PCT_IGV)) > 0) {
                $lstparametrosM['PCT_IGV'] = $PCT_IGV;
            }
            if (strlen(rtrim($IMP_IGV)) > 0) {
                $lstparametrosM['IMP_IGV'] = $IMP_IGV;
            }
            if (strlen(rtrim($IMP_NETO)) > 0) {
                $lstparametrosM['IMP_NETO'] = $IMP_NETO;
            }
            if (strlen(rtrim($IMP_PENALIDAD)) > 0) {
                $lstparametrosM['IMP_PENALIDAD'] = $IMP_PENALIDAD;
            }
            if (strlen(rtrim($IMP_RETENCION)) > 0) {
                $lstparametrosM['IMP_RETENCION'] = $IMP_RETENCION;
            }
            if (strlen(rtrim($IMP_PAGO)) > 0) {
                $lstparametrosM['IMP_PAGO'] = $IMP_PAGO;
            }
            if (strlen(rtrim($EST_ETAPA_CONTROL_DET)) > 0) {
                $lstparametrosM['EST_ETAPA_CONTROL_DET'] = $EST_ETAPA_CONTROL_DET;
            } 
            if (strlen(rtrim($NUM_MES_PROVISION)) > 0) {
                $lstparametrosM['NUM_MES_PROVISION'] = $NUM_MES_PROVISION;
            }
            if (strlen(rtrim($NUM_ANIO_PROVISION)) > 0) {
                $lstparametrosM['NUM_ANIO_PROVISION'] = $NUM_ANIO_PROVISION;
            }            
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONT_ETAPA_CONTROL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_ANIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_MES'], SQLSRV_PARAM_IN),
                
                array(&$lstparametrosM['DES_CONCEPTO_PAGO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['PCT_AVANCE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_BRUTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_REAJUSTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_AMORT_ADEL_DIR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_AMORT_ADEL_MAT'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_AMORTIZACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_SALDO_SIN_IGV'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_DEDUC_ADEL_DIR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_DEDUC_ADEL_MAT'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_IMPONIBLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['PCT_IGV'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_IGV'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_NETO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_PENALIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_RETENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_PAGO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ETAPA_CONTROL_DET'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_MES_PROVISION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_ANIO_PROVISION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO->Insert_PROY_CONT_COMP_CONTROL_DET($DataSet_PROY_CONT_COMP_CONTROL_DET, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[25][0];

            $mensaje = $procedure_parametrosMS[26][0];

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
            $DataSet_PROY_CONT_COMP_CONTROL_DET = array();
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO = new PROY_CONT_COMP_CONTROL_DET_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO->SelPk_PROY_CONT_COMP_CONTROL_DET($DataSet_PROY_CONT_COMP_CONTROL_DET, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_CONT_COMP_CONTROL_DET) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_CONT_COMP_CONTROL_DET

                $IDE_CONT_ETAPA_CONTROL = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IDE_CONT_ETAPA_CONTROL;
                $NUM_ITEM = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->NUM_ITEM;
                $NUM_ANIO = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->NUM_ANIO;
                $NUM_MES = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->NUM_MES;                
                $DES_CONCEPTO_PAGO = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->DES_CONCEPTO_PAGO;
                $PCT_AVANCE = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->PCT_AVANCE;
                $IMP_BRUTO = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_BRUTO;
                $IMP_REAJUSTE = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_REAJUSTE;
                $IMP_AMORT_ADEL_DIR = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_AMORT_ADEL_DIR;
                $IMP_AMORT_ADEL_MAT = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_AMORT_ADEL_MAT;
                $IMP_AMORTIZACION = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_AMORTIZACION;
                $IMP_SALDO_SIN_IGV = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_SALDO_SIN_IGV;
                $IMP_DEDUC_ADEL_DIR = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_DEDUC_ADEL_DIR;
                $IMP_DEDUC_ADEL_MAT = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_DEDUC_ADEL_MAT;
                $IMP_IMPONIBLE = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_IMPONIBLE;
                $PCT_IGV = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->PCT_IGV;
                $IMP_IGV = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_IGV;
                $IMP_NETO = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_NETO;
                $IMP_PENALIDAD = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_PENALIDAD;
                $IMP_RETENCION = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_RETENCION;
                $IMP_PAGO = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->IMP_PAGO;
                $EST_ETAPA_CONTROL_DET = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->EST_ETAPA_CONTROL_DET;
                $NUM_MES_PROVISION = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->NUM_MES_PROVISION;
                $NUM_ANIO_PROVISION = $DataSet_PROY_CONT_COMP_CONTROL_DET[0]->NUM_ANIO_PROVISION;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONT_ETAPA_CONTROL', $IDE_CONT_ETAPA_CONTROL);
            $lCollection->Add('NUM_ITEM', $NUM_ITEM);
            $lCollection->Add('NUM_ANIO', $NUM_ANIO);
            $lCollection->Add('NUM_MES', $NUM_MES);            
            $lCollection->Add('DES_CONCEPTO_PAGO', $DES_CONCEPTO_PAGO);
            $lCollection->Add('PCT_AVANCE', $PCT_AVANCE);
            $lCollection->Add('IMP_BRUTO', $IMP_BRUTO);
            $lCollection->Add('IMP_REAJUSTE', $IMP_REAJUSTE);
            $lCollection->Add('IMP_AMORT_ADEL_DIR', $IMP_AMORT_ADEL_DIR);
            $lCollection->Add('IMP_AMORT_ADEL_MAT', $IMP_AMORT_ADEL_MAT);
            $lCollection->Add('IMP_AMORTIZACION', $IMP_AMORTIZACION);
            $lCollection->Add('IMP_SALDO_SIN_IGV', $IMP_SALDO_SIN_IGV);
            $lCollection->Add('IMP_DEDUC_ADEL_DIR', $IMP_DEDUC_ADEL_DIR);
            $lCollection->Add('IMP_DEDUC_ADEL_MAT', $IMP_DEDUC_ADEL_MAT);
            $lCollection->Add('IMP_IMPONIBLE', $IMP_IMPONIBLE);
            $lCollection->Add('PCT_IGV', $PCT_IGV);
            $lCollection->Add('IMP_IGV', $IMP_IGV);
            $lCollection->Add('IMP_NETO', $IMP_NETO);
            $lCollection->Add('IMP_PENALIDAD', $IMP_PENALIDAD);
            $lCollection->Add('IMP_RETENCION', $IMP_RETENCION);
            $lCollection->Add('IMP_PAGO', $IMP_PAGO);
            $lCollection->Add('EST_ETAPA_CONTROL_DET', $EST_ETAPA_CONTROL_DET);
            $lCollection->Add('NUM_MES_PROVISION', $NUM_MES_PROVISION);
            $lCollection->Add('NUM_ANIO_PROVISION', $NUM_ANIO_PROVISION);

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data11 = Comunidad_Datos($IDE_COMUNIDAD);
            //$Bdescripcion = $Data11['DES_COMUNIDAD'] ;
            //$lCollection->Add('Bdescripcion', $Bdescripcion);
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_CONT_COMP_CONTROL_DET = array();
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO = new PROY_CONT_COMP_CONTROL_DET_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONT_ETAPA_CONTROL)) > 0) {
                $lstparametrosM['IDE_CONT_ETAPA_CONTROL'] = $IDE_CONT_ETAPA_CONTROL;
            }
            if (strlen(rtrim($NUM_ITEM)) > 0) {
                $lstparametrosM['NUM_ITEM'] = $NUM_ITEM;
            }
            if (strlen(rtrim($NUM_ANIO)) > 0) {
                $lstparametrosM['NUM_ANIO'] = $NUM_ANIO;
            }
            if (strlen(rtrim($NUM_MES)) > 0) {
                $lstparametrosM['NUM_MES'] = $NUM_MES;
            }

            if (strlen(rtrim($DES_CONCEPTO_PAGO)) > 0) {
                $lstparametrosM['DES_CONCEPTO_PAGO'] = $DES_CONCEPTO_PAGO;
            }
            if (strlen(rtrim($PCT_AVANCE)) > 0) {
                $lstparametrosM['PCT_AVANCE'] = $PCT_AVANCE;
            }
            if (strlen(rtrim($IMP_BRUTO)) > 0) {
                $lstparametrosM['IMP_BRUTO'] = $IMP_BRUTO;
            }
            if (strlen(rtrim($IMP_REAJUSTE)) > 0) {
                $lstparametrosM['IMP_REAJUSTE'] = $IMP_REAJUSTE;
            }
            if (strlen(rtrim($IMP_AMORT_ADEL_DIR)) > 0) {
                $lstparametrosM['IMP_AMORT_ADEL_DIR'] = $IMP_AMORT_ADEL_DIR;
            }
            if (strlen(rtrim($IMP_AMORT_ADEL_MAT)) > 0) {
                $lstparametrosM['IMP_AMORT_ADEL_MAT'] = $IMP_AMORT_ADEL_MAT;
            }
            if (strlen(rtrim($IMP_AMORTIZACION)) > 0) {
                $lstparametrosM['IMP_AMORTIZACION'] = $IMP_AMORTIZACION;
            }
            if (strlen(rtrim($IMP_SALDO_SIN_IGV)) > 0) {
                $lstparametrosM['IMP_SALDO_SIN_IGV'] = $IMP_SALDO_SIN_IGV;
            }
            if (strlen(rtrim($IMP_DEDUC_ADEL_DIR)) > 0) {
                $lstparametrosM['IMP_DEDUC_ADEL_DIR'] = $IMP_DEDUC_ADEL_DIR;
            }
            if (strlen(rtrim($IMP_DEDUC_ADEL_MAT)) > 0) {
                $lstparametrosM['IMP_DEDUC_ADEL_MAT'] = $IMP_DEDUC_ADEL_MAT;
            }
            if (strlen(rtrim($IMP_IMPONIBLE)) > 0) {
                $lstparametrosM['IMP_IMPONIBLE'] = $IMP_IMPONIBLE;
            }
            if (strlen(rtrim($PCT_IGV)) > 0) {
                $lstparametrosM['PCT_IGV'] = $PCT_IGV;
            }
            if (strlen(rtrim($IMP_IGV)) > 0) {
                $lstparametrosM['IMP_IGV'] = $IMP_IGV;
            }
            if (strlen(rtrim($IMP_NETO)) > 0) {
                $lstparametrosM['IMP_NETO'] = $IMP_NETO;
            }
            if (strlen(rtrim($IMP_PENALIDAD)) > 0) {
                $lstparametrosM['IMP_PENALIDAD'] = $IMP_PENALIDAD;
            }
            if (strlen(rtrim($IMP_RETENCION)) > 0) {
                $lstparametrosM['IMP_RETENCION'] = $IMP_RETENCION;
            }
            if (strlen(rtrim($IMP_PAGO)) > 0) {
                $lstparametrosM['IMP_PAGO'] = $IMP_PAGO;
            }
            if (strlen(rtrim($EST_ETAPA_CONTROL_DET)) > 0) {
                $lstparametrosM['EST_ETAPA_CONTROL_DET'] = $EST_ETAPA_CONTROL_DET;
            }
            if (strlen(rtrim($NUM_MES_PROVISION)) > 0) {
                $lstparametrosM['NUM_MES_PROVISION'] = $NUM_MES_PROVISION;
            }
            if (strlen(rtrim($NUM_ANIO_PROVISION)) > 0) {
                $lstparametrosM['NUM_ANIO_PROVISION'] = $NUM_ANIO_PROVISION;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONT_ETAPA_CONTROL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_ANIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_MES'], SQLSRV_PARAM_IN)                
                , array(&$lstparametrosM['DES_CONCEPTO_PAGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCT_AVANCE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_BRUTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_REAJUSTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_AMORT_ADEL_DIR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_AMORT_ADEL_MAT'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_AMORTIZACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_SALDO_SIN_IGV'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_DEDUC_ADEL_DIR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_DEDUC_ADEL_MAT'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_IMPONIBLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCT_IGV'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_IGV'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_NETO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_PENALIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_RETENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_PAGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ETAPA_CONTROL_DET'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_MES_PROVISION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_ANIO_PROVISION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO->Update_PROY_CONT_COMP_CONTROL_DET($DataSet_PROY_CONT_COMP_CONTROL_DET, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[26][0];

            $mensaje = $procedure_parametrosMS[27][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_CONT_COMP_CONTROL_DET = array();
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO = new PROY_CONT_COMP_CONTROL_DET_DAO();
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
            $Objeto_PROY_CONT_COMP_CONTROL_DET_DAO->Delete_PROY_CONT_COMP_CONTROL_DET($DataSet_PROY_CONT_COMP_CONTROL_DET, $procedure_parametrosMS); //JCMY
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


        
        /* 	COMBO DEL AÑO DE VALORIZACION	 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_NUM_ANIO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '101'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_NUM_ANIO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);
        
        
        /* COMBO DEL MES DE VALORIZACION */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_NUM_MES_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '18'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_NUM_MES_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);
        

        /* 	COMBO DEL AÑO DE PROVISIÓN	 */

        $DataSet_GEN_TABLAS_5 = array();
        $Objeto_NUM_ANIO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '101'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_NUM_ANIO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_5, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_5', $DataSet_GEN_TABLAS_5);        

        /* COMBO DEL MES DE PROVISIÓN */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_NUM_MES_PROVISION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '18'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_NUM_MES_PROVISION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);
 

        /* 	COMBO DEL ESTADO DE LAS TABLAS GENERALES */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_ETAPA_CONTROL_DET_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ETAPA_CONTROL_DET_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

              



        /* EDGAR */
        $lCollection->Add('crud', crud($usuario, $PermisosPerfil, $Pedido, $SeleccionarID));
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;