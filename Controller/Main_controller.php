<?php

/**
 * Controllador que se encargará de listar las diferentes carpetas y/o ficheros de el usuario que haya iniciado sesión. Por ahora es un esqueleto.
 */
session_start();
if(!isset ($_SESSION['email']) && isset($_GET['file']) && isset($_GET['action'])){
	$_SESSION['email']="temp-shared";
}
if(!isset($_SESSION['email'])){
	header('Location:/Controller/Login_controller.php',true,301);
}
if(!isset($_GET['action'])){
	$_GET['action'] = "list";
}

	Switch($_GET['action']){

		case "list":
				include_once ('../Model/Files_Model.php'); 
				include_once ('../Model/Directories_Model.php');
				$ficheros = FILES_Model::getSons($_SESSION['currentDir'],$_SESSION['email']);
				$dirs = DIRECTORIES_Model::getSons($_SESSION['currentDir'],$_SESSION['email']);

				include_once ('../Vistas/templates/main.php');
				new Main($ficheros, $dirs);

				break;

		case "addDir":

				crearCarpeta();
				header('Location:/Controller/Main_controller.php?action=list');
				break;

		case "deleteItem":
				if($_POST['type'] == "dir"){
					eliminarCarpeta($_POST['uuid']);
				}else{
					borrarFichero($_POST['uuid']);
				}
				header('Location:/Controller/Main_controller.php?action=list');
				break;

		case "editItem":
				
				editarCarpeta($_POST['uuid']);
				header('Location:/Controller/Main_controller.php?action=list');
				break;

		case "download":
				descargarFichero();
				header('Location:/Controller/Main_controller.php?action=list');
				break;

		case "upload":
				include_once '../Functions/uuidGenerator.php';
				if(subirFichero(uuidGenerator($_SESSION['email'])) == false){
					include_once '../Vistas/templates/error.php';
					new CustomError("ERRORUPLOADING");
				}else{
					header('Location:/Controller/Main_controller.php?action=list');
				}
				
				break;

		case "nextDir":
				include_once ('../Model/Directories_Model.php');
				if(DIRECTORIES_Model::isOwner($_POST['nextDir'],$_SESSION['email'])){
					$_SESSION['currentDir'] = $_POST['nextDir'];
					$_SESSION['top']=false;

				}else{
					include_once '../Vistas/templates/error.php';
					new CustomError("NOTALLOWED");
				}
				header("Location:/Controller/Main_controller.php?action=list");
				break;
		case "goParent":
				include_once ('../Model/Directories_Model.php');
				$father = DIRECTORIES_Model::getFather($_SESSION['currentDir'],$_SESSION['email']);
				if($father === NULL){
					include_once '../Vistas/templates/error.php';
					new CustomError("ONTOP");
				}elseif(DIRECTORIES_Model::getFather($father,$_SESSION['email']) === NULL){
					$_SESSION['currentDir'] = $father;
					$_SESSION['top']=true;
				}else{
					$_SESSION['currentDir'] = $father;
				}

				header("Location:/Controller/Main_controller.php?action=list");
				break;

		case "sharedFile":
				shared($_GET['file']);
				break;

		default:
				header("Location:/Controller/Main_controller.php?action=list");
				break;

	}


/**
 * Función que crea una carpeta para el usuario.
 */
function crearCarpeta(){
		include_once ('../Model/Directories_Model.php');
		include_once '../Functions/uuidGenerator.php';

		$uuid = uuidGenerator($_SESSION['email']);
		$dir = new DIRECTORIES_Model($_POST['dirName'],$_SESSION['email'],$_SESSION['currentDir']);

		while( ($dir->add( $uuid )) === false ){
			$uuid = uuidGenerator($_SESSION['email']);
		}
}


/**
 * Función para eliminar una carpeta y todo lo que contenga dentro de un usuario.
 */

