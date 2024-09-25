<?php
class FILES_Model{

	/**
	 * 
	 */

	private $name;
	private $father;
	private $owner;
	private $mimeType;

	function __construct($oName,$father,$owner,$mimeType){
		
		$this->name = $oName;
		$this->father = $father;
		$this->owner = $owner;
		$this->mimeType = $mimeType;

             include_once '../Model/BDConector.php';
                $this->mysqli = BDConector::createConection();
        }

        function __destruct(){
        }

        function add($uuid){
	        $sql = "SELECT * FROM FILES WHERE uuid='$uuid'";

	        $resultado = $this->mysqli->query($sql);
	        if ($resultado == false || $resultado->num_rows > 0){
	                $mysqli->close();
	                return false;
	        } else{
                $stmt = $this->mysqli->prepare("INSERT INTO FILES (
                                        originalName,
                                        owner,
                                        father,
                                        mimeType,
                                        uuid) VALUES (
                                        ?,
                                        ?,
                                        ?,
                                        ?,
                                        ?)");
                $stmt->bind_param("sssss",$this->name,$this->owner,$this->father,$this->mimeType,$uuid);
                $resultado = $stmt->execute();
                if($resultado == false){
                        return $this->mysqli->error;
                } else{
                        return true;
                }
	        }
        }


	function delete($uuid,$owner){
		$sql = "DELETE FROM FILES WHERE uuid ='$uuid' AND owner = '$owner'";
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();
		$resultado = $mysqli->query($sql);
		$mysqli->close();
		if($resultado == false){
			return false;
		}elseif ($resultado->num_rows === 0){
			return "El fichero no existia";
		}else{
			return true;
		}
		
	}
	function edit($new_name,$uuid,$owner){

		$sql = "UPDATE FILES SET originalName = '$new_name' WHERE uuid = '$uuid' AND owner = '$owner'";
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();
		$resultado = $this->mysqli->query($sql);

		if($resultado == false){
			return false;
		}elseif ($resultado->num_rows == 0){
			return "El fichero no existia";
		}else{
			return true;
		}
	}
	
	/**
	 * @return true
	 */
	public static function isOwner($uuid,$owner){
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();
		$sql = "SELECT * FROM FILES WHERE owner = '$owner' AND uuid = '$uuid'";

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

	public static function listFiles($father){
	include_once '../Model/BDConector.php';
			$mysqli = BDConector::createConection();
		$sql1 = "SELECT * FROM FILES WHERE father = '$father';";
		$resultado = $mysqli->query($sql);

		if($resultado->num_rows === 0){

			return "Carpeta vacía";

		}elseif($resultado->num_rows > 0){

			return $resultado;

		}else{

			return "Error inesperado";
		}
	}

	public static function getSons($father,$owner){
		
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();
		$sql = "SELECT uuid,originalName,mimeType FROM FILES WHERE father = '$father' AND owner = '$owner'";


		$resultado = $mysqli->query($sql);
		$mysqli->close();
		if($resultado == false){
			return false;
		}
		elseif($resultado->num_rows === 0){

			return "Carpeta vacía";

		}elseif($resultado->num_rows > 0){

			return $resultado;

		}else{

			return "Error inesperado";
		}
	}

	public static function getShared($uuid){
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();
		$sql = "SELECT originalName FROM FILES WHERE uuid = '$uuid'";


		$resultado = $mysqli->query($sql);
		$mysqli->close();
		if($resultado == false){
			return false;
		}elseif($resultado->num_rows === 1){

			return $resultado;

		}else{

			return false;
		}
	}

	public static function isDownloable($uuid,$father){
		include_once '../Model/BDConector.php';
		$mysqli = BDConector::createConection();
		$sql = "SELECT * FROM FILES WHERE uuid = '$uuid' AND father='$father'";


		$resultado = $mysqli->query($sql);
		$mysqli->close();
		if($resultado == false){
			return false;
		}elseif($resultado->num_rows === 1){

			return true;

		}else{

			return false;
		}
	}
	
}

?>
