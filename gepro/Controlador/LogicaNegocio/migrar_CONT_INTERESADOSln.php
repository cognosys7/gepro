<?php

require_once(RECURSOSGEN_LIB . "/Fechas.php");
require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');
require_once(RECURSOSGEN_LIB . "/Flexigrid.php");
/* AGREGAR REFERENCIAS DE LA CLASES DE LAS TABLAS AUXILIZARES */


/* EDGAR */
//require_once("include/LNinclude.php");
//require_once("include/GEN_ARCHIVOlni.php");
require_once(PATH_CONTROLADOR_LN . "/include/LNinclude.php");
require_once(PATH_CONTROLADOR_LN . "/include/GEN_ARCHIVOlni.php");

//// busqueda lni
/* EDGAR */


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "migrar_CONT_INTERESADOS";
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
        $PIDE = isset($_REQUEST['PIDE']) ? VerificarInputs($_REQUEST['PIDE']) : ""; //echo 'PIDE:'. $PIDE.'<br>' ;
        $lCollection->Add('PIDE', $PIDE);
        
        $Tabla = isset($_REQUEST['Tabla']) ? VerificarInputs($_REQUEST['Tabla']) : ""; //echo 'Tabla:'. $Tabla.'<br>' ;
        $lCollection->Add('Tabla', $Tabla); 
//        exit;
        
        
        
        $Data00 = Archivo_Datos ( $PIDE , $Tabla , 'max' );
        $BDES_ARCHIVO = $Data00['DES_ARCHIVO'];
        $BDES_RUTA = $Data00['DES_RUTA'];
        $BFEC_CARGA = $Data00['FEC_CARGA'];
        $BFEC_CARGA_fecha = $Data00['FEC_CARGA_fecha'];
        $BFEC_CARGA_hora = $Data00['FEC_CARGA_hora'];
        $lCollection->Add('BDES_ARCHIVO', $BDES_ARCHIVO );
        $lCollection->Add('BDES_RUTA', $BDES_RUTA );
        $lCollection->Add('BFEC_CARGA', $BFEC_CARGA ); 
        $lCollection->Add('BFEC_CARGA_fecha', $BFEC_CARGA_fecha );  
        $lCollection->Add('BFEC_CARGA_hora', $BFEC_CARGA_hora );       

    }
}

//var_dump($lstDepartamento);exit;