<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
  //  Empresa	    	  : ACTIVOS MINEROS S.A.C.
  //  Autores         : Ing. julio C�sar Meza Yangali
  //  Prop�sito       : PROY_CONT_AMPLIACIONln de la tabla PROY_CONT_AMPLIACION
  //  Fecha           : martes, 11 de mayo de 2021 15:21:44
  //  Desde el Modelo : PDM - Modelo F�sico de Datos - SGPAM
  //  Modificado      : martes, 11 de mayo de 2021 15:21:44
  //
  //***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_CONT_AMPLIACIONDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR - invoca a la libreria de funciones generales */
require_once("include/LNinclude.php");
require_once("include/PROY_CONT_AMPLIACIONlni.php");
require_once("include/PROYECTO_ACTIVIDADlni.php");

//// busqueda lni
require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/GEN_INTERVENCIONlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_CONT_AMPLIACION";
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

        $PIDE_PROYECTO = isset($_REQUEST['PIDE_PROYECTO']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO']) : ""; // AÑADIDO POR JULIO MEZA 
        $lCollection->Add('VIDE_PROYECTO', $PIDE_PROYECTO);


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
        $NUM_ORDEN = isset($_REQUEST['NUM_ORDEN']) ? VerificarInputs($_REQUEST['NUM_ORDEN']) : "";
        $IDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) : "";
        $TIP_AMPLIACION = isset($_REQUEST['TIP_AMPLIACION']) ? VerificarInputs($_REQUEST['TIP_AMPLIACION']) : "";
        $NUM_AMPLIACION = isset($_REQUEST['NUM_AMPLIACION']) ? VerificarInputs($_REQUEST['NUM_AMPLIACION']) : "";
        $FEC_INICIO_AMP = isset($_REQUEST['FEC_INICIO_AMP']) ? VerificarInputs($_REQUEST['FEC_INICIO_AMP']) : "";
        $CAN_DIAS_CALENDARIO = isset($_REQUEST['CAN_DIAS_CALENDARIO']) ? VerificarInputs($_REQUEST['CAN_DIAS_CALENDARIO']) : "";
        $FEC_TERMINO_AMP = isset($_REQUEST['FEC_TERMINO_AMP']) ? VerificarInputs($_REQUEST['FEC_TERMINO_AMP']) : "";
        $COD_RESOLUCION = isset($_REQUEST['COD_RESOLUCION']) ? VerificarInputs($_REQUEST['COD_RESOLUCION']) : "";
        $EST_CONT_AMPLIACION = isset($_REQUEST['EST_CONT_AMPLIACION']) ? VerificarInputs($_REQUEST['EST_CONT_AMPLIACION']) : "";
        //$USER_UPDATE = isset($_REQUEST['USER_UPDATE']) ? VerificarInputs($_REQUEST['USER_UPDATE']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = " "; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        ////// GRILLA PREDETERMINADA
        $TipoGrilla = 'SelGrd_PROY_CONT_AMPLIACION';
        $Recursiva_hide = 'true';
        $Tabla_DatosPadre = '';

        ////// SI TIENE UN REGISTRO PADRE, ENTONCES SE DIBUJA CABECERA - NOTA: REVISAR EL ALIAS DEL CAMPO DE LA TABLA PADRE
        if ($PIDE > 0) {
            
            $ScriptFLX = $ScriptFLX." AND T.IDE_PROYECTO_ACTIVIDAD = $PIDE";

            //$Tabla_DatosPadre = Tabla_PROYECTO_ACTIVIDAD_Datos($PIDE);
        }


        //echo $PIDE;  echo $ScriptFLX;         exit;

        ////// SI ES UN REGISTRO RECURSIVO
        $Recursiva = 0;


        ////// PASE DE PARAMETROS DE GRILLA        
        $lCollection->Add('Tabla_DatosPadre', $Tabla_DatosPadre);
        $lCollection->Add('Recursiva_hide', $Recursiva_hide);

        /* EDGAR */

        /* JULIO MEZA - 11.05.2021 */ 

        $Data2 = ProyectoActividad_Datos($PIDE);
        $PIDE_PROYECTO = $Data2['IDE_PROYECTO'];
        $lCollection->Add('VIDE_PROYECTO', $PIDE_PROYECTO );
        
        $Data3 = ProyectoContrato_Datos2($PIDE,$PIDE_PROYECTO);
        $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
        
        
        $Data21 = PROY_CONT_AMPLIACION_Datos_Contrato ( $PIDE  , '3' ); // '3' = '2. PLAZO CONTRACTUAL'
        $eIDE_CONT_AMPLIACION_tipo = strlen(rtrim($Data21['BIDE'])) ;
        $filtro_IDE_CONT_AMPLIACION_tipo = ( $eIDE_CONT_AMPLIACION_tipo > 0 ? " and COD_ITEM not in('3') " : "" ) ;
       // $lCollection->Add('VIDE_INTERVENCION', $PIDE_INTERVENCION ) ;

       /* JULIO MEZA */
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_CONT_AMPLIACION_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'TIP_AMPLIACION') {
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
            $ogridDAO->Count_PROY_CONT_AMPLIACION($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONT_AMPLIACION;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_CONT_AMPLIACION', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
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

            if (strlen($FEC_INICIO_AMP) > 0) {
                $FEC_INICIO_AMP = cambiafecha($FEC_INICIO_AMP);
            } else {
                $FEC_INICIO_AMP = "";
            }
            if (strlen($FEC_TERMINO_AMP) > 0) {
                $FEC_TERMINO_AMP = cambiafecha($FEC_TERMINO_AMP);
            } else {
                $FEC_TERMINO_AMP = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_CONT_AMPLIACIONM = array();
            $Objeto_PROY_CONT_AMPLIACION_DAO = new PROY_CONT_AMPLIACION_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($NUM_ORDEN)) > 0) {
                $lstparametrosM['NUM_ORDEN'] = $NUM_ORDEN;
            }
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($TIP_AMPLIACION)) > 0) {
                $lstparametrosM['TIP_AMPLIACION'] = $TIP_AMPLIACION;
            }
            if (strlen(rtrim($NUM_AMPLIACION)) > 0) {
                $lstparametrosM['NUM_AMPLIACION'] = $NUM_AMPLIACION;
            }
            if (strlen(rtrim($FEC_INICIO_AMP)) > 0) {
                $lstparametrosM['FEC_INICIO_AMP'] = $FEC_INICIO_AMP;
            }
            if (strlen(rtrim($CAN_DIAS_CALENDARIO)) > 0) {
                $lstparametrosM['CAN_DIAS_CALENDARIO'] = $CAN_DIAS_CALENDARIO;
            }
            if (strlen(rtrim($FEC_TERMINO_AMP)) > 0) {
                $lstparametrosM['FEC_TERMINO_AMP'] = $FEC_TERMINO_AMP;
            }
            if (strlen(rtrim($COD_RESOLUCION)) > 0) {
                $lstparametrosM['COD_RESOLUCION'] = $COD_RESOLUCION;
            }
            if (strlen(rtrim($EST_CONT_AMPLIACION)) > 0) {
                $lstparametrosM['EST_CONT_AMPLIACION'] = $EST_CONT_AMPLIACION;
            }
            /*
            if (strlen(rtrim($USER_UPDATE)) > 0) {
                $lstparametrosM['USER_UPDATE'] = $USER_UPDATE;
            }
            */
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['NUM_ORDEN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_AMPLIACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_AMPLIACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO_AMP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CAN_DIAS_CALENDARIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO_AMP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_RESOLUCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CONT_AMPLIACION'], SQLSRV_PARAM_IN)
               // array(&$lstparametrosM['USER_UPDATE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_CONT_AMPLIACION_DAO->Insert_PROY_CONT_AMPLIACION($DataSet_PROY_CONT_AMPLIACION, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_CONT_AMPLIACION = array();
            $Objeto_PROY_CONT_AMPLIACION_DAO = new PROY_CONT_AMPLIACION_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_CONT_AMPLIACION_DAO->SelPk_PROY_CONT_AMPLIACION($DataSet_PROY_CONT_AMPLIACION, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_CONT_AMPLIACION) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_CONT_AMPLIACION

                $NUM_ORDEN = $DataSet_PROY_CONT_AMPLIACION[0]->NUM_ORDEN;
                $IDE_PROYECTO_ACTIVIDAD = $DataSet_PROY_CONT_AMPLIACION[0]->IDE_PROYECTO_ACTIVIDAD;
                $TIP_AMPLIACION = $DataSet_PROY_CONT_AMPLIACION[0]->TIP_AMPLIACION;
                $NUM_AMPLIACION = $DataSet_PROY_CONT_AMPLIACION[0]->NUM_AMPLIACION;
                $FEC_INICIO_AMP = $DataSet_PROY_CONT_AMPLIACION[0]->FEC_INICIO_AMP;
                $CAN_DIAS_CALENDARIO = $DataSet_PROY_CONT_AMPLIACION[0]->CAN_DIAS_CALENDARIO;
                $FEC_TERMINO_AMP = $DataSet_PROY_CONT_AMPLIACION[0]->FEC_TERMINO_AMP;
                $COD_RESOLUCION = $DataSet_PROY_CONT_AMPLIACION[0]->COD_RESOLUCION;
                $EST_CONT_AMPLIACION = $DataSet_PROY_CONT_AMPLIACION[0]->EST_CONT_AMPLIACION;
              //  $USER_UPDATE = $DataSet_PROY_CONT_AMPLIACION[0]->USER_UPDATE;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('NUM_ORDEN', $NUM_ORDEN);
            $lCollection->Add('IDE_PROYECTO_ACTIVIDAD', $IDE_PROYECTO_ACTIVIDAD);
            $lCollection->Add('TIP_AMPLIACION', $TIP_AMPLIACION);
            $lCollection->Add('NUM_AMPLIACION', $NUM_AMPLIACION);
            $lCollection->Add('FEC_INICIO_AMP', $FEC_INICIO_AMP);
            $lCollection->Add('CAN_DIAS_CALENDARIO', $CAN_DIAS_CALENDARIO);
            $lCollection->Add('FEC_TERMINO_AMP', $FEC_TERMINO_AMP);
            $lCollection->Add('COD_RESOLUCION', $COD_RESOLUCION);
            $lCollection->Add('EST_CONT_AMPLIACION', $EST_CONT_AMPLIACION);
         //   $lCollection->Add('USER_UPDATE', $USER_UPDATE);

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //// ajuste al filtro, sino no aprece el TIP_AMPLIACION
            $filtro_IDE_CONT_AMPLIACION_tipo = ( $TIP_AMPLIACION=='3' ? "" : $filtro_IDE_CONT_AMPLIACION_tipo ) ; 
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_INICIO_AMP) > 0) {
                $FEC_INICIO_AMP = cambiafecha($FEC_INICIO_AMP);
            } else {
                $FEC_INICIO_AMP = "";
            }
            if (strlen($FEC_TERMINO_AMP) > 0) {
                $FEC_TERMINO_AMP = cambiafecha($FEC_TERMINO_AMP);
            } else {
                $FEC_TERMINO_AMP = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_CONT_AMPLIACION = array();
            $Objeto_PROY_CONT_AMPLIACION_DAO = new PROY_CONT_AMPLIACION_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($NUM_ORDEN)) > 0) {
                $lstparametrosM['NUM_ORDEN'] = $NUM_ORDEN;
            }
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($TIP_AMPLIACION)) > 0) {
                $lstparametrosM['TIP_AMPLIACION'] = $TIP_AMPLIACION;
            }
            if (strlen(rtrim($NUM_AMPLIACION)) > 0) {
                $lstparametrosM['NUM_AMPLIACION'] = $NUM_AMPLIACION;
            }
            if (strlen(rtrim($FEC_INICIO_AMP)) > 0) {
                $lstparametrosM['FEC_INICIO_AMP'] = $FEC_INICIO_AMP;
            }
            if (strlen(rtrim($CAN_DIAS_CALENDARIO)) > 0) {
                $lstparametrosM['CAN_DIAS_CALENDARIO'] = $CAN_DIAS_CALENDARIO;
            }
            if (strlen(rtrim($FEC_TERMINO_AMP)) > 0) {
                $lstparametrosM['FEC_TERMINO_AMP'] = $FEC_TERMINO_AMP;
            }
            if (strlen(rtrim($COD_RESOLUCION)) > 0) {
                $lstparametrosM['COD_RESOLUCION'] = $COD_RESOLUCION;
            }
            if (strlen(rtrim($EST_CONT_AMPLIACION)) > 0) {
                $lstparametrosM['EST_CONT_AMPLIACION'] = $EST_CONT_AMPLIACION;
            }
            /*
            if (strlen(rtrim($USER_UPDATE)) > 0) {
                $lstparametrosM['USER_UPDATE'] = $USER_UPDATE;
            }
            */
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_ORDEN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_AMPLIACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_AMPLIACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO_AMP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CAN_DIAS_CALENDARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO_AMP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_RESOLUCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CONT_AMPLIACION'], SQLSRV_PARAM_IN)
               // , array(&$lstparametrosM['USER_UPDATE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_CONT_AMPLIACION_DAO->Update_PROY_CONT_AMPLIACION($DataSet_PROY_CONT_AMPLIACION, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[11][0];

            $mensaje = $procedure_parametrosMS[12][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_CONT_AMPLIACION = array();
            $Objeto_PROY_CONT_AMPLIACION_DAO = new PROY_CONT_AMPLIACION_DAO();
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
            $Objeto_PROY_CONT_AMPLIACION_DAO->Delete_PROY_CONT_AMPLIACION($DataSet_PROY_CONT_AMPLIACION, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_AMPLIACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='103'" . $filtro_IDE_CONT_AMPLIACION_tipo;

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_AMPLIACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_CONT_AMPLIACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CONT_AMPLIACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */




        /* EDGAR */
        $lCollection->Add('crud', crud($usuario, $PermisosPerfil, $Pedido, $SeleccionarID));
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;
