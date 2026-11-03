<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_ACT_UBIGEOLN de la tabla PROY_ACT_UBIGEO
  //  Fecha           : lunes, 20 de noviembre de 2017 06:03:38 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_ACT_UBIGEODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/PROYECTO_ACTIVIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_UBIGEODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

require_once("include/PROYECTOLNI.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_ACT_UBIGEO";
    $PermisoOK = 0;

    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}

    
    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
    if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
    if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
    if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}
	$PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);


    if ($PermisoOK == 1) {
        $COD_UBIGEO 		= "";
        $DESCRIPCIONUBIGEO	= "";

        /*******************************************************************
        *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
        /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";

        if ($ActionFlex <> "LoadProvinciaAjax" and $ActionFlex <> "LoadDistritoAjax") {
            $PIDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) : "";


            /*******************************************************************
            *     RECUPERACION DE DATOS DEL FORMULARIO
            /****************************************************************** */
            $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
            $IDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['IDE_PROYECTO_ACTIVIDAD']) : "";
            $COD_UBIGEO = isset($_REQUEST['COD_UBIGEO']) ? VerificarInputs($_REQUEST['COD_UBIGEO']) : "";
            $GEO_LONGITUD_UBICACION = isset($_REQUEST['GEO_LONGITUD_UBICACION']) ? VerificarInputs($_REQUEST['GEO_LONGITUD_UBICACION']) : "";
            $GEO_LATITUD_UBICACION = isset($_REQUEST['GEO_LATITUD_UBICACION']) ? VerificarInputs($_REQUEST['GEO_LATITUD_UBICACION']) : "";
            $EST_PROY_ACT_UBIGEO = isset($_REQUEST['EST_PROY_ACT_UBIGEO']) ? VerificarInputs($_REQUEST['EST_PROY_ACT_UBIGEO']) : "";
            /* FLEXIGRID */
            //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
            $ScriptFLX = " AND  PAU.IDE_PROYECTO_ACTIVIDAD=$PIDE_PROYECTO_ACTIVIDAD";

            
//            $PIDE_PROYECTO_ACTIVIDAD = 20115;
            
