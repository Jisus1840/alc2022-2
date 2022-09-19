<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET GIRO
* * DATOS ENTRADA GET
						
* DATOS DE SALIDA JSON	id
						nombre
* Catalogo cat_giro
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$catalogos = new catalogos();
	$res = $catalogos->getgiro();
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['giro_id'],
					"nombre"=>$row['giro_nombre']
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