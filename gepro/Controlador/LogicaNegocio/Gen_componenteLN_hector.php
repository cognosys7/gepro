<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_COMPONENTELN de la tabla GEN_COMPONENTE
  //  Fecha           : martes, 21 de noviembre de 2017 10:25:42 a.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_COMPONENTEDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_FASEDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_COMPONENTE";
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
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_FASE = isset($_REQUEST['IDE_FASE']) ? VerificarInputs($_REQUEST['IDE_FASE']) : "";
        $DES_COMPONENTE = isset($_REQUEST['DES_COMPONENTE']) ? VerificarInputs($_REQUEST['DES_COMPONENTE']) : "";
        $DES_ABREVIATURA = isset($_REQUEST['DES_ABREVIATURA']) ? VerificarInputs($_REQUEST['DES_ABREVIATURA']) : "";
        $EST_COMPONENTE = isset($_REQUEST['EST_COMPONENTE']) ? VerificarInputs($_REQUEST['EST_COMPONENTE']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_COMPONENTE_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'FASE') {
                        $_POST['qtype'] = 'GF.DES_FASE';
                    }
                    if ($_POST['qtype'] == 'COMPONENTE') {
                        $_POST['qtype'] = 'GC.DES_COMPONENTE';
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
            $ogridDAO->Count_GEN_COMPONENTE($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_COMPONENTE;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_COMPONENTE', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_COMPONENTEM = array();
            $Objeto_GEN_COMPONENTE_DAO = new GEN_COMPONENTE_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_FASE)) > 0) {
                $lstparametrosM['IDE_FASE'] = $IDE_FASE;
            }
            if (strlen(rtrim($DES_COMPONENTE)) > 0) {
                $lstparametrosM['DES_COMPONENTE'] = $DES_COMPONENTE;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($EST_COMPONENTE)) > 0) {
                $lstparametrosM['EST_COMPONENTE'] = $EST_COMPONENTE;
            }
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_FASE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_COMPONENTE'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_COMPONENTE'], SQLSRV_PARAM_IN), array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_COMPONENTE_DAO->Insert_GEN_COMPONENTE($DataSet_GEN_COMPONENTE, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_COMPONENTE = array();
            $Objeto_GEN_COMPONENTE_DAO = new GEN_COMPONENTE_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_COMPONENTE_DAO->SelPk_GEN_COMPONENTE($DataSet_GEN_COMPONENTE, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_COMPONENTE) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_COMPONENTE

                $IDE_FASE = $DataSet_GEN_COMPONENTE[0]->IDE_FASE;
                $DES_COMPONENTE = $DataSet_GEN_COMPONENTE[0]->DES_COMPONENTE;
                $DES_ABREVIATURA = $DataSet_GEN_COMPONENTE[0]->DES_ABREVIATURA;
                $EST_COMPONENTE = $DataSet_GEN_COMPONENTE[0]->EST_COMPONENTE;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_FASE', $IDE_FASE);
            $lCollection->Add('DES_COMPONENTE', $DES_COMPONENTE);
            $lCollection->Add('DES_ABREVIATURA', $DES_ABREVIATURA);
            $lCollection->Add('EST_COMPONENTE', $EST_COMPONENTE);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_COMPONENTE = array();
            $Objeto_GEN_COMPONENTE_DAO = new GEN_COMPONENTE_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_FASE)) > 0) {
                $lstparametrosM['IDE_FASE'] = $IDE_FASE;
            }
            if (strlen(rtrim($DES_COMPONENTE)) > 0) {
                $lstparametrosM['DES_COMPONENTE'] = $DES_COMPONENTE;
            }
            if (strlen(rtrim($DES_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_ABREVIATURA'] = $DES_ABREVIATURA;
            }
            if (strlen(rtrim($EST_COMPONENTE)) > 0) {
                $lstparametrosM['EST_COMPONENTE'] = $EST_COMPONENTE;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_FASE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ABREVIATURA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_COMPONENTE'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_COMPONENTE_DAO->Update_GEN_COMPONENTE($DataSet_GEN_COMPONENTE, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[6][0];

            $mensaje = $procedure_parametrosMS[7][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_COMPONENTE = array();
            $Objeto_GEN_COMPONENTE_DAO = new GEN_COMPONENTE_DAO();
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
            $Objeto_GEN_COMPONENTE_DAO->Delete_GEN_COMPONENTE($DataSet_GEN_COMPONENTE, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_FASE_1 = array();
        $Objeto_IDE_FASE_DAO = new GEN_FASE_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_FASE,DES_FASE";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_FASE_DAO->SelCampos_GEN_FASE($DataSet_GEN_FASE_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_FASE_1', $DataSet_GEN_FASE_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
    }
}

//var_dump($lstDepartamento);exit;