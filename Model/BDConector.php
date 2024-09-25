<?php
class BDConector{
		/**
		 * Conexión actual mysqli
		 */
		private $current_conection;

		/**
		 * Referencia a la conexión mysqli
		 * @param mysqli $conection 
		 * @return void
		 */
		private function __construct(){
		
			$this->current_conection = createConection();
		}

		/**
		 * @return void
		 */
		public function __destruct(){
			$this->current_conection->close();
		}

		/**
		 * Crea una nueva conexión con la base de datos y la devuelve en forma de instancia de la propia clase
		 * @return bool | mysqli 
		 */
		public static function createConection(){
			/**
			 * En caso de que las variables de entorno no estén definidas se toma el valor a su derecha
			 */
			/**
			 * Host de la base de datos
			 */
			if(!defined("HOST")){
				if(getenv("APP_BD_HOST") == false){
					define("HOST", "localhost");
				} else{
					define("HOST",getenv("APP_BD_HOST"));
				}
			}
			/**
			 * Usuario con el que conectarse
			 */
			if(!defined("USER")){
				if(getenv("APP_DB_USER") == false){
					define("USER", "tester");
				} else{
					define("USER", getenv("APP_DB_USER"));
				}
			}

			/**
			 * Contraseña con la que conectarse
			 */
			if(!defined("PASS")){
				if(getenv("APP_DB_PASS") == false){
					define("PASS", "tester");
				} else{
					define("PASS", getenv("APP_DB_PASS"));
				}
			}
			/**
			 * Nombre de la BD a usar
			 */
			if(!defined("BD")){
				if(getenv("APP_DB_NAME") == false){
					define("BD", "Aidraif");
				} else{
					define("BD", getenv("APP_DB_NAME"));
				}
			}
			/**
			 * Conexión con la base de datos en base a los parámetros dados
			 */
			$mysqli = new mysqli(HOST,USER,PASS,BD);

			/**
			 * En caso de error muestra información al respecto
			 */
			if($mysqli->connect_errno){
				    echo "Error: Fallo al conectarse a MySQL debido a: \n";
				    echo "Errno: " . $mysqli->connect_errno . "\n";
				    echo "Error: " . $mysqli->connect_error . "\n";
					return false;
			} else {
				return $mysqli;
			}
		}
	}

