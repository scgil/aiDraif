
<?php
//Comprueba si te has autentificado en el sistema.
function IsAuthenticated()
{
	if (!isset($_SESSION['email']))
	{
		return false;
	}
	else
	{
		return true;
	}
}
?>
