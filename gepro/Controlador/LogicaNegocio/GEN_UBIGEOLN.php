<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_UBIGEOLN de la tabla GEN_UBIGEO
  //  Fecha           : jueves, 20 de junio de 2019 3:07:55
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J4
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_UBIGEODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */

//require_once("include/GEN_TABLASLNI.php");
//// busqueda lni
require_once("include/GEN_UBIGEOlni.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_UBIGEO";
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
        $COD_UBIGEO = isset($_REQUEST['COD_UBIGEO']) ? VerificarInputs($_REQUEST['COD_UBIGEO']) : "";
        $COD_UBIGEO_SUP = isset($_REQUEST['COD_UBIGEO_SUP']) ? VerificarInputs($_REQUEST['COD_UBIGEO_SUP']) : "";
        $DES_DEPARTAMENTO = isset($_REQUEST['DES_DEPARTAMENTO']) ? VerificarInputs($_REQUEST['DES_DEPARTAMENTO']) : "";
        $DES_PROVINCIA = isset($_REQUEST['DES_PROVINCIA']) ? VerificarInputs($_REQUEST['DES_PROVINCIA']) : "";
        $DES_DISTRITO = isset($_REQUEST['DES_DISTRITO']) ? VerificarInputs($_REQUEST['DES_DISTRITO']) : "";
        $NUM_NIVEL = isset($_REQUEST['NUM_NIVEL']) ? VerificarInputs($_REQUEST['NUM_NIVEL']) : "";
        $GEO_LONGITUD = isset($_REQUEST['GEO_LONGITUD']) ? VerificarInputs($_REQUEST['GEO_LONGITUD']) : "";
        $GEO_LATITUD = isset($_REQUEST['GEO_LATITUD']) ? VerificarInputs($_REQUEST['GEO_LATITUD']) : "";
        $EST_UBIGEO = isset($_REQUEST['EST_UBIGEO']) ? VerificarInputs($_REQUEST['EST_UBIGEO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_UBIGEO';

//       if ( $PIDE>0 ){
//             $ScriptFLX .= " AND P.COD_TABLA=$PIDE";
//             $pAuxiliar = '';         
//       } 
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
            $ogridDAO = new GEN_UBIGEO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'DES_DEPARTAMENTO') {
                        $_POST['qtype'] = 'DES_DEPARTAMENTO';
                    }
                    if ($_POST['qtype'] == 'DES_PROVINCIA') {
                        $_POST['qtype'] = 'DES_PROVINCIA';
                    }
                    if ($_POST['qtype'] == 'DES_DISTRITO') {
                        $_POST['qtype'] = 'DES_DISTRITO';
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
            $ogridDAO->Count_GEN_UBIGEO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->COD_UBIGEO;

            $lCollection->Add('nTotal', $nTotal);
            GenerarDatosParaFlexigridSP($ogridDAO, $TipoGrilla, $nTotal, $_POST['page'], $lparametro, $_POST['rp'], $_POST['sortname'], $_POST['sortorder']); //JCMY
            exit;
        }



        /* EDGAR ******************************************************************
         *        METODO PARA EXTRAER DATOS DE UN REGISTRO 
          /* EDGAR ***************************************************************** */
        if ($Action == "PasarDatos") {
//            echo 'entre'; exit;
            $Data = UBIGEO_Datos($PIDEbuscado);
//            $Data1 = Recurso_Datos($Data'IDE_RECURSO');
//            $Data2 = Cargo_Datos($Data'IDE_PUESTO');
            $Bdescripcion = '( '. $Data['BIDE'] .' ) '.$Data['DES_DEPARTAMENTO'] .'-'.$Data['DES_PROVINCIA'] .'-'.$Data['DES_DISTRITO']  ;
            $lCollection->Add('BIDE', $Data['BIDE']);
            $lCollection->Add('Bdescripcion', $Bdescripcion);
            $lCollection->Add('BGEO_LONGITUD', $Data['GEO_LONGITUD']);
            $lCollection->Add('BGEO_LATITUD', $Data['GEO_LATITUD']);
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_UBIGEOM = array();
            $Objeto_GEN_UBIGEO_DAO = new GEN_UBIGEO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($COD_UBIGEO)) > 0) {
                $lstparametrosM['COD_UBIGEO'] = $COD_UBIGEO;
            }
            if (strlen(rtrim($COD_UBIGEO_SUP)) > 0) {
                $lstparametrosM['COD_UBIGEO_SUP'] = $COD_UBIGEO_SUP;
            }
            if (strlen(rtrim($DES_DEPARTAMENTO)) > 0) {
                $lstparametrosM['DES_DEPARTAMENTO'] = $DES_DEPARTAMENTO;
            }
            if (strlen(rtrim($DES_PROVINCIA)) > 0) {
                $lstparametrosM['DES_PROVINCIA'] = $DES_PROVINCIA;
            }
            if (strlen(rtrim($DES_DISTRITO)) > 0) {
                $lstparametrosM['DES_DISTRITO'] = $DES_DISTRITO;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($GEO_LONGITUD)) > 0) {
                $lstparametrosM['GEO_LONGITUD'] = $GEO_LONGITUD;
            }
            if (strlen(rtrim($GEO_LATITUD)) > 0) {
                $lstparametrosM['GEO_LATITUD'] = $GEO_LATITUD;
            }
            if (strlen(rtrim($EST_UBIGEO)) > 0) {
                $lstparametrosM['EST_UBIGEO'] = $EST_UBIGEO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['COD_UBIGEO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['COD_UBIGEO_SUP'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DEPARTAMENTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_PROVINCIA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_DISTRITO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GEO_LONGITUD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['GEO_LATITUD'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_UBIGEO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_UBIGEO_DAO->Insert_GEN_UBIGEO($DataSet_GEN_UBIGEO, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_UBIGEO = array();
            $Objeto_GEN_UBIGEO_DAO = new GEN_UBIGEO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_UBIGEO_DAO->SelPk_GEN_UBIGEO($DataSet_GEN_UBIGEO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_UBIGEO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_UBIGEO

                $COD_UBIGEO = $DataSet_GEN_UBIGEO[0]->COD_UBIGEO;
                $COD_UBIGEO_SUP = $DataSet_GEN_UBIGEO[0]->COD_UBIGEO_SUP;
                $DES_DEPARTAMENTO = $DataSet_GEN_UBIGEO[0]->DES_DEPARTAMENTO;
                $DES_PROVINCIA = $DataSet_GEN_UBIGEO[0]->DES_PROVINCIA;
                $DES_DISTRITO = $DataSet_GEN_UBIGEO[0]->DES_DISTRITO;
                $NUM_NIVEL = $DataSet_GEN_UBIGEO[0]->NUM_NIVEL;
                $GEO_LONGITUD = $DataSet_GEN_UBIGEO[0]->GEO_LONGITUD;
                $GEO_LATITUD = $DataSet_GEN_UBIGEO[0]->GEO_LATITUD;
                $EST_UBIGEO = $DataSet_GEN_UBIGEO[0]->EST_UBIGEO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('COD_UBIGEO', $COD_UBIGEO);
            $lCollection->Add('COD_UBIGEO_SUP', $COD_UBIGEO_SUP);
            $lCollection->Add('DES_DEPARTAMENTO', $DES_DEPARTAMENTO);
            $lCollection->Add('DES_PROVINCIA', $DES_PROVINCIA);
            $lCollection->Add('DES_DISTRITO', $DES_DISTRITO);
            $lCollection->Add('NUM_NIVEL', $NUM_NIVEL);
            $lCollection->Add('GEO_LONGITUD', $GEO_LONGITUD);
            $lCollection->Add('GEO_LATITUD', $GEO_LATITUD);
            $lCollection->Add('EST_UBIGEO', $EST_UBIGEO);

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

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_UBIGEO = array();
            $Objeto_GEN_UBIGEO_DAO = new GEN_UBIGEO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($COD_UBIGEO)) > 0) {
                $lstparametrosM['COD_UBIGEO'] = $COD_UBIGEO;
            }
            if (strlen(rtrim($COD_UBIGEO_SUP)) > 0) {
                $lstparametrosM['COD_UBIGEO_SUP'] = $COD_UBIGEO_SUP;
            }
            if (strlen(rtrim($DES_DEPARTAMENTO)) > 0) {
                $lstparametrosM['DES_DEPARTAMENTO'] = $DES_DEPARTAMENTO;
            }
            if (strlen(rtrim($DES_PROVINCIA)) > 0) {
                $lstparametrosM['DES_PROVINCIA'] = $DES_PROVINCIA;
            }
            if (strlen(rtrim($DES_DISTRITO)) > 0) {
                $lstparametrosM['DES_DISTRITO'] = $DES_DISTRITO;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($GEO_LONGITUD)) > 0) {
                $lstparametrosM['GEO_LONGITUD'] = $GEO_LONGITUD;
            }
            if (strlen(rtrim($GEO_LATITUD)) > 0) {
                $lstparametrosM['GEO_LATITUD'] = $GEO_LATITUD;
            }
            if (strlen(rtrim($EST_UBIGEO)) > 0) {
                $lstparametrosM['EST_UBIGEO'] = $EST_UBIGEO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UBIGEO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['COD_UBIGEO_SUP'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DEPARTAMENTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_PROVINCIA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_DISTRITO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GEO_LONGITUD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['GEO_LATITUD'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_UBIGEO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_UBIGEO_DAO->Update_GEN_UBIGEO($DataSet_GEN_UBIGEO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[11][0];

            $mensaje = $procedure_parametrosMS[12][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_UBIGEO = array();
            $Objeto_GEN_UBIGEO_DAO = new GEN_UBIGEO_DAO();
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
            $Objeto_GEN_UBIGEO_DAO->Delete_GEN_UBIGEO($DataSet_GEN_UBIGEO, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_NUM_NIVEL_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '20'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_NUM_NIVEL_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_UBIGEO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = '99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_UBIGEO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
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