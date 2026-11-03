<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : CONTRATO_CONCEPTOLN de la tabla CONTRATO_CONCEPTO
  //  Fecha           : lunes, 13 de mayo de 2019 21:09:52
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/CONTRATO_CONCEPTODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_BANCODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/CONTRATOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "CONTRATO_CONCEPTO";
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
        $IDE_CONTRATO = isset($_REQUEST['IDE_CONTRATO']) ? VerificarInputs($_REQUEST['IDE_CONTRATO']) : "";
        $IDE_BANCO = isset($_REQUEST['IDE_BANCO']) ? VerificarInputs($_REQUEST['IDE_BANCO']) : "";
        $TIP_CONCEPTO = isset($_REQUEST['TIP_CONCEPTO']) ? VerificarInputs($_REQUEST['TIP_CONCEPTO']) : "";
        $TIP_DOCUMENTO = isset($_REQUEST['TIP_DOCUMENTO']) ? VerificarInputs($_REQUEST['TIP_DOCUMENTO']) : "";
        $COD_TIPO_DOCUMENTO = isset($_REQUEST['COD_TIPO_DOCUMENTO']) ? VerificarInputs($_REQUEST['COD_TIPO_DOCUMENTO']) : "";
        $IMG_DOCUMENTO = isset($_REQUEST['IMG_DOCUMENTO']) ? VerificarInputs($_REQUEST['IMG_DOCUMENTO']) : "";
        $IMP_CONCEPTO = isset($_REQUEST['IMP_CONCEPTO']) ? VerificarInputs($_REQUEST['IMP_CONCEPTO']) : "";
        $FEC_EMISION = isset($_REQUEST['FEC_EMISION']) ? VerificarInputs($_REQUEST['FEC_EMISION']) : "";
        $FEC_INICIO = isset($_REQUEST['FEC_INICIO']) ? VerificarInputs($_REQUEST['FEC_INICIO']) : "";
        $FEC_TERMINO = isset($_REQUEST['FEC_TERMINO']) ? VerificarInputs($_REQUEST['FEC_TERMINO']) : "";
        $DES_OBSERVACION = isset($_REQUEST['DES_OBSERVACION']) ? VerificarInputs($_REQUEST['DES_OBSERVACION']) : "";
        $EST_CONT_CONCEPTO = isset($_REQUEST['EST_CONT_CONCEPTO']) ? VerificarInputs($_REQUEST['EST_CONT_CONCEPTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_CONTRATO=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
            $Data4 = Contrato_Datos($PIDE);
            $COD_UNICO_ORDEN = $Data4['COD_UNICO_ORDEN'];
            $DES_CONTRATO = $Data4['DES_CONTRATO'];
            $IMP_TOTAL = $Data4['IMP_TOTAL_mon'];
            $lCollection->Add('VCOD_UNICO_ORDEN', $COD_UNICO_ORDEN );
            $lCollection->Add('VDES_CONTRATO', $DES_CONTRATO );
            $lCollection->Add('VIMP_TOTAL', $IMP_TOTAL );
            
       } else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new CONTRATO_CONCEPTO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_TIPO_DOCUMENTO') {
                        $_POST['qtype'] = 'T.COD_TIPO_DOCUMENTO';
                    }
                    if ($_POST['qtype'] == 'TipoConcepto') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'TipoDocumento') {
                        $_POST['qtype'] = 'T3.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'DES_BANCO') {
                        $_POST['qtype'] = 'B.DES_BANCO';
                    }
                    if ($_POST['qtype'] == 'FEC_INICIO') {
                        $_POST['qtype'] = 'T.FEC_INICIO';
                    }
                    if ($_POST['qtype'] == 'FEC_TERMINO') {
                        $_POST['qtype'] = 'T.FEC_TERMINO';
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
            $ogridDAO->Count_CONTRATO_CONCEPTO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONT_CONCEPTO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_CONTRATO_CONCEPTO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_EMISION) > 0) {
                $FEC_EMISION = cambiafecha($FEC_EMISION);
            } else {
                $FEC_EMISION = "";
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

            $DataSet_CONTRATO_CONCEPTOM = array();
            $Objeto_CONTRATO_CONCEPTO_DAO = new CONTRATO_CONCEPTO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_BANCO)) > 0) {
                $lstparametrosM['IDE_BANCO'] = $IDE_BANCO;
            }
            if (strlen(rtrim($TIP_CONCEPTO)) > 0) {
                $lstparametrosM['TIP_CONCEPTO'] = $TIP_CONCEPTO;
            }
            if (strlen(rtrim($TIP_DOCUMENTO)) > 0) {
                $lstparametrosM['TIP_DOCUMENTO'] = $TIP_DOCUMENTO;
            }
            if (strlen(rtrim($COD_TIPO_DOCUMENTO)) > 0) {
                $lstparametrosM['COD_TIPO_DOCUMENTO'] = $COD_TIPO_DOCUMENTO;
            }
            if (strlen(rtrim($IMG_DOCUMENTO)) > 0) {
                $lstparametrosM['IMG_DOCUMENTO'] = $IMG_DOCUMENTO;
            }
            if (strlen(rtrim($IMP_CONCEPTO)) > 0) {
                $lstparametrosM['IMP_CONCEPTO'] = $IMP_CONCEPTO;
            }
            if (strlen(rtrim($FEC_EMISION)) > 0) {
                $lstparametrosM['FEC_EMISION'] = $FEC_EMISION;
            }
            if (strlen(rtrim($FEC_INICIO)) > 0) {
                $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            }
            if (strlen(rtrim($FEC_TERMINO)) > 0) {
                $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_CONT_CONCEPTO)) > 0) {
                $lstparametrosM['EST_CONT_CONCEPTO'] = $EST_CONT_CONCEPTO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_BANCO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_CONCEPTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_DOCUMENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_TIPO_DOCUMENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMG_DOCUMENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_CONCEPTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_EMISION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CONT_CONCEPTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONTRATO_CONCEPTO_DAO->Insert_CONTRATO_CONCEPTO($DataSet_CONTRATO_CONCEPTO, $procedure_parametrosMS); //JCMY

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
            $DataSet_CONTRATO_CONCEPTO = array();
            $Objeto_CONTRATO_CONCEPTO_DAO = new CONTRATO_CONCEPTO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_CONTRATO_CONCEPTO_DAO->SelPk_CONTRATO_CONCEPTO($DataSet_CONTRATO_CONCEPTO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_CONTRATO_CONCEPTO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_CONTRATO_CONCEPTO

                $IDE_CONTRATO = $DataSet_CONTRATO_CONCEPTO[0]->IDE_CONTRATO;
                $IDE_BANCO = $DataSet_CONTRATO_CONCEPTO[0]->IDE_BANCO;
                $TIP_CONCEPTO = $DataSet_CONTRATO_CONCEPTO[0]->TIP_CONCEPTO;
                $TIP_DOCUMENTO = $DataSet_CONTRATO_CONCEPTO[0]->TIP_DOCUMENTO;
                $COD_TIPO_DOCUMENTO = $DataSet_CONTRATO_CONCEPTO[0]->COD_TIPO_DOCUMENTO;
                $IMG_DOCUMENTO = $DataSet_CONTRATO_CONCEPTO[0]->IMG_DOCUMENTO;
                $IMP_CONCEPTO = $DataSet_CONTRATO_CONCEPTO[0]->IMP_CONCEPTO;
                $FEC_EMISION = $DataSet_CONTRATO_CONCEPTO[0]->FEC_EMISION;
                $FEC_INICIO = $DataSet_CONTRATO_CONCEPTO[0]->FEC_INICIO;
                $FEC_TERMINO = $DataSet_CONTRATO_CONCEPTO[0]->FEC_TERMINO;
                $DES_OBSERVACION = $DataSet_CONTRATO_CONCEPTO[0]->DES_OBSERVACION;
                $EST_CONT_CONCEPTO = $DataSet_CONTRATO_CONCEPTO[0]->EST_CONT_CONCEPTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONTRATO', $IDE_CONTRATO);
            $lCollection->Add('IDE_BANCO', $IDE_BANCO);
            $lCollection->Add('TIP_CONCEPTO', $TIP_CONCEPTO);
            $lCollection->Add('TIP_DOCUMENTO', $TIP_DOCUMENTO);
            $lCollection->Add('COD_TIPO_DOCUMENTO', $COD_TIPO_DOCUMENTO);
            $lCollection->Add('IMG_DOCUMENTO', $IMG_DOCUMENTO);
            $lCollection->Add('IMP_CONCEPTO', $IMP_CONCEPTO);
            $lCollection->Add('FEC_EMISION', $FEC_EMISION);
            $lCollection->Add('FEC_INICIO', $FEC_INICIO);
            $lCollection->Add('FEC_TERMINO', $FEC_TERMINO);
            $lCollection->Add('DES_OBSERVACION', $DES_OBSERVACION);
            $lCollection->Add('EST_CONT_CONCEPTO', $EST_CONT_CONCEPTO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_EMISION) > 0) {
                $FEC_EMISION = cambiafecha($FEC_EMISION);
            } else {
                $FEC_EMISION = "";
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
            $DataSet_CONTRATO_CONCEPTO = array();
            $Objeto_CONTRATO_CONCEPTO_DAO = new CONTRATO_CONCEPTO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_BANCO)) > 0) {
                $lstparametrosM['IDE_BANCO'] = $IDE_BANCO;
            }
            if (strlen(rtrim($TIP_CONCEPTO)) > 0) {
                $lstparametrosM['TIP_CONCEPTO'] = $TIP_CONCEPTO;
            }
            if (strlen(rtrim($TIP_DOCUMENTO)) > 0) {
                $lstparametrosM['TIP_DOCUMENTO'] = $TIP_DOCUMENTO;
            }
            if (strlen(rtrim($COD_TIPO_DOCUMENTO)) > 0) {
                $lstparametrosM['COD_TIPO_DOCUMENTO'] = $COD_TIPO_DOCUMENTO;
            }
            if (strlen(rtrim($IMG_DOCUMENTO)) > 0) {
                $lstparametrosM['IMG_DOCUMENTO'] = $IMG_DOCUMENTO;
            }
            if (strlen(rtrim($IMP_CONCEPTO)) > 0) {
                $lstparametrosM['IMP_CONCEPTO'] = $IMP_CONCEPTO;
            }
            if (strlen(rtrim($FEC_EMISION)) > 0) {
                $lstparametrosM['FEC_EMISION'] = $FEC_EMISION;
            }
            if (strlen(rtrim($FEC_INICIO)) > 0) {
                $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            }
            if (strlen(rtrim($FEC_TERMINO)) > 0) {
                $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_CONT_CONCEPTO)) > 0) {
                $lstparametrosM['EST_CONT_CONCEPTO'] = $EST_CONT_CONCEPTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_BANCO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_CONCEPTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_DOCUMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_TIPO_DOCUMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMG_DOCUMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_CONCEPTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_EMISION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CONT_CONCEPTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONTRATO_CONCEPTO_DAO->Update_CONTRATO_CONCEPTO($DataSet_CONTRATO_CONCEPTO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[14][0];

            $mensaje = $procedure_parametrosMS[15][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_CONTRATO_CONCEPTO = array();
            $Objeto_CONTRATO_CONCEPTO_DAO = new CONTRATO_CONCEPTO_DAO();
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
            $Objeto_CONTRATO_CONCEPTO_DAO->Delete_CONTRATO_CONCEPTO($DataSet_CONTRATO_CONCEPTO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_BANCO_1 = array();
        $Objeto_IDE_BANCO_DAO = new GEN_BANCO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_BANCO,DES_BANCO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_BANCO_DAO->SelCampos_GEN_BANCO($DataSet_GEN_BANCO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_BANCO_1', $DataSet_GEN_BANCO_1);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_CONCEPTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='66' AND COD_ITEM IN ('1','2','3','4') ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_CONCEPTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_DOCUMENTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='67'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_DOCUMENTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_CONT_CONCEPTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CONT_CONCEPTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

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