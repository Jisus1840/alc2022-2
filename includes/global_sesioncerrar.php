<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* DESTRUYE VARIABLES DE SESION
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<?
session_destroy();
header("location:../index.php");
?>