<?php 

const DEFAULT_LANGUAGE = 'Spanish';

if($_GET['action'] == 'switchL'){
	switchL();
}


function translate($key){
	

	static $strings = null;

	//Carga el fichero de lenguaje en caso de que no haya sido cargado todavía
	if($strings === null){


		//Entra en la sesión para leer del array superglobal el idioma actual
		session_start();//Modo lectura y cierre

		//Define el lenguaje actual como le primero de los valores no null de izq a der
		$current_language = $_SESSION['currentLanguage'] ?? DEFAULT_LANGUAGE; 
		
		//Carga el lenguaje seleccionado
		include_once ('../Locales/'.$current_language.'.php');
	
	
	}
	
	
	// Comprueba que la cadena exista y sea válida, en caso contrario muestra el valor pasado como clave
	if(isset($strings[$key]) && is_string($strings[$key])){
		
		return $strings[$key];
	
	} else{
		
		return $key;
	
	}
}

function switchL(){
	session_start();
	if($_SESSION['currentLanguage'] == 'English'){
		$_SESSION['currentLanguage'] = 'Spanish';	
	} else{
		$_SESSION['currentLanguage'] = 'English';
	}

	if(isset($_GET['from'])){
		if($_GET['from'] == "Login"){
			header('Location:/Controller/Login_controller.php');
		} elseif($_GET['from'] == "Register"){
			header('Location:/Controller/Register_controller.php');

		} elseif($_GET['from'] == "Main"){
			header('Location:/Controller/Main_controller.php?action=list');
		}
	}
	header('Location:/Controller/Login_controller.php');
}

?>
