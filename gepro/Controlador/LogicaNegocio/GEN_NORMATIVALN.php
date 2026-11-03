<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio C�sar Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //  Prop�sito       : GEN_NORMATIVALN de la tabla GEN_NORMATIVA
  //  Fecha           : viernes, 5 de enero de 2018 14:38:20
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_NORMATIVADAO.php");
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
    $PaginaFormulario = "GEN_NORMATIVA";
    $PermisoOK = 0;

/***EDGAR---**************/    
    //OBTENGOS LOS POST ANTIREFRESH
    if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}
    
    //OBTENGO LAS SESIONES
    if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
    if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
    if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
    if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}	
    $PermisosPerfil = CallNomPerfil($perfilsession);
    $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);// echo $PermisosPerfil; die;
/***EDGAR---**************/


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
        $COD_NORMATIVA = isset($_REQUEST['COD_NORMATIVA']) ? VerificarInputs($_REQUEST['COD_NORMATIVA']) : "";
        $FEC_PUBLICACION = isset($_REQUEST['FEC_PUBLICACION']) ? VerificarInputs($_REQUEST['FEC_PUBLICACION']) : "";
        $IMP_NORMATIVA = isset($_REQUEST['IMP_NORMATIVA']) ? VerificarInputs($_REQUEST['IMP_NORMATIVA']) : "";
        $EST_NORMATIVA = isset($_REQUEST['EST_NORMATIVA']) ? VerificarInputs($_REQUEST['EST_NORMATIVA']) : "";
        
        
        $TIP_NORMATIVA = isset($_REQUEST['TIP_NORMATIVA']) ? VerificarInputs($_REQUEST['TIP_NORMATIVA']) : "";
        
        
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_NORMATIVA_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_NORMATIVA') {
                        $_POST['qtype'] = 'DECR.COD_NORMATIVA';
                    }
                    if ($_POST['qtype'] == 'FEC_PUBLICACION') {
                        $_POST['qtype'] = 'CONVERT(varchar(10),DECR.FEC_PUBLICACION, 103)';
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
            $ogridDAO->Count_GEN_NORMATIVA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_NORMATIVA;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_GEN_NORMATIVA', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_PUBLICACION) > 0) {
                $FEC_PUBLICACION = cambiafecha($FEC_PUBLICACION);
            } else {
                $FEC_PUBLICACION = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_GEN_NORMATIVAM = array();
            $Objeto_GEN_NORMATIVA_DAO = new GEN_NORMATIVA_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($COD_NORMATIVA)) > 0) {
                $lstparametrosM['COD_NORMATIVA'] = $COD_NORMATIVA;
            }
            if (strlen(rtrim($FEC_PUBLICACION)) > 0) {
                $lstparametrosM['FEC_PUBLICACION'] = $FEC_PUBLICACION;
            }
            if (strlen(rtrim($IMP_NORMATIVA)) > 0) {
                $lstparametrosM['IMP_NORMATIVA'] = $IMP_NORMATIVA;
            }
            if (strlen(rtrim($TIP_NORMATIVA)) > 0) {
                $lstparametrosM['TIP_NORMATIVA'] = $TIP_NORMATIVA;
            }
            if (strlen(rtrim($EST_NORMATIVA)) > 0) {
                $lstparametrosM['EST_NORMATIVA'] = $EST_NORMATIVA;
            } 
            
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['COD_NORMATIVA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_PUBLICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IMP_NORMATIVA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_NORMATIVA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_NORMATIVA'], SQLSRV_PARAM_IN), 
                array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_NORMATIVA_DAO->Insert_GEN_NORMATIVA($DataSet_GEN_NORMATIVA, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[6][0];

            $mensaje = $procedure_parametrosMS[7][0];

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
            $DataSet_GEN_NORMATIVA = array();
            $Objeto_GEN_NORMATIVA_DAO = new GEN_NORMATIVA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_NORMATIVA_DAO->SelPk_GEN_NORMATIVA($DataSet_GEN_NORMATIVA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_NORMATIVA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_NORMATIVA

                $COD_NORMATIVA = $DataSet_GEN_NORMATIVA[0]->COD_NORMATIVA;
                $FEC_PUBLICACION = $DataSet_GEN_NORMATIVA[0]->FEC_PUBLICACION;
                $IMP_NORMATIVA = $DataSet_GEN_NORMATIVA[0]->IMP_NORMATIVA;
                $TIP_NORMATIVA = $DataSet_GEN_NORMATIVA[0]->TIP_NORMATIVA;
                $EST_NORMATIVA = $DataSet_GEN_NORMATIVA[0]->EST_NORMATIVA;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('COD_NORMATIVA', $COD_NORMATIVA);
            $lCollection->Add('FEC_PUBLICACION', $FEC_PUBLICACION);
            $lCollection->Add('IMP_NORMATIVA', $IMP_NORMATIVA);
            $lCollection->Add('TIP_NORMATIVA', $TIP_NORMATIVA);
            $lCollection->Add('EST_NORMATIVA', $EST_NORMATIVA);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_PUBLICACION) > 0) {
                $FEC_PUBLICACION = cambiafecha($FEC_PUBLICACION);
            } else {
                $FEC_PUBLICACION = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_NORMATIVA = array();
            $Objeto_GEN_NORMATIVA_DAO = new GEN_NORMATIVA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($COD_NORMATIVA)) > 0) {
                $lstparametrosM['COD_NORMATIVA'] = $COD_NORMATIVA;
            }
            if (strlen(rtrim($FEC_PUBLICACION)) > 0) {
                $lstparametrosM['FEC_PUBLICACION'] = $FEC_PUBLICACION;
            }
            if (strlen(rtrim($IMP_NORMATIVA)) > 0) {
                $lstparametrosM['IMP_NORMATIVA'] = $IMP_NORMATIVA;
            }
            if (strlen(rtrim($TIP_NORMATIVA)) > 0) {
                $lstparametrosM['TIP_NORMATIVA'] = $TIP_NORMATIVA;
            }
            if (strlen(rtrim($EST_NORMATIVA)) > 0) {
                $lstparametrosM['EST_NORMATIVA'] = $EST_NORMATIVA;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_NORMATIVA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_PUBLICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IMP_NORMATIVA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_NORMATIVA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_NORMATIVA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_NORMATIVA_DAO->Update_GEN_NORMATIVA($DataSet_GEN_NORMATIVA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_NORMATIVA = array();
            $Objeto_GEN_NORMATIVA_DAO = new GEN_NORMATIVA_DAO();
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
            $Objeto_GEN_NORMATIVA_DAO->Delete_GEN_NORMATIVA($DataSet_GEN_NORMATIVA, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_NORMATIVA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_NORMATIVA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_NORMATIVA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA = '53' ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_NORMATIVA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);
        
        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */
    }
}

//var_dump($lstDepartamento);exit;
