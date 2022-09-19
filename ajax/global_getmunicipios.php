<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET MUNICIPIOS
* * DATOS ENTRADA GET
						busqueda
                        estadoid
* DATOS DE SALIDA JSON	id
						nombre
* Catalogo cat_municipio
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$busqueda = (isset($_GET['busqueda'])?$_GET['busqueda']:'');
    $estadoid = (isset($_GET['estadoid'])?$_GET['estadoid']:'');
	$catalogos = new catalogos();
	$res = $catalogos->getmunicipios($busqueda,$estadoid);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['municipio_id'],
					"nombre"=>$row['municipio_nombre']
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