<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET PERSONAS
* * DATOS ENTRADA GET
						busqueda
* DATOS DE SALIDA JSON	id
						nombre
						rfc
* Catalogo cat_usuarios
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$busqueda = (isset($_GET['busqueda'])?$_GET['busqueda']:'');
	$catalogos = new catalogos();
	$res = $catalogos->getpersonas($busqueda);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['persona_id'],
					"nombre"=>$row['persona_nombre'],
					"rfc"=>$row['persona_rfc'],
                    "curp"=>$row['persona_curp'],
                    "domicilio"=>$row['persona_direccion'].' '.$row['persona_direccion_numero'].', '.$row['colonia_nombre'],
                    "telefonos"=>' Tel:'.$row['persona_telefono'].' Cel:'.$row['persona_celular']
				);
			$i++;
		}
	}else{
		$array[0] = array(
					"id"=>'',
					"nombre"=>'',
					"rfc"=>'',
                    "curp"=>'',
                    "domicilio"=>''
				);
	}
echo json_encode($array);
?>