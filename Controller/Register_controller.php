<?php

/**
 * Cargar la sesión.
 */
session_start();
	if(isset($_SESSION['email'])){
		header('Location:../Login_controller.php',TRUE,301);
	}
	//No se está registrando, le mostramos la vista
	if(!isset($_POST['user']) && (!isset($_POST['email']) || !(isset($_POST['pass'])))){
		include_once '../Vistas/templates/register.php';
	new Register();
	}else{//Se está registrando
		/**
		 * Realiza una query a la BD para registrar al nuevo usuario
		 */
		include_once '../Model/User_Model.php';
		$usuario = new USUARIOS_Model(
				$_POST['user'], 
				md5( $_POST['pass'] ),
				$_POST['email'] );

		$respuesta = $usuario->register();


		


		if($respuesta === true){
			/**
			 * Le crea un directorio de inicio
			 */

			include_once ('../Model/Directories_Model.php');
			$principal = DIRECTORIES_Model::findMain($_POST['email']);
			//Comprueba que no exista ya un main para el usuario
			if($principal == false){
				/**
			 	* En caso de no encontrar un directorio inicial 
			 	* intenta crear el directorio base
			 	*/
				include_once '../Functions/uuidGenerator.php';
				$uuid = uuidGenerator($_POST['email']);
				$dir = new DIRECTORIES_Model("/",$_POST['email'],NULL);
				
				/**
				 * Intenta añadir el directorio con el uuid generado, en caso de no poder genera uuids hasta poder hacerlo
				 */
				while( ($dir->addParent( $uuid )) === false ){
					$uuid = uuidGenerator($_POST['email']);
				}
			}
			include_once '../Vistas/templates/error.php';
			new CustomError("USERREGISTERED");
			

		} else {

			include_once '../Vistas/templates/error.php';
			new CustomError("REGISTERERROR");
		}
	}

?>
