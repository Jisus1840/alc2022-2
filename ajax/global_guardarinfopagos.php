
<? include_once ("../config/global_includes.php"); ?>
<?php
	$tramitevuid = $_POST['tramitevuid'];
	$fechaprimerpago = $_POST['fechaprimerpago'] ? "'".$_POST['fechaprimerpago']."'" : 'null';
	$montoprimerpago = $_POST['montoprimerpago'] ? $_POST['montoprimerpago'] : 'null';
	$fechasegundopago = $_POST['fechasegundopago'] ? "'".$_POST['fechasegundopago']."'" : 'null';
	$montosegundopago = $_POST['montosegundopago'] ? $_POST['montosegundopago'] : 'null';
	
	$tramite = new tramite();
	$res = $tramite->guardarinfopagos($tramitevuid, $fechaprimerpago, $montoprimerpago, $fechasegundopago, $montosegundopago);
?>