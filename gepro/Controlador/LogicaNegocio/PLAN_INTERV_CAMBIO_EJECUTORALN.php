<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : MODULO DE PLANIFICACION
  //  Entidad         : AMSAC - ACTIVOS MINEROS S.A.C.
  //  Autores         : ING. EDGAR DAVID PISFIL AHUMADA

  //  Propósito       : PLAN_INTERV_CAMBIO_EJECUTORALN de la tabla PLAN_INTERV_CAMBIO_EJECUTORA
  //  Fecha           : jueves, 07 de junio de 2018 11:10:10 a.m.
  //  Desde el Modelo : PDM - AMSAC-pisfil
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PLAN_INTERV_CAMBIO_EJECUTORADAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_NORMATIVADAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_NORMATIVADAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

/***EDGAR---************** DFFINE DATOS DEL PLAN_INTERVENCION ****/
require_once("include/PLAN_INTERV_CAMBIO_EJECUTORALNI.php");
/***EDGAR---**************/

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PLAN_INTERV_CAMBIO_EJECUTORA";
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
        
        
        $DESCRIPCION_EJECUTORA_ORIGEN = "";
        $DESCRIPCION_EJECUTORA_DESTINO = "";
        
        
        
/***EDGAR---******************/
        $PIDE_PLAN_INTERVENCION = isset($_REQUEST['PIDE_PLAN_INTERVENCION']) ? VerificarInputs($_REQUEST['PIDE_PLAN_INTERVENCION']) : "";
