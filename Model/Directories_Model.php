<?php
class DIRECTORIES_Model{

	var $name;
	var $owner;
	var $father;
	var $uuid;

	function __construct($name,$owner,$father){
		$this->name = $name;
		$this->owner = $owner;
		$this->father = $father;
	}

	function add($uuid){
		$sql = "SELECT * FROM DIRECTORY WHERE uuid='$uuid' AND father IS NOT NULL";

		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$resultado = $mysqli->query($sql);
		if ($resultado == false || $resultado->num_rows > 0){
			$mysqli->close();
			return false;
		} else{
			$stmt = $mysqli->prepare("INSERT INTO DIRECTORY (
						name,
						owner,
						father,
						uuid) VALUES (
						?,
						?,
						?,
						?)");
			$stmt->bind_param("ssss",$this->name,$this->owner,$this->father,$uuid);
			$resultado = $stmt->execute();
			if($resultado == false){
				return $mysqli->error;
			} else{
				return true;
			}
		
		}
	}

	function addParent($uuid){

		$sql = "SELECT * FROM DIRECTORY WHERE owner = '$this->owner' AND father IS NULL";

		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$resultado = $mysqli->query($sql);
		if ($resultado == false || $resultado->num_rows > 0){
			$mysqli->close();
			return false;
		} else{
			$stmt = $mysqli->prepare("INSERT INTO DIRECTORY (
						name,
						owner,
						father,
						uuid) VALUES (
						?,
						?,
						NULL,
						?)");
			$stmt->bind_param("sss",$this->name,$this->owner,$uuid);
			$resultado = $stmt->execute();
			if($resultado == false){
				return false;
			} else{
				return true;
			}
		
		}
	}

	public static function delete($uuid,$owner){  

		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$sql = "DELETE FROM DIRECTORY WHERE `uuid` = '$uuid' AND owner = '$owner'";
		$resultado = $mysqli->query($sql);
		$mysqli->close();

		if($resultado->num_rows === 0 || $resultado === false ){
			
			return false;

		}else{

		    return true;
		}
	}

	public static function edit($uuid,$new_name,$owner){

		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$sql = "SELECT * FROM `DIRECTORY` WHERE `uuid` = '$uuid' AND owner = '$owner'";
		$resultado = $mysqli->query($sql);

		if($resultado->num_rows === 0 || $resultado === false){
			$mysqli->close();
			return false;

		}else{
		
			 $sql1 = "UPDATE `DIRECTORY` SET name='$new_name' WHERE `uuid` = '$uuid' AND owner = '$owner'";
			 $resultado = $mysqli->query($sql1);
			 $mysqli->close();
			 if($resultado->num_rows === 1){
			 	
			 	return true;

			 }else{

			 	return false;
			 }
		}
	}

	public static function findMain($owner){
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$sql = "SELECT uuid FROM DIRECTORY WHERE owner = '".$owner."' AND father IS NULL";
		$resultado = $mysqli->query($sql);
		$mysqli->close();

		if($resultado->num_rows === 0){

			return false;

		}elseif($resultado->num_rows === 1){

			return mysqli_fetch_object($resultado)->uuid;

		}else{

			return "error";
		}
	}

	public static function isOwner($uuid,$owner){

		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$sql = "SELECT * FROM `DIRECTORY` WHERE (`owner` = '$owner' && `uuid` = '$uuid')";

		$resultado = $mysqli->query($sql);
		$mysqli->close();
		if($resultado->num_rows === 0){

			return false;

		}elseif($resultado->num_rows === 1){

			return true;

		}else{

			return false;
		}
	}

	public static function getSons($father,$owner){
		
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$sql = "SELECT uuid,name FROM DIRECTORY WHERE father = '$father' AND owner = '$owner'";

		$resultado = $mysqli->query($sql);
		$mysqli->close();
		if($resultado == false || $resultado->num_rows === 0){
			
			return false;

		}elseif($resultado->num_rows > 0){

			return $resultado;

		}else{

			return "Error inesperado";
		}
	}

	public static function vacia($uuid){
		
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$sql1 = "SELECT * FROM DIRECTORY WHERE father = '$uuid'";
		$sql2 = "SELECT * FROM FILES WHERE father = '$uuid'";
		$resultado1 = $mysqli->query($sql1);
		$resultado2 = $mysqli->query($sql2);
		$mysqli->close();
		if($resultado1->num_rows == 0 && $resultado2->num_rows == 0){
			return true;
		}elseif($resultado1 == false || $resultado2==false) {
			return $mysqli->error;
		}else{
			return false;
		}
	}

	public static function getFather($uuid,$owner){

		$sql = "SELECT father FROM DIRECTORY WHERE uuid = '$uuid' AND owner ='$owner'";
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();

		$respuesta = $mysqli->query($sql);
		$mysqli->close();
		if($respuesta== false){
			return false;
		}else{
			return mysqli_fetch_object($respuesta)->father;
		}
	}
}
?>
