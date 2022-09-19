<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2020
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET calendario usuarios
* * DATOS ENTRADA GET
                        eventoid
* DATOS DE SALIDA JSON	id
						nombre
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
    $eventoid = (isset($_GET['eventoid'])?$_GET['eventoid']:"");
	$citas = new citas();
	$res = $citas->getusuariosactivosbyeventoid($eventoid);
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
	}
echo json_encode($array);
?>