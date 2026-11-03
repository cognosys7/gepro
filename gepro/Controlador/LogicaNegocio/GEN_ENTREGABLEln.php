<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ENTREGABLELN de la tabla GEN_ENTREGABLE
  //  Fecha           : martes, 4 de junio de 2019 20:06:50
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTREGABLEDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_INTERVENCIONDAO.php");
//require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTREGABLEDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/GEN_ENTREGABLElni.php");
require_once("include/GEN_INTERVENCIONlni.php");
//// busqueda lni
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_ENTREGABLE";
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
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_FASE_COMPONENTE = isset($_REQUEST['IDE_FASE_COMPONENTE']) ? VerificarInputs($_REQUEST['IDE_FASE_COMPONENTE']) : "";
        $GEN_IDE_ENTREGABLE = isset($_REQUEST['GEN_IDE_ENTREGABLE']) ? VerificarInputs($_REQUEST['GEN_IDE_ENTREGABLE']) : "";
        $DES_ENTREGABLE = isset($_REQUEST['DES_ENTREGABLE']) ? VerificarInputs($_REQUEST['DES_ENTREGABLE']) : "";
        $DES_ABREVIATURA = isset($_REQUEST['DES_ABREVIATURA']) ? VerificarInputs($_REQUEST['DES_ABREVIATURA']) : "";
        $NUM_NIVEL = isset($_REQUEST['NUM_NIVEL']) ? VerificarInputs($_REQUEST['NUM_NIVEL']) : "";
        $NUM_ORDEN = isset($_REQUEST['NUM_ORDEN']) ? VerificarInputs($_REQUEST['NUM_ORDEN']) : "";
        $EST_ENTREGABLE = isset($_REQUEST['EST_ENTREGABLE']) ? VerificarInputs($_REQUEST['EST_ENTREGABLE']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_ENTREGABLE';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.GEN_IDE_ENTREGABLE=$PIDE";
             $pAuxiliar = '';
            $lCollection->Add('VNUM_NIVEL', '2' );  
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
            
            $Data = Entregable_Datos($PIDE);
            $lCollection->Add('VIDE_FASE_COMPONENTE_superior', $Data['IDE_FASE_COMPONENTE'] );
       } 
       else {
             $ScriptFLX = $ScriptFLX." AND T.NUM_NIVEL=1 ";
             $pAuxiliar = 'Anidado';
             $lCollection->Add('VNUM_NIVEL', '1' ); 
       } 
       
       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_ENTREGABLE_pAuxiliar' : $TipoGrilla ) ;
       
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_GEN_ENTREGABLE_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_ENTREGABLE_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'IDE_FASE_COMPONENTE') {
                        $_POST['qtype'] = 'GI.DES_INTERVENCION';
                    }

                    if ($_POST['qtype'] == 'DES_ENTREGABLE') {
                        $_POST['qtype'] = 'T.DES_ENTREGABLE';
                    }
                    if ($_POST['qtype'] == 'DES_ABREVIATURA') {
                        $_POST['qtype'] = 'T.DES_ABREVIATURA';
                    }
                    if ($_POST['qtype'] == 'NUM_NIVEL') {
                        $_POST['qtype'] = 'T.NUM_NIVEL';
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
            $ogridDAO->Count_GEN_ENTREGABLE($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_ENTREGABLE;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
            //echo 'entre'; exit;
            $Data = Entregable_Datos($PIDEbuscado);
            $Data1 = GenIntervencion_Datos($Data['IDE_FASE_COMPONENTE']);
            $Bdescripcion = $Data['DES_ENTREGABLE'] ; //.' ( '. $Data1['DES_INTERVENCION'] .' ) ' ;
            
            $lCollection->Add('BIDE', $Data['BIDE']);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_ENTREGABLEM = array();
            $Objeto_GEN_ENTREGABLE_DAO = new GEN_ENTREGABLE_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_FASE_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_FASE_COMPONENTE'] = $IDE_FASE_COMPONENTE;
            }
            if (strlen(rtrim($GEN_IDE_ENTREGABLE)) > 0) {
                $lstparametrosM['GEN_IDE_ENTREGABLE'] = $GEN_IDE_ENTREGABLE;
            }
            if (strlen(rtrim($DES_ENTREGABLE)) > 0) {
                $lstparametrosM['DES_ENTREGABLE'] = $DES_ENTREGABLE;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($NUM_ORDEN)) > 0) {
                $lstparametrosM['NUM_ORDEN'] = $NUM_ORDEN;
            }
            if (strlen(rtrim($EST_ENTREGABLE)) > 0) {
                $lstparametrosM['EST_ENTREGABLE'] = $EST_ENTREGABLE;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_FASE_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GEN_IDE_ENTREGABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ENTREGABLE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_ORDEN'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ENTREGABLE_DAO->Insert_GEN_ENTREGABLE($DataSet_GEN_ENTREGABLE, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_ENTREGABLE = array();
            $Objeto_GEN_ENTREGABLE_DAO = new GEN_ENTREGABLE_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_ENTREGABLE_DAO->SelPk_GEN_ENTREGABLE($DataSet_GEN_ENTREGABLE, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_ENTREGABLE) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_ENTREGABLE

                $IDE_FASE_COMPONENTE = $DataSet_GEN_ENTREGABLE[0]->IDE_FASE_COMPONENTE;
                $GEN_IDE_ENTREGABLE = $DataSet_GEN_ENTREGABLE[0]->GEN_IDE_ENTREGABLE;
                $DES_ENTREGABLE = $DataSet_GEN_ENTREGABLE[0]->DES_ENTREGABLE;
                $DES_ABREVIATURA = $DataSet_GEN_ENTREGABLE[0]->DES_ABREVIATURA;
                $NUM_NIVEL = $DataSet_GEN_ENTREGABLE[0]->NUM_NIVEL;
                $NUM_ORDEN = $DataSet_GEN_ENTREGABLE[0]->NUM_ORDEN;
                $EST_ENTREGABLE = $DataSet_GEN_ENTREGABLE[0]->EST_ENTREGABLE;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_FASE_COMPONENTE', $IDE_FASE_COMPONENTE);
            $lCollection->Add('GEN_IDE_ENTREGABLE', $GEN_IDE_ENTREGABLE);
            $lCollection->Add('DES_ENTREGABLE', $DES_ENTREGABLE);
            $lCollection->Add('DES_ABREVIATURA', $DES_ABREVIATURA);
            $lCollection->Add('NUM_NIVEL', $NUM_NIVEL);
            $lCollection->Add('NUM_ORDEN', $NUM_ORDEN);
            $lCollection->Add('EST_ENTREGABLE', $EST_ENTREGABLE);

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
            $DataSet_GEN_ENTREGABLE = array();
            $Objeto_GEN_ENTREGABLE_DAO = new GEN_ENTREGABLE_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_FASE_COMPONENTE)) > 0) {
                $lstparametrosM['IDE_FASE_COMPONENTE'] = $IDE_FASE_COMPONENTE;
            }
            if (strlen(rtrim($GEN_IDE_ENTREGABLE)) > 0) {
                $lstparametrosM['GEN_IDE_ENTREGABLE'] = $GEN_IDE_ENTREGABLE;
            }
            if (strlen(rtrim($DES_ENTREGABLE)) > 0) {
                $lstparametrosM['DES_ENTREGABLE'] = $DES_ENTREGABLE;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($NUM_ORDEN)) > 0) {
                $lstparametrosM['NUM_ORDEN'] = $NUM_ORDEN;
            }
            if (strlen(rtrim($EST_ENTREGABLE)) > 0) {
                $lstparametrosM['EST_ENTREGABLE'] = $EST_ENTREGABLE;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_FASE_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GEN_IDE_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_ORDEN'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ENTREGABLE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ENTREGABLE_DAO->Update_GEN_ENTREGABLE($DataSet_GEN_ENTREGABLE, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[9][0];

            $mensaje = $procedure_parametrosMS[10][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_ENTREGABLE = array();
            $Objeto_GEN_ENTREGABLE_DAO = new GEN_ENTREGABLE_DAO();
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
            $Objeto_GEN_ENTREGABLE_DAO->Delete_GEN_ENTREGABLE($DataSet_GEN_ENTREGABLE, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_INTERVENCION_1 = array();
        $Objeto_IDE_FASE_COMPONENTE_DAO = new GEN_INTERVENCION_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_INTERVENCION,DES_INTERVENCION";
        $lstparametrosM['filtro'] = " AND IDE_SECTOR=14 AND EST_INTERVENCION<>2 AND NUM_NIVEL=3 ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_FASE_COMPONENTE_DAO->SelCampos_GEN_INTERVENCION($DataSet_GEN_INTERVENCION_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_INTERVENCION_1', $DataSet_GEN_INTERVENCION_1);

        /* 					 */

        $DataSet_GEN_ENTREGABLE_1 = array();
        $Objeto_GEN_IDE_ENTREGABLE_DAO = new GEN_ENTREGABLE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTREGABLE,DES_ENTREGABLE";
        $lstparametrosM['filtro'] = "AND NUM_NIVEL=1";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_GEN_IDE_ENTREGABLE_DAO->SelCampos_GEN_ENTREGABLE($DataSet_GEN_ENTREGABLE_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTREGABLE_1', $DataSet_GEN_ENTREGABLE_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_ENTREGABLE_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ENTREGABLE_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        $lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;

        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;