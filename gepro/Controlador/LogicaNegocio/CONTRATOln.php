<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : CONTRATOLN de la tabla CONTRATO
  //  Fecha           : miércoles, 8 de mayo de 2019 13:16:39
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/CONTRATODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_PROVEEDORDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/PROYECTOlni.php");
require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "CONTRATO";
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
        $PIDE2 = isset($_REQUEST['PIDE2']) ? VerificarInputs($_REQUEST['PIDE2']) : "";
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PROVEEDOR = isset($_REQUEST['IDE_PROVEEDOR']) ? VerificarInputs($_REQUEST['IDE_PROVEEDOR']) : "";
        $IDE_ADM_CONTRATO = isset($_REQUEST['IDE_ADM_CONTRATO']) ? VerificarInputs($_REQUEST['IDE_ADM_CONTRATO']) : "";
        $COD_CONTRATO = isset($_REQUEST['COD_CONTRATO']) ? VerificarInputs($_REQUEST['COD_CONTRATO']) : "";
        $COD_CONTRATO_ENTIDAD = isset($_REQUEST['COD_CONTRATO_ENTIDAD']) ? VerificarInputs($_REQUEST['COD_CONTRATO_ENTIDAD']) : "";
        $COD_CONTRATO_SUP = isset($_REQUEST['COD_CONTRATO_SUP']) ? VerificarInputs($_REQUEST['COD_CONTRATO_SUP']) : "";
        $DES_CONTRATO = isset($_REQUEST['DES_CONTRATO']) ? VerificarInputs($_REQUEST['DES_CONTRATO']) : "";
        $TIP_CONTRATO = isset($_REQUEST['TIP_CONTRATO']) ? VerificarInputs($_REQUEST['TIP_CONTRATO']) : "";
        $FEC_CONTRATO = isset($_REQUEST['FEC_CONTRATO']) ? VerificarInputs($_REQUEST['FEC_CONTRATO']) : "";
        $FEC_INICIO_CONTRATO = isset($_REQUEST['FEC_INICIO_CONTRATO']) ? VerificarInputs($_REQUEST['FEC_INICIO_CONTRATO']) : "";
        $FEC_TERMINO_CONTRATO = isset($_REQUEST['FEC_TERMINO_CONTRATO']) ? VerificarInputs($_REQUEST['FEC_TERMINO_CONTRATO']) : "";
        $FEC_CIERRE_CONTRATO = isset($_REQUEST['FEC_CIERRE_CONTRATO']) ? VerificarInputs($_REQUEST['FEC_CIERRE_CONTRATO']) : "";
        $IMP_IMPONIBLE = isset($_REQUEST['IMP_IMPONIBLE']) ? VerificarInputs($_REQUEST['IMP_IMPONIBLE']) : "";
        $IMP_IMPUESTOS = isset($_REQUEST['IMP_IMPUESTOS']) ? VerificarInputs($_REQUEST['IMP_IMPUESTOS']) : "";
        $IMP_TOTAL = isset($_REQUEST['IMP_TOTAL']) ? VerificarInputs($_REQUEST['IMP_TOTAL']) : "";
        $IMG_CONTRATO = isset($_REQUEST['IMG_CONTRATO']) ? VerificarInputs($_REQUEST['IMG_CONTRATO']) : "";
        $DES_COMENTARIO = isset($_REQUEST['DES_COMENTARIO']) ? VerificarInputs($_REQUEST['DES_COMENTARIO']) : "";
        $EST_CONTRATO = isset($_REQUEST['EST_CONTRATO']) ? VerificarInputs($_REQUEST['EST_CONTRATO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
       if ( $PIDE>0 ){

//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */

            $Data4 = ProyectoContrato_Datos2($PIDE,$PIDE2);
            $VIDE_CONTRATO = $Data4['IDE_CONTRATO'];
            $lCollection->Add('VIDE_CONTRATO', $VIDE_CONTRATO );
            
            $ScriptFLX = $ScriptFLX." AND IDE_CONTRATO=$VIDE_CONTRATO ";
            
       } else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
       } 
       
       $TipoGrilla = ($Pedido=='Busqueda' ? 'SelGrd_CONTRATO_busqueda' : 'SelGrd_CONTRATO' ) ; //echo $Pedido .'-'. $TipoGrilla ; //exit;
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new CONTRATO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_CONTRATO_ENTIDAD') {
                        $_POST['qtype'] = 'T.COD_CONTRATO_ENTIDAD';
                    }
                    if ($_POST['qtype'] == 'COD_UNICO_ORDEN') {
                        $_POST['qtype'] = 'T.COD_UNICO_ORDEN';
                    }
                    if ($_POST['qtype'] == 'DES_CONTRATO') {
                        $_POST['qtype'] = 'T.DES_CONTRATO';
                    }
                    if ($_POST['qtype'] == 'DES_PROVEEDOR') {
                        $_POST['qtype'] = 'P.DES_PROVEEDOR';
                    }
                    if ($_POST['qtype'] == 'FEC_INICIO_CONTRATO') {
                        $_POST['qtype'] = 'T.FEC_INICIO_CONTRATO';
                    }
                    if ($_POST['qtype'] == 'FEC_TERMINO_CONTRATO') {
                        $_POST['qtype'] = 'T.FEC_TERMINO_CONTRATO';
                    }
                    if ($_POST['qtype'] == 'FEC_CIERRE_CONTRATO') {
                        $_POST['qtype'] = 'T.FEC_CIERRE_CONTRATO';
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
            $ogridDAO->Count_CONTRATO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONTRATO;
            $lCollection->Add('nTotal', $nTotal);
            
           // echo '<br>/'.$TipoGrilla.'/' ;// exit;
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        
        
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data = Contrato_Datos($PIDEbuscado);
            $lCollection->Add('VIDE_CONTRATO', $Data['IDE_CONTRATO'] );
            $lCollection->Add('VCOD_UNICO_ORDEN', $Data['COD_UNICO_ORDEN'] );
            $lCollection->Add('VCOD_CONTRATO_ENTIDAD', $Data['COD_CONTRATO_ENTIDAD'] );
            $lCollection->Add('VDES_CONTRATO', $Data['DES_CONTRATO'] );
            $lCollection->Add('VIMP_TOTAL', $Data['IMP_TOTAL'] );
            $lCollection->Add('VEST_CONTRATO', ( $Data['EST_CONTRATO']==4 ? 3 : ($Data['EST_CONTRATO']==5 ? 4 : $Data['EST_CONTRATO'] ) ) );
        }
        
        
        
        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_CONTRATO) > 0) {
                $FEC_CONTRATO = cambiafecha($FEC_CONTRATO);
            } else {
                $FEC_CONTRATO = "";
            }
            if (strlen($FEC_INICIO_CONTRATO) > 0) {
                $FEC_INICIO_CONTRATO = cambiafecha($FEC_INICIO_CONTRATO);
            } else {
                $FEC_INICIO_CONTRATO = "";
            }
            if (strlen($FEC_TERMINO_CONTRATO) > 0) {
                $FEC_TERMINO_CONTRATO = cambiafecha($FEC_TERMINO_CONTRATO);
            } else {
                $FEC_TERMINO_CONTRATO = "";
            }
            if (strlen($FEC_CIERRE_CONTRATO) > 0) {
                $FEC_CIERRE_CONTRATO = cambiafecha($FEC_CIERRE_CONTRATO);
            } else {
                $FEC_CIERRE_CONTRATO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_CONTRATOM = array();
            $Objeto_CONTRATO_DAO = new CONTRATO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROVEEDOR)) > 0) {
                $lstparametrosM['IDE_PROVEEDOR'] = $IDE_PROVEEDOR;
            }
            if (strlen(rtrim($IDE_ADM_CONTRATO)) > 0) {
                $lstparametrosM['IDE_ADM_CONTRATO'] = $IDE_ADM_CONTRATO;
            }
            if (strlen(rtrim($COD_CONTRATO)) > 0) {
                $lstparametrosM['COD_CONTRATO'] = $COD_CONTRATO;
            }
            if (strlen(rtrim($COD_CONTRATO_ENTIDAD)) > 0) {
                $lstparametrosM['COD_CONTRATO_ENTIDAD'] = $COD_CONTRATO_ENTIDAD;
            }
            if (strlen(rtrim($COD_CONTRATO_SUP)) > 0) {
                $lstparametrosM['COD_CONTRATO_SUP'] = $COD_CONTRATO_SUP;
            }
            if (strlen(rtrim($DES_CONTRATO)) > 0) {
                $lstparametrosM['DES_CONTRATO'] = $DES_CONTRATO;
            }
            if (strlen(rtrim($TIP_CONTRATO)) > 0) {
                $lstparametrosM['TIP_CONTRATO'] = $TIP_CONTRATO;
            }
            if (strlen(rtrim($FEC_CONTRATO)) > 0) {
                $lstparametrosM['FEC_CONTRATO'] = $FEC_CONTRATO;
            }
            if (strlen(rtrim($FEC_INICIO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_INICIO_CONTRATO'] = $FEC_INICIO_CONTRATO;
            }
            if (strlen(rtrim($FEC_TERMINO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_TERMINO_CONTRATO'] = $FEC_TERMINO_CONTRATO;
            }
            if (strlen(rtrim($FEC_CIERRE_CONTRATO)) > 0) {
                $lstparametrosM['FEC_CIERRE_CONTRATO'] = $FEC_CIERRE_CONTRATO;
            }
            if (strlen(rtrim($IMP_IMPONIBLE)) > 0) {
                $lstparametrosM['IMP_IMPONIBLE'] = $IMP_IMPONIBLE;
            }
            if (strlen(rtrim($IMP_IMPUESTOS)) > 0) {
                $lstparametrosM['IMP_IMPUESTOS'] = $IMP_IMPUESTOS;
            }
            if (strlen(rtrim($IMP_TOTAL)) > 0) {
                $lstparametrosM['IMP_TOTAL'] = $IMP_TOTAL;
            }
            if (strlen(rtrim($IMG_CONTRATO)) > 0) {
                $lstparametrosM['IMG_CONTRATO'] = $IMG_CONTRATO;
            }
            if (strlen(rtrim($DES_COMENTARIO)) > 0) {
                $lstparametrosM['DES_COMENTARIO'] = $DES_COMENTARIO;
            }
            if (strlen(rtrim($EST_CONTRATO)) > 0) {
                $lstparametrosM['EST_CONTRATO'] = $EST_CONTRATO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROVEEDOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ADM_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_CONTRATO_ENTIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_CONTRATO_SUP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_CIERRE_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_IMPONIBLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_IMPUESTOS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_TOTAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMG_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_COMENTARIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONTRATO_DAO->Insert_CONTRATO($DataSet_CONTRATO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[18][0];

            $mensaje = $procedure_parametrosMS[19][0];

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
            $DataSet_CONTRATO = array();
            $Objeto_CONTRATO_DAO = new CONTRATO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_CONTRATO_DAO->SelPk_CONTRATO($DataSet_CONTRATO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_CONTRATO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_CONTRATO

                $IDE_PROVEEDOR = $DataSet_CONTRATO[0]->IDE_PROVEEDOR;
                $IDE_ADM_CONTRATO = $DataSet_CONTRATO[0]->IDE_ADM_CONTRATO;
                $COD_CONTRATO = $DataSet_CONTRATO[0]->COD_CONTRATO;
                $COD_CONTRATO_ENTIDAD = $DataSet_CONTRATO[0]->COD_CONTRATO_ENTIDAD;
                $COD_CONTRATO_SUP = $DataSet_CONTRATO[0]->COD_CONTRATO_SUP;
                $DES_CONTRATO = $DataSet_CONTRATO[0]->DES_CONTRATO;
                $TIP_CONTRATO = $DataSet_CONTRATO[0]->TIP_CONTRATO;
                $FEC_CONTRATO = $DataSet_CONTRATO[0]->FEC_CONTRATO;
                $FEC_INICIO_CONTRATO = $DataSet_CONTRATO[0]->FEC_INICIO_CONTRATO;
                $FEC_TERMINO_CONTRATO = $DataSet_CONTRATO[0]->FEC_TERMINO_CONTRATO;
                $FEC_CIERRE_CONTRATO = $DataSet_CONTRATO[0]->FEC_CIERRE_CONTRATO;
                $IMP_IMPONIBLE = $DataSet_CONTRATO[0]->IMP_IMPONIBLE;
                $IMP_IMPUESTOS = $DataSet_CONTRATO[0]->IMP_IMPUESTOS;
                $IMP_TOTAL = $DataSet_CONTRATO[0]->IMP_TOTAL;
                $IMG_CONTRATO = $DataSet_CONTRATO[0]->IMG_CONTRATO;
                $DES_COMENTARIO = $DataSet_CONTRATO[0]->DES_COMENTARIO;
                $EST_CONTRATO = $DataSet_CONTRATO[0]->EST_CONTRATO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROVEEDOR', $IDE_PROVEEDOR);
            $lCollection->Add('IDE_ADM_CONTRATO', $IDE_ADM_CONTRATO);
            $lCollection->Add('COD_CONTRATO', $COD_CONTRATO);
            $lCollection->Add('COD_CONTRATO_ENTIDAD', $COD_CONTRATO_ENTIDAD);
            $lCollection->Add('COD_CONTRATO_SUP', $COD_CONTRATO_SUP);
            $lCollection->Add('DES_CONTRATO', $DES_CONTRATO);
            $lCollection->Add('TIP_CONTRATO', $TIP_CONTRATO);
            $lCollection->Add('FEC_CONTRATO', $FEC_CONTRATO);
            $lCollection->Add('FEC_INICIO_CONTRATO', $FEC_INICIO_CONTRATO);
            $lCollection->Add('FEC_TERMINO_CONTRATO', $FEC_TERMINO_CONTRATO);
            $lCollection->Add('FEC_CIERRE_CONTRATO', $FEC_CIERRE_CONTRATO);
            $lCollection->Add('IMP_IMPONIBLE', $IMP_IMPONIBLE);
            $lCollection->Add('IMP_IMPUESTOS', $IMP_IMPUESTOS);
            $lCollection->Add('IMP_TOTAL', $IMP_TOTAL);
            $lCollection->Add('IMG_CONTRATO', $IMG_CONTRATO);
            $lCollection->Add('DES_COMENTARIO', $DES_COMENTARIO);
            $lCollection->Add('EST_CONTRATO', $EST_CONTRATO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_CONTRATO) > 0) {
                $FEC_CONTRATO = cambiafecha($FEC_CONTRATO);
            } else {
                $FEC_CONTRATO = "";
            }
            if (strlen($FEC_INICIO_CONTRATO) > 0) {
                $FEC_INICIO_CONTRATO = cambiafecha($FEC_INICIO_CONTRATO);
            } else {
                $FEC_INICIO_CONTRATO = "";
            }
            if (strlen($FEC_TERMINO_CONTRATO) > 0) {
                $FEC_TERMINO_CONTRATO = cambiafecha($FEC_TERMINO_CONTRATO);
            } else {
                $FEC_TERMINO_CONTRATO = "";
            }
            if (strlen($FEC_CIERRE_CONTRATO) > 0) {
                $FEC_CIERRE_CONTRATO = cambiafecha($FEC_CIERRE_CONTRATO);
            } else {
                $FEC_CIERRE_CONTRATO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_CONTRATO = array();
            $Objeto_CONTRATO_DAO = new CONTRATO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROVEEDOR)) > 0) {
                $lstparametrosM['IDE_PROVEEDOR'] = $IDE_PROVEEDOR;
            }
            if (strlen(rtrim($IDE_ADM_CONTRATO)) > 0) {
                $lstparametrosM['IDE_ADM_CONTRATO'] = $IDE_ADM_CONTRATO;
            }
            if (strlen(rtrim($COD_CONTRATO)) > 0) {
                $lstparametrosM['COD_CONTRATO'] = $COD_CONTRATO;
            }
            if (strlen(rtrim($COD_CONTRATO_ENTIDAD)) > 0) {
                $lstparametrosM['COD_CONTRATO_ENTIDAD'] = $COD_CONTRATO_ENTIDAD;
            }
            if (strlen(rtrim($COD_CONTRATO_SUP)) > 0) {
                $lstparametrosM['COD_CONTRATO_SUP'] = $COD_CONTRATO_SUP;
            }
            if (strlen(rtrim($DES_CONTRATO)) > 0) {
                $lstparametrosM['DES_CONTRATO'] = $DES_CONTRATO;
            }
            if (strlen(rtrim($TIP_CONTRATO)) > 0) {
                $lstparametrosM['TIP_CONTRATO'] = $TIP_CONTRATO;
            }
            if (strlen(rtrim($FEC_CONTRATO)) > 0) {
                $lstparametrosM['FEC_CONTRATO'] = $FEC_CONTRATO;
            }
            if (strlen(rtrim($FEC_INICIO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_INICIO_CONTRATO'] = $FEC_INICIO_CONTRATO;
            }
            if (strlen(rtrim($FEC_TERMINO_CONTRATO)) > 0) {
                $lstparametrosM['FEC_TERMINO_CONTRATO'] = $FEC_TERMINO_CONTRATO;
            }
            if (strlen(rtrim($FEC_CIERRE_CONTRATO)) > 0) {
                $lstparametrosM['FEC_CIERRE_CONTRATO'] = $FEC_CIERRE_CONTRATO;
            }
            if (strlen(rtrim($IMP_IMPONIBLE)) > 0) {
                $lstparametrosM['IMP_IMPONIBLE'] = $IMP_IMPONIBLE;
            }
            if (strlen(rtrim($IMP_IMPUESTOS)) > 0) {
                $lstparametrosM['IMP_IMPUESTOS'] = $IMP_IMPUESTOS;
            }
            if (strlen(rtrim($IMP_TOTAL)) > 0) {
                $lstparametrosM['IMP_TOTAL'] = $IMP_TOTAL;
            }
            if (strlen(rtrim($IMG_CONTRATO)) > 0) {
                $lstparametrosM['IMG_CONTRATO'] = $IMG_CONTRATO;
            }
            if (strlen(rtrim($DES_COMENTARIO)) > 0) {
                $lstparametrosM['DES_COMENTARIO'] = $DES_COMENTARIO;
            }
            if (strlen(rtrim($EST_CONTRATO)) > 0) {
                $lstparametrosM['EST_CONTRATO'] = $EST_CONTRATO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROVEEDOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ADM_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_CONTRATO_ENTIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_CONTRATO_SUP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_CIERRE_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_IMPONIBLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_IMPUESTOS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_TOTAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMG_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_COMENTARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONTRATO_DAO->Update_CONTRATO($DataSet_CONTRATO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[19][0];

            $mensaje = $procedure_parametrosMS[20][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_CONTRATO = array();
            $Objeto_CONTRATO_DAO = new CONTRATO_DAO();
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
            $Objeto_CONTRATO_DAO->Delete_CONTRATO($DataSet_CONTRATO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_PROVEEDOR_1 = array();
        $Objeto_IDE_PROVEEDOR_DAO = new GEN_PROVEEDOR_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PROVEEDOR,DES_PROVEEDOR";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PROVEEDOR_DAO->SelCampos_GEN_PROVEEDOR($DataSet_GEN_PROVEEDOR_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_PROVEEDOR_1', $DataSet_GEN_PROVEEDOR_1);

        /* 					 */

        $DataSet_GEN_RECURSO_1 = array();
        $Objeto_IDE_ADM_CONTRATO_DAO = new GEN_RECURSO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ADM_CONTRATO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_RECURSO_1', $DataSet_GEN_RECURSO_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_CONTRATO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='64'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_CONTRATO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

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

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_CONTRATO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='84'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CONTRATO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('PIDE2', $PIDE2);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;