<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET HORAS DISPONMIBLES CITAS
* DATOS ENTRADA GET
                        eventoid
                        asesorid
                        fecha
* DATOS DE SALIDA JSON	id
						nombre
*********************************************************************************
*/
?>
<? session_start(); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
    $citas = new citas();
	$res = $citas->gethorasdisponibles($_GET['eventoid'],$_GET['asesorid'],$_GET['fecha']);
	$array = array();
	$i=0;
	if (count($res) > 1){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row,
					"nombre"=>$row
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