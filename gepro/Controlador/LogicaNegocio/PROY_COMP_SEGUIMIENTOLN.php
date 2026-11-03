<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : PROY_COMP_SEGUIMIENTOLN de la tabla PROY_COMP_SEGUIMIENTO
  //  Fecha           : viernes, 17 de mayo de 2019 22:48:03
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMP_SEGUIMIENTODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");





/* EDGAR */
require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/GEN_INTERVENCIONlni.php");

require_once("include/PROY_COMPONENTElni.php");
require_once("include/PROY_CARTERAlni.php");
require_once("include/GEN_MODO_EJECUCIONlni.php");
require_once("include/GEN_COMPONENTElni.php");

require_once("include/GEN_ESTADOlni.php");
/* EDGAR */




function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_COMP_SEGUIMIENTO";
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
        
        
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $DES_SEGUIMIENTO = isset($_REQUEST['DES_SEGUIMIENTO']) ? VerificarInputs($_REQUEST['DES_SEGUIMIENTO']) : "";
        $EST_SEGUIMIENTO = isset($_REQUEST['EST_SEGUIMIENTO']) ? VerificarInputs($_REQUEST['EST_SEGUIMIENTO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND  T.IDE_PROY_COMPONENTE=".$PIDE;
             $IDE_PROY_COMPONENTE = $PIDE ;
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
        $PIDE_PROYECTO = '' ;
        
        
        $Data1 = ProyectoComponente_Datos($PIDE);
        $PIDE_PROYECTO_ACTIVIDAD = $Data1['IDE_PROYECTO_ACTIVIDAD'] ;
        $PIDE_CARTERA = $Data1['IDE_CARTERA'] ;
        $PIDE_MODO_EJECUCION = $Data1['IDE_MODO_EJECUCION'] ;
        $PIDE_COMPONENTE = $Data1['IDE_COMPONENTE'] ;
        $lCollection->Add('VIDE_PROYECTO', $PIDE_PROYECTO ) ;
        
        $Data2 = ProyectoActividad_Datos($PIDE_PROYECTO_ACTIVIDAD);
        $PIDE_PROYECTO = $Data2['IDE_PROYECTO'] ;
        $PIDE_INTERVENCION = $Data2['IDE_INTERVENCION'] ;
        $lCollection->Add('VIDE_PROYECTO', $PIDE_PROYECTO ) ;
        
        $Data3 = ProyectoContrato_Datos2($PIDE_PROYECTO_ACTIVIDAD,$PIDE_PROYECTO);
        $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
        
        $Data4 = GenIntervencion_Datos($PIDE_INTERVENCION ) ;
        
        $Data5 = Cartera_Datos($PIDE_CARTERA);
        $lCollection->Add('VDES_CARTERA', $Data5['DES_CARTERA'] ) ;
        
        $Data6 = ModoEjecucion_Datos($PIDE_MODO_EJECUCION);
        $lCollection->Add('VDES_MODO_EJECUCION', $Data6['DES_MODO_EJECUCION'] ) ;
        
        $Data7 = Componente_Datos($PIDE_COMPONENTE);
        $lCollection->Add('VDES_COMPONENTE', $Data7['DES_COMPONENTE'] ) ;
        
        $Data8 = ProyectoContrato_Datos2($PIDE_PROYECTO_ACTIVIDAD,$PIDE_PROYECTO);
        $Data9 = Contrato_Datos($Data8['IDE_CONTRATO']);
        
        $Data10 = Estado_Datos($Data1['IDE_ESTADO']);
        
       $DatosPadre = Tabla_Proyecto_Datos($PIDE_PROYECTO) .'<hr>'. Tabla_ProyectoComponente_Datos($Data9['COD_UNICO_ORDEN'] . ' - ' . $Data9['DES_CONTRATO'], $Data4['DES_INTERVENCION'], '$VFEC_INICIO_CONTRATO', '$VFEC_TERMINO_CONTRATO', $Data7['DES_COMPONENTE'], $Data5['DES_CARTERA'], $Data10['DES_ESTADO'], $Data1['IMP_COMPONENTE']);
        $lCollection->Add('DatosPadre', $DatosPadre ) ;
//        Tabla_ProyectoComponente_Datos2
       } else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_COMP_SEGUIMIENTO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_SEGUIMIENTO') {
                        $_POST['qtype'] = 'T.DES_SEGUIMIENTO';
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
            $ogridDAO->Count_PROY_COMP_SEGUIMIENTO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_SEGUIMIENTO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_COMP_SEGUIMIENTO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROY_COMP_SEGUIMIENTOM = array();
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO = new PROY_COMP_SEGUIMIENTO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
            }
            if (strlen(rtrim($DES_SEGUIMIENTO)) > 0) {
                $lstparametrosM['DES_SEGUIMIENTO'] = $DES_SEGUIMIENTO;
            }
            if (strlen(rtrim($EST_SEGUIMIENTO)) > 0) {
                $lstparametrosM['EST_SEGUIMIENTO'] = $EST_SEGUIMIENTO;
            } 
            
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SEGUIMIENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO->Insert_PROY_COMP_SEGUIMIENTO($DataSet_PROY_COMP_SEGUIMIENTO, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_COMP_SEGUIMIENTO = array();
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO = new PROY_COMP_SEGUIMIENTO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO->SelPk_PROY_COMP_SEGUIMIENTO($DataSet_PROY_COMP_SEGUIMIENTO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_COMP_SEGUIMIENTO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_COMP_SEGUIMIENTO

                $IDE_PROY_COMPONENTE = $DataSet_PROY_COMP_SEGUIMIENTO[0]->IDE_PROY_COMPONENTE;
                $DES_SEGUIMIENTO = $DataSet_PROY_COMP_SEGUIMIENTO[0]->DES_SEGUIMIENTO;
                $EST_SEGUIMIENTO = $DataSet_PROY_COMP_SEGUIMIENTO[0]->EST_SEGUIMIENTO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROY_COMPONENTE', $IDE_PROY_COMPONENTE);
            $lCollection->Add('DES_SEGUIMIENTO', $DES_SEGUIMIENTO);
            $lCollection->Add('EST_SEGUIMIENTO', $EST_SEGUIMIENTO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_COMP_SEGUIMIENTO = array();
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO = new PROY_COMP_SEGUIMIENTO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROY_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_PROY_COMPONENTE'] = $IDE_PROY_COMPONENTE;
            }
            if (strlen(rtrim($DES_SEGUIMIENTO)) > 0) {
                $lstparametrosM['DES_SEGUIMIENTO'] = $DES_SEGUIMIENTO;
            }
            if (strlen(rtrim($EST_SEGUIMIENTO)) > 0) {
                $lstparametrosM['EST_SEGUIMIENTO'] = $EST_SEGUIMIENTO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROY_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_SEGUIMIENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO->Update_PROY_COMP_SEGUIMIENTO($DataSet_PROY_COMP_SEGUIMIENTO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[5][0];

            $mensaje = $procedure_parametrosMS[6][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_COMP_SEGUIMIENTO = array();
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO = new PROY_COMP_SEGUIMIENTO_DAO();
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
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO->Delete_PROY_COMP_SEGUIMIENTO($DataSet_PROY_COMP_SEGUIMIENTO, $procedure_parametrosMS); //JCMY
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
        $Objeto_EST_SEGUIMIENTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_SEGUIMIENTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;