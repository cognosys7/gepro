<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMP_RECURSOLN de la tabla PROY_COMP_RECURSO
  //  Fecha           : martes, 16 de enero de 2018 03:27:05 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMP_RECURSODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMPONENTEDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_RECURSODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ROLESDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/PROY_COMPONENTElni.php");
require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/PROYECTOlni.php");
//// busqueda
require_once("include/GEN_RECURSOlni.php");
require_once("include/GEN_CARGOlni.php");
require_once("include/GEN_ENTIDADlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_COMP_RECURSO";
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
        $IDE_RECURSO="";
        $DESCRIPCIONRECURSO = "";        

        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";


        $PIDE_PROY_COMPONENTE= isset($_REQUEST['PIDE_PROY_COMPONENTE']) ? VerificarInputs($_REQUEST['PIDE_PROY_COMPONENTE']) : "";
        
        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PROY_COMPONENTE = isset($_REQUEST['IDE_PROY_COMPONENTE']) ? VerificarInputs($_REQUEST['IDE_PROY_COMPONENTE']) : "";
        $IDE_RECURSO = isset($_REQUEST['IDE_RECURSO']) ? VerificarInputs($_REQUEST['IDE_RECURSO']) : "";
        $IDE_ROL = isset($_REQUEST['IDE_ROL']) ? VerificarInputs($_REQUEST['IDE_ROL']) : "";
        $EST_PROY_COMP_REC = isset($_REQUEST['EST_PROY_COMP_REC']) ? VerificarInputs($_REQUEST['EST_PROY_COMP_REC']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR


        $ScriptFLX = " AND  PCR.IDE_PROY_COMPONENTE=$PIDE_PROY_COMPONENTE";



        $DataSet_PROY_COMPONENTE_1 = array();
        $Objeto_IDE_PROY_COMPONENTE_DAO = new PROY_COMPONENTE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONVOCATORIA,COD_ITEM,SEC_EJEC,DES_ENTIDAD,UPPER(DES_INTERVENCION) AS DES_INTERVENCION,DES_PROYECTO,DES_COMPONENTE,DES_CARTERA,DES_ESTADO,CONVERT(varchar(10), FEC_INICIO_CONTRATO, 103) as FEC_INICIO_CONTRATO, CONVERT(varchar(10), FEC_TERMINO_CONTRATO, 103) as FEC_TERMINO_CONTRATO, IMP_COMPONENTE";
        $lstparametrosM['filtro'] = " AND PC.IDE_PROY_COMPONENTE = '$PIDE_PROY_COMPONENTE'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_PROY_COMPONENTE_DAO->SelCampos_PROY_COMPONENTE2($DataSet_PROY_COMPONENTE_1, $procedure_parametrosMS);
        $VIDE_CONVOCATORIA = $DataSet_PROY_COMPONENTE_1[0]->IDE_CONVOCATORIA;
        $lCollection->Add('VIDE_CONVOCATORIA', $VIDE_CONVOCATORIA);
        $VCOD_ITEM = $DataSet_PROY_COMPONENTE_1[0]->COD_ITEM;
        $lCollection->Add('VCOD_ITEM', $VCOD_ITEM);
        $VSEC_EJEC = $DataSet_PROY_COMPONENTE_1[0]->SEC_EJEC;
        $lCollection->Add('VSEC_EJEC', $VSEC_EJEC);
        $VDES_ENTIDAD = $DataSet_PROY_COMPONENTE_1[0]->DES_ENTIDAD;
        $lCollection->Add('VDES_ENTIDAD', $VDES_ENTIDAD);
        $VDES_INTERVENCION = $DataSet_PROY_COMPONENTE_1[0]->DES_INTERVENCION;
        $lCollection->Add('VDES_INTERVENCION', $VDES_INTERVENCION);
        $VDES_PROYECTO = $DataSet_PROY_COMPONENTE_1[0]->DES_PROYECTO;
        $lCollection->Add('VDES_PROYECTO', $VDES_PROYECTO);
        $VDES_COMPONENTE = $DataSet_PROY_COMPONENTE_1[0]->DES_COMPONENTE;
        $lCollection->Add('VDES_COMPONENTE', $VDES_COMPONENTE);
        $VDES_CARTERA = $DataSet_PROY_COMPONENTE_1[0]->DES_CARTERA;
        $lCollection->Add('VDES_CARTERA', $VDES_CARTERA);
        $VDES_ESTADO = $DataSet_PROY_COMPONENTE_1[0]->DES_ESTADO;
        $lCollection->Add('VDES_ESTADO', $VDES_ESTADO);
        $VFEC_INICIO_CONTRATO = $DataSet_PROY_COMPONENTE_1[0]->FEC_INICIO_CONTRATO;
        $lCollection->Add('VFEC_INICIO_CONTRATO', $VFEC_INICIO_CONTRATO);
        $VFEC_TERMINO_CONTRATO = $DataSet_PROY_COMPONENTE_1[0]->FEC_TERMINO_CONTRATO;
        $lCollection->Add('VFEC_TERMINO_CONTRATO', $VFEC_TERMINO_CONTRATO);
        $VIMP_COMPONENTE = $DataSet_PROY_COMPONENTE_1[0]->IMP_COMPONENTE;
        $lCollection->Add('VIMP_COMPONENTE', $VIMP_COMPONENTE);



        /* EDGAR */
        $Data11 = ProyectoComponente_Datos($PIDE_PROY_COMPONENTE);
        $Data12 = ProyectoActividad_Datos($Data11['IDE_PROYECTO_ACTIVIDAD']); //echo $PIDE_PROY_COMPONENTE.'-'.$Data11['IDE_PROYECTO_ACTIVIDAD'].'-'.$Data12['IDE_PROYECTO'];exit;
        $lCollection->Add('VCOD_PROYECTO', $Data12['COD_PROYECTO'] );
        
        $lCollection->Add('VIDE_PROYECTO', $Data12['IDE_PROYECTO'] );
	/* EDGAR */
            
            
  
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_COMP_RECURSO_DAO();
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
            $ogridDAO->Count_PROY_COMP_RECURSO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROY_COMP_REC;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_COMP_RECURSO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROY_COMP_RECURSOM = array();
            $Objeto_PROY_COMP_RECURSO_DAO = new PROY_COMP_RECURSO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
            }
            if (strlen(rtrim($IDE_RECURSO)) > 0) {
                $lstparametrosM['IDE_RECURSO'] = $IDE_RECURSO;
            }
            if (strlen(rtrim($IDE_ROL)) > 0) {
                $lstparametrosM['IDE_ROL'] = $IDE_ROL;
            }
            if (strlen(rtrim($EST_PROY_COMP_REC)) > 0) {
                $lstparametrosM['EST_PROY_COMP_REC'] = $EST_PROY_COMP_REC;
            }

            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_RECURSO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ROL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROY_COMP_REC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMP_RECURSO_DAO->Insert_PROY_COMP_RECURSO($DataSet_PROY_COMP_RECURSO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[5][0];

            $mensaje = $procedure_parametrosMS[6][0];

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
            $DataSet_PROY_COMP_RECURSO = array();
            $Objeto_PROY_COMP_RECURSO_DAO = new PROY_COMP_RECURSO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_COMP_RECURSO_DAO->SelPk_PROY_COMP_RECURSO($DataSet_PROY_COMP_RECURSO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_COMP_RECURSO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_COMP_RECURSO

                $IDE_PROY_COMPONENTE = $DataSet_PROY_COMP_RECURSO[0]->IDE_PROY_COMPONENTE;
                $IDE_RECURSO = $DataSet_PROY_COMP_RECURSO[0]->IDE_RECURSO;
                $IDE_ROL = $DataSet_PROY_COMP_RECURSO[0]->IDE_ROL;
                $EST_PROY_COMP_REC = $DataSet_PROY_COMP_RECURSO[0]->EST_PROY_COMP_REC;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROY_COMPONENTE', $IDE_PROY_COMPONENTE);
            $lCollection->Add('IDE_RECURSO', $IDE_RECURSO);
            $lCollection->Add('IDE_ROL', $IDE_ROL);
            $lCollection->Add('EST_PROY_COMP_REC', $EST_PROY_COMP_REC);

            
            /* BUSCANDO LOS DATOS DEL RECURSO */            
            $DataSet_GEN_RECURSO_1 = array();
            $Objeto_IDE_RECURSO_DAO = new GEN_RECURSO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
            $lstparametrosM['filtro'] = "";
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
            );
            $Objeto_IDE_RECURSO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_1, $procedure_parametrosMS);
            $lCollection->Add('DataSet_GEN_RECURSO_1', $DataSet_GEN_RECURSO_1);
            $listaContador = count($DataSet_GEN_RECURSO_1) > 0 ? true : false;
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                $DES_RECURSO=$DataSet_GEN_RECURSO_1[0]->DES_RECURSO;                
            }
            $DESCRIPCIONRECURSO = $DES_RECURSO;
            $lCollection->Add('DESCRIPCIONRECURSO', $DESCRIPCIONRECURSO);     
            
            
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data = Recurso_Datos($IDE_RECURSO);
            $Data1 = Entidad_Datos($Data['IDE_ENTIDAD']);
            
            $Bdescripcion = $Data['DES_RECURSO'] .' [ '. $Data1['DES_ENTIDAD'] .' ( RUC: '. $Data1['COD_RUC'] .' ) ]' ;
            
            $lCollection->Add('DESCRIPCIONRECURSO', $Bdescripcion);
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_COMP_RECURSO = array();
            $Objeto_PROY_COMP_RECURSO_DAO = new PROY_COMP_RECURSO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
            }
            if (strlen(rtrim($IDE_RECURSO)) > 0) {
                $lstparametrosM['IDE_RECURSO'] = $IDE_RECURSO;
            }
            if (strlen(rtrim($IDE_ROL)) > 0) {
                $lstparametrosM['IDE_ROL'] = $IDE_ROL;
            }
            if (strlen(rtrim($EST_PROY_COMP_REC)) > 0) {
                $lstparametrosM['EST_PROY_COMP_REC'] = $EST_PROY_COMP_REC;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_RECURSO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ROL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROY_COMP_REC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMP_RECURSO_DAO->Update_PROY_COMP_RECURSO($DataSet_PROY_COMP_RECURSO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[6][0];

            $mensaje = $procedure_parametrosMS[7][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_COMP_RECURSO = array();
            $Objeto_PROY_COMP_RECURSO_DAO = new PROY_COMP_RECURSO_DAO();
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
            $Objeto_PROY_COMP_RECURSO_DAO->Delete_PROY_COMP_RECURSO($DataSet_PROY_COMP_RECURSO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_RECURSO_1 = array();
        $Objeto_IDE_RECURSO_DAO = new GEN_RECURSO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_RECURSO,DES_RECURSO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_RECURSO_DAO->SelCampos_GEN_RECURSO($DataSet_GEN_RECURSO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_RECURSO_1', $DataSet_GEN_RECURSO_1);

        /* 					 */

        $DataSet_GEN_ROLES_1 = array();
        $Objeto_IDE_ROL_DAO = new GEN_ROLES_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ROL,DES_ROL";
        $lstparametrosM['filtro'] = " AND IDE_FASE = '18'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ROL_DAO->SelCampos_GEN_ROLES($DataSet_GEN_ROLES_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ROLES_1', $DataSet_GEN_ROLES_1);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_PROY_COMP_REC_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROY_COMP_REC_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        $lCollection->Add('PIDE_PROY_COMPONENTE', $PIDE_PROY_COMPONENTE);
        
    /* EDGAR */
	$lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;