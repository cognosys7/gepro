<?php

/* * ******************************************************************************
  //  ==========================================
//  Proyecto        : MODULO DE PLANIFICACION
//  Entidad         : AUTORIDAD PARA LA RECONSTRUCCIÓN CON CAMBIOS. PRESIDENCIA DEL CONSEJO DE MINISTROS
//  Autores         : ING. EDGAR DAVID PISFIL AHUMADA
  //  Propósito       : PLAN_TRANS_INTERVENCIONLN de la tabla PLAN_TRANS_INTERVENCION
  //  Fecha           : viernes, 26 de octubre de 2018 13:10:56
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLAN_TRANS_INTERVENCIONDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/genericaDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/fuente_financDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/componente_nombreDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/programa_ppto_nombreDAO.php");

/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION ****/
require_once("include/GEN_ENTIDADLNI.php");
require_once("include/GEN_UBIGEOLNI.php");
require_once("include/LNinclude.php");
/***EDGAR---**************/


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PLAN_TRANS_INTERVENCION";
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
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : ""; // echo  $PIDE ; die;
/***EDGAR---******************/
        
        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_TRANSFERENCIA = isset($_REQUEST['IDE_TRANSFERENCIA']) ? VerificarInputs($_REQUEST['IDE_TRANSFERENCIA']) : "";
        $TIPO_TRANSFERENCIA = isset($_REQUEST['TIPO_TRANSFERENCIA']) ? VerificarInputs($_REQUEST['TIPO_TRANSFERENCIA']) : "";
        $TIPO_TRANSACCION = isset($_REQUEST['TIPO_TRANSACCION']) ? VerificarInputs($_REQUEST['TIPO_TRANSACCION']) : "";
        $AMBITO = isset($_REQUEST['AMBITO']) ? VerificarInputs($_REQUEST['AMBITO']) : "";
        $PROGRAMA_PPTO = isset($_REQUEST['PROGRAMA_PPTO']) ? VerificarInputs($_REQUEST['PROGRAMA_PPTO']) : "";
        $FUENTE_FINANC = isset($_REQUEST['FUENTE_FINANC']) ? VerificarInputs($_REQUEST['FUENTE_FINANC']) : "";
        $GENERICA = isset($_REQUEST['GENERICA']) ? VerificarInputs($_REQUEST['GENERICA']) : "";
        $COMPONENTE = isset($_REQUEST['COMPONENTE']) ? VerificarInputs($_REQUEST['COMPONENTE']) : "";
        $COD_PRODUCTO_PROYECTO = isset($_REQUEST['COD_PRODUCTO_PROYECTO']) ? VerificarInputs($_REQUEST['COD_PRODUCTO_PROYECTO']) : "";
        $IMP_TRANSFERENCIA = isset($_REQUEST['IMP_TRANSFERENCIA']) ? VerificarInputs($_REQUEST['IMP_TRANSFERENCIA']) : "";
        $DES_INTERVENCION = isset($_REQUEST['DES_INTERVENCION']) ? VerificarInputs($_REQUEST['DES_INTERVENCION']) : "";
        $DES_INTERVENCION_CORTO = isset($_REQUEST['DES_INTERVENCION_CORTO']) ? VerificarInputs($_REQUEST['DES_INTERVENCION_CORTO']) : "";
        $TIP_GRUPO_INTERVENCION = isset($_REQUEST['TIP_GRUPO_INTERVENCION']) ? VerificarInputs($_REQUEST['TIP_GRUPO_INTERVENCION']) : "";
        $COD_SNIP = isset($_REQUEST['COD_SNIP']) ? VerificarInputs($_REQUEST['COD_SNIP']) : "";
        $COD_UNICO = isset($_REQUEST['COD_UNICO']) ? VerificarInputs($_REQUEST['COD_UNICO']) : "";
        $COD_UBIGEO = isset($_REQUEST['COD_UBIGEO']) ? VerificarInputs($_REQUEST['COD_UBIGEO']) : "";
        $IDE_ENTIDAD = isset($_REQUEST['IDE_ENTIDAD']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD']) : "";
        $TIP_TIPOLOGIA_INTERVENCION = isset($_REQUEST['TIP_TIPOLOGIA_INTERVENCION']) ? VerificarInputs($_REQUEST['TIP_TIPOLOGIA_INTERVENCION']) : "";
        $IDE_INTERVENCION = isset($_REQUEST['IDE_INTERVENCION']) ? VerificarInputs($_REQUEST['IDE_INTERVENCION']) : "";
        $IDE_PIP = isset($_REQUEST['IDE_PIP']) ? VerificarInputs($_REQUEST['IDE_PIP']) : "";
        $TIP_PRODUCTO_PROYECTO = isset($_REQUEST['TIP_PRODUCTO_PROYECTO']) ? VerificarInputs($_REQUEST['TIP_PRODUCTO_PROYECTO']) : "";
        $EST_TRANS_INTERVENCION = isset($_REQUEST['EST_TRANS_INTERVENCION']) ? VerificarInputs($_REQUEST['EST_TRANS_INTERVENCION']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        if( strlen($PIDE)>0 ) {
            $ScriptFLX = " AND  PT.IDE_TRANSFERENCIA =". $PIDE ;
        };
        
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PLAN_TRANS_INTERVENCION_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {

                    if ($_POST['qtype'] == 'Decreto') {
                        $_POST['qtype'] = 'DS.COD_NORMATIVA';
                    }
                    if ($_POST['qtype'] == 'CodigoUnico') {
                        $_POST['qtype'] = 'PTI.COD_UNICO';
                    }
                    if ($_POST['qtype'] == 'Ejecutora') {
                        $_POST['qtype'] = 'UE.DES_ENTIDAD';
                    }
                    if ($_POST['qtype'] == 'Departamento') {
                        $_POST['qtype'] = 'UBI.DES_DEPARTAMENTO';
                    }
                    if ($_POST['qtype'] == 'Provincia') {
                        $_POST['qtype'] = 'UBI.DES_PROVINCIA';
                    }
                    if ($_POST['qtype'] == 'Distrito') {
                        $_POST['qtype'] = 'UBI.DES_DISTRITO';
                    }
                    if ($_POST['qtype'] == 'TipoIntervencion') {
                        $_POST['qtype'] = 'GI.DES_INTERVENCION';
                    }
                    if ($_POST['qtype'] == 'NombreCorto') {
                        $_POST['qtype'] = 'PTI.DES_INTERVENCION_CORTO';
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
            $ogridDAO->Count_PLAN_TRANS_INTERVENCION($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_TRANS_INTERVENCION;
//echo $nTotal ; die; 
            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PLAN_TRANS_INTERVENCION', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PLAN_TRANS_INTERVENCIONM = array();
            $Objeto_PLAN_TRANS_INTERVENCION_DAO = new PLAN_TRANS_INTERVENCION_DAO();
            $lstparametrosM = array();

            if (strlen(rtrim($IDE_TRANSFERENCIA)) > 0) {
                $lstparametrosM['IDE_TRANSFERENCIA'] = $IDE_TRANSFERENCIA;
            }
            if (strlen(rtrim($TIPO_TRANSFERENCIA)) > 0) {
                $lstparametrosM['TIPO_TRANSFERENCIA'] = $TIPO_TRANSFERENCIA;
            }
            if (strlen(rtrim($TIPO_TRANSACCION)) > 0) {
                $lstparametrosM['TIPO_TRANSACCION'] = $TIPO_TRANSACCION;
            }
            if (strlen(rtrim($AMBITO)) > 0) {
                $lstparametrosM['AMBITO'] = $AMBITO;
            }
            if (strlen(rtrim($PROGRAMA_PPTO)) > 0) {
                $lstparametrosM['PROGRAMA_PPTO'] = $PROGRAMA_PPTO;
            }
            if (strlen(rtrim($FUENTE_FINANC)) > 0) {
                $lstparametrosM['FUENTE_FINANC'] = $FUENTE_FINANC;
            }
            if (strlen(rtrim($GENERICA)) > 0) {
                $lstparametrosM['GENERICA'] = $GENERICA;
            }
            if (strlen(rtrim($COMPONENTE)) > 0) {
                $lstparametrosM['COMPONENTE'] = $COMPONENTE;
            }
            if (strlen(rtrim($COD_PRODUCTO_PROYECTO)) > 0) {
                $lstparametrosM['COD_PRODUCTO_PROYECTO'] = $COD_PRODUCTO_PROYECTO;
            }
            if (strlen(rtrim($IMP_TRANSFERENCIA)) > 0) {
                $lstparametrosM['IMP_TRANSFERENCIA'] = $IMP_TRANSFERENCIA;
            }
            if (strlen(rtrim($DES_INTERVENCION)) > 0) {
                $lstparametrosM['DES_INTERVENCION'] = $DES_INTERVENCION;
            }
            if (strlen(rtrim($DES_INTERVENCION_CORTO)) > 0) {
                $lstparametrosM['DES_INTERVENCION_CORTO'] = $DES_INTERVENCION_CORTO;
            }
            if (strlen(rtrim($TIP_GRUPO_INTERVENCION)) > 0) {
                $lstparametrosM['TIP_GRUPO_INTERVENCION'] = $TIP_GRUPO_INTERVENCION;
            }
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_UBIGEO)) > 0) {
                $lstparametrosM['COD_UBIGEO'] = $COD_UBIGEO;
            }
            if (strlen(rtrim($IDE_ENTIDAD)) > 0) {
                $lstparametrosM['IDE_ENTIDAD'] = $IDE_ENTIDAD;
            }
            if (strlen(rtrim($TIP_TIPOLOGIA_INTERVENCION)) > 0) {
                $lstparametrosM['TIP_TIPOLOGIA_INTERVENCION'] = $TIP_TIPOLOGIA_INTERVENCION;
            }
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($IDE_PIP)) > 0) {
                $lstparametrosM['IDE_PIP'] = $IDE_PIP;
            }
            if (strlen(rtrim($TIP_PRODUCTO_PROYECTO)) > 0) {
                $lstparametrosM['TIP_PRODUCTO_PROYECTO'] = $TIP_PRODUCTO_PROYECTO;
            }
            if (strlen(rtrim($EST_TRANS_INTERVENCION)) > 0) {
                $lstparametrosM['EST_TRANS_INTERVENCION'] = $EST_TRANS_INTERVENCION;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);
            

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_TRANSFERENCIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIPO_TRANSFERENCIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIPO_TRANSACCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['AMBITO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['PROGRAMA_PPTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FUENTE_FINANC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GENERICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_PRODUCTO_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_TRANSFERENCIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_INTERVENCION_CORTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_GRUPO_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_UBIGEO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_TIPOLOGIA_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PRODUCTO_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_TRANS_INTERVENCION'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_TRANS_INTERVENCION_DAO->Insert_PLAN_TRANS_INTERVENCION($DataSet_PLAN_TRANS_INTERVENCION, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[23][0];

            $mensaje = $procedure_parametrosMS[24][0];

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
            $DataSet_PLAN_TRANS_INTERVENCION = array();
            $Objeto_PLAN_TRANS_INTERVENCION_DAO = new PLAN_TRANS_INTERVENCION_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PLAN_TRANS_INTERVENCION_DAO->SelPk_PLAN_TRANS_INTERVENCION($DataSet_PLAN_TRANS_INTERVENCION, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PLAN_TRANS_INTERVENCION) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PLAN_TRANS_INTERVENCION

                $IDE_TRANSFERENCIA = $DataSet_PLAN_TRANS_INTERVENCION[0]->IDE_TRANSFERENCIA;
                $TIPO_TRANSFERENCIA = $DataSet_PLAN_TRANS_INTERVENCION[0]->TIPO_TRANSFERENCIA; 
                $TIPO_TRANSACCION = $DataSet_PLAN_TRANS_INTERVENCION[0]->TIPO_TRANSACCION;
                $AMBITO = $DataSet_PLAN_TRANS_INTERVENCION[0]->AMBITO;
                $PROGRAMA_PPTO = $DataSet_PLAN_TRANS_INTERVENCION[0]->PROGRAMA_PPTO;
                $FUENTE_FINANC = $DataSet_PLAN_TRANS_INTERVENCION[0]->FUENTE_FINANC;
                $GENERICA = $DataSet_PLAN_TRANS_INTERVENCION[0]->GENERICA;
                $COMPONENTE = $DataSet_PLAN_TRANS_INTERVENCION[0]->COMPONENTE;
                $COD_PRODUCTO_PROYECTO = $DataSet_PLAN_TRANS_INTERVENCION[0]->COD_PRODUCTO_PROYECTO;
                $IMP_TRANSFERENCIA = $DataSet_PLAN_TRANS_INTERVENCION[0]->IMP_TRANSFERENCIA;
                $DES_INTERVENCION = $DataSet_PLAN_TRANS_INTERVENCION[0]->DES_INTERVENCION;
                $DES_INTERVENCION_CORTO = $DataSet_PLAN_TRANS_INTERVENCION[0]->DES_INTERVENCION_CORTO;
                $TIP_GRUPO_INTERVENCION = $DataSet_PLAN_TRANS_INTERVENCION[0]->TIP_GRUPO_INTERVENCION;
                $COD_SNIP = $DataSet_PLAN_TRANS_INTERVENCION[0]->COD_SNIP;
                $COD_UNICO = $DataSet_PLAN_TRANS_INTERVENCION[0]->COD_UNICO;
                $COD_UBIGEO = $DataSet_PLAN_TRANS_INTERVENCION[0]->COD_UBIGEO;
                $IDE_ENTIDAD = $DataSet_PLAN_TRANS_INTERVENCION[0]->IDE_ENTIDAD;
                $TIP_TIPOLOGIA_INTERVENCION = $DataSet_PLAN_TRANS_INTERVENCION[0]->TIP_TIPOLOGIA_INTERVENCION;
                $IDE_INTERVENCION = $DataSet_PLAN_TRANS_INTERVENCION[0]->IDE_INTERVENCION;
                $IDE_PIP = $DataSet_PLAN_TRANS_INTERVENCION[0]->IDE_PIP;
                $TIP_PRODUCTO_PROYECTO = $DataSet_PLAN_TRANS_INTERVENCION[0]->TIP_PRODUCTO_PROYECTO;
                $EST_TRANS_INTERVENCION = $DataSet_PLAN_TRANS_INTERVENCION[0]->EST_TRANS_INTERVENCION;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_TRANSFERENCIA', $IDE_TRANSFERENCIA);
            $lCollection->Add('TIPO_TRANSFERENCIA', $TIPO_TRANSFERENCIA);
            $lCollection->Add('TIPO_TRANSACCION', $TIPO_TRANSACCION);
            $lCollection->Add('AMBITO', $AMBITO);
            $lCollection->Add('PROGRAMA_PPTO', $PROGRAMA_PPTO);
            $lCollection->Add('FUENTE_FINANC', $FUENTE_FINANC);
            $lCollection->Add('GENERICA', $GENERICA);
            $lCollection->Add('COMPONENTE', $COMPONENTE);
            $lCollection->Add('COD_PRODUCTO_PROYECTO', $COD_PRODUCTO_PROYECTO);
            $lCollection->Add('IMP_TRANSFERENCIA', $IMP_TRANSFERENCIA);
            $lCollection->Add('DES_INTERVENCION', $DES_INTERVENCION);
            $lCollection->Add('DES_INTERVENCION_CORTO', $DES_INTERVENCION_CORTO);
            $lCollection->Add('TIP_GRUPO_INTERVENCION', $TIP_GRUPO_INTERVENCION);
            $lCollection->Add('COD_SNIP', $COD_SNIP);
            $lCollection->Add('COD_UNICO', $COD_UNICO);
            $lCollection->Add('COD_UBIGEO', $COD_UBIGEO);
            $lCollection->Add('IDE_ENTIDAD', $IDE_ENTIDAD);
            $lCollection->Add('TIP_TIPOLOGIA_INTERVENCION', $TIP_TIPOLOGIA_INTERVENCION);
            $lCollection->Add('IDE_INTERVENCION', $IDE_INTERVENCION);
            $lCollection->Add('IDE_PIP', $IDE_PIP);
            $lCollection->Add('TIP_PRODUCTO_PROYECTO', $TIP_PRODUCTO_PROYECTO);
            $lCollection->Add('EST_TRANS_INTERVENCION', $EST_TRANS_INTERVENCION);
            
            
/*****************/ 
            $data_2 = Entidad_Datos( $IDE_ENTIDAD );
            $lCollection->Add('DESCRIPCION_ENTIDAD_UNIDAD_EJECUTORA', $data_2['DES_ENTIDAD']);

            $data_3 = UBIGEO_Datos( $COD_UBIGEO );
            $DES_DEPARTAMENTO = $data_3['DES_DEPARTAMENTO'];
            $DES_PROVINCIA = $data_3['DES_PROVINCIA'];
            $DES_DISTRITO = $data_3['DES_DISTRITO'];
            $DESCRIPCION_UBIGEO = $COD_UBIGEO . ' - ' . $DES_DEPARTAMENTO . ' - ' . $DES_PROVINCIA . ' - ' . $DES_DISTRITO;
            $lCollection->Add('DESCRIPCION_UBIGEO', $DESCRIPCION_UBIGEO);
            
            
            
            $DataSet_componente_nombre = array();
            $Objeto_componente_nombre_DAO = new componente_nombre_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = " ANO_EJE, COMPONENTE, NOMBRE ";
            $lstparametrosM['filtro'] = " AND COMPONENTE='".$COMPONENTE."'";            
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            
            $ANO_EJE = $COMPONENTE = $NOMBRE = '';
            
            $Objeto_componente_nombre_DAO->SelCampos_componente_nombre($DataSet_componente_nombre, $procedure_parametrosMS);            
            $listaContador = count($DataSet_componente_nombre) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                $ANO_EJE = $DataSet_componente_nombre[0]->ANO_EJE;
                $COMPONENTE = $DataSet_componente_nombre[0]->COMPONENTE;
                $NOMBRE = $DataSet_componente_nombre[0]->NOMBRE;
            }
            $lCollection->Add('ANO_EJE', $ANO_EJE);
            $lCollection->Add('COMPONENTE', $COMPONENTE);
            $lCollection->Add('NOMBRE', $NOMBRE); 
            $lCollection->Add('DESCRIPCION_COMPONENTE', $ANO_EJE.' - '.$COMPONENTE.' - '.$NOMBRE); 
            
            
            
            
            
            $DataSet_programa_ppto_nombre = array();
            $Objeto_programa_ppto_nombre_DAO = new programa_ppto_nombre_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = " ANO_EJE, PROGRAMA_PPTO, NOMBRE ";
            $lstparametrosM['filtro'] = " AND PROGRAMA_PPTO='".$PROGRAMA_PPTO."'";            
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            
            $ANO_EJE = $PROGRAMA_PPTO = $NOMBRE = '';
            
            $Objeto_programa_ppto_nombre_DAO->SelCampos_programa_ppto_nombre($DataSet_programa_ppto_nombre, $procedure_parametrosMS);            
            $listaContador = count($DataSet_programa_ppto_nombre) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                $ANO_EJE = $DataSet_programa_ppto_nombre[0]->ANO_EJE;
                $PROGRAMA_PPTO = $DataSet_programa_ppto_nombre[0]->PROGRAMA_PPTO;
                $NOMBRE = $DataSet_programa_ppto_nombre[0]->NOMBRE;
            }
            $lCollection->Add('ANO_EJE', $ANO_EJE);
            $lCollection->Add('PROGRAMA_PPTO', $PROGRAMA_PPTO);
            $lCollection->Add('NOMBRE', $NOMBRE); 
            $lCollection->Add('DESCRIPCION_PROGRAMA_PPTO', $ANO_EJE.' - '.$PROGRAMA_PPTO.' - '.$NOMBRE); 
