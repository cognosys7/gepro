<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : CONT_INTERESADOSLN de la tabla CONT_INTERESADOS
  //  Fecha           : sábado, 25 de mayo de 2019 1:43:01
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/CONT_INTERESADOSDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


//require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ROLESDAO.php");
//require_once(PATH_CONTROLADOR_DAO . "/GEN_CARGODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/GEN_INTERVENCIONlni.php");

require_once("include/CONT_INTERESADOSlni.php");

//// busqueda
require_once("include/GEN_RECURSOlni.php");
require_once("include/GEN_CARGOlni.php");
require_once("include/GEN_ENTIDADlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "CONT_INTERESADOS";
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
	$PINTERVENCION = isset($_REQUEST['PINTERVENCION']) ? VerificarInputs($_REQUEST['PINTERVENCION']) : "";
        
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        $ProyectoExtractor = isset($_REQUEST['ProyectoExtractor']) ? VerificarInputs($_REQUEST['ProyectoExtractor']) : "";
        
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_CONTRATO = isset($_REQUEST['IDE_CONTRATO']) ? VerificarInputs($_REQUEST['IDE_CONTRATO']) : "";
        $IDE_RECURSO = isset($_REQUEST['IDE_RECURSO']) ? VerificarInputs($_REQUEST['IDE_RECURSO']) : "";
        $IDE_ROL = isset($_REQUEST['IDE_ROL']) ? VerificarInputs($_REQUEST['IDE_ROL']) : "";
        $IDE_PUESTO = isset($_REQUEST['IDE_PUESTO']) ? VerificarInputs($_REQUEST['IDE_PUESTO']) : "";
        $DES_LOCALIZACION = isset($_REQUEST['DES_LOCALIZACION']) ? VerificarInputs($_REQUEST['DES_LOCALIZACION']) : "";
        $DES_MAIL = isset($_REQUEST['DES_MAIL']) ? VerificarInputs($_REQUEST['DES_MAIL']) : "";
        $DES_TELEFONO = isset($_REQUEST['DES_TELEFONO']) ? VerificarInputs($_REQUEST['DES_TELEFONO']) : "";
        $DES_REQUERIMIENTOS_PRIMORDIALES = isset($_REQUEST['DES_REQUERIMIENTOS_PRIMORDIALES']) ? VerificarInputs($_REQUEST['DES_REQUERIMIENTOS_PRIMORDIALES']) : "";
        $DES_EXPECTATIVAS_PRINCIPALES = isset($_REQUEST['DES_EXPECTATIVAS_PRINCIPALES']) ? VerificarInputs($_REQUEST['DES_EXPECTATIVAS_PRINCIPALES']) : "";
        $TIP_INFLUENCIA_POTENCIAL = isset($_REQUEST['TIP_INFLUENCIA_POTENCIAL']) ? VerificarInputs($_REQUEST['TIP_INFLUENCIA_POTENCIAL']) : "";
        $DES_FASE_MAYOR_INTERES = isset($_REQUEST['DES_FASE_MAYOR_INTERES']) ? VerificarInputs($_REQUEST['DES_FASE_MAYOR_INTERES']) : "";
        $TIP_INTERNO_EXTERNO = isset($_REQUEST['TIP_INTERNO_EXTERNO']) ? VerificarInputs($_REQUEST['TIP_INTERNO_EXTERNO']) : "";
        $TIP_CLASIFICACION = isset($_REQUEST['TIP_CLASIFICACION']) ? VerificarInputs($_REQUEST['TIP_CLASIFICACION']) : "";
        $DES_INTERES_PROYECTO = isset($_REQUEST['DES_INTERES_PROYECTO']) ? VerificarInputs($_REQUEST['DES_INTERES_PROYECTO']) : "";
        $TIP_EVALUACION_IMPACTO = isset($_REQUEST['TIP_EVALUACION_IMPACTO']) ? VerificarInputs($_REQUEST['TIP_EVALUACION_IMPACTO']) : "";
        $DES_ESTRATEGIA_PRINCIPAL = isset($_REQUEST['DES_ESTRATEGIA_PRINCIPAL']) ? VerificarInputs($_REQUEST['DES_ESTRATEGIA_PRINCIPAL']) : "";
        $DES_OBSERVACION = isset($_REQUEST['DES_OBSERVACION']) ? VerificarInputs($_REQUEST['DES_OBSERVACION']) : "";
        $EST_CONT_INTERESADO = isset($_REQUEST['EST_CONT_INTERESADO']) ? VerificarInputs($_REQUEST['EST_CONT_INTERESADO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_CONT_INTERESADOS';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_CONTRATO=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
            $Data3 = ProyectoContrato_Datos2($PIDE,$PIDE_PROYECTO);
            $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
       } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_CONT_INTERESADOS_busqueda';
            //$ScriptFLX = $ScriptFLX." AND P.IDE_PROYECTO=$ProyectoExtractor";
            $Data5 = Proyecto_Datos($ProyectoExtractor);
            //$ScriptFLX = $ScriptFLX." AND PA.IDE_PROYECTO=$ProyectoExtractor ";
            $ScriptFLX = $ScriptFLX." AND P.COD_UNICO='".$Data5['COD_UNICO']."'";   //para que pueda soportar todos los contratos del proyecto
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new CONT_INTERESADOS_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {

                    if ($_POST['qtype'] == 'COD_CONTRATO_ENTIDAD') {
                        $_POST['qtype'] = 'C.COD_CONTRATO_ENTIDAD';
                    }
                    if ($_POST['qtype'] == 'DES_INTERVENCION') {
                        $_POST['qtype'] = 'GI.DES_INTERVENCION';
                    }
                    
                    if ($_POST['qtype'] == 'DES_RECURSO') {
                        $_POST['qtype'] = 'REC.DES_RECURSO';
                    }
                    if ($_POST['qtype'] == 'DES_ROL') {
                        $_POST['qtype'] = 'ROL.DES_ROL';
                    }
                    if ($_POST['qtype'] == 'DES_CARGO') {
                        $_POST['qtype'] = 'CAR.DES_CARGO';
                    }
                    if ($_POST['qtype'] == 'DES_LOCALIZACION') {
                        $_POST['qtype'] = 'T.DES_LOCALIZACION';
                    }
                    if ($_POST['qtype'] == 'DES_MAIL') {
                        $_POST['qtype'] = 'T.DES_MAIL';
                    }
                    if ($_POST['qtype'] == 'DES_REQUERIMIENTOS_PRIMORDIALES') {
                        $_POST['qtype'] = 'T.DES_REQUERIMIENTOS_PRIMORDIALES';
                    }
                    if ($_POST['qtype'] == 'DES_EXPECTATIVAS_PRINCIPALES') {
                        $_POST['qtype'] = 'T.DES_EXPECTATIVAS_PRINCIPALES';
                    }
                    if ($_POST['qtype'] == 'Tipo') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
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
            $ogridDAO->Count_CONT_INTERESADOS($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONT_INTERESADO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
        *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
        /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data = Interesados_Datos($PIDEbuscado);
            $BIDE = $Data['BIDE'] ;
            
            $Data1 = Recurso_Datos($Data['IDE_RECURSO']);
            $Data2 = Cargo_Datos($Data['IDE_PUESTO']);
            
            $Bdescripcion = $Data1['DES_RECURSO'] .' ( '. $Data2['DES_CARGO'] .' ) ' ;
            
            $lCollection->Add('BIDE', $BIDE);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_CONT_INTERESADOSM = array();
            $Objeto_CONT_INTERESADOS_DAO = new CONT_INTERESADOS_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_RECURSO)) > 0) {
                $lstparametrosM['IDE_RECURSO'] = $IDE_RECURSO;
            }
            if (strlen(rtrim($IDE_ROL)) > 0) {
                $lstparametrosM['IDE_ROL'] = $IDE_ROL;
            }
            if (strlen(rtrim($IDE_PUESTO)) > 0) {
                $lstparametrosM['IDE_PUESTO'] = $IDE_PUESTO;
            }
            if (strlen(rtrim($DES_LOCALIZACION)) > 0) {
                $lstparametrosM['DES_LOCALIZACION'] = $DES_LOCALIZACION;
            }
            if (strlen(rtrim($DES_MAIL)) > 0) {
                $lstparametrosM['DES_MAIL'] = $DES_MAIL;
            }
            if (strlen(rtrim($DES_TELEFONO)) > 0) {
                $lstparametrosM['DES_TELEFONO'] = $DES_TELEFONO;
            }
            if (strlen(rtrim($DES_REQUERIMIENTOS_PRIMORDIALES)) > 0) {
                $lstparametrosM['DES_REQUERIMIENTOS_PRIMORDIALES'] = $DES_REQUERIMIENTOS_PRIMORDIALES;
            }
            if (strlen(rtrim($DES_EXPECTATIVAS_PRINCIPALES)) > 0) {
                $lstparametrosM['DES_EXPECTATIVAS_PRINCIPALES'] = $DES_EXPECTATIVAS_PRINCIPALES;
            }
            if (strlen(rtrim($TIP_INFLUENCIA_POTENCIAL)) > 0) {
                $lstparametrosM['TIP_INFLUENCIA_POTENCIAL'] = $TIP_INFLUENCIA_POTENCIAL;
            }
            if (strlen(rtrim($DES_FASE_MAYOR_INTERES)) > 0) {
                $lstparametrosM['DES_FASE_MAYOR_INTERES'] = $DES_FASE_MAYOR_INTERES;
            }
            if (strlen(rtrim($TIP_INTERNO_EXTERNO)) > 0) {
                $lstparametrosM['TIP_INTERNO_EXTERNO'] = $TIP_INTERNO_EXTERNO;
            }
            if (strlen(rtrim($TIP_CLASIFICACION)) > 0) {
                $lstparametrosM['TIP_CLASIFICACION'] = $TIP_CLASIFICACION;
            }
            if (strlen(rtrim($DES_INTERES_PROYECTO)) > 0) {
                $lstparametrosM['DES_INTERES_PROYECTO'] = $DES_INTERES_PROYECTO;
            }
            if (strlen(rtrim($TIP_EVALUACION_IMPACTO)) > 0) {
                $lstparametrosM['TIP_EVALUACION_IMPACTO'] = $TIP_EVALUACION_IMPACTO;
            }
            if (strlen(rtrim($DES_ESTRATEGIA_PRINCIPAL)) > 0) {
                $lstparametrosM['DES_ESTRATEGIA_PRINCIPAL'] = $DES_ESTRATEGIA_PRINCIPAL;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_CONT_INTERESADO)) > 0) {
                $lstparametrosM['EST_CONT_INTERESADO'] = $EST_CONT_INTERESADO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_RECURSO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ROL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PUESTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_LOCALIZACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_MAIL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_TELEFONO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_REQUERIMIENTOS_PRIMORDIALES'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_EXPECTATIVAS_PRINCIPALES'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_INFLUENCIA_POTENCIAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_FASE_MAYOR_INTERES'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_INTERNO_EXTERNO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_CLASIFICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_INTERES_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_EVALUACION_IMPACTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ESTRATEGIA_PRINCIPAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CONT_INTERESADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_INTERESADOS_DAO->Insert_CONT_INTERESADOS($DataSet_CONT_INTERESADOS, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[19][0];

            $mensaje = $procedure_parametrosMS[20][0];

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
            $DataSet_CONT_INTERESADOS = array();
            $Objeto_CONT_INTERESADOS_DAO = new CONT_INTERESADOS_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_CONT_INTERESADOS_DAO->SelPk_CONT_INTERESADOS($DataSet_CONT_INTERESADOS, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_CONT_INTERESADOS) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_CONT_INTERESADOS

                $IDE_CONTRATO = $DataSet_CONT_INTERESADOS[0]->IDE_CONTRATO;
                $IDE_RECURSO = $DataSet_CONT_INTERESADOS[0]->IDE_RECURSO;
                $IDE_ROL = $DataSet_CONT_INTERESADOS[0]->IDE_ROL;
                $IDE_PUESTO = $DataSet_CONT_INTERESADOS[0]->IDE_PUESTO;
                $DES_LOCALIZACION = $DataSet_CONT_INTERESADOS[0]->DES_LOCALIZACION;
                $DES_MAIL = $DataSet_CONT_INTERESADOS[0]->DES_MAIL;
                $DES_TELEFONO = $DataSet_CONT_INTERESADOS[0]->DES_TELEFONO;
                $DES_REQUERIMIENTOS_PRIMORDIALES = $DataSet_CONT_INTERESADOS[0]->DES_REQUERIMIENTOS_PRIMORDIALES;
                $DES_EXPECTATIVAS_PRINCIPALES = $DataSet_CONT_INTERESADOS[0]->DES_EXPECTATIVAS_PRINCIPALES;
                $TIP_INFLUENCIA_POTENCIAL = $DataSet_CONT_INTERESADOS[0]->TIP_INFLUENCIA_POTENCIAL;
                $DES_FASE_MAYOR_INTERES = $DataSet_CONT_INTERESADOS[0]->DES_FASE_MAYOR_INTERES;
                $TIP_INTERNO_EXTERNO = $DataSet_CONT_INTERESADOS[0]->TIP_INTERNO_EXTERNO;
                $TIP_CLASIFICACION = $DataSet_CONT_INTERESADOS[0]->TIP_CLASIFICACION;
                $DES_INTERES_PROYECTO = $DataSet_CONT_INTERESADOS[0]->DES_INTERES_PROYECTO;
                $TIP_EVALUACION_IMPACTO = $DataSet_CONT_INTERESADOS[0]->TIP_EVALUACION_IMPACTO;
                $DES_ESTRATEGIA_PRINCIPAL = $DataSet_CONT_INTERESADOS[0]->DES_ESTRATEGIA_PRINCIPAL;
                $DES_OBSERVACION = $DataSet_CONT_INTERESADOS[0]->DES_OBSERVACION;
                $EST_CONT_INTERESADO = $DataSet_CONT_INTERESADOS[0]->EST_CONT_INTERESADO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONTRATO', $IDE_CONTRATO);
            $lCollection->Add('IDE_RECURSO', $IDE_RECURSO);
            $lCollection->Add('IDE_ROL', $IDE_ROL);
            $lCollection->Add('IDE_PUESTO', $IDE_PUESTO);
            $lCollection->Add('DES_LOCALIZACION', $DES_LOCALIZACION);
            $lCollection->Add('DES_MAIL', $DES_MAIL);
            $lCollection->Add('DES_TELEFONO', $DES_TELEFONO);
            $lCollection->Add('DES_REQUERIMIENTOS_PRIMORDIALES', $DES_REQUERIMIENTOS_PRIMORDIALES);
            $lCollection->Add('DES_EXPECTATIVAS_PRINCIPALES', $DES_EXPECTATIVAS_PRINCIPALES);
            $lCollection->Add('TIP_INFLUENCIA_POTENCIAL', $TIP_INFLUENCIA_POTENCIAL);
            $lCollection->Add('DES_FASE_MAYOR_INTERES', $DES_FASE_MAYOR_INTERES);
            $lCollection->Add('TIP_INTERNO_EXTERNO', $TIP_INTERNO_EXTERNO);
            $lCollection->Add('TIP_CLASIFICACION', $TIP_CLASIFICACION);
            $lCollection->Add('DES_INTERES_PROYECTO', $DES_INTERES_PROYECTO);
            $lCollection->Add('TIP_EVALUACION_IMPACTO', $TIP_EVALUACION_IMPACTO);
            $lCollection->Add('DES_ESTRATEGIA_PRINCIPAL', $DES_ESTRATEGIA_PRINCIPAL);
            $lCollection->Add('DES_OBSERVACION', $DES_OBSERVACION);
            $lCollection->Add('EST_CONT_INTERESADO', $EST_CONT_INTERESADO);


            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data = Recurso_Datos($IDE_RECURSO);
            $Data1 = Entidad_Datos($Data['IDE_ENTIDAD']);
            
            $Bdescripcion = $Data['DES_RECURSO'] .' [ '. $Data1['DES_ENTIDAD'] .' ( RUC: '. $Data1['COD_RUC'] .' ) ]' ;
            
            $lCollection->Add('Bdescripcion', $Bdescripcion);
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_CONT_INTERESADOS = array();
            $Objeto_CONT_INTERESADOS_DAO = new CONT_INTERESADOS_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_RECURSO)) > 0) {
                $lstparametrosM['IDE_RECURSO'] = $IDE_RECURSO;
            }
            if (strlen(rtrim($IDE_ROL)) > 0) {
                $lstparametrosM['IDE_ROL'] = $IDE_ROL;
            }
            if (strlen(rtrim($IDE_PUESTO)) > 0) {
                $lstparametrosM['IDE_PUESTO'] = $IDE_PUESTO;
            }
            if (strlen(rtrim($DES_LOCALIZACION)) > 0) {
                $lstparametrosM['DES_LOCALIZACION'] = $DES_LOCALIZACION;
            }
            if (strlen(rtrim($DES_MAIL)) > 0) {
                $lstparametrosM['DES_MAIL'] = $DES_MAIL;
            }
            if (strlen(rtrim($DES_TELEFONO)) > 0) {
                $lstparametrosM['DES_TELEFONO'] = $DES_TELEFONO;
            }
            if (strlen(rtrim($DES_REQUERIMIENTOS_PRIMORDIALES)) > 0) {
                $lstparametrosM['DES_REQUERIMIENTOS_PRIMORDIALES'] = $DES_REQUERIMIENTOS_PRIMORDIALES;
            }
            if (strlen(rtrim($DES_EXPECTATIVAS_PRINCIPALES)) > 0) {
                $lstparametrosM['DES_EXPECTATIVAS_PRINCIPALES'] = $DES_EXPECTATIVAS_PRINCIPALES;
            }
            if (strlen(rtrim($TIP_INFLUENCIA_POTENCIAL)) > 0) {
                $lstparametrosM['TIP_INFLUENCIA_POTENCIAL'] = $TIP_INFLUENCIA_POTENCIAL;
            }
            if (strlen(rtrim($DES_FASE_MAYOR_INTERES)) > 0) {
                $lstparametrosM['DES_FASE_MAYOR_INTERES'] = $DES_FASE_MAYOR_INTERES;
            }
            if (strlen(rtrim($TIP_INTERNO_EXTERNO)) > 0) {
                $lstparametrosM['TIP_INTERNO_EXTERNO'] = $TIP_INTERNO_EXTERNO;
            }
            if (strlen(rtrim($TIP_CLASIFICACION)) > 0) {
                $lstparametrosM['TIP_CLASIFICACION'] = $TIP_CLASIFICACION;
            }
            if (strlen(rtrim($DES_INTERES_PROYECTO)) > 0) {
                $lstparametrosM['DES_INTERES_PROYECTO'] = $DES_INTERES_PROYECTO;
            }
            if (strlen(rtrim($TIP_EVALUACION_IMPACTO)) > 0) {
                $lstparametrosM['TIP_EVALUACION_IMPACTO'] = $TIP_EVALUACION_IMPACTO;
            }
            if (strlen(rtrim($DES_ESTRATEGIA_PRINCIPAL)) > 0) {
                $lstparametrosM['DES_ESTRATEGIA_PRINCIPAL'] = $DES_ESTRATEGIA_PRINCIPAL;
            }
            if (strlen(rtrim($DES_OBSERVACION)) > 0) {
                $lstparametrosM['DES_OBSERVACION'] = $DES_OBSERVACION;
            }
            if (strlen(rtrim($EST_CONT_INTERESADO)) > 0) {
                $lstparametrosM['EST_CONT_INTERESADO'] = $EST_CONT_INTERESADO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ROL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PUESTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_LOCALIZACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_MAIL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_TELEFONO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_REQUERIMIENTOS_PRIMORDIALES'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_EXPECTATIVAS_PRINCIPALES'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_INFLUENCIA_POTENCIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_FASE_MAYOR_INTERES'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_INTERNO_EXTERNO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_CLASIFICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_INTERES_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_EVALUACION_IMPACTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ESTRATEGIA_PRINCIPAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERVACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CONT_INTERESADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_INTERESADOS_DAO->Update_CONT_INTERESADOS($DataSet_CONT_INTERESADOS, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[20][0];

            $mensaje = $procedure_parametrosMS[21][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_CONT_INTERESADOS = array();
            $Objeto_CONT_INTERESADOS_DAO = new CONT_INTERESADOS_DAO();
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
            $Objeto_CONT_INTERESADOS_DAO->Delete_CONT_INTERESADOS($DataSet_CONT_INTERESADOS, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_RECURSO_1 = array();
        $Objeto_IDE_RECURSO_DAO = new GEN_RECURSO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_RECURSO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_RECURSO_1', $DataSet_GEN_RECURSO_1);

        /* 					 */

        $DataSet_GEN_ROLES_1 = array();
        $Objeto_IDE_ROL_DAO = new GEN_ROLES_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ROL,DES_ROL";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ROL_DAO->SelCampos_GEN_ROLES($DataSet_GEN_ROLES_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ROLES_1', $DataSet_GEN_ROLES_1);

        /* 					 */

        $DataSet_GEN_CARGO_1 = array();
        $Objeto_IDE_PUESTO_DAO = new GEN_CARGO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CARGO,DES_CARGO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PUESTO_DAO->SelCampos_GEN_CARGO($DataSet_GEN_CARGO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_CARGO_1', $DataSet_GEN_CARGO_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_INFLUENCIA_POTENCIAL_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='69'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_INFLUENCIA_POTENCIAL_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_INTERNO_EXTERNO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='70'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_INTERNO_EXTERNO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_TIP_CLASIFICACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='71'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_CLASIFICACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_TIP_EVALUACION_IMPACTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='72'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_EVALUACION_IMPACTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_5 = array();
        $Objeto_EST_CONT_INTERESADO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CONT_INTERESADO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_5, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_5', $DataSet_GEN_TABLAS_5);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('PIDE_PROYECTO', $PIDE_PROYECTO);
        $lCollection->Add('PINTERVENCION', $PINTERVENCION);
        
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        $lCollection->Add('ProyectoExtractor', $ProyectoExtractor);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;