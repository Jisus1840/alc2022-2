
<? include_once ("../config/global_includes.php"); ?>
<?php
	$tramite = new tramite();
	$res = $tramite->getinfo_pagos($_GET['tramitevu_id']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"fecha_primer_pago"=>$row['tramitevu_fechapago'],
                    "monto_primer_pago"=>$row['tramitevu_montopago'],
                    "fecha_segundo_pago"=>$row['tramitevu_fechatotalpago'],
                    "monto_segundo_pago"=>$row['tramitevu_montototalpago'],
				);
			$i++;
		}
	}
echo json_encode($array);
?>