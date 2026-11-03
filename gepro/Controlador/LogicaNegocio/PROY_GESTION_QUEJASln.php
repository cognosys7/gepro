<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_GESTION_QUEJASLN de la tabla PROY_GESTION_QUEJAS
  //  Fecha           : domingo, 26 de mayo de 2019 19:51:43
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_GESTION_QUEJASDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_CENTRO_COSTODAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");


/* EDGAR */
require_once("include/PROYECTOlni.php");
require_once("include/GEN_INTERVENCIONlni.php");
require_once("include/GEN_COMUNIDADlni.php");
require_once("include/PROY_GESTION_SOCIALlni.php");
require_once("include/GEN_UBIGEOlni.php");

//// busqueda
require_once("include/CONT_INTERESADOSlni.php");
require_once("include/GEN_RECURSOlni.php");
require_once("include/GEN_CARGOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_GESTION_QUEJAS";
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
        $DES_QUEJA = isset($_REQUEST['DES_QUEJA']) ? VerificarInputs($_REQUEST['DES_QUEJA']) : "";
        $TIP_IMPACTO = isset($_REQUEST['TIP_IMPACTO']) ? VerificarInputs($_REQUEST['TIP_IMPACTO']) : "";
        $TIP_CANALIZA = isset($_REQUEST['TIP_CANALIZA']) ? VerificarInputs($_REQUEST['TIP_CANALIZA']) : "";
        $IDE_CENCOSTO_ASIGNADO = isset($_REQUEST['IDE_CENCOSTO_ASIGNADO']) ? VerificarInputs($_REQUEST['IDE_CENCOSTO_ASIGNADO']) : "";
        $IDE_CONT_INTERESADO = isset($_REQUEST['IDE_CONT_INTERESADO']) ? VerificarInputs($_REQUEST['IDE_CONT_INTERESADO']) : "";
        $FEC_QUEJA = isset($_REQUEST['FEC_QUEJA']) ? VerificarInputs($_REQUEST['FEC_QUEJA']) : "";
        $EST_ATENDIDO = isset($_REQUEST['EST_ATENDIDO']) ? VerificarInputs($_REQUEST['EST_ATENDIDO']) : "";
        $FEC_ATENDIDO = isset($_REQUEST['FEC_ATENDIDO']) ? VerificarInputs($_REQUEST['FEC_ATENDIDO']) : "";
        $DES_RESPUESTA= isset($_REQUEST['DES_RESPUESTA']) ? VerificarInputs($_REQUEST['DES_RESPUESTA']) : "";
        $EST_QUEJA = isset($_REQUEST['EST_QUEJA']) ? VerificarInputs($_REQUEST['EST_QUEJA']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROY_GESTION_QUEJAS';

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
            
            $lCollection->Add('VIDE_PROYECTO', $Data2['IDE_PROYECTO']  );
       }
//           else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_PROY_GESTION_QUEJAS_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_GESTION_QUEJAS_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_QUEJA') {
                        $_POST['qtype'] = 'T.DES_QUEJA';
                    }
                    if ($_POST['qtype'] == 'TIP_IMPACTO') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'TIP_CANALIZA') {
                        $_POST['qtype'] = 'T3.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'DES_CENCOSTO') {
                        $_POST['qtype'] = 'CC.DES_CENCOSTO';
                    }
                    if ($_POST['qtype'] == 'EST_ATENDIDO') {
                        $_POST['qtype'] = 'T4.DES_ITEM';
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
            $ogridDAO->Count_PROY_GESTION_QUEJAS($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_GESTION_QUEJAS;

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

            if (strlen($FEC_QUEJA) > 0) {
                $FEC_QUEJA = cambiafecha($FEC_QUEJA);
            } else {
                $FEC_QUEJA = "";
            }
            if (strlen($FEC_ATENDIDO) > 0) {
                $FEC_ATENDIDO = cambiafecha($FEC_ATENDIDO);
            } else {
                $FEC_ATENDIDO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_GESTION_QUEJASM = array();
            $Objeto_PROY_GESTION_QUEJAS_DAO = new PROY_GESTION_QUEJAS_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['IDE_GESTION_SOCIAL'] = $IDE_GESTION_SOCIAL;
            }
            if (strlen(rtrim($DES_QUEJA)) > 0) {
                $lstparametrosM['DES_QUEJA'] = $DES_QUEJA;
            }
            if (strlen(rtrim($TIP_IMPACTO)) > 0) {
                $lstparametrosM['TIP_IMPACTO'] = $TIP_IMPACTO;
            }
            if (strlen(rtrim($TIP_CANALIZA)) > 0) {
                $lstparametrosM['TIP_CANALIZA'] = $TIP_CANALIZA;
            }
            if (strlen(rtrim($IDE_CENCOSTO_ASIGNADO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO_ASIGNADO'] = $IDE_CENCOSTO_ASIGNADO;
            }
            if (strlen(rtrim($IDE_CONT_INTERESADO)) > 0) {
                $lstparametrosM['IDE_CONT_INTERESADO'] = $IDE_CONT_INTERESADO;
            }
            if (strlen(rtrim($FEC_QUEJA)) > 0) {
                $lstparametrosM['FEC_QUEJA'] = $FEC_QUEJA;
            }
            if (strlen(rtrim($EST_ATENDIDO)) > 0) {
                $lstparametrosM['EST_ATENDIDO'] = $EST_ATENDIDO;
            }
            if (strlen(rtrim($FEC_ATENDIDO)) > 0) {
                $lstparametrosM['FEC_ATENDIDO'] = $FEC_ATENDIDO;
            }
            if (strlen(rtrim($DES_RESPUESTA)) > 0) {
                $lstparametrosM['DES_RESPUESTA'] = $DES_RESPUESTA;
            }
            if (strlen(rtrim($EST_QUEJA)) > 0) {
                $lstparametrosM['EST_QUEJA'] = $EST_QUEJA;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_GESTION_SOCIAL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_QUEJA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_IMPACTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_CANALIZA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CENCOSTO_ASIGNADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CONT_INTERESADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_QUEJA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ATENDIDO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_ATENDIDO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_RESPUESTA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_QUEJA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_GESTION_QUEJAS_DAO->Insert_PROY_GESTION_QUEJAS($DataSet_PROY_GESTION_QUEJAS, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[12][0];

            $mensaje = $procedure_parametrosMS[13][0];

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
            $DataSet_PROY_GESTION_QUEJAS = array();
            $Objeto_PROY_GESTION_QUEJAS_DAO = new PROY_GESTION_QUEJAS_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_GESTION_QUEJAS_DAO->SelPk_PROY_GESTION_QUEJAS($DataSet_PROY_GESTION_QUEJAS, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_GESTION_QUEJAS) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_GESTION_QUEJAS

                $IDE_GESTION_SOCIAL = $DataSet_PROY_GESTION_QUEJAS[0]->IDE_GESTION_SOCIAL;
                $DES_QUEJA = $DataSet_PROY_GESTION_QUEJAS[0]->DES_QUEJA;
                $TIP_IMPACTO = $DataSet_PROY_GESTION_QUEJAS[0]->TIP_IMPACTO;
                $TIP_CANALIZA = $DataSet_PROY_GESTION_QUEJAS[0]->TIP_CANALIZA;
                $IDE_CENCOSTO_ASIGNADO = $DataSet_PROY_GESTION_QUEJAS[0]->IDE_CENCOSTO_ASIGNADO;
                $IDE_CONT_INTERESADO = $DataSet_PROY_GESTION_QUEJAS[0]->IDE_CONT_INTERESADO;
                $FEC_QUEJA = $DataSet_PROY_GESTION_QUEJAS[0]->FEC_QUEJA;
                $EST_ATENDIDO = $DataSet_PROY_GESTION_QUEJAS[0]->EST_ATENDIDO;
                $FEC_ATENDIDO = $DataSet_PROY_GESTION_QUEJAS[0]->FEC_ATENDIDO;
                $DES_RESPUESTA = $DataSet_PROY_GESTION_QUEJAS[0]->DES_RESPUESTA;
                $EST_QUEJA = $DataSet_PROY_GESTION_QUEJAS[0]->EST_QUEJA;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_GESTION_SOCIAL', $IDE_GESTION_SOCIAL);
            $lCollection->Add('DES_QUEJA', $DES_QUEJA);
            $lCollection->Add('TIP_IMPACTO', $TIP_IMPACTO);
            $lCollection->Add('TIP_CANALIZA', $TIP_CANALIZA);
            $lCollection->Add('IDE_CENCOSTO_ASIGNADO', $IDE_CENCOSTO_ASIGNADO);
            $lCollection->Add('IDE_CONT_INTERESADO', $IDE_CONT_INTERESADO);
            $lCollection->Add('FEC_QUEJA', $FEC_QUEJA);
            $lCollection->Add('EST_ATENDIDO', $EST_ATENDIDO);
            $lCollection->Add('FEC_ATENDIDO', $FEC_ATENDIDO);
            $lCollection->Add('DES_RESPUESTA', $DES_RESPUESTA);
            $lCollection->Add('EST_QUEJA', $EST_QUEJA);

            
            
            
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data = Interesados_Datos($IDE_CONT_INTERESADO);
            
            $Data1 = Recurso_Datos($Data['IDE_RECURSO']);
            $Data2 = Cargo_Datos($Data['IDE_PUESTO']);
            
            $Bdescripcion = $Data1['DES_RECURSO'] .' ( '. $Data2['DES_CARGO'] .' ) ' ;
//            $Bdescripcion = $Data1['DES_RECURSO'] .' ( '. $Data2['DES_CARGO'] .' ) ' ;
            
            $lCollection->Add('Bdescripcion', $Bdescripcion);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            if (strlen($FEC_QUEJA) > 0) {
                $FEC_QUEJA = cambiafecha($FEC_QUEJA);
            } else {
                $FEC_QUEJA = "";
            }
            if (strlen($FEC_ATENDIDO) > 0) {
                $FEC_ATENDIDO = cambiafecha($FEC_ATENDIDO);
            } else {
                $FEC_ATENDIDO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_GESTION_QUEJAS = array();
            $Objeto_PROY_GESTION_QUEJAS_DAO = new PROY_GESTION_QUEJAS_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_GESTION_SOCIAL)) > 0) {
                $lstparametrosM['IDE_GESTION_SOCIAL'] = $IDE_GESTION_SOCIAL;
            }
            if (strlen(rtrim($DES_QUEJA)) > 0) {
                $lstparametrosM['DES_QUEJA'] = $DES_QUEJA;
            }
            if (strlen(rtrim($TIP_IMPACTO)) > 0) {
                $lstparametrosM['TIP_IMPACTO'] = $TIP_IMPACTO;
            }
            if (strlen(rtrim($TIP_CANALIZA)) > 0) {
                $lstparametrosM['TIP_CANALIZA'] = $TIP_CANALIZA;
            }
            if (strlen(rtrim($IDE_CENCOSTO_ASIGNADO)) > 0) {
                $lstparametrosM['IDE_CENCOSTO_ASIGNADO'] = $IDE_CENCOSTO_ASIGNADO;
            }
            if (strlen(rtrim($IDE_CONT_INTERESADO)) > 0) {
                $lstparametrosM['IDE_CONT_INTERESADO'] = $IDE_CONT_INTERESADO;
            }
            if (strlen(rtrim($FEC_QUEJA)) > 0) {
                $lstparametrosM['FEC_QUEJA'] = $FEC_QUEJA;
            }
            if (strlen(rtrim($EST_ATENDIDO)) > 0) {
                $lstparametrosM['EST_ATENDIDO'] = $EST_ATENDIDO;
            }
            if (strlen(rtrim($FEC_ATENDIDO)) > 0) {
                $lstparametrosM['FEC_ATENDIDO'] = $FEC_ATENDIDO;
            }
            if (strlen(rtrim($DES_RESPUESTA)) > 0) {
                $lstparametrosM['DES_RESPUESTA'] = $DES_RESPUESTA;
            }
            if (strlen(rtrim($EST_QUEJA)) > 0) {
                $lstparametrosM['EST_QUEJA'] = $EST_QUEJA;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_GESTION_SOCIAL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_QUEJA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_IMPACTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_CANALIZA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CENCOSTO_ASIGNADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONT_INTERESADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_QUEJA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ATENDIDO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_ATENDIDO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_RESPUESTA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_QUEJA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_GESTION_QUEJAS_DAO->Update_PROY_GESTION_QUEJAS($DataSet_PROY_GESTION_QUEJAS, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[13][0];

            $mensaje = $procedure_parametrosMS[14][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_GESTION_QUEJAS = array();
            $Objeto_PROY_GESTION_QUEJAS_DAO = new PROY_GESTION_QUEJAS_DAO();
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
            $Objeto_PROY_GESTION_QUEJAS_DAO->Delete_PROY_GESTION_QUEJAS($DataSet_PROY_GESTION_QUEJAS, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_CENTRO_COSTO_1 = array();
        $Objeto_IDE_CENCOSTO_ASIGNADO_DAO = new GEN_CENTRO_COSTO_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CENCOSTO,DES_CENCOSTO";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_CENCOSTO_ASIGNADO_DAO->SelCampos_GEN_CENTRO_COSTO($DataSet_GEN_CENTRO_COSTO_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_CENTRO_COSTO_1', $DataSet_GEN_CENTRO_COSTO_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_IMPACTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='76'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_IMPACTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_CANALIZA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='77'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_CANALIZA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_ATENDIDO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='78'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ATENDIDO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_EST_QUEJA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_QUEJA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

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