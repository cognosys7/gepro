<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : PROY_COM_INTERESADOSLN de la tabla PROY_COM_INTERESADOS
  //  Fecha           : viernes, 28 de junio de 2019 21:23:01
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO
  //  Modificado      : 29 de Junio 2019
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_COM_INTERESADOSDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


//require_once(PATH_CONTROLADOR_DAO . "/CONT_INTERESADOSDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOlni.php");
require_once("include/PROY_COMUNICACIONlni.php");
require_once("include/GEN_TABLASlni.php");
//// busqueda
require_once("include/CONT_INTERESADOSlni.php");
require_once("include/GEN_RECURSOlni.php");
require_once("include/GEN_CARGOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_COM_INTERESADOS";
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
        $IDE_COMUNICACION = isset($_REQUEST['IDE_COMUNICACION']) ? VerificarInputs($_REQUEST['IDE_COMUNICACION']) : "";
        $IDE_CONT_INTERESADO = isset($_REQUEST['IDE_CONT_INTERESADO']) ? VerificarInputs($_REQUEST['IDE_CONT_INTERESADO']) : "";
        $TIP_RESPONSABILIDAD = isset($_REQUEST['TIP_RESPONSABILIDAD']) ? VerificarInputs($_REQUEST['TIP_RESPONSABILIDAD']) : "";
        $DES_COMENTARIO = isset($_REQUEST['DES_COMENTARIO']) ? VerificarInputs($_REQUEST['DES_COMENTARIO']) : "";
        $EST_PROY_COM_INTERESADO = isset($_REQUEST['EST_PROY_COM_INTERESADO']) ? VerificarInputs($_REQUEST['EST_PROY_COM_INTERESADO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_PROY_COM_INTERESADOS';

       if ( $PIDE>0 ){
             $ScriptFLX .= " AND T.IDE_COMUNICACION=$PIDE";
             $pAuxiliar = '';   
             
            $Data = ProyectoComunicacion_Datos($PIDE);
            $Data1 = GenTablas_Datos(88,$Data['TIP_FRECUENCIA']);
            
            $Tabla_DatosPadre = '<table class="tbDatoPadre" style="width:100%">';
            $Tabla_DatosPadre .= '<tr><td>';
            $Tabla_DatosPadre .= Tabla_Proyecto_Datos($Data['IDE_PROYECTO']).'<hr>'.Tabla_ProyectoComunicacion_Datos($PIDE , $Data1['DES_ITEM']);
            $Tabla_DatosPadre .= '</tr></td>';
            $Tabla_DatosPadre .= '</table>';
            
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
            $ogridDAO = new PROY_COM_INTERESADOS_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_RECURSO') {
                        $_POST['qtype'] = 'GR.DES_RECURSO';
                    }
                    if ($_POST['qtype'] == 'DES_CARGO') {
                        $_POST['qtype'] = 'GC.DES_CARGO';
                    }
                    if ($_POST['qtype'] == 'DES_ROL') {
                        $_POST['qtype'] = 'GL.DES_ROL';
                    }
                    if ($_POST['qtype'] == 'TIP_RESPONSABILIDAD') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
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
            $ogridDAO->Count_PROY_COM_INTERESADOS($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROY_COM_INTERESADO;

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

            $DataSet_PROY_COM_INTERESADOSM = array();
            $Objeto_PROY_COM_INTERESADOS_DAO = new PROY_COM_INTERESADOS_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_COMUNICACION)) > 0) {
                $lstparametrosM['IDE_COMUNICACION'] = $IDE_COMUNICACION;
            }
            if (strlen(rtrim($IDE_CONT_INTERESADO)) > 0) {
                $lstparametrosM['IDE_CONT_INTERESADO'] = $IDE_CONT_INTERESADO;
            }
            if (strlen(rtrim($TIP_RESPONSABILIDAD)) > 0) {
                $lstparametrosM['TIP_RESPONSABILIDAD'] = $TIP_RESPONSABILIDAD;
            }
            if (strlen(rtrim($DES_COMENTARIO)) > 0) {
                $lstparametrosM['DES_COMENTARIO'] = $DES_COMENTARIO;
            }
            if (strlen(rtrim($EST_PROY_COM_INTERESADO)) > 0) {
                $lstparametrosM['EST_PROY_COM_INTERESADO'] = $EST_PROY_COM_INTERESADO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_COMUNICACION'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_CONT_INTERESADO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_RESPONSABILIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_COMENTARIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROY_COM_INTERESADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COM_INTERESADOS_DAO->Insert_PROY_COM_INTERESADOS($DataSet_PROY_COM_INTERESADOS, $procedure_parametrosMS); //JCMY

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
            $DataSet_PROY_COM_INTERESADOS = array();
            $Objeto_PROY_COM_INTERESADOS_DAO = new PROY_COM_INTERESADOS_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_COM_INTERESADOS_DAO->SelPk_PROY_COM_INTERESADOS($DataSet_PROY_COM_INTERESADOS, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_COM_INTERESADOS) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_COM_INTERESADOS

                $IDE_COMUNICACION = $DataSet_PROY_COM_INTERESADOS[0]->IDE_COMUNICACION;
                $IDE_CONT_INTERESADO = $DataSet_PROY_COM_INTERESADOS[0]->IDE_CONT_INTERESADO;
                $TIP_RESPONSABILIDAD = $DataSet_PROY_COM_INTERESADOS[0]->TIP_RESPONSABILIDAD;
                $DES_COMENTARIO = $DataSet_PROY_COM_INTERESADOS[0]->DES_COMENTARIO;
                $EST_PROY_COM_INTERESADO = $DataSet_PROY_COM_INTERESADOS[0]->EST_PROY_COM_INTERESADO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_COMUNICACION', $IDE_COMUNICACION);
            $lCollection->Add('IDE_CONT_INTERESADO', $IDE_CONT_INTERESADO);
            $lCollection->Add('TIP_RESPONSABILIDAD', $TIP_RESPONSABILIDAD);
            $lCollection->Add('DES_COMENTARIO', $DES_COMENTARIO);
            $lCollection->Add('EST_PROY_COM_INTERESADO', $EST_PROY_COM_INTERESADO);


            
            
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data = Interesados_Datos($IDE_CONT_INTERESADO);
            
            $Data1 = Recurso_Datos($Data['IDE_RECURSO']);
            $Data2 = Cargo_Datos($Data['IDE_PUESTO']);
            
            $Bdescripcion = $Data1['DES_RECURSO'] .' ( '. $Data2['DES_CARGO'] .' ) ' ;
            
            $lCollection->Add('Bdescripcion', $Bdescripcion);
            /* EDGAR */
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_PROY_COM_INTERESADOS = array();
            $Objeto_PROY_COM_INTERESADOS_DAO = new PROY_COM_INTERESADOS_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_COMUNICACION)) > 0) {
                $lstparametrosM['IDE_COMUNICACION'] = $IDE_COMUNICACION;
            }
            if (strlen(rtrim($IDE_CONT_INTERESADO)) > 0) {
                $lstparametrosM['IDE_CONT_INTERESADO'] = $IDE_CONT_INTERESADO;
            }
            if (strlen(rtrim($TIP_RESPONSABILIDAD)) > 0) {
                $lstparametrosM['TIP_RESPONSABILIDAD'] = $TIP_RESPONSABILIDAD;
            }
            if (strlen(rtrim($DES_COMENTARIO)) > 0) {
                $lstparametrosM['DES_COMENTARIO'] = $DES_COMENTARIO;
            }
            if (strlen(rtrim($EST_PROY_COM_INTERESADO)) > 0) {
                $lstparametrosM['EST_PROY_COM_INTERESADO'] = $EST_PROY_COM_INTERESADO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_COMUNICACION'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_CONT_INTERESADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_RESPONSABILIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_COMENTARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROY_COM_INTERESADO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_COM_INTERESADOS_DAO->Update_PROY_COM_INTERESADOS($DataSet_PROY_COM_INTERESADOS, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_COM_INTERESADOS = array();
            $Objeto_PROY_COM_INTERESADOS_DAO = new PROY_COM_INTERESADOS_DAO();
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
            $Objeto_PROY_COM_INTERESADOS_DAO->Delete_PROY_COM_INTERESADOS($DataSet_PROY_COM_INTERESADOS, $procedure_parametrosMS); //JCMY
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

        $DataSet_CONT_INTERESADOS_1 = array();
        $Objeto_IDE_CONT_INTERESADO_DAO = new CONT_INTERESADOS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = " IDE_CONT_INTERESADO,DES_RECURSO ";
        $lstparametrosM['filtro'] = " ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_CONT_INTERESADO_DAO->SelCampos_Recursos_CONT_INTERESADOS($DataSet_CONT_INTERESADOS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_CONT_INTERESADOS_1', $DataSet_CONT_INTERESADOS_1);   //     var_dump($DataSet_CONT_INTERESADOS_1); 

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_RESPONSABILIDAD_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='92'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_RESPONSABILIDAD_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_PROY_COM_INTERESADO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROY_COM_INTERESADO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

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