
<? include_once ("../config/global_includes.php"); ?>

<?php
	$tramitevu_id = $_GET['tramitevu_id'];
	$licencias = new licencias();
	$res = $licencias->getinfotramitecambio($tramitevu_id);
	
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"tiposubtramiteids"=>$row['tramitecambio_tiposubtramiteids'],
					"licenciaid"=>$row['tramitecambio_licenciaid'],
					"licencia"=>$row['tipolicencia_nombre'].$row['licencias_licencia'],
					"direccion_nueva"=>$row['tramitecambio_domicilionuevo'],
					"direccion_num_nuevo"=>$row['tramitecambio_domicilionuevo_numext'],
					"codigopostal"=>$row['colonia_cp'],
					"coloniaid"=>$row['tramitecambio_domiciliocoloniaidnuevo'],
					"entrecalle"=>$row['tramitecambio_domicilioentrecallenuevo'],
					"yentrecalle"=>$row['tramitecambio_domicilioyentrecallenuevo'],
					"latitud"=>$row['tramitecambio_domiciliolatitudnuevo'],
					"longitud"=>$row['tramitecambio_domiciliolongitudnuevo'],
					"domicilio_anterior"=>$row['tramitecambio_domicilioanterior'],
					"acolonia"=>$row['colonia_nombre'],
					"acoloniaid"=>$row['tramitecambio_domiciliocoloniaidanterior'],
					"aentrecalle"=>$row['tramitecambio_domicilioentrecalleanterior'],
					"ayentrecalle"=>$row['tramitecambio_domicilioyentrecalleanterior'],
					"alatitud"=>$row['tramitecambio_domiciliolatitudanterior'],
					"alongitud"=>$row['tramitecambio_domiciliolongitudanterior'],
					"pnuevo"=>$row['rfc_rfc'],
					"pnuevoid"=>$row['tramitecambio_propietarioidnuevo'],
					"personanombre"=>$row['persona_razonsocial'],
					"direccion"=>$row['persona_direccion'].' '.$row['persona_direccion_numero'],
					"panterior"=>$row['rfc_propietario_anterior'],
					"panteriorid"=>$row['tramitecambio_propietarioidanterior'],
					"cnuevo"=>$row['rfc_comodatarionuevo'],
					"cnuevoid"=>$row['tramitecambio_comodatarioidnuevo'],
					"personanombrec"=>$row['nombre_comodatario'],
					"direccionc"=>$row['comodatario_direccion'].' '.$row['comodatario_numero'],
					"canterior"=>$row['rfc_comodatarioanterior'],
					"canteriorid"=>$row['tramitecambio_comodatarioidanterior'],
					"nombregnuevo"=>$row['tramitecambio_nombrenuevo'],
					"nombreganteriordis"=>$row['tramitecambio_nombreanterior'],
					"nombreganterior"=>$row['tramitecambio_nombreanterior'],
					"giroid"=>$row['tramitecambio_giroidnuevo'],
					"giroanterior"=>$row['giro_nombre'],
					"giroanteriorid"=>$row['tramitecambio_giroidanterior'],
					"tipolicenciaid"=>$row['tramitecambio_tipo_licencia_id'],
					"tipolicenciaanterior"=>$row['tipolicencia_nombre'],
					"tipolicenciaidanterior"=>$row['licencias_tipolicencia'],
					"nombre_propietario_anterior"=>$row['nombre_propietario_anterior'],
					"direccion_panterior"=>$row['direccion_panterior'].' '.$row['numext_panterior'],
					"nombre_anterior_comodatario"=>$row['nombre_anterior_comodatario'],
					"direccion_canterior"=>$row['direccion_canterior'].' '.$row['numext_canterior'],
					"comodatario_licencia_rfc"=>$row['rfc_comodatario_licencia'],
					"comodatario_licencia_nombre"=>$row['comodatario_licencia'],
					"comodatario_licencia_domicilio"=>$row['com_direccion_licencia'].' '.$row['com_numext_licencia'],
					"comodatario_licencia_id"=>$row['licencias_comodatariopersonaid'],
					"propietario_licencia_rfc"=>$row['rfc_propietario_licencia'],
					"propietario_licencia_nombre"=>$row['propietario_licencia'],
					"propietario_licencia_domicilio"=>$row['prop_direccion_licencia'].' '.$row['prop_numext_licencia'],
					"propietario_licencia_id"=>$row['licencias_propietariopersonaid'],
					"folio_licencia_anterior"=>$row['tramitecambio_folio_licencia_anterior'],
					"tipolicencia_nombre_nuevo"=>$row['tipolicencia_nombre_nuevo']
				);
			$i++;
		}
	}else{
		$array[0] = array(
			"tiposubtramiteids"=>'',
			"licenciaid"=>'',
			"licencia"=>'',
			"direccion_nueva"=>'',
			"direccion_num_nuevo"=>'',
			"codigopostal"=>'',
			"coloniaid"=>'',
			"entrecalle"=>'',
			"yentrecalle"=>'',
			"latitud"=>'',
			"longitud"=>'',
			"domicilio_anterior"=>'',
			"acolonia"=>'',
			"acoloniaid"=>'',
			"aentrecalle"=>'',
			"ayentrecalle"=>'',
			"alatitud"=>'',
			"alongitud"=>'',
			"pnuevo"=>'',
			"pnuevoid"=>'',
			"personanombre"=>'',
			"direccion"=>'',
			"panterior"=>'',
			"panteriorid"=>'',
			"cnuevo"=>'',
			"cnuevoid"=>'',
			"personanombrec"=>'',
			"direccionc"=>'',
			"canterior"=>'',
			"canteriorid"=>'',
			"nombregnuevo"=>'',
			"nombreganteriordis"=>'',
			"nombreganterior"=>'',
			"giroid"=>'',
			"giroanterior"=>'',
			"giroanteriorid"=>'',
			"tipolicenciaid"=>'',
			"tipolicenciaanterior"=>'',
			"tipolicenciaidanterior"=>'',
			"nombre_propietario_anterior"=>'',
			"direccion_panterior"=>'',
			"nombre_anterior_comodatario"=>'',
			"direccion_canterior"=>'',
			"comodatario_licencia_rfc"=>'',
			"comodatario_licencia_nombre"=>'',
			"comodatario_licencia_domicilio"=>'',
			"comodatario_licencia_id"=>'',
			"propietario_licencia_rfc"=>'',
			"propietario_licencia_nombre"=>'',
			"propietario_licencia_domicilio"=>'',
			"propietario_licencia_id"=>'',
			"folio_licencia_anterior"=>'',
			"tipolicencia_nombre_nuevo"=>''
		);
	}
echo json_encode($array);
?>