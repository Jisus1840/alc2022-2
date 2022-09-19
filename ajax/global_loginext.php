<? session_start(); ?>
<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2020
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX LOGIN DE USUARIO
* DATOS ENTRADA POST 	correo
						rfc
* DATOS DE SALIDA		1 o 0
* CREA VARIABLES DE SESION	
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$correo = util::strupper($_POST['correo']);
	$rfc = util::strupper($_POST['rfc']);
	$pagina = util::strupper($_POST['numero_pagina']);
	$login = new loginext();
	$login->acceso($correo,$rfc,$pagina);
?>