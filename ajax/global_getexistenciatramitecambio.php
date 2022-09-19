
<? include_once ("../config/global_includes.php"); ?>
<?php
	$num_licencia = $_GET['num_licencia'];
	$licencias = new licencias();
	$res = $licencias->getexistenciatramitecambio($num_licencia);
	
	if($res == 0) {
		$resultado = false;
	}
	else {
		$resultado = $res;
	}
	
echo json_encode($resultado);
?>