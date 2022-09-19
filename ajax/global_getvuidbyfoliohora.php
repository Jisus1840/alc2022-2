<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET INFO BY FOLIO Y HORA
* * DATOS ENTRADA POST
						folio
                        hora
* DATOS DE SALIDA JSON	
                        vuid
* Catalogo cat_persona
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$vu = new ventanilla();
	$res = $vu->getresbyfoliohora($_POST['folio'],$_POST['hora']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
                    "vuid" => $row['vuid'],
                    "tramitevu" => $row['tramitevu_folio'],
                    "fecha" => $row['tramitevu_fechainicio'],
                    "folio" => $row['folio'],
                    "tramite" => $row['tipotramite_nombre'],
                    "flujo" => $row['flujodetalle_casillanombre'],
                    "statuscolor" => $row['status_color'],
                    "statusnombre" => $row['status_nombre'],
                    "tabla" => $row['tabla'],
                    "tablacampo" => $row['tablacampo'],
                    "tipotramiteid" => $row['tramitevu_tipotramiteid']
				);
			$i++;
		}
	}else{
		$array[0] = array(
					"vuid" => 0
				);
	}
echo json_encode($array);
?>