<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : PROY_GESTION_SOCIALLN de la tabla PROY_GESTION_SOCIAL
  //  Fecha           : domingo, 26 de mayo de 2019 4:35:47
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_GESTION_SOCIALDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");
require_once("include/GEN_COMUNIDADlni.php");
require_once("include/GEN_UBIGEOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_GESTION_SOCIAL";
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
        $IDE_COMUNIDAD = isset($_REQUEST['IDE_COMUNIDAD']) ? VerificarInputs($_REQUEST['IDE_COMUNIDAD']) : "";
        $IDE_ETAPA_CONTRATO = isset($_REQUEST['IDE_ETAPA_CONTRATO']) ? VerificarInputs($_REQUEST['IDE_ETAPA_CONTRATO']) : "";
        $NUM_BENEFICIARIOS = isset($_REQUEST['NUM_BENEFICIARIOS']) ? VerificarInputs($_REQUEST['NUM_BENEFICIARIOS']) : "";
        $TIP_UNIDAD_BENEFICIARIO = isset($_REQUEST['TIP_UNIDAD_BENEFICIARIO']) ? VerificarInputs($_REQUEST['TIP_UNIDAD_BENEFICIARIO']) : "";
        $DES_UNIDAD_BENEFICIARIO = isset($_REQUEST['DES_UNIDAD_BENEFICIARIO']) ? VerificarInputs($_REQUEST['DES_UNIDAD_BENEFICIARIO']) : "";
        $EST_MATRIZ_RC = isset($_REQUEST['EST_MATRIZ_RC']) ? VerificarInputs($_REQUEST['EST_MATRIZ_RC']) : "";
        $EST_ACTA_APROBACION = isset($_REQUEST['EST_ACTA_APROBACION']) ? VerificarInputs($_REQUEST['EST_ACTA_APROBACION']) : "";
        $EST_GESTION_SOCIAL = isset($_REQUEST['EST_GESTION_SOCIAL']) ? VerificarInputs($_REQUEST['EST_GESTION_SOCIAL']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROY_GESTION_SOCIAL';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_PROYECTO=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
//             $Data = GenTablas_Datos1($PIDE);
//             $lCollection->Add('VDES_ITEM', $Data['DES_ITEM'] );
//             $lCollection->Add('VDES_ABREVIATURA', $Data['DES_ABREVIATURA'] );
//             $lCollection->Add('VCOD_TABLA', $Data['COD_TABLA'] );
       } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_PROY_GESTION_SOCIAL_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_GESTION_SOCIAL_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_LARGA_PROYECTO') {
                        $_POST['qtype'] = 'P.DES_LARGA_PROYECTO';
                    }
                    if ($_POST['qtype'] == 'DES_COMUNIDAD') {
                        $_POST['qtype'] = 'CP.DES_COMUNIDAD';
                    }
                    if ($_POST['qtype'] == 'DES_INTERVENCION') {
                        $_POST['qtype'] = 'I.DES_INTERVENCION';
                    }
                    if ($_POST['qtype'] == 'TipoBeneficiario') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'DES_UNIDAD_BENEFICIARIO') {
                        $_POST['qtype'] = 'T.DES_UNIDAD_BENEFICIARIO';
                    }
                    if ($_POST['qtype'] == 'EST_MATRIZ_RC') {
                        $_POST['qtype'] = 'T3.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'EST_ACTA_APROBACION') {
                        $_POST['qtype'] = 'T4.DES_ITEM';
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
            $ogridDAO->Count_PROY_GESTION_SOCIAL($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_GESTION_SOCIAL;

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

            $DataSet_PROY_GESTION_SOCIALM = array();
            $Objeto_PROY_GESTION_SOCIAL_DAO = new PROY_GESTION_SOCIAL_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($IDE_COMUNIDAD)) > 0) {
                $lstparametrosM['IDE_COMUNIDAD'] = $IDE_COMUNIDAD;
            }
            if (strlen(rtrim($IDE_ETAPA_CONTRATO)) > 0) {
                $lstparametrosM['IDE_ETAPA_CONTRATO'] = $IDE_ETAPA_CONTRATO;
            }
            if (strlen(rtrim($NUM_BENEFICIARIOS)) > 0) {
                $lstparametrosM['NUM_BENEFICIARIOS'] = $NUM_BENEFICIARIOS;
            }
            if (strlen(rtrim($TIP_UNIDAD_BENEFICIARIO)) > 0) {
                $lstparametrosM['TIP_UNIDAD_BENEFICIARIO'] = $TIP_UNIDAD_BENEFICIARIO;
            }
            if (strlen(rtrim($DES_UNIDAD_BENEFICIARIO)) > 0) {
                $lstparametrosM['DES_UNIDAD_BENEFICIARIO'] = $DES_UNIDAD_BENEFICIARIO;
            }
            if (strlen(rtrim($EST_MATRIZ_RC)) > 0) {
                $lstparametrosM['EST_MATRIZ_RC'] = $EST_MATRIZ_RC;
            }
            if (strlen(rtrim($EST_ACTA_APROBACION)) > 0) {
                $lstparametrosM['EST_ACTA_APROBACION'] = $EST_ACTA_APROBACION;
            }
            if (strlen(rtrim($EST_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['EST_GESTION_SOCIAL'] = $EST_GESTION_SOCIAL;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_COMUNIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ETAPA_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_BENEFICIARIOS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_UNIDAD_BENEFICIARIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_UNIDAD_BENEFICIARIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_MATRIZ_RC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ACTA_APROBACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_GESTION_SOCIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_GESTION_SOCIAL_DAO->Insert_PROY_GESTION_SOCIAL($DataSet_PROY_GESTION_SOCIAL, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[10][0];

            $mensaje = $procedure_parametrosMS[11][0];

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
            $DataSet_PROY_GESTION_SOCIAL = array();
            $Objeto_PROY_GESTION_SOCIAL_DAO = new PROY_GESTION_SOCIAL_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_GESTION_SOCIAL_DAO->SelPk_PROY_GESTION_SOCIAL($DataSet_PROY_GESTION_SOCIAL, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_GESTION_SOCIAL) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_GESTION_SOCIAL

                $IDE_PROYECTO = $DataSet_PROY_GESTION_SOCIAL[0]->IDE_PROYECTO;
                $IDE_COMUNIDAD = $DataSet_PROY_GESTION_SOCIAL[0]->IDE_COMUNIDAD;
                $IDE_ETAPA_CONTRATO = $DataSet_PROY_GESTION_SOCIAL[0]->IDE_ETAPA_CONTRATO;
                $NUM_BENEFICIARIOS = $DataSet_PROY_GESTION_SOCIAL[0]->NUM_BENEFICIARIOS;
                $TIP_UNIDAD_BENEFICIARIO = $DataSet_PROY_GESTION_SOCIAL[0]->TIP_UNIDAD_BENEFICIARIO;
                $DES_UNIDAD_BENEFICIARIO = $DataSet_PROY_GESTION_SOCIAL[0]->DES_UNIDAD_BENEFICIARIO;
                $EST_MATRIZ_RC = $DataSet_PROY_GESTION_SOCIAL[0]->EST_MATRIZ_RC;
                $EST_ACTA_APROBACION = $DataSet_PROY_GESTION_SOCIAL[0]->EST_ACTA_APROBACION;
                $EST_GESTION_SOCIAL = $DataSet_PROY_GESTION_SOCIAL[0]->EST_GESTION_SOCIAL;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
            $lCollection->Add('IDE_COMUNIDAD', $IDE_COMUNIDAD);
            $lCollection->Add('IDE_ETAPA_CONTRATO', $IDE_ETAPA_CONTRATO);
            $lCollection->Add('NUM_BENEFICIARIOS', $NUM_BENEFICIARIOS);
            $lCollection->Add('TIP_UNIDAD_BENEFICIARIO', $TIP_UNIDAD_BENEFICIARIO);
            $lCollection->Add('DES_UNIDAD_BENEFICIARIO', $DES_UNIDAD_BENEFICIARIO);
            $lCollection->Add('EST_MATRIZ_RC', $EST_MATRIZ_RC);
            $lCollection->Add('EST_ACTA_APROBACION', $EST_ACTA_APROBACION);
            $lCollection->Add('EST_GESTION_SOCIAL', $EST_GESTION_SOCIAL);

            

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data = Comunidad_Datos($IDE_COMUNIDAD);
            $Data1 = UBIGEO_Datos($Data['COD_UBIGEO']);
            
            $Bdescripcion = $Data['DES_COMUNIDAD'] .' ( '. $Data1['DES_DEPARTAMENTO'] .' - '. $Data1['DES_PROVINCIA'] .' - '. $Data1['DES_DISTRITO'] . ' )' ;
            
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
            $DataSet_PROY_GESTION_SOCIAL = array();
            $Objeto_PROY_GESTION_SOCIAL_DAO = new PROY_GESTION_SOCIAL_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($IDE_COMUNIDAD)) > 0) {
                $lstparametrosM['IDE_COMUNIDAD'] = $IDE_COMUNIDAD;
            }
            if (strlen(rtrim($IDE_ETAPA_CONTRATO)) > 0) {
                $lstparametrosM['IDE_ETAPA_CONTRATO'] = $IDE_ETAPA_CONTRATO;
            }
            if (strlen(rtrim($NUM_BENEFICIARIOS)) > 0) {
                $lstparametrosM['NUM_BENEFICIARIOS'] = $NUM_BENEFICIARIOS;
            }
            if (strlen(rtrim($TIP_UNIDAD_BENEFICIARIO)) > 0) {
                $lstparametrosM['TIP_UNIDAD_BENEFICIARIO'] = $TIP_UNIDAD_BENEFICIARIO;
            }
            if (strlen(rtrim($DES_UNIDAD_BENEFICIARIO)) > 0) {
                $lstparametrosM['DES_UNIDAD_BENEFICIARIO'] = $DES_UNIDAD_BENEFICIARIO;
            }
            if (strlen(rtrim($EST_MATRIZ_RC)) > 0) {
                $lstparametrosM['EST_MATRIZ_RC'] = $EST_MATRIZ_RC;
            }
            if (strlen(rtrim($EST_ACTA_APROBACION)) > 0) {
                $lstparametrosM['EST_ACTA_APROBACION'] = $EST_ACTA_APROBACION;
            }
            if (strlen(rtrim($EST_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['EST_GESTION_SOCIAL'] = $EST_GESTION_SOCIAL;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_COMUNIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ETAPA_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_BENEFICIARIOS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_UNIDAD_BENEFICIARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_UNIDAD_BENEFICIARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_MATRIZ_RC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ACTA_APROBACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_GESTION_SOCIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_GESTION_SOCIAL_DAO->Update_PROY_GESTION_SOCIAL($DataSet_PROY_GESTION_SOCIAL, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[11][0];

            $mensaje = $procedure_parametrosMS[12][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_GESTION_SOCIAL = array();
            $Objeto_PROY_GESTION_SOCIAL_DAO = new PROY_GESTION_SOCIAL_DAO();
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
            $Objeto_PROY_GESTION_SOCIAL_DAO->Delete_PROY_GESTION_SOCIAL($DataSet_PROY_GESTION_SOCIAL, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_ETAPA_CONTRATO_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = "AND NUM_NIVEL='3' AND IDE_SECTOR='14' ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ETAPA_CONTRATO_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_UNIDAD_BENEFICIARIO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='73'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_UNIDAD_BENEFICIARIO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_MATRIZ_RC_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='98'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_MATRIZ_RC_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_ACTA_APROBACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='98'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ACTA_APROBACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_EST_GESTION_SOCIAL_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_GESTION_SOCIAL_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

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