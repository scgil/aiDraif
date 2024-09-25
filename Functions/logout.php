<?php

session_start();
require_once '../Functions/Authentication.php';

// Si el usuario está conectado, desconectarle borrando los datos de sesión asociados
if (IsAuthenticated()) {
	session_destroy();
	header('Location: /Controller/Login_controller.php');
}


?>