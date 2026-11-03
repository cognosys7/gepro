<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_LECCION_APRENDIDALN de la tabla PROY_LECCION_APRENDIDA
  //  Fecha           : lunes, 3 de junio de 2019 8:23:58
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_LECCION_APRENDIDADAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TIPO_RIESGODAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_LECCION_APRENDIDA";
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
        $IDE_PROYECTO = isset($_REQUEST['IDE_PROYECTO']) ? VerificarInputs($_REQUEST['IDE_PROYECTO']) : "";
        $IDE_FASE_COMPONENTE = isset($_REQUEST['IDE_FASE_COMPONENTE']) ? VerificarInputs($_REQUEST['IDE_FASE_COMPONENTE']) : "";
        $COD_LECCION_APRENDIDA = isset($_REQUEST['COD_LECCION_APRENDIDA']) ? VerificarInputs($_REQUEST['COD_LECCION_APRENDIDA']) : "";
        $TIP_LECCION = isset($_REQUEST['TIP_LECCION']) ? VerificarInputs($_REQUEST['TIP_LECCION']) : "";
        $IDE_TIPO_RIESGO = isset($_REQUEST['IDE_TIPO_RIESGO']) ? VerificarInputs($_REQUEST['IDE_TIPO_RIESGO']) : "";
        $DES_LECCION_APRENDIDA = isset($_REQUEST['DES_LECCION_APRENDIDA']) ? VerificarInputs($_REQUEST['DES_LECCION_APRENDIDA']) : "";
        $DES_RIESGO =  isset($_REQUEST['DES_RIESGO']) ? VerificarInputs($_REQUEST['DES_RIESGO']) : "";
        $TIP_IMPACTO_SITUACION = isset($_REQUEST['TIP_IMPACTO_SITUACION']) ? VerificarInputs($_REQUEST['TIP_IMPACTO_SITUACION']) : "";
        $DES_RECOMENDACION = isset($_REQUEST['DES_RECOMENDACION']) ? VerificarInputs($_REQUEST['DES_RECOMENDACION']) : "";
        $DES_ACCION_PROPUESTA = isset($_REQUEST['DES_ACCION_PROPUESTA']) ? VerificarInputs($_REQUEST['DES_ACCION_PROPUESTA']) : "";
        $FEC_LECCION = isset($_REQUEST['FEC_LECCION']) ? VerificarInputs($_REQUEST['FEC_LECCION']) : "";
        $EST_LECCION = isset($_REQUEST['EST_LECCION']) ? VerificarInputs($_REQUEST['EST_LECCION']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROY_LECCION_APRENDIDA';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_PROYECTO=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
       } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_PROY_LECCION_APRENDIDA_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_LECCION_APRENDIDA_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_INTERVENCION') {
                        $_POST['qtype'] = 'I.DES_INTERVENCION';
                    }
                    if ($_POST['qtype'] == 'DES_LECCION_APRENDIDA') {
                        $_POST['qtype'] = 'T.DES_LECCION_APRENDIDA';
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
            $ogridDAO->Count_PROY_LECCION_APRENDIDA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_LECCION_APRENDIDA;

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

            if (strlen($FEC_LECCION) > 0) {
                $FEC_LECCION = cambiafecha($FEC_LECCION);
            } else {
                $FEC_LECCION = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_LECCION_APRENDIDAM = array();
            $Objeto_PROY_LECCION_APRENDIDA_DAO = new PROY_LECCION_APRENDIDA_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($IDE_FASE_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_FASE_COMPONENTE'] = $IDE_FASE_COMPONENTE;
            }
            if (strlen(rtrim($COD_LECCION_APRENDIDA)) > 0) {
                $lstparametrosM['COD_LECCION_APRENDIDA'] = $COD_LECCION_APRENDIDA;
            }
            if (strlen(rtrim($TIP_LECCION)) > 0) {
                $lstparametrosM['TIP_LECCION'] = $TIP_LECCION;
            }
            if (strlen(rtrim($IDE_TIPO_RIESGO)) > 0) {
                $lstparametrosM['IDE_TIPO_RIESGO'] = $IDE_TIPO_RIESGO;
            }
            if (strlen(rtrim($DES_LECCION_APRENDIDA)) > 0) {
                $lstparametrosM['DES_LECCION_APRENDIDA'] = $DES_LECCION_APRENDIDA;
            }
            if (strlen(rtrim($DES_RIESGO)) > 0) {
                $lstparametrosM['DES_RIESGO'] = $DES_RIESGO;
            }
            if (strlen(rtrim($TIP_IMPACTO_SITUACION)) > 0) {
                $lstparametrosM['TIP_IMPACTO_SITUACION'] = $TIP_IMPACTO_SITUACION;
            }
            if (strlen(rtrim($DES_RECOMENDACION)) > 0) {
                $lstparametrosM['DES_RECOMENDACION'] = $DES_RECOMENDACION;
            }
            if (strlen(rtrim($DES_ACCION_PROPUESTA)) > 0) {
                $lstparametrosM['DES_ACCION_PROPUESTA'] = $DES_ACCION_PROPUESTA;
            }
            if (strlen(rtrim($FEC_LECCION)) > 0) {
                $lstparametrosM['FEC_LECCION'] = $FEC_LECCION;
            }
            if (strlen(rtrim($EST_LECCION)) > 0) {
                $lstparametrosM['EST_LECCION'] = $EST_LECCION;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_FASE_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_LECCION_APRENDIDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_LECCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_TIPO_RIESGO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_LECCION_APRENDIDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_RIESGO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_IMPACTO_SITUACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_RECOMENDACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACCION_PROPUESTA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_LECCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_LECCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_LECCION_APRENDIDA_DAO->Insert_PROY_LECCION_APRENDIDA($DataSet_PROY_LECCION_APRENDIDA, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_LECCION_APRENDIDA = array();
            $Objeto_PROY_LECCION_APRENDIDA_DAO = new PROY_LECCION_APRENDIDA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_LECCION_APRENDIDA_DAO->SelPk_PROY_LECCION_APRENDIDA($DataSet_PROY_LECCION_APRENDIDA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_LECCION_APRENDIDA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_LECCION_APRENDIDA

                $IDE_PROYECTO = $DataSet_PROY_LECCION_APRENDIDA[0]->IDE_PROYECTO;
                $IDE_FASE_COMPONENTE = $DataSet_PROY_LECCION_APRENDIDA[0]->IDE_FASE_COMPONENTE;
                $COD_LECCION_APRENDIDA = $DataSet_PROY_LECCION_APRENDIDA[0]->COD_LECCION_APRENDIDA;
                $TIP_LECCION = $DataSet_PROY_LECCION_APRENDIDA[0]->TIP_LECCION;
                $IDE_TIPO_RIESGO = $DataSet_PROY_LECCION_APRENDIDA[0]->IDE_TIPO_RIESGO;
                $DES_LECCION_APRENDIDA = $DataSet_PROY_LECCION_APRENDIDA[0]->DES_LECCION_APRENDIDA;
                $DES_RIESGO = $DataSet_PROY_LECCION_APRENDIDA[0]->DES_RIESGO;
                $TIP_IMPACTO_SITUACION = $DataSet_PROY_LECCION_APRENDIDA[0]->TIP_IMPACTO_SITUACION;
                $DES_RECOMENDACION = $DataSet_PROY_LECCION_APRENDIDA[0]->DES_RECOMENDACION;
                $DES_ACCION_PROPUESTA = $DataSet_PROY_LECCION_APRENDIDA[0]->DES_ACCION_PROPUESTA;
                $FEC_LECCION = $DataSet_PROY_LECCION_APRENDIDA[0]->FEC_LECCION;
                $EST_LECCION = $DataSet_PROY_LECCION_APRENDIDA[0]->EST_LECCION;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
            $lCollection->Add('IDE_FASE_COMPONENTE', $IDE_FASE_COMPONENTE);
            $lCollection->Add('COD_LECCION_APRENDIDA', $COD_LECCION_APRENDIDA);
            $lCollection->Add('TIP_LECCION', $TIP_LECCION);
            $lCollection->Add('IDE_TIPO_RIESGO', $IDE_TIPO_RIESGO);
            $lCollection->Add('DES_LECCION_APRENDIDA', $DES_LECCION_APRENDIDA);
            $lCollection->Add('DES_RIESGO', $DES_RIESGO);
            $lCollection->Add('TIP_IMPACTO_SITUACION', $TIP_IMPACTO_SITUACION);
            $lCollection->Add('DES_RECOMENDACION', $DES_RECOMENDACION);
            $lCollection->Add('DES_ACCION_PROPUESTA', $DES_ACCION_PROPUESTA);
            $lCollection->Add('FEC_LECCION', $FEC_LECCION);
            $lCollection->Add('EST_LECCION', $EST_LECCION);

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

            if (strlen($FEC_LECCION) > 0) {
                $FEC_LECCION = cambiafecha($FEC_LECCION);
            } else {
                $FEC_LECCION = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_LECCION_APRENDIDA = array();
            $Objeto_PROY_LECCION_APRENDIDA_DAO = new PROY_LECCION_APRENDIDA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($IDE_FASE_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_FASE_COMPONENTE'] = $IDE_FASE_COMPONENTE;
            }
            if (strlen(rtrim($COD_LECCION_APRENDIDA)) > 0) {
                $lstparametrosM['COD_LECCION_APRENDIDA'] = $COD_LECCION_APRENDIDA;
            }
            if (strlen(rtrim($TIP_LECCION)) > 0) {
                $lstparametrosM['TIP_LECCION'] = $TIP_LECCION;
            }
            if (strlen(rtrim($IDE_TIPO_RIESGO)) > 0) {
                $lstparametrosM['IDE_TIPO_RIESGO'] = $IDE_TIPO_RIESGO;
            }
            if (strlen(rtrim($DES_LECCION_APRENDIDA)) > 0) {
                $lstparametrosM['DES_LECCION_APRENDIDA'] = $DES_LECCION_APRENDIDA;
            }
            if (strlen(rtrim($DES_RIESGO)) > 0) {
                $lstparametrosM['DES_RIESGO'] = $DES_RIESGO;
            }
            if (strlen(rtrim($TIP_IMPACTO_SITUACION)) > 0) {
                $lstparametrosM['TIP_IMPACTO_SITUACION'] = $TIP_IMPACTO_SITUACION;
            }
            if (strlen(rtrim($DES_RECOMENDACION)) > 0) {
                $lstparametrosM['DES_RECOMENDACION'] = $DES_RECOMENDACION;
            }
            if (strlen(rtrim($DES_ACCION_PROPUESTA)) > 0) {
                $lstparametrosM['DES_ACCION_PROPUESTA'] = $DES_ACCION_PROPUESTA;
            }
            if (strlen(rtrim($FEC_LECCION)) > 0) {
                $lstparametrosM['FEC_LECCION'] = $FEC_LECCION;
            }
            if (strlen(rtrim($EST_LECCION)) > 0) {
                $lstparametrosM['EST_LECCION'] = $EST_LECCION;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_FASE_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_LECCION_APRENDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_LECCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_TIPO_RIESGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_LECCION_APRENDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_RIESGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_IMPACTO_SITUACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_RECOMENDACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACCION_PROPUESTA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_LECCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_LECCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_LECCION_APRENDIDA_DAO->Update_PROY_LECCION_APRENDIDA($DataSet_PROY_LECCION_APRENDIDA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[14][0];

            $mensaje = $procedure_parametrosMS[15][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_LECCION_APRENDIDA = array();
            $Objeto_PROY_LECCION_APRENDIDA_DAO = new PROY_LECCION_APRENDIDA_DAO();
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
            $Objeto_PROY_LECCION_APRENDIDA_DAO->Delete_PROY_LECCION_APRENDIDA($DataSet_PROY_LECCION_APRENDIDA, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_FASE_COMPONENTE_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = "AND NUM_NIVEL='3'  AND IDE_SECTOR=14 ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_FASE_COMPONENTE_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_LECCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='80'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_LECCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TIPO_RIESGO_1 = array();
        $Objeto_IDE_TIPO_RIESGO_DAO = new GEN_TIPO_RIESGO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_TIPO_RIESGO,DES_TIPO_RIESGO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_TIPO_RIESGO_DAO->SelCampos_GEN_TIPO_RIESGO($DataSet_GEN_TIPO_RIESGO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TIPO_RIESGO_1', $DataSet_GEN_TIPO_RIESGO_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_IMPACTO_SITUACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='81'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_IMPACTO_SITUACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_LECCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_LECCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

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