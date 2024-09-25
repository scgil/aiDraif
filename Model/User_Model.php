<?php
class USUARIOS_Model {

	/**
	 * Nombre de usuario
	 */
	var $user;

	/**
	 * Contraseña del usuario
	 */
	var $pass;

	/**
	 * Email del usuario (PK en la BD)
	 */
	var $email;

	/**
	 * Conexión con la BD usada
	 */
	var $mysqli;


//Constructor de la clase
function __construct($user,$pass,$email){
        
	$this->user = $user;
	$this->pass = $pass;
	$this->email = $email;

	include_once '../Model/BDConector.php';
	$this->mysqli = BDConector::createConection();
}



//funcion de destrucción del objeto: se ejecuta automaticamente
//al finalizar el script
function __destruct()
{
	
}

/**
 * Comprueba si el usuario existe y la pass proporcionada es correcta
 * @return true | String
 */
	function login(){

		$sql = "SELECT *
				FROM USER
				WHERE (
					(email = '$this->email') 
				)";

		$resultado = $this->mysqli->query($sql);
		if ($resultado->num_rows == 0){
			return 'El usuario o contraseña es incorrecto';
		}
		else{
			$tupla = $resultado->fetch_array();
			if ($tupla['password'] == $this->pass){
				return true;
			}
			else{
				return 'El usuario o contraseña es incorrecto';
			}
		}
	}//Login end

	/**
	 * Comprueba que el usuario a añadir no exista y en dicho caso lo añade
	 */
	function register(){
		
		$checkSql = "SELECT *
				FROM USER
				WHERE 
					email = '$this->email'
				";

		$resultado = $this->mysqli->query($checkSql);
		if ($resultado->num_rows == 0){
		
			$sql = "INSERT INTO `USER` (
						`email`,
						`password`,
						`login`
			) VALUES(
				'".$this->email."',
				'".$this->pass."',
				'".$this->user."'
			)";

			if(!$this->mysqli->query($sql)){
				return "Error al registrar usuario";
			} else {

				return true;
			}

		}
	}//Register end

}//Class end

?>
