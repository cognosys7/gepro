	<?php
	//namespace JGA;
	class Conexion {

            static private $instance;

            public static function getConexion() {

                if(self::$instance == NULL){           
                    $serverName = "DESKTOP-U0A4LJ6\SQLSERVER2022";
            	      $PDOinstance = new PDO( "sqlsrv:server=$serverName ; Database=BDGEPRO", "sa", "" /* clave retirada */);  
			
                    $PDOinstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$instance = $PDOinstance;
                }
                return self::$instance;
            }
	}