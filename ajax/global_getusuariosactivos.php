<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET USUARIOS
* * DATOS ENTRADA GET
						busqueda
* DATOS DE SALIDA JSON	id
						nombre
						iniciales
* Catalogo cat_usuarios
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$busqueda = (isset($_GET['busqueda'])?$_GET['busqueda']:'');
	$catalogos = new catalogos();
	$res = $catalogos->getusuariosactivos($busqueda);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['usuarios_id'],
					"nombre"=>$row['usuarios_nombre'],
					"iniciales"=>$row['usuarios_iniciales']
				);
			$i++;
		}
	}else{
		$array[0] = array(
					"id"=>'',
					"nombre"=>'',
					"iniciales"=>''
				);
	}
echo json_encode($array);
?>