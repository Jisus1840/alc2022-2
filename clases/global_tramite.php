<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase Tramite
*********************************************************************************
*/
?>
<?
class tramite{

    //get folio by id ventanilla
    public static function getfoliotramite($vuid){
        $db = new DB();
        $sql = "select folio from vw_tramitestramitevu where vuid = ".$vuid;
        $res = $db->Ejecuta($sql);
		$folio = $res[0]['folio'];
        return $folio;
    }

    //get fecha inicio by id ventanilla
    public static function getfechainiciotramite($vuid){
        $db = new DB();
        $sql = "select tramitevu_fechainicio from global_tramitevu where tramitevu_id = ".$vuid;
        $res = $db->Ejecuta($sql);
		$fecha = $res[0]['tramitevu_fechainicio'];
        return $fecha;
    }

    //get hora inicio by id ventanilla
    public static function gethorainiciotramite($vuid){
        $db = new DB();
        $sql = "select DATE_FORMAT(tramitevu_fechainicio, '%k:%i') hora from global_tramitevu where tramitevu_id = ".$vuid;
        $res = $db->Ejecuta($sql);
		$hora = $res[0]['hora'];
        return $hora;
    }

    //Guarda Trámite
    function guardarsolicitudlicencia(
        $nombregenerico,
        $giroid,
        $personaid,
        $personaidcomodatario,
        $domiciliolic,
        $domiciliolicnum,
        $municipioid,
        $coloniaid,
        $entrecalle,
        $yentrecalle,
        $latitud,
        $longitud,
        $vuid,
        $usuarioid,
        $usuarionombre,
        $correousuario,
        $rfcusuario,
		$tipolicenciaid
    ){

        $db = new DB();
		$sql = "
        insert into global_tramitealtalicencia
        (
            tramitealtalicencia_id,
			tramitealtalicencia_ciclo,
            tramitealtalicencia_propietariopersonaid,
            tramitealtalicencia_comodatariopersonaid,
            tramitealtalicencia_nombregenerico,
            tramitealtalicencia_giro,
            tramitealtalicencia_domicilio,
            tramitealtalicencia_domicilio_numext,
            tramitealtalicencia_coloniaid,
            tramitealtalicencia_municipioid,
            tramitealtalicencia_entrecalle,
            tramitealtalicencia_yentrecalle,
            tramitealtalicencia_latitud,
            tramitealtalicencia_longitud,
            tramitealtalicencia_tramitevuid,
			tramitealtalicencia_tipo_licencia_id
        )
        values
        (
            null,
			(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".(($personaid == '' or $personaid == 0)?'null':$personaid).",
            ".(($personaidcomodatario == '' or $personaidcomodatario == 0)?'null':$personaidcomodatario).",
            '".mb_strtoupper($nombregenerico)."',
            ".$giroid.",
            '".mb_strtoupper($domiciliolic)."',
            '".mb_strtoupper($domiciliolicnum)."',
            ".$coloniaid.",
            ".$municipioid.",
            '".mb_strtoupper($entrecalle)."',
            '".mb_strtoupper($yentrecalle)."',
            '".$latitud."',
            '".$longitud."',
            ".$vuid.",
			".$tipolicenciaid."
        )
        ";
        /*$sql = "
        insert into global_tramitealtalicencia
        (
            tramitealtalicencia_id,
            tramitealtalicencia_folioid,
            tramitealtalicencia_folio,
            tramitealtalicencia_ciclo,
            tramitealtalicencia_propietariopersonaid,
            tramitealtalicencia_comodatariopersonaid,
            tramitealtalicencia_nombregenerico,
            tramitealtalicencia_giro,
            tramitealtalicencia_domicilio,
            tramitealtalicencia_coloniaid,
            tramitealtalicencia_municipioid,
            tramitealtalicencia_entrecalle,
            tramitealtalicencia_yentrecalle,
            tramitealtalicencia_latitud,
            tramitealtalicencia_longitud,
            tramitealtalicencia_tramitevuid
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(folioid),0) + 1 folioid
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folioid),
			(select folio from (
				select concat('CA/A/',LPAD(ifnull(max(folioid),0) + 1,4,'0'),'-',(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)) folio
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folio),
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".(($personaid == '' or $personaid == 0)?'null':$personaid).",
            ".(($personaidcomodatario == '' or $personaidcomodatario == 0)?'null':$personaidcomodatario).",
            '".$nombregenerico."',
            ".$giroid.",
            '".$domiciliolic."',
            ".$coloniaid.",
            ".$municipioid.",
            '".$entrecalle."',
            '".$yentrecalle."',
            '".$latitud."',
            '".$longitud."',
            ".$vuid."
        )
        ";*/
        $db->Insert($sql);
        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];
        $usuario = ($usuarioid == 'null' or $usuarioid == '')?$correousuario:catalogos::getnombreusuariobyid($usuarioid);

        $folio = tramite::getfoliotramite($vuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE LICENCIA CON FOLIO: '.$folio,$usuario,$vuid,'global_tramitevu');

        return $lastinsert;
    }
	
	# Función para traer información acerca de los pagos de la licencia
	function getinfo_pagos($tramitevu_id) {
		$db = new DB();
		$sql = "SELECT * FROM global_tramitevu WHERE tramitevu_id = ".$tramitevu_id;
		$res = $db->Ejecuta($sql);
        return $res;
	}
	
	# Función para guardar información de los pagos
	function guardarinfopagos($tramitevuid, $fechaprimerpago, $montoprimerpago, $fechasegundopago, $montosegundopago) {
		$db = new DB();
		$sql = "UPDATE global_tramitevu SET tramitevu_fechapago = ".$fechaprimerpago.", tramitevu_montopago = ".$montoprimerpago.", tramitevu_fechatotalpago = ".$fechasegundopago.", tramitevu_montototalpago = ".$montosegundopago." 
		WHERE tramitevu_id = ".$tramitevuid;
		file_put_contents('qqqqqq.txt', $sql);
        $db->Insert($sql);
        $db->close();
	}
	
    //Guarda Trámite licencia provisional
    function guardarsolicitudlicenciaprovisional(
        $tipoevento,
        $giroid,
        $fechai,
        $fechaf,
        $horario,
        $horariofin,
        $descripcion,
        $personaid,
        $domiciliolic,
        $domiciliolicnumext,
        $municipioid,
        $coloniaid,
        $entrecalle,
        $yentrecalle,
        $latitud,
        $longitud,
        $vuid,
        $usuarioid,
        $usuarionombre,
        $correousuario,
        $rfcusuario
    ){

        $db = new DB();
        $sql = "
        insert into global_tramitealtalicenciaprovisional
        (
            tramitealtalicenciaprovisional_id,
            tramitealtalicenciaprovisional_ciclo,
            tramitealtalicenciaprovisional_propietariopersonaid,
            tramitealtalicenciaprovisional_tipoevento,
			tramitealtalicenciaprovisional_giro,
            tramitealtalicenciaprovisional_fechai,
            tramitealtalicenciaprovisional_fechaf,
            tramitealtalicenciaprovisional_horario,
            tramitealtalicenciaprovisional_horariofin,
            tramitealtalicenciaprovisional_descripcion,
            tramitealtalicenciaprovisional_domicilio,
            tramitealtalicenciaprovisional_domicilio_numext,
            tramitealtalicenciaprovisional_coloniaid,
            tramitealtalicenciaprovisional_municipioid,
            tramitealtalicenciaprovisional_entrecalle,
            tramitealtalicenciaprovisional_yentrecalle,
            tramitealtalicenciaprovisional_latitud,
            tramitealtalicenciaprovisional_longitud,
            tramitealtalicenciaprovisional_tramitevuid
        )
        values
        (
            null,
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".(($personaid == '' or $personaid == 0)?'null':$personaid).",
            '".mb_strtoupper($tipoevento)."',
			".$giroid.",
            '".$fechai."',
            '".$fechaf."',
            '".$horario."',
            '".$horariofin."',
            '".mb_strtoupper($descripcion)."',
            '".mb_strtoupper($domiciliolic)."',
            '".mb_strtoupper($domiciliolicnumext)."',
            ".$coloniaid.",
            ".$municipioid.",
            '".mb_strtoupper($entrecalle)."',
            '".mb_strtoupper($yentrecalle)."',
            '".$latitud."',
            '".$longitud."',
            ".$vuid."
        )
        ";
        $db->Insert($sql);
        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = ($usuarioid == 'null' or $usuarioid == '')?$correousuario:catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($vuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE PERMISO ESPECIAL CON FOLIO: '.$folio,$usuario,$vuid,'global_tramitevu');

        return $lastinsert;
    }
	
	# Función para traer los montos del primer pago según el trámite
	function get_primer_pago($tipo_tramite_id, $year) {
		$db = new DB();
		$sql = "SELECT CONCAT('ENERO') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-01%')
		UNION
		SELECT CONCAT('FEBRERO') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-02%')
		UNION
		SELECT CONCAT('MARZO') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-03%')
		UNION
		SELECT CONCAT('ABRIL') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-04%')
		UNION
		SELECT CONCAT('MAYO') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-05%')
		UNION
		SELECT CONCAT('JUNIO') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-06%')
		UNION
		SELECT CONCAT('JULIO') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-07%')
		UNION
		SELECT CONCAT('AGOSTO') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-08%')
		UNION
		SELECT CONCAT('SEPTIEMBRE') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-09%')
		UNION
		SELECT CONCAT('OCTUBRE') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-10%')
		UNION
		SELECT CONCAT('NOVIEMBRE') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-11%')
		UNION
		SELECT CONCAT('DICIEMBRE') AS mes, COALESCE(SUM(tramitevu_montopago),0) AS primer_pago FROM global_tramitevu 
		WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechapago LIKE '$year-12%')";
		$res = $db->Ejecuta($sql);
		return $res;
	}
	
	# Función para traer los montos del segundo pago según el trámite
	function get_segundo_pago($tipo_tramite_id, $year) {
		$db = new DB();
		$sql = "SELECT CONCAT('ENERO') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-01%')
		UNION
		SELECT CONCAT('FEBRERO') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-02%')
		UNION
		SELECT CONCAT('MARZO') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-03%')
		UNION
		SELECT CONCAT('ABRIL') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-04%')
		UNION
		SELECT CONCAT('MAYO') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-05%')
		UNION
		SELECT CONCAT('JUNIO') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-06%')
		UNION
		SELECT CONCAT('JULIO') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-07%')
		UNION
		SELECT CONCAT('AGOSTO') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-08%')
		UNION
		SELECT CONCAT('SEPTIEMBRE') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-09%')
		UNION
		SELECT CONCAT('OCTUBRE') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-10%')
		UNION
		SELECT CONCAT('NOVIEMBRE') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-11%')
		UNION
		SELECT CONCAT('DICIEMBRE') AS mes, COALESCE(SUM(tramitevu_montototalpago),0) AS segundo_pago 
		FROM global_tramitevu WHERE (tramitevu_tipotramiteid = $tipo_tramite_id AND tramitevu_fechatotalpago LIKE '$year-12%')";
		$res = $db->Ejecuta($sql);
		return $res;
	}
	
	# Función para traer la sumatoria total por meses de los trámites realizados durante el año
	function get_sumatoria_total_pagos($year) {
		$db = new DB();
		$sql = "SELECT CONCAT('ENERO') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu WHERE tramitevu_fechatotalpago LIKE '$year-01%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-01%')) AS total_pagos
		UNION
		SELECT CONCAT('FEBRERO') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-02%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-02%')) AS total_pagos
		UNION
		SELECT CONCAT('MARZO') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-03%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-03%')) AS total_pagos
		UNION
		SELECT CONCAT('ABRIL') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-04%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-04%')) AS total_pagos
		UNION
		SELECT CONCAT('MAYO') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-05%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-05%')) AS total_pagos
		UNION
		SELECT CONCAT('JUNIO') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-06%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-06%')) AS total_pagos
		UNION
		SELECT CONCAT('JULIO') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-07%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-07%')) AS total_pagos
		UNION
		SELECT CONCAT('AGOSTO') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-08%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-08%')) AS total_pagos
		UNION
		SELECT CONCAT('SEPTIEMBRE') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-09%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-09%')) AS total_pagos
		UNION
		SELECT CONCAT('OCTUBRE') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu 
		WHERE tramitevu_fechatotalpago LIKE '$year-10%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-10%')) AS total_pagos
		UNION
		SELECT CONCAT('NOVIEMBRE') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu WHERE tramitevu_fechatotalpago LIKE '$year-11%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-11%')) AS total_pagos
        UNION
        SELECT CONCAT('DICIEMBRE') AS mes, ((SELECT COALESCE(SUM(tramitevu_montototalpago),0) AS total_pagos FROM global_tramitevu WHERE tramitevu_fechatotalpago LIKE '$year-12%')  +(SELECT COALESCE(SUM(tramitevu_montopago),0) AS total_pagos 
		FROM global_tramitevu WHERE tramitevu_fechapago LIKE '$year-12%')) AS total_pagos";
		$res = $db->Ejecuta($sql);
		return $res;
	}
	
	// Función para actualizar el campo de mostrar trámite en la coordinación de alcoholes
	function update_mostrar_coordinacion($tramitevu_id) {
		$sql = "UPDATE global_tramitevu SET tramitevu_mostrar = 1, tramitevu_fecha_enviado_revision = NOW()
		WHERE tramitevu_id = ".$tramitevu_id;
        $db = new DB();
        $db->Insert($sql);
        $db->close();
	}

    //Guarda Solicitud de Cambios
    function guardarcambios(
        $licenciaid,
        $subtramites,
        $domiciliolic,
		$domiciliolicnumext,
        $coloniaid,
        $estadoid,
        $municipioid,
        $entrecalle,
        $yentrecalle,
        $latitud,
        $longitud,
        $adomiciliolic,
        $acoloniaid,
        $aestadoid,
        $amunicipioid,
        $aentrecalle,
        $ayentrecalle,
        $alatitud,
        $alongitud,
        $panteriorid,
        $pnuevoid,
        $canteriorid,
        $cnuevoid,
        $nombreganterior,
        $nombregnuevo,
        $giroanteriorid,
        $giroid,
        $usuarioid,
        $tramitevuid,
        $usuarionombre,
        $correousuario,
        $rfcusuario,
		$tipolicenciaid,
		$folio_licencia
    ){
		if($tipolicenciaid != '' && $tipolicenciaid != 'null') {
			$num_licencia = $folio_licencia;
		}
		else {
			$num_licencia = 'null';
		}
        $db = new DB();
        $sql = "
            insert into global_tramitecambio
            (
                tramitecambio_id,
                tramitecambio_ciclo,
                tramitecambio_licenciaid,
                tramitecambio_domicilionuevo,
                tramitecambio_domicilionuevo_numext,
                tramitecambio_domiciliocoloniaidnuevo,
                tramitecambio_domicilioestadoidnuevo,
                tramitecambio_domiciliomunicipioidnuevo,
                tramitecambio_domicilioentrecallenuevo,
                tramitecambio_domicilioyentrecallenuevo,
                tramitecambio_domiciliolatitudnuevo,
                tramitecambio_domiciliolongitudnuevo,
                tramitecambio_domicilioanterior,
                tramitecambio_domiciliocoloniaidanterior,
                tramitecambio_domicilioestadoidanterior,
                tramitecambio_domiciliomunicipioidanterior,
                tramitecambio_domicilioentrecalleanterior,
                tramitecambio_domicilioyentrecalleanterior,
                tramitecambio_domiciliolatitudanterior,
                tramitecambio_domiciliolongitudanterior,
                tramitecambio_propietarioidanterior,
                tramitecambio_propietarioidnuevo,
                tramitecambio_comodatarioidanterior,
                tramitecambio_comodatarioidnuevo,
                tramitecambio_nombreanterior,
                tramitecambio_nombrenuevo,
                tramitecambio_giroidanterior,
                tramitecambio_giroidnuevo,
                tramitecambio_usuarioid,
                tramitecambio_tiposubtramiteids,
                tramitecambio_tramitevuid,
				tramitecambio_tipo_licencia_id,
				tramitecambio_folio_licencia_anterior
            )
            values
            (
                null,
                (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
                ".$licenciaid.",
                '".mb_strtoupper($domiciliolic)."',
                '".mb_strtoupper($domiciliolicnumext)."',
                ".$coloniaid.",
                ".$estadoid.",
                ".$municipioid.",
                '".mb_strtoupper($entrecalle)."',
                '".mb_strtoupper($yentrecalle)."',
                ".(($latitud=='')?'null':"'".$latitud."'").",
                ".(($longitud=='')?'null':"'".$longitud."'").",
                '".mb_strtoupper($adomiciliolic)."',
                ".(($acoloniaid='' or $acoloniaid='null' )?'null':$acoloniaid).",
                ".$aestadoid.",
                ".$amunicipioid.",
                '".mb_strtoupper($aentrecalle)."',
                '".mb_strtoupper($ayentrecalle)."',
                ".(($alatitud=='')?'null':"'".$alatitud."'").",
                ".(($alongitud=='')?'null':"'".$alongitud."'").",
                ".$panteriorid.",
                ".$pnuevoid.",
                ".(($canteriorid=='')?'null':$canteriorid).",
                ".$cnuevoid.",
                '".mb_strtoupper($nombreganterior)."',
                '".mb_strtoupper($nombregnuevo)."',
                ".$giroanteriorid.",
                ".$giroid.",
                ".$usuarioid.",
                '".$subtramites."',
                ".$tramitevuid.",
				".$tipolicenciaid.",
				'".$num_licencia."'
            )

        ";
        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = ($usuarioid == 'null' or $usuarioid == '')?$correousuario:catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE CAMBIO CON FOLIO: '.$folio,$usuario,$tramitevuid,'global_tramitevu');

        return $lastinsert;
    }
    //Guarda Trámite Cambio Giro
    function guardarcambiogiro($tramitevuid, $licenciaid, $giroidanterior, $giroidnuevo, $usuarioid){

        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_tramitecambiogiro
        (
            tramitecambiogiro_id,
            tramitecambiogiro_folioid,
            tramitecambiogiro_folio,
            tramitecambiogiro_ciclo,
            tramitecambiogiro_licenciaid,
            tramitecambiogiro_giroidanterior,
            tramitecambiogiro_giroidnuevo,
            tramitecambiogiro_usuarioid,
            tramitecambiogiro_tramitevuid
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(folioid),0) + 1 folioid
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folioid),
			(select folio from (
				select concat('CA/C/',LPAD(ifnull(max(folioid),0) + 1,4,'0'),'-',(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)) folio
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folio),
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".$licenciaid.",
            ".$giroidanterior.",
            ".$giroidnuevo.",
            ".$usuarioid.",
            ".(($tramitevuid=='')?'null':$tramitevuid)."

        )
        ";

        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE CAMBIO DE GIRO CON FOLIO: '.$folio,$usuario,$tramitevuid);

        return $lastinsert;

    }

    //Guarda Trámite Refrendo
    function guardarrefrendo($tramitevuid, $licenciaid, $fechapago, $usuarioid,$usuarionombre,$correousuario,$rfcusuario){

        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_tramiterefrendo
        (
            tramiterefrendo_id,
            tramiterefrendo_folioid,
            tramiterefrendo_folio,
            tramiterefrendo_ciclo,
            tramiterefrendo_licenciaid,
            tramiterefrendo_fechapago,
            tramiterefrendo_usuarioid,
            tramiterefrendo_tramitevuid
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(folioid),0) + 1 folioid
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folioid),
			(select folio from (
				select concat('CA/C/',LPAD(ifnull(max(folioid),0) + 1,4,'0'),'-',(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)) folio
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folio),
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".$licenciaid.",
            '".$fechapago."',
            ".$usuarioid.",
            ".(($tramitevuid=='')?'null':$tramitevuid)."

        )
        ";

        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = ($usuarioid == 'null' or $usuarioid == '')?$correousuario:catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE REFRENDO CON FOLIO: '.$folio,$usuario,$tramitevuid,'global_tramitevu');

        return $lastinsert;

    }

    //Guarda Trámite Cambio Nombre Generico
    function guardarcambionombregenerico($tramitevuid, $licenciaid, $nombreganterior, $nombregnuevo, $usuarioid){

        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_tramitecambionombregenerico
        (
            tramitecambionombregenerico_id,
            tramitecambionombregenerico_folioid,
            tramitecambionombregenerico_folio,
            tramitecambionombregenerico_ciclo,
            tramitecambionombregenerico_licenciaid,
            tramitecambionombregenerico_nombreanterior,
            tramitecambionombregenerico_nombrenuevo,
            tramitecambionombregenerico_usuarioid,
            tramitecambionombregenerico_tramitevuid
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(folioid),0) + 1 folioid
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folioid),
			(select folio from (
				select concat('CA/C/',LPAD(ifnull(max(folioid),0) + 1,4,'0'),'-',(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)) folio
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folio),
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".$licenciaid.",
            '".$nombreganterior."',
            '".$nombregnuevo."',
            ".$usuarioid.",
            ".(($tramitevuid=='')?'null':$tramitevuid)."

        )
        ";

        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE CAMBIO DE NOMBRE GENÉRICO CON FOLIO: '.$folio,$usuario,$tramitevuid);

        return $lastinsert;

    }


    //Guarda Trámite Cambio Popietario
    function guardarcambiopropietario($tramitevuid, $licenciaid, $pidanterior, $pidnuevo, $usuarioid){

        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_tramitecambiopropietario
        (
            tramitecambiopropietario_id,
            tramitecambiopropietario_folioid,
            tramitecambiopropietario_folio,
            tramitecambiopropietario_ciclo,
            tramitecambiopropietario_licenciaid,
            tramitecambiopropietario_propietarioidanterior,
            tramitecambiopropietario_propietarioidnuevo,
            tramitecambiopropietario_usuarioid,
            tramitecambiopropietario_tramitevuid
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(folioid),0) + 1 folioid
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folioid),
			(select folio from (
				select concat('CA/C/',LPAD(ifnull(max(folioid),0) + 1,4,'0'),'-',(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)) folio
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folio),
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".$licenciaid.",
            ".$pidanterior.",
            ".$pidnuevo.",
            ".$usuarioid.",
            ".(($tramitevuid=='')?'null':$tramitevuid)."

        )
        ";

        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE CAMBIO DE PROPIETARIO CON FOLIO: '.$folio,$usuario,$tramitevuid);

        return $lastinsert;
    }

    //Guarda Trámite Cambio Comodatario
    function guardarcambiocomodatario($tramitevuid, $licenciaid, $pidanterior, $pidnuevo, $usuarioid){

        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_tramitecambiocomodatario
        (
            tramitecambiocomodatario_id,
            tramitecambiocomodatario_folioid,
            tramitecambiocomodatario_folio,
            tramitecambiocomodatario_ciclo,
            tramitecambiocomodatario_licenciaid,
            tramitecambiocomodatario_comodatarioidanterior,
            tramitecambiocomodatario_comodatarioidnuevo,
            tramitecambiocomodatario_usuarioid,
            tramitecambiocomodatario_tramitevuid
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(folioid),0) + 1 folioid
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folioid),
			(select folio from (
				select concat('CA/C/',LPAD(ifnull(max(folioid),0) + 1,4,'0'),'-',(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)) folio
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folio),
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".$licenciaid.",
            ".(($pidanterior=='')?'null':$pidanterior).",
            ".$pidnuevo.",
            ".$usuarioid.",
            ".(($tramitevuid=='')?'null':$tramitevuid)."

        )
        ";

        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE CAMBIO DE COMODATARIO CON FOLIO: '.$folio,$usuario,$tramitevuid);

        return $lastinsert;
    }
	
	// Función para actualizar el folio del trámite
	function actualizafoliotramite($tabla, $tramitevuid, $foliotramite) {
		$db = new DB();
		// Licencias
		if($tabla == 'global_tramitealtalicencia') {
			$sql = "UPDATE global_tramitealtalicencia 
			SET tramitealtalicencia_folio = '".$foliotramite."'
			WHERE tramitealtalicencia_tramitevuid = ".$tramitevuid;
			$db->Insert($sql);
        }
		// Cambio en licencia existente
		else if($tabla == 'global_tramitecambio') {
			$sql = "UPDATE global_tramitecambio
			SET tramitecambio_folio = '".$foliotramite."'
			WHERE tramitecambio_tramitevuid = ".$tramitevuid;
			$db->Insert($sql);
		}
		// Permiso especial
		else if($tabla == 'global_tramitealtalicenciaprovisional') {
			$sql = "UPDATE global_tramitealtalicenciaprovisional
			SET tramitealtalicenciaprovisional_folio = '".$foliotramite."' 
			WHERE tramitealtalicenciaprovisional_tramitevuid = ".$tramitevuid;
			$db->Insert($sql);
		}
		return "Folio actualizado exitosamente";
	}
	
	// Función para traer el folio del trámite 
	function get_folio_tramite($tabla, $tramitevuid) {
		$db = new DB();
		if($tabla == 'global_tramitealtalicencia') {
			$sql = "SELECT tramitealtalicencia_folio as folio_tramite
			FROM global_tramitealtalicencia 
			WHERE tramitealtalicencia_tramitevuid = ".$tramitevuid;	
		}
		else if($tabla == 'global_tramitecambio') {
			$sql = "SELECT tramitecambio_folio as folio_tramite
			FROM global_tramitecambio
			WHERE tramitecambio_tramitevuid = ".$tramitevuid;
		}
		else if($tabla == 'global_tramitealtalicenciaprovisional') {
			$sql = "SELECT tramitealtalicenciaprovisional_folio as folio_tramite
			FROM global_tramitealtalicenciaprovisional 
			WHERE tramitealtalicenciaprovisional_tramitevuid = ".$tramitevuid;
		}
        $res = $db->Ejecuta($sql);
        return $res;
	}

    //Guarda Trámite Cambio Domicilio
    function guardarcambiodomicilio($tramitevuid, $licenciaid, $domiciliolic, $coloniaid, $estadoid, $municipioid, $entrecalle, $yentrecalle, $adomiciliolic, $acoloniaid, $aestadoid, $amunicipioid, $aentrecalle, $ayentrecalle, $latitud, $longitud, $usuarioid){

        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_tramitecambiodomicilio
        (
            tramitecambiodomicilio_id,
            tramitecambiodomicilio_folioid,
            tramitecambiodomicilio_folio,
            tramitecambiodomicilio_ciclo,
            tramitecambiodomicilio_licenciaid,
            tramitecambiodomicilio_domicilionuevo,
            tramitecambiodomicilio_coloniaidnuevo,
            tramitecambiodomicilio_estadoidnuevo,
            tramitecambiodomicilio_municipioidnuevo,
            tramitecambiodomicilio_entrecallenuevo,
            tramitecambiodomicilio_yentrecallenuevo,
            tramitecambiodomicilio_domicilioanterior,
            tramitecambiodomicilio_coloniaidanterior,
            tramitecambiodomicilio_estadoidanterior,
            tramitecambiodomicilio_municipioidanterior,
            tramitecambiodomicilio_entrecalleanterior,
            tramitecambiodomicilio_yentrecalleanterior,
            tramitecambiodomicilio_usuarioid,
            tramitecambiodomicilio_tramitevuid,
            tramitecambiodomicilio_latitud,
            tramitecambiodomicilio_longitud
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(folioid),0) + 1 folioid
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folioid),
			(select folio from (
				select concat('CA/C/',LPAD(ifnull(max(folioid),0) + 1,4,'0'),'-',(SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)) folio
				from vw_folios
				where ciclo = (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1)
			)folio),
            (SELECT ciclo_id FROM conf_ciclo where ciclo_activo = 1),
            ".$licenciaid.",
            '".$domiciliolic."',
            ".(($coloniaid=='')?'null':$coloniaid).",
            ".(($estadoid=='')?'null':$estadoid).",
            ".(($municipioid=='')?'null':$municipioid).",
            '".$entrecalle."',
            '".$yentrecalle."',
            '".$adomiciliolic."',
            ".(($acoloniaid=='')?'null':$acoloniaid).",
            ".(($aestadoid=='')?'null':$aestadoid).",
            ".(($amunicipioid=='')?'null':$amunicipioid).",
            '".$aentrecalle."',
            '".$ayentrecalle."',
            ".$usuarioid.",
            ".(($tramitevuid=='')?'null':$tramitevuid).",
            '".$latitud."',
            '".$longitud."'
        )
        ";

        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        $usuario = catalogos::getnombreusuariobyid($usuarioid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ SOLICITUD DE CAMBIO DE DOMICILIO CON FOLIO: '.$folio,$usuario,$tramitevuid);
        return $lastinsert;
    }


    //Get info tramite by folio
    function getinfotramitebytramitevu($tramiteidvu,$tipotramitevu){
        $sql = "
        SELECT
        vu.*,
        tt.*,
        l.*,
        g.*,
        rp.rfc_rfc rfcp, pp.persona_curp curpp, pp.persona_razonsocial nombrep, pp.persona_direccion direccionp, pp.persona_direccion_numero numext_p, pp.persona_entrecalle entrecallep, pp.persona_yentrecalle yentrecallep, pp.persona_telefono telefonop, pp.persona_celular celularp, pp.persona_correo correop,
        cp.colonia_nombre coloniap, cp.colonia_cp codpp,
        rc.rfc_rfc rfcc, pc.persona_curp curpc, pc.persona_razonsocial nombrec, pc.persona_direccion direccionc, pc.persona_direccion_numero numext_c,pc.persona_entrecalle entrecallec, pc.persona_yentrecalle yentrecallec, pc.persona_telefono telefonoc, pc.persona_celular celularc, pc.persona_correo correoc,
        cc.colonia_nombre coloniac, cc.colonia_cp codpc";
        switch ($tipotramitevu) {
            case 9:
                $sql.= "
                ,cambiodom.colonia_nombre colonianuevo, tt.tramitecambio_comodatarioidanterior
                ,gcambio.giro_nombre girocambio, perac.persona_razonsocial razonsocial_canterior, ccl.colonia_nombre colonia_nombre_negocio
                ,rfc_n.rfc_rfc rfcnuevop, per.persona_curp curpnuevop, per.persona_telefono telnuevop, per.persona_celular celnuevop, per.persona_razonsocial nombrenuevop, per.persona_direccion domicilionuevop, per.persona_direccion_numero domicilionump
                ,rc.rfc_rfc rfcnuevoc, perc.persona_curp curpnuevoc, perc.persona_telefono telnuevoc, perc.persona_celular celnuevoc, perc.persona_razonsocial nombrenuevoc
                ,perc.persona_direccion domicilionuevoc, perc.persona_direccion_numero domicilionuevonumc, tlc.tipolicencia_nombre as tipo_licencia_nuevo
                ,tlc2.tipolicencia_nombre as tipo_licencia_anterior, tt.tramitecambio_domiciliolongitudnuevo as longitud, tt.tramitecambio_domiciliolatitudnuevo as latitud
                ,tt.tramitecambio_nombrenuevo, tt.tramitecambio_domicilionuevo, tt.tramitecambio_domicilionuevo_numext, cambiocom.colonia_nombre colonia_nombre_nc
                ,cambioprop.colonia_nombre colonia_nombre_np
                ";
                break;
            case 7:
                $sql .= " 
                ,tt.tramitealtalicenciaprovisional_folio folio 
                ,tt.tramitealtalicenciaprovisional_tipoevento nombregenerico
                ,tt.tramitealtalicenciaprovisional_latitud latitud
                ,tt.tramitealtalicenciaprovisional_longitud longitud
                ,tt.tramitealtalicenciaprovisional_domicilio domicilio
                ,ubilic.colonia_nombre nombrecolonia";
                break;
            case 6:
                $sql.= " ,cambiodom.colonia_nombre colonianuevo";
                break;
            case 5:
                $sql .= " ,gcambio.giro_nombre girocambio";
                break;
            case 4:
                $sql .= " ,per.persona_rfc rfcnuevop, per.persona_curp curpnuevop, per.persona_telefono telnuevop, per.persona_celular celnuevop, per.persona_nombre nombrenuevop, per.persona_direccion domicilionuevop";
                break;
            case 3:
                $sql .= " ,perc.persona_rfc rfcnuevoc, perc.persona_curp curpnuevoc, perc.persona_telefono telnuevoc, perc.persona_celular celnuevoc, perc.persona_nombre nombrenuevoc, perc.persona_direccion domicilionuevoc";
                break;
            case 1:
                $sql .= " 
                ,tt.tramitealtalicencia_folio folio 
                ,tt.tramitealtalicencia_nombregenerico nombregenerico
                ,tt.tramitealtalicencia_latitud latitud
                ,tt.tramitealtalicencia_longitud longitud
                ,tt.tramitealtalicencia_domicilio domicilio
				,tt.tramitealtalicencia_domicilio_numext domicilionumext
				,ctll.tipolicencia_nombre
                ,ubilic.colonia_nombre nombrecolonia";
                break;
        }

        $sql .= " FROM global_tramitevu vu";
        switch ($tipotramitevu) {
            //Cambio Todos
            case 9:
                $sql.= "
                left join global_tramitecambio tt on tramitecambio_tramitevuid = tramitevu_id
                left join global_licencias l on licencias_id = tramitecambio_licenciaid
                left join cat_colonia cambiodom on cambiodom.colonia_id = tramitecambio_domiciliocoloniaidnuevo
                left join cat_giro gcambio on gcambio.giro_id = tramitecambio_giroidnuevo
                left join cat_persona per on per.persona_id = tramitecambio_propietarioidnuevo
                left join cat_persona perc on perc.persona_id = tramitecambio_comodatarioidnuevo
				left join cat_rfc rfc_n on rfc_n.rfc_id = per.persona_rfcid
				left join cat_colonia cambiocom on cambiocom.colonia_id = perc.persona_colonia
				left join cat_colonia cambioprop on cambioprop.colonia_id = per.persona_colonia
				left join cat_tipolicencia tlc on tlc.tipolicencia_id = tramitecambio_tipo_licencia_id 
				left join cat_tipolicencia tlc2 on tlc2.tipolicencia_id = l.licencias_tipolicencia
				left join cat_persona perac on perac.persona_id = tt.tramitecambio_comodatarioidanterior
				left join cat_colonia ccl on ccl.colonia_id = l.licencias_coloniaid
                ";
                break;
            //Permiso
            case 7:
                $sql.= " left join global_tramitealtalicenciaprovisional tt on tramitealtalicenciaprovisional_tramitevuid = tramitevu_id
                left join (select gtl.*, gtl.tramitealtalicenciaprovisional_giro licencias_giro, gtl.tramitealtalicenciaprovisional_propietariopersonaid licencias_propietariopersonaid, 'null' licencias_comodatariopersonaid from global_tramitealtalicenciaprovisional gtl) l on l.tramitealtalicenciaprovisional_id = tt.tramitealtalicenciaprovisional_id
                left join cat_colonia ubilic on ubilic.colonia_id = l.tramitealtalicenciaprovisional_coloniaid
                ";
                break;
            //Cambio Domicilio
            case 6:
                $sql.= " left join global_tramitecambiodomicilio tt on tramitecambiodomicilio_tramitevuid = tramitevu_id
                left join global_licencias l on licencias_id = tramitecambiodomicilio_licenciaid
                left join cat_colonia cambiodom on cambiodom.colonia_id = tramitecambiodomicilio_coloniaidnuevo
                ";
                break;
            //Cambio Giro
            case 5:
                $sql.= " left join global_tramitecambiogiro tt on tramitecambiogiro_tramitevuid = tramitevu_id
                left join global_licencias l on licencias_id = tramitecambiogiro_licenciaid
                left join cat_giro gcambio on gcambio.giro_id = tramitecambiogiro_giroidnuevo
                ";
                break;
            //Cambio Propietario
            case 4:
                $sql.= " left join global_tramitecambiopropietario tt on tramitecambiopropietario_tramitevuid = tramitevu_id
                left join global_licencias l on licencias_id = tramitecambiopropietario_licenciaid
                left join cat_persona per on per.persona_id = tramitecambiopropietario_propietarioidnuevo
                ";
                break;
            //Cambio Comodatario
            case 3:
                $sql.= " left join global_tramitecambiocomodatario tt on tramitecambiocomodatario_tramitevuid = tramitevu_id
                left join global_licencias l on licencias_id = tramitecambiocomodatario_licenciaid
                left join cat_persona perc on perc.persona_id = tramitecambiocomodatario_comodatarioidnuevo
                ";
                break;
            //Cambio Nombre Genérico
            case 2:
                $sql.= " left join global_tramitecambionombregenerico tt on tramitecambionombregenerico_tramitevuid = tramitevu_id
                left join global_licencias l on licencias_id = tramitecambionombregenerico_licenciaid";
                break;
            //Solicitud Licencia
            case 1:
                $sql.= " left join global_tramitealtalicencia tt on tramitealtalicencia_tramitevuid = tramitevu_id
                left join (select gtl.*, gtl.tramitealtalicencia_giro licencias_giro, gtl.tramitealtalicencia_propietariopersonaid licencias_propietariopersonaid, gtl.tramitealtalicencia_comodatariopersonaid licencias_comodatariopersonaid from global_tramitealtalicencia gtl) l on l.tramitealtalicencia_id = tt.tramitealtalicencia_id
                left join cat_colonia ubilic on ubilic.colonia_id = l.tramitealtalicencia_coloniaid
				left join cat_tipolicencia ctll on ctll.tipolicencia_id = tt.tramitealtalicencia_tipo_licencia_id";
                break;
        }
        $sql .= "
        left join cat_giro g on g.giro_id = l.licencias_giro
        left join cat_persona pp on pp.persona_id = l.licencias_propietariopersonaid
        left join cat_rfc rp on rp.rfc_id = pp.persona_rfcid
        left join cat_colonia cp on cp.colonia_id = pp.persona_colonia
        left join cat_persona pc on pc.persona_id = l.licencias_comodatariopersonaid
        left join cat_rfc rc on rc.rfc_id = pc.persona_rfcid
        left join cat_colonia cc on cc.colonia_id = pc.persona_colonia
        ";
        $sql .= " where tramitevu_id = ".$tramiteidvu."";
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function crearlicenciabysolicitudlicencia($tipolicencia,$numlicencia,$fechaalta,$tramitevuid){
        $sql = "
        insert into global_licencias
            (
                licencias_fechaalta,
                licencias_licencia,
                licencias_tipolicencia,
                licencias_propietariopersonaid,
                licencias_comodatariopersonaid,
                licencias_nombregenerico,
                licencias_giro,
                licencias_domicilio,
				licencias_domicilio_numext,
                licencias_coloniaid,
                licencias_municipioid,
                licencias_entrecalle,
                licencias_yentrecalle,
                licencias_latitud,
                licencias_longitud
            )
            select
                '".$fechaalta."',
                ".$numlicencia.",
                ".$tipolicencia.",
                tramitealtalicencia_propietariopersonaid,
                tramitealtalicencia_comodatariopersonaid,
                tramitealtalicencia_nombregenerico,
                tramitealtalicencia_giro,
                tramitealtalicencia_domicilio,
				tramitealtalicencia_domicilio_numext,
                tramitealtalicencia_coloniaid,
                tramitealtalicencia_municipioid,
                tramitealtalicencia_entrecalle,
                tramitealtalicencia_yentrecalle,
                tramitealtalicencia_latitud,
                tramitealtalicencia_longitud
            from global_tramitealtalicencia
            where tramitealtalicencia_tramitevuid = ".$tramitevuid."
        ";
        $db = new DB();
        $res = $db->Insert($sql);
		/*
        //consulta lastid licencia
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        //update tramite licenciaid fechapago y monto pago
        $sql3 = "
        update global_tramitevu set
        tramitevu_licenciaid  = ".$lastinsert.",
        tramitevu_fechapago = '".$fechapago."',
        tramitevu_montopago = '".$montopago."',
        tramitevu_aplicado = 1
        where
        tramitevu_id = ".$tramitevuid."
        ";
        $db->Insert($sql3);*/
    }


    function crearpermisobysolicitudpermiso($numpermiso,$fechaalta,$tramitevuid){
        $sql = "
        insert into global_permisos
            (
                permisos_fechaalta,
                permisos_folio,
                permisos_propietariopersonaid,
                permisos_tipoevento,
                permisos_fechai,
                permisos_fechaf,
                permisos_horario,
                permisos_horariofin,
                permisos_descripcion,
                permisos_giro,
                permisos_domicilio,
                permisos_coloniaid,
                permisos_municipioid,
                permisos_entrecalle,
                permisos_yentrecalle,
                permisos_latitud,
                permisos_longitud
            )
            select
                '".$fechaalta."',
                ".$numpermiso.",
                tramitealtalicenciaprovisional_propietariopersonaid,
                tramitealtalicenciaprovisional_tipoevento,
                tramitealtalicenciaprovisional_fechai,
                tramitealtalicenciaprovisional_fechaf,
                tramitealtalicenciaprovisional_horario,
                tramitealtalicenciaprovisional_horariofin,
                tramitealtalicenciaprovisional_descripcion,
                tramitealtalicenciaprovisional_giro,
                tramitealtalicenciaprovisional_domicilio,
                tramitealtalicenciaprovisional_coloniaid,
                tramitealtalicenciaprovisional_municipioid,
                tramitealtalicenciaprovisional_entrecalle,
                tramitealtalicenciaprovisional_yentrecalle,
                tramitealtalicenciaprovisional_latitud,
                tramitealtalicenciaprovisional_longitud
            from global_tramitealtalicenciaprovisional
            where tramitealtalicenciaprovisional_tramitevuid = ".$tramitevuid."
        ";
        $db = new DB();
        $res = $db->Insert($sql);

      /*  //consulta lastid licencia
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        //update tramite licenciaid fechapago y monto pago
        $sql3 = "
        update global_tramitevu set
        tramitevu_licenciaid  = ".$lastinsert.",
        tramitevu_fechapago = '".$fechapago."',
        tramitevu_montopago = '".$montopago."',
        tramitevu_aplicado = 1
        where
        tramitevu_id = ".$tramitevuid."
        ";
        $db->Insert($sql3);*/
    }

    function updatelicenciabysolicitud($tramitevuid, $folionuevo){
        //Consulta infrmación de trámite
        $res = $this->getinfotramitebytramitevu($tramitevuid,9);
        $subtramites = $res[0]['tramitecambio_tiposubtramiteids'];
        $subtramites = explode(",", $subtramites);
        //Update subtrámites
        foreach ($subtramites as $sub){
            switch ($sub){
                //Cambio Domicilio
                case 1:
                    $sql = "
                        update global_tramitecambio tc
                        left join global_licencias l on l.licencias_id = tc.tramitecambio_licenciaid
                        left join global_tramitevu vu on vu.tramitevu_id = tc.tramitecambio_tramitevuid
                        set 
                        l.licencias_domicilio = tc.tramitecambio_domicilionuevo,
						l.licencias_domicilio_numext = tc.tramitecambio_domicilionuevo_numext,
                        l.licencias_coloniaid = tc.tramitecambio_domiciliocoloniaidnuevo,
                        l.licencias_municipioid = tc.tramitecambio_domiciliomunicipioidnuevo,
                        l.licencias_entrecalle = tc.tramitecambio_domicilioentrecallenuevo,
                        l.licencias_yentrecalle = tc.tramitecambio_domicilioyentrecallenuevo,
                        l.licencias_latitud = tc.tramitecambio_domiciliolatitudnuevo,
                        l.licencias_longitud = tc.tramitecambio_domiciliolongitudnuevo
						where tramitevu_id = ".$tramitevuid;
                    $db = new DB();
                    $db->Insert($sql);
                    $db->close();
                    break;
                //Cambio Propietario
                case 2:
                    $sql = "
                        update global_tramitecambio tc
                        left join global_licencias l on l.licencias_id = tc.tramitecambio_licenciaid
                        left join global_tramitevu vu on vu.tramitevu_id = tc.tramitecambio_tramitevuid
                        set 
                        l.licencias_propietariopersonaid = tc.tramitecambio_propietarioidnuevo
                        where tramitevu_id = ".$tramitevuid."
                    ";
                    $db = new DB();
                    $db->Insert($sql);
                    $db->close();
                    break;
                //Cambio Comodatario
                case 3:
                    $sql = "
                        update global_tramitecambio tc
                        left join global_licencias l on l.licencias_id = tc.tramitecambio_licenciaid
                        left join global_tramitevu vu on vu.tramitevu_id = tc.tramitecambio_tramitevuid
                        set 
                        l.licencias_comodatariopersonaid = tc.tramitecambio_comodatarioidnuevo
                        where tramitevu_id = ".$tramitevuid."
                    ";
                    $db = new DB();
                    $db->Insert($sql);
                    $db->close();
                    break;
                //Cambio Nombre Genérico
                case 4:
                    $sql = "
                        update global_tramitecambio tc
                        left join global_licencias l on l.licencias_id = tc.tramitecambio_licenciaid
                        left join global_tramitevu vu on vu.tramitevu_id = tc.tramitecambio_tramitevuid
                        set 
                        l.licencias_nombregenerico = tc.tramitecambio_nombrenuevo
                        where tramitevu_id = ".$tramitevuid."
                    ";
                    $db = new DB();
                    $db->Insert($sql);
                    $db->close();
                    break;
                //Cambio Giro
                case 5:
                    $sql = "
                        update global_tramitecambio tc
                        left join global_licencias l on l.licencias_id = tc.tramitecambio_licenciaid
                        left join global_tramitevu vu on vu.tramitevu_id = tc.tramitecambio_tramitevuid
                        set 
                        l.licencias_giro = tc.tramitecambio_giroidnuevo
                        where tramitevu_id = ".$tramitevuid."
                    ";
                    $db = new DB();
                    $db->Insert($sql);
                    $db->close();
                    break;
                //Cambio Tipo de Licencia
                case 6:
					$sql = "
						update global_tramitecambio tc
                        left join global_licencias l on l.licencias_id = tc.tramitecambio_licenciaid
                        left join global_tramitevu vu on vu.tramitevu_id = tc.tramitecambio_tramitevuid
						set
						l.licencias_tipolicencia = tc.tramitecambio_tipo_licencia_id,
						l.licencias_licencia = '".$folionuevo."' 
						where tramitevu_id = ".$tramitevuid;
					$db = new DB();
                    $db->Insert($sql);
                    $db->close();
                    break;				
            }
        }
        
      /*  //actualizar pago
        //update tramite licenciaid fechapago y monto pago
        $sql = "
        update global_tramitevu set
        tramitevu_fechapago = '".$fechapago."',
        tramitevu_montopago = '".$montopago."',
        tramitevu_aplicado = 1
        where
        tramitevu_id = ".$tramitevuid."
        ";
        $db = new DB();
        $db->Insert($sql);
        $db->close();*/
    }
}
