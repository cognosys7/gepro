<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : CONT_CAL_CONTENIDOLN de la tabla CONT_CAL_CONTENIDO
  //  Fecha           : miércoles, 5 de junio de 2019 4:08:03
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/CONT_CAL_CONTENIDODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTREGABLEDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/CONT_CALIDADlni.php");
require_once("include/GEN_ENTREGABLElni.php");

require_once("include/PROYECTOlni.php");

require_once("include/PROY_CONTRATOlni.php");
require_once("include/CONTRATOlni.php");

require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/GEN_INTERVENCIONlni.php");
//// busqueda lni
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "CONT_CAL_CONTENIDO";
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
        $Entregable = isset($_REQUEST['Entregable']) ? VerificarInputs($_REQUEST['Entregable']) : "";
        $Contrato = isset($_REQUEST['Contrato']) ? VerificarInputs($_REQUEST['Contrato']) : "";
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_CONT_CALIDAD = isset($_REQUEST['IDE_CONT_CALIDAD']) ? VerificarInputs($_REQUEST['IDE_CONT_CALIDAD']) : "";
        $IDE_ENTREGABLE = isset($_REQUEST['IDE_ENTREGABLE']) ? VerificarInputs($_REQUEST['IDE_ENTREGABLE']) : "";
        $DES_OBSERV_CONTENIDO = isset($_REQUEST['DES_OBSERV_CONTENIDO']) ? VerificarInputs($_REQUEST['DES_OBSERV_CONTENIDO']) : "";
        $EST_CAL_CONTENIDO = isset($_REQUEST['EST_CAL_CONTENIDO']) ? VerificarInputs($_REQUEST['EST_CAL_CONTENIDO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_CONT_CAL_CONTENIDO';

        if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_CONT_CALIDAD=$PIDE";
//             $pAuxiliar = '';
            $Data = ContratoCalidad_Datos($PIDE);
            $VIDE_ENTREGABLE_padre = $Data['IDE_ENTREGABLE'];
            
            $Data0 = ContratoCalidad_Datos($PIDE);
            
            $Data4 = ProyectoActividad_Datos($Data0['IDE_CONTRATO']);
            $lCollection->Add('VIDE_INTERVENCION', $Data4['IDE_INTERVENCION'] ) ;
            $lCollection->Add('VIDE_PROYECTO', $Data4['IDE_PROYECTO']) ;
            $IdeFaseComponente = $Data4['IDE_INTERVENCION'];
            
            $Data3 = ProyectoContrato_Datos2($Data0['IDE_CONTRATO'],$Data4['IDE_PROYECTO']);
            $lCollection->Add('VIDE_CONTRATO', $Data3['IDE_CONTRATO'] ) ;
            
            $Data5 = Entregable_Datos($Data0['IDE_ENTREGABLE']);
            $lCollection->Add('VDES_ENTREGABLE', $Data5['DES_ENTREGABLE']) ;
                 
        } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_CONT_CAL_CONTENIDO_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new CONT_CAL_CONTENIDO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'IDE_ENTREGABLE') {
                        $_POST['qtype'] = 'GE.DES_ENTREGABLE';
                    }
                    if ($_POST['qtype'] == 'DES_OBSERV_CONTENIDO') {
                        $_POST['qtype'] = 'T.DES_OBSERV_CONTENIDO';
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
            $ogridDAO->Count_CONT_CAL_CONTENIDO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CAL_CONTENIDO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
//            $Data = Interesados_Datos($PIDEbuscado);
//            $Data1 = Recurso_Datos($Data'IDE_RECURSO');
//            $Data2 = Cargo_Datos($Data'IDE_PUESTO');
//            $Bdescripcion = $Data1'DES_RECURSO' .' ( '. $Data2'DES_CARGO' .' ) ' ;
//            $lCollection->Add('BIDE', $Data'BIDE');
//            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_CONT_CAL_CONTENIDOM = array();
            $Objeto_CONT_CAL_CONTENIDO_DAO = new CONT_CAL_CONTENIDO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_CONT_CALIDAD)) > 0) {
                $lstparametrosM['IDE_CONT_CALIDAD'] = $IDE_CONT_CALIDAD;
            }
            if (strlen(rtrim($IDE_ENTREGABLE)) > 0) {
                $lstparametrosM['IDE_ENTREGABLE'] = $IDE_ENTREGABLE;
            }
            if (strlen(rtrim($DES_OBSERV_CONTENIDO)) > 0) {
                $lstparametrosM['DES_OBSERV_CONTENIDO'] = $DES_OBSERV_CONTENIDO;
            }
            if (strlen(rtrim($EST_CAL_CONTENIDO)) > 0) {
                $lstparametrosM['EST_CAL_CONTENIDO'] = $EST_CAL_CONTENIDO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_CONT_CALIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTREGABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_OBSERV_CONTENIDO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CAL_CONTENIDO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_CAL_CONTENIDO_DAO->Insert_CONT_CAL_CONTENIDO($DataSet_CONT_CAL_CONTENIDO, $procedure_parametrosMS); //JCMY

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
            $DataSet_CONT_CAL_CONTENIDO = array();
            $Objeto_CONT_CAL_CONTENIDO_DAO = new CONT_CAL_CONTENIDO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_CONT_CAL_CONTENIDO_DAO->SelPk_CONT_CAL_CONTENIDO($DataSet_CONT_CAL_CONTENIDO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_CONT_CAL_CONTENIDO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_CONT_CAL_CONTENIDO

                $IDE_CONT_CALIDAD = $DataSet_CONT_CAL_CONTENIDO[0]->IDE_CONT_CALIDAD;
                $IDE_ENTREGABLE = $DataSet_CONT_CAL_CONTENIDO[0]->IDE_ENTREGABLE;
                $DES_OBSERV_CONTENIDO = $DataSet_CONT_CAL_CONTENIDO[0]->DES_OBSERV_CONTENIDO;
                $EST_CAL_CONTENIDO = $DataSet_CONT_CAL_CONTENIDO[0]->EST_CAL_CONTENIDO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_CONT_CALIDAD', $IDE_CONT_CALIDAD);
            $lCollection->Add('IDE_ENTREGABLE', $IDE_ENTREGABLE);
            $lCollection->Add('DES_OBSERV_CONTENIDO', $DES_OBSERV_CONTENIDO);
            $lCollection->Add('EST_CAL_CONTENIDO', $EST_CAL_CONTENIDO);

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data = Comunidad_Datos($IDE_COMUNIDAD);
            //$Data1 = UBIGEO_Datos($Data'COD_UBIGEO');
            //$Bdescripcion = $Data'DES_COMUNIDAD' .' ( '. $Data1'DES_DEPARTAMENTO' .' - '. $Data1'DES_PROVINCIA' .' - '. $Data1'DES_DISTRITO' . ' )' ;
            //$lCollection->Add('Bdescripcion', $Bdescripcion);
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_CONT_CAL_CONTENIDO = array();
            $Objeto_CONT_CAL_CONTENIDO_DAO = new CONT_CAL_CONTENIDO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_CONT_CALIDAD)) > 0) {
                $lstparametrosM['IDE_CONT_CALIDAD'] = $IDE_CONT_CALIDAD;
            }
            if (strlen(rtrim($IDE_ENTREGABLE)) > 0) {
                $lstparametrosM['IDE_ENTREGABLE'] = $IDE_ENTREGABLE;
            }
            if (strlen(rtrim($DES_OBSERV_CONTENIDO)) > 0) {
                $lstparametrosM['DES_OBSERV_CONTENIDO'] = $DES_OBSERV_CONTENIDO;
            }
            if (strlen(rtrim($EST_CAL_CONTENIDO)) > 0) {
                $lstparametrosM['EST_CAL_CONTENIDO'] = $EST_CAL_CONTENIDO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONT_CALIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_OBSERV_CONTENIDO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CAL_CONTENIDO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_CONT_CAL_CONTENIDO_DAO->Update_CONT_CAL_CONTENIDO($DataSet_CONT_CAL_CONTENIDO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[6][0];

            $mensaje = $procedure_parametrosMS[7][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_CONT_CAL_CONTENIDO = array();
            $Objeto_CONT_CAL_CONTENIDO_DAO = new CONT_CAL_CONTENIDO_DAO();
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
            $Objeto_CONT_CAL_CONTENIDO_DAO->Delete_CONT_CAL_CONTENIDO($DataSet_CONT_CAL_CONTENIDO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_ENTREGABLE_1 = array();
        $Objeto_IDE_ENTREGABLE_DAO = new GEN_ENTREGABLE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTREGABLE,DES_ENTREGABLE";
        $lstparametrosM['filtro'] = " AND NUM_NIVEL=2 and GEN_IDE_ENTREGABLE=".$VIDE_ENTREGABLE_padre;

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ENTREGABLE_DAO->SelCampos_GEN_ENTREGABLE($DataSet_GEN_ENTREGABLE_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTREGABLE_1', $DataSet_GEN_ENTREGABLE_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_CAL_CONTENIDO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CAL_CONTENIDO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('Entregable', $Entregable);
        $lCollection->Add('Contrato', $Contrato);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;