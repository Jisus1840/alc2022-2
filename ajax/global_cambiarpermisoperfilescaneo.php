<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET PERMISOS DE PERFIL PARA ESCANEO
* * DATOS ENTRADA
* DATOS DE SALIDA JSON	idperfil
* Catalogo cat_usuarios
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$_SESSION['alcoholes']['perfil_escaneo'] = $_POST['idperfil'];
?>