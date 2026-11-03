<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COMUNICACIONLN de la tabla PROY_COMUNICACION
  //  Fecha           : viernes, 28 de junio de 2019 20:22:48
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO
  //  Modificado      : 29 de Junio 2019
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COMUNICACIONDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");
//// busqueda lni
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_COMUNICACION";
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
        $IDE_PROYECTO = isset($_REQUEST['IDE_PROYECTO']) ? VerificarInputs($_REQUEST['IDE_PROYECTO']) : "";
        $DES_COMUNICACION = isset($_REQUEST['DES_COMUNICACION']) ? VerificarInputs($_REQUEST['DES_COMUNICACION']) : "";
        $FEC_INICIO = isset($_REQUEST['FEC_INICIO']) ? VerificarInputs($_REQUEST['FEC_INICIO']) : "";
        $FEC_TERMINO = isset($_REQUEST['FEC_TERMINO']) ? VerificarInputs($_REQUEST['FEC_TERMINO']) : "";
        $TIP_DIRECCION_EMISOR_RECEPTOR = isset($_REQUEST['TIP_DIRECCION_EMISOR_RECEPTOR']) ? VerificarInputs($_REQUEST['TIP_DIRECCION_EMISOR_RECEPTOR']) : "";
        $TIP_FRECUENCIA = isset($_REQUEST['TIP_FRECUENCIA']) ? VerificarInputs($_REQUEST['TIP_FRECUENCIA']) : "";
        $TIP_COMPLEJIDAD_COMUNICACION = isset($_REQUEST['TIP_COMPLEJIDAD_COMUNICACION']) ? VerificarInputs($_REQUEST['TIP_COMPLEJIDAD_COMUNICACION']) : "";
        $TIP_METODO_COMUNICACION = isset($_REQUEST['TIP_METODO_COMUNICACION']) ? VerificarInputs($_REQUEST['TIP_METODO_COMUNICACION']) : "";
        $TIP_MEDIO_COMUNICACION = isset($_REQUEST['TIP_MEDIO_COMUNICACION']) ? VerificarInputs($_REQUEST['TIP_MEDIO_COMUNICACION']) : "";
        $DES_GLOSARIO_TERMINOS = isset($_REQUEST['DES_GLOSARIO_TERMINOS']) ? VerificarInputs($_REQUEST['DES_GLOSARIO_TERMINOS']) : "";
        $EST_COMUNICACION = isset($_REQUEST['EST_COMUNICACION']) ? VerificarInputs($_REQUEST['EST_COMUNICACION']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROY_COMUNICACION';

       if ( $PIDE>0 ){
            $ScriptFLX .= " AND T.IDE_PROYECTO=$PIDE";
            $pAuxiliar = '';         
             
            $Tabla_DatosPadre = Tabla_Proyecto_Datos($PIDE);
            $lCollection->Add('Tabla_DatosPadre', $Tabla_DatosPadre );
       } 
//       else {
//             $ScriptFLX .= " AND T.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;

        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_COMUNICACION_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_COMUNICACION') {
                        $_POST['qtype'] = 'T.DES_COMUNICACION';
                    }
                    if ($_POST['qtype'] == 'FEC_INICIO') {
                        $_POST['qtype'] = 'T.FEC_INICIO';
                    }
                    if ($_POST['qtype'] == 'FEC_TERMINO') {
                        $_POST['qtype'] = 'T.FEC_TERMINO';
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
            $ogridDAO->Count_PROY_COMUNICACION($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_COMUNICACION;

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

            if (strlen($FEC_INICIO) > 0) {
                $FEC_INICIO = cambiafecha($FEC_INICIO);
            } else {
                $FEC_INICIO = "";
            }
            if (strlen($FEC_TERMINO) > 0) {
                $FEC_TERMINO = cambiafecha($FEC_TERMINO);
            } else {
                $FEC_TERMINO = "";
            }

            /* FIN DE ACTIVACION */

            $DataSet_PROY_COMUNICACIONM = array();
            $Objeto_PROY_COMUNICACION_DAO = new PROY_COMUNICACION_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($DES_COMUNICACION)) > 0) {
                $lstparametrosM['DES_COMUNICACION'] = $DES_COMUNICACION;
            }
            if (strlen(rtrim($FEC_INICIO)) > 0) {
                $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            }
            if (strlen(rtrim($FEC_TERMINO)) > 0) {
                $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            }
            if (strlen(rtrim($TIP_DIRECCION_EMISOR_RECEPTOR)) > 0) {
                $lstparametrosM['TIP_DIRECCION_EMISOR_RECEPTOR'] = $TIP_DIRECCION_EMISOR_RECEPTOR;
            }
            if (strlen(rtrim($TIP_FRECUENCIA)) > 0) {
                $lstparametrosM['TIP_FRECUENCIA'] = $TIP_FRECUENCIA;
            }
            if (strlen(rtrim($TIP_COMPLEJIDAD_COMUNICACION)) > 0) {
                $lstparametrosM['TIP_COMPLEJIDAD_COMUNICACION'] = $TIP_COMPLEJIDAD_COMUNICACION;
            }
            if (strlen(rtrim($TIP_METODO_COMUNICACION)) > 0) {
                $lstparametrosM['TIP_METODO_COMUNICACION'] = $TIP_METODO_COMUNICACION;
            }
            if (strlen(rtrim($TIP_MEDIO_COMUNICACION)) > 0) {
                $lstparametrosM['TIP_MEDIO_COMUNICACION'] = $TIP_MEDIO_COMUNICACION;
            }
            if (strlen(rtrim($DES_GLOSARIO_TERMINOS)) > 0) {
                $lstparametrosM['DES_GLOSARIO_TERMINOS'] = $DES_GLOSARIO_TERMINOS;
            }
            if (strlen(rtrim($EST_COMUNICACION)) > 0) {
                $lstparametrosM['EST_COMUNICACION'] = $EST_COMUNICACION;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_COMUNICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_DIRECCION_EMISOR_RECEPTOR'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_FRECUENCIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_COMPLEJIDAD_COMUNICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_METODO_COMUNICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_MEDIO_COMUNICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_GLOSARIO_TERMINOS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_COMUNICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMUNICACION_DAO->Insert_PROY_COMUNICACION($DataSet_PROY_COMUNICACION, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_COMUNICACION = array();
            $Objeto_PROY_COMUNICACION_DAO = new PROY_COMUNICACION_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_COMUNICACION_DAO->SelPk_PROY_COMUNICACION($DataSet_PROY_COMUNICACION, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_COMUNICACION) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_COMUNICACION

                $IDE_PROYECTO = $DataSet_PROY_COMUNICACION[0]->IDE_PROYECTO;
                $DES_COMUNICACION = $DataSet_PROY_COMUNICACION[0]->DES_COMUNICACION;
                $FEC_INICIO = $DataSet_PROY_COMUNICACION[0]->FEC_INICIO;
                $FEC_TERMINO = $DataSet_PROY_COMUNICACION[0]->FEC_TERMINO;
                $TIP_DIRECCION_EMISOR_RECEPTOR = $DataSet_PROY_COMUNICACION[0]->TIP_DIRECCION_EMISOR_RECEPTOR;
                $TIP_FRECUENCIA = $DataSet_PROY_COMUNICACION[0]->TIP_FRECUENCIA;
                $TIP_COMPLEJIDAD_COMUNICACION = $DataSet_PROY_COMUNICACION[0]->TIP_COMPLEJIDAD_COMUNICACION;
                $TIP_METODO_COMUNICACION = $DataSet_PROY_COMUNICACION[0]->TIP_METODO_COMUNICACION;
                $TIP_MEDIO_COMUNICACION = $DataSet_PROY_COMUNICACION[0]->TIP_MEDIO_COMUNICACION;
                $DES_GLOSARIO_TERMINOS = $DataSet_PROY_COMUNICACION[0]->DES_GLOSARIO_TERMINOS;
                $EST_COMUNICACION = $DataSet_PROY_COMUNICACION[0]->EST_COMUNICACION;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
            $lCollection->Add('DES_COMUNICACION', $DES_COMUNICACION);
            $lCollection->Add('FEC_INICIO', $FEC_INICIO);
            $lCollection->Add('FEC_TERMINO', $FEC_TERMINO);
            $lCollection->Add('TIP_DIRECCION_EMISOR_RECEPTOR', $TIP_DIRECCION_EMISOR_RECEPTOR);
            $lCollection->Add('TIP_FRECUENCIA', $TIP_FRECUENCIA);
            $lCollection->Add('TIP_COMPLEJIDAD_COMUNICACION', $TIP_COMPLEJIDAD_COMUNICACION);
            $lCollection->Add('TIP_METODO_COMUNICACION', $TIP_METODO_COMUNICACION);
            $lCollection->Add('TIP_MEDIO_COMUNICACION', $TIP_MEDIO_COMUNICACION);
            $lCollection->Add('DES_GLOSARIO_TERMINOS', $DES_GLOSARIO_TERMINOS);
            $lCollection->Add('EST_COMUNICACION', $EST_COMUNICACION);

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

            if (strlen($FEC_INICIO) > 0) {
                $FEC_INICIO = cambiafecha($FEC_INICIO);
            } else {
                $FEC_INICIO = "";
            }
            if (strlen($FEC_TERMINO) > 0) {
                $FEC_TERMINO = cambiafecha($FEC_TERMINO);
            } else {
                $FEC_TERMINO = "";
            }

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_COMUNICACION = array();
            $Objeto_PROY_COMUNICACION_DAO = new PROY_COMUNICACION_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($DES_COMUNICACION)) > 0) {
                $lstparametrosM['DES_COMUNICACION'] = $DES_COMUNICACION;
            }
            if (strlen(rtrim($FEC_INICIO)) > 0) {
                $lstparametrosM['FEC_INICIO'] = $FEC_INICIO;
            }
            if (strlen(rtrim($FEC_TERMINO)) > 0) {
                $lstparametrosM['FEC_TERMINO'] = $FEC_TERMINO;
            }
            if (strlen(rtrim($TIP_DIRECCION_EMISOR_RECEPTOR)) > 0) {
                $lstparametrosM['TIP_DIRECCION_EMISOR_RECEPTOR'] = $TIP_DIRECCION_EMISOR_RECEPTOR;
            }
            if (strlen(rtrim($TIP_FRECUENCIA)) > 0) {
                $lstparametrosM['TIP_FRECUENCIA'] = $TIP_FRECUENCIA;
            }
            if (strlen(rtrim($TIP_COMPLEJIDAD_COMUNICACION)) > 0) {
                $lstparametrosM['TIP_COMPLEJIDAD_COMUNICACION'] = $TIP_COMPLEJIDAD_COMUNICACION;
            }
            if (strlen(rtrim($TIP_METODO_COMUNICACION)) > 0) {
                $lstparametrosM['TIP_METODO_COMUNICACION'] = $TIP_METODO_COMUNICACION;
            }
            if (strlen(rtrim($TIP_MEDIO_COMUNICACION)) > 0) {
                $lstparametrosM['TIP_MEDIO_COMUNICACION'] = $TIP_MEDIO_COMUNICACION;
            }
            if (strlen(rtrim($DES_GLOSARIO_TERMINOS)) > 0) {
                $lstparametrosM['DES_GLOSARIO_TERMINOS'] = $DES_GLOSARIO_TERMINOS;
            }
            if (strlen(rtrim($EST_COMUNICACION)) > 0) {
                $lstparametrosM['EST_COMUNICACION'] = $EST_COMUNICACION;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_COMUNICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_INICIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FEC_TERMINO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_DIRECCION_EMISOR_RECEPTOR'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_FRECUENCIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_COMPLEJIDAD_COMUNICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_METODO_COMUNICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_MEDIO_COMUNICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_GLOSARIO_TERMINOS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_COMUNICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COMUNICACION_DAO->Update_PROY_COMUNICACION($DataSet_PROY_COMUNICACION, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[13][0];

            $mensaje = $procedure_parametrosMS[14][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_COMUNICACION = array();
            $Objeto_PROY_COMUNICACION_DAO = new PROY_COMUNICACION_DAO();
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
            $Objeto_PROY_COMUNICACION_DAO->Delete_PROY_COMUNICACION($DataSet_PROY_COMUNICACION, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_DIRECCION_EMISOR_RECEPTOR_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='87'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_DIRECCION_EMISOR_RECEPTOR_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_TIP_FRECUENCIA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='88'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_FRECUENCIA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_TIP_COMPLEJIDAD_COMUNICACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='89'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_COMPLEJIDAD_COMUNICACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */

        $DataSet_GEN_TABLAS_4 = array();
        $Objeto_TIP_METODO_COMUNICACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='90'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_METODO_COMUNICACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_4, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_4', $DataSet_GEN_TABLAS_4);

        /* 					 */

        $DataSet_GEN_TABLAS_5 = array();
        $Objeto_TIP_MEDIO_COMUNICACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='91'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_MEDIO_COMUNICACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_5, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_5', $DataSet_GEN_TABLAS_5);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_6 = array();
        $Objeto_EST_COMUNICACION_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_COMUNICACION_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_6, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_6', $DataSet_GEN_TABLAS_6);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;