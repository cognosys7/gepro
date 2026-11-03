<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : PROYECTOLN de la tabla PROYECTO
  //  Fecha           : domingo, 5 de mayo de 2019 9:28:20
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-D
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROYECTODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_PORTAFOLIO_PROYECTODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_PROGRAMA_PROYECTODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_CENTRO_COSTODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");




/* EDGAR */
require_once("include/PROYECTOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROYECTO";
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
        
        //EMPLEADO PARA LA GRILLA
        $Opcion = isset($_REQUEST['Opcion']) ? VerificarInputs($_REQUEST['Opcion']) : "";
        $lCollection->Add('Opcion', $Opcion);
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PORTAFOLIO = isset($_REQUEST['IDE_PORTAFOLIO']) ? VerificarInputs($_REQUEST['IDE_PORTAFOLIO']) : "";
        $IDE_PROGRAMA = isset($_REQUEST['IDE_PROGRAMA']) ? VerificarInputs($_REQUEST['IDE_PROGRAMA']) : "";
        $IDE_CENCOSTO = isset($_REQUEST['IDE_CENCOSTO']) ? VerificarInputs($_REQUEST['IDE_CENCOSTO']) : "";
        $IDE_ENTIDAD_EJECUTORA = isset($_REQUEST['IDE_ENTIDAD_EJECUTORA']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD_EJECUTORA']) : "";
        $IDE_ETAPA_CONTRATO = isset($_REQUEST['IDE_ETAPA_CONTRATO']) ? VerificarInputs($_REQUEST['IDE_ETAPA_CONTRATO']) : "";
        $COD_INTERNO = isset($_REQUEST['COD_INTERNO']) ? VerificarInputs($_REQUEST['COD_INTERNO']) : "";
        $COD_UNICO = isset($_REQUEST['COD_UNICO']) ? VerificarInputs($_REQUEST['COD_UNICO']) : "";
        $COD_SNIP = isset($_REQUEST['COD_SNIP']) ? VerificarInputs($_REQUEST['COD_SNIP']) : "";
        $DES_LARGA_PROYECTO = isset($_REQUEST['DES_LARGA_PROYECTO']) ? VerificarInputs($_REQUEST['DES_LARGA_PROYECTO']) : "";
        $DES_CORTA_PROYECTO = isset($_REQUEST['DES_CORTA_PROYECTO']) ? VerificarInputs($_REQUEST['DES_CORTA_PROYECTO']) : "";
        $DES_PROYECTO_ENGLISH = isset($_REQUEST['DES_PROYECTO_ENGLISH']) ? VerificarInputs($_REQUEST['DES_PROYECTO_ENGLISH']) : "";
        $TIP_MONEDA = isset($_REQUEST['TIP_MONEDA']) ? VerificarInputs($_REQUEST['TIP_MONEDA']) : "";
        $IMP_APROBADO_LOC = isset($_REQUEST['IMP_APROBADO_LOC']) ? VerificarInputs($_REQUEST['IMP_APROBADO_LOC']) : "";
        $IMP_APROBADO_EXT = isset($_REQUEST['IMP_APROBADO_EXT']) ? VerificarInputs($_REQUEST['IMP_APROBADO_EXT']) : "";
        $FEC_APROBACION = isset($_REQUEST['FEC_APROBACION']) ? VerificarInputs($_REQUEST['FEC_APROBACION']) : "";
        $FEC_INICIO_PROY = isset($_REQUEST['FEC_INICIO_PROY']) ? VerificarInputs($_REQUEST['FEC_INICIO_PROY']) : "";
        $FEC_TERMINO_PROY = isset($_REQUEST['FEC_TERMINO_PROY']) ? VerificarInputs($_REQUEST['FEC_TERMINO_PROY']) : "";
        $DES_UBICACION_PROYECTO = isset($_REQUEST['DES_UBICACION_PROYECTO']) ? VerificarInputs($_REQUEST['DES_UBICACION_PROYECTO']) : "";
        $DES_UNIDAD_FORMULADORA = isset($_REQUEST['DES_UNIDAD_FORMULADORA']) ? VerificarInputs($_REQUEST['DES_UNIDAD_FORMULADORA']) : "";
        $DES_VIABILIDAD = isset($_REQUEST['DES_VIABILIDAD']) ? VerificarInputs($_REQUEST['DES_VIABILIDAD']) : "";
        $DES_AREA_INTERVENCION = isset($_REQUEST['DES_AREA_INTERVENCION']) ? VerificarInputs($_REQUEST['DES_AREA_INTERVENCION']) : "";
        $DES_CUENCA_HIDROGRAFICA = isset($_REQUEST['DES_CUENCA_HIDROGRAFICA']) ? VerificarInputs($_REQUEST['DES_CUENCA_HIDROGRAFICA']) : "";
        $NUM_PAMS = isset($_REQUEST['NUM_PAMS']) ? VerificarInputs($_REQUEST['NUM_PAMS']) : "";
        $DES_STAKEHOLDER = isset($_REQUEST['DES_STAKEHOLDER']) ? VerificarInputs($_REQUEST['DES_STAKEHOLDER']) : "";
        $DES_ESTATUS = isset($_REQUEST['DES_ESTATUS']) ? VerificarInputs($_REQUEST['DES_ESTATUS']) : "";
        $DES_ACCION_GESTION = isset($_REQUEST['DES_ACCION_GESTION']) ? VerificarInputs($_REQUEST['DES_ACCION_GESTION']) : "";
        $DES_ACCION_GESTION_SOCIAL = isset($_REQUEST['DES_ACCION_GESTION_SOCIAL']) ? VerificarInputs($_REQUEST['DES_ACCION_GESTION_SOCIAL']) : "";
        $DES_ACCION_CORRECTIVA = isset($_REQUEST['DES_ACCION_CORRECTIVA']) ? VerificarInputs($_REQUEST['DES_ACCION_CORRECTIVA']) : "";
        $DES_OPORTUNIDAD_MEJORA = isset($_REQUEST['DES_OPORTUNIDAD_MEJORA']) ? VerificarInputs($_REQUEST['DES_OPORTUNIDAD_MEJORA']) : "";
        $TIP_PROYECTO = isset($_REQUEST['TIP_PROYECTO']) ? VerificarInputs($_REQUEST['TIP_PROYECTO']) : "";
        $TIP_GRUPO_PROYECTO = isset($_REQUEST['TIP_GRUPO_PROYECTO']) ? VerificarInputs($_REQUEST['TIP_GRUPO_PROYECTO']) : "";
        $NUM_BENEFICIARIOS = isset($_REQUEST['NUM_BENEFICIARIOS']) ? VerificarInputs($_REQUEST['NUM_BENEFICIARIOS']) : "";
        $EST_PROYECTO = isset($_REQUEST['EST_PROYECTO']) ? VerificarInputs($_REQUEST['EST_PROYECTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROYECTO'.$Opcion;
        
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
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROYECTO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_INTERNO') {
                        $_POST['qtype'] = 'T.COD_INTERNO';
                    }
                    if ($_POST['qtype'] == 'COD_UNICO') {
                        $_POST['qtype'] = 'T.COD_UNICO';
                    }
                    if ($_POST['qtype'] == 'DES_LARGA_PROYECTO') {
                        $_POST['qtype'] = 'T.DES_LARGA_PROYECTO';
                    }
                    if ($_POST['qtype'] == 'FEC_INICIO_PROY') {
                        $_POST['qtype'] = 'T.FEC_INICIO_PROY';
                    }
                    if ($_POST['qtype'] == 'FEC_TERMINO_PROY') {
                        $_POST['qtype'] = 'T.FEC_TERMINO_PROY';
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
            $ogridDAO->Count_PROYECTO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROYECTO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_APROBACION) > 0) {
                $FEC_APROBACION = cambiafecha($FEC_APROBACION);
            } else {
                $FEC_APROBACION = "";
            }
            if (strlen($FEC_INICIO_PROY) > 0) {
                $FEC_INICIO_PROY = cambiafecha($FEC_INICIO_PROY);
            } else {
                $FEC_INICIO_PROY = "";
            }
            if (strlen($FEC_TERMINO_PROY) > 0) {
                $FEC_TERMINO_PROY = cambiafecha($FEC_TERMINO_PROY);
            } else {
                $FEC_TERMINO_PROY = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROYECTOM = array();
            $Objeto_PROYECTO_DAO = new PROYECTO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PORTAFOLIO)) > 0) {
                $lstparametrosM['IDE_PORTAFOLIO'] = $IDE_PORTAFOLIO;
            }
            if (strlen(rtrim($IDE_PROGRAMA)) > 0) {
                $lstparametrosM['IDE_PROGRAMA'] = $IDE_PROGRAMA;
            }
            if (strlen(rtrim($IDE_CENCOSTO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO'] = $IDE_CENCOSTO;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }
            if (strlen(rtrim($IDE_ETAPA_CONTRATO)) > 0) {
                $lstparametrosM['IDE_ETAPA_CONTRATO'] = $IDE_ETAPA_CONTRATO;
            }
            if (strlen(rtrim($COD_INTERNO)) > 0) {
                $lstparametrosM['COD_INTERNO'] = $COD_INTERNO;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($DES_LARGA_PROYECTO)) > 0) {
                $lstparametrosM['DES_LARGA_PROYECTO'] = $DES_LARGA_PROYECTO;
            }
            if (strlen(rtrim($DES_CORTA_PROYECTO)) > 0) {
                $lstparametrosM['DES_CORTA_PROYECTO'] = $DES_CORTA_PROYECTO;
            }
            if (strlen(rtrim($DES_PROYECTO_ENGLISH)) > 0) {
                $lstparametrosM['DES_PROYECTO_ENGLISH'] = $DES_PROYECTO_ENGLISH;
            }
            if (strlen(rtrim($TIP_MONEDA)) > 0) {
                $lstparametrosM['TIP_MONEDA'] = $TIP_MONEDA;
            }
            if (strlen(rtrim($IMP_APROBADO_LOC)) > 0) {
                $lstparametrosM['IMP_APROBADO_LOC'] = $IMP_APROBADO_LOC;
            }
            if (strlen(rtrim($IMP_APROBADO_EXT)) > 0) {
                $lstparametrosM['IMP_APROBADO_EXT'] = $IMP_APROBADO_EXT;
            }
            if (strlen(rtrim($FEC_APROBACION)) > 0) {
                $lstparametrosM['FEC_APROBACION'] = $FEC_APROBACION;
            }
            if (strlen(rtrim($FEC_INICIO_PROY)) > 0) {
                $lstparametrosM['FEC_INICIO_PROY'] = $FEC_INICIO_PROY;
            }
            if (strlen(rtrim($FEC_TERMINO_PROY)) > 0) {
                $lstparametrosM['FEC_TERMINO_PROY'] = $FEC_TERMINO_PROY;
            }
            if (strlen(rtrim($DES_UBICACION_PROYECTO)) > 0) {
                $lstparametrosM['DES_UBICACION_PROYECTO'] = $DES_UBICACION_PROYECTO;
            }
            if (strlen(rtrim($DES_UNIDAD_FORMULADORA)) > 0) {
                $lstparametrosM['DES_UNIDAD_FORMULADORA'] = $DES_UNIDAD_FORMULADORA;
            }
            if (strlen(rtrim($DES_VIABILIDAD)) > 0) {
                $lstparametrosM['DES_VIABILIDAD'] = $DES_VIABILIDAD;
            }
            if (strlen(rtrim($DES_AREA_INTERVENCION)) > 0) {
                $lstparametrosM['DES_AREA_INTERVENCION'] = $DES_AREA_INTERVENCION;
            }
            if (strlen(rtrim($DES_CUENCA_HIDROGRAFICA)) > 0) {
                $lstparametrosM['DES_CUENCA_HIDROGRAFICA'] = $DES_CUENCA_HIDROGRAFICA;
            }
            if (strlen(rtrim($NUM_PAMS)) > 0) {
                $lstparametrosM['NUM_PAMS'] = $NUM_PAMS;
            }
            if (strlen(rtrim($DES_STAKEHOLDER)) > 0) {
                $lstparametrosM['DES_STAKEHOLDER'] = $DES_STAKEHOLDER;
            }
            if (strlen(rtrim($DES_ESTATUS)) > 0) {
                $lstparametrosM['DES_ESTATUS'] = $DES_ESTATUS;
            }
            if (strlen(rtrim($DES_ACCION_GESTION)) > 0) {
                $lstparametrosM['DES_ACCION_GESTION'] = $DES_ACCION_GESTION;
            }
            if (strlen(rtrim($DES_ACCION_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['DES_ACCION_GESTION_SOCIAL'] = $DES_ACCION_GESTION_SOCIAL;
            }
            if (strlen(rtrim($DES_ACCION_CORRECTIVA)) > 0) {
                $lstparametrosM['DES_ACCION_CORRECTIVA'] = $DES_ACCION_CORRECTIVA;
            }
            if (strlen(rtrim($DES_OPORTUNIDAD_MEJORA)) > 0) {
                $lstparametrosM['DES_OPORTUNIDAD_MEJORA'] = $DES_OPORTUNIDAD_MEJORA;
            }
            if (strlen(rtrim($TIP_PROYECTO)) > 0) {
                $lstparametrosM['TIP_PROYECTO'] = $TIP_PROYECTO;
            }
            if (strlen(rtrim($TIP_GRUPO_PROYECTO)) > 0) {
                $lstparametrosM['TIP_GRUPO_PROYECTO'] = $TIP_GRUPO_PROYECTO;
            }
            if (strlen(rtrim($NUM_BENEFICIARIOS)) > 0) {
                $lstparametrosM['NUM_BENEFICIARIOS'] = $NUM_BENEFICIARIOS;
            }
            if (strlen(rtrim($EST_PROYECTO)) > 0) {
                $lstparametrosM['EST_PROYECTO'] = $EST_PROYECTO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PORTAFOLIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROGRAMA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CENCOSTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ETAPA_CONTRATO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_INTERNO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_LARGA_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CORTA_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROYECTO_ENGLISH'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_MONEDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_APROBADO_LOC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_APROBADO_EXT'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_APROBACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO_PROY'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO_PROY'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_UBICACION_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_UNIDAD_FORMULADORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_VIABILIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_AREA_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CUENCA_HIDROGRAFICA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_PAMS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_STAKEHOLDER'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ESTATUS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACCION_GESTION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACCION_GESTION_SOCIAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACCION_CORRECTIVA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OPORTUNIDAD_MEJORA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_GRUPO_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_BENEFICIARIOS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROYECTO_DAO->Insert_PROYECTO($DataSet_PROYECTO, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[34][0];

            $mensaje = $procedure_parametrosMS[35][0];

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
            $DataSet_PROYECTO = array();
            $Objeto_PROYECTO_DAO = new PROYECTO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROYECTO_DAO->SelPk_PROYECTO($DataSet_PROYECTO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROYECTO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROYECTO

                $IDE_PORTAFOLIO = $DataSet_PROYECTO[0]->IDE_PORTAFOLIO;
                $IDE_PROGRAMA = $DataSet_PROYECTO[0]->IDE_PROGRAMA;
                $IDE_CENCOSTO = $DataSet_PROYECTO[0]->IDE_CENCOSTO;
                $IDE_ENTIDAD_EJECUTORA = $DataSet_PROYECTO[0]->IDE_ENTIDAD_EJECUTORA;
                $IDE_ETAPA_CONTRATO = $DataSet_PROYECTO[0]->IDE_ETAPA_CONTRATO;
                $COD_INTERNO = $DataSet_PROYECTO[0]->COD_INTERNO;
                $COD_UNICO = $DataSet_PROYECTO[0]->COD_UNICO;
                $COD_SNIP = $DataSet_PROYECTO[0]->COD_SNIP;
                $DES_LARGA_PROYECTO = $DataSet_PROYECTO[0]->DES_LARGA_PROYECTO;
                $DES_CORTA_PROYECTO = $DataSet_PROYECTO[0]->DES_CORTA_PROYECTO;
                $DES_PROYECTO_ENGLISH = $DataSet_PROYECTO[0]->DES_PROYECTO_ENGLISH;
                $TIP_MONEDA = $DataSet_PROYECTO[0]->TIP_MONEDA;
                $IMP_APROBADO_LOC = $DataSet_PROYECTO[0]->IMP_APROBADO_LOC;
                $IMP_APROBADO_EXT = $DataSet_PROYECTO[0]->IMP_APROBADO_EXT;
                $FEC_APROBACION = $DataSet_PROYECTO[0]->FEC_APROBACION;
                $FEC_INICIO_PROY = $DataSet_PROYECTO[0]->FEC_INICIO_PROY;
                $FEC_TERMINO_PROY = $DataSet_PROYECTO[0]->FEC_TERMINO_PROY;
                $DES_UBICACION_PROYECTO = $DataSet_PROYECTO[0]->DES_UBICACION_PROYECTO;
                $DES_UNIDAD_FORMULADORA = $DataSet_PROYECTO[0]->DES_UNIDAD_FORMULADORA;
                $DES_VIABILIDAD = $DataSet_PROYECTO[0]->DES_VIABILIDAD;
                $DES_AREA_INTERVENCION = $DataSet_PROYECTO[0]->DES_AREA_INTERVENCION;
                $DES_CUENCA_HIDROGRAFICA = $DataSet_PROYECTO[0]->DES_CUENCA_HIDROGRAFICA;
                $NUM_PAMS = $DataSet_PROYECTO[0]->NUM_PAMS;
                $DES_STAKEHOLDER = $DataSet_PROYECTO[0]->DES_STAKEHOLDER;
                $DES_ESTATUS = $DataSet_PROYECTO[0]->DES_ESTATUS;
                $DES_ACCION_GESTION = $DataSet_PROYECTO[0]->DES_ACCION_GESTION;
                $DES_ACCION_GESTION_SOCIAL = $DataSet_PROYECTO[0]->DES_ACCION_GESTION_SOCIAL;
                $DES_ACCION_CORRECTIVA = $DataSet_PROYECTO[0]->DES_ACCION_CORRECTIVA;
                $DES_OPORTUNIDAD_MEJORA = $DataSet_PROYECTO[0]->DES_OPORTUNIDAD_MEJORA;
                $TIP_PROYECTO = $DataSet_PROYECTO[0]->TIP_PROYECTO;
                $TIP_GRUPO_PROYECTO = $DataSet_PROYECTO[0]->TIP_GRUPO_PROYECTO;
                $NUM_BENEFICIARIOS = $DataSet_PROYECTO[0]->NUM_BENEFICIARIOS;
                $EST_PROYECTO = $DataSet_PROYECTO[0]->EST_PROYECTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PORTAFOLIO', $IDE_PORTAFOLIO);
            $lCollection->Add('IDE_PROGRAMA', $IDE_PROGRAMA);
            $lCollection->Add('IDE_CENCOSTO', $IDE_CENCOSTO);
            $lCollection->Add('IDE_ENTIDAD_EJECUTORA', $IDE_ENTIDAD_EJECUTORA);
            $lCollection->Add('IDE_ETAPA_CONTRATO', $IDE_ETAPA_CONTRATO);
            $lCollection->Add('COD_INTERNO', $COD_INTERNO);
            $lCollection->Add('COD_UNICO', $COD_UNICO);
            $lCollection->Add('COD_SNIP', $COD_SNIP);
            $lCollection->Add('DES_LARGA_PROYECTO', $DES_LARGA_PROYECTO);
            $lCollection->Add('DES_CORTA_PROYECTO', $DES_CORTA_PROYECTO);
            $lCollection->Add('DES_PROYECTO_ENGLISH', $DES_PROYECTO_ENGLISH);
            $lCollection->Add('TIP_MONEDA', $TIP_MONEDA);
            $lCollection->Add('IMP_APROBADO_LOC', $IMP_APROBADO_LOC);
            $lCollection->Add('IMP_APROBADO_EXT', $IMP_APROBADO_EXT);
            $lCollection->Add('FEC_APROBACION', $FEC_APROBACION);
            $lCollection->Add('FEC_INICIO_PROY', $FEC_INICIO_PROY);
            $lCollection->Add('FEC_TERMINO_PROY', $FEC_TERMINO_PROY);
            $lCollection->Add('DES_UBICACION_PROYECTO', $DES_UBICACION_PROYECTO);
            $lCollection->Add('DES_UNIDAD_FORMULADORA', $DES_UNIDAD_FORMULADORA);
            $lCollection->Add('DES_VIABILIDAD', $DES_VIABILIDAD);
            $lCollection->Add('DES_AREA_INTERVENCION', $DES_AREA_INTERVENCION);
            $lCollection->Add('DES_CUENCA_HIDROGRAFICA', $DES_CUENCA_HIDROGRAFICA);
            $lCollection->Add('NUM_PAMS', $NUM_PAMS);
            $lCollection->Add('DES_STAKEHOLDER', $DES_STAKEHOLDER);
            $lCollection->Add('DES_ESTATUS', $DES_ESTATUS);
            $lCollection->Add('DES_ACCION_GESTION', $DES_ACCION_GESTION);
            $lCollection->Add('DES_ACCION_GESTION_SOCIAL', $DES_ACCION_GESTION_SOCIAL);
            $lCollection->Add('DES_ACCION_CORRECTIVA', $DES_ACCION_CORRECTIVA);
            $lCollection->Add('DES_OPORTUNIDAD_MEJORA', $DES_OPORTUNIDAD_MEJORA);
            $lCollection->Add('TIP_PROYECTO', $TIP_PROYECTO);
            $lCollection->Add('TIP_GRUPO_PROYECTO', $TIP_GRUPO_PROYECTO);
            $lCollection->Add('NUM_BENEFICIARIOS', $NUM_BENEFICIARIOS);
            $lCollection->Add('EST_PROYECTO', $EST_PROYECTO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_APROBACION) > 0) {
                $FEC_APROBACION = cambiafecha($FEC_APROBACION);
            } else {
                $FEC_APROBACION = "";
            }
            if (strlen($FEC_INICIO_PROY) > 0) {
                $FEC_INICIO_PROY = cambiafecha($FEC_INICIO_PROY);
            } else {
                $FEC_INICIO_PROY = "";
            }
            if (strlen($FEC_TERMINO_PROY) > 0) {
                $FEC_TERMINO_PROY = cambiafecha($FEC_TERMINO_PROY);
            } else {
                $FEC_TERMINO_PROY = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROYECTO = array();
            $Objeto_PROYECTO_DAO = new PROYECTO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PORTAFOLIO)) > 0) {
                $lstparametrosM['IDE_PORTAFOLIO'] = $IDE_PORTAFOLIO;
            }
            if (strlen(rtrim($IDE_PROGRAMA)) > 0) {
                $lstparametrosM['IDE_PROGRAMA'] = $IDE_PROGRAMA;
            }
            if (strlen(rtrim($IDE_CENCOSTO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO'] = $IDE_CENCOSTO;
            }
            if (strlen(rtrim($IDE_ENTIDAD_EJECUTORA)) > 0) {
                $lstparametrosM['IDE_ENTIDAD_EJECUTORA'] = $IDE_ENTIDAD_EJECUTORA;
            }
            if (strlen(rtrim($IDE_ETAPA_CONTRATO)) > 0) {
                $lstparametrosM['IDE_ETAPA_CONTRATO'] = $IDE_ETAPA_CONTRATO;
            }
            if (strlen(rtrim($COD_INTERNO)) > 0) {
                $lstparametrosM['COD_INTERNO'] = $COD_INTERNO;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($DES_LARGA_PROYECTO)) > 0) {
                $lstparametrosM['DES_LARGA_PROYECTO'] = $DES_LARGA_PROYECTO;
            }
            if (strlen(rtrim($DES_CORTA_PROYECTO)) > 0) {
                $lstparametrosM['DES_CORTA_PROYECTO'] = $DES_CORTA_PROYECTO;
            }
            if (strlen(rtrim($DES_PROYECTO_ENGLISH)) > 0) {
                $lstparametrosM['DES_PROYECTO_ENGLISH'] = $DES_PROYECTO_ENGLISH;
            }
            if (strlen(rtrim($TIP_MONEDA)) > 0) {
                $lstparametrosM['TIP_MONEDA'] = $TIP_MONEDA;
            }
            if (strlen(rtrim($IMP_APROBADO_LOC)) > 0) {
                $lstparametrosM['IMP_APROBADO_LOC'] = ConvertirMontos($IMP_APROBADO_LOC);
            }
            if (strlen(rtrim($IMP_APROBADO_EXT)) > 0) {
                $lstparametrosM['IMP_APROBADO_EXT'] = ConvertirMontos($IMP_APROBADO_EXT);
            }
            if (strlen(rtrim($FEC_APROBACION)) > 0) {
                $lstparametrosM['FEC_APROBACION'] = $FEC_APROBACION;
            }
            if (strlen(rtrim($FEC_INICIO_PROY)) > 0) {
                $lstparametrosM['FEC_INICIO_PROY'] = $FEC_INICIO_PROY;
            }
            if (strlen(rtrim($FEC_TERMINO_PROY)) > 0) {
                $lstparametrosM['FEC_TERMINO_PROY'] = $FEC_TERMINO_PROY;
            }
            if (strlen(rtrim($DES_UBICACION_PROYECTO)) > 0) {
                $lstparametrosM['DES_UBICACION_PROYECTO'] = $DES_UBICACION_PROYECTO;
            }
            if (strlen(rtrim($DES_UNIDAD_FORMULADORA)) > 0) {
                $lstparametrosM['DES_UNIDAD_FORMULADORA'] = $DES_UNIDAD_FORMULADORA;
            }
            if (strlen(rtrim($DES_VIABILIDAD)) > 0) {
                $lstparametrosM['DES_VIABILIDAD'] = $DES_VIABILIDAD;
            }
            if (strlen(rtrim($DES_AREA_INTERVENCION)) > 0) {
                $lstparametrosM['DES_AREA_INTERVENCION'] = $DES_AREA_INTERVENCION;
            }
            if (strlen(rtrim($DES_CUENCA_HIDROGRAFICA)) > 0) {
                $lstparametrosM['DES_CUENCA_HIDROGRAFICA'] = $DES_CUENCA_HIDROGRAFICA;
            }
            if (strlen(rtrim($NUM_PAMS)) > 0) {
                $lstparametrosM['NUM_PAMS'] = $NUM_PAMS;
            }
            if (strlen(rtrim($DES_STAKEHOLDER)) > 0) {
                $lstparametrosM['DES_STAKEHOLDER'] = $DES_STAKEHOLDER;
            }
            if (strlen(rtrim($DES_ESTATUS)) > 0) {
                $lstparametrosM['DES_ESTATUS'] = $DES_ESTATUS;
            }
            if (strlen(rtrim($DES_ACCION_GESTION)) > 0) {
                $lstparametrosM['DES_ACCION_GESTION'] = $DES_ACCION_GESTION;
            }
            if (strlen(rtrim($DES_ACCION_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['DES_ACCION_GESTION_SOCIAL'] = $DES_ACCION_GESTION_SOCIAL;
            }
            if (strlen(rtrim($DES_ACCION_CORRECTIVA)) > 0) {
                $lstparametrosM['DES_ACCION_CORRECTIVA'] = $DES_ACCION_CORRECTIVA;
            }
            if (strlen(rtrim($DES_OPORTUNIDAD_MEJORA)) > 0) {
                $lstparametrosM['DES_OPORTUNIDAD_MEJORA'] = $DES_OPORTUNIDAD_MEJORA;
            }
            if (strlen(rtrim($TIP_PROYECTO)) > 0) {
                $lstparametrosM['TIP_PROYECTO'] = $TIP_PROYECTO;
            }
            if (strlen(rtrim($TIP_GRUPO_PROYECTO)) > 0) {
                $lstparametrosM['TIP_GRUPO_PROYECTO'] = $TIP_GRUPO_PROYECTO;
            }
            if (strlen(rtrim($NUM_BENEFICIARIOS)) > 0) {
                $lstparametrosM['NUM_BENEFICIARIOS'] = $NUM_BENEFICIARIOS;
            }
            if (strlen(rtrim($EST_PROYECTO)) > 0) {
                $lstparametrosM['EST_PROYECTO'] = $EST_PROYECTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PORTAFOLIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROGRAMA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CENCOSTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD_EJECUTORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ETAPA_CONTRATO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_INTERNO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_LARGA_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CORTA_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROYECTO_ENGLISH'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_MONEDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_APROBADO_LOC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_APROBADO_EXT'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_APROBACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO_PROY'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO_PROY'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_UBICACION_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_UNIDAD_FORMULADORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_VIABILIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_AREA_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CUENCA_HIDROGRAFICA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_PAMS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_STAKEHOLDER'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ESTATUS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACCION_GESTION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACCION_GESTION_SOCIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACCION_CORRECTIVA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OPORTUNIDAD_MEJORA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_GRUPO_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_BENEFICIARIOS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROYECTO_DAO->Update_PROYECTO($DataSet_PROYECTO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[35][0];

            $mensaje = $procedure_parametrosMS[36][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROYECTO = array();
            $Objeto_PROYECTO_DAO = new PROYECTO_DAO();
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
            $Objeto_PROYECTO_DAO->Delete_PROYECTO($DataSet_PROYECTO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_PORTAFOLIO_PROYECTO_1 = array();
        $Objeto_IDE_PORTAFOLIO_DAO = new GEN_PORTAFOLIO_PROYECTO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PORTAFOLIO,DES_PORTAFOLIO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PORTAFOLIO_DAO->SelCampos_GEN_PORTAFOLIO_PROYECTO($DataSet_GEN_PORTAFOLIO_PROYECTO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_PORTAFOLIO_PROYECTO_1', $DataSet_GEN_PORTAFOLIO_PROYECTO_1);

        /* 					 */

        $DataSet_GEN_PROGRAMA_PROYECTO_1 = array();
        $Objeto_IDE_PROGRAMA_DAO = new GEN_PROGRAMA_PROYECTO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_PROGRAMA,DES_PROGRAMA";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_PROGRAMA_DAO->SelCampos_GEN_PROGRAMA_PROYECTO($DataSet_GEN_PROGRAMA_PROYECTO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_PROGRAMA_PROYECTO_1', $DataSet_GEN_PROGRAMA_PROYECTO_1);

        /* 					 */

        $DataSet_GEN_CENTRO_COSTO_1 = array();
        $Objeto_IDE_CENCOSTO_DAO = new GEN_CENTRO_COSTO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CENCOSTO,DES_CENCOSTO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_CENCOSTO_DAO->SelCampos_GEN_CENTRO_COSTO($DataSet_GEN_CENTRO_COSTO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_CENTRO_COSTO_1', $DataSet_GEN_CENTRO_COSTO_1);

        /* 					 */

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

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_ETAPA_CONTRATO_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = " AND IDE_SECTOR=14  AND  NUM_NIVEL=3 ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ETAPA_CONTRATO_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_MONEDA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='62'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_MONEDA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_PROYECTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='58'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_PROYECTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_TIP_GRUPO_PROYECTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='63'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_GRUPO_PROYECTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_EST_PROYECTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='61'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROYECTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE) ;
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;