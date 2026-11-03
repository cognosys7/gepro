<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Prop�sito       : GEN_ACTIVIDADLN de la tabla GEN_ACTIVIDAD
  //  Fecha           : martes, 15 de mayo de 2018 13:15:09
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_ACTIVIDADDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


//require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCION_COMPDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/GEN_INTERVENCION_COMlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_ACTIVIDAD";
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


        $PIDE_INTERVENCION_COMP = isset($_REQUEST['PIDE_INTERVENCION_COMP']) ? VerificarInputs($_REQUEST['PIDE_INTERVENCION_COMP']) : "";


        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_INTERVENCION_COMP = isset($_REQUEST['IDE_INTERVENCION_COMP']) ? VerificarInputs($_REQUEST['IDE_INTERVENCION_COMP']) : "";
        $IDE_ACTIVIDAD_SUP = isset($_REQUEST['IDE_ACTIVIDAD_SUP']) ? VerificarInputs($_REQUEST['IDE_ACTIVIDAD_SUP']) : "";
        $DES_ACTIVIDAD = isset($_REQUEST['DES_ACTIVIDAD']) ? VerificarInputs($_REQUEST['DES_ACTIVIDAD']) : "";
        $DES_ABREVIATURA = isset($_REQUEST['DES_ABREVIATURA']) ? VerificarInputs($_REQUEST['DES_ABREVIATURA']) : "";
        $NUM_NIVEL = isset($_REQUEST['NUM_NIVEL']) ? VerificarInputs($_REQUEST['NUM_NIVEL']) : "";
        $NUM_DIAS = isset($_REQUEST['NUM_DIAS']) ? VerificarInputs($_REQUEST['NUM_DIAS']) : "";
        $IND_HITO = isset($_REQUEST['IND_HITO']) ? VerificarInputs($_REQUEST['IND_HITO']) : "";
        $COD_ORDEN = isset($_REQUEST['COD_ORDEN']) ? VerificarInputs($_REQUEST['COD_ORDEN']) : "";
        $EST_ACTIVIDAD = isset($_REQUEST['EST_ACTIVIDAD']) ? VerificarInputs($_REQUEST['EST_ACTIVIDAD']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND IdeIntervComponente=$PIDE_INTERVENCION_COMP";



        $DataSet_GEN_INTERVENCION_COMP_1 = array();
        $Objeto_IDE_INTERVENCION_COMP_DAO = new GEN_INTERVENCION_COMP_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "  INTERV.DES_INTERVENCION AS TipoIntervencion,   COMP.DES_ABREVIATURA AS Componente,   MODEJE.DES_MODO_EJECUCION AS Modalidad ";
        $lstparametrosM['filtro'] = " AND INTCMP.IDE_INTERVENCION_COMP = '$PIDE_INTERVENCION_COMP' ";
        //$lstparametrosM['filtro'] = " AND INTCMP.IDE_INTERVENCION_COMP = 87";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_INTERVENCION_COMP_DAO->SelCampos2_GEN_INTERVENCION_COMP($DataSet_GEN_INTERVENCION_COMP_1, $procedure_parametrosMS);


        $VTipoIntervencion = $DataSet_GEN_INTERVENCION_COMP_1[0]->TipoIntervencion;
        $lCollection->Add('VTipoIntervencion', $VTipoIntervencion);
        $VComponente = $DataSet_GEN_INTERVENCION_COMP_1[0]->Componente;
        $lCollection->Add('VComponente', $VComponente);
        $VModalidad = $DataSet_GEN_INTERVENCION_COMP_1[0]->Modalidad;
        $lCollection->Add('VModalidad', $VModalidad);

        $lCollection->Add('DatosPadre', Tabla_IntervencionCom_Datos2 ( $VTipoIntervencion, $VComponente, $VModalidad ) ) ;

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_ACTIVIDAD_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'Actividad') {
                        $_POST['qtype'] = 'Actividad';
                    }
                    if ($_POST['qtype'] == 'Nivel') {
                        $_POST['qtype'] = 'Nivel';
                    }
                    if ($_POST['qtype'] == 'Hito') {
                        $_POST['qtype'] = 'Hito';
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
            $ogridDAO->Count_GEN_ACTIVIDAD($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_ACTIVIDAD;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_ACTIVIDAD', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_ACTIVIDADM = array();
            $Objeto_GEN_ACTIVIDAD_DAO = new GEN_ACTIVIDAD_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_INTERVENCION_COMP)) > 0) {
                $lstparametrosM['IDE_INTERVENCION_COMP'] = $IDE_INTERVENCION_COMP;
            }
            if (strlen(rtrim($IDE_ACTIVIDAD_SUP)) > 0) {
                $lstparametrosM['IDE_ACTIVIDAD_SUP'] = $IDE_ACTIVIDAD_SUP;
            }
            if (strlen(rtrim($DES_ACTIVIDAD)) > 0) {
                $lstparametrosM['DES_ACTIVIDAD'] = $DES_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($NUM_DIAS)) > 0) {
                $lstparametrosM['NUM_DIAS'] = $NUM_DIAS;
            }
            if (strlen(rtrim($IND_HITO)) > 0) {
                $lstparametrosM['IND_HITO'] = $IND_HITO;
            }
            if (strlen(rtrim($COD_ORDEN)) > 0) {
                $lstparametrosM['COD_ORDEN'] = $COD_ORDEN;
            }
            if (strlen(rtrim($EST_ACTIVIDAD)) > 0) {
                $lstparametrosM['EST_ACTIVIDAD'] = $EST_ACTIVIDAD;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_INTERVENCION_COMP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ACTIVIDAD_SUP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_DIAS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IND_HITO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_ORDEN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ACTIVIDAD'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ACTIVIDAD_DAO->Insert_GEN_ACTIVIDAD($DataSet_GEN_ACTIVIDAD, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_ACTIVIDAD = array();
            $Objeto_GEN_ACTIVIDAD_DAO = new GEN_ACTIVIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_ACTIVIDAD_DAO->SelPk_GEN_ACTIVIDAD($DataSet_GEN_ACTIVIDAD, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_ACTIVIDAD) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_ACTIVIDAD

                $IDE_INTERVENCION_COMP = $DataSet_GEN_ACTIVIDAD[0]->IDE_INTERVENCION_COMP;
                $IDE_ACTIVIDAD_SUP = $DataSet_GEN_ACTIVIDAD[0]->IDE_ACTIVIDAD_SUP;
                $DES_ACTIVIDAD = $DataSet_GEN_ACTIVIDAD[0]->DES_ACTIVIDAD;
                $DES_ABREVIATURA = $DataSet_GEN_ACTIVIDAD[0]->DES_ABREVIATURA;
                $NUM_NIVEL = $DataSet_GEN_ACTIVIDAD[0]->NUM_NIVEL;
                $NUM_DIAS = $DataSet_GEN_ACTIVIDAD[0]->NUM_DIAS;
                $IND_HITO = $DataSet_GEN_ACTIVIDAD[0]->IND_HITO;
                $COD_ORDEN = $DataSet_GEN_ACTIVIDAD[0]->COD_ORDEN;
                $EST_ACTIVIDAD = $DataSet_GEN_ACTIVIDAD[0]->EST_ACTIVIDAD;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_INTERVENCION_COMP', $IDE_INTERVENCION_COMP);
            $lCollection->Add('IDE_ACTIVIDAD_SUP', $IDE_ACTIVIDAD_SUP);
            $lCollection->Add('DES_ACTIVIDAD', $DES_ACTIVIDAD);
            $lCollection->Add('DES_ABREVIATURA', $DES_ABREVIATURA);
            $lCollection->Add('NUM_NIVEL', $NUM_NIVEL);
            $lCollection->Add('NUM_DIAS', $NUM_DIAS);
            $lCollection->Add('IND_HITO', $IND_HITO);
            $lCollection->Add('COD_ORDEN', $COD_ORDEN);
            $lCollection->Add('EST_ACTIVIDAD', $EST_ACTIVIDAD);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_ACTIVIDAD = array();
            $Objeto_GEN_ACTIVIDAD_DAO = new GEN_ACTIVIDAD_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_INTERVENCION_COMP)) > 0) {
                $lstparametrosM['IDE_INTERVENCION_COMP'] = $IDE_INTERVENCION_COMP;
            }
            if (strlen(rtrim($IDE_ACTIVIDAD_SUP)) > 0) {
                $lstparametrosM['IDE_ACTIVIDAD_SUP'] = $IDE_ACTIVIDAD_SUP;
            }
            if (strlen(rtrim($DES_ACTIVIDAD)) > 0) {
                $lstparametrosM['DES_ACTIVIDAD'] = $DES_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($NUM_DIAS)) > 0) {
                $lstparametrosM['NUM_DIAS'] = $NUM_DIAS;
            }
            if (strlen(rtrim($IND_HITO)) > 0) {
                $lstparametrosM['IND_HITO'] = $IND_HITO;
            }
            if (strlen(rtrim($COD_ORDEN)) > 0) {
                $lstparametrosM['COD_ORDEN'] = $COD_ORDEN;
            }
            if (strlen(rtrim($EST_ACTIVIDAD)) > 0) {
                $lstparametrosM['EST_ACTIVIDAD'] = $EST_ACTIVIDAD;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_INTERVENCION_COMP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ACTIVIDAD_SUP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_DIAS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IND_HITO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_ORDEN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ACTIVIDAD_DAO->Update_GEN_ACTIVIDAD($DataSet_GEN_ACTIVIDAD, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[11][0];

            $mensaje = $procedure_parametrosMS[12][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_ACTIVIDAD = array();
            $Objeto_GEN_ACTIVIDAD_DAO = new GEN_ACTIVIDAD_DAO();
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
            $Objeto_GEN_ACTIVIDAD_DAO->Delete_GEN_ACTIVIDAD($DataSet_GEN_ACTIVIDAD, $procedure_parametrosMS); //JCMY
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


        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_NUM_NIVEL_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '29'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_NUM_NIVEL_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_IND_HITO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '30'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IND_HITO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_ACTIVIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ACTIVIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);




        $lCollection->Add('PIDE_INTERVENCION_COMP', $PIDE_INTERVENCION_COMP);
        
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    }
}

//var_dump($lstDepartamento);exit;
