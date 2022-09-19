<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET ESTADOS
* * DATOS ENTRADA GET
						busqueda
* DATOS DE SALIDA JSON	id
						nombre
* Catalogo cat_estado
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$busqueda = (isset($_GET['busqueda'])?$_GET['busqueda']:'');
	$catalogos = new catalogos();
	$res = $catalogos->getestados($busqueda);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['estado_id'],
					"nombre"=>$row['estado_nombre']
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