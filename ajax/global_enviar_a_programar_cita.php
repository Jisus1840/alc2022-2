
<? include_once ("../config/global_includes.php"); ?>
<?	
	$fecha_hora_actual = date('Y-m-d H:i:s', time());
	$fecha_actual = date('Y-m-d');
	$fecha_inicio = $fecha_actual.' 09:00:00';
	$fecha_fin = $fecha_actual.' 14:00:00';
	$dia_semana = date("l");
		
	$sql = "select * from global_tramitevu where tramitevu_fecha_enviado_revision like '%".$fecha_actual."%'";
	$db = new DB();
	$res2 = $db->Ejecuta($sql);
	$db->close();
		
	if($res > 0 || (count($res2) < 8 && ($fecha_hora_actual >= $fecha_inicio && $fecha_hora_actual <= $fecha_fin)) && $dia_semana != 'Saturday' && $dia_semana != 'Sunday') {
		$tramite = new tramite();
		$tramitevu_id = $_POST['tramitevu_id'];
		$tramite->update_mostrar_coordinacion($tramitevu_id);		
		echo "Expediente enviado a revisión. La Unidad Administrativa de Alcoholes te asignará la fecha y hora de tu cita. Esta información te será notificada por correo electrónico y también aparecerá en esta página, en la columna Cita";
	}
	else if(count($res2) == 8) {
		echo "No es posible enviar el expediente, límite de expedientes enviados por día alcanzado. Intenta de lunes a viernes en un horario de 09:00 a.m. a 02:00 p.m.";
	}
	else {
		echo "No es posible enviar el expediente a revisión. Horario para enviar expedientes a revisión: de lunes a viernes, de 09:00 a.m. a 02:00 p.m.";
	}

?>


