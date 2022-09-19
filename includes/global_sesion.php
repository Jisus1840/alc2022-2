<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* AMBIENTE DE SESION EN TU PORTAL
*********************************************************************************
*/
session_start();
if (isset($_SESSION['alcoholes']['usuario_info'])){
	//session_start();
	$usersession =  unserialize($_SESSION['alcoholes']['usuario_info']);
    $usersessionpermisos =  unserialize($_SESSION['alcoholes']['permisos']);
}else{
	header ("location:../gui/global_login.php");
}
?>