function eliminarCarpeta($selectedId){
	include_once ('../Model/Directories_Model.php');

	if(DIRECTORIES_Model::vacia($selectedId)){
		DIRECTORIES_Model::delete($selectedId,$_SESSION['email']);
	} else {

		include_once ('../Model/Files_Model.php');
		$ficheroshijos =FILES_Model::getSons($selectedId, $_SESSION['email'] );
		while($hijo=mysqli_fetch_object($ficheroshijos)){
			$hijoid = $hijo->uuid;
			borrarFichero($hijoid);
		}

		$directoriosHijos =DIRECTORIES_Model::getSons($selectedId, $_SESSION['email'] );
		while($hijo=mysqli_fetch_object($directoriosHijos)){
			$hijoid = $hijo->uuid;
			if(DIRECTORIES_Model::vacia($hijoid)){
				DIRECTORIES_Model::delete($hijoid,$_SESSION['email']);
			}else{
				eliminarCarpeta($hijoid);
			}
		}

		if(DIRECTORIES_Model::vacia($selectedId)){
			DIRECTORIES_Model::delete($selectedId,$_SESSION['email']);
		} 	
	}
}


/**
 * Función para editar una carpeta de un usuario, cambiar su nombre.
 */

function editarCarpeta($selectedId){
	include_once ('../Model/Directories_Model.php');
	$respuesta = DIRECTORIES_Model::edit($selectedId,$_POST['item_name'],$_SESSION['email']);
	if($respuesta == false){
		include_once '../Vistas/templates/error.php';
		new CustomError("COULDNTEDITFOLDER");
	}

}


 

/**
 * Función para subir un fichero, primero se intenta subir al directorio, si resulta exitoso, se intenta en la base de datos.
 */

  function subirFichero($uuid)
{

  	include_once '../Model/Files_Model.php';
  	include_once '../Model/Directories_Model.php';


	 /**
	  * Ruta absoluta del directorio para guardar ficheros
	  */

	 $dir = $_SERVER['DOCUMENT_ROOT'].'/files';

	 if(isset($dir) === false){

	 	echo 'Fallo creando la ruta absoluta del directorio';
	 	return false;

	 }

	 if(isset($uuid) === false){

	 	echo 'El uuid del usuario no es válido';
	 	return false;
	 }


	/**
	 * Ruta absoluta donde se guardará el fichero.
	 */
	 $file_path = $dir.'/'.$uuid.'.file';

	 if(isset($file_path) === false){

	 	echo 'Fallo creando la ruta absoluta del fichero';
	 	return false;
	 }

	/**
	 * Ruta absoluta donde se encuentra el fichero en php antes de ponerlo en el directorio.
	 * @param custom_file   -> nombre del imput en la vista
	 */
	 $tmp_file_path = $_FILES['custom_file']['tmp_name'];

	 if(isset($tmp_file_path) === false){

	 	echo 'Error con la ruta absoluta del fichero en php';
	 	return false;
	 }

	 /**
	  * Padre del fichero, es decir, la carpeta donde se va a almacenar en la app
	  */
	 $father = $_SESSION['currentDir'];

	 if(!DIRECTORIES_Model::isOwner($_SESSION['currentDir'],$_SESSION['email'])){

	 	echo 'Fallo al obtener el padre';
	 	return false;
	 }

	 /**
	  * Nombre del fichero a guardar
	  */
	 $file_name = $_FILES['custom_file']['name'];

	 if(isset($file_name) === false){

	 	echo 'No se obtenido el nombre del archivo desde la vistaa';
	 	return false;
	 }

	/**
	 * Si no se encuentra el directorio se crea.
	 */
	 if(!file_exists($dir)){
	 	/**
	 	 * Se crea el directorio en la ruta absouta proporcionada, con el acceso más amplio posible y se activa la opción para crear directorios anidados.
	 	 */
	 	if(mkdir($dir,0777,true) === false){

	 		echo 'Error creando el directorio';
	 		return false;
	 	}

	 	/**
	 	 * Tras crearlo se busca, si se encuentra...
	 	 */
	 	if(file_exists($dir)){

	 		/**
	 		 * Se intenta guardarlo en el directorio
	 		 */
	 		if(move_uploaded_file($tmp_file_path, $file_path) === false){

	 			echo 'Fallo guardando el fichero en el directorio 1.0';
	 			return false;
	 		}
	 		/**
	 		 * Si se guarda en el directorio exitosamente, se intenta guardar en la base de datos
	 		 */
	 		else{

	 			$file = new FILES_Model($file_name,$father,$_SESSION['email'],mime_content_type($file_path));

	 			if(isset($file) === false){

	 				echo 'error creando el objeto de FILES_Model 1.0';
	 				return false;
	 			}

	 			if($file->add($uuid) === true){

	 				echo 'Fichero guardado con éxito';
	 				return true;
	 			}
	 			else{

	 					echo 'Fallo al guardar el fichero en la BD 1.0';
	 					return false;
	 			}

	 		}
	 	}
	 	/**
	 	 * Si el directorio no se ha logrado crear, se manda un mensaje de error.
	 	 */
	 	else{

	 		echo 'Fallo creando el directorio para guardar los ficheros';
	 		return false;
	 	}
	 }/**
	  * Si el directorio ya existía...
	  */
	 else{

	 	/**
	 	 * Se intenta guardar en el directorio
	 	 */
	 	if(move_uploaded_file($tmp_file_path, $file_path) === false){

	 		echo 'Fallo guardando el fichero en el directorio 2.0';
	 		return false;
	 	}
	 	/**
	 	 * Si se guarda en el directorio exitosamente, se intenta guardar en la BD
	 	 */
	 	else{

	 			$file = new FILES_Model($file_name,$father,$_SESSION['email'],mime_content_type($file_path));

	 			if(isset($file) === false){

	 				echo 'error creando el objeto de FILES_Model 2.0';
	 				return false;
	 			}

	 			if($file->add($uuid) === true){

	 				echo 'Fichero guardado con éxito';
	 				return true;
	 			}
	 			else{

	 					echo 'Fallo al guardar el fichero en la BD 2.0';
	 					borrarFichero($uuid);
	 					return false;
	 			}

	 	}
	 }
} 	

