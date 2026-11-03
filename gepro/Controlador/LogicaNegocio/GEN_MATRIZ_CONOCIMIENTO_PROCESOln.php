<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_MATRIZ_CONOCIMIENTO_PROCESOLN de la tabla GEN_MATRIZ_CONOCIMIENTO_PROCESO
  //  Fecha           : lunes, 3 de junio de 2019 9:04:59
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_MATRIZ_CONOCIMIENTO_PROCESODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/GEN_MATRIZ_CONOCIMIENTO_PROCESOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_MATRIZ_CONOCIMIENTO_PROCESO";
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
        $TIP_AREA_CONOCIMIENTO = isset($_REQUEST['TIP_AREA_CONOCIMIENTO']) ? VerificarInputs($_REQUEST['TIP_AREA_CONOCIMIENTO']) : "";
        $TIP_GRUPO_PROCESO = isset($_REQUEST['TIP_GRUPO_PROCESO']) ? VerificarInputs($_REQUEST['TIP_GRUPO_PROCESO']) : "";
        $DES_CRUCE_CONOC_PROC = isset($_REQUEST['DES_CRUCE_CONOC_PROC']) ? VerificarInputs($_REQUEST['DES_CRUCE_CONOC_PROC']) : "";
        $DES_ABREVIATURA = isset($_REQUEST['DES_ABREVIATURA']) ? VerificarInputs($_REQUEST['DES_ABREVIATURA']) : "";
        $COD_ORDEN = isset($_REQUEST['COD_ORDEN']) ? VerificarInputs($_REQUEST['COD_ORDEN']) : "";
        $EST_CONOC_PROC = isset($_REQUEST['EST_CONOC_PROC']) ? VerificarInputs($_REQUEST['EST_CONOC_PROC']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_MATRIZ_CONOCIMIENTO_PROCESO';

//       if ( $PIDE>0 ){
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
//             $Data = GenTablas_Datos1($PIDE);
//             $lCollection->Add('VDES_ITEM', $Data['DES_ITEM'] );
//             $lCollection->Add('VDES_ABREVIATURA', $Data['DES_ABREVIATURA'] );
//             $lCollection->Add('VCOD_TABLA', $Data['COD_TABLA'] );
//       } else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_GEN_MATRIZ_CONOCIMIENTO_PROCESO_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'TIP_AREA_CONOCIMIENTO') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'TIP_GRUPO_PROCESO') {
                        $_POST['qtype'] = 'T3.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'DES_CRUCE_CONOC_PROC') {
                        $_POST['qtype'] = 'T.DES_CRUCE_CONOC_PROC';
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
            $ogridDAO->Count_GEN_MATRIZ_CONOCIMIENTO_PROCESO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONOC_PROC;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data1 = MatrizConocimiento_Datos($PIDEbuscado);
            $Bdescripcion = $Data1['DES_CRUCE_CONOC_PROC']  ;
            $lCollection->Add('BIDE', $Data1['BIDE']);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESOM = array();
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO = new GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($TIP_AREA_CONOCIMIENTO)) > 0) {
                $lstparametrosM['TIP_AREA_CONOCIMIENTO'] = $TIP_AREA_CONOCIMIENTO;
            }
            if (strlen(rtrim($TIP_GRUPO_PROCESO)) > 0) {
                $lstparametrosM['TIP_GRUPO_PROCESO'] = $TIP_GRUPO_PROCESO;
            }
            if (strlen(rtrim($DES_CRUCE_CONOC_PROC)) > 0) {
                $lstparametrosM['DES_CRUCE_CONOC_PROC'] = $DES_CRUCE_CONOC_PROC;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($COD_ORDEN)) > 0) {
                $lstparametrosM['COD_ORDEN'] = $COD_ORDEN;
            }
            if (strlen(rtrim($EST_CONOC_PROC)) > 0) {
                $lstparametrosM['EST_CONOC_PROC'] = $EST_CONOC_PROC;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['TIP_AREA_CONOCIMIENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_GRUPO_PROCESO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CRUCE_CONOC_PROC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ORDEN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CONOC_PROC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO->Insert_GEN_MATRIZ_CONOCIMIENTO_PROCESO($DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

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
            $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO = array();
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO = new GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO->SelPk_GEN_MATRIZ_CONOCIMIENTO_PROCESO($DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO

                $TIP_AREA_CONOCIMIENTO = $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO[0]->TIP_AREA_CONOCIMIENTO;
                $TIP_GRUPO_PROCESO = $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO[0]->TIP_GRUPO_PROCESO;
                $DES_CRUCE_CONOC_PROC = $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO[0]->DES_CRUCE_CONOC_PROC;
                $DES_ABREVIATURA = $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO[0]->DES_ABREVIATURA;
                $COD_ORDEN = $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO[0]->COD_ORDEN;
                $EST_CONOC_PROC = $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO[0]->EST_CONOC_PROC;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('TIP_AREA_CONOCIMIENTO', $TIP_AREA_CONOCIMIENTO);
            $lCollection->Add('TIP_GRUPO_PROCESO', $TIP_GRUPO_PROCESO);
            $lCollection->Add('DES_CRUCE_CONOC_PROC', $DES_CRUCE_CONOC_PROC);
            $lCollection->Add('DES_ABREVIATURA', $DES_ABREVIATURA);
            $lCollection->Add('COD_ORDEN', $COD_ORDEN);
            $lCollection->Add('EST_CONOC_PROC', $EST_CONOC_PROC);

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

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO = array();
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO = new GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($TIP_AREA_CONOCIMIENTO)) > 0) {
                $lstparametrosM['TIP_AREA_CONOCIMIENTO'] = $TIP_AREA_CONOCIMIENTO;
            }
            if (strlen(rtrim($TIP_GRUPO_PROCESO)) > 0) {
                $lstparametrosM['TIP_GRUPO_PROCESO'] = $TIP_GRUPO_PROCESO;
            }
            if (strlen(rtrim($DES_CRUCE_CONOC_PROC)) > 0) {
                $lstparametrosM['DES_CRUCE_CONOC_PROC'] = $DES_CRUCE_CONOC_PROC;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($COD_ORDEN)) > 0) {
                $lstparametrosM['COD_ORDEN'] = $COD_ORDEN;
            }
            if (strlen(rtrim($EST_CONOC_PROC)) > 0) {
                $lstparametrosM['EST_CONOC_PROC'] = $EST_CONOC_PROC;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_AREA_CONOCIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_GRUPO_PROCESO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CRUCE_CONOC_PROC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ORDEN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CONOC_PROC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO->Update_GEN_MATRIZ_CONOCIMIENTO_PROCESO($DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[8][0];

            $mensaje = $procedure_parametrosMS[9][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO = array();
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO = new GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO();
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
            $Objeto_GEN_MATRIZ_CONOCIMIENTO_PROCESO_DAO->Delete_GEN_MATRIZ_CONOCIMIENTO_PROCESO($DataSet_GEN_MATRIZ_CONOCIMIENTO_PROCESO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_AREA_CONOCIMIENTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='82'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_AREA_CONOCIMIENTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_GRUPO_PROCESO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='83'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_GRUPO_PROCESO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_CONOC_PROC_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CONOC_PROC_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
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