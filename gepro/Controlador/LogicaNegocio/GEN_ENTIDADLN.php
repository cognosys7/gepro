<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ENTIDADLN de la tabla GEN_ENTIDAD
  //  Fecha           : miércoles, 1 de noviembre de 2017 15:50:31
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_SECTORDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_ENTIDAD";
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
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";
        
        /****************** UNIDAD EJECUTORA PLANIFICACION PARA INTERVENCIONES ARCCC***************************** */
        $PIDE_ENTIDAD= isset($_REQUEST['PIDE_ENTIDAD'])? VerificarInputs($_REQUEST['PIDE_ENTIDAD']) : "";

       
        /******************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_ENTIDAD_SUP = isset($_REQUEST['IDE_ENTIDAD_SUP']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD_SUP']) : "";
        $IDE_SECTOR = isset($_REQUEST['IDE_SECTOR']) ? VerificarInputs($_REQUEST['IDE_SECTOR']) : "";
        $COD_RUC = isset($_REQUEST['COD_RUC']) ? VerificarInputs($_REQUEST['COD_RUC']) : "";
        $DES_ENTIDAD = isset($_REQUEST['DES_ENTIDAD']) ? VerificarInputs($_REQUEST['DES_ENTIDAD']) : "";
        $TIP_ENTIDAD = isset($_REQUEST['TIP_ENTIDAD']) ? VerificarInputs($_REQUEST['TIP_ENTIDAD']) : "";
        $NUM_NIVEL = isset($_REQUEST['NUM_NIVEL']) ? VerificarInputs($_REQUEST['NUM_NIVEL']) : "";
        $EST_ENTIDAD = isset($_REQUEST['EST_ENTIDAD']) ? VerificarInputs($_REQUEST['EST_ENTIDAD']) : "";
        $SEC_EJEC = isset($_REQUEST['SEC_EJEC']) ? VerificarInputs($_REQUEST['SEC_EJEC']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_ENTIDAD_DAO();
            $Prueba = "ActionFlex";
            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {
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
            $ogridDAO->Count_GEN_ENTIDAD($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_ENTIDAD;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_ENTIDAD', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }
        
        /************** PARA BUSCAR LA UNIDAD EJECUTORA    *************/
        if ($Action == "PasarDatos") {
            $DataSet_GEN_ENTIDAD = array();
            $Objeto_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = " IDE_ENTIDAD, DES_ENTIDAD, COD_UBIGEO, TIP_GOBIERNO, DES_UBIGEO ";
            $lstparametrosM['filtro'] = " AND IDE_ENTIDAD='".$PIDE_ENTIDAD."'";            
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_ENTIDAD_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD, $procedure_parametrosMS);            
            $listaContador = count($DataSet_GEN_ENTIDAD) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            $IDE_ENTIDAD = $DES_ENTIDAD = $COD_UBIGEO = $TIP_GOBIERNO = $DES_UBIGEO = '';
            if (($listaContador == true) || ($listaContador > 0)) {
                $IDE_ENTIDAD=$DataSet_GEN_ENTIDAD[0]->IDE_ENTIDAD;
                $DES_ENTIDAD=$DataSet_GEN_ENTIDAD[0]->DES_ENTIDAD;
                $COD_UBIGEO=$DataSet_GEN_ENTIDAD[0]->COD_UBIGEO;
                $DES_UBIGEO=$DataSet_GEN_ENTIDAD[0]->DES_UBIGEO;
                $TIP_GOBIERNO=$DataSet_GEN_ENTIDAD[0]->TIP_GOBIERNO;
            }
            $lCollection->Add('IDE_ENTIDAD', $IDE_ENTIDAD);
            $lCollection->Add('DES_ENTIDAD', $DES_ENTIDAD);   
            $lCollection->Add('COD_UBIGEO', $COD_UBIGEO); 
            $lCollection->Add('DES_UBIGEO', $DES_UBIGEO); 
            $lCollection->Add('TIP_GOBIERNO', $TIP_GOBIERNO); 