/**
 * Función para borrar ficheros, primero del directorio y después de la BD
 */

 function borrarFichero($uuid){

	include_once '../Model/Files_Model.php';
	include_once ('../Model/Directories_Model.php');

		
	/**
 	* Ruta absoluta del directorio para guardar ficheros
    */


    $dir = $_SERVER['DOCUMENT_ROOT'].'/files';

    if(isset($dir) === false){

 		echo 'Fallo creando la ruta absoluta del directorio';
 		return false;

 	}

	if(isset($uuid) === false){

 		echo 'El uuid del usuario no es válido';
 		return false;
 	}

 /**
  * Padre del fichero, es decir, la carpeta donde se va a almacenar en la app
  */
 $father = $_SESSION['currentDir'];

 if(!DIRECTORIES_Model::isOwner($_SESSION['currentDir'],$_SESSION['email'])){

 	echo 'Fallo al obtener el padre';
 	return false;
 }


    /**
    * Ruta absoluta donde se guardará el fichero.
    */
    $file_path = $dir.'/'.$uuid.'.file';

    if(isset($file_path) === false){

 		echo 'No se obtenido el nombre del archivo desde la vistaa';
 		return false;
 	}


    /**
     * Se comprueba que el usuario logueado sea el propietario del fichero
     */
	if(FILES_Model::isOwner($uuid,$_SESSION['email']) === false){
			
			echo 'No eres propietario de este fichero';
			return false;
	}
	/**
	 * Si el usuario resulta ser el propietario...
	 */
	else{

		/**
		 * Se comprueba que exista el directorio para borrar ficheros.
		 */
		if(file_exists($dir)){
			/**
			 * Se comprueba que el fichero exista dentro del directorio.
			 */
			if(file_exists($file_path)){
				/**
				 * Se intenta borrar el fichero del directorio
				 */
				if(unlink($file_path) === false){

					echo 'Fallo borrando el fichero del directorio';
					return false;
				}
				/**
				 * Si se borra l fichero del directorio correctamente, se intenta borrar de la BD
				 */
				else{

					if(FILES_Model::delete($uuid,$_SESSION['email']) === true){

						echo 'Borrado del fichero en la BD realizado correctamente y del directorio';
						return true;
					}else{

						echo 'Fallo al borrar el fichero en la BD';
						return false;
					}
				}
			}
			/**
			 * Se está intentando borrar un fichero que no existe en el sistema
			 */
			else{

				echo 'Está intentando borrar un fichero que no existe';
				return false;
			}
		}
		/**
		 * El directorio donde debería estar guardado el fichero no existe.
		 */
		else{

			echo 'El directorio para guardar ficheros no existe';
			return false;
		}
	}	


}


 function editarFichero($uuid)
	{

		include_once '../Model/Files_Model.php';
		include_once ('../Model/Directories_Model.php');
		 /**
		  * Padre del fichero, es decir, la carpeta donde se va a almacenar en la app
		  */
		 $father = $_SESSION['currentDir'];

		 if(!DIRECTORIES_Model::isOwner($_SESSION['currentDir'],$_SESSION['email'])){

		 	echo 'Fallo al obtener el padre';
		 	return false;
		 }

		/**
		 * Nuevo nombre del fichero
		 */
		$new_file_name = $_FILES['item_name']['name'];


		if(isset($new_file_name) === false){

			echo 'Fallo obteniendo el nuevo nombre del fichero';
			return false;
		}
		
		/**
		 * Se compruba si el fichero pertenece al usuario
		 */
		if(isOwner($uuid, $_SESSION['email']) === false){
			/**
			 * El usuario logueado no es el propietario del fichero original
			 */
			echo 'No eres el propietario del fichero';
			return false;
		}
		/**
		 * El fichero pertenece al usuario
		 */
		else{

					if(FILES_Model::edit($new_file_name,$uuid,$_SESSION['email']) === true)
					{
						/**
						 * Edición exitosa
						 */
						echo 'Fichero editado con éxito';
						return true;
					}
					else{

						/**
						 * Edición fallida
						 */
						echo 'Edición fallida';
						return false;
					}
			
		}
	}


 /**
  * Función para descargar ficheros
  */

