<? session_start(); ?>
<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX LOGIN DE USUARIO
* DATOS ENTRADA POST 	usuario
						password
* DATOS DE SALIDA		1 o 0
* CREA VARIABLES DE SESION	
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$usuario = $_POST['usuario'];
	$pwd = $_POST['password'];
	$login = new loginuser();
	$login->acceso($usuario,$pwd);
?>