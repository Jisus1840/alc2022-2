<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET INFORMACIÓN DE LICENCIA BY LICENCIA
* * DATOS ENTRADA GET
						licencia
* DATOS DE SALIDA JSON	id
						nombre
* Catalogo cat_colonia
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$licencias = new licencias();
	$res = $licencias->getalllicencias($_GET['licencia']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['licencias_id'],
                    "idtipolicencia"=>$row['tipolicencia_id'],
                    "tipolicencia"=>$row['tipolicencia_nombre'],
					"licencia"=>$row['tipolicencia_nombre'].$row['licencias_licencia'],
                    "giroid"=>$row['giro_id'],
                    "gironombre"=>$row['giro_nombre'],
                    "nombregenerico"=>$row['licencias_nombregenerico'],
                    "domicilio"=>$row['licencias_domicilio'].' '.$row['licencias_domicilio_numext'],
                    "colonia"=>$row['colonia_nombre'],
                    "coloniaid"=>$row['colonia_id'],
                    "entrecalle"=>$row['licencias_entrecalle'],
                    "ycalle"=>$row['licencias_yentrecalle'],
                    "pid"=>$row['pid'],
                    "cid"=>$row['cid'],
                    "prfc"=>$row['prfc'],
                    "crfc"=>$row['crfc'],
                    "pnombre"=>$row['pnombre'],
                    "cnombre"=>$row['cnombre'],
                    "latitud"=>$row['licencias_latitud'],
                    "longitud"=>$row['licencias_longitud']
				);
			$i++;
		}
	}
echo json_encode($array);
?>