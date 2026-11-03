<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_DOCUMENTACIONLN de la tabla CONT_DOCUMENTACION
  //  Fecha           : lunes, 3 de junio de 2019 19:00:41
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/CONT_DOCUMENTACIONDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_MATRIZ_CONOCIMIENTO_PROCESODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/GEN_INTERVENCIONlni.php");

require_once("include/GEN_MATRIZ_CONOCIMIENTO_PROCESOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "CONT_DOCUMENTACION";
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
        $IDE_CONTRATO = isset($_REQUEST['IDE_CONTRATO']) ? VerificarInputs($_REQUEST['IDE_CONTRATO']) : "";
        $IDE_CONOC_PROC = isset($_REQUEST['IDE_CONOC_PROC']) ? VerificarInputs($_REQUEST['IDE_CONOC_PROC']) : "";
        $FEC_DOCUMENTO = isset($_REQUEST['FEC_DOCUMENTO']) ? VerificarInputs($_REQUEST['FEC_DOCUMENTO']) : "";
        $DES_DOCUMENTO = isset($_REQUEST['DES_DOCUMENTO']) ? VerificarInputs($_REQUEST['DES_DOCUMENTO']) : "";
        $EST_DOCUMENTO = isset($_REQUEST['EST_DOCUMENTO']) ? VerificarInputs($_REQUEST['EST_DOCUMENTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_CONT_DOCUMENTACION';

        if ( $PIDE>0 ){
            $ScriptFLX = $ScriptFLX." AND T.IDE_CONTRATO=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
            $Data3 = ProyectoContrato_Datos2($PIDE,$PIDE2);
            $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
       
            $Data4 = ProyectoActividad_Datos($PIDE);
            $lCollection->Add('VIDE_INTERVENCION', $Data4['IDE_INTERVENCION'] ) ;
        } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_CONT_DOCUMENTACION_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new CONT_DOCUMENTACION_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'CONOC_PROC') {
                        $_POST['qtype'] = 'MGC.DES_CRUCE_CONOC_PROC';
                    }
                    if ($_POST['qtype'] == 'FEC_DOCUMENTO') {
                        $_POST['qtype'] = 'T.FEC_DOCUMENTO';
                    }
                    if ($_POST['qtype'] == 'DES_DOCUMENTO') {
                        $_POST['qtype'] = 'T.DES_DOCUMENTO';
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
            $ogridDAO->Count_CONT_DOCUMENTACION($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONT_DOCUM;

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

            if (strlen($FEC_DOCUMENTO) > 0) {
                $FEC_DOCUMENTO = cambiafecha($FEC_DOCUMENTO);
            } else {
                $FEC_DOCUMENTO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_CONT_DOCUMENTACIONM = array();
            $Objeto_CONT_DOCUMENTACION_DAO = new CONT_DOCUMENTACION_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_CONOC_PROC)) > 0) {
                $lstparametrosM['IDE_CONOC_PROC'] = $IDE_CONOC_PROC;
            }
            if (strlen(rtrim($FEC_DOCUMENTO)) > 0) {
                $lstparametrosM['FEC_DOCUMENTO'] = $FEC_DOCUMENTO;
            }
            if (strlen(rtrim($DES_DOCUMENTO)) > 0) {
                $lstparametrosM['DES_DOCUMENTO'] = $DES_DOCUMENTO;
            }
            if (strlen(rtrim($EST_DOCUMENTO)) > 0) {
                $lstparametrosM['EST_DOCUMENTO'] = $EST_DOCUMENTO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CONOC_PROC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_DOCUMENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DOCUMENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_DOCUMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_DOCUMENTACION_DAO->Insert_CONT_DOCUMENTACION($DataSet_CONT_DOCUMENTACION, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[6][0];

            $mensaje = $procedure_parametrosMS[7][0];

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
            $DataSet_CONT_DOCUMENTACION = array();
            $Objeto_CONT_DOCUMENTACION_DAO = new CONT_DOCUMENTACION_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_CONT_DOCUMENTACION_DAO->SelPk_CONT_DOCUMENTACION($DataSet_CONT_DOCUMENTACION, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_CONT_DOCUMENTACION) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_CONT_DOCUMENTACION

                $IDE_CONTRATO = $DataSet_CONT_DOCUMENTACION[0]->IDE_CONTRATO;
                $IDE_CONOC_PROC = $DataSet_CONT_DOCUMENTACION[0]->IDE_CONOC_PROC;
                $FEC_DOCUMENTO = $DataSet_CONT_DOCUMENTACION[0]->FEC_DOCUMENTO;
                $DES_DOCUMENTO = $DataSet_CONT_DOCUMENTACION[0]->DES_DOCUMENTO;
                $EST_DOCUMENTO = $DataSet_CONT_DOCUMENTACION[0]->EST_DOCUMENTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONTRATO', $IDE_CONTRATO);
            $lCollection->Add('IDE_CONOC_PROC', $IDE_CONOC_PROC);
            $lCollection->Add('FEC_DOCUMENTO', $FEC_DOCUMENTO);
            $lCollection->Add('DES_DOCUMENTO', $DES_DOCUMENTO);
            $lCollection->Add('EST_DOCUMENTO', $EST_DOCUMENTO);

            
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data1 = MatrizConocimiento_Datos($IDE_CONOC_PROC);
            $Bdescripcion = $Data1['DES_CRUCE_CONOC_PROC']  ;
            $lCollection->Add('DES_TIPO_DOCUMENTO', $Bdescripcion);
            /* EDGAR */
            
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_DOCUMENTO) > 0) {
                $FEC_DOCUMENTO = cambiafecha($FEC_DOCUMENTO);
            } else {
                $FEC_DOCUMENTO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_CONT_DOCUMENTACION = array();
            $Objeto_CONT_DOCUMENTACION_DAO = new CONT_DOCUMENTACION_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONTRATO)) > 0) {
                $lstparametrosM['IDE_CONTRATO'] = $IDE_CONTRATO;
            }
            if (strlen(rtrim($IDE_CONOC_PROC)) > 0) {
                $lstparametrosM['IDE_CONOC_PROC'] = $IDE_CONOC_PROC;
            }
            if (strlen(rtrim($FEC_DOCUMENTO)) > 0) {
                $lstparametrosM['FEC_DOCUMENTO'] = $FEC_DOCUMENTO;
            }
            if (strlen(rtrim($DES_DOCUMENTO)) > 0) {
                $lstparametrosM['DES_DOCUMENTO'] = $DES_DOCUMENTO;
            }
            if (strlen(rtrim($EST_DOCUMENTO)) > 0) {
                $lstparametrosM['EST_DOCUMENTO'] = $EST_DOCUMENTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONOC_PROC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_DOCUMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DOCUMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_DOCUMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_DOCUMENTACION_DAO->Update_CONT_DOCUMENTACION($DataSet_CONT_DOCUMENTACION, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_CONT_DOCUMENTACION = array();
            $Objeto_CONT_DOCUMENTACION_DAO = new CONT_DOCUMENTACION_DAO();
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
            $Objeto_CONT_DOCUMENTACION_DAO->Delete_CONT_DOCUMENTACION($DataSet_CONT_DOCUMENTACION, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO_1 = array();
        $Objeto_IDE_CONOC_PROC_DAO = new GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONOC_PROC,DES_CRUCE_CONOC_PROC";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_CONOC_PROC_DAO->SelCampos_GEN_MATRIZ_CONOCIMIENTO_PROCESO($DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO_1', $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO_1);

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_DOCUMENTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_DOCUMENTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

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