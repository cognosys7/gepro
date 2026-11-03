<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                     
//  Propósito       : BIDM_GASTO_CONSOLIDAln de la tabla BIDM_GASTO_CONSOLIDA
//  Fecha           : martes, 25 de mayo de 2021 14:17:14
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:17:14
//******************************************************************************/

require_once(PATH_CONTROLADOR_DAO . "/BIDM_GASTO_CONSOLIDADAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/LNinclude.php");
require_once("include/CONTRATOlni.php");
require_once("include/PROY_CONTRATOlni.php");
require_once("include/PROYECTO_ACTIVIDADlni.php");
require_once("include/PROYECTOlni.php");
require_once("include/BIDM_GASTO_CONSOLIDAlni.php");
//// busqueda lni
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "BIDM_GASTO_CONSOLIDA";
    $PermisoOK = 0;



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



    if ($PermisoOK == 1) {
        /*         * *****************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
          /****************************************************************** */
        //ACCIONES PARA EL FORMULARIO
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";



        /* EDGAR */
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : "";
        $lCollection->Add('PIDE', $PIDE);

        ////// TIPO DE VENTANA: MANTENIMIENTO O BUSQUEDA-SELECCION
        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $lCollection->Add('Pedido', $Pedido);

        ////// IDE: BUSQUEDA-SELECCION
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);

        ////// PARAMETROS DE FILTRO: RECURSIVO, O PERSONALIZACION DE TABLAS 
        $Recursiva_Nivel_Actual = isset($_REQUEST['Recursiva_Nivel_Actual']) ? VerificarInputs($_REQUEST['Recursiva_Nivel_Actual']) : "";

        /* EDGAR */



        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $AsientoIde = isset($_REQUEST['AsientoIde']) ? VerificarInputs($_REQUEST['AsientoIde']) : "";
        $AsientoNumDocumento = isset($_REQUEST['AsientoNumDocumento']) ? VerificarInputs($_REQUEST['AsientoNumDocumento']) : "";
        $AsientoAnio = isset($_REQUEST['AsientoAnio']) ? VerificarInputs($_REQUEST['AsientoAnio']) : "";
        $AsientoPeriodo = isset($_REQUEST['AsientoPeriodo']) ? VerificarInputs($_REQUEST['AsientoPeriodo']) : "";
        $CencoCodigo = isset($_REQUEST['CencoCodigo']) ? VerificarInputs($_REQUEST['CencoCodigo']) : "";
        $CencoNombre = isset($_REQUEST['CencoNombre']) ? VerificarInputs($_REQUEST['CencoNombre']) : "";
        $ContratoOrden = isset($_REQUEST['ContratoOrden']) ? VerificarInputs($_REQUEST['ContratoOrden']) : "";
        $OrdenCodigo = isset($_REQUEST['OrdenCodigo']) ? VerificarInputs($_REQUEST['OrdenCodigo']) : "";
        $ActorDocumento = isset($_REQUEST['ActorDocumento']) ? VerificarInputs($_REQUEST['ActorDocumento']) : "";
        $ActorNombre = isset($_REQUEST['ActorNombre']) ? VerificarInputs($_REQUEST['ActorNombre']) : "";
        $ProyectoCodigo = isset($_REQUEST['ProyectoCodigo']) ? VerificarInputs($_REQUEST['ProyectoCodigo']) : "";
        $ProyectoNombreCorto = isset($_REQUEST['ProyectoNombreCorto']) ? VerificarInputs($_REQUEST['ProyectoNombreCorto']) : "";
        $ProyGrupoCodigo = isset($_REQUEST['ProyGrupoCodigo']) ? VerificarInputs($_REQUEST['ProyGrupoCodigo']) : "";
        $CtaCodigo = isset($_REQUEST['CtaCodigo']) ? VerificarInputs($_REQUEST['CtaCodigo']) : "";
        $CtaNomPartida = isset($_REQUEST['CtaNomPartida']) ? VerificarInputs($_REQUEST['CtaNomPartida']) : "";
        $CtaNomClase = isset($_REQUEST['CtaNomClase']) ? VerificarInputs($_REQUEST['CtaNomClase']) : "";
        $CtaNombre = isset($_REQUEST['CtaNombre']) ? VerificarInputs($_REQUEST['CtaNombre']) : "";
        $FuenteAbrev = isset($_REQUEST['FuenteAbrev']) ? VerificarInputs($_REQUEST['FuenteAbrev']) : "";
        $AsientoMontoSoles = isset($_REQUEST['AsientoMontoSoles']) ? VerificarInputs($_REQUEST['AsientoMontoSoles']) : "";
        $Fase = isset($_REQUEST['Fase']) ? VerificarInputs($_REQUEST['Fase']) : "";
        $Componente = isset($_REQUEST['Componente']) ? VerificarInputs($_REQUEST['Componente']) : "";
        $EST_BIDM_GASTO_CONSOLIDA = isset($_REQUEST['EST_BIDM_GASTO_CONSOLIDA']) ? VerificarInputs($_REQUEST['EST_BIDM_GASTO_CONSOLIDA']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        ////// GRILLA PREDETERMINADA
        $TipoGrilla = 'SelGrd_BIDM_GASTO_CONSOLIDA';
        $Recursiva_hide = 'true';
        $Tabla_DatosPadre = '';

        ////// SI TIENE UN REGISTRO PADRE, ENTONCES SE DIBUJA CABEZERA
        if ($PIDE > 0) {
            $FILTRO_contrato = $FILTRO_contrato1 = "";
            $Data11 = Contrato_Datos($PIDE);
            $BCOD_CONTRATO_ENTIDAD = trim($Data11['COD_CONTRATO_ENTIDAD']);
            $BCOD_CONTRATO_ENTIDAD_tipo = substr($BCOD_CONTRATO_ENTIDAD,0,2);
            $BCOD_ORDEN = trim($Data11['COD_ORDEN']);
            if($BCOD_CONTRATO_ENTIDAD_tipo=='GL'){
                $FILTRO_contrato .= " AND trim(T.ContratoOrden) = '$BCOD_CONTRATO_ENTIDAD' ";
                $FILTRO_contrato1 .= " AND trim(ContratoOrden) = '$BCOD_CONTRATO_ENTIDAD' ";
            } else {
                $FILTRO_contrato .= " AND trim(T.OrdenCodigo) = '$BCOD_ORDEN' ";
                $FILTRO_contrato1 .= " AND trim(OrdenCodigo) = '$BCOD_ORDEN' ";
            }
            
            $ScriptFLX .= $FILTRO_contrato; //echo 'te vi'.$ScriptFLX; 
            
            $Data12 = ProyectoContrato_Datos3($PIDE);    //        var_dump($Data12); die;
            $Data13 = ProyectoActividad_Datos($Data12['IDE_PROYECTO_ACTIVIDAD']);
            $Tabla_DatosPadre = Tabla_Proyecto_Datos($Data13['IDE_PROYECTO']) .'<hr>'. Tabla_Contrato_Datos($PIDE) .'<hr>'. Tabla_BIDM_GASTO_CONSOLIDA_Datos_sumMonto($FILTRO_contrato1);
        }

        ////// SI ES UN REGISTRO RECURSIVO
        $Recursiva = 'NO';
        if ($Recursiva == 'SI') {
            $Recursiva_Limite_min = 11;
            $Recursiva_Limite_max = 13;

            if ($PIDE == '') {
                $Recursiva_Nivel_Actual = $Recursiva_Limite_min;
            }
            if (intval($Recursiva_Nivel_Actual) < $Recursiva_Limite_max) {
                $Recursiva_hide = 'false';
            }
            $ScriptFLX .= " AND T.NUM_NIVEL =" . $Recursiva_Nivel_Actual;

            $lCollection->Add('Recursiva_Nivel_Actual', $Recursiva_Nivel_Actual);
        }

        ////// PASE DE PARAMETROS DE GRILLA        
        $lCollection->Add('Tabla_DatosPadre', $Tabla_DatosPadre);
        $lCollection->Add('Recursiva_hide', $Recursiva_hide);

        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new BIDM_GASTO_CONSOLIDA_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'AsientoIde') {
                        $_POST['qtype'] = 'T.AsientoIde';
                    }
                    if ($_POST['qtype'] == 'AsientoNumDocumento') {
                        $_POST['qtype'] = 'T.AsientoNumDocumento';
                    }
                    if ($_POST['qtype'] == 'AsientoPeriodo') {
                        $_POST['qtype'] = 'T.AsientoPeriodo';
                    }
                    if ($_POST['qtype'] == 'ContratoOrden') {
                        $_POST['qtype'] = 'T.ContratoOrden';
                    }
                    if ($_POST['qtype'] == 'OrdenCodigo') {
                        $_POST['qtype'] = 'T.OrdenCodigo';
                    }
                    if ($_POST['qtype'] == 'ActorNombre') {
                        $_POST['qtype'] = 'T.ActorNombre';
                    }
                    if ($_POST['qtype'] == 'ProyectoNombreCorto') {
                        $_POST['qtype'] = 'T.ProyectoNombreCorto';
                    }
                    if ($_POST['qtype'] == 'CtaNomPartida') {
                        $_POST['qtype'] = 'T.CtaNomPartida';
                    }
                    if ($_POST['qtype'] == 'FuenteAbrev') {
                        $_POST['qtype'] = 'T.FuenteAbrev';
                    }
                    if ($_POST['qtype'] == 'AsientoMontoSoles') {
                        $_POST['qtype'] = 'T.AsientoMontoSoles';
                    }
                    if ($_POST['qtype'] == 'Componente') {
                        $_POST['qtype'] = 'T.Componente';
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
            $ogridDAO->Count_BIDM_GASTO_CONSOLIDA($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_BIDM_GASTO_CONSOLIDA;

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
//            $Data1 = Recurso_Datos($Data['IDE_RECURSO']);
//            $Bdescripcion = $Data1['DES_RECURSO']  ;
//            $lCollection->Add('BIDE', $PIDEbuscado);
//            $lCollection->Add('Bdescripcion', $Bdescripcion);
//            echo 'entre'. $PIDEbuscado . ' - '.$Bdescripcion ; exit;
        }



        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_BIDM_GASTO_CONSOLIDAM = array();
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO = new BIDM_GASTO_CONSOLIDA_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($AsientoIde)) > 0) {
                $lstparametrosM['AsientoIde'] = $AsientoIde;
            }
            if (strlen(rtrim($AsientoNumDocumento)) > 0) {
                $lstparametrosM['AsientoNumDocumento'] = $AsientoNumDocumento;
            }
            if (strlen(rtrim($AsientoAnio)) > 0) {
                $lstparametrosM['AsientoAnio'] = $AsientoAnio;
            }
            if (strlen(rtrim($AsientoPeriodo)) > 0) {
                $lstparametrosM['AsientoPeriodo'] = $AsientoPeriodo;
            }
            if (strlen(rtrim($CencoCodigo)) > 0) {
                $lstparametrosM['CencoCodigo'] = $CencoCodigo;
            }
            if (strlen(rtrim($CencoNombre)) > 0) {
                $lstparametrosM['CencoNombre'] = $CencoNombre;
            }
            if (strlen(rtrim($ContratoOrden)) > 0) {
                $lstparametrosM['ContratoOrden'] = $ContratoOrden;
            }
            if (strlen(rtrim($OrdenCodigo)) > 0) {
                $lstparametrosM['OrdenCodigo'] = $OrdenCodigo;
            }
            if (strlen(rtrim($ActorDocumento)) > 0) {
                $lstparametrosM['ActorDocumento'] = $ActorDocumento;
            }
            if (strlen(rtrim($ActorNombre)) > 0) {
                $lstparametrosM['ActorNombre'] = $ActorNombre;
            }
            if (strlen(rtrim($ProyectoCodigo)) > 0) {
                $lstparametrosM['ProyectoCodigo'] = $ProyectoCodigo;
            }
            if (strlen(rtrim($ProyectoNombreCorto)) > 0) {
                $lstparametrosM['ProyectoNombreCorto'] = $ProyectoNombreCorto;
            }
            if (strlen(rtrim($ProyGrupoCodigo)) > 0) {
                $lstparametrosM['ProyGrupoCodigo'] = $ProyGrupoCodigo;
            }
            if (strlen(rtrim($CtaCodigo)) > 0) {
                $lstparametrosM['CtaCodigo'] = $CtaCodigo;
            }
            if (strlen(rtrim($CtaNomPartida)) > 0) {
                $lstparametrosM['CtaNomPartida'] = $CtaNomPartida;
            }
            if (strlen(rtrim($CtaNomClase)) > 0) {
                $lstparametrosM['CtaNomClase'] = $CtaNomClase;
            }
            if (strlen(rtrim($CtaNombre)) > 0) {
                $lstparametrosM['CtaNombre'] = $CtaNombre;
            }
            if (strlen(rtrim($FuenteAbrev)) > 0) {
                $lstparametrosM['FuenteAbrev'] = $FuenteAbrev;
            }
            if (strlen(rtrim($AsientoMontoSoles)) > 0) {
                $lstparametrosM['AsientoMontoSoles'] = $AsientoMontoSoles;
            }
            if (strlen(rtrim($Fase)) > 0) {
                $lstparametrosM['Fase'] = $Fase;
            }
            if (strlen(rtrim($Componente)) > 0) {
                $lstparametrosM['Componente'] = $Componente;
            }
            if (strlen(rtrim($EST_BIDM_GASTO_CONSOLIDA)) > 0) {
                $lstparametrosM['EST_BIDM_GASTO_CONSOLIDA'] = $EST_BIDM_GASTO_CONSOLIDA;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['AsientoIde'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['AsientoNumDocumento'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['AsientoAnio'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['AsientoPeriodo'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CencoCodigo'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CencoNombre'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['ContratoOrden'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['OrdenCodigo'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['ActorDocumento'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['ActorNombre'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['ProyectoCodigo'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['ProyectoNombreCorto'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['ProyGrupoCodigo'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CtaCodigo'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CtaNomPartida'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CtaNomClase'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['CtaNombre'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['FuenteAbrev'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['AsientoMontoSoles'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['Fase'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['Componente'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_BIDM_GASTO_CONSOLIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO->Insert_BIDM_GASTO_CONSOLIDA($DataSet_BIDM_GASTO_CONSOLIDA, $procedure_parametrosMS); //JCMY

            $CodMensaje = $procedure_parametrosMS[23][0];

            $mensaje = $procedure_parametrosMS[24][0];

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
            $DataSet_BIDM_GASTO_CONSOLIDA = array();
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO = new BIDM_GASTO_CONSOLIDA_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO->SelPk_BIDM_GASTO_CONSOLIDA($DataSet_BIDM_GASTO_CONSOLIDA, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_BIDM_GASTO_CONSOLIDA) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_BIDM_GASTO_CONSOLIDA

                $AsientoIde = $DataSet_BIDM_GASTO_CONSOLIDA[0]->AsientoIde;
                $AsientoNumDocumento = $DataSet_BIDM_GASTO_CONSOLIDA[0]->AsientoNumDocumento;
                $AsientoAnio = $DataSet_BIDM_GASTO_CONSOLIDA[0]->AsientoAnio;
                $AsientoPeriodo = $DataSet_BIDM_GASTO_CONSOLIDA[0]->AsientoPeriodo;
                $CencoCodigo = $DataSet_BIDM_GASTO_CONSOLIDA[0]->CencoCodigo;
                $CencoNombre = $DataSet_BIDM_GASTO_CONSOLIDA[0]->CencoNombre;
                $ContratoOrden = $DataSet_BIDM_GASTO_CONSOLIDA[0]->ContratoOrden;
                $OrdenCodigo = $DataSet_BIDM_GASTO_CONSOLIDA[0]->OrdenCodigo;
                $ActorDocumento = $DataSet_BIDM_GASTO_CONSOLIDA[0]->ActorDocumento;
                $ActorNombre = $DataSet_BIDM_GASTO_CONSOLIDA[0]->ActorNombre;
                $ProyectoCodigo = $DataSet_BIDM_GASTO_CONSOLIDA[0]->ProyectoCodigo;
                $ProyectoNombreCorto = $DataSet_BIDM_GASTO_CONSOLIDA[0]->ProyectoNombreCorto;
                $ProyGrupoCodigo = $DataSet_BIDM_GASTO_CONSOLIDA[0]->ProyGrupoCodigo;
                $CtaCodigo = $DataSet_BIDM_GASTO_CONSOLIDA[0]->CtaCodigo;
                $CtaNomPartida = $DataSet_BIDM_GASTO_CONSOLIDA[0]->CtaNomPartida;
                $CtaNomClase = $DataSet_BIDM_GASTO_CONSOLIDA[0]->CtaNomClase;
                $CtaNombre = $DataSet_BIDM_GASTO_CONSOLIDA[0]->CtaNombre;
                $FuenteAbrev = $DataSet_BIDM_GASTO_CONSOLIDA[0]->FuenteAbrev;
                $AsientoMontoSoles = $DataSet_BIDM_GASTO_CONSOLIDA[0]->AsientoMontoSoles;
                $Fase = $DataSet_BIDM_GASTO_CONSOLIDA[0]->Fase;
                $Componente = $DataSet_BIDM_GASTO_CONSOLIDA[0]->Componente;
                $EST_BIDM_GASTO_CONSOLIDA = $DataSet_BIDM_GASTO_CONSOLIDA[0]->EST_BIDM_GASTO_CONSOLIDA;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('AsientoIde', $AsientoIde);
            $lCollection->Add('AsientoNumDocumento', $AsientoNumDocumento);
            $lCollection->Add('AsientoAnio', $AsientoAnio);
            $lCollection->Add('AsientoPeriodo', $AsientoPeriodo);
            $lCollection->Add('CencoCodigo', $CencoCodigo);
            $lCollection->Add('CencoNombre', $CencoNombre);
            $lCollection->Add('ContratoOrden', $ContratoOrden);
            $lCollection->Add('OrdenCodigo', $OrdenCodigo);
            $lCollection->Add('ActorDocumento', $ActorDocumento);
            $lCollection->Add('ActorNombre', $ActorNombre);
            $lCollection->Add('ProyectoCodigo', $ProyectoCodigo);
            $lCollection->Add('ProyectoNombreCorto', $ProyectoNombreCorto);
            $lCollection->Add('ProyGrupoCodigo', $ProyGrupoCodigo);
            $lCollection->Add('CtaCodigo', $CtaCodigo);
            $lCollection->Add('CtaNomPartida', $CtaNomPartida);
            $lCollection->Add('CtaNomClase', $CtaNomClase);
            $lCollection->Add('CtaNombre', $CtaNombre);
            $lCollection->Add('FuenteAbrev', $FuenteAbrev);
            $lCollection->Add('AsientoMontoSoles', $AsientoMontoSoles);
            $lCollection->Add('Fase', $Fase);
            $lCollection->Add('Componente', $Componente);
            $lCollection->Add('EST_BIDM_GASTO_CONSOLIDA', $EST_BIDM_GASTO_CONSOLIDA);

            /* EDGAR */ // DATOS DEL REGISTRO PADRE 
            //$Data11 = Comunidad_Datos($IDE_COMUNIDAD);
            //$Bdescripcion = $Data11['DES_COMUNIDAD'] ;
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
            $DataSet_BIDM_GASTO_CONSOLIDA = array();
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO = new BIDM_GASTO_CONSOLIDA_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($AsientoIde)) > 0) {
                $lstparametrosM['AsientoIde'] = $AsientoIde;
            }
            if (strlen(rtrim($AsientoNumDocumento)) > 0) {
                $lstparametrosM['AsientoNumDocumento'] = $AsientoNumDocumento;
            }
            if (strlen(rtrim($AsientoAnio)) > 0) {
                $lstparametrosM['AsientoAnio'] = $AsientoAnio;
            }
            if (strlen(rtrim($AsientoPeriodo)) > 0) {
                $lstparametrosM['AsientoPeriodo'] = $AsientoPeriodo;
            }
            if (strlen(rtrim($CencoCodigo)) > 0) {
                $lstparametrosM['CencoCodigo'] = $CencoCodigo;
            }
            if (strlen(rtrim($CencoNombre)) > 0) {
                $lstparametrosM['CencoNombre'] = $CencoNombre;
            }
            if (strlen(rtrim($ContratoOrden)) > 0) {
                $lstparametrosM['ContratoOrden'] = $ContratoOrden;
            }
            if (strlen(rtrim($OrdenCodigo)) > 0) {
                $lstparametrosM['OrdenCodigo'] = $OrdenCodigo;
            }
            if (strlen(rtrim($ActorDocumento)) > 0) {
                $lstparametrosM['ActorDocumento'] = $ActorDocumento;
            }
            if (strlen(rtrim($ActorNombre)) > 0) {
                $lstparametrosM['ActorNombre'] = $ActorNombre;
            }
            if (strlen(rtrim($ProyectoCodigo)) > 0) {
                $lstparametrosM['ProyectoCodigo'] = $ProyectoCodigo;
            }
            if (strlen(rtrim($ProyectoNombreCorto)) > 0) {
                $lstparametrosM['ProyectoNombreCorto'] = $ProyectoNombreCorto;
            }
            if (strlen(rtrim($ProyGrupoCodigo)) > 0) {
                $lstparametrosM['ProyGrupoCodigo'] = $ProyGrupoCodigo;
            }
            if (strlen(rtrim($CtaCodigo)) > 0) {
                $lstparametrosM['CtaCodigo'] = $CtaCodigo;
            }
            if (strlen(rtrim($CtaNomPartida)) > 0) {
                $lstparametrosM['CtaNomPartida'] = $CtaNomPartida;
            }
            if (strlen(rtrim($CtaNomClase)) > 0) {
                $lstparametrosM['CtaNomClase'] = $CtaNomClase;
            }
            if (strlen(rtrim($CtaNombre)) > 0) {
                $lstparametrosM['CtaNombre'] = $CtaNombre;
            }
            if (strlen(rtrim($FuenteAbrev)) > 0) {
                $lstparametrosM['FuenteAbrev'] = $FuenteAbrev;
            }
            if (strlen(rtrim($AsientoMontoSoles)) > 0) {
                $lstparametrosM['AsientoMontoSoles'] = $AsientoMontoSoles;
            }
            if (strlen(rtrim($Fase)) > 0) {
                $lstparametrosM['Fase'] = $Fase;
            }
            if (strlen(rtrim($Componente)) > 0) {
                $lstparametrosM['Componente'] = $Componente;
            }
            if (strlen(rtrim($EST_BIDM_GASTO_CONSOLIDA)) > 0) {
                $lstparametrosM['EST_BIDM_GASTO_CONSOLIDA'] = $EST_BIDM_GASTO_CONSOLIDA;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['AsientoIde'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['AsientoNumDocumento'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['AsientoAnio'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['AsientoPeriodo'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CencoCodigo'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CencoNombre'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['ContratoOrden'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['OrdenCodigo'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['ActorDocumento'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['ActorNombre'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['ProyectoCodigo'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['ProyectoNombreCorto'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['ProyGrupoCodigo'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CtaCodigo'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CtaNomPartida'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CtaNomClase'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['CtaNombre'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['FuenteAbrev'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['AsientoMontoSoles'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Fase'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Componente'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_BIDM_GASTO_CONSOLIDA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO->Update_BIDM_GASTO_CONSOLIDA($DataSet_BIDM_GASTO_CONSOLIDA, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[24][0];

            $mensaje = $procedure_parametrosMS[25][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_BIDM_GASTO_CONSOLIDA = array();
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO = new BIDM_GASTO_CONSOLIDA_DAO();
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
            $Objeto_BIDM_GASTO_CONSOLIDA_DAO->Delete_BIDM_GASTO_CONSOLIDA($DataSet_BIDM_GASTO_CONSOLIDA, $procedure_parametrosMS); //JCMY
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

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        $DataSet_GEN_TABLAS_1 = array();
        $Objeto_EST_BIDM_GASTO_CONSOLIDA_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = " AND COD_TABLA = 99";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_BIDM_GASTO_CONSOLIDA_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */

        /* 					 */




        /* EDGAR */
        $lCollection->Add('crud', crud($usuario, $PermisosPerfil, $Pedido, $SeleccionarID));
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;