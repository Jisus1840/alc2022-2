<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda trámite Escaneo
* Entrada
                tramites
* Salida
                lastinsertid
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
$tramites = $_POST['tramites'];
$objTramite = new ventanilla();
$res = $objTramite->recibir($tramites);
$cont = 0;
for ($i=0;$i<count($res);$i++){
	if ($res[$i]["valido"]!=0)
		$cont++;
}
if ($cont==0){
	echo "no";
}else{
	$fech = date("Ymdhis");
	$rannum = rand(10000,99999);
	$bloquetramite = $fech.$rannum;
	$objTramite->recibirGuardar($tramites,$bloquetramite);
	echo "Trámites recibidos con éxito";
}
?>