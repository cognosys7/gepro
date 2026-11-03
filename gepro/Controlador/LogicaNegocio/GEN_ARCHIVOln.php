<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada
  //  Propósito       : GEN_ARCHIVOLN de la tabla GEN_ARCHIVO
  //  Fecha           : lunes, 3 de junio de 2019 22:00:44
  //  Desde el Modelo : PDM - AMSAC - AJUSTADO-J
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/GEN_ARCHIVODAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");



/* EDGAR */
require_once("include/LNinclude.php");
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "GEN_ARCHIVO";
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
        $Tabla = isset($_REQUEST['Tabla']) ? VerificarInputs($_REQUEST['Tabla']) : "";

        $Pedido = isset($_REQUEST['Pedido']) ? VerificarInputs($_REQUEST['Pedido']) : "";
        $PIDEbuscado = isset($_REQUEST['PIDEbuscado']) ? VerificarInputs($_REQUEST['PIDEbuscado']) : "";
        /* EDGAR */

        /*         * *****************************************************************
         *     RECUPERACION DE DATOS DEL FORMULARIO
          /****************************************************************** */
        $SeleccionarID = isset($_REQUEST['SeleccionarID']) ? VerificarInputs($_REQUEST['SeleccionarID']) : ""; //TOMA EL VALOR DEL ID
        $IDE_TABLA = isset($_REQUEST['IDE_TABLA']) ? VerificarInputs($_REQUEST['IDE_TABLA']) : "";
        $IDE_REGISTRO = isset($_REQUEST['IDE_REGISTRO']) ? VerificarInputs($_REQUEST['IDE_REGISTRO']) : "";
        $DES_RUTA = isset($_REQUEST['DES_RUTA']) ? VerificarInputs($_REQUEST['DES_RUTA']) : "";
        $DES_ARCHIVO = isset($_REQUEST['DES_ARCHIVO']) ? VerificarInputs($_REQUEST['DES_ARCHIVO']) : "";
        $EST_ARCHIVO = isset($_REQUEST['EST_ARCHIVO']) ? VerificarInputs($_REQUEST['EST_ARCHIVO']) : "";
        /* FLEXIGRID */
        //CONDICION EMPLEADO CUANDO LA TABLA DEPENDO DE OTRA SUPERIOR
        $ScriptFLX = ""; // AND P1.IdProveedor = $fIdProveedor ;            

        /* EDGAR */
        $TipoGrilla = 'SelGrd_GEN_ARCHIVO';

       if ( $PIDE>0 ){
             $ScriptFLX = $ScriptFLX." AND T.IDE_TABLA='".$Tabla."'"." AND T.IDE_REGISTRO=$PIDE";
//             $pAuxiliar = '';
//              
//             $IDE_SOLICITUD = $PIDE; /* añadido por julio meza */
       } 
