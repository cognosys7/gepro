<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_PIPLN de la tabla GEN_PIP
  //  Fecha           : lunes, 24 de septiembre de 2018 10:38:34
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_PIPDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION ****/
require_once("include/GEN_PIPLNI.php");
/***EDGAR---**************/

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_PIP";
    $PermisoOK = 0;

/***EDGAR---**************/    
    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}
    
    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
    if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
    if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
    if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}	
    $PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);// echo $PermisosPerfil; die;
/***EDGAR---**************/  

    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";

/***EDGAR---******************/
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : ""; 
        $PIDE_PIP = isset($_REQUEST['PIDE_PIP'])? VerificarInputs($_REQUEST['PIDE_PIP']) : "";
/***EDGAR---******************/
        
        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $COD_SNIP = isset($_REQUEST['COD_SNIP']) ? VerificarInputs($_REQUEST['COD_SNIP']) : "";
        $COD_UNICO = isset($_REQUEST['COD_UNICO']) ? VerificarInputs($_REQUEST['COD_UNICO']) : "";
        $COD_PROYECTO = isset($_REQUEST['COD_PROYECTO']) ? VerificarInputs($_REQUEST['COD_PROYECTO']) : "";
        $DES_PIP = isset($_REQUEST['DES_PIP']) ? VerificarInputs($_REQUEST['DES_PIP']) : "";
        $FEC_REGISTRO = isset($_REQUEST['FEC_REGISTRO']) ? VerificarInputs($_REQUEST['FEC_REGISTRO']) : "";
        $FEC_VIABILIDAD = isset($_REQUEST['FEC_VIABILIDAD']) ? VerificarInputs($_REQUEST['FEC_VIABILIDAD']) : "";
        $IMP_MONTO_VIABLE = isset($_REQUEST['IMP_MONTO_VIABLE']) ? VerificarInputs($_REQUEST['IMP_MONTO_VIABLE']) : "";
        $DES_FUNCION = isset($_REQUEST['DES_FUNCION']) ? VerificarInputs($_REQUEST['DES_FUNCION']) : "";
        $DES_PROGRAMA = isset($_REQUEST['DES_PROGRAMA']) ? VerificarInputs($_REQUEST['DES_PROGRAMA']) : "";
        $DES_SUBPROGRAMA = isset($_REQUEST['DES_SUBPROGRAMA']) ? VerificarInputs($_REQUEST['DES_SUBPROGRAMA']) : "";
        $DES_NIVEL = isset($_REQUEST['DES_NIVEL']) ? VerificarInputs($_REQUEST['DES_NIVEL']) : "";
        $DES_SECTOR = isset($_REQUEST['DES_SECTOR']) ? VerificarInputs($_REQUEST['DES_SECTOR']) : "";
        $DES_PLIEGO = isset($_REQUEST['DES_PLIEGO']) ? VerificarInputs($_REQUEST['DES_PLIEGO']) : "";
        $DES_UNIDAD_EJECUTORA = isset($_REQUEST['DES_UNIDAD_EJECUTORA']) ? VerificarInputs($_REQUEST['DES_UNIDAD_EJECUTORA']) : "";
        $DES_RESPONSABLE_VIABLE = isset($_REQUEST['DES_RESPONSABLE_VIABLE']) ? VerificarInputs($_REQUEST['DES_RESPONSABLE_VIABLE']) : "";
        $IMP_MONTO_F15 = isset($_REQUEST['IMP_MONTO_F15']) ? VerificarInputs($_REQUEST['IMP_MONTO_F15']) : "";
        $IMP_MONTO_F16 = isset($_REQUEST['IMP_MONTO_F16']) ? VerificarInputs($_REQUEST['IMP_MONTO_F16']) : "";
        $IMP_COSTO_ACTUALIZADO = isset($_REQUEST['IMP_COSTO_ACTUALIZADO']) ? VerificarInputs($_REQUEST['IMP_COSTO_ACTUALIZADO']) : "";
        $NUM_BENEFICIARIOS = isset($_REQUEST['NUM_BENEFICIARIOS']) ? VerificarInputs($_REQUEST['NUM_BENEFICIARIOS']) : "";
        $EST_INVIERTE = isset($_REQUEST['EST_INVIERTE']) ? VerificarInputs($_REQUEST['EST_INVIERTE']) : "";
        $TIP_PIP = isset($_REQUEST['TIP_PIP']) ? VerificarInputs($_REQUEST['TIP_PIP']) : "";
        $TIP_PIP_CODIGO = isset($_REQUEST['TIP_PIP_CODIGO']) ? VerificarInputs($_REQUEST['TIP_PIP_CODIGO']) : "";
        $EST_PIP = isset($_REQUEST['EST_PIP']) ? VerificarInputs($_REQUEST['EST_PIP']) : "";
        $DES_OBSERVACION = isset($_REQUEST['DES_OBSERVACION']) ? VerificarInputs($_REQUEST['DES_OBSERVACION']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;    

        
/* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_PIP' ;
        if($Pedido=='Busqueda'){ $TipoGrilla = 'SelGrd_GEN_PIP_busqueda'  ; }        
/* EDGAR */
        
        
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_PIP_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'CodigoSNIP') {
                        $_POST['qtype'] = 'PIP.COD_SNIP';
                    }
                    if ($_POST['qtype'] == 'CodigoUnico') {
                        $_POST['qtype'] = 'PIP.COD_UNICO';
                    }
