<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Hector Lopez Sanchez
  //  Propósito       : PROC_UNIDAD_MEDIDALN de la tabla PROC_UNIDAD_MEDIDA
  //  Fecha           : miércoles, 1 de noviembre de 2017 09:39:47
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROC_UNIDAD_MEDIDADAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROC_UNIDAD_MEDIDA";
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
        $UNIDAD_MEDIDA = isset($_REQUEST['UNIDAD_MEDIDA']) ? VerificarInputs($_REQUEST['UNIDAD_MEDIDA']) : "";
        $EST_UNIDAD_MEDIDA = isset($_REQUEST['EST_UNIDAD_MEDIDA']) ? VerificarInputs($_REQUEST['EST_UNIDAD_MEDIDA']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROC_UNIDAD_MEDIDA_DAO();
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
            $ogridDAO->Count_PROC_UNIDAD_MEDIDA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_UNIDAD_MEDIDA;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROC_UNIDAD_MEDIDA', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROC_UNIDAD_MEDIDAM = array();
            $Objeto_PROC_UNIDAD_MEDIDA_DAO = new PROC_UNIDAD_MEDIDA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['UNIDAD_MEDIDA'] = $UNIDAD_MEDIDA;
            $lstparametrosM['EST_UNIDAD_MEDIDA'] = $EST_UNIDAD_MEDIDA;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['UNIDAD_MEDIDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_UNIDAD_MEDIDA_DAO->Insert_PROC_UNIDAD_MEDIDA($DataSet_PROC_UNIDAD_MEDIDA, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[3][0];

            $mensaje = $procedure_parametrosMS[4][0];

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
            $DataSet_PROC_UNIDAD_MEDIDA = array();
            $Objeto_PROC_UNIDAD_MEDIDA_DAO = new PROC_UNIDAD_MEDIDA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROC_UNIDAD_MEDIDA_DAO->SelPk_PROC_UNIDAD_MEDIDA($DataSet_PROC_UNIDAD_MEDIDA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROC_UNIDAD_MEDIDA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROC_UNIDAD_MEDIDA

                $UNIDAD_MEDIDA = $DataSet_PROC_UNIDAD_MEDIDA[0]->UNIDAD_MEDIDA;
                $EST_UNIDAD_MEDIDA = $DataSet_PROC_UNIDAD_MEDIDA[0]->EST_UNIDAD_MEDIDA;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('UNIDAD_MEDIDA', $UNIDAD_MEDIDA);
            $lCollection->Add('EST_UNIDAD_MEDIDA', $EST_UNIDAD_MEDIDA);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROC_UNIDAD_MEDIDA = array();
            $Objeto_PROC_UNIDAD_MEDIDA_DAO = new PROC_UNIDAD_MEDIDA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $lstparametrosM['UNIDAD_MEDIDA'] = $UNIDAD_MEDIDA;
            $lstparametrosM['EST_UNIDAD_MEDIDA'] = $EST_UNIDAD_MEDIDA;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['UNIDAD_MEDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROC_UNIDAD_MEDIDA_DAO->Update_PROC_UNIDAD_MEDIDA($DataSet_PROC_UNIDAD_MEDIDA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[4][0];

            $mensaje = $procedure_parametrosMS[5][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROC_UNIDAD_MEDIDA = array();
            $Objeto_PROC_UNIDAD_MEDIDA_DAO = new PROC_UNIDAD_MEDIDA_DAO();
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
            $Objeto_PROC_UNIDAD_MEDIDA_DAO->Delete_PROC_UNIDAD_MEDIDA($DataSet_PROC_UNIDAD_MEDIDA, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS = array();
        $Objeto_EST_UNIDAD_MEDIDA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_UNIDAD_MEDIDA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS', $DataSet_GEN_TABLAS);

        /* 					 */
        
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
    }
}

//var_dump($lstDepartamento);exit;