//            var_dump($lCollection);
//            die;
        }

        
        

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */                         
             if (strlen(rtrim($IDE_SECTOR)) > 0)  {	
                    $lstparametrosM['IDE_SECTOR'] 		= $IDE_SECTOR;
             }	
             if (strlen(rtrim($COD_RUC)) > 0)  {	
                    $lstparametrosM['COD_RUC'] 		= $COD_RUC;
             }	
             if (strlen(rtrim($DES_ENTIDAD)) > 0)  {	
                    $lstparametrosM['DES_ENTIDAD'] 		= $DES_ENTIDAD;
             }	
             if (strlen(rtrim($TIP_ENTIDAD)) > 0)  {	
                    $lstparametrosM['TIP_ENTIDAD'] 		= $TIP_ENTIDAD;
             }	
             if (strlen(rtrim($NUM_NIVEL)) > 0)  {	
                    $lstparametrosM['NUM_NIVEL'] 		= $NUM_NIVEL;
             }	
             if (strlen(rtrim($EST_ENTIDAD)) > 0)  {	
                    $lstparametrosM['EST_ENTIDAD'] 		= $EST_ENTIDAD;
             }	
             if (strlen(rtrim($SEC_EJEC)) > 0)  {	
                    $lstparametrosM['SEC_EJEC'] 		= $SEC_EJEC;
             }	
            /* FIN DE ACTIVACION */

            $DataSet_GEN_ENTIDADM = array();
            $Objeto_GEN_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();
            $lstparametrosM = array();            
            $lstparametrosM['IDE_SECTOR'] = $IDE_SECTOR;
            $lstparametrosM['COD_RUC'] = $COD_RUC;
            $lstparametrosM['DES_ENTIDAD'] = $DES_ENTIDAD;
            $lstparametrosM['TIP_ENTIDAD'] = $TIP_ENTIDAD;
            $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            $lstparametrosM['EST_ENTIDAD'] = $EST_ENTIDAD;
            $lstparametrosM['SEC_EJEC'] = $SEC_EJEC;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(                
                array(&$lstparametrosM['IDE_SECTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_RUC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ENTIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_ENTIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ENTIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['SEC_EJEC'], SQLSRV_PARAM_IN), 
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ENTIDAD_DAO->Insert_GEN_ENTIDAD($DataSet_GEN_ENTIDAD, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[8][0];

            $mensaje = $procedure_parametrosMS[9][0];

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
            $DataSet_GEN_ENTIDAD = array();
            $Objeto_GEN_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_ENTIDAD_DAO->SelPk_GEN_ENTIDAD($DataSet_GEN_ENTIDAD, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_ENTIDAD) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_ENTIDAD

                $IDE_ENTIDAD_SUP = $DataSet_GEN_ENTIDAD[0]->IDE_ENTIDAD_SUP;
                $IDE_SECTOR = $DataSet_GEN_ENTIDAD[0]->IDE_SECTOR;
                $COD_RUC = $DataSet_GEN_ENTIDAD[0]->COD_RUC;
                $DES_ENTIDAD = $DataSet_GEN_ENTIDAD[0]->DES_ENTIDAD;
                $TIP_ENTIDAD = $DataSet_GEN_ENTIDAD[0]->TIP_ENTIDAD;
                $NUM_NIVEL = $DataSet_GEN_ENTIDAD[0]->NUM_NIVEL;
                $EST_ENTIDAD = $DataSet_GEN_ENTIDAD[0]->EST_ENTIDAD;
                $SEC_EJEC = $DataSet_GEN_ENTIDAD[0]->SEC_EJEC;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_ENTIDAD_SUP', $IDE_ENTIDAD_SUP);
            $lCollection->Add('IDE_SECTOR', $IDE_SECTOR);
            $lCollection->Add('COD_RUC', $COD_RUC);
            $lCollection->Add('DES_ENTIDAD', $DES_ENTIDAD);
            $lCollection->Add('TIP_ENTIDAD', $TIP_ENTIDAD);
            $lCollection->Add('NUM_NIVEL', $NUM_NIVEL);
            $lCollection->Add('EST_ENTIDAD', $EST_ENTIDAD);
            $lCollection->Add('SEC_EJEC', $SEC_EJEC);
        }
        
        
        

        
        
        
        /* *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */             
             if (strlen(rtrim($IDE_SECTOR)) > 0)  {	
                    $lstparametrosM['IDE_SECTOR'] 		= $IDE_SECTOR;
             }	
             if (strlen(rtrim($COD_RUC)) > 0)  {	
                    $lstparametrosM['COD_RUC'] 		= $COD_RUC;
             }	
             if (strlen(rtrim($DES_ENTIDAD)) > 0)  {	
                    $lstparametrosM['DES_ENTIDAD'] 		= $DES_ENTIDAD;
             }	
             if (strlen(rtrim($TIP_ENTIDAD)) > 0)  {	
                    $lstparametrosM['TIP_ENTIDAD'] 		= $TIP_ENTIDAD;
             }	
             if (strlen(rtrim($NUM_NIVEL)) > 0)  {	
                    $lstparametrosM['NUM_NIVEL'] 		= $NUM_NIVEL;
             }	
             if (strlen(rtrim($EST_ENTIDAD)) > 0)  {	
                    $lstparametrosM['EST_ENTIDAD'] 		= $EST_ENTIDAD;
             }	
             if (strlen(rtrim($SEC_EJEC)) > 0)  {	
                    $lstparametrosM['SEC_EJEC'] 		= $SEC_EJEC;
             }	
            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_ENTIDAD = array();
            $Objeto_GEN_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;            
            $lstparametrosM['IDE_SECTOR'] = $IDE_SECTOR;
            $lstparametrosM['COD_RUC'] = $COD_RUC;
            $lstparametrosM['DES_ENTIDAD'] = $DES_ENTIDAD;
            $lstparametrosM['TIP_ENTIDAD'] = $TIP_ENTIDAD;
            $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            $lstparametrosM['EST_ENTIDAD'] = $EST_ENTIDAD;
            $lstparametrosM['SEC_EJEC'] = $SEC_EJEC;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)                
                , array(&$lstparametrosM['IDE_SECTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_RUC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ENTIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_ENTIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ENTIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['SEC_EJEC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ENTIDAD_DAO->Update_GEN_ENTIDAD($DataSet_GEN_ENTIDAD, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[9][0];

            $mensaje = $procedure_parametrosMS[10][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_ENTIDAD = array();
            $Objeto_GEN_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();
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
            $Objeto_GEN_ENTIDAD_DAO->Delete_GEN_ENTIDAD($DataSet_GEN_ENTIDAD, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_SECTOR = array();
        $Objeto_IDE_SECTOR_DAO = new GEN_SECTOR_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_SECTOR,DES_SECTOR";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_SECTOR_DAO->SelCampos_GEN_SECTOR($DataSet_GEN_SECTOR, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_SECTOR', $DataSet_GEN_SECTOR);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_ENTIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '6'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_ENTIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */
        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS = array();
        $Objeto_EST_ENTIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ENTIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS', $DataSet_GEN_TABLAS);

        /* 					 */
        
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    }
}

//var_dump($lstDepartamento);exit;