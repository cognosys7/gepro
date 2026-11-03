<?php
  /* * ******************************************************************************
  //  ==========================================
  //  Proyecto        : SGPAM
  //  Empresa         : www.cognosys.com.pe
  //  Autores         : Ing. Julio César Meza Yangali - mezayangali@gmail.com -
  //                    Ing. Edgar David Pisfil Ahumada 
  //  Propósito       : Configuración de parametros, para Envío de email de lutilizando vista AlertaContratoRiesgo
  //  Fecha           : lunes, 12 de agosto de 2019 11:30
  //  Modificado      : 01 de Setiembre 2019
  //
  //***************************************************************************** */

    ///////////////////// Definicion de Parametros /////////////////////
    //// tutorial:   https://www.youtube.com/watch?v=fV37_vWDzEU
    //// libreria:   https://github.com/PHPMailer/PHPMailer/tree/v5.2.11

    $Autentificacion= 'SSL';
    $HostEmail      = 'https://198.150.0.59/' ;
    $PuertoEmail    = 25 ;
    
    $EmisorEmail    = 'monitoreo.sgpam@amsac.pe' ;
    $EmisorAlias    = 'Monitoreo de Proyectos SGPAM - AMSAC' ;
    $EmisorClave    = 'Amsac..2020' ;
        
    $ReceptorEmail  = $ReceptorAlias = $EmailTitulo = $EmailMensaje = '';
    
    
//    require_once ("../../../Configuracion.php");
    define("RECURSOSGEN_LIB", "../../../../recursosAPP/lib/");
    define("PATH_DATA", "../../../Data");
    
    //// Driver
    define("DRIVER_MYSQL", "MySQL");
    define("DRIVER_MYSQLI", "MySQLi");
    define("DRIVER_SQLSERVER", "SQLServer");


    define("DB_DRIVER",   DRIVER_SQLSERVER);   
    define("DB_HOSTNAME", "CSVLSMOPROY01\MSSQLSERVER1"); //produccion
//    define("DB_HOSTNAME", "DESKTOP-494N0JN\EPISFIL");
    define("DB_DATABASE", "amsac");
    define("DB_USERNAME", "sa");
    define("DB_PASSWORD", ""); // clave retirada: se cargará desde fuera del sitio
//    define("DB_PASSWORD", ""); // clave retirada: se cargará desde fuera del sitio
    
    
    define("ROOT_PATH",                    str_replace("\\", "/", dirname(__file__)));
    define("PATH_LOG",                     ROOT_PATH ."/log");
    
    define("LOG_UNCAUGHT_EXCEPTIONS",!true);
    define("DISPLAY_UNCAUGHT_EXCEPTIONS",true);

?>

