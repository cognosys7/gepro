<?php

require_once(PATH_CONTROLADOR_DAO . "/SEG_ENTIDAD_USUARIODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIARES */

require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "SEG_ENTIDAD_USUARIO";
    $PermisoOK = 0;
    $CargaAsignacion  = 0;

    //OBTENGOS LOS POST ANTIREFRESH        
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        
    //OBTIENE LOS PERMISOS Y NIVELES DE ACCESO
    $PermisosPerfil         = CallNomPerfil($perfilsession);
    
    //VERIFICA EL ACCESO
    if (($PermisosPerfil == "ADMINISTRADOR" OR $PermisosPerfil == "GESTOR DE USUARIOS"))
    {
        $PermisoOK = 1;
    }

    if ($PermisoOK == 1){
        
        /*******************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
        /*******************************************************************/
        //ACCIONES PARA EL FORMULARIO
        
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";

        /*******************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
        /*******************************************************************/
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDUSUARIO = isset($_REQUEST['IDUSUARIO']) ? VerificarInputs($_REQUEST['IDUSUARIO']) : "";
        $IDE_ENTIDAD = isset($_REQUEST['IDE_ENTIDAD']) ? VerificarInputs($_REQUEST['IDE_ENTIDAD']) : "";
        $TIP_ACCESO = isset($_REQUEST['TIP_ACCESO']) ? VerificarInputs($_REQUEST['TIP_ACCESO']) : "";
        $EST_ENTIDAD_USUARIO = isset($_REQUEST['EST_ENTIDAD_USUARIO']) ? VerificarInputs($_REQUEST['EST_ENTIDAD_USUARIO']) : "";
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR        
        $PIDE_USUARIO = isset($_REQUEST['PIDE_USUARIO'])? VerificarInputs($_REQUEST['PIDE_USUARIO']) : "";
        
        /* FLEXIGRID */        
        $ScriptFLX = " AND IDUSUARIO=".$PIDE_USUARIO;

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new SEG_ENTIDAD_USUARIO_DAO();            

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'UnidadEjecutora') {
                        $_POST['qtype'] = 'GE.DES_ENTIDAD';
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
            $ogridDAO->Count_SEG_ENTIDAD_USUARIO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_ENTIDAD_USUARIO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, 'SelGrd_SEG_ENTIDAD_USUARIO', $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }

        /*******************************************************************
        *        METODO PARA INSERTAR UN REGISTRO 
        /*******************************************************************/
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_SEG_ENTIDAD_USUARIOM = array();
            $Objeto_SEG_ENTIDAD_USUARIO_DAO = new SEG_ENTIDAD_USUARIO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDUSUARIO)) > 0) {
                $lstparametrosM['IDUSUARIO'] = $IDUSUARIO;
            }
            if (strlen(rtrim($IDE_ENTIDAD)) > 0) {
                $lstparametrosM['IDE_ENTIDAD'] = $IDE_ENTIDAD;
            }
            if (strlen(rtrim($TIP_ACCESO)) > 0) {
                $lstparametrosM['TIP_ACCESO'] = $TIP_ACCESO;
            }
            if (strlen(rtrim($EST_ENTIDAD_USUARIO)) > 0) {
                $lstparametrosM['EST_ENTIDAD_USUARIO'] = $EST_ENTIDAD_USUARIO;
            }

            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDUSUARIO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_ENTIDAD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_ACCESO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ENTIDAD_USUARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_SEG_ENTIDAD_USUARIO_DAO->Insert_SEG_ENTIDAD_USUARIO($DataSet_SEG_ENTIDAD_USUARIO, $procedure_parametrosMS); //JCMY

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
            $DataSet_SEG_ENTIDAD_USUARIO = array();
            $Objeto_SEG_ENTIDAD_USUARIO_DAO = new SEG_ENTIDAD_USUARIO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_SEG_ENTIDAD_USUARIO_DAO->SelPk_SEG_ENTIDAD_USUARIO($DataSet_SEG_ENTIDAD_USUARIO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_SEG_ENTIDAD_USUARIO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_SEG_ENTIDAD_USUARIO

                $IDUSUARIO = $DataSet_SEG_ENTIDAD_USUARIO[0]->IDUSUARIO;
                $IDE_ENTIDAD = $DataSet_SEG_ENTIDAD_USUARIO[0]->IDE_ENTIDAD;
                $TIP_ACCESO = $DataSet_SEG_ENTIDAD_USUARIO[0]->TIP_ACCESO;
                $EST_ENTIDAD_USUARIO = $DataSet_SEG_ENTIDAD_USUARIO[0]->EST_ENTIDAD_USUARIO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDUSUARIO', $IDUSUARIO);
            $lCollection->Add('IDE_ENTIDAD', $IDE_ENTIDAD);
            $lCollection->Add('TIP_ACCESO', $TIP_ACCESO);
            $lCollection->Add('EST_ENTIDAD_USUARIO', $EST_ENTIDAD_USUARIO);
        }

        /*         * *****************************************************************
         *        METODO PARA ACTUALIZAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "ActualizarForm") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_SEG_ENTIDAD_USUARIO = array();
            $Objeto_SEG_ENTIDAD_USUARIO_DAO = new SEG_ENTIDAD_USUARIO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDUSUARIO)) > 0) {
                $lstparametrosM['IDUSUARIO'] = $IDUSUARIO;
            }
            if (strlen(rtrim($IDE_ENTIDAD)) > 0) {
                $lstparametrosM['IDE_ENTIDAD'] = $IDE_ENTIDAD;
            }
            if (strlen(rtrim($TIP_ACCESO)) > 0) {
                $lstparametrosM['TIP_ACCESO'] = $TIP_ACCESO;
            }
            if (strlen(rtrim($EST_ENTIDAD_USUARIO)) > 0) {
                $lstparametrosM['EST_ENTIDAD_USUARIO'] = $EST_ENTIDAD_USUARIO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDUSUARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_ENTIDAD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_ACCESO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ENTIDAD_USUARIO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_SEG_ENTIDAD_USUARIO_DAO->Update_SEG_ENTIDAD_USUARIO($DataSet_SEG_ENTIDAD_USUARIO, $procedure_parametrosMS);
            $CodMensaje = $procedure_parametrosMS[6][0];
            $mensaje = $procedure_parametrosMS[7][0];
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_SEG_ENTIDAD_USUARIO = array();
            $Objeto_SEG_ENTIDAD_USUARIO_DAO = new SEG_ENTIDAD_USUARIO_DAO();
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
            $Objeto_SEG_ENTIDAD_USUARIO_DAO->Delete_SEG_ENTIDAD_USUARIO($DataSet_SEG_ENTIDAD_USUARIO, $procedure_parametrosMS); //JCMY
            $CodMensaje = $procedure_parametrosMS[2][0];
            $mensaje = $procedure_parametrosMS[3][0];
            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }
        /********************************************************************************
         *          SECCION DE CODIGO PARA LAS LISTAS DEPLEGABLES O COMBOS
        /*******************************************************************************/
 
        $DataSet_tsusuario_1 = array();
        $Objeto_IDUSUARIO_DAO = new UsuarioDAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
           ,array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_IDUSUARIO_DAO->SelCampos_tsusuario($DataSet_tsusuario_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_tsusuario_1', $DataSet_tsusuario_1);


        $DataSet_GEN_ENTIDAD_1 = array();
        $Objeto_IDE_ENTIDAD_DAO = new GEN_ENTIDAD_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_ENTIDAD,DES_ENTIDAD";
        $lstparametrosM['filtro'] = "";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_ENTIDAD_DAO->SelCampos_GEN_ENTIDAD($DataSet_GEN_ENTIDAD_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_ENTIDAD_1', $DataSet_GEN_ENTIDAD_1);

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_ACCESO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '22'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_ACCESO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_ENTIDAD_USUARIO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );
        $Objeto_EST_ENTIDAD_USUARIO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);    
        
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        //$lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);        
        $lCollection->Add('PIDE_USUARIO', $PIDE_USUARIO);
    

        /* 					 */
    }
}

//var_dump($lstDepartamento);exit;
    