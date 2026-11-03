<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_CONCEPTO_SOCIALLN de la tabla GEN_CONCEPTO_SOCIAL
  //  Fecha           : domingo, 26 de mayo de 2019 20:51:18
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-G
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_CONCEPTO_SOCIALDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_CONCEPTO_SOCIALDAO.php");



/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_CONCEPTO_SOCIAL";
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

        ////// PARAMETROS DE FILTRO: RECURSIVO, O PERSONALIZACION DE TABLAS 
        $Recursiva_Nivel_Actual = isset($_REQUEST['Recursiva_Nivel_Actual']) ? VerificarInputs($_REQUEST['Recursiva_Nivel_Actual']) : "";

        //echo 'Recursiva_Nivel_Actual:'.$Recursiva_Nivel_Actual;
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $DES_CONCEPTO = isset($_REQUEST['DES_CONCEPTO']) ? VerificarInputs($_REQUEST['DES_CONCEPTO']) : "";
        $DES_CONCEPTO_ABREVIATURA = isset($_REQUEST['DES_CONCEPTO_ABREVIATURA']) ? VerificarInputs($_REQUEST['DES_CONCEPTO_ABREVIATURA']) : "";
        $TIP_UNIDAD_MEDIDA = isset($_REQUEST['TIP_UNIDAD_MEDIDA']) ? VerificarInputs($_REQUEST['TIP_UNIDAD_MEDIDA']) : "";
        $NUM_NIVEL = isset($_REQUEST['NUM_NIVEL']) ? VerificarInputs($_REQUEST['NUM_NIVEL']) : "";
        $EST_CONCEPTO = isset($_REQUEST['EST_CONCEPTO']) ? VerificarInputs($_REQUEST['EST_CONCEPTO']) : "";
        $IDE_RUBRO = isset($_REQUEST['IDE_RUBRO']) ? VerificarInputs($_REQUEST['IDE_RUBRO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_CONCEPTO_SOCIAL';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_RUBRO=$PIDE";
             $pAuxiliar = 'Anidado';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
//            
//             $Data = GenTablas_Datos1($PIDE);
           // $lCollection->Add('VNUM_NIVEL', 12 );
            $lCollection->Add('VIDE_RUBRO', $PIDE );
//             $lCollection->Add('VCOD_TABLA', $Data['COD_TABLA'] );
       } else {
            $ScriptFLX = $ScriptFLX." AND T.NUM_NIVEL=11 ";
            $pAuxiliar = 'Anidado';
            $lCollection->Add('VNUM_NIVEL', 11 );
            $lCollection->Add('VIDE_RUBRO', 0 );
       } 


          ////// SI ES UN REGISTRO RECURSIVO - 04/07/2021
          $Recursiva = 'SI';
          $Recursiva_hide = 'false';
          if ($Recursiva == 'SI') {
              $Recursiva_Limite_min = 11;
              $Recursiva_Limite_max = 14;
  
              if ($PIDE == '') {
                  $Recursiva_Nivel_Actual = $Recursiva_Limite_min;
              }
              if (intval($Recursiva_Nivel_Actual) < $Recursiva_Limite_max) {
                  $Recursiva_hide = 'false';
              } else {
                $Recursiva_hide = 'true';
              }
              $ScriptFLX .= " AND T.NUM_NIVEL =" . $Recursiva_Nivel_Actual;
  
              $lCollection->Add('Recursiva_Nivel_Actual', $Recursiva_Nivel_Actual);
              $lCollection->Add('Recursiva_hide', $Recursiva_hide);
          }
        /////- 04/07/2021

       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_CONCEPTO_SOCIAL_pAuxiliar' : $TipoGrilla ) ;
       
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_GEN_CONCEPTO_SOCIAL_busqueda';
        }
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_CONCEPTO_SOCIAL_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'IDE_RUBRO') {
                        $_POST['qtype'] = 'T.IDE_RUBRO';
                    }
                    if ($_POST['qtype'] == 'DES_CONCEPTO') {
                        $_POST['qtype'] = 'T.DES_CONCEPTO';
                    }
                    if ($_POST['qtype'] == 'DES_CONCEPTO_ABREVIATURA') {
                        $_POST['qtype'] = 'T.DES_CONCEPTO_ABREVIATURA';
                    }
                    if ($_POST['qtype'] == 'TIP_UNIDAD_MEDIDA') {
                        $_POST['qtype'] = 'T2.DES_ITEM';
                    }
                    if ($_POST['qtype'] == 'NUM_NIVEL') {
                        $_POST['qtype'] = 'T.NUM_NIVEL';
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
            $ogridDAO->Count_GEN_CONCEPTO_SOCIAL($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_CONCEPTO;

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

            /* FIN DE ACTIVACION */

            $DataSet_GEN_CONCEPTO_SOCIALM = array();
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO = new GEN_CONCEPTO_SOCIAL_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($DES_CONCEPTO)) > 0) {
                $lstparametrosM['DES_CONCEPTO'] = $DES_CONCEPTO;
            }
            if (strlen(rtrim($DES_CONCEPTO_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_CONCEPTO_ABREVIATURA'] = $DES_CONCEPTO_ABREVIATURA;
            }
            if (strlen(rtrim($TIP_UNIDAD_MEDIDA)) > 0) {
                $lstparametrosM['TIP_UNIDAD_MEDIDA'] = $TIP_UNIDAD_MEDIDA;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($EST_CONCEPTO)) > 0) {
                $lstparametrosM['EST_CONCEPTO'] = $EST_CONCEPTO;
            }
            if (strlen(rtrim($IDE_RUBRO)) > 0) {
                $lstparametrosM['IDE_RUBRO'] = $IDE_RUBRO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['DES_CONCEPTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_CONCEPTO_ABREVIATURA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['TIP_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_CONCEPTO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_RUBRO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO->Insert_GEN_CONCEPTO_SOCIAL($DataSet_GEN_CONCEPTO_SOCIAL, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

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
            $DataSet_GEN_CONCEPTO_SOCIAL = array();
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO = new GEN_CONCEPTO_SOCIAL_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO->SelPk_GEN_CONCEPTO_SOCIAL($DataSet_GEN_CONCEPTO_SOCIAL, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_CONCEPTO_SOCIAL) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_CONCEPTO_SOCIAL

                $DES_CONCEPTO = $DataSet_GEN_CONCEPTO_SOCIAL[0]->DES_CONCEPTO;
                $DES_CONCEPTO_ABREVIATURA = $DataSet_GEN_CONCEPTO_SOCIAL[0]->DES_CONCEPTO_ABREVIATURA;
                $TIP_UNIDAD_MEDIDA = $DataSet_GEN_CONCEPTO_SOCIAL[0]->TIP_UNIDAD_MEDIDA;
                $NUM_NIVEL = $DataSet_GEN_CONCEPTO_SOCIAL[0]->NUM_NIVEL;
                $EST_CONCEPTO = $DataSet_GEN_CONCEPTO_SOCIAL[0]->EST_CONCEPTO;
                $IDE_RUBRO = $DataSet_GEN_CONCEPTO_SOCIAL[0]->IDE_RUBRO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('DES_CONCEPTO', $DES_CONCEPTO);
            $lCollection->Add('DES_CONCEPTO_ABREVIATURA', $DES_CONCEPTO_ABREVIATURA);
            $lCollection->Add('TIP_UNIDAD_MEDIDA', $TIP_UNIDAD_MEDIDA);
            $lCollection->Add('NUM_NIVEL', $NUM_NIVEL);
            $lCollection->Add('EST_CONCEPTO', $EST_CONCEPTO);
            $lCollection->Add('IDE_RUBRO', $IDE_RUBRO);

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

            //var_dump($FechaHoraRegistro);exit;        
            /* FIN DE ACTIVACION */
            $DataSet_GEN_CONCEPTO_SOCIAL = array();
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO = new GEN_CONCEPTO_SOCIAL_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($DES_CONCEPTO)) > 0) {
                $lstparametrosM['DES_CONCEPTO'] = $DES_CONCEPTO;
            }
            if (strlen(rtrim($DES_CONCEPTO_ABREVIATURA)) > 0) {
                $lstparametrosM['DES_CONCEPTO_ABREVIATURA'] = $DES_CONCEPTO_ABREVIATURA;
            }
            if (strlen(rtrim($TIP_UNIDAD_MEDIDA)) > 0) {
                $lstparametrosM['TIP_UNIDAD_MEDIDA'] = $TIP_UNIDAD_MEDIDA;
            }
            if (strlen(rtrim($NUM_NIVEL)) > 0) {
                $lstparametrosM['NUM_NIVEL'] = $NUM_NIVEL;
            }
            if (strlen(rtrim($EST_CONCEPTO)) > 0) {
                $lstparametrosM['EST_CONCEPTO'] = $EST_CONCEPTO;
            }
            if (strlen(rtrim($IDE_RUBRO)) > 0) {
                $lstparametrosM['IDE_RUBRO'] = $IDE_RUBRO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CONCEPTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_CONCEPTO_ABREVIATURA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['TIP_UNIDAD_MEDIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['NUM_NIVEL'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_CONCEPTO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_RUBRO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO->Update_GEN_CONCEPTO_SOCIAL($DataSet_GEN_CONCEPTO_SOCIAL, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[8][0];

            $mensaje = $procedure_parametrosMS[9][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_CONCEPTO_SOCIAL = array();
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO = new GEN_CONCEPTO_SOCIAL_DAO();
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
            $Objeto_GEN_CONCEPTO_SOCIAL_DAO->Delete_GEN_CONCEPTO_SOCIAL($DataSet_GEN_CONCEPTO_SOCIAL, $procedure_parametrosMS); //JCMY
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

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_TIP_UNIDAD_MEDIDA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='79'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_TIP_UNIDAD_MEDIDA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_2 = array();
        $Objeto_EST_CONCEPTO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='99'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_CONCEPTO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_2, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_2', $DataSet_GEN_TABLAS_2);

        /* 					 */

        $DataSet_GEN_CONCEPTO_SOCIAL_1 = array();
        $Objeto_IDE_RUBRO_DAO = new GEN_CONCEPTO_SOCIAL_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "IDE_CONCEPTO,DES_CONCEPTO";
        $lstparametrosM['filtro'] = " AND NUM_NIVEL=1 ";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_IDE_RUBRO_DAO->SelCampos_GEN_CONCEPTO_SOCIAL($DataSet_GEN_CONCEPTO_SOCIAL_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_CONCEPTO_SOCIAL_1', $DataSet_GEN_CONCEPTO_SOCIAL_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        $lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;