//       else {
//             $ScriptFLX = $ScriptFLX." AND P.COD_TABLA=0 ";
//             $pAuxiliar = 'Anidado';
//             $lCollection->Add('VCOD_TABLA', '0' );
//       } 
//       $TipoGrilla = ($pAuxiliar=='Anidado' ? 'SelGrd_GEN_TABLAS_pAuxiliar' : 'SelGrd_GEN_TABLAS' ) ;
        if ($Pedido == 'Busqueda') {
            $TipoGrilla = 'SelGrd_GEN_ARCHIVO_busqueda';
        }
        
        //----------- RUTAS DE ARCHIVOS
        $VAlojamiento = '../../SGPAM_archivos/';
        $VRuta = $VTitulo = '';
        switch ($Tabla) {
            case 'CONT_DOCUMENTACION':
                $VRuta = $VAlojamiento."ContratoDocumentos/";
                $VTitulo = "Documentos del Contrato";
                break;
            case 'CONT_CALIDAD':
                $VRuta = $VAlojamiento."ContratoEntregables/";
                $VTitulo = "Entregables del Contrato";
                break;
            case 'CONTRATO':
                $VRuta = $VAlojamiento."Contrato/";
                $VTitulo = "Contrato";
                break;
            case 'CONTRATO_CONCEPTO':
                $VRuta = $VAlojamiento."ContratoConcepto/";
                $VTitulo = "Carta Fianzas del Contrato";
                break;
            case 'PROY_GESTION_ACTIVIDADES':
                $VRuta = $VAlojamiento."ProyectoGestionSocialActividades/";
                $VTitulo = "Actividades de la Gestión Social del Proyecto";
                break;
//            case 'PROY_COMP_SEGUIFOTO':
            case 'PROY_COMP_SEGUIMIENTO':
                $VRuta = $VAlojamiento."ContratoComponenteSeguimiento/";
                $VTitulo = "Seguimiento de la Etapa de Contrato del Proyecto";
                break;
            case 'PROY_CONT_COMP_CONTROL_DET':
                $VRuta = $VAlojamiento."ContratoControlDetalle/";
                $VTitulo = "Control Mensual del Contrato";
                break;
            case 'migrar_CONT_ETAPA_CONTROL':
                $VRuta = $VAlojamiento."etl_FichaTecnica/";
                $VTitulo = "Migrar Ficha Técnica del Contrato";
                break;
            case 'migrar_INTERESADOS':
                $VRuta = $VAlojamiento."etl_Interesados/";
                $VTitulo = "Migrar Interesados del Contrato Principal";
                break;
            case 'PROY_CONT_AMPLIACION':
                $VRuta = $VAlojamiento."ContratoAmpliacion/";
                $VTitulo = "Ampliación de Plazo del Contrato";
                break;
            case 'PROY_SEGUIMIENTO':
                $VRuta = $VAlojamiento."ProyectoSeguimiento/";
                $VTitulo = "Seguimiento del Proyecto";
                break;
			case 'PROY_GESTION_BENEFICIOS':
				$VRuta = $VAlojamiento."ProyectoComunidadBeneficios/";
				$VTitulo = "Beneficios de Comunidades";
				break;
        }

        $lCollection->Add('VRuta', $VRuta);
        $lCollection->Add('VTitulo', $VTitulo);
        /* EDGAR */

        /*         * *****************************************************************
         *     METODO LISTAR UN CONJUNTO DE REGISTRO EN EL FLEXIGRID
          /****************************************************************** */
        if ($ActionFlex == "LoadJsonList") {
            $lDataSet = array();
            $ogridDAO = new GEN_ARCHIVO_DAO();
            $Prueba = "ActionFlex";

            if ($_POST['query'] <> '%') {
                if (strlen(VerificarInputs($_POST['query'])) > 0) {


                    if ($_POST['qtype'] == 'IDE_TABLA') {
                        $_POST['qtype'] = 'T.IDE_TABLA';
                    }
                    if ($_POST['qtype'] == 'DES_ARCHIVO') {
                        $_POST['qtype'] = 'T.DES_ARCHIVO';
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
            $ogridDAO->Count_GEN_ARCHIVO($lDataSet, $procedure_parametrosP); //JCMY
            $nTotal = $lDataSet[0]->IDE_ARCHIVO;

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




        /*******************************************************************
         *        REGISTRAR IMAGENES 
        /****************************************************************** */
        
        if ($Action == "RegistraDatos" or $Action == "ActualizarForm") {            
            //CARGANDO ARCHIVO AL SERVIDOR
            $valorFile = "";
            $Archivo   = isset($_FILES['archivo']['name'])? $_FILES['archivo']['name'] : "";
            
            if(strlen($Archivo)>0){            
//                $Det_ext    = pathinfo($Archivo, PATHINFO_EXTENSION);
                $Archivo_nombre = $_FILES['archivo']['name'];
                $Buscar = array("á",'é','í','ó','ú','Á'," ", "  "); 
                $Reemplazo = array("a",'e','i','o','u','A',"_", "_",); 
                $valorFile  = date("dmY").'_'.date("His").'_'.str_replace($Buscar,$Reemplazo,$Archivo_nombre);
                
                copy($_FILES["archivo"]['tmp_name'],PATH_VISTA.'/'.$DES_RUTA.$valorFile);

                $DES_ARCHIVO = $valorFile ;
            }
            
        }
        
     

        /*         * *****************************************************************
         *        METODO PARA INSERTAR UN REGISTRO 
          /****************************************************************** */
        if ($Action == "RegistraDatos") {
            /* ACTIVAR PARA CONVERTIR LOS DATOS DE TIPO FECHA */

            /* FIN DE ACTIVACION */

            $DataSet_GEN_ARCHIVOM = array();
            $Objeto_GEN_ARCHIVO_DAO = new GEN_ARCHIVO_DAO();
            $lstparametrosM = array();
            if (strlen(rtrim($IDE_TABLA)) > 0) {
                $lstparametrosM['IDE_TABLA'] = $IDE_TABLA;
            }
            if (strlen(rtrim($IDE_REGISTRO)) > 0) {
                $lstparametrosM['IDE_REGISTRO'] = $IDE_REGISTRO;
            }
            if (strlen(rtrim($DES_RUTA)) > 0) {
                $lstparametrosM['DES_RUTA'] = $DES_RUTA;
            }
            if (strlen(rtrim($DES_ARCHIVO)) > 0) {
                $lstparametrosM['DES_ARCHIVO'] = $DES_ARCHIVO;
            }
            if (strlen(rtrim($EST_ARCHIVO)) > 0) {
                $lstparametrosM['EST_ARCHIVO'] = $EST_ARCHIVO;
            } $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['IDE_TABLA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['IDE_REGISTRO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_RUTA'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['DES_ARCHIVO'], SQLSRV_PARAM_IN),
                array(&$lstparametrosM['EST_ARCHIVO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ARCHIVO_DAO->Insert_GEN_ARCHIVO($DataSet_GEN_ARCHIVO, $procedure_parametrosMS); //JCMY

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
            $DataSet_GEN_ARCHIVO = array();
            $Objeto_GEN_ARCHIVO_DAO = new GEN_ARCHIVO_DAO();
            $lstparametrosM = array();
            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
            );
            $Objeto_GEN_ARCHIVO_DAO->SelPk_GEN_ARCHIVO($DataSet_GEN_ARCHIVO, $procedure_parametrosMS); // JCMY
            //var_dump($procedure_parametrosMS);
            $listaContador = count($DataSet_GEN_ARCHIVO) > 0 ? true : false; //JCMY
            //var_dump($listaContador);exit;
            if (($listaContador == true) || ($listaContador > 0)) {
                //Recuperando Valores del arreglo $DataSet_GEN_ARCHIVO

                $IDE_TABLA = $DataSet_GEN_ARCHIVO[0]->IDE_TABLA;
                $IDE_REGISTRO = $DataSet_GEN_ARCHIVO[0]->IDE_REGISTRO;
                $DES_RUTA = $DataSet_GEN_ARCHIVO[0]->DES_RUTA;
                $DES_ARCHIVO = $DataSet_GEN_ARCHIVO[0]->DES_ARCHIVO;
                $EST_ARCHIVO = $DataSet_GEN_ARCHIVO[0]->EST_ARCHIVO;
            }
            $lCollection->Add('SeleccionarID', $SeleccionarID);
            $lCollection->Add('IDE_TABLA', $IDE_TABLA);
            $lCollection->Add('IDE_REGISTRO', $IDE_REGISTRO);
            $lCollection->Add('DES_RUTA', $DES_RUTA);
            $lCollection->Add('DES_ARCHIVO', $DES_ARCHIVO);
            $lCollection->Add('EST_ARCHIVO', $EST_ARCHIVO);

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
            $DataSet_GEN_ARCHIVO = array();
            $Objeto_GEN_ARCHIVO_DAO = new GEN_ARCHIVO_DAO();

            $lstparametrosM['SeleccionarID'] = $SeleccionarID;
            if (strlen(rtrim($IDE_TABLA)) > 0) {
                $lstparametrosM['IDE_TABLA'] = $IDE_TABLA;
            }
            if (strlen(rtrim($IDE_REGISTRO)) > 0) {
                $lstparametrosM['IDE_REGISTRO'] = $IDE_REGISTRO;
            }
            if (strlen(rtrim($DES_RUTA)) > 0) {
                $lstparametrosM['DES_RUTA'] = $DES_RUTA;
            }
            if (strlen(rtrim($DES_ARCHIVO)) > 0) {
                $lstparametrosM['DES_ARCHIVO'] = $DES_ARCHIVO;
            }
            if (strlen(rtrim($EST_ARCHIVO)) > 0) {
                $lstparametrosM['EST_ARCHIVO'] = $EST_ARCHIVO;
            }
            $lstparametrosM['Usuario'] = $usuario;
            $lstparametrosM['PCODIGO'] = str_repeat("0", 100);
            $lstparametrosM['PMENSAJE'] = str_repeat("0", 200);

            $procedure_parametrosMS = array(
                array(&$lstparametrosM['SeleccionarID'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_TABLA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['IDE_REGISTRO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_RUTA'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['DES_ARCHIVO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['EST_ARCHIVO'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)
                , array(&$lstparametrosM['PCODIGO'], SQLSRV_PARAM_OUT)
                , array(&$lstparametrosM['PMENSAJE'], SQLSRV_PARAM_OUT)
            );
            $Objeto_GEN_ARCHIVO_DAO->Update_GEN_ARCHIVO($DataSet_GEN_ARCHIVO, $procedure_parametrosMS);   //JCMY

            $CodMensaje = $procedure_parametrosMS[7][0];

            $mensaje = $procedure_parametrosMS[8][0];

            $lCollection->Add('CodMensaje', $CodMensaje);
            $lCollection->Add('Mensaje', $mensaje);
        }

        /*         * *****************************************************************
         *          METODO ELIMINAR REGISTRO     
          /****************************************************************** */
        if ($Action == "EliminaRegistro") {
            $DataSet_GEN_ARCHIVO = array();
            $Objeto_GEN_ARCHIVO_DAO = new GEN_ARCHIVO_DAO();
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
            $Objeto_GEN_ARCHIVO_DAO->Delete_GEN_ARCHIVO($DataSet_GEN_ARCHIVO, $procedure_parametrosMS); //JCMY
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
        $Objeto_EST_ARCHIVO_DAO = new GEN_TABLAS_DAO();
        $lstparametrosM = array();
        $lstparametrosM['campos'] = "COD_ITEM,DES_ITEM";
        $lstparametrosM['filtro'] = "AND COD_TABLA='94'";

        $procedure_parametrosMS = array(
            array(&$lstparametrosM['campos'], SQLSRV_PARAM_IN)
            , array(&$lstparametrosM['filtro'], SQLSRV_PARAM_IN)
        );

        $Objeto_EST_ARCHIVO_DAO->SelCampos_GEN_TABLAS($DataSet_GEN_TABLAS_1, $procedure_parametrosMS);
        $lCollection->Add('DataSet_GEN_TABLAS_1', $DataSet_GEN_TABLAS_1);

        /* 					 */



        /* EDGAR */
        $lCollection->Add('PIDE', $PIDE);
        
        $lCollection->Add('Tabla', $Tabla);
        $lCollection->Add('Pedido', $Pedido);
        $lCollection->Add('PIDEbuscado', $PIDEbuscado);
        //$lCollection->Add('pAuxiliar', $pAuxiliar);
        $lCollection->Add('crudGrabarCancelar', crudGrabarCancelar($SeleccionarID,$usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudEliminar', crudEliminar($usuario,$PermisosPerfil) ) ;
        $lCollection->Add('crudArchivoDescargar', crudArchivoDescargar($usuario,$PermisosPerfil) ) ;
        /* EDGAR */
    }
}

//var_dump($lstDepartamento);exit;