//                    if ($_POST['qtype'] == 'CodigoProyecto') {
//                        $_POST['qtype'] = 'PIP.COD_PROYECTO';
//                    }
                    if ($_POST['qtype'] == 'DescripcionProyecto') {
                        $_POST['qtype'] = 'PIP.DES_PIP';
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
            $ogridDAO->Count_GEN_PIP($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PIP;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

/***EDGAR---**************/   
        if ($Action == "PasarDatos") {
            $data = PIP_Datos($PIDE_PIP);
            $lCollection->Add('VIDE_PIP', $PIDE_PIP);
            $lCollection->Add('VCOD_PROYECTO', $data['COD_PROYECTO']);
            $lCollection->Add('VDES_PIP', $data['DES_PIP']);
            $lCollection->Add('VIMP_MONTO_VIABLE', $data['IMP_MONTO_VIABLE']); 
            $lCollection->Add('VCOD_SNIP', $data['COD_SNIP']); 
            $lCollection->Add('VCOD_UNICO', $data['COD_UNICO']); 
            $lCollection->Add('VCOD_PROYECTO', $data['COD_PROYECTO']); 
        }
/***EDGAR---**************/
        
        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_REGISTRO) > 0) {
                $FEC_REGISTRO = cambiafecha($FEC_REGISTRO);
            } else {
                $FEC_REGISTRO = "";
            }
            if (strlen($FEC_VIABILIDAD) > 0) {
                $FEC_VIABILIDAD = cambiafecha($FEC_VIABILIDAD);
            } else {
                $FEC_VIABILIDAD = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_GEN_PIPM = array();
            $Objeto_GEN_PIP_DAO = new GEN_PIP_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_PROYECTO)) > 0) {
                $lstparametrosM['COD_PROYECTO'] = $COD_PROYECTO;
            }
            if (strlen(rtrim($DES_PIP)) > 0) {
                $lstparametrosM['DES_PIP'] = $DES_PIP;
            }
            if (strlen(rtrim($FEC_REGISTRO)) > 0) {
                $lstparametrosM['FEC_REGISTRO'] = $FEC_REGISTRO;
            }
            if (strlen(rtrim($FEC_VIABILIDAD)) > 0) {
                $lstparametrosM['FEC_VIABILIDAD'] = $FEC_VIABILIDAD;
            }
/***EDGAR---**************/ 
            $IMP_MONTO_VIABLE = ( is_null($IMP_MONTO_VIABLE)  ||  $IMP_MONTO_VIABLE=='' ? 0 : $IMP_MONTO_VIABLE ) ;
