<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : GEN_INTERVENCIONLN de la tabla GEN_INTERVENCION
  //  Fecha           : viernes, 3 de mayo de 2019 18:42:57
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-C
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


//require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/GEN_INTERVENCIONLNI.php");
require_once("include/GEN_TABLASLNI.php");
require_once("include/GEN_SECTORLNI.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_INTERVENCION";
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
        $IDE_SECTOR = isset($_REQUEST['IDE_SECTOR']) ? VerificarInputs($_REQUEST['IDE_SECTOR']) : "";
        $DES_INTERVENCION = isset($_REQUEST['DES_INTERVENCION']) ? VerificarInputs($_REQUEST['DES_INTERVENCION']) : "";
        $NUM_NIVEL = isset($_REQUEST['NUM_NIVEL']) ? VerificarInputs($_REQUEST['NUM_NIVEL']) : "";
        $IDE_INTERVENCION_SUP = isset($_REQUEST['IDE_INTERVENCION_SUP']) ? VerificarInputs($_REQUEST['IDE_INTERVENCION_SUP']) : "";
        $DES_RUBRO = isset($_REQUEST['DES_RUBRO']) ? VerificarInputs($_REQUEST['DES_RUBRO']) : "";
        $TIP_SECTOR_PIRCC = isset($_REQUEST['TIP_SECTOR_PIRCC']) ? VerificarInputs($_REQUEST['TIP_SECTOR_PIRCC']) : "";
        $EST_INTERVENCION = isset($_REQUEST['EST_INTERVENCION']) ? VerificarInputs($_REQUEST['EST_INTERVENCION']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND DET.IDE_INTERVENCION_SUP=$PIDE ";
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
             $Data = GenIntervencion_Datos($PIDE);
             $lCollection->Add('VDES_INTERVENCION', $Data['DES_INTERVENCION'] );
             $lCollection->Add('VNUM_NIVEL', $Data['NUM_NIVEL'] );
             $lCollection->Add('VDES_RUBRO', $Data['DES_RUBRO'] );
             $lCollection->Add('VIDE_INTERVENCION_SUP_regActual', $PIDE );
//             
             $pAuxiliar = ( $Data['NUM_NIVEL']=='2' ? '' : 'Anidado' );
//             
             $Data1 = GenTablas_Datos('99',$Data['EST_INTERVENCION']);
             $lCollection->Add('VEstado', $Data1['DES_ITEM'] );
             
//             $Data2 = GenSector_Datos($Data['IDE_SECTOR']);             
       } else {
             $ScriptFLX = $ScriptFLX." AND DET.NUM_NIVEL=1 ";
             $pAuxiliar = 'Anidado';
       } 
       
        $Data2 = GenSector_Datos(14); // energias y minas
        $lCollection->Add('VIDE_SECTOR', $Data2['IDE_SECTOR'] );
        $lCollection->Add('VSector', $Data2['DES_SECTOR'] );
            
       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_INTERVENCION_pAuxiliar' : 'SelGrd_GEN_INTERVENCION' ) ;
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_INTERVENCION_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_SECTOR') {
                        $_POST['qtype'] = 'SEC.DES_SECTOR';
                    }
                    if ($_POST['qtype'] == 'DES_RUBRO') {
                        $_POST['qtype'] = 'DET.DES_RUBRO';
                    }
                    if ($_POST['qtype'] == 'DES_INTERVENCION') {
                        $_POST['qtype'] = 'DET.DES_INTERVENCION';
                    }
                    if ($_POST['qtype'] == 'DES_ITEM') {
                        $_POST['qtype'] = 'TAB.DES_ITEM';
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
            $ogridDAO->Count_GEN_INTERVENCION($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_INTERVENCION;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_INTERVENCIONM = array();
            $Objeto_GEN_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_SECTOR)) > 0) {
                $lstparametrosM['IDE_SECTOR'] = $IDE_SECTOR;
            }
            if (strlen(rtrim($DES_INTERVENCION)) > 0) {
                $lstparametrosM['DES_INTERVENCION'] = $DES_INTERVENCION;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($IDE_INTERVENCION_SUP)) > 0) {
                $lstparametrosM['IDE_INTERVENCION_SUP'] = $IDE_INTERVENCION_SUP;
            }
            if (strlen(rtrim($DES_RUBRO)) > 0) {
                $lstparametrosM['DES_RUBRO'] = $DES_RUBRO;
            }
            if (strlen(rtrim($TIP_SECTOR_PIRCC)) > 0) {
                $lstparametrosM['TIP_SECTOR_PIRCC'] = $TIP_SECTOR_PIRCC;
            }
            if (strlen(rtrim($EST_INTERVENCION)) > 0) {
                $lstparametrosM['EST_INTERVENCION'] = $EST_INTERVENCION;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_SECTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_INTERVENCION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_INTERVENCION_SUP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_RUBRO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_SECTOR_PIRCC'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_INTERVENCION_DAO->Insert_GEN_INTERVENCION($DataSet_GEN_INTERVENCION, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_INTERVENCION = array();
            $Objeto_GEN_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_INTERVENCION_DAO->SelPk_GEN_INTERVENCION($DataSet_GEN_INTERVENCION, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_INTERVENCION) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_INTERVENCION

                $IDE_SECTOR = $DataSet_GEN_INTERVENCION[0]->IDE_SECTOR;
                $DES_INTERVENCION = $DataSet_GEN_INTERVENCION[0]->DES_INTERVENCION;
                $NUM_NIVEL = $DataSet_GEN_INTERVENCION[0]->NUM_NIVEL;
                $IDE_INTERVENCION_SUP = $DataSet_GEN_INTERVENCION[0]->IDE_INTERVENCION_SUP;
                $DES_RUBRO = $DataSet_GEN_INTERVENCION[0]->DES_RUBRO;
                $TIP_SECTOR_PIRCC = $DataSet_GEN_INTERVENCION[0]->TIP_SECTOR_PIRCC;
                $EST_INTERVENCION = $DataSet_GEN_INTERVENCION[0]->EST_INTERVENCION;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_SECTOR', $IDE_SECTOR);
            $lCollection->Add('DES_INTERVENCION', $DES_INTERVENCION);
            $lCollection->Add('NUM_NIVEL', $NUM_NIVEL);
            $lCollection->Add('IDE_INTERVENCION_SUP', $IDE_INTERVENCION_SUP);
            $lCollection->Add('DES_RUBRO', $DES_RUBRO);
            $lCollection->Add('TIP_SECTOR_PIRCC', $TIP_SECTOR_PIRCC);
            $lCollection->Add('EST_INTERVENCION', $EST_INTERVENCION);
            
            
//            $Data = GenIntervencion_Datos($IDE_INTERVENCION_SUP);
//             $lCollection->Add('VDES_INTERVENCION', $Data['DES_INTERVENCION'] );
//             $lCollection->Add('VNUM_NIVEL', $Data['NUM_NIVEL'] );
//             $lCollection->Add('VDES_RUBRO', $Data['DES_RUBRO'] );
//             $lCollection->Add('VIDE_INTERVENCION_SUP', $IDE_INTERVENCION_SUP );
//             
//             $pAuxiliar = ( $Data['NUM_NIVEL']=='2' ? '' : 'Anidado' );
//             
//             $Data1 = GenTablas_Datos('99',$Data['EST_INTERVENCION']);
//             $lCollection->Add('VEstado', $Data1['DES_ITEM'] );
//             
//             $Data2 = GenSector_Datos($Data['IDE_SECTOR']);
//             $lCollection->Add('VSector', $Data2['DES_SECTOR'] );
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_INTERVENCION = array();
            $Objeto_GEN_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_SECTOR)) > 0) {
                $lstparametrosM['IDE_SECTOR'] = $IDE_SECTOR;
            }
            if (strlen(rtrim($DES_INTERVENCION)) > 0) {
                $lstparametrosM['DES_INTERVENCION'] = $DES_INTERVENCION;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($IDE_INTERVENCION_SUP)) > 0) {
                $lstparametrosM['IDE_INTERVENCION_SUP'] = $IDE_INTERVENCION_SUP;
            }
            if (strlen(rtrim($DES_RUBRO)) > 0) {
                $lstparametrosM['DES_RUBRO'] = $DES_RUBRO;
            }
            if (strlen(rtrim($TIP_SECTOR_PIRCC)) > 0) {
                $lstparametrosM['TIP_SECTOR_PIRCC'] = $TIP_SECTOR_PIRCC;
            }
            if (strlen(rtrim($EST_INTERVENCION)) > 0) {
                $lstparametrosM['EST_INTERVENCION'] = $EST_INTERVENCION;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_SECTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_INTERVENCION_SUP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_RUBRO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_SECTOR_PIRCC'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_INTERVENCION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_INTERVENCION_DAO->Update_GEN_INTERVENCION($DataSet_GEN_INTERVENCION, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[9][0];

            $mensaje = $procedure_parametrosMS[10][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_INTERVENCION = array();
            $Objeto_GEN_INTERVENCION_DAO = new GEN_INTERVENCION_DAO();
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
            $Objeto_GEN_INTERVENCION_DAO->Delete_GEN_INTERVENCION($DataSet_GEN_INTERVENCION, $procedure_parametrosMS); //JCMY
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

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_INTERVENCION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_INTERVENCION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('pAuxiliar', $pAuxiliar);
        
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;