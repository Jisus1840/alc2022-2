
<? include_once ("../config/global_includes.php"); ?>
<?php
	$licencias = new licencias();
	$res = $licencias->getinfopermisoespecial($_GET['tramitevu_id']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(           
                    "tipo_evento"=>$row['tramitealtalicenciaprovisional_tipoevento'],                       
                    "fecha_inicial"=>$row['tramitealtalicenciaprovisional_fechai'],  
					"fecha_final"=>$row['tramitealtalicenciaprovisional_fechaf'],     					
                    "horario_inicio"=>$row['tramitealtalicenciaprovisional_horario'],            
                    "horario_fin"=>$row['tramitealtalicenciaprovisional_horariofin'], 
                    "descripcion"=>$row['tramitealtalicenciaprovisional_descripcion'],   					
                    "rfc_rfc"=>$row['rfc_rfc'],   					
                    "persona_razonsocial"=>$row['persona_razonsocial'],   					
					"propietario_id"=>$row['tramitealtalicenciaprovisional_propietariopersonaid'], 					
					"propietario_direccion"=>$row['persona_direccion'].' '.$row['persona_direccion_numero'],			
                    "giro_id"=>$row['tramitealtalicenciaprovisional_giro'], 					       
                    "domicilio"=>$row['tramitealtalicenciaprovisional_domicilio'],            
                    "domicilio_num"=>$row['tramitealtalicenciaprovisional_domicilio_numext'],            
                    "colonia_id"=>$row['tramitealtalicenciaprovisional_coloniaid'],            
                    "colonia_cp"=>$row['colonia_cp'],            
                    "entrecalle"=>$row['tramitealtalicenciaprovisional_entrecalle'],            
                    "yentrecalle"=>$row['tramitealtalicenciaprovisional_yentrecalle'],            
                    "latitud"=>$row['tramitealtalicenciaprovisional_latitud'],            
                    "longitud"=>$row['tramitealtalicenciaprovisional_longitud']           
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