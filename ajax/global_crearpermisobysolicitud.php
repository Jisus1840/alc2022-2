<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX CREAR UN PEMRISO A PARTIR DE UNA TRÁMITE DE UNA SOLICITUD DE PERMISO
* * DATOS ENTRADA POST
                        numpermiso
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
	$res = $t->crearpermisobysolicitudpermiso($_POST['numpermiso'],$_POST['fechaalta'],$_POST['tramitevuid']);
?>