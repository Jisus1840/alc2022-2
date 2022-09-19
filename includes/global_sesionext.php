<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* AMBIENTE DE SESION EN TU PORTAL DE USUAEIOS EXTERNOS
*********************************************************************************
*/
session_start();
if (isset($_SESSION['alcoholesext']['usuarioext_info'])){
	//session_start();
	$usersessionext =  unserialize($_SESSION['alcoholesext']['usuarioext_info']);
}else{
	header ("location:../gui/global_loginext.php");
}
?>