function descargarFichero(){
	include_once('../Model/Files_Model.php');
	if(FILES_Model::isOwner($_POST['uuid'],$_SESSION['email'])  &&
		 FILES_Model::isDownloable($_POST['uuid'],$_SESSION['currentDir']) ){

		$file = $_SERVER['DOCUMENT_ROOT'].'/files/'.$_POST['uuid'].'.file';
		if (file_exists($file)) {
		    header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.$_POST['name'].'"');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate');
		    header('Pragma: public');
		    header('Content-Length: ' . filesize($file));
		    readfile($file);
		    exit;
		}
	}else{
		include_once '../Vistas/templates/error.php';
		new CustomError("CANTDOWNLOAD");
	}	
}


/**
 * Funcion a la que se recurre cuando se accede desde un enlace compartido
 */
function shared($uuid){
		include_once('../Model/Files_Model.php');
		$resultado = FILES_Model::getShared($uuid);
		if($resultado == false){
			include_once '../Vistas/templates/error.php';
			new CustomError("COULDNTGETELEMENT");
		}else{
			include_once '../Vistas/templates/error.php';
			new CustomError("SERVINGELEMENT");
			$obj_file = mysqli_fetch_object($resultado);

			$file = $_SERVER['DOCUMENT_ROOT'].'/files/'.$uuid.'.file';
			if (file_exists($file)) {
			    header('Content-Description: File Transfer');
			    header('Content-Type: application/octet-stream');
			    header('Content-Disposition: attachment; filename="'.$obj_file->originalName.'"');
			    header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($file));
			    readfile($file);
			    exit;
			}
		}
}



