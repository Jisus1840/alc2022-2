<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET USUARIOS POR EVENTO SELECCIONADO
* DATOS ENTRADA
                        eventoid
* DATOS DE SALIDA JSON	id
						nombre
*********************************************************************************
*/
?>
<? session_start(); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$citas = new citas();
	$res = $citas->getusuariosactivosbyeventoid($_GET['eventoid']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['ceventosusuario_cusuariosid'],
					"nombre"=>$row['cusuarios_nombre']
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