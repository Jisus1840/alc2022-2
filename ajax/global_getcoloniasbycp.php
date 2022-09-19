
<? include_once ("../config/global_includes.php"); ?>
<?php
	$codigo_postal = (isset($_GET['codigo_postal'])?$_GET['codigo_postal']:'');
	$municipioid = (isset($_GET['municipioid'])?$_GET['municipioid']:'');
	$catalogos = new catalogos();
	$res = $catalogos->getcoloniasbycp($codigo_postal,$municipioid);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['colonia_id'],
					"nombre"=>$row['colonia_nombre'].' (CP:'.$row['colonia_cp'].')'
				);
			$i++;
		}
	}else{
		$array[0] = array(
					"id"=>'',
					"nombre"=>''
				);
	}
echo json_encode($array);
?>