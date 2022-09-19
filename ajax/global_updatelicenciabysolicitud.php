<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX PARA REALIZAR LOS CAMBIOS DE UNA LICENCIA EN BASE A UNA SOLICITUD DE CAMBIOS
* * DATOS ENTRADA POST
                        tramitevuid
                        fechapago
                        montopago
                        
* DATOS DE SALIDA JSON	
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $t = new tramite();
	$res = $t->updatelicenciabysolicitud($_POST['tramitevuid'], $_POST['folionuevo']);
?>