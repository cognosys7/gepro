<?php
ini_set("session.cookie_lifetime","0");
ini_set("session.gc_maxlifetime","0");
session_start();

date_default_timezone_set('America/Lima');

define("GENERATE_LOG", false);

//PRODUCCION
 /*
define("DB_SQLSERVER_HOSTNAME", "DESKTOP-U0A4LJ6\SQLSERVER2022");
define("DB_SQLSERVER_DATABASE", "BDGEPRO"); 
define("DB_SQLSERVER_USERNAME", "sa");
define("DB_SQLSERVER_PASSWORD", ""); // clave retirada: se cargará desde fuera del sitio
*/
define("DB_SQLSERVER_HOSTNAME", "DESKTOP-U0A4LJ6\SQLSERVER2022");
define("DB_SQLSERVER_DATABASE", "BDGEPRO_ESSALUD"); 
define("DB_SQLSERVER_USERNAME", "sa");
define("DB_SQLSERVER_PASSWORD", ""); // clave retirada: se cargará desde fuera del sitio

// Driver
define("DRIVER_MYSQL", "MySQL");
define("DRIVER_MYSQLI", "MySQLi");
define("DRIVER_SQLSERVER", "SQLServer");
define("DRIVER_ODBC", "ODBC");

// Configurar the driver a usar
define("DRIVER_TO_USE", DRIVER_SQLSERVER);

switch(DRIVER_TO_USE) {
    case DRIVER_MYSQL:
        define("DB_HOSTNAME", DB_MYSQL_HOSTNAME);
        define("DB_DATABASE", DB_MYSQL_DATABASE);
        define("DB_USERNAME", DB_MYSQL_USERNAME);
        define("DB_PASSWORD", DB_MYSQL_PASSWORD);
        define("DB_DRIVER",   DRIVER_MYSQL);
        break;
    case DRIVER_MYSQLI:
        define("DB_HOSTNAME", DB_MYSQL_HOSTNAME);
        define("DB_DATABASE", DB_MYSQL_DATABASE);
        define("DB_USERNAME", DB_MYSQL_USERNAME);
        define("DB_PASSWORD", DB_MYSQL_PASSWORD);
        define("DB_DRIVER",   DRIVER_MYSQLI);
        break;
    case DRIVER_SQLSERVER:
        define("DB_HOSTNAME", DB_SQLSERVER_HOSTNAME);
        define("DB_DATABASE", DB_SQLSERVER_DATABASE);
        define("DB_USERNAME", DB_SQLSERVER_USERNAME);
        define("DB_PASSWORD", DB_SQLSERVER_PASSWORD);
        define("DB_DRIVER",   DRIVER_SQLSERVER);
        break;
    case DRIVER_ODBC:
        define("DB_HOSTNAME", DB_ODBC_HOSTNAME);
        define("DB_DATABASE", DB_ODBC_DATABASE);
        define("DB_USERNAME", DB_ODBC_USERNAME);
        define("DB_PASSWORD", DB_ODBC_PASSWORD);
        define("DB_DRIVER",   DRIVER_ODBC);
        break;

    default:
        define("DB_HOSTNAME", DB_MYSQL_HOSTNAME);
        define("DB_DATABASE", DB_MYSQL_DATABASE);
        define("DB_USERNAME", DB_MYSQL_USERNAME);
        define("DB_PASSWORD", DB_MYSQL_PASSWORD);
        define("DB_DRIVER",   DRIVER_MYSQL);
}

//Rutas
define("ROOT_PATH",                    str_replace("\\", "/", dirname(__file__)));
define('RAIZWEB',			$_SERVER['DOCUMENT_ROOT']);
define("INTRANET",                     "/gepro/intranet");
define("INTRAAPP",                     "/gepro/intrapronied/Vista/");
define("RECURSOSPROY",                 "/gepro/intranet/Recursos/");
/*LLAMO A PARAMETROS DE RECURSOS GENERALES*/
define("RECURSOSGEN",                  "/gepro/recursosAPP/");
define("RECURSOSGEN_RECURSOS",         RECURSOSGEN."/recursos/");
define("RECURSOSGEN_LIB",              RAIZWEB.RECURSOSGEN."/lib/");
define("SEG_CONTROLADOR_DAO",          RAIZWEB.RECURSOSGEN ."/Controlador/DAO");
define("SEG_CONTROLADOR_LN",           RAIZWEB.RECURSOSGEN ."/Controlador/LogicaNegocio");
define("SEG_VISTA",                    RAIZWEB.RECURSOSGEN ."/Vista");
define("SEG_MODELO",                   RAIZWEB.RECURSOSGEN ."/Modelo");
define("SEG_DATA",                     RAIZWEB.RECURSOSGEN ."/Data");
/*FIN DE RECURSOS GENERALES*/
define("PATH_DATA",                    ROOT_PATH ."/Data");
define("PATH_MODELO",                  ROOT_PATH ."/Modelo");
define("PATH_VISTA",                   ROOT_PATH ."/Vista");
define("PATH_CONTROLADOR",             ROOT_PATH ."/Controlador");
define("PATH_CONTROLADOR_LN",          PATH_CONTROLADOR ."/LogicaNegocio");
define("PATH_CONTROLADOR_DAO",         PATH_CONTROLADOR ."/DAO");
define("PATH_LIB",                     ROOT_PATH ."/lib");
define("PATH_LOG",                     ROOT_PATH ."/log");
define("PATH_LIB_PHPEXCEL",            PATH_LIB ."/PHPExcel");
define("INTRAAPP_FILES",                "/recursosAPP/ArchivosIntranet");
define("HTML_PATH_IMAGES",             "../recursos/images");

define("NOMBRESISTEMA",                "INTRANET GEPRO");
define("COPYRIGHT",                    "INTRANET GEPRO");
define("TELEFDIRECTO",                 "");
define("PRONIED",                      "::: GEPRO :::");
define("PIE",                          "Copyright 2023 (C) - GEPRO :: COGNOSYS");

//A PHPExcel
set_include_path(PATH_LIB_PHPEXCEL.'/');

// Manejo de Excepciones
//Registra en archivo log los errores
define("LOG_ERROR_EXCEPTIONS",!true);
//Muestra los errores en pantalla
define("DISPLAY_ERROR_EXCEPTIONS",true);

define("LOG_FATAL_EXCEPTIONS",!true);
define("DISPLAY_FATAL_EXCEPTIONS",true);

define("LOG_UNCAUGHT_EXCEPTIONS",!true);
define("DISPLAY_UNCAUGHT_EXCEPTIONS",true);

define("DB_ERROR_CONNECT", '¡Sin Conexión!');

define("DB_ERROR_UPDATE", "Error Inesperado de actualización. Por favor intentelo nuevamente más tarde.");
define("DB_ERROR_INSERT", "Error Inesperado de inserción. Por favor intentelo nuevamente más tarde.");
define("DB_ERROR_DELETE", "Error Inesperado de eliminación. Por favor intentelo nuevamente más tarde.");

define('ANIO','"Año del Buen Servicio al Ciudadano"');
define('DECENIO','"Decenio de las Personas con Discapacidad en el Perú 2007 - 2016"')
?>
