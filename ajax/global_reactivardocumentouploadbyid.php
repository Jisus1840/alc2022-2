<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX REACTIVA UN DOCUMENTO DE UPLOADS
* DATOS ENTRADA POST 	documentosupload_id
* DATOS DE SALIDA		1 o 0
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$documento = new documentosupload();
	echo $documento->reactivardocumentobyid($_POST['documentosupload_id']);
?>