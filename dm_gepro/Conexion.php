<?php
	//namespace JGA;
	require_once(dirname(__DIR__) . '/config/cargar_config.php');

	class Conexion {

		static private $instance;

		public static function getConexion() {

			if(self::$instance == NULL){
				$lDB = gepro_config()['db'];

				$PDOinstance = new PDO( "sqlsrv:server={$lDB['host']} ; Database={$lDB['database']};TrustServerCertificate=1", $lDB['user'], $lDB['password']);

				$PDOinstance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$instance = $PDOinstance;
			}
			return self::$instance;
		}
	}
