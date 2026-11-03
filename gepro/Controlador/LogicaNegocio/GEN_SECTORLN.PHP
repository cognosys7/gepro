<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Propósito       : GEN_SECTORLN de la tabla GEN_SECTOR
  //  Fecha           : martes, 31 de octubre de 2017 03:00:39 p.m.
  //  Desde el Modelo : PDM AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_SECTORDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_SECTOR";
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
        $COD_SECTOR = isset($_REQUEST['COD_SECTOR']) ? VerificarInputs($_REQUEST['COD_SECTOR']) : "";
        $DES_SECTOR = isset($_REQUEST['DES_SECTOR']) ? VerificarInputs($_REQUEST['DES_SECTOR']) : "";
        $DES_SECTOR_ABREVIATURA = isset($_REQUEST['DES_SECTOR_ABREVIATURA']) ? VerificarInputs($_REQUEST['DES_SECTOR_ABREVIATURA']) : "";
        $EST_SECTOR = isset($_REQUEST['EST_SECTOR']) ? VerificarInputs($_REQUEST['EST_SECTOR']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_SECTOR_DAO();
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
            $ogridDAO->Count_GEN_SECTOR($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_SECTOR;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_SECTOR', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_SECTORM = array();
            $Objeto_GEN_SECTOR_DAO = new GEN_SECTOR_DAO();
            $lstparametrosM = array();
            $lstparametrosM['COD_SECTOR'] = $COD_SECTOR;
            $lstparametrosM['DES_SECTOR'] = $DES_SECTOR;
            $lstparametrosM['DES_SECTOR_ABREVIATURA'] = $DES_SECTOR_ABREVIATURA;
            $lstparametrosM['EST_SECTOR'] = $EST_SECTOR;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['COD_SECTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SECTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_SECTOR_ABREVIATURA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_SECTOR'], SQLSRV_PARAM_IN), 
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_SECTOR_DAO->Insert_GEN_SECTOR($DataSet_GEN_SECTOR, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_SECTOR = array();
            $Objeto_GEN_SECTOR_DAO = new GEN_SECTOR_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_SECTOR_DAO->SelPk_GEN_SECTOR($DataSet_GEN_SECTOR, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_SECTOR) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_SECTOR

                $COD_SECTOR = $DataSet_GEN_SECTOR[0]->COD_SECTOR;
                $DES_SECTOR = $DataSet_GEN_SECTOR[0]->DES_SECTOR;
                $DES_SECTOR_ABREVIATURA = $DataSet_GEN_SECTOR[0]->DES_SECTOR_ABREVIATURA;
                $EST_SECTOR = $DataSet_GEN_SECTOR[0]->EST_SECTOR;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('COD_SECTOR', $COD_SECTOR);
            $lCollection->Add('DES_SECTOR', $DES_SECTOR);
            $lCollection->Add('DES_SECTOR_ABREVIATURA', $DES_SECTOR_ABREVIATURA);
            $lCollection->Add('EST_SECTOR', $EST_SECTOR);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_SECTOR = array();
            $Objeto_GEN_SECTOR_DAO = new GEN_SECTOR_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $lstparametrosM['COD_SECTOR'] = $COD_SECTOR;
            $lstparametrosM['DES_SECTOR'] = $DES_SECTOR;
            $lstparametrosM['DES_SECTOR_ABREVIATURA'] = $DES_SECTOR_ABREVIATURA;
            $lstparametrosM['EST_SECTOR'] = $EST_SECTOR;
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_SECTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SECTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_SECTOR_ABREVIATURA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_SECTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_SECTOR_DAO->Update_GEN_SECTOR($DataSet_GEN_SECTOR, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[5][0];

            $mensaje = $procedure_parametrosMS[6][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
            
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_SECTOR = array();
            $Objeto_GEN_SECTOR_DAO = new GEN_SECTOR_DAO();
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
            $Objeto_GEN_SECTOR_DAO->Delete_GEN_SECTOR($DataSet_GEN_SECTOR, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS = array();
        $Objeto_EST_SECTOR_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_SECTOR_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS', $DataSet_GEN_TABLAS);

        /* 					 */
    }
}

//var_dump($lstDepartamento);exit;