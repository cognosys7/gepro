
<?php

/********************************************************************************
//  ==========================================
//  Proyecto        : SISTEMA DE GESTION DE PROYECTOS
//  Empresa	    : ACTIVOS MINEROS S.A.C.
//  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
//                    Ing. Edgar David Pisfil Ahumada                     
//  Propósito       : LN de elección de archivo para migrar a la tabla PROY_CONT_ETAPA_CONTROL y PROY_CONT_COMP_CONTROL_DET
//  Fecha           : martes, 25 de mayo de 2021 14:16:08
//  Desde el Modelo : PDM - Modelo Físico de Datos - SGPAM
//  Modificado      : martes, 25 de mayo de 2021 14:16:08
//******************************************************************************/

require_once(RECURSOSGEN_LIB . "/Collection.php");
require_once(RECURSOSGEN_LIB . "/util.php");
require_once(PATH_LIB . '/util.php');


require_once("include/GEN_ARCHIVOlni.php");


function EjecutaLN() {
    ValidaSession();
    $lCollection = Collection::Singleton();

    //VARIABLES GENERALES PARA EL SISTEMA
    $PaginaFormulario = "migrar_CONT_ETAPA_CONTROL";
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
        $lCollection->Add('PIDE', $PIDE);
        
        $Tabla = isset($_REQUEST['Tabla']) ? VerificarInputs($_REQUEST['Tabla']) : "";
        $lCollection->Add('Tabla', $Tabla);
        
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
 
 