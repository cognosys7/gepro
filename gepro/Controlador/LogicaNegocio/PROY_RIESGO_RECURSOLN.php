<?php
  /********************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_RIESGO_RECURSOLN de la tabla PROY_RIESGO_RECURSO
  //  Fecha           : domingo, 24 de junio de 2018 20:44:02
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_RIESGO_RECURSODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROYECTO_ACTIVIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/PROY_RIESGO_PROBLEMADAO.php");


/* EDGAR */
require_once("include/LNinclude.php");

//// busqueda
require_once("include/GEN_RECURSOlni.php");
require_once("include/GEN_CARGOlni.php");
require_once("include/GEN_ENTIDADlni.php");
require_once("include/CONT_INTERESADOSlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_RIESGO_RECURSO";
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

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $PIDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) : "";
        $PIDE_RIESGO_PROB = isset($_REQUEST['PIDE_RIESGO_PROB']) ? VerificarInputs($_REQUEST['PIDE_RIESGO_PROB']) : "";
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_RIESGO_PROB = isset($_REQUEST['IDE_RIESGO_PROB']) ? VerificarInputs($_REQUEST['IDE_RIESGO_PROB']) : "";
        $IDE_RECURSO = isset($_REQUEST['IDE_RECURSO']) ? VerificarInputs($_REQUEST['IDE_RECURSO']) : "";
        $EST_RECURSO_RIESGO = isset($_REQUEST['EST_RECURSO_RIESGO']) ? VerificarInputs($_REQUEST['EST_RECURSO_RIESGO']) : "";
        /* FLEXIGRID */                
        
        $DataSet_PROYECTO_ACTIVIDAD_1 = array();
        $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = " IDE_ENTIDAD_EJECUTORA, P.IDE_INTERVENCION, SEC_EJEC, DES_ENTIDAD, COD_PROYECTO, DES_PROYECTO_ITEM, IMP_COSTO_ACTUAL";
        $lstparametrosM['filtro'] = " AND P.IDE_PROYECTO_ACTIVIDAD = '$PIDE_PROYECTO_ACTIVIDAD'";        
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)        );
        $Objeto_IDE_PROYECTO_ACTIVIDAD_DAO->SelCampos_PROYECTO_ACTIVIDAD2($DataSet_PROYECTO_ACTIVIDAD_1, $procedure_parametrosMS);
        $VIDE_ENTIDAD_EJECUTORA = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IDE_ENTIDAD_EJECUTORA;
        $lCollection->Add('VIDE_ENTIDAD_EJECUTORA', $VIDE_ENTIDAD_EJECUTORA);        
        $VIDE_INTERVENCION = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IDE_INTERVENCION;
        $lCollection->Add('VIDE_INTERVENCION', $VIDE_INTERVENCION);        
        $VSEC_EJEC = $DataSet_PROYECTO_ACTIVIDAD_1[0]->SEC_EJEC;
        $lCollection->Add('VSEC_EJEC', $VSEC_EJEC);
        $VDES_ENTIDAD = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_ENTIDAD;
        $lCollection->Add('VDES_ENTIDAD', $VDES_ENTIDAD);
        $VCOD_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD_1[0]->COD_PROYECTO;
        $lCollection->Add('VCOD_PROYECTO', $VCOD_PROYECTO);
        $VDES_PROYECTO_ITEM = $DataSet_PROYECTO_ACTIVIDAD_1[0]->DES_PROYECTO_ITEM;
        $lCollection->Add('VDES_PROYECTO_ITEM', $VDES_PROYECTO_ITEM);
        $VIMP_COSTO_ACTUAL = $DataSet_PROYECTO_ACTIVIDAD_1[0]->IMP_COSTO_ACTUAL;
        $lCollection->Add('VIMP_COSTO_ACTUAL', $VIMP_COSTO_ACTUAL);
        
        /*OBTENIENDO EL NOMBRE DEL RIESGO*/
        $DataSet_PROY_RIESGO_PROBLEMA_1    = array(); 
        $Objeto_IDE_RIESGO_PROB_DAO  	    = new PROY_RIESGO_PROBLEMA_DAO();
        $lstparametrosM = array();   
        $lstparametrosM['campos'] = " DES_NOMBRE ";
        $lstparametrosM['filtro'] = " AND IDE_RIESGO_PROB=$PIDE_RIESGO_PROB";
        $procedure_parametrosMS = array(                  
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                ,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_RIESGO_PROB_DAO ->SelCampos_PROY_RIESGO_PROBLEMA($DataSet_PROY_RIESGO_PROBLEMA_1,$procedure_parametrosMS);       
        $DES_NOMBRE = $DataSet_PROY_RIESGO_PROBLEMA_1[0]->DES_NOMBRE;
        $lCollection->Add('DES_NOMBRE', $DES_NOMBRE);     
        
        
        
        
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = " AND R.IDE_RIESGO_PROB=$PIDE_RIESGO_PROB"; // AND P1.IdProveedor = $fIdProveedor;
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_RIESGO_RECURSO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_RECURSO') {
                        $_POST['qtype'] = 'GR.DES_RECURSO';
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
            $ogridDAO->Count_PROY_RIESGO_RECURSO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_RECURSO_RIESGO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_RIESGO_RECURSO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }


        
        
        /* EDGAR ******************************************************************
        *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
        /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data = Interesados_Datos($PIDEbuscado);
            $BIDE = $Data['BIDE'] ;
            
            $Data1 = Recurso_Datos($Data['IDE_RECURSO']);
            $Data2 = Cargo_Datos($Data['IDE_PUESTO']);
            
            $Bdescripcion = $Data1['DES_RECURSO'] .' ( '. $Data2['DES_CARGO'] .' ) ' ;
            
            $lCollection->Add('BIDE', $BIDE);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*******************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
        /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROY_RIESGO_RECURSOM = array();
            $Objeto_PROY_RIESGO_RECURSO_DAO = new PROY_RIESGO_RECURSO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_RIESGO_PROB)) > 0) {
                $lstparametrosM['IDE_RIESGO_PROB'] = $IDE_RIESGO_PROB;
            }
            if (strlen(rtrim($IDE_RECURSO)) > 0) {
                $lstparametrosM['IDE_RECURSO'] = $IDE_RECURSO;
            }
            if (strlen(rtrim($EST_RECURSO_RIESGO)) > 0) {
                $lstparametrosM['EST_RECURSO_RIESGO'] = $EST_RECURSO_RIESGO;
            }

            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_RIESGO_PROB'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_RECURSO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_RECURSO_RIESGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_RIESGO_RECURSO_DAO->Insert_PROY_RIESGO_RECURSO($DataSet_PROY_RIESGO_RECURSO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[4][0];

            $mensaje = $procedure_parametrosMS[5][0];

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
            $DataSet_PROY_RIESGO_RECURSO = array();
            $Objeto_PROY_RIESGO_RECURSO_DAO = new PROY_RIESGO_RECURSO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_RIESGO_RECURSO_DAO->SelPk_PROY_RIESGO_RECURSO($DataSet_PROY_RIESGO_RECURSO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_RIESGO_RECURSO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_RIESGO_RECURSO

                $IDE_RIESGO_PROB = $DataSet_PROY_RIESGO_RECURSO[0]->IDE_RIESGO_PROB;
                $IDE_RECURSO = $DataSet_PROY_RIESGO_RECURSO[0]->IDE_RECURSO;
                $EST_RECURSO_RIESGO = $DataSet_PROY_RIESGO_RECURSO[0]->EST_RECURSO_RIESGO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_RIESGO_PROB', $IDE_RIESGO_PROB);
            $lCollection->Add('IDE_RECURSO', $IDE_RECURSO);
            $lCollection->Add('EST_RECURSO_RIESGO', $EST_RECURSO_RIESGO);
            
            
            
            /* EDGAR - recuperar datos de la consulta*/
