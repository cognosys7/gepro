<?php
/********************************************************************************
//  ==========================================
//  Proyecto        : GESTION.NET
//  Empresa         : www.cognosys.com.pe
//  Autores         : Edgar David Pisfil Ahumada                    
//  Propósito       : PROY_COMP_SEG_IMAGENLN de la tabla PROY_COMP_SEG_IMAGEN
//  Fecha           : martes, 22 de mayo de 2018 12:30:01
//  Desde el Modelo : PDM - AMSAC
//
/******************************************************************************/
    require_once(PATH_CONTROLADOR_DAO . "/PROY_COMP_SEGUIMIENTODAO.php");
    require_once(RECURSOSGEN_LIB . "/Fechas.php");
    require_once(RECURSOSGEN_LIB . "/Collection.php");
    require_once(RECURSOSGEN_LIB . "/util.php");
    require_once(PATH_LIB . '/util.php');    
    require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
    /*AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES*/    
    function EjecutaLN()
    {
        ValidaSession();
        $lCollection = Collection::Singleton();

        //VARIABLES GENERALES PARA EL SISTEMA
        $PaginaFormulario = "PROY_COMP_SEGUIMIENTO_CARRUSEL";
        $PermisoOK        = 0;

        //OBTENGOS LOS POST ANTIREFRESH
        if (!empty($_POST['Mensaje'])) { $mensaje = $_POST['Mensaje']; } else { $mensaje = 0;}

        //OBTENGO LAS SESIONES
        if (!empty($_SESSION['usuario'])) { $usuario = $_SESSION['usuario'];} else { $usuario = 0;}
        if (!empty($_SESSION['CodPerfil'])) { $perfilsession = $_SESSION['CodPerfil'];} else { $perfilsession = 0;}
        if (!empty($_SESSION['personal'])) { $personal = $_SESSION['personal'];} else { $personal = 0;}
        if (!empty($_SESSION['Oc'])) { $Opcionsession = $_SESSION['Oc'];} else { $Opcionsession = 0;}	
        $PermisosPerfil = CallNomPerfil($perfilsession);
        $PermisoOK = VerificaAccesoMenu($Opcionsession,$perfilsession);

        if ($PermisoOK == 1)       {
            /*******************************************************************
             *     RECUPERACION DE ACCIONES SOBRE LOS FORMULARIOS 
            /*******************************************************************/             
            //ACCIONES PARA EL FORMULARIO
            $Action = isset($_REQUEST['ActionForm']) ? VerificarInputs($_REQUEST['ActionForm']) : "";
            $ActionFlex = isset($_REQUEST['Accion']) ? VerificarInputs($_REQUEST['Accion']) : "";
            $PIDE_PROYECTO_ACTIVIDAD = isset($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) ? VerificarInputs($_REQUEST['PIDE_PROYECTO_ACTIVIDAD']) : "";

            /*******************************************************************
             *  METODO PARA RECUPERAR LAS IMAGENES DEL PROYECTO
            /*******************************************************************/             
            $DataSet_PROY_COMP_SEG_IMAGEN        = array();  
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO = new PROY_COMP_SEGUIMIENTO_DAO();
            $lstparametrosM     = array();
            $lstparametrosM['PIDE_PROYECTO_ACTIVIDAD']  = $PIDE_PROYECTO_ACTIVIDAD;
            $procedure_parametrosMS = array(
                  array(&$lstparametrosM['PIDE_PROYECTO_ACTIVIDAD'], SQLSRV_PARAM_IN)
            );
            $Objeto_PROY_COMP_SEGUIMIENTO_DAO->Carrusel_PROY_COMP_SEGUIMIENTO($DataSet_PROY_COMP_SEG_IMAGEN, $procedure_parametrosMS);
            $lCollection->Add('DataSet_PROY_COMP_SEG_IMAGEN', $DataSet_PROY_COMP_SEG_IMAGEN);            
        }
        $lCollection->Add('PaginaFormulario', $PaginaFormulario);
        $lCollection->Add('Mensaje', $mensaje);
        $lCollection->Add('PermisoOK', $PermisoOK);
        
    }    
    