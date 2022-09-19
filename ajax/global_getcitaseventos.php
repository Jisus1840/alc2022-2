<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET EVENTOS CITAS
* DATOS ENTRADA
* DATOS DE SALIDA JSON	id
						nombre
*********************************************************************************
*/
?>
<? session_start(); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$citas = new citas();
	$res = $citas->geteventosactivos();
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['ceventos_id'],
					"nombre"=>$row['ceventos_nombre']
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