<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX CREAR UNA LICENCIA A PARTIR DE UNA TRÁMITE DE UNA SOLICITUD DE LICENCIA
* * DATOS ENTRADA POST
                        tipolicencia
                        numlicencia
                        fechaalta
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
	$res = $t->crearlicenciabysolicitudlicencia($_POST['tipolicencia'],$_POST['numlicencia'],$_POST['fechaalta'],$_POST['tramitevuid']);
?>