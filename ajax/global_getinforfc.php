<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET INFO RFC BY RFC
* * DATOS ENTRADA POST
						rfc
* DATOS DE SALIDA JSON	
                        id
                        rfc
                        curp
						nombre
                        direccion
                        entrecalle
                        ycalle
                        coloniaid
                        colonia
                        telefono
                        celular   
* Catalogo cat_persona
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$catalogos = new catalogos();
	$res = $catalogos->getpersonabyrfc($_POST['rfc']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
                    "bandera"=>1,
                    "rfc"=>$row['persona_rfc'],
                    "curp"=>$row['persona_curp'],
					"id"=>$row['persona_id'],
					"nombre"=>$row['persona_nombre'],
                    "direccion"=>$row['persona_direccion'],
                    "entrecalle"=>$row['persona_entrecalle'],
                    "yentrecalle"=>$row['persona_yentrecalle'],
                    "coloniaid"=>$row['persona_colonia'],
                    "colonia"=>$row['colonia_nombre'],
                    "telefono"=>$row['persona_telefono'],
                    "celular"=>$row['persona_celular'],
                    "correo"=>$row['persona_correo'],
                    "zona"=>$row['zona_nombre']
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