//            $DataSet_PROYECTO_ACTIVIDAD_1 = array();
//            $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
//            $lstparametrosM = array();
//            $lstparametrosM['campos'] = "IDE_ENTIDAD_EJECUTORA, SEC_EJEC, DES_ENTIDAD, COD_PROYECTO, DES_PROYECTO_ITEM, IMP_COSTO_ACTUAL";
////            $lstparametrosM['filtro'] = " AND IDE_PROYECTO_ACTIVIDAD = '$PIDE_PROYECTO_ACTIVIDAD'";
//            $lstparametrosM['filtro'] = " AND IDE_PROYECTO_ACTIVIDAD = 20115";
//            $procedure_parametrosMS = array(
//                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
//                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
//            );
//            $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO->SelCampos_PROYECTO_ACTIVIDAD2($DataSet_PROYECTO_ACTIVIDAD_1, $procedure_parametrosMS);
//            $VIDE_ENTIDAD_EJECUTORA = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IDE_ENTIDAD_EJECUTORA;
//            $lCollection->Add('VIDE_ENTIDAD_EJECUTORA', $VIDE_ENTIDAD_EJECUTORA);
//            $VSEC_EJEC = $DataSet_PROYECTO_ACTIVIDAD_1[0]->SEC_EJEC;
//            $lCollection->Add('VSEC_EJEC', $VSEC_EJEC);
//            $VDES_ENTIDAD = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_ENTIDAD;
//            $lCollection->Add('VDES_ENTIDAD', $VDES_ENTIDAD);
//            $VCOD_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD_1[0]->COD_PROYECTO;
//            $lCollection->Add('VCOD_PROYECTO', $VCOD_PROYECTO);
//            $VDES_PROYECTO_ITEM = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_PROYECTO_ITEM;
//            $lCollection->Add('VDES_PROYECTO_ITEM', $VDES_PROYECTO_ITEM);
//            $VIMP_COSTO_ACTUAL = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IMP_COSTO_ACTUAL;
//            $lCollection->Add('VIMP_COSTO_ACTUAL', $VIMP_COSTO_ACTUAL);

        }


        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_ACT_UBIGEO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_DEPARTAMENTO') {
                        $_POST['qtype'] = 'GU.DES_DEPARTAMENTO';
                    }
                    if ($_POST['qtype'] == 'DES_PROVINCIA') {
                        $_POST['qtype'] = 'GU.DES_PROVINCIA';
                    }
                    if ($_POST['qtype'] == 'DES_DISTRITO') {
                        $_POST['qtype'] = 'GU.DES_DISTRITO';
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
            $ogridDAO->Count_PROY_ACT_UBIGEO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROY_ACT_UBIGEO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_ACT_UBIGEO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*******************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
        /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */
            /* FIN DE ACTIVACION */
            $DataSet_PROY_ACT_UBIGEOM = array();
            $Objeto_PROY_ACT_UBIGEO_DAO = new PROY_ACT_UBIGEO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($COD_UBIGEO)) > 0) {
                $lstparametrosM['COD_UBIGEO'] = $COD_UBIGEO;
            }
            if (strlen(rtrim($GEO_LONGITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LONGITUD_UBICACION'] = $GEO_LONGITUD_UBICACION;
            }
            if (strlen(rtrim($GEO_LATITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LATITUD_UBICACION'] = $GEO_LATITUD_UBICACION;
            }
            if (strlen(rtrim($EST_PROY_ACT_UBIGEO)) > 0) {
                $lstparametrosM['EST_PROY_ACT_UBIGEO'] = $EST_PROY_ACT_UBIGEO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_UBIGEO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GEO_LONGITUD_UBICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GEO_LATITUD_UBICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROY_ACT_UBIGEO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_ACT_UBIGEO_DAO->Insert_PROY_ACT_UBIGEO($DataSet_PROY_ACT_UBIGEO, $procedure_parametrosMS); //JCMY
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
            $DataSet_PROY_ACT_UBIGEO = array();
            $Objeto_PROY_ACT_UBIGEO_DAO = new PROY_ACT_UBIGEO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_ACT_UBIGEO_DAO->SelPk_PROY_ACT_UBIGEO($DataSet_PROY_ACT_UBIGEO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_ACT_UBIGEO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_ACT_UBIGEO

                $IDE_PROYECTO_ACTIVIDAD = $DataSet_PROY_ACT_UBIGEO[0]->IDE_PROYECTO_ACTIVIDAD;
                $COD_UBIGEO = trim($DataSet_PROY_ACT_UBIGEO[0]->COD_UBIGEO);                
                $DESCRIPCIONUBIGEO = $DataSet_PROY_ACT_UBIGEO[0]-> DESCRIPCIONUBIGEO;
                $GEO_LONGITUD_UBICACION = $DataSet_PROY_ACT_UBIGEO[0]->GEO_LONGITUD_UBICACION;
                $GEO_LATITUD_UBICACION = $DataSet_PROY_ACT_UBIGEO[0]->GEO_LATITUD_UBICACION;
                $EST_PROY_ACT_UBIGEO = $DataSet_PROY_ACT_UBIGEO[0]->EST_PROY_ACT_UBIGEO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO_ACTIVIDAD', $IDE_PROYECTO_ACTIVIDAD);
            $lCollection->Add('COD_UBIGEO', $COD_UBIGEO);            
            $lCollection->Add('GEO_LONGITUD_UBICACION', $GEO_LONGITUD_UBICACION);
            $lCollection->Add('GEO_LATITUD_UBICACION', $GEO_LATITUD_UBICACION);
            $lCollection->Add('EST_PROY_ACT_UBIGEO', $EST_PROY_ACT_UBIGEO);
            
            // RECUPERANDO VALORES DEL UBIGEO
            $DataSet_GEN_UBIGEO = array();
            $Objeto_UBIGEO_DAO = new GEN_UBIGEO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = "COD_UBIGEO, DES_DEPARTAMENTO, DES_PROVINCIA, DES_DISTRITO";
            $lstparametrosM['filtro'] = " AND COD_UBIGEO='".trim($COD_UBIGEO)."'";            
            $procedure_parametrosMS = array(
                  array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_UBIGEO_DAO->SelCampos_GEN_UBIGEO($DataSet_GEN_UBIGEO, $procedure_parametrosMS);            
            $listaContador = count($DataSet_GEN_UBIGEO) > 0 ? true : false; 
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {                
                $DES_DEPARTAMENTO=$DataSet_GEN_UBIGEO[0]->DES_DEPARTAMENTO;
                $DES_PROVINCIA=$DataSet_GEN_UBIGEO[0]->DES_PROVINCIA;
                $DES_DISTRITO=$DataSet_GEN_UBIGEO[0]->DES_DISTRITO;                
            }
			
            $DESCRIPCIONUBIGEO='( '.$COD_UBIGEO.' ) '.$DES_DEPARTAMENTO.' - '.$DES_PROVINCIA.' - '.$DES_DISTRITO;            
            $lCollection->Add('DESCRIPCIONUBIGEO', $DESCRIPCIONUBIGEO);            
        }

        /*******************************************************************
        *        METODO PARA ACTUALIZAR UN REGISTRO 
        /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($IDE_PROYECTO_ACTIVIDAD);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_ACT_UBIGEO = array();
            $Objeto_PROY_ACT_UBIGEO_DAO = new PROY_ACT_UBIGEO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['IDE_PROYECTO_ACTIVIDAD'] = $IDE_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($COD_UBIGEO)) > 0) {
                $lstparametrosM['COD_UBIGEO'] = $COD_UBIGEO;
            }
            if (strlen(rtrim($GEO_LONGITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LONGITUD_UBICACION'] = $GEO_LONGITUD_UBICACION;
            }
            if (strlen(rtrim($GEO_LATITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LATITUD_UBICACION'] = $GEO_LATITUD_UBICACION;
            }
            if (strlen(rtrim($EST_PROY_ACT_UBIGEO)) > 0) {
                $lstparametrosM['EST_PROY_ACT_UBIGEO'] = $EST_PROY_ACT_UBIGEO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UBIGEO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GEO_LONGITUD_UBICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GEO_LATITUD_UBICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROY_ACT_UBIGEO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_ACT_UBIGEO_DAO->Update_PROY_ACT_UBIGEO($DataSet_PROY_ACT_UBIGEO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_ACT_UBIGEO = array();
            $Objeto_PROY_ACT_UBIGEO_DAO = new PROY_ACT_UBIGEO_DAO();
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
            $Objeto_PROY_ACT_UBIGEO_DAO->Delete_PROY_ACT_UBIGEO($DataSet_PROY_ACT_UBIGEO, $procedure_parametrosMS); //JCMY
            $CodMensaje = $procedure_parametrosMS[2][0];
            $mensaje = $procedure_parametrosMS[3][0];
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);


    if ($ActionFlex <> "LoadProvinciaAjax" and $ActionFlex <> "LoadDistritoAjax") {
        /********************************************************************************
         *          SECCION DE CODIGO PARA LAS LISTAS DEPLEGABLES O COMBOS
        /*******************************************************************************/
        $DataSet_GEN_UBIGEO_1 = array();
        $Objeto_REGION_DAO = new GEN_UBIGEO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_UBIGEO,DES_DEPARTAMENTO";
        $lstparametrosM['filtro'] = " AND NUM_NIVEL=1";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_REGION_DAO->SelCampos_GEN_UBIGEO($DataSet_GEN_UBIGEO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_UBIGEO_1', $DataSet_GEN_UBIGEO_1);


        $DataSet_GEN_UBIGEO_2 = array();
        $Objeto_PROVINCIA_DAO = new GEN_UBIGEO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_UBIGEO,DES_PROVINCIA";
        $lstparametrosM['filtro'] = " AND NUM_NIVEL=2 AND COD_UBIGEO_SUP ='" . substr($COD_UBIGEO,0,2) . "'";
        $procedure_parametrosMS = array(
        array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
        , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_PROVINCIA_DAO->SelCampos_GEN_UBIGEO($DataSet_GEN_UBIGEO_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_UBIGEO_2', $DataSet_GEN_UBIGEO_2);


        $DataSet_GEN_UBIGEO_3 = array();
        $Objeto_DISTRITO_DAO = new GEN_UBIGEO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_UBIGEO,DES_DISTRITO";
        $lstparametrosM['filtro'] = " AND NUM_NIVEL=3 AND COD_UBIGEO_SUP ='" . substr($COD_UBIGEO,0,4) . "'";
        $procedure_parametrosMS = array(
        array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
        , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_DISTRITO_DAO->SelCampos_GEN_UBIGEO($DataSet_GEN_UBIGEO_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_UBIGEO_3', $DataSet_GEN_UBIGEO_3);


        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_PROY_ACT_UBIGEO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_EST_PROY_ACT_UBIGEO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);
    }

        /********************************************************************************
         *          SECCION DE CODIGO AJAX PARA LAS LISTAS DEPLEGABLES O COMBOS
        /*******************************************************************************/
        if ($ActionFlex == "LoadProvinciaAjax") {
            $ProvinciaID = isset($_REQUEST['Id']) ? VerificarInputs($_REQUEST['Id']) : 0;
            $DataSet_GEN_UBIGEO_2 = array();
            $Objeto_PROVINCIA_DAO = new GEN_UBIGEO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = "COD_UBIGEO,DES_PROVINCIA";
            $lstparametrosM['filtro'] = " AND NUM_NIVEL=2 AND COD_UBIGEO_SUP ='" . $ProvinciaID . "'";
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROVINCIA_DAO->SelCampos_GEN_UBIGEO($DataSet_GEN_UBIGEO_2, $procedure_parametrosMS);
            $lCollection->Add('DataSet_GEN_UBIGEO_2', $DataSet_GEN_UBIGEO_2);
        } elseif ($ActionFlex == "LoadDistritoAjax") {
            $DistritoID = isset($_REQUEST['Id']) ? VerificarInputs($_REQUEST['Id']) : 0;
            $DataSet_GEN_UBIGEO_3 = array();
            $Objeto_DISTRITO_DAO = new GEN_UBIGEO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = "COD_UBIGEO,DES_DISTRITO";
            $lstparametrosM['filtro'] = " AND NUM_NIVEL=3 AND COD_UBIGEO_SUP ='" . $DistritoID . "'";
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_DISTRITO_DAO->SelCampos_GEN_UBIGEO($DataSet_GEN_UBIGEO_3, $procedure_parametrosMS);
            $lCollection->Add('DataSet_GEN_UBIGEO_3', $DataSet_GEN_UBIGEO_3);
        } else {
            $lCollection->Add('PIDE_PROYECTO_ACTIVIDAD', $PIDE_PROYECTO_ACTIVIDAD);
        }
        
        
        
        
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    }
}

//var_dump($lstDepartamento);exit;

