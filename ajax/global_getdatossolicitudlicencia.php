
<? include_once ("../config/global_includes.php"); ?>
<?php
	$licencias = new licencias();
	$res = $licencias->getdatossolicitudlicencia($_GET['tramitevu_id']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
                    "nombregenerico"=>$row['tramitealtalicencia_nombregenerico'],
                    "giro_id"=>$row['tramitealtalicencia_giro'],
					"tipo_licencia_id"=>$row['tramitealtalicencia_tipo_licencia_id'],
					"comodatario_id"=>$row['tramitealtalicencia_comodatariopersonaid'],
                    "propietario_id"=>$row['tramitealtalicencia_propietariopersonaid'],
                    "domicilio_licencia"=>$row['tramitealtalicencia_domicilio'],
					"domicilio_licencia_num"=>$row['tramitealtalicencia_domicilio_numext'],
                    "colonia_licencia_id"=>$row['tramitealtalicencia_coloniaid'],
                    "entrecalle"=>$row['tramitealtalicencia_entrecalle'],
                    "yentrecalle"=>$row['tramitealtalicencia_yentrecalle'],
                    "latitud"=>$row['tramitealtalicencia_latitud'],
                    "longitud"=>$row['tramitealtalicencia_longitud'],
                    "nombre_comodatario"=>$row['nombre_comodatario'],
                    "nombre_propietario"=>$row['nombre_propietario'],
                    "direccion_comodatario"=>$row['direccion_comodatario'].' '.$row['numero_direccion_comodatario'],
                    "direccion_propietario"=>$row['direccion_propietario'].' '.$row['numero_direccion_propietario'],
                    "rfc_comodatario"=>$row['rfc_comodatario'],
                    "rfc_propietario"=>$row['rfc_propietario'],
                    "rfc_id_comodatario"=>$row['rfc_id_comodatario'],
                    "rfc_id_propietario"=>$row['rfc_id_propietario'],
                    "colonia_cp"=>$row['colonia_cp']
				);
			$i++;
		}
	}else{
		$array[0] = array(
					"bandera"=>0
				);
	}
echo json_encode($array);
?>