<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : PROYECTO_ACTIVIDADLN de la tabla PROYECTO_ACTIVIDAD
  //  Fecha           : viernes, 3 de noviembre de 2017 10:20:52
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROYECTO_ACTIVIDADDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/PROYECTOlni.php");
require_once("include/PROCESOlni.php");
require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/CONTRATOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();


    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROYECTO_ACTIVIDAD";
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
    $PermisoOK = VerificaAccesoMenu($Opcionsession, $perfilsession);


    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";

        //EMPLEADO PARA LA GRILLA
        $Opcion = isset($_REQUEST['Opcion']) ? VerificarInputs($_REQUEST['Opcion']) : "";
        $lCollection->Add('Opcion', $Opcion);

        
        /* EDGAR */
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";
        $Pfiltro = isset($_REQUEST['Pfiltro']) ? VerificarInputs($_REQUEST['Pfiltro']) : "";
        $lCollection->Add('Pfiltro', $Pfiltro); //echo 'Pfiltro:'.$Pfiltro; exit;
        /* EDGAR */
        
        
        /** *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PROYECTO = isset($_REQUEST['IDE_PROYECTO']) ? VerificarInputs($_REQUEST['IDE_PROYECTO']) : "";
        $COD_PROYECTO = isset($_REQUEST['COD_PROYECTO']) ? VerificarInputs($_REQUEST['COD_PROYECTO']) : "";
        $IDE_ENTIDAD_EJECUTORA = isset($_REQUEST['IDE_ENTIDAD_EJECUTORA']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD_EJECUTORA']) : "";
        $IDE_PROCESO_ITEM = isset($_REQUEST['IDE_PROCESO_ITEM']) ? VerificarInputs($_REQUEST['IDE_PROCESO_ITEM']) : "";
        $IDE_PRIORIZACION = isset($_REQUEST['IDE_PRIORIZACION']) ? VerificarInputs($_REQUEST['IDE_PRIORIZACION']) : "";
        $IDE_INTERVENCION = isset($_REQUEST['IDE_INTERVENCION']) ? VerificarInputs($_REQUEST['IDE_INTERVENCION']) : "";
        $GRUPO_TIPO_INTERVENCION = isset($_REQUEST['GRUPO_TIPO_INTERVENCION']) ? VerificarInputs($_REQUEST['GRUPO_TIPO_INTERVENCION']) : "";
        $TIP_PROYECTO_ACTIVIDAD = isset($_REQUEST['TIP_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['TIP_PROYECTO_ACTIVIDAD']) : "";
        $DES_PROYECTO = isset($_REQUEST['DES_PROYECTO']) ? VerificarInputs($_REQUEST['DES_PROYECTO']) : "";
        $DES_PROYECTO_ITEM = isset($_REQUEST['DES_PROYECTO_ITEM']) ? VerificarInputs($_REQUEST['DES_PROYECTO_ITEM']) : "";
        $DES_PROYECTO_ABREV = isset($_REQUEST['DES_PROYECTO_ABREV']) ? VerificarInputs($_REQUEST['DES_PROYECTO_ABREV']) : "";        
        $IMP_INVERSION          =   isset($_REQUEST['IMP_INVERSION'])? VerificarInputs($_REQUEST['IMP_INVERSION']) : "";
        $IMP_FINANCIADO          =   isset($_REQUEST['IMP_FINANCIADO'])? VerificarInputs($_REQUEST['IMP_FINANCIADO']) : "";
        $IMP_TRANSFERIDO          =   isset($_REQUEST['IMP_TRANSFERIDO'])? VerificarInputs($_REQUEST['IMP_TRANSFERIDO']) : "";
        $IMP_VALOR_REFERENCIAL          =   isset($_REQUEST['IMP_VALOR_REFERENCIAL'])? VerificarInputs($_REQUEST['IMP_VALOR_REFERENCIAL']) : "";
        $IMP_COSTO_ACTUAL          =   isset($_REQUEST['IMP_COSTO_ACTUAL'])? VerificarInputs($_REQUEST['IMP_COSTO_ACTUAL']) : "";
        $IMP_LIQUIDADO          =   isset($_REQUEST['IMP_LIQUIDADO'])? VerificarInputs($_REQUEST['IMP_LIQUIDADO']) : "";
        $DES_UBICACION = isset($_REQUEST['DES_UBICACION']) ? VerificarInputs($_REQUEST['DES_UBICACION']) : "";
        $GEO_LONGITUD_UBICACION = isset($_REQUEST['GEO_LONGITUD_UBICACION']) ? VerificarInputs($_REQUEST['GEO_LONGITUD_UBICACION']) : "";
        $GEO_LATITUD_UBICACION = isset($_REQUEST['GEO_LATITUD_UBICACION']) ? VerificarInputs($_REQUEST['GEO_LATITUD_UBICACION']) : "";
        $EST_PROYECTO_ACTIVIDAD = isset($_REQUEST['EST_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['EST_PROYECTO_ACTIVIDAD']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;

        
        
        
        /* EDGAR */
       if ( $PIDE>0 ){
//            $ScriptFLX = $ScriptFLX." AND P.IDE_PROYECTO=$PIDE";
            $Data = Proyecto_Datos($PIDE);
            $ScriptFLX = $ScriptFLX." AND P.COD_UNICO='".$Data['COD_UNICO']."'";

            switch ($Pfiltro) {
                case '1': // ESTUDIOS
                    $ScriptFLX .= " AND PRY.IDE_INTERVENCION IN ( 155 , 174 , 161 , 160 , 159 , 152 ) ";
                    break;
                case '2': // OBRAS
                    $ScriptFLX .= " AND PRY.IDE_INTERVENCION IN ( 151 ) ";
                    break;
                case '3': // SUPERVISION
                    $ScriptFLX .= " AND PRY.IDE_INTERVENCION IN ( 153 ) ";
                    break;
                case '4': // POST-CIERRE
                    $ScriptFLX .= " AND PRY.IDE_INTERVENCION IN ( 169 , 163 ) ";
                    break;
                case '5': // OTROS 
                    //$ScriptFLX .= " AND PRY.IDE_INTERVENCION NOT IN ( 155 , 174 , 161 , 160 , 159 , 152 , 151 , 153 , 169 , 163 ) ";
					$ScriptFLX .= " AND ( PRY.IDE_INTERVENCION NOT IN ( 155 , 174 , 161 , 160 , 159 , 152 , 151 , 153 , 169 , 163 ) OR  PRY.IDE_INTERVENCION IS NULL ) ";
                    break;
            }
       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        /* EDGAR */

       
       
        
        
        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROYECTO_ACTIVIDAD_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


//                    if ($_POST['qtype'] == 'UNIDAD_EJECUTORA') {
//                        $_POST['qtype'] = 'ENT.DES_ENTIDAD';
//                    }
                    if ($_POST['qtype'] == 'COD_PROYECTO') {
                        $_POST['qtype'] = 'PRY.COD_PROYECTO';
                    }
                    if ($_POST['qtype'] == 'COD_CONTRATO_ENTIDAD') {
                        $_POST['qtype'] = 'C.COD_CONTRATO_ENTIDAD';
                    }
                    if ($_POST['qtype'] == 'DES_PROYECTO') {
                        $_POST['qtype'] = 'PRY.DES_PROYECTO';
                    }
                    if ($_POST['qtype'] == 'INTERVENCION') {
                        $_POST['qtype'] = 'ITV.DES_INTERVENCION';
                    }
                    if ($_POST['qtype'] == 'ESTADO_PROYECTO') {
                        $_POST['qtype'] = 'EST_PRY.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'TIPO_CONTRATO') {
                        $_POST['qtype'] = 'TT1.DES_ITEM';
                    }

                    if ($_POST['qtype'] == 'FEC_INICIO') {
                        $_POST['qtype'] = 'C.FEC_INICIO_CONTRATO';
                    }
                    if ($_POST['qtype'] == 'FEC_TERMINO') {
                        $_POST['qtype'] = 'C.FEC_TERMINO_CONTRATO';
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
            $lparametroP['pUsuario'] = $usuario;
            $procedure_parametrosP = array(
                array(&$lparametroP['Script'], SQLSRV_PARAM_IN),
                array(&$lparametroP['pUsuario'], SQLSRV_PARAM_IN)
            );
            $ogridDAO->Count_PROYECTO_ACTIVIDAD($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROYECTO_ACTIVIDAD;
            $lCollection->Add('nTotal', $nTotal);                        
            GenerarDatosParaFlexigridSP1($ogridDAO, 'SelGrd_PROYECTO_ACTIVIDAD', $nTotal, $_POST['page'], $lparametro, $usuario,$_POST['rp'], $_POST['sortname'], $_POST['sortorder']);
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROYECTO_ACTIVIDADM = array();
            $Objeto_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($COD_PROYECTO)) > 0) {
                $lstparametrosM['COD_PROYECTO'] = $COD_PROYECTO;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }
            if (strlen(rtrim($IDE_PROCESO_ITEM)) > 0) {
                $lstparametrosM['IDE_PROCESO_ITEM'] = $IDE_PROCESO_ITEM;
            }
            if (strlen(rtrim($IDE_PRIORIZACION)) > 0) {
                $lstparametrosM['IDE_PRIORIZACION'] = $IDE_PRIORIZACION;
            }
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($GRUPO_TIPO_INTERVENCION)) > 0) {
                $lstparametrosM['GRUPO_TIPO_INTERVENCION'] = $GRUPO_TIPO_INTERVENCION;
            }
            if (strlen(rtrim($TIP_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['TIP_PROYECTO_ACTIVIDAD'] = $TIP_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_PROYECTO)) > 0) {
                $lstparametrosM['DES_PROYECTO'] = $DES_PROYECTO;
            }
            if (strlen(rtrim($DES_PROYECTO_ITEM)) > 0) {
                $lstparametrosM['DES_PROYECTO_ITEM'] = $DES_PROYECTO_ITEM;
            }
            if (strlen(rtrim($DES_PROYECTO_ABREV)) > 0) {
                $lstparametrosM['DES_PROYECTO_ABREV'] = $DES_PROYECTO_ABREV;
            }
            
            if (strlen(rtrim($IMP_INVERSION)) > 0)  {	
                    $lstparametrosM['IMP_INVERSION'] 		= $IMP_INVERSION;
             }	
             if (strlen(rtrim($IMP_FINANCIADO)) > 0)  {	
                    $lstparametrosM['IMP_FINANCIADO'] 		= $IMP_FINANCIADO;
             }	
             if (strlen(rtrim($IMP_TRANSFERIDO)) > 0)  {	
                    $lstparametrosM['IMP_TRANSFERIDO'] 		= $IMP_TRANSFERIDO;
             }	
             if (strlen(rtrim($IMP_VALOR_REFERENCIAL)) > 0)  {	
                    $lstparametrosM['IMP_VALOR_REFERENCIAL'] 		= $IMP_VALOR_REFERENCIAL;
             }	
             if (strlen(rtrim($IMP_COSTO_ACTUAL)) > 0)  {	
                    $lstparametrosM['IMP_COSTO_ACTUAL'] 		= $IMP_COSTO_ACTUAL;
             }	
             if (strlen(rtrim($IMP_LIQUIDADO)) > 0)  {	
                    $lstparametrosM['IMP_LIQUIDADO'] 		= $IMP_LIQUIDADO;
             }	
            if (strlen(rtrim($DES_UBICACION)) > 0) {
                $lstparametrosM['DES_UBICACION'] = $DES_UBICACION;
            }
            if (strlen(rtrim($GEO_LONGITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LONGITUD_UBICACION'] = $GEO_LONGITUD_UBICACION;
            }
            if (strlen(rtrim($GEO_LATITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LATITUD_UBICACION'] = $GEO_LATITUD_UBICACION;
            }
            if (strlen(rtrim($EST_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['EST_PROYECTO_ACTIVIDAD'] = $EST_PROYECTO_ACTIVIDAD;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROCESO_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PRIORIZACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GRUPO_TIPO_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROYECTO_ITEM'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROYECTO_ABREV'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_INVERSION'],       SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_FINANCIADO'],       SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_TRANSFERIDO'],       SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_VALOR_REFERENCIAL'],       SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_COSTO_ACTUAL'],       SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_LIQUIDADO'],       SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_UBICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GEO_LONGITUD_UBICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GEO_LATITUD_UBICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROYECTO_ACTIVIDAD_DAO->Insert_PROYECTO_ACTIVIDAD($DataSet_PROYECTO_ACTIVIDAD, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[22][0];

            $mensaje = $procedure_parametrosMS[23][0];

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
            $DataSet_PROYECTO_ACTIVIDAD = array();
            $Objeto_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROYECTO_ACTIVIDAD_DAO->SelPk_PROYECTO_ACTIVIDAD($DataSet_PROYECTO_ACTIVIDAD, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROYECTO_ACTIVIDAD) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROYECTO_ACTIVIDAD
                
                $IDE_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD[0]->IDE_PROYECTO;
                $COD_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD[0]->COD_PROYECTO;
                $IDE_ENTIDAD_EJECUTORA = $DataSet_PROYECTO_ACTIVIDAD[0]->IDE_ENTIDAD_EJECUTORA;
                $IDE_PROCESO_ITEM = $DataSet_PROYECTO_ACTIVIDAD[0]->IDE_PROCESO_ITEM;
                $IDE_PRIORIZACION = $DataSet_PROYECTO_ACTIVIDAD[0]->IDE_PRIORIZACION;
                $IDE_INTERVENCION = $DataSet_PROYECTO_ACTIVIDAD[0]->IDE_INTERVENCION;
                $GRUPO_TIPO_INTERVENCION = $DataSet_PROYECTO_ACTIVIDAD[0]->GRUPO_TIPO_INTERVENCION;
                $TIP_PROYECTO_ACTIVIDAD = $DataSet_PROYECTO_ACTIVIDAD[0]->TIP_PROYECTO_ACTIVIDAD;
                $DES_PROYECTO = $DataSet_PROYECTO_ACTIVIDAD[0]->DES_PROYECTO;
                $DES_PROYECTO_ITEM = $DataSet_PROYECTO_ACTIVIDAD[0]->DES_PROYECTO_ITEM;
                $DES_PROYECTO_ABREV = $DataSet_PROYECTO_ACTIVIDAD[0]->DES_PROYECTO_ABREV;
                $IMP_INVERSION  =  $DataSet_PROYECTO_ACTIVIDAD[0]->IMP_INVERSION;
                $IMP_FINANCIADO  =  $DataSet_PROYECTO_ACTIVIDAD[0]->IMP_FINANCIADO;
                $IMP_TRANSFERIDO  =  $DataSet_PROYECTO_ACTIVIDAD[0]->IMP_TRANSFERIDO;
                $IMP_VALOR_REFERENCIAL  =  $DataSet_PROYECTO_ACTIVIDAD[0]->IMP_VALOR_REFERENCIAL;
                $IMP_COSTO_ACTUAL  =  $DataSet_PROYECTO_ACTIVIDAD[0]->IMP_COSTO_ACTUAL;
                $IMP_LIQUIDADO  =  $DataSet_PROYECTO_ACTIVIDAD[0]->IMP_LIQUIDADO;
                $DES_UBICACION = $DataSet_PROYECTO_ACTIVIDAD[0]->DES_UBICACION;
                $GEO_LONGITUD_UBICACION = $DataSet_PROYECTO_ACTIVIDAD[0]->GEO_LONGITUD_UBICACION;
                $GEO_LATITUD_UBICACION = $DataSet_PROYECTO_ACTIVIDAD[0]->GEO_LATITUD_UBICACION;
                $EST_PROYECTO_ACTIVIDAD = $DataSet_PROYECTO_ACTIVIDAD[0]->EST_PROYECTO_ACTIVIDAD;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
            $lCollection->Add('COD_PROYECTO', $COD_PROYECTO);
            $lCollection->Add('IDE_ENTIDAD_EJECUTORA', $IDE_ENTIDAD_EJECUTORA);
            $lCollection->Add('IDE_PROCESO_ITEM', $IDE_PROCESO_ITEM);
            $lCollection->Add('IDE_PRIORIZACION', $IDE_PRIORIZACION);
            $lCollection->Add('IDE_INTERVENCION', $IDE_INTERVENCION);
            $lCollection->Add('GRUPO_TIPO_INTERVENCION', $GRUPO_TIPO_INTERVENCION);
            $lCollection->Add('TIP_PROYECTO_ACTIVIDAD', $TIP_PROYECTO_ACTIVIDAD);
            $lCollection->Add('DES_PROYECTO', $DES_PROYECTO);
            $lCollection->Add('DES_PROYECTO_ITEM', $DES_PROYECTO_ITEM);
            $lCollection->Add('DES_PROYECTO_ABREV', $DES_PROYECTO_ABREV);
            $lCollection->Add('IMP_INVERSION', $IMP_INVERSION);
            $lCollection->Add('IMP_FINANCIADO', $IMP_FINANCIADO);
            $lCollection->Add('IMP_TRANSFERIDO', $IMP_TRANSFERIDO);
            $lCollection->Add('IMP_VALOR_REFERENCIAL', $IMP_VALOR_REFERENCIAL);
            $lCollection->Add('IMP_COSTO_ACTUAL', $IMP_COSTO_ACTUAL);
            $lCollection->Add('IMP_LIQUIDADO', $IMP_LIQUIDADO);
            $lCollection->Add('DES_UBICACION', $DES_UBICACION);
            $lCollection->Add('GEO_LONGITUD_UBICACION', $GEO_LONGITUD_UBICACION);
            $lCollection->Add('GEO_LATITUD_UBICACION', $GEO_LATITUD_UBICACION);
            $lCollection->Add('EST_PROYECTO_ACTIVIDAD', $EST_PROYECTO_ACTIVIDAD);
            
            
            /* EDGAR */ // DATOS BUSCADO s
            $Data = Proceso_Datos($IDE_PROCESO_ITEM);
            $BProcesoAdquisicion = '( '. $Data['BIDE'] .' - Proc.Esp: '. $Data['NUM_PROC_ESPECIFICO'] . ' ) ' . $Data['DES_OBJETO'] ;
            $lCollection->Add('BProcesoAdquisicion', $BProcesoAdquisicion);
            
            
            $Data_Contrato = Contrato_Datos($IMP_TRANSFERIDO);
            $bCOD_CONTRATO_ENTIDAD = $Data_Contrato['COD_CONTRATO_ENTIDAD'] ;
            $lCollection->Add('bCOD_CONTRATO_ENTIDAD', $bCOD_CONTRATO_ENTIDAD);
            /* EDGAR */
            
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROYECTO_ACTIVIDAD = array();
            $Objeto_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($COD_PROYECTO)) > 0) {
                $lstparametrosM['COD_PROYECTO'] = $COD_PROYECTO;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }
            if (strlen(rtrim($IDE_PROCESO_ITEM)) > 0) {
                $lstparametrosM['IDE_PROCESO_ITEM'] = $IDE_PROCESO_ITEM;
            }
            if (strlen(rtrim($IDE_PRIORIZACION)) > 0) {
                $lstparametrosM['IDE_PRIORIZACION'] = $IDE_PRIORIZACION;
            }
            if (strlen(rtrim($IDE_INTERVENCION)) > 0) {
                $lstparametrosM['IDE_INTERVENCION'] = $IDE_INTERVENCION;
            }
            if (strlen(rtrim($GRUPO_TIPO_INTERVENCION)) > 0) {
                $lstparametrosM['GRUPO_TIPO_INTERVENCION'] = $GRUPO_TIPO_INTERVENCION;
            }
            if (strlen(rtrim($TIP_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['TIP_PROYECTO_ACTIVIDAD'] = $TIP_PROYECTO_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_PROYECTO)) > 0) {
                $lstparametrosM['DES_PROYECTO'] = $DES_PROYECTO;
            }
            if (strlen(rtrim($DES_PROYECTO_ITEM)) > 0) {
                $lstparametrosM['DES_PROYECTO_ITEM'] = $DES_PROYECTO_ITEM;
            }
            if (strlen(rtrim($DES_PROYECTO_ABREV)) > 0) {
                $lstparametrosM['DES_PROYECTO_ABREV'] = $DES_PROYECTO_ABREV;
            }
            if (strlen(rtrim($IMP_INVERSION)) > 0)  {	
                    $lstparametrosM['IMP_INVERSION'] = ConvertirMontos($IMP_INVERSION);                    
             }	
             if (strlen(rtrim($IMP_FINANCIADO)) > 0)  {	
                    $lstparametrosM['IMP_FINANCIADO'] = ConvertirMontos($IMP_FINANCIADO);
             }	
             if (strlen(rtrim($IMP_TRANSFERIDO)) > 0)  {	
                    $lstparametrosM['IMP_TRANSFERIDO'] = ConvertirMontos($IMP_TRANSFERIDO);
             }	
             if (strlen(rtrim($IMP_VALOR_REFERENCIAL)) > 0)  {	
                    $lstparametrosM['IMP_VALOR_REFERENCIAL'] = ConvertirMontos($IMP_VALOR_REFERENCIAL);
             }	
             if (strlen(rtrim($IMP_COSTO_ACTUAL)) > 0)  {	
                    $lstparametrosM['IMP_COSTO_ACTUAL'] = ConvertirMontos($IMP_COSTO_ACTUAL);
             }	
             if (strlen(rtrim($IMP_LIQUIDADO)) > 0)  {	
                    $lstparametrosM['IMP_LIQUIDADO'] = ConvertirMontos($IMP_LIQUIDADO);
             }	

            if (strlen(rtrim($DES_UBICACION)) > 0) {
                $lstparametrosM['DES_UBICACION'] = $DES_UBICACION;
            }
            if (strlen(rtrim($GEO_LONGITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LONGITUD_UBICACION'] = $GEO_LONGITUD_UBICACION;
            }
            if (strlen(rtrim($GEO_LATITUD_UBICACION)) > 0) {
                $lstparametrosM['GEO_LATITUD_UBICACION'] = $GEO_LATITUD_UBICACION;
            }
            if (strlen(rtrim($EST_PROYECTO_ACTIVIDAD)) > 0) {
                $lstparametrosM['EST_PROYECTO_ACTIVIDAD'] = $EST_PROYECTO_ACTIVIDAD;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROCESO_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PRIORIZACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GRUPO_TIPO_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROYECTO_ITEM'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROYECTO_ABREV'], SQLSRV_PARAM_IN)
                ,array(&$lstparametrosM['IMP_INVERSION'], SQLSRV_PARAM_IN)
                ,array(&$lstparametrosM['IMP_FINANCIADO'], SQLSRV_PARAM_IN)
                ,array(&$lstparametrosM['IMP_TRANSFERIDO'], SQLSRV_PARAM_IN)
                ,array(&$lstparametrosM['IMP_VALOR_REFERENCIAL'], SQLSRV_PARAM_IN)
                ,array(&$lstparametrosM['IMP_COSTO_ACTUAL'], SQLSRV_PARAM_IN)
                ,array(&$lstparametrosM['IMP_LIQUIDADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_UBICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GEO_LONGITUD_UBICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GEO_LATITUD_UBICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROYECTO_ACTIVIDAD_DAO->Update_PROYECTO_ACTIVIDAD($DataSet_PROYECTO_ACTIVIDAD, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[23][0];

            $mensaje = $procedure_parametrosMS[24][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROYECTO_ACTIVIDAD = array();
            $Objeto_PROYECTO_ACTIVIDAD_DAO = new PROYECTO_ACTIVIDAD_DAO();
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
            $Objeto_PROYECTO_ACTIVIDAD_DAO->Delete_PROYECTO_ACTIVIDAD($DataSet_PROYECTO_ACTIVIDAD, $procedure_parametrosMS); //JCMY
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


        $DataSet_GEN_ENTIDAD_1 = array();
        $Objeto_IDE_ENTIDAD_EJECUTORA_DAO = new GEN_ENTIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD,DES_ENTIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDE_ENTIDAD_EJECUTORA_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTIDAD_1', $DataSet_GEN_ENTIDAD_1);


        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = " AND IDE_SECTOR=14  AND  NUM_NIVEL=3 ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_INTERVENCION_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_PROYECTO_ACTIVIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '65'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_TIP_PROYECTO_ACTIVIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */
        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_PROYECTO_ACTIVIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '8'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_EST_PROYECTO_ACTIVIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */
        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_GRUPO_TIPO_INTERVENCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '23'";
        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_GRUPO_TIPO_INTERVENCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);
        
        
        
        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
        
    }
}

//var_dump($lstDepartamento);exit;