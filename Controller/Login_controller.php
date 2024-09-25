<?php
/*
 * Comienza una sesión o la continua
 */
session_start();

/**
 * Comprueba que el usuario esta autenticado
 */
	if(!isset($_SESSION['email']) && ( !isset( $_POST['email']) || !isset($_POST['pass']) ) ){
		/**
		 * En caso de no estar ya autenticado se procede al login
		 */
		include_once ('../Vistas/templates/login.php');
		new Login();
			
	}
	elseif (!isset($_SESSION['email']) && isset($_POST['email']) && isset($_POST['pass'])){
		
		/**
		 * No esta logeado pero está en proceso
		 *
		 * Realiza una query a la BD para comprobar si el usuario es correcto
		 */
		include_once ('../Model/User_Model.php');
		$usuario = new USUARIOS_Model("", md5($_POST['pass']),$_POST['email']);
		$respuesta = $usuario->login();

		if($respuesta === true){
			/**
			 * En caso de login exitoso establece las variables de sesion
			 */
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['currentLanguage'] = "Spanish";
			include_once ('../Model/Directories_Model.php');
			$directorio = DIRECTORIES_Model::findMain($_POST['email']);

			$_SESSION['currentDir'] = $directorio;
			$_SESSION['top'] = true;
			//Almacena los datos y cierra la sesion
			session_write_close();

			header('Location:./Main_controller.php?action=list',TRUE,301); 

		} else {
			
			/**
			 * Muestra el posible error de login
			 */
			include_once '../Vistas/templates/error.php';
			new CustomError("LOGINERROR");
		}
	} else{
		/**
		 * Ya logeado
		 */
		header('Location:./Main_controller.php?action=list',TRUE,301);
	}


?>