//            $Data11 = Interesados_Datos($IDE_RECURSO);
//            $BIDE = $Data11['BIDE'] ;

            $Data111 = Recurso_Datos($IDE_RECURSO);
            //$Data112 = Cargo_Datos($Data11['IDE_PUESTO']);

            //$Bdescripcion = $IDE_RECURSO.$Data111['DES_RECURSO'] .' ( '. $Data112['DES_CARGO'] .' ) ' ;
            $Bdescripcion = $Data111['DES_RECURSO']  ;

//            $lCollection->Add('BIDE', $BIDE);
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
            $DataSet_PROY_RIESGO_RECURSO = array();
            $Objeto_PROY_RIESGO_RECURSO_DAO = new PROY_RIESGO_RECURSO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_RIESGO_PROB)) > 0) {
                $lstparametrosM['IDE_RIESGO_PROB'] = $IDE_RIESGO_PROB;
            }
            if (strlen(rtrim($IDE_RECURSO)) > 0) {
                $lstparametrosM['IDE_RECURSO'] = $IDE_RECURSO;
            }
            if (strlen(rtrim($EST_RECURSO_RIESGO)) > 0) {
                $lstparametrosM['EST_RECURSO_RIESGO'] = $EST_RECURSO_RIESGO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_RIESGO_PROB'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_RECURSO_RIESGO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_RIESGO_RECURSO_DAO->Update_PROY_RIESGO_RECURSO($DataSet_PROY_RIESGO_RECURSO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[5][0];

            $mensaje = $procedure_parametrosMS[6][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_RIESGO_RECURSO = array();
            $Objeto_PROY_RIESGO_RECURSO_DAO = new PROY_RIESGO_RECURSO_DAO();
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
            $Objeto_PROY_RIESGO_RECURSO_DAO->Delete_PROY_RIESGO_RECURSO($DataSet_PROY_RIESGO_RECURSO, $procedure_parametrosMS); //JCMY
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
        $DataSet_GEN_RECURSO_1 = array();
        $Objeto_IDE_RECURSO_DAO = new GEN_RECURSO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
        $lstparametrosM['filtro'] = " AND EST_RECURSO <> '2'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_RECURSO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_RECURSO_1', $DataSet_GEN_RECURSO_1);


        /* 					 */
        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_RECURSO_RIESGO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_EST_RECURSO_RIESGO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);        
        $lCollection->Add('PIDE_PROYECTO_ACTIVIDAD', $PIDE_PROYECTO_ACTIVIDAD);
        $lCollection->Add('PIDE_RIESGO_PROB', $PIDE_RIESGO_PROB);
    
    /* EDGAR */
	$lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    /* EDGAR */


    }
}

//var_dump($lstDepartamento);exit;