/***EDGAR---******************/
        
        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PLAN_INTERVENCION = isset($_REQUEST['IDE_PLAN_INTERVENCION']) ? VerificarInputs($_REQUEST['IDE_PLAN_INTERVENCION']) : "";
        $IDE_EJECUTORA_ORIGEN = isset($_REQUEST['IDE_EJECUTORA_ORIGEN']) ? VerificarInputs($_REQUEST['IDE_EJECUTORA_ORIGEN']) : "";
        $IDE_DS_INCORP_ORIGEN = isset($_REQUEST['IDE_DS_INCORP_ORIGEN']) ? VerificarInputs($_REQUEST['IDE_DS_INCORP_ORIGEN']) : "";
        $IDE_EJECUTORA_DESTINO = isset($_REQUEST['IDE_EJECUTORA_DESTINO']) ? VerificarInputs($_REQUEST['IDE_EJECUTORA_DESTINO']) : "";
        $IDE_DS_INCORP_DESTINO = isset($_REQUEST['IDE_DS_INCORP_DESTINO']) ? VerificarInputs($_REQUEST['IDE_DS_INCORP_DESTINO']) : "";
        $EST_INTERV_CAMBIO_EJEC = isset($_REQUEST['EST_INTERV_CAMBIO_EJEC']) ? VerificarInputs($_REQUEST['EST_INTERV_CAMBIO_EJEC']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        
        
        
/***EDGAR---************** DEFINE DATOS DEL PLAN_INTERVENCION ****/
        $ScriptFLX = " AND T.IDE_PLAN_INTERVENCION=$PIDE_PLAN_INTERVENCION";
        $IDE_PLAN_INTERVENCION = $PIDE_PLAN_INTERVENCION; /* añadido por julio meza */

        $VDES_ENTIDAD = $VCOD_NORMATIVA = null;
        $campos = "  COD_ARCC,  DES_INTERVENCION, IDE_ENTIDAD, IDE_DS_INCORPORACION ";
        $filtro = " AND IDE_PLAN_INTERVENCION = '$PIDE_PLAN_INTERVENCION'";
            $data = VIS_SelCampos ('PLAN_INTERVENCION',$campos,$filtro) ;
            
        $campos = "IDE_ENTIDAD, DES_ENTIDAD";
        $filtro = " AND IDE_ENTIDAD='".$data[0]->IDE_ENTIDAD."'"; 
            $data_1 = VIS_SelCampos ('GEN_ENTIDAD',$campos,$filtro) ;
            
        $campos = "IDE_NORMATIVA,COD_NORMATIVA";
        $filtro = " AND IDE_NORMATIVA='".$data[0]->IDE_DS_INCORPORACION."'";
            $data_2 = VIS_SelCampos ('GEN_NORMATIVA',$campos,$filtro) ;         //   var_dump($data_2); 
        
//        if (count($data_1)>0) { $VDES_ENTIDAD = $data_1[0]->DES_ENTIDAD;        } 
//        if (count($data_2)>0) { $VCOD_NORMATIVA = $data_2[0]->COD_NORMATIVA;    }
        $lCollection->Add('VDES_INTERVENCION', $data[0]->DES_INTERVENCION);
        $lCollection->Add('VCOD_ARCC', $data[0]->COD_ARCC);
        $lCollection->Add('VIDE_ENTIDAD', $data[0]->IDE_ENTIDAD);
        $lCollection->Add('VIDE_DS_INCORPORACION', $data[0]->IDE_DS_INCORPORACION);
        $lCollection->Add('VDES_ENTIDAD',   ( count($data_1)>0 ? $data_1[0]->DES_ENTIDAD : null )       );
        $lCollection->Add('VCOD_NORMATIVA', ( count($data_2)>0 ? $data_2[0]->COD_NORMATIVA : null )     );      
/***EDGAR---**************/          
            
            
        
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PLAN_INTERV_CAMBIO_EJECUTORA_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'EJECUTORA_DESTINO') {
                        $_POST['qtype'] = 'RTRIM(UEJD.DES_ENTIDAD)';
                    }
                    if ($_POST['qtype'] == 'DS_INCORP_DESTINO') {
                        $_POST['qtype'] = 'NORD.COD_NORMATIVA';
                    }
                    if ($_POST['qtype'] == 'EJECUTORA_ORIGEN') {
                        $_POST['qtype'] = 'RTRIM(UEJO.DES_ENTIDAD)';
                    }
                    if ($_POST['qtype'] == 'NORMATIVA_ORIGEN') {
                        $_POST['qtype'] = 'NORO.COD_NORMATIVA';
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
            $ogridDAO->Count_PLAN_INTERV_CAMBIO_EJECUTORA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_INTERV_CAMBIO_EJEC;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PLAN_INTERV_CAMBIO_EJECUTORA', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PLAN_INTERV_CAMBIO_EJECUTORAM = array();
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO = new PLAN_INTERV_CAMBIO_EJECUTORA_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PLAN_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_PLAN_INTERVENCION'] = $IDE_PLAN_INTERVENCION;
            }
            if (strlen(rtrim($IDE_EJECUTORA_ORIGEN)) > 0) {
                $lstparametrosM['IDE_EJECUTORA_ORIGEN'] = $IDE_EJECUTORA_ORIGEN;
            }
            if (strlen(rtrim($IDE_DS_INCORP_ORIGEN)) > 0) {
                $lstparametrosM['IDE_DS_INCORP_ORIGEN'] = $IDE_DS_INCORP_ORIGEN;
            }
            if (strlen(rtrim($IDE_EJECUTORA_DESTINO)) > 0) {
                $lstparametrosM['IDE_EJECUTORA_DESTINO'] = $IDE_EJECUTORA_DESTINO;
            }
            if (strlen(rtrim($IDE_DS_INCORP_DESTINO)) > 0) {
                $lstparametrosM['IDE_DS_INCORP_DESTINO'] = $IDE_DS_INCORP_DESTINO;
            }
            if (strlen(rtrim($EST_INTERV_CAMBIO_EJEC)) > 0) {
                $lstparametrosM['EST_INTERV_CAMBIO_EJEC'] = $EST_INTERV_CAMBIO_EJEC;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PLAN_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_EJECUTORA_ORIGEN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_DS_INCORP_ORIGEN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_EJECUTORA_DESTINO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_DS_INCORP_DESTINO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_INTERV_CAMBIO_EJEC'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO->Insert_PLAN_INTERV_CAMBIO_EJECUTORA($DataSet_PLAN_INTERV_CAMBIO_EJECUTORA, $procedure_parametrosMS); //JCMY

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
            $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA = array();
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO = new PLAN_INTERV_CAMBIO_EJECUTORA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO->SelPk_PLAN_INTERV_CAMBIO_EJECUTORA($DataSet_PLAN_INTERV_CAMBIO_EJECUTORA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PLAN_INTERV_CAMBIO_EJECUTORA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA

                $IDE_PLAN_INTERVENCION = $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA[0]->IDE_PLAN_INTERVENCION;
                $IDE_EJECUTORA_ORIGEN = $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA[0]->IDE_EJECUTORA_ORIGEN;
                $IDE_DS_INCORP_ORIGEN = $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA[0]->IDE_DS_INCORP_ORIGEN;
                $IDE_EJECUTORA_DESTINO = $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA[0]->IDE_EJECUTORA_DESTINO;
                $IDE_DS_INCORP_DESTINO = $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA[0]->IDE_DS_INCORP_DESTINO;
                $EST_INTERV_CAMBIO_EJEC = $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA[0]->EST_INTERV_CAMBIO_EJEC;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PLAN_INTERVENCION', $IDE_PLAN_INTERVENCION);
            $lCollection->Add('IDE_EJECUTORA_ORIGEN', $IDE_EJECUTORA_ORIGEN);
            $lCollection->Add('IDE_DS_INCORP_ORIGEN', $IDE_DS_INCORP_ORIGEN);
            $lCollection->Add('IDE_EJECUTORA_DESTINO', $IDE_EJECUTORA_DESTINO);
            $lCollection->Add('IDE_DS_INCORP_DESTINO', $IDE_DS_INCORP_DESTINO);
            $lCollection->Add('EST_INTERV_CAMBIO_EJEC', $EST_INTERV_CAMBIO_EJEC);
            
/***EDGAR---**************/            
            $campos = "IDE_NORMATIVA,COD_NORMATIVA";
            $filtro = " AND IDE_NORMATIVA='".$IDE_DS_INCORP_ORIGEN."'";
                $data_2 = VIS_SelCampos ('GEN_NORMATIVA',$campos,$filtro) ;    
            $lCollection->Add('VCOD_NORMATIVA', ( count($data_2)>0 ? $data_2[0]->COD_NORMATIVA : null ) );
/***EDGAR---**************/
        }

        
                  
            
        
        // RECUPERANDO VALORES DEL UNIDAD EJECUTORA ORIGEN
            $DataSet_GEN_UE_ORIGEN = array();
            $Objeto_UE_ORIGEN_DAO = new GEN_ENTIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = "IDE_ENTIDAD, DES_ENTIDAD";
            $lstparametrosM['filtro'] = " AND IDE_ENTIDAD='".$IDE_EJECUTORA_ORIGEN."'";            
            $procedure_parametrosMS = array(
                  array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_UE_ORIGEN_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_UE_ORIGEN, $procedure_parametrosMS);            
            $listaContador = count($DataSet_GEN_UE_ORIGEN) > 0 ? true : false; 
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {                

                $DESCRIPCION_EJECUTORA_ORIGEN=$DataSet_GEN_UE_ORIGEN[0]->DES_ENTIDAD;
                $lCollection->Add('DESCRIPCION_EJECUTORA_ORIGEN', $DESCRIPCION_EJECUTORA_ORIGEN);

            }
            
            
            
            // RECUPERANDO VALORES DEL UNIDAD EJECUTORA DESTINO
            $DataSet_GEN_UE_DESTINO = array();
            $Objeto_UE_DESTINO_DAO = new GEN_ENTIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = "IDE_ENTIDAD, DES_ENTIDAD";
            $lstparametrosM['filtro'] = " AND IDE_ENTIDAD='".$IDE_EJECUTORA_DESTINO."'";            
            $procedure_parametrosMS = array(
                  array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_UE_DESTINO_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_UE_DESTINO, $procedure_parametrosMS);            
            $listaContador = count($DataSet_GEN_UE_DESTINO) > 0 ? true : false; 
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) { 
                
                $DESCRIPCION_EJECUTORA_DESTINO=$DataSet_GEN_UE_DESTINO[0]->DES_ENTIDAD;
                $lCollection->Add('DESCRIPCION_EJECUTORA_DESTINO', $DESCRIPCION_EJECUTORA_DESTINO);  
            }
            
        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA = array();
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO = new PLAN_INTERV_CAMBIO_EJECUTORA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PLAN_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_PLAN_INTERVENCION'] = $IDE_PLAN_INTERVENCION;
            }
            if (strlen(rtrim($IDE_EJECUTORA_ORIGEN)) > 0) {
                $lstparametrosM['IDE_EJECUTORA_ORIGEN'] = $IDE_EJECUTORA_ORIGEN;
            }
            if (strlen(rtrim($IDE_DS_INCORP_ORIGEN)) > 0) {
                $lstparametrosM['IDE_DS_INCORP_ORIGEN'] = $IDE_DS_INCORP_ORIGEN;
            }
            if (strlen(rtrim($IDE_EJECUTORA_DESTINO)) > 0) {
                $lstparametrosM['IDE_EJECUTORA_DESTINO'] = $IDE_EJECUTORA_DESTINO;
            }
            if (strlen(rtrim($IDE_DS_INCORP_DESTINO)) > 0) {
                $lstparametrosM['IDE_DS_INCORP_DESTINO'] = $IDE_DS_INCORP_DESTINO;
            }
            if (strlen(rtrim($EST_INTERV_CAMBIO_EJEC)) > 0) {
                $lstparametrosM['EST_INTERV_CAMBIO_EJEC'] = $EST_INTERV_CAMBIO_EJEC;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PLAN_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_EJECUTORA_ORIGEN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_DS_INCORP_ORIGEN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_EJECUTORA_DESTINO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_DS_INCORP_DESTINO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_INTERV_CAMBIO_EJEC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO->Update_PLAN_INTERV_CAMBIO_EJECUTORA($DataSet_PLAN_INTERV_CAMBIO_EJECUTORA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[8][0];

            $mensaje = $procedure_parametrosMS[9][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PLAN_INTERV_CAMBIO_EJECUTORA = array();
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO = new PLAN_INTERV_CAMBIO_EJECUTORA_DAO();
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
            $Objeto_PLAN_INTERV_CAMBIO_EJECUTORA_DAO->Delete_PLAN_INTERV_CAMBIO_EJECUTORA($DataSet_PLAN_INTERV_CAMBIO_EJECUTORA, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_NORMATIVA_1 = array();
        $Objeto_IDE_DS_INCORP_ORIGEN_DAO = new GEN_NORMATIVA_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_NORMATIVA,COD_NORMATIVA";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_DS_INCORP_ORIGEN_DAO->SelCampos_GEN_NORMATIVA($DataSet_GEN_NORMATIVA_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_NORMATIVA_1', $DataSet_GEN_NORMATIVA_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_NORMATIVA_2 = array();
        $Objeto_IDE_DS_INCORP_DESTINO_DAO = new GEN_NORMATIVA_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_NORMATIVA,COD_NORMATIVA";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_DS_INCORP_DESTINO_DAO->SelCampos_GEN_NORMATIVA($DataSet_GEN_NORMATIVA_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_NORMATIVA_2', $DataSet_GEN_NORMATIVA_2);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_INTERV_CAMBIO_EJEC_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='38'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_INTERV_CAMBIO_EJEC_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
/***EDGAR---******************/        
        $lCollection->Add('PIDE_PLAN_INTERVENCION', $PIDE_PLAN_INTERVENCION);
 /***EDGAR---******************/       
    }
}

//var_dump($lstDepartamento);exit;