/*****************/ 
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PLAN_TRANS_INTERVENCION = array();
            $Objeto_PLAN_TRANS_INTERVENCION_DAO = new PLAN_TRANS_INTERVENCION_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_TRANSFERENCIA)) > 0) {
                $lstparametrosM['IDE_TRANSFERENCIA'] = $IDE_TRANSFERENCIA;
            }
            if (strlen(rtrim($TIPO_TRANSFERENCIA)) > 0) {
                $lstparametrosM['TIPO_TRANSFERENCIA'] = $TIPO_TRANSFERENCIA;
            }
            if (strlen(rtrim($TIPO_TRANSACCION)) > 0) {
                $lstparametrosM['TIPO_TRANSACCION'] = $TIPO_TRANSACCION;
            }
            if (strlen(rtrim($AMBITO)) > 0) {
                $lstparametrosM['AMBITO'] = $AMBITO;
            }
            if (strlen(rtrim($PROGRAMA_PPTO)) > 0) {
                $lstparametrosM['PROGRAMA_PPTO'] = $PROGRAMA_PPTO;
            }
            if (strlen(rtrim($FUENTE_FINANC)) > 0) {
                $lstparametrosM['FUENTE_FINANC'] = $FUENTE_FINANC;
            }
            if (strlen(rtrim($GENERICA)) > 0) {
                $lstparametrosM['GENERICA'] = $GENERICA;
            }
            if (strlen(rtrim($COMPONENTE)) > 0) {
                $lstparametrosM['COMPONENTE'] = $COMPONENTE;
            }
            if (strlen(rtrim($COD_PRODUCTO_PROYECTO)) > 0) {
                $lstparametrosM['COD_PRODUCTO_PROYECTO'] = $COD_PRODUCTO_PROYECTO;
            }
            if (strlen(rtrim($IMP_TRANSFERENCIA)) > 0) {
                $lstparametrosM['IMP_TRANSFERENCIA'] = $IMP_TRANSFERENCIA;
            }
            if (strlen(rtrim($DES_INTERVENCION)) > 0) {
                $lstparametrosM['DES_INTERVENCION'] = $DES_INTERVENCION;
            }
            if (strlen(rtrim($DES_INTERVENCION_CORTO)) > 0) {
                $lstparametrosM['DES_INTERVENCION_CORTO'] = $DES_INTERVENCION_CORTO;
            }
            if (strlen(rtrim($TIP_GRUPO_INTERVENCION)) > 0) {
                $lstparametrosM['TIP_GRUPO_INTERVENCION'] = $TIP_GRUPO_INTERVENCION;
            }
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_UBIGEO)) > 0) {
                $lstparametrosM['COD_UBIGEO'] = $COD_UBIGEO;
            }
            if (strlen(rtrim($IDE_ENTIDAD)) > 0) {
                $lstparametrosM['IDE_ENTIDAD'] = $IDE_ENTIDAD;
            }
            if (strlen(rtrim($TIP_TIPOLOGIA_INTERVENCION)) > 0) {
                $lstparametrosM['TIP_TIPOLOGIA_INTERVENCION'] = $TIP_TIPOLOGIA_INTERVENCION;
            }
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($IDE_PIP)) > 0) {
                $lstparametrosM['IDE_PIP'] = $IDE_PIP;
            }
            if (strlen(rtrim($TIP_PRODUCTO_PROYECTO)) > 0) {
                $lstparametrosM['TIP_PRODUCTO_PROYECTO'] = $TIP_PRODUCTO_PROYECTO;
            }
            if (strlen(rtrim($EST_TRANS_INTERVENCION)) > 0) {
                $lstparametrosM['EST_TRANS_INTERVENCION'] = $EST_TRANS_INTERVENCION;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_TRANSFERENCIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIPO_TRANSFERENCIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIPO_TRANSACCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['AMBITO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PROGRAMA_PPTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FUENTE_FINANC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GENERICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_PRODUCTO_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_TRANSFERENCIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_INTERVENCION_CORTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_GRUPO_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UBIGEO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_TIPOLOGIA_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PRODUCTO_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_TRANS_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_TRANS_INTERVENCION_DAO->Update_PLAN_TRANS_INTERVENCION($DataSet_PLAN_TRANS_INTERVENCION, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[24][0];

            $mensaje = $procedure_parametrosMS[25][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PLAN_TRANS_INTERVENCION = array();
            $Objeto_PLAN_TRANS_INTERVENCION_DAO = new PLAN_TRANS_INTERVENCION_DAO();
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
            $Objeto_PLAN_TRANS_INTERVENCION_DAO->Delete_PLAN_TRANS_INTERVENCION($DataSet_PLAN_TRANS_INTERVENCION, $procedure_parametrosMS); //JCMY
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
        $Objeto_TIPO_TRANSFERENCIA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='24'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIPO_TRANSFERENCIA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_AMBITO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='25'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_AMBITO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_TRANS_INTERVENCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_TRANS_INTERVENCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_TIP_GRUPO_INTERVENCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='23'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_GRUPO_INTERVENCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_5 = array();
        $Objeto_TIP_TIPOLOGIA_INTERVENCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='32'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_TIPOLOGIA_INTERVENCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_5, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_5', $DataSet_GEN_TABLAS_5);

        /* 					 */

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_INTERVENCION_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_6 = array();
        $Objeto_TIP_PRODUCTO_PROYECTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='2'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PRODUCTO_PROYECTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_6, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_6', $DataSet_GEN_TABLAS_6);

        /* 					 */

        /* 					 */

        $DataSet_generica = array();
        $Objeto_generica_DAO = new generica_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = " GENERICA, DESCRIPCIO ";
        $lstparametrosM['filtro'] = "AND TIPO_TRANSACCION='2'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_generica_DAO->SelCampos_generica($DataSet_generica, $procedure_parametrosMS);
        $lCollection->Add('DataSet_generica', $DataSet_generica);
        
        
        /* 					 */

        
        $DataSet_fuente_financ = array();
        $Objeto_fuente_financ_DAO = new fuente_financ_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = " FUENTE_FINANC, NOMBRE ";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_fuente_financ_DAO->SelCampos_fuente_financ($DataSet_fuente_financ, $procedure_parametrosMS);
        $lCollection->Add('DataSet_fuente_financ', $DataSet_fuente_financ);
        
        /* 					 */

        /* 					 */
        
        $lCollection->Add('PIDE', $PIDE);
    }
}

//var_dump($lstDepartamento);exit;