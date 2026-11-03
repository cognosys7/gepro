<?php

/* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : GESTION.NET
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Edgar David Pisfil Ahumada
  //  Propósito       : RPT_INTERVENCIONESLN de la tabla RPT_INTERVENCIONES
  //  Fecha           : jueves, 22 de febrero de 2018 04:02:34 p.m.
  //  Desde el Modelo : PDM - AMSAC
  //  Modificado      : 16 de Octubre 2017
  //
  /***************************************************************************** */
require_once(PATH_CONTROLADOR_DAO . "/RPT_INTERVENCIONESDAO.php");
require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
//require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */

//require_once(PATH_CONTROLADOR_DAO . "/UsuarioDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_ENTIDADDAO.php");
require_once(PATH_CONTROLADOR_DAO . "/GEN_TABLASDAO.php");

function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "RPT_INTERVENCIONES";
    $PermisoOK = 0;
    $CargaAsignacion  = 0;
    

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
    $PermisoOK = VerificaAccesoMenu($Opcionsession, $perfilsession);


    if ($PermisoOK == 1){
        
        /*******************************************************************
         *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
        /*******************************************************************/
        //ACCIONES PARA EL FORMULARIO
        
        $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
        $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";

        

        /*******************************************************************
        *        METODO PARA INSERTAR UN REGISTRO 
        /*******************************************************************/     
        //if ($Action == "ImprimirReporte") {                       
		/* FIN DE ACTIVACION */                
		$DataSet_RPT_INTERVENCIONESM = array();
		$Objeto_RPT_INTERVENCIONES_DAO = new RPT_INTERVENCIONES_DAO();
		$lstparametrosM = array();		
		$lstparametrosM['Usuario'] = $usuario;
		$procedure_parametrosMS = array(
			 array(&$lstparametrosM['Usuario'], SQLSRV_PARAM_IN)			
		);
		$Objeto_RPT_INTERVENCIONES_DAO->Rpt_Formato1_RPT_INTERVENCIONES($DataSet_RPT_INTERVENCIONES, $procedure_parametrosMS);
                //$lCollection->Add('Reporte', $DataSet_RPT_INTERVENCIONES);
		$lCollection->Add('DataSet_RPT_INTERVENCIONES', $DataSet_RPT_INTERVENCIONES);                             
        //}
        
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
        $lCollection->Add('PermisoOK', $PermisoOK);        
        
    }
}

//var_dump($lstDepartamento);exit;
    