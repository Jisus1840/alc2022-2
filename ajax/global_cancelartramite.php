<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX CANCELAR TRAMITE
* * DATOS ENTRADA POST
                        tramiteid
                        usuarioid
                        
* DATOS DE SALIDA JSON	
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $v = new ventanilla();
	$res = $v->cancelartramite($_POST['tramiteid'],$_POST['usuarioid'],$_POST['motivocancelacion']);
    echo "Trámite Cancelado";
?>