/***EDGAR---**************/ 
            if (strlen(rtrim($IMP_MONTO_VIABLE)) > 0) {
                $lstparametrosM['IMP_MONTO_VIABLE'] = $IMP_MONTO_VIABLE;
            }
            if (strlen(rtrim($DES_FUNCION)) > 0) {
                $lstparametrosM['DES_FUNCION'] = $DES_FUNCION;
            }
            if (strlen(rtrim($DES_PROGRAMA)) > 0) {
                $lstparametrosM['DES_PROGRAMA'] = $DES_PROGRAMA;
            }
            if (strlen(rtrim($DES_SUBPROGRAMA)) > 0) {
                $lstparametrosM['DES_SUBPROGRAMA'] = $DES_SUBPROGRAMA;
            }
            if (strlen(rtrim($DES_NIVEL)) > 0) {
                $lstparametrosM['DES_NIVEL'] = $DES_NIVEL;
            }
            if (strlen(rtrim($DES_SECTOR)) > 0) {
                $lstparametrosM['DES_SECTOR'] = $DES_SECTOR;
            }
            if (strlen(rtrim($DES_PLIEGO)) > 0) {
                $lstparametrosM['DES_PLIEGO'] = $DES_PLIEGO;
            }
            if (strlen(rtrim($DES_UNIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['DES_UNIDAD_EJECUTORA'] = $DES_UNIDAD_EJECUTORA;
            }
            if (strlen(rtrim($DES_RESPONSABLE_VIABLE)) > 0) {
                $lstparametrosM['DES_RESPONSABLE_VIABLE'] = $DES_RESPONSABLE_VIABLE;
            }
            if (strlen(rtrim($IMP_MONTO_F15)) > 0) {
                $lstparametrosM['IMP_MONTO_F15'] = $IMP_MONTO_F15;
            }
            if (strlen(rtrim($IMP_MONTO_F16)) > 0) {
                $lstparametrosM['IMP_MONTO_F16'] = $IMP_MONTO_F16;
            }
/***EDGAR---**************/ 
            $IMP_COSTO_ACTUALIZADO = ( is_null($IMP_MONTO_VIABLE)  ||  $IMP_COSTO_ACTUALIZADO=='' ? 0 : $IMP_MONTO_VIABLE ) ;
/***EDGAR---**************/
            if (strlen(rtrim($IMP_COSTO_ACTUALIZADO)) > 0) {
                $lstparametrosM['IMP_COSTO_ACTUALIZADO'] = $IMP_COSTO_ACTUALIZADO;
            }
            if (strlen(rtrim($NUM_BENEFICIARIOS)) > 0) {
                $lstparametrosM['NUM_BENEFICIARIOS'] = $NUM_BENEFICIARIOS;
            }
            if (strlen(rtrim($EST_INVIERTE)) > 0) {
                $lstparametrosM['EST_INVIERTE'] = $EST_INVIERTE;
            }
            if (strlen(rtrim($TIP_PIP)) > 0) {
                $lstparametrosM['TIP_PIP'] = $TIP_PIP;
            }
            if (strlen(rtrim($TIP_PIP_CODIGO)) > 0) {
                $lstparametrosM['TIP_PIP_CODIGO'] = $TIP_PIP_CODIGO;
            }
            if (strlen(rtrim($EST_PIP)) > 0) {
                $lstparametrosM['EST_PIP'] = $EST_PIP;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_REGISTRO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_VIABILIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_MONTO_VIABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_FUNCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROGRAMA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SUBPROGRAMA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_NIVEL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SECTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PLIEGO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_UNIDAD_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_RESPONSABLE_VIABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_MONTO_F15'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_MONTO_F16'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_COSTO_ACTUALIZADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_BENEFICIARIOS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_INVIERTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PIP_CODIGO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_PIP_DAO->Insert_GEN_PIP($DataSet_GEN_PIP, $procedure_parametrosMS); //JCMY

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
        $FiltroEstado = NULL ;
        if ($Action == "ModificarRegistro") {
            //var_dump($SeleccionarID); 
            $DataSet_GEN_PIP = array();
            $Objeto_GEN_PIP_DAO = new GEN_PIP_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_PIP_DAO->SelPk_GEN_PIP($DataSet_GEN_PIP, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_PIP) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_PIP

                $COD_SNIP = $DataSet_GEN_PIP[0]->COD_SNIP;
                $COD_UNICO = $DataSet_GEN_PIP[0]->COD_UNICO;
                $COD_PROYECTO = $DataSet_GEN_PIP[0]->COD_PROYECTO;
                $DES_PIP = $DataSet_GEN_PIP[0]->DES_PIP;
                $FEC_REGISTRO = $DataSet_GEN_PIP[0]->FEC_REGISTRO;
                $FEC_VIABILIDAD = $DataSet_GEN_PIP[0]->FEC_VIABILIDAD;
                $IMP_MONTO_VIABLE = $DataSet_GEN_PIP[0]->IMP_MONTO_VIABLE;
                $DES_FUNCION = $DataSet_GEN_PIP[0]->DES_FUNCION;
                $DES_PROGRAMA = $DataSet_GEN_PIP[0]->DES_PROGRAMA;
                $DES_SUBPROGRAMA = $DataSet_GEN_PIP[0]->DES_SUBPROGRAMA;
                $DES_NIVEL = $DataSet_GEN_PIP[0]->DES_NIVEL;
                $DES_SECTOR = $DataSet_GEN_PIP[0]->DES_SECTOR;
                $DES_PLIEGO = $DataSet_GEN_PIP[0]->DES_PLIEGO;
                $DES_UNIDAD_EJECUTORA = $DataSet_GEN_PIP[0]->DES_UNIDAD_EJECUTORA;
                $DES_RESPONSABLE_VIABLE = $DataSet_GEN_PIP[0]->DES_RESPONSABLE_VIABLE;
                $IMP_MONTO_F15 = $DataSet_GEN_PIP[0]->IMP_MONTO_F15;
                $IMP_MONTO_F16 = $DataSet_GEN_PIP[0]->IMP_MONTO_F16;
                $IMP_COSTO_ACTUALIZADO = $DataSet_GEN_PIP[0]->IMP_COSTO_ACTUALIZADO;
                $NUM_BENEFICIARIOS = $DataSet_GEN_PIP[0]->NUM_BENEFICIARIOS;
                $EST_INVIERTE = $DataSet_GEN_PIP[0]->EST_INVIERTE;
                $TIP_PIP = $DataSet_GEN_PIP[0]->TIP_PIP;
                $TIP_PIP_CODIGO = $DataSet_GEN_PIP[0]->TIP_PIP_CODIGO;
                $EST_PIP = $DataSet_GEN_PIP[0]->EST_PIP;
                $DES_OBSERVACION = $DataSet_GEN_PIP[0]->DES_OBSERVACION;
                
                if($EST_PIP=='3'  ||  $EST_PIP=='4') { $FiltroEstado = " AND ( COD_ITEM IN('3','4') ) " ;}
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('COD_SNIP', $COD_SNIP);
            $lCollection->Add('COD_UNICO', $COD_UNICO);
            $lCollection->Add('COD_PROYECTO', $COD_PROYECTO);
            $lCollection->Add('DES_PIP', $DES_PIP);
            $lCollection->Add('FEC_REGISTRO', $FEC_REGISTRO);
            $lCollection->Add('FEC_VIABILIDAD', $FEC_VIABILIDAD);
            $lCollection->Add('IMP_MONTO_VIABLE', $IMP_MONTO_VIABLE);
            $lCollection->Add('DES_FUNCION', $DES_FUNCION);
            $lCollection->Add('DES_PROGRAMA', $DES_PROGRAMA);
            $lCollection->Add('DES_SUBPROGRAMA', $DES_SUBPROGRAMA);
            $lCollection->Add('DES_NIVEL', $DES_NIVEL);
            $lCollection->Add('DES_SECTOR', $DES_SECTOR);
            $lCollection->Add('DES_PLIEGO', $DES_PLIEGO);
            $lCollection->Add('DES_UNIDAD_EJECUTORA', $DES_UNIDAD_EJECUTORA);
            $lCollection->Add('DES_RESPONSABLE_VIABLE', $DES_RESPONSABLE_VIABLE);
            $lCollection->Add('IMP_MONTO_F15', $IMP_MONTO_F15);
            $lCollection->Add('IMP_MONTO_F16', $IMP_MONTO_F16);
            $lCollection->Add('IMP_COSTO_ACTUALIZADO', $IMP_COSTO_ACTUALIZADO);
            $lCollection->Add('NUM_BENEFICIARIOS', $NUM_BENEFICIARIOS);
            $lCollection->Add('EST_INVIERTE', $EST_INVIERTE);
            $lCollection->Add('TIP_PIP', $TIP_PIP);
            $lCollection->Add('TIP_PIP_CODIGO', $TIP_PIP_CODIGO);
            $lCollection->Add('EST_PIP', $EST_PIP);
            $lCollection->Add('DES_OBSERVACION', $DES_OBSERVACION);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_REGISTRO) > 0) {
                $FEC_REGISTRO = cambiafecha($FEC_REGISTRO);
            } else {
                $FEC_REGISTRO = "";
            }
            if (strlen($FEC_VIABILIDAD) > 0) {
                $FEC_VIABILIDAD = cambiafecha($FEC_VIABILIDAD);
            } else {
                $FEC_VIABILIDAD = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_PIP = array();
            $Objeto_GEN_PIP_DAO = new GEN_PIP_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_PROYECTO)) > 0) {
                $lstparametrosM['COD_PROYECTO'] = $COD_PROYECTO;
            }
            if (strlen(rtrim($DES_PIP)) > 0) {
                $lstparametrosM['DES_PIP'] = $DES_PIP;
            }
            if (strlen(rtrim($FEC_REGISTRO)) > 0) {
                $lstparametrosM['FEC_REGISTRO'] = $FEC_REGISTRO;
            }
            if (strlen(rtrim($FEC_VIABILIDAD)) > 0) {
                $lstparametrosM['FEC_VIABILIDAD'] = $FEC_VIABILIDAD;
            }
            if (strlen(rtrim($IMP_MONTO_VIABLE)) > 0) {
                $lstparametrosM['IMP_MONTO_VIABLE'] = $IMP_MONTO_VIABLE;
            }
            if (strlen(rtrim($DES_FUNCION)) > 0) {
                $lstparametrosM['DES_FUNCION'] = $DES_FUNCION;
            }
            if (strlen(rtrim($DES_PROGRAMA)) > 0) {
                $lstparametrosM['DES_PROGRAMA'] = $DES_PROGRAMA;
            }
            if (strlen(rtrim($DES_SUBPROGRAMA)) > 0) {
                $lstparametrosM['DES_SUBPROGRAMA'] = $DES_SUBPROGRAMA;
            }
            if (strlen(rtrim($DES_NIVEL)) > 0) {
                $lstparametrosM['DES_NIVEL'] = $DES_NIVEL;
            }
            if (strlen(rtrim($DES_SECTOR)) > 0) {
                $lstparametrosM['DES_SECTOR'] = $DES_SECTOR;
            }
            if (strlen(rtrim($DES_PLIEGO)) > 0) {
                $lstparametrosM['DES_PLIEGO'] = $DES_PLIEGO;
            }
            if (strlen(rtrim($DES_UNIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['DES_UNIDAD_EJECUTORA'] = $DES_UNIDAD_EJECUTORA;
            }
            if (strlen(rtrim($DES_RESPONSABLE_VIABLE)) > 0) {
                $lstparametrosM['DES_RESPONSABLE_VIABLE'] = $DES_RESPONSABLE_VIABLE;
            }
            if (strlen(rtrim($IMP_MONTO_F15)) > 0) {
                $lstparametrosM['IMP_MONTO_F15'] = $IMP_MONTO_F15;
            }
            if (strlen(rtrim($IMP_MONTO_F16)) > 0) {
                $lstparametrosM['IMP_MONTO_F16'] = $IMP_MONTO_F16;
            }
            if (strlen(rtrim($IMP_COSTO_ACTUALIZADO)) > 0) {
                $lstparametrosM['IMP_COSTO_ACTUALIZADO'] = $IMP_COSTO_ACTUALIZADO;
            }
            if (strlen(rtrim($NUM_BENEFICIARIOS)) > 0) {
                $lstparametrosM['NUM_BENEFICIARIOS'] = $NUM_BENEFICIARIOS;
            }
            if (strlen(rtrim($EST_INVIERTE)) > 0) {
                $lstparametrosM['EST_INVIERTE'] = $EST_INVIERTE;
            }
            if (strlen(rtrim($TIP_PIP)) > 0) {
                $lstparametrosM['TIP_PIP'] = $TIP_PIP;
            }
            if (strlen(rtrim($TIP_PIP_CODIGO)) > 0) {
                $lstparametrosM['TIP_PIP_CODIGO'] = $TIP_PIP_CODIGO;
            }
            if (strlen(rtrim($EST_PIP)) > 0) {
                $lstparametrosM['EST_PIP'] = $EST_PIP;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_REGISTRO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_VIABILIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_MONTO_VIABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_FUNCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROGRAMA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SUBPROGRAMA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_NIVEL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SECTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PLIEGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_UNIDAD_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_RESPONSABLE_VIABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_MONTO_F15'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_MONTO_F16'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_COSTO_ACTUALIZADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_BENEFICIARIOS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_INVIERTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PIP_CODIGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_PIP_DAO->Update_GEN_PIP($DataSet_GEN_PIP, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[26][0];

            $mensaje = $procedure_parametrosMS[27][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_PIP = array();
            $Objeto_GEN_PIP_DAO = new GEN_PIP_DAO();
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
            $Objeto_GEN_PIP_DAO->Delete_GEN_PIP($DataSet_GEN_PIP, $procedure_parametrosMS); //JCMY
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

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_INVIERTE_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='60'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_INVIERTE_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_PIP_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='58'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PIP_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_TIP_PIP_CODIGO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='59'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PIP_CODIGO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        
        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_EST_PIP_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='57' AND COD_ITEM<>'2' " . $FiltroEstado ;

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PIP_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
        
        $lCollection->Add('Pedido', $Pedido);
        
    }
}

//var_dump($lstDepartamento);exit;