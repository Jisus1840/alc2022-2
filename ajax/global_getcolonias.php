<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET COLONIAS
* * DATOS ENTRADA GET
						busqueda
                        municipioid
* DATOS DE SALIDA JSON	id
						nombre
* Catalogo cat_colonia
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$busqueda = (isset($_GET['busqueda'])?$_GET['busqueda']:'');
	$municipioid = (isset($_GET['municipioid'])?$_GET['municipioid']:'');
	$catalogos = new catalogos();
	$res = $catalogos->getcolonias($busqueda,$municipioid);
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