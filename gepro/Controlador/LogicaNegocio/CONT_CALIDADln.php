<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_CALIDADLN de la tabla CONT_CALIDAD
  //  Fecha           : miércoles, 5 de junio de 2019 0:46:48
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/CONT_CALIDADDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTREGABLEDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
//require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
//require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/GEN_INTERVENCIONlni.php");
//// busqueda lni
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "CONT_CALIDAD";
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
        $PIDE_PROYECTO = isset($_REQUEST['PIDE_PROYECTO']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO']) : "";
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_CONTRATO = isset($_REQUEST['IDE_CONTRATO']) ? VerificarInputs($_REQUEST['IDE_CONTRATO']) : "";
        $IDE_ENTREGABLE = isset($_REQUEST['IDE_ENTREGABLE']) ? VerificarInputs($_REQUEST['IDE_ENTREGABLE']) : "";
        $DES_ENTREGABLE = isset($_REQUEST['DES_ENTREGABLE']) ? VerificarInputs($_REQUEST['DES_ENTREGABLE']) : "";
        $NUM_REVISION = isset($_REQUEST['NUM_REVISION']) ? VerificarInputs($_REQUEST['NUM_REVISION']) : "";
        $COD_INFORME = isset($_REQUEST['COD_INFORME']) ? VerificarInputs($_REQUEST['COD_INFORME']) : "";
        $FEC_INFORME = isset($_REQUEST['FEC_INFORME']) ? VerificarInputs($_REQUEST['FEC_INFORME']) : "";
        $IDE_REC_REVISADO = isset($_REQUEST['IDE_REC_REVISADO']) ? VerificarInputs($_REQUEST['IDE_REC_REVISADO']) : "";
        $IDE_REC_VALIDADO = isset($_REQUEST['IDE_REC_VALIDADO']) ? VerificarInputs($_REQUEST['IDE_REC_VALIDADO']) : "";
        $IDE_REC_APROBADO = isset($_REQUEST['IDE_REC_APROBADO']) ? VerificarInputs($_REQUEST['IDE_REC_APROBADO']) : "";
        $DES_OBSERV_INFORME = isset($_REQUEST['DES_OBSERV_INFORME']) ? VerificarInputs($_REQUEST['DES_OBSERV_INFORME']) : "";
        $CAN_OBSERVACIONES = isset($_REQUEST['CAN_OBSERVACIONES']) ? VerificarInputs($_REQUEST['CAN_OBSERVACIONES']) : "";
        $EST_ENTREGABLE = isset($_REQUEST['EST_ENTREGABLE']) ? VerificarInputs($_REQUEST['EST_ENTREGABLE']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_CONT_CALIDAD';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_CONTRATO=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
            $Data3 = ProyectoContrato_Datos2($PIDE,$PIDE_PROYECTO);
            $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
            
            $Data4 = ProyectoActividad_Datos($PIDE);
            $lCollection->Add('VIDE_INTERVENCION', $Data4['IDE_INTERVENCION'] ) ;
            $IdeFaseComponente = $Data4['IDE_INTERVENCION'];
       } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_CONT_CALIDAD_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new CONT_CALIDAD_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'NUM_REVISION') {
                        $_POST['qtype'] = 'T.NUM_REVISION';
                    }
                    if ($_POST['qtype'] == 'COD_INFORME') {
                        $_POST['qtype'] = 'T.COD_INFORME';
                    }
                    if ($_POST['qtype'] == 'FEC_INFORME') {
                        $_POST['qtype'] = 'T.FEC_INFORME';
                    }
                    if ($_POST['qtype'] == 'IDE_REC_REVISADO') {
                        $_POST['qtype'] = 'R1.DES_RECURSO';
                    }
                    if ($_POST['qtype'] == 'IDE_REC_VALIDADO') {
                        $_POST['qtype'] = 'R2.DES_RECURSO';
                    }
                    if ($_POST['qtype'] == 'IDE_REC_APROBADO') {
                        $_POST['qtype'] = 'R3.DES_RECURSO';
                    }
                    if ($_POST['qtype'] == 'CAN_OBSERVACIONES') {
                        $_POST['qtype'] = 'T.CAN_OBSERVACIONES';
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
            $ogridDAO->Count_CONT_CALIDAD($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONT_CALIDAD;

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
//            $Data1 = Recurso_Datos($Data'IDE_RECURSO');
//            $Data2 = Cargo_Datos($Data'IDE_PUESTO');
//            $Bdescripcion = $Data1'DES_RECURSO' .' ( '. $Data2'DES_CARGO' .' ) ' ;
//            $lCollection->Add('BIDE', $Data'BIDE');
//            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_INFORME) > 0) {
                $FEC_INFORME = cambiafecha($FEC_INFORME);
            } else {
                $FEC_INFORME = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_CONT_CALIDADM = array();
            $Objeto_CONT_CALIDAD_DAO = new CONT_CALIDAD_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_ENTREGABLE)) > 0) {
                $lstparametrosM['IDE_ENTREGABLE'] = $IDE_ENTREGABLE;
            }
            if (strlen(rtrim($DES_ENTREGABLE)) > 0) {
                $lstparametrosM['DES_ENTREGABLE'] = $DES_ENTREGABLE;
            }
            if (strlen(rtrim($NUM_REVISION)) > 0) {
                $lstparametrosM['NUM_REVISION'] = $NUM_REVISION;
            }
            if (strlen(rtrim($COD_INFORME)) > 0) {
                $lstparametrosM['COD_INFORME'] = $COD_INFORME;
            }
            if (strlen(rtrim($FEC_INFORME)) > 0) {
                $lstparametrosM['FEC_INFORME'] = $FEC_INFORME;
            }
            if (strlen(rtrim($IDE_REC_REVISADO)) > 0) {
                $lstparametrosM['IDE_REC_REVISADO'] = $IDE_REC_REVISADO;
            }
            if (strlen(rtrim($IDE_REC_VALIDADO)) > 0) {
                $lstparametrosM['IDE_REC_VALIDADO'] = $IDE_REC_VALIDADO;
            }
            if (strlen(rtrim($IDE_REC_APROBADO)) > 0) {
                $lstparametrosM['IDE_REC_APROBADO'] = $IDE_REC_APROBADO;
            }
            if (strlen(rtrim($DES_OBSERV_INFORME)) > 0) {
                $lstparametrosM['DES_OBSERV_INFORME'] = $DES_OBSERV_INFORME;
            }
            if (strlen(rtrim($CAN_OBSERVACIONES)) > 0) {
                $lstparametrosM['CAN_OBSERVACIONES'] = $CAN_OBSERVACIONES;
            }
            if (strlen(rtrim($EST_ENTREGABLE)) > 0) {
                $lstparametrosM['EST_ENTREGABLE'] = $EST_ENTREGABLE;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTREGABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ENTREGABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_REVISION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_INFORME'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INFORME'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_REC_REVISADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_REC_VALIDADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_REC_APROBADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERV_INFORME'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CAN_OBSERVACIONES'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_CALIDAD_DAO->Insert_CONT_CALIDAD($DataSet_CONT_CALIDAD, $procedure_parametrosMS); //JCMY

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
            $DataSet_CONT_CALIDAD = array();
            $Objeto_CONT_CALIDAD_DAO = new CONT_CALIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_CONT_CALIDAD_DAO->SelPk_CONT_CALIDAD($DataSet_CONT_CALIDAD, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_CONT_CALIDAD) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_CONT_CALIDAD

                $IDE_CONTRATO = $DataSet_CONT_CALIDAD[0]->IDE_CONTRATO;
                $IDE_ENTREGABLE = $DataSet_CONT_CALIDAD[0]->IDE_ENTREGABLE;
                $DES_ENTREGABLE = $DataSet_CONT_CALIDAD[0]->DES_ENTREGABLE;
                $NUM_REVISION = $DataSet_CONT_CALIDAD[0]->NUM_REVISION;
                $COD_INFORME = $DataSet_CONT_CALIDAD[0]->COD_INFORME;
                $FEC_INFORME = $DataSet_CONT_CALIDAD[0]->FEC_INFORME;
                $IDE_REC_REVISADO = $DataSet_CONT_CALIDAD[0]->IDE_REC_REVISADO;
                $IDE_REC_VALIDADO = $DataSet_CONT_CALIDAD[0]->IDE_REC_VALIDADO;
                $IDE_REC_APROBADO = $DataSet_CONT_CALIDAD[0]->IDE_REC_APROBADO;
                $DES_OBSERV_INFORME = $DataSet_CONT_CALIDAD[0]->DES_OBSERV_INFORME;
                $CAN_OBSERVACIONES = $DataSet_CONT_CALIDAD[0]->CAN_OBSERVACIONES;
                $EST_ENTREGABLE = $DataSet_CONT_CALIDAD[0]->EST_ENTREGABLE;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONTRATO', $IDE_CONTRATO);
            $lCollection->Add('IDE_ENTREGABLE', $IDE_ENTREGABLE);
            $lCollection->Add('DES_ENTREGABLE', $DES_ENTREGABLE);
            $lCollection->Add('NUM_REVISION', $NUM_REVISION);
            $lCollection->Add('COD_INFORME', $COD_INFORME);
            $lCollection->Add('FEC_INFORME', $FEC_INFORME);
            $lCollection->Add('IDE_REC_REVISADO', $IDE_REC_REVISADO);
            $lCollection->Add('IDE_REC_VALIDADO', $IDE_REC_VALIDADO);
            $lCollection->Add('IDE_REC_APROBADO', $IDE_REC_APROBADO);
            $lCollection->Add('DES_OBSERV_INFORME', $DES_OBSERV_INFORME);
            $lCollection->Add('CAN_OBSERVACIONES', $CAN_OBSERVACIONES);
            $lCollection->Add('EST_ENTREGABLE', $EST_ENTREGABLE);

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data = Comunidad_Datos($IDE_COMUNIDAD);
            //$Data1 = UBIGEO_Datos($Data'COD_UBIGEO');
            //$Bdescripcion = $Data'DES_COMUNIDAD' .' ( '. $Data1'DES_DEPARTAMENTO' .' - '. $Data1'DES_PROVINCIA' .' - '. $Data1'DES_DISTRITO' . ' )' ;
            //$lCollection->Add('Bdescripcion', $Bdescripcion);
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_INFORME) > 0) {
                $FEC_INFORME = cambiafecha($FEC_INFORME);
            } else {
                $FEC_INFORME = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_CONT_CALIDAD = array();
            $Objeto_CONT_CALIDAD_DAO = new CONT_CALIDAD_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_ENTREGABLE)) > 0) {
                $lstparametrosM['IDE_ENTREGABLE'] = $IDE_ENTREGABLE;
            }
            if (strlen(rtrim($DES_ENTREGABLE)) > 0) {
                $lstparametrosM['DES_ENTREGABLE'] = $DES_ENTREGABLE;
            }
            if (strlen(rtrim($NUM_REVISION)) > 0) {
                $lstparametrosM['NUM_REVISION'] = $NUM_REVISION;
            }
            if (strlen(rtrim($COD_INFORME)) > 0) {
                $lstparametrosM['COD_INFORME'] = $COD_INFORME;
            }
            if (strlen(rtrim($FEC_INFORME)) > 0) {
                $lstparametrosM['FEC_INFORME'] = $FEC_INFORME;
            }
            if (strlen(rtrim($IDE_REC_REVISADO)) > 0) {
                $lstparametrosM['IDE_REC_REVISADO'] = $IDE_REC_REVISADO;
            }
            if (strlen(rtrim($IDE_REC_VALIDADO)) > 0) {
                $lstparametrosM['IDE_REC_VALIDADO'] = $IDE_REC_VALIDADO;
            }
            if (strlen(rtrim($IDE_REC_APROBADO)) > 0) {
                $lstparametrosM['IDE_REC_APROBADO'] = $IDE_REC_APROBADO;
            }
            if (strlen(rtrim($DES_OBSERV_INFORME)) > 0) {
                $lstparametrosM['DES_OBSERV_INFORME'] = $DES_OBSERV_INFORME;
            }
            if (strlen(rtrim($CAN_OBSERVACIONES)) > 0) {
                $lstparametrosM['CAN_OBSERVACIONES'] = $CAN_OBSERVACIONES;
            }
            if (strlen(rtrim($EST_ENTREGABLE)) > 0) {
                $lstparametrosM['EST_ENTREGABLE'] = $EST_ENTREGABLE;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_REVISION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_INFORME'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INFORME'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_REC_REVISADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_REC_VALIDADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_REC_APROBADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERV_INFORME'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CAN_OBSERVACIONES'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_CALIDAD_DAO->Update_CONT_CALIDAD($DataSet_CONT_CALIDAD, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[14][0];

            $mensaje = $procedure_parametrosMS[15][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_CONT_CALIDAD = array();
            $Objeto_CONT_CALIDAD_DAO = new CONT_CALIDAD_DAO();
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
            $Objeto_CONT_CALIDAD_DAO->Delete_CONT_CALIDAD($DataSet_CONT_CALIDAD, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_ENTREGABLE_1 = array();
        $Objeto_IDE_ENTREGABLE_DAO = new GEN_ENTREGABLE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTREGABLE,DES_ENTREGABLE";
        $lstparametrosM['filtro'] = " and NUM_NIVEL=1 and IDE_FASE_COMPONENTE=$IdeFaseComponente ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ENTREGABLE_DAO->SelCampos_GEN_ENTREGABLE($DataSet_GEN_ENTREGABLE_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTREGABLE_1', $DataSet_GEN_ENTREGABLE_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_RECURSO_1 = array();
        $Objeto_IDE_REC_REVISADO_DAO = new GEN_RECURSO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
        $lstparametrosM['filtro'] = "AND TIP_RECURSO='3'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_REC_REVISADO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_RECURSO_1', $DataSet_GEN_RECURSO_1);

        /* 					 */

        $DataSet_GEN_RECURSO_2 = array();
        $Objeto_IDE_REC_VALIDADO_DAO = new GEN_RECURSO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
        $lstparametrosM['filtro'] = "AND TIP_RECURSO='3'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_REC_VALIDADO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_RECURSO_2', $DataSet_GEN_RECURSO_2);

        /* 					 */

        $DataSet_GEN_RECURSO_3 = array();
        $Objeto_IDE_REC_APROBADO_DAO = new GEN_RECURSO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
        $lstparametrosM['filtro'] = "AND TIP_RECURSO='3'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_REC_APROBADO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_RECURSO_3', $DataSet_GEN_RECURSO_3);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_ENTREGABLE_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='86'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ENTREGABLE_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('PIDE_PROYECTO', $PIDE_PROYECTO);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;