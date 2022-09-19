<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX ELIMINA O AGREGA UN PERMISO DE LA BASE DE DATOS
* DATOS ENTRADA POST 	idusuario
                        idmenu
                        permiso
* DATOS DE SALIDA		1 o 0
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
$permisos = new permisos();
$res = $permisos->updatepermisos($_POST['idusuario'],$_POST['idmenu'],$_POST['permiso']);
?>