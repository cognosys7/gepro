<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Julio César Meza Yangali - mezayangali@gmail.com
  //                    Edgar David Pisfil Ahumada
  //
  //  Propósito       : PROY_PIPLN de la tabla PROY_PIP
  //  Fecha           : jueves, 16 de mayo de 2019 15:57:58
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-E
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/PROY_PIPDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/PROYECTOLNI.php");
require_once("include/GEN_PIPlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "PROY_PIP";
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
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_PIP = isset($_REQUEST['IDE_PIP']) ? VerificarInputs($_REQUEST['IDE_PIP']) : "";
        $IDE_PROYECTO = isset($_REQUEST['IDE_PROYECTO']) ? VerificarInputs($_REQUEST['IDE_PROYECTO']) : "";
        $COD_SNIP = isset($_REQUEST['COD_SNIP']) ? VerificarInputs($_REQUEST['COD_SNIP']) : "";
        $COD_UNICO = isset($_REQUEST['COD_UNICO']) ? VerificarInputs($_REQUEST['COD_UNICO']) : "";
        $COD_INFOBRAS = isset($_REQUEST['COD_INFOBRAS']) ? VerificarInputs($_REQUEST['COD_INFOBRAS']) : "";
        $COD_INTERNO = isset($_REQUEST['COD_INTERNO']) ? VerificarInputs($_REQUEST['COD_INTERNO']) : "";
        $EST_PROY_SNIP = isset($_REQUEST['EST_PROY_SNIP']) ? VerificarInputs($_REQUEST['EST_PROY_SNIP']) : "";
        $CHK = isset($_REQUEST['CHK']) ? VerificarInputs($_REQUEST['CHK']) : "";
        $EST_PROY_PIP = isset($_REQUEST['EST_PROY_PIP']) ? VerificarInputs($_REQUEST['EST_PROY_PIP']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_PROYECTO=$PIDE";
//             $pAuxiliar = '';
//              
             $IDE_PROYECTO = $PIDE; /* añadido por julio meza */
//            
//             $Data = GenTablas_Datos1($PIDE);
//             $lCollection->Add('VDES_ITEM', $Data['DES_ITEM'] );
//             $lCollection->Add('VDES_ABREVIATURA', $Data['DES_ABREVIATURA'] );
//             $lCollection->Add('VCOD_TABLA', $Data['COD_TABLA'] );
       } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        $lparametro1 =  ' AND T.IDE_PROYECTO='.$PIDE;
        $procedure_parametrosP1 = array(
            array(&$lparametro1, SQLSRV_PARAM_IN)
        );
        $cuentaDAO = new PROY_PIP_DAO(); 
        $cuentaDAO->Count_PROY_PIP($Resultado, $procedure_parametrosP1); //JCMY
        $lCollection->Add('cuentaResultado', $Resultado[0]->IDE_PROY_PIP );
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new PROY_PIP_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'COD_SNIP') {
                        $_POST['qtype'] = 'T.COD_SNIP';
                    }
                    if ($_POST['qtype'] == 'COD_UNICO') {
                        $_POST['qtype'] = 'T.COD_UNICO';
                    }
                    if ($_POST['qtype'] == 'DES_PIP') {
                        $_POST['qtype'] = 'PIP.DES_PIP';
                    }
                    if ($_POST['qtype'] == 'COD_INFOBRAS') {
                        $_POST['qtype'] = 'T.COD_INFOBRAS';
                    }
                    if ($_POST['qtype'] == 'COD_INTERNO') {
                        $_POST['qtype'] = 'T.COD_INTERNO';
                    }
                    if ($_POST['qtype'] == 'EstadoSNIP') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'CheckReg') {
                        $_POST['qtype'] = 'T3.DES_ITEM';
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
            $ogridDAO->Count_PROY_PIP($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_PROY_PIP;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_PROY_PIP', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_PROY_PIPM = array();
            $Objeto_PROY_PIP_DAO = new PROY_PIP_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_PIP)) > 0) {
                $lstparametrosM['IDE_PIP'] = $IDE_PIP;
            }
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_INFOBRAS)) > 0) {
                $lstparametrosM['COD_INFOBRAS'] = $COD_INFOBRAS;
            }
            if (strlen(rtrim($COD_INTERNO)) > 0) {
                $lstparametrosM['COD_INTERNO'] = $COD_INTERNO;
            }
            if (strlen(rtrim($EST_PROY_SNIP)) > 0) {
                $lstparametrosM['EST_PROY_SNIP'] = $EST_PROY_SNIP;
            }
            if (strlen(rtrim($CHK)) > 0) {
                $lstparametrosM['CHK'] = $CHK;
            }
            if (strlen(rtrim($EST_PROY_PIP)) > 0) {
                $lstparametrosM['EST_PROY_PIP'] = $EST_PROY_PIP;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_PIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_INFOBRAS'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_INTERNO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROY_SNIP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CHK'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_PROY_PIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_PIP_DAO->Insert_PROY_PIP($DataSet_PROY_PIP, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[10][0];

            $mensaje = $procedure_parametrosMS[11][0];

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
            $DataSet_PROY_PIP = array();
            $Objeto_PROY_PIP_DAO = new PROY_PIP_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_PIP_DAO->SelPk_PROY_PIP($DataSet_PROY_PIP, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_PROY_PIP) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_PROY_PIP

                $IDE_PIP = $DataSet_PROY_PIP[0]->IDE_PIP;
                $IDE_PROYECTO = $DataSet_PROY_PIP[0]->IDE_PROYECTO;
                $COD_SNIP = $DataSet_PROY_PIP[0]->COD_SNIP;
                $COD_UNICO = $DataSet_PROY_PIP[0]->COD_UNICO;
                $COD_INFOBRAS = $DataSet_PROY_PIP[0]->COD_INFOBRAS;
                $COD_INTERNO = $DataSet_PROY_PIP[0]->COD_INTERNO;
                $EST_PROY_SNIP = $DataSet_PROY_PIP[0]->EST_PROY_SNIP;
                $CHK = $DataSet_PROY_PIP[0]->CHK;
                $EST_PROY_PIP = $DataSet_PROY_PIP[0]->EST_PROY_PIP;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_PIP', $IDE_PIP);
            $lCollection->Add('IDE_PROYECTO', $IDE_PROYECTO);
            $lCollection->Add('COD_SNIP', $COD_SNIP);
            $lCollection->Add('COD_UNICO', $COD_UNICO);
            $lCollection->Add('COD_INFOBRAS', $COD_INFOBRAS);
            $lCollection->Add('COD_INTERNO', $COD_INTERNO);
            $lCollection->Add('EST_PROY_SNIP', $EST_PROY_SNIP);
            $lCollection->Add('CHK', $CHK);
            $lCollection->Add('EST_PROY_PIP', $EST_PROY_PIP);
            
            
            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            $Data = PIP_Datos($IDE_PIP);
            
            $Bdescripcion = $Data['DES_PIP'] ;
            
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
            $DataSet_PROY_PIP = array();
            $Objeto_PROY_PIP_DAO = new PROY_PIP_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_PIP)) > 0) {
                $lstparametrosM['IDE_PIP'] = $IDE_PIP;
            }
            if (strlen(rtrim($IDE_PROYECTO)) > 0) {
                $lstparametrosM['IDE_PROYECTO'] = $IDE_PROYECTO;
            }
            if (strlen(rtrim($COD_SNIP)) > 0) {
                $lstparametrosM['COD_SNIP'] = $COD_SNIP;
            }
            if (strlen(rtrim($COD_UNICO)) > 0) {
                $lstparametrosM['COD_UNICO'] = $COD_UNICO;
            }
            if (strlen(rtrim($COD_INFOBRAS)) > 0) {
                $lstparametrosM['COD_INFOBRAS'] = $COD_INFOBRAS;
            }
            if (strlen(rtrim($COD_INTERNO)) > 0) {
                $lstparametrosM['COD_INTERNO'] = $COD_INTERNO;
            }
            if (strlen(rtrim($EST_PROY_SNIP)) > 0) {
                $lstparametrosM['EST_PROY_SNIP'] = $EST_PROY_SNIP;
            }
            if (strlen(rtrim($CHK)) > 0) {
                $lstparametrosM['CHK'] = $CHK;
            }
            if (strlen(rtrim($EST_PROY_PIP)) > 0) {
                $lstparametrosM['EST_PROY_PIP'] = $EST_PROY_PIP;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_PROYECTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_SNIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UNICO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_INFOBRAS'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_INTERNO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROY_SNIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CHK'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_PROY_PIP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_PROY_PIP_DAO->Update_PROY_PIP($DataSet_PROY_PIP, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[11][0];

            $mensaje = $procedure_parametrosMS[12][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_PROY_PIP = array();
            $Objeto_PROY_PIP_DAO = new PROY_PIP_DAO();
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
            $Objeto_PROY_PIP_DAO->Delete_PROY_PIP($DataSet_PROY_PIP, $procedure_parametrosMS); //JCMY
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

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_PROY_SNIP_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='98'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROY_SNIP_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_CHK_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='98'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_CHK_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_TABLAS_3 = array();
        $Objeto_EST_PROY_PIP_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_PROY_PIP_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_3, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_3', $DataSet_GEN_TABLAS_3);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;