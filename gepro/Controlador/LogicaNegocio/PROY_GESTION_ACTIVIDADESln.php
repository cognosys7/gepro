<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_ACTIVIDADESLN de la tabla PROY_GESTION_ACTIVIDADES
  //  Fecha           : domingo, 26 de mayo de 2019 6:23:54
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_GESTION_ACTIVIDADESDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
//require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");
require_once("include/GEN_INTERVENCIONlni.php");
require_once("include/GEN_COMUNIDADlni.php");
require_once("include/PROY_GESTION_SOCIALlni.php");
require_once("include/GEN_UBIGEOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_GESTION_ACTIVIDADES";
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
        $PPROYECTO = isset($_REQUEST['PPROYECTO']) ? VerificarInputs($_REQUEST['PPROYECTO']) : "";
        $PINTERVENCION = isset($_REQUEST['PINTERVENCION']) ? VerificarInputs($_REQUEST['PINTERVENCION']) : "";
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_GESTION_SOCIAL = isset($_REQUEST['IDE_GESTION_SOCIAL']) ? VerificarInputs($_REQUEST['IDE_GESTION_SOCIAL']) : "";
        $TIP_ACTIVIDAD = isset($_REQUEST['TIP_ACTIVIDAD']) ? VerificarInputs($_REQUEST['TIP_ACTIVIDAD']) : "";
        $DES_ACTIV_PROGRAMADA = isset($_REQUEST['DES_ACTIV_PROGRAMADA']) ? VerificarInputs($_REQUEST['DES_ACTIV_PROGRAMADA']) : "";
        $FEC_ACTIV_PROGRAMADA = isset($_REQUEST['FEC_ACTIV_PROGRAMADA']) ? VerificarInputs($_REQUEST['FEC_ACTIV_PROGRAMADA']) : "";
        $DES_ACTIV_REALIZADA = isset($_REQUEST['DES_ACTIV_REALIZADA']) ? VerificarInputs($_REQUEST['DES_ACTIV_REALIZADA']) : "";
        $FEC_ACTIV_REALIZADA = isset($_REQUEST['FEC_ACTIV_REALIZADA']) ? VerificarInputs($_REQUEST['FEC_ACTIV_REALIZADA']) : "";
        $EST_ACTIVIDAD = isset($_REQUEST['EST_ACTIVIDAD']) ? VerificarInputs($_REQUEST['EST_ACTIVIDAD']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROY_GESTION_ACTIVIDADES';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_GESTION_SOCIAL=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
            $Data2 = GestionSocial_Datos($PIDE);
            
            $Data5 = GenTablas_Datos('73',$Data2['TIP_UNIDAD_BENEFICIARIO']);
            $VNUM_BENEFICIARIOS = $Data2['NUM_BENEFICIARIOS'] .' '. $Data5['DES_ITEM'] .'(s)' ;

            $lCollection->Add('VNUM_BENEFICIARIOS', $VNUM_BENEFICIARIOS );
            
            $Data3 = Comunidad_Datos($Data2['IDE_COMUNIDAD']);
            $lCollection->Add('VDES_COMUNIDAD', $Data3['DES_COMUNIDAD'] );

            $Data4 = UBIGEO_Datos($Data3['COD_UBIGEO']);
            $DescripcionUBIGEO = '(' . $Data3['COD_UBIGEO'] . ') ' . $Data4['DES_DEPARTAMENTO'] .' - '. $Data4['DES_PROVINCIA'] .' - '. $Data4['DES_DISTRITO'] ;
            $lCollection->Add('VDES_UBIGEO', $DescripcionUBIGEO  );
       }
//           else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_PROY_GESTION_ACTIVIDADES_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_GESTION_ACTIVIDADES_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'TIP_ACTIVIDAD') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'DES_ACTIV_PROGRAMADA') {
                        $_POST['qtype'] = 'T.DES_ACTIV_PROGRAMADA';
                    }
                    if ($_POST['qtype'] == 'DES_ACTIV_REALIZADA') {
                        $_POST['qtype'] = 'T.DES_ACTIV_REALIZADA';
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
            $ogridDAO->Count_PROY_GESTION_ACTIVIDADES($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_GESTION_ACTIVIDAD;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data = Comunidad_Datos($PIDEbuscado);
            $lCollection->Add('VCOD_UBIGEO', $Data['COD_UBIGEO']);
            $lCollection->Add('VDES_COMUNIDAD', $Data['DES_COMUNIDAD']);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_ACTIV_PROGRAMADA) > 0) {
                $FEC_ACTIV_PROGRAMADA = cambiafecha($FEC_ACTIV_PROGRAMADA);
            } else {
                $FEC_ACTIV_PROGRAMADA = "";
            }
            if (strlen($FEC_ACTIV_REALIZADA) > 0) {
                $FEC_ACTIV_REALIZADA = cambiafecha($FEC_ACTIV_REALIZADA);
            } else {
                $FEC_ACTIV_REALIZADA = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_GESTION_ACTIVIDADESM = array();
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO = new PROY_GESTION_ACTIVIDADES_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['IDE_GESTION_SOCIAL'] = $IDE_GESTION_SOCIAL;
            }
            if (strlen(rtrim($TIP_ACTIVIDAD)) > 0) {
                $lstparametrosM['TIP_ACTIVIDAD'] = $TIP_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_ACTIV_PROGRAMADA)) > 0) {
                $lstparametrosM['DES_ACTIV_PROGRAMADA'] = $DES_ACTIV_PROGRAMADA;
            }
            if (strlen(rtrim($FEC_ACTIV_PROGRAMADA)) > 0) {
                $lstparametrosM['FEC_ACTIV_PROGRAMADA'] = $FEC_ACTIV_PROGRAMADA;
            }
            if (strlen(rtrim($DES_ACTIV_REALIZADA)) > 0) {
                $lstparametrosM['DES_ACTIV_REALIZADA'] = $DES_ACTIV_REALIZADA;
            }
            if (strlen(rtrim($FEC_ACTIV_REALIZADA)) > 0) {
                $lstparametrosM['FEC_ACTIV_REALIZADA'] = $FEC_ACTIV_REALIZADA;
            }
            if (strlen(rtrim($EST_ACTIVIDAD)) > 0) {
                $lstparametrosM['EST_ACTIVIDAD'] = $EST_ACTIVIDAD;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_GESTION_SOCIAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_ACTIVIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACTIV_PROGRAMADA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_ACTIV_PROGRAMADA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ACTIV_REALIZADA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_ACTIV_REALIZADA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO->Insert_PROY_GESTION_ACTIVIDADES($DataSet_PROY_GESTION_ACTIVIDADES, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_GESTION_ACTIVIDADES = array();
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO = new PROY_GESTION_ACTIVIDADES_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO->SelPk_PROY_GESTION_ACTIVIDADES($DataSet_PROY_GESTION_ACTIVIDADES, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_GESTION_ACTIVIDADES) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_GESTION_ACTIVIDADES

                $IDE_GESTION_SOCIAL = $DataSet_PROY_GESTION_ACTIVIDADES[0]->IDE_GESTION_SOCIAL;
                $TIP_ACTIVIDAD = $DataSet_PROY_GESTION_ACTIVIDADES[0]->TIP_ACTIVIDAD;
                $DES_ACTIV_PROGRAMADA = $DataSet_PROY_GESTION_ACTIVIDADES[0]->DES_ACTIV_PROGRAMADA;
                $FEC_ACTIV_PROGRAMADA = $DataSet_PROY_GESTION_ACTIVIDADES[0]->FEC_ACTIV_PROGRAMADA;
                $DES_ACTIV_REALIZADA = $DataSet_PROY_GESTION_ACTIVIDADES[0]->DES_ACTIV_REALIZADA;
                $FEC_ACTIV_REALIZADA = $DataSet_PROY_GESTION_ACTIVIDADES[0]->FEC_ACTIV_REALIZADA;
                $EST_ACTIVIDAD = $DataSet_PROY_GESTION_ACTIVIDADES[0]->EST_ACTIVIDAD;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_GESTION_SOCIAL', $IDE_GESTION_SOCIAL);
            $lCollection->Add('TIP_ACTIVIDAD', $TIP_ACTIVIDAD);
            $lCollection->Add('DES_ACTIV_PROGRAMADA', $DES_ACTIV_PROGRAMADA);
            $lCollection->Add('FEC_ACTIV_PROGRAMADA', $FEC_ACTIV_PROGRAMADA);
            $lCollection->Add('DES_ACTIV_REALIZADA', $DES_ACTIV_REALIZADA);
            $lCollection->Add('FEC_ACTIV_REALIZADA', $FEC_ACTIV_REALIZADA);
            $lCollection->Add('EST_ACTIVIDAD', $EST_ACTIVIDAD);

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data = UBIGEO_Datos($COD_UBIGEO);
            //$lCollection->Add('DES_UBIGEO', '('.$COD_UBIGEO.') '.$Data['DES_DEPARTAMENTO'].' - '.$Data['DES_PROVINCIA'].' - '.$Data['DES_DISTRITO'] );
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_ACTIV_PROGRAMADA) > 0) {
                $FEC_ACTIV_PROGRAMADA = cambiafecha($FEC_ACTIV_PROGRAMADA);
            } else {
                $FEC_ACTIV_PROGRAMADA = "";
            }
            if (strlen($FEC_ACTIV_REALIZADA) > 0) {
                $FEC_ACTIV_REALIZADA = cambiafecha($FEC_ACTIV_REALIZADA);
            } else {
                $FEC_ACTIV_REALIZADA = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_GESTION_ACTIVIDADES = array();
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO = new PROY_GESTION_ACTIVIDADES_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['IDE_GESTION_SOCIAL'] = $IDE_GESTION_SOCIAL;
            }
            if (strlen(rtrim($TIP_ACTIVIDAD)) > 0) {
                $lstparametrosM['TIP_ACTIVIDAD'] = $TIP_ACTIVIDAD;
            }
            if (strlen(rtrim($DES_ACTIV_PROGRAMADA)) > 0) {
                $lstparametrosM['DES_ACTIV_PROGRAMADA'] = $DES_ACTIV_PROGRAMADA;
            }
            if (strlen(rtrim($FEC_ACTIV_PROGRAMADA)) > 0) {
                $lstparametrosM['FEC_ACTIV_PROGRAMADA'] = $FEC_ACTIV_PROGRAMADA;
            }
            if (strlen(rtrim($DES_ACTIV_REALIZADA)) > 0) {
                $lstparametrosM['DES_ACTIV_REALIZADA'] = $DES_ACTIV_REALIZADA;
            }
            if (strlen(rtrim($FEC_ACTIV_REALIZADA)) > 0) {
                $lstparametrosM['FEC_ACTIV_REALIZADA'] = $FEC_ACTIV_REALIZADA;
            }
            if (strlen(rtrim($EST_ACTIVIDAD)) > 0) {
                $lstparametrosM['EST_ACTIVIDAD'] = $EST_ACTIVIDAD;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_GESTION_SOCIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACTIV_PROGRAMADA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_ACTIV_PROGRAMADA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ACTIV_REALIZADA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_ACTIV_REALIZADA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ACTIVIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO->Update_PROY_GESTION_ACTIVIDADES($DataSet_PROY_GESTION_ACTIVIDADES, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[9][0];

            $mensaje = $procedure_parametrosMS[10][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_GESTION_ACTIVIDADES = array();
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO = new PROY_GESTION_ACTIVIDADES_DAO();
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
            $Objeto_PROY_GESTION_ACTIVIDADES_DAO->Delete_PROY_GESTION_ACTIVIDADES($DataSet_PROY_GESTION_ACTIVIDADES, $procedure_parametrosMS); //JCMY
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
        $Objeto_TIP_ACTIVIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='75'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_ACTIVIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_ACTIVIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ACTIVIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('PPROYECTO', $PPROYECTO);
        $lCollection->Add('PINTERVENCION', $PINTERVENCION);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;