<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* MODIFICADO: ANGELA SANCHEZ
* Clase Liencias
*********************************************************************************
*/
?>
<?
class licencias{
    //Get query all
    function getqueryall($busqueda){
        $sql = "
            select
            l.*,
            tl.*,
            g.*,
            pp.persona_razonsocial nombrepropietario,
            pc.persona_razonsocial nombrecomodatario,
            c.colonia_nombre, c.colonia_cp,
            z.zona_nombre
            from
            global_licencias l
            left join cat_tipolicencia tl on tipolicencia_id = licencias_tipolicencia
            left join cat_persona pp on pp.persona_id = licencias_propietariopersonaid
            left join cat_rfc rp on rp.rfc_id = pp.persona_rfcid
            left join cat_persona pc on pc.persona_id = licencias_comodatariopersonaid
            left join cat_rfc rc on rc.rfc_id = pc.persona_rfcid
            left join cat_colonia c on colonia_id = licencias_coloniaid
            left join cat_zona z on zona_id = colonia_zonaid
            left join cat_giro g on giro_id = licencias_giro
            where 1 = 1 ";
            if ($busqueda <> ''){
                $res = json_decode(base64_decode($busqueda),true); 
                
                    if ($res['bsqgiroid'] <> '' and $res['bsqgiroid'] <> 'null'){
                        $sql.= " and (giro_id = ".$res['bsqgiroid'].")";
                    }
                    if ($res['bsqpropietario'] <> '' and $res['bsqpropietario'] <> 'null'){
                        $sql.= " and (rp.rfc_rfc like '%".$res['bsqpropietario']."%' or pp.persona_razonsocial like '%".$res['bsqpropietario']."%')";
                    }
                    if ($res['bsqcomodatario'] <> '' and $res['bsqcomodatario'] <> 'null'){
                        $sql.= " and (rc.rfc_rfc like '%".$res['bsqcomodatario']."%' or pc.persona_razonsocial like '%".$res['bsqcomodatario']."%')";
                    }
                    if ($res['bsqnombre'] <> '' and $res['bsqnombre'] <> 'null'){
                        $sql.= " and (l.licencias_nombregenerico like '%".$res['bsqnombre']."%')";
                    }
                    if ($res['bsqtipolicencia'] <> '' and $res['bsqtipolicencia'] <> 'null'){
                        $sql.= " and (tipolicencia_id = ".$res['bsqtipolicencia'].")";
                    }   
                    if ($res['bsqnumlicencia'] <> '' and $res['bsqnumlicencia'] <> 'null'){
                        $sql.= " and (l.licencias_licencia like '%".$res['bsqnumlicencia']."%')";
                    }
                
            }
            $sql.= " order by licencias_id desc
        ";
        
        return $sql;
    }

    //Get query all permisos
    function getqueryallpermisos(){
        $sql = "
            select
            p.*,
            pp.persona_razonsocial nombrepropietario,
            c.colonia_nombre, c.colonia_cp,
            z.zona_nombre
            from
            global_permisos p
            left join cat_persona pp on pp.persona_id = permisos_propietariopersonaid
            left join cat_rfc rp on rp.rfc_id = pp.persona_rfcid
            left join cat_colonia c on colonia_id = permisos_coloniaid
            left join cat_zona z on zona_id = colonia_zonaid
            order by permisos_id desc
        ";
        return $sql;
    }

    //Get info licencia by id
    function getinfobylicenciaid($id){
        $sql = "
            select
            l.*,
            tl.*,
            g.*,
            pp.persona_razonsocial nombrepropietario, rp.rfc_rfc rfcpropietario, pp.persona_curp curppropietario, pp.persona_telefono telefonopropietario, pp.persona_celular celularpropietario, pp.persona_direccion direccionpropietario,
            cp.colonia_nombre coloniapropietario,
            pc.persona_razonsocial nombrecomodatario, rc.rfc_rfc rfccomodatario, pc.persona_curp curpcomodatario, pc.persona_telefono telefonocomodatario, pc.persona_celular celularcomodatario, pc.persona_direccion direccioncomodatario,
            cc.colonia_nombre coloniacomodatario,
            c.colonia_nombre, c.colonia_cp,
            z.zona_nombre
            from
            global_licencias l
            left join cat_tipolicencia tl on tipolicencia_id = licencias_tipolicencia
            left join cat_persona pp on pp.persona_id = licencias_propietariopersonaid
            left join cat_rfc rp on rp.rfc_id = pp.persona_rfcid
            left join cat_colonia cp on cp.colonia_id = pp.persona_colonia
            left join cat_persona pc on pc.persona_id = licencias_comodatariopersonaid
            left join cat_rfc rc on rc.rfc_id = pc.persona_rfcid
            left join cat_colonia cc on cc.colonia_id = pc.persona_colonia
            left join cat_colonia c on c.colonia_id = licencias_coloniaid
            left join cat_zona z on zona_id = c.colonia_zonaid
            left join cat_giro g on giro_id = licencias_giro
            where licencias_id = ".$id."
            order by licencias_id desc
        ";
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
    }

    //Get info permiso by id
    function getinfobypermisoid($id){
        $sql = "
            select
            p.*,
            g.*,
            pp.persona_razonsocial nombrepropietario, rp.rfc_rfc rfcpropietario, pp.persona_curp curppropietario, pp.persona_telefono telefonopropietario, pp.persona_celular celularpropietario, pp.persona_direccion direccionpropietario,
            cp.colonia_nombre coloniapropietario,
            c.colonia_nombre, c.colonia_cp,
            z.zona_nombre
            from
            global_permisos p
            left join cat_persona pp on pp.persona_id = permisos_propietariopersonaid
            left join cat_rfc rp on rp.rfc_id = pp.persona_rfcid
            left join cat_colonia cp on cp.colonia_id = pp.persona_colonia
            left join cat_colonia c on c.colonia_id = permisos_coloniaid
            left join cat_zona z on zona_id = c.colonia_zonaid
            left join cat_giro g on giro_id = permisos_giro
            where permisos_id = ".$id."
        ";
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
    }
	
	# Función para traer la información de cambio del trámite
	function getinfotramitecambio($tramitevu_id) {
		$sql = "SELECT gtc.tramitecambio_licenciaid, gtc.tramitecambio_domicilionuevo, gtc.tramitecambio_folio_licencia_anterior, gtc.tramitecambio_domicilionuevo_numext, gtc.tramitecambio_domiciliocoloniaidnuevo, gtc.tramitecambio_domicilioestadoidnuevo, gtc.tramitecambio_domiciliomunicipioidnuevo, gtc.tramitecambio_domicilioentrecallenuevo, gtc.tramitecambio_domicilioyentrecallenuevo, gtc.tramitecambio_domiciliolatitudnuevo, gtc.tramitecambio_domiciliolongitudnuevo, gtc.tramitecambio_domicilioanterior, gtc.tramitecambio_domiciliocoloniaidanterior, gtc.tramitecambio_domicilioestadoidanterior, gtc.tramitecambio_domiciliomunicipioidanterior, gtc.tramitecambio_domicilioentrecalleanterior, gtc.tramitecambio_domicilioyentrecalleanterior, gtc.tramitecambio_domiciliolatitudanterior, gtc.tramitecambio_domiciliolongitudanterior, gtc.tramitecambio_usuarioid, gtc.tramitecambio_propietarioidanterior, gtc.tramitecambio_propietarioidnuevo, gtc.tramitecambio_comodatarioidanterior, gtc.tramitecambio_comodatarioidnuevo, gtc.tramitecambio_nombreanterior, gtc.tramitecambio_nombrenuevo, gtc.tramitecambio_giroidanterior, gtc.tramitecambio_giroidnuevo, gtc.tramitecambio_tiposubtramiteids, gtc.tramitecambio_tipo_licencia_id, ctl.tipolicencia_nombre, gl.licencias_licencia, cc.colonia_cp, ca.colonia_nombre, cr.rfc_rfc, cp.persona_razonsocial, cp.persona_direccion, cp.persona_direccion_numero, cra.rfc_rfc rfc_propietario_anterior, crc.rfc_rfc rfc_comodatarionuevo, cpc.persona_razonsocial nombre_comodatario, cpc.persona_direccion comodatario_direccion, cpc.persona_direccion_numero comodatario_numero, crca.rfc_rfc rfc_comodatarioanterior, gl.licencias_id, cg.giro_nombre, gl.licencias_tipolicencia, cpa.persona_razonsocial as nombre_propietario_anterior, cpa.persona_direccion direccion_panterior, cpa.persona_direccion_numero numext_panterior, cpca.persona_razonsocial as nombre_anterior_comodatario, cpca.persona_direccion direccion_canterior, cpca.persona_direccion_numero numext_canterior, gtc.tramitecambio_nombreanterior, cpal.persona_razonsocial propietario_licencia, cpal.persona_direccion prop_direccion_licencia, cpal.persona_direccion_numero prop_numext_licencia, crpal.rfc_rfc rfc_propietario_licencia, cpcal.persona_razonsocial comodatario_licencia, cpcal.persona_direccion com_direccion_licencia, cpcal.persona_direccion_numero com_numext_licencia, crpcal.rfc_rfc rfc_comodatario_licencia, gl.licencias_propietariopersonaid, gl.licencias_comodatariopersonaid, ctln.tipolicencia_nombre as tipolicencia_nombre_nuevo
		FROM global_tramitecambio gtc
        LEFT JOIN global_licencias gl ON gl.licencias_id = gtc.tramitecambio_licenciaid
        LEFT JOIN cat_tipolicencia ctl ON ctl.tipolicencia_id = gl.licencias_tipolicencia
		LEFT JOIN cat_tipolicencia ctln ON ctln.tipolicencia_id = gtc.tramitecambio_tipo_licencia_id
		LEFT JOIN cat_colonia cc ON cc.colonia_id = gtc.tramitecambio_domiciliocoloniaidnuevo
		LEFT JOIN cat_colonia ca ON ca.colonia_id = gtc.tramitecambio_domiciliocoloniaidanterior
		LEFT JOIN cat_persona cp ON cp.persona_id = gtc.tramitecambio_propietarioidnuevo
		LEFT JOIN cat_rfc cr ON cr.rfc_id = cp.persona_rfcid
		LEFT JOIN cat_persona cpa ON cpa.persona_id = gtc.tramitecambio_propietarioidanterior
		LEFT JOIN cat_rfc cra ON cra.rfc_id = cpa.persona_rfcid
		LEFT JOIN cat_persona cpc ON cpc.persona_id = gtc.tramitecambio_comodatarioidnuevo
		LEFT JOIN cat_rfc crc ON crc.rfc_id = cpc.persona_rfcid
		LEFT JOIN cat_persona cpca ON cpca.persona_id = gtc.tramitecambio_comodatarioidanterior
		LEFT JOIN cat_rfc crca ON crca.rfc_id = cpca.persona_rfcid
		LEFT JOIN cat_giro cg ON cg.giro_id = gtc.tramitecambio_giroidanterior
		LEFT JOIN cat_persona cpal ON cpal.persona_id = gl.licencias_propietariopersonaid
		LEFT JOIN cat_rfc crpal ON crpal.rfc_id = cpal.persona_rfcid
		LEFT JOIN cat_persona cpcal ON cpcal.persona_id = gl.licencias_comodatariopersonaid
		LEFT JOIN cat_rfc crpcal ON crpcal.rfc_id = cpcal.persona_rfcid
		WHERE gtc.tramitecambio_tramitevuid = ".$tramitevu_id;
		$db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
	}
	
	# Función para traer información del permiso especial
	function getinfopermisoespecial($tramitevu_id) {
		$sql = "SELECT gtalp.tramitealtalicenciaprovisional_propietariopersonaid, gtalp.tramitealtalicenciaprovisional_tipoevento, gtalp.tramitealtalicenciaprovisional_giro, gtalp.tramitealtalicenciaprovisional_fechai, gtalp.tramitealtalicenciaprovisional_fechaf, gtalp.tramitealtalicenciaprovisional_horario, gtalp.tramitealtalicenciaprovisional_descripcion, gtalp.tramitealtalicenciaprovisional_domicilio, gtalp.tramitealtalicenciaprovisional_domicilio_numext, gtalp.tramitealtalicenciaprovisional_coloniaid, gtalp.tramitealtalicenciaprovisional_municipioid, gtalp.tramitealtalicenciaprovisional_entrecalle, gtalp.tramitealtalicenciaprovisional_yentrecalle, gtalp.tramitealtalicenciaprovisional_latitud, gtalp.tramitealtalicenciaprovisional_longitud, gtalp.tramitealtalicenciaprovisional_horariofin, cp.persona_razonsocial, cr.rfc_rfc, cp.persona_direccion, cp.persona_direccion_numero, cc.colonia_cp
		FROM global_tramitealtalicenciaprovisional gtalp
		LEFT JOIN cat_persona cp ON cp.persona_id = gtalp.tramitealtalicenciaprovisional_propietariopersonaid
		LEFT JOIN cat_rfc cr ON cr.rfc_id = cp.persona_rfcid
		LEFT JOIN cat_colonia cc ON cc.colonia_id = gtalp.tramitealtalicenciaprovisional_coloniaid
		WHERE tramitealtalicenciaprovisional_tramitevuid = ".$tramitevu_id;
		$db = new DB();
		$res = $db->Ejecuta($sql);
		return $res;
	}
	
	# Función para traer la información de una alta de licencia 
	function getdatossolicitudlicencia($tramitevu_id) {
		$sql = "SELECT gtal.tramitealtalicencia_propietariopersonaid, gtal.tramitealtalicencia_comodatariopersonaid, gtal.tramitealtalicencia_nombregenerico, gtal.tramitealtalicencia_giro, gtal.tramitealtalicencia_domicilio, gtal.tramitealtalicencia_domicilio_numext, gtal.tramitealtalicencia_coloniaid, gtal.tramitealtalicencia_entrecalle, gtal.tramitealtalicencia_yentrecalle, gtal.tramitealtalicencia_latitud, gtal.tramitealtalicencia_longitud, gtal.tramitealtalicencia_tipo_licencia_id, cpc.persona_razonsocial nombre_comodatario, cpc.persona_direccion direccion_comodatario, cpc.persona_direccion_numero numero_direccion_comodatario, crc.rfc_rfc rfc_comodatario, cpc.persona_rfcid rfc_id_comodatario, cpp.persona_razonsocial nombre_propietario, cpp.persona_direccion direccion_propietario, cpp.persona_direccion_numero numero_direccion_propietario, cpp.persona_rfcid rfc_id_propietario, crp.rfc_rfc rfc_propietario, gtal.tramitealtalicencia_coloniaid, cc.colonia_cp
		FROM global_tramitealtalicencia gtal
		LEFT JOIN cat_persona cpc ON cpc.persona_id = gtal.tramitealtalicencia_comodatariopersonaid
        LEFT JOIN cat_rfc crc ON crc.rfc_id = cpc.persona_rfcid
        LEFT JOIN cat_persona cpp ON cpp.persona_id = gtal.tramitealtalicencia_propietariopersonaid
        LEFT JOIN cat_rfc crp ON crp.rfc_id = cpp.persona_rfcid
		LEFT JOIN cat_colonia cc ON cc.colonia_id = gtal.tramitealtalicencia_coloniaid
		WHERE tramitealtalicencia_tramitevuid = ".$tramitevu_id;
		$db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
	}

    //Guarda Licencia
    function guardalicencia(
		$fechaalta,
        $foliolicencia,
        $nombregenerico,
        $giroid,
        $personaid,
        $personaidcomodatario,
        $domiciliolic,
        $numeroext,
        $municipioid,
        $coloniaid,
        $entrecalle,
        $yentrecalle,
        $latitud,
        $longitud,
        $usuarioid
    ){
		$tipolicencia = mb_strtoupper(substr($foliolicencia,0,4));
		$folio_licencia = substr($foliolicencia,4);
		if($tipolicencia == "ALCC") {
			$licencias_tipolicencia = 1;
		}
		else if($tipolicencia == "ALCA") {
			$licencias_tipolicencia = 2;
		}
        //Guarda Licencia
        $db = new DB();
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
        values
        (
			'".$fechaalta."',
            '".$folio_licencia."',
			".$licencias_tipolicencia.",
            ".(($personaid == '' or $personaid == 0)?'null':$personaid).",
            ".(($personaidcomodatario =='' or $personaidcomodatario == 0)?'null':$personaidcomodatario).",
            '".$nombregenerico."',
            ".$giroid.",
            '".$domiciliolic."',
            ".$numeroext.",
            ".$coloniaid.",
            ".$municipioid.",
            '".$entrecalle."',
            '".$yentrecalle."',
            '".$latitud."',
            '".$longitud."'
        )
        ";
        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        return $lastinsert;
    }

    function update(
                    $licenciaid,
                    $pnuevoid,
                    $cnuevoid,
                    $nombregnuevo,
                    $giroid,
                    $adomiciliolic,
                    $acoloniaid,
                    $aentrecalle,
                    $ayentrecalle,
                    $alatitud,
                    $alongitud,
                    $tipolicenciaid
                )
                {
        $sql="
        update global_licencias
        set
            licencias_propietariopersonaid = ".$pnuevoid.",
            licencias_comodatariopersonaid = ".$cnuevoid.",
            licencias_nombregenerico = ".$nombregnuevo.",
            licencias_giro = ".$giroid.",
            licencias_domicilio = ".$adomiciliolic.",
            licencias_coloniaid = ".$acoloniaid.",
            licencias_entrecalle = ".$aentrecalle.",
            licencias_yentrecalle = ".$ayentrecalle.",
            licencias_latitud = ".$alatitud.",
            licencias_longitud = ".$alongitud.",
            licencias_tipolicencia =".$tipolicenciaid."
        where licencias_id = ".$licenciaid."
        ";
        //  var_dump($sql);die;
        var_dump($sql);
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
        
    }
	
	# Función para saber si ya hay un trámite para esta licencia en específico
	function getexistenciatramitecambio($num_licencia) {
		$sql = "SELECT * FROM global_tramitecambio gtc
		LEFT JOIN global_licencias gl ON gl.licencias_id = gtc.tramitecambio_licenciaid
		LEFT JOIN cat_tipolicencia ctl ON ctl.tipolicencia_id = gl.licencias_tipolicencia
		LEFT JOIN global_tramitevu gtv ON gtv.tramitevu_id = gtc.tramitecambio_tramitevuid
		WHERE CONCAT(ctl.tipolicencia_nombre, gl.licencias_licencia) = '".$num_licencia."'
		AND gtv.tramitevu_statusid != 3 AND gtv.tramitevu_statusid != 4 AND gtv.tramitevu_statusid IS NOT NULL";
		$db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
	}
	
    function getalllicencias($licencia){
        $sql = "
            select
            tl.*,
            l.*,
            c.*,
            g.*,
            perp.persona_id pid,
            rp.rfc_rfc prfc,
            perp.persona_razonsocial pnombre,
            perc.persona_id cid,
            rc.rfc_rfc crfc,
            perc.persona_razonsocial cnombre
            from
            global_licencias l
            left join cat_tipolicencia tl on licencias_tipolicencia = tipolicencia_id
            left join cat_giro g on giro_id = licencias_giro
            left join cat_persona perp on perp.persona_id = licencias_propietariopersonaid
            left join cat_rfc rp on rp.rfc_id = perp.persona_rfcid
            left join cat_persona perc on perc.persona_id = licencias_comodatariopersonaid
            left join cat_rfc rc on rc.rfc_id = perc.persona_rfcid
            left join cat_colonia c on colonia_id = licencias_coloniaid
            where concat(tipolicencia_nombre,licencias_licencia) like '%".$licencia."%'
        ";
        // var_dump($sql);
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function getlicenciasvencidas(){
        $sql = "
            SELECT
            licencias_licencia title,
            licencias_nombregenerico website,
            licencias_licencia phone,
            licencias_latitud lat,
            licencias_longitud lng,
            giro_nombre giro,
            persona_nombre,
            persona_direccion direccion,
            colonia_nombre colonia,
            zona_nombre,
            licencias_fechavencimientopago
            FROM global_licencias
            left join cat_persona on persona_id = licencias_propietariopersonaid
            left join cat_colonia on colonia_id = persona_colonia
            left join cat_giro on giro_id = licencias_giro
            left join cat_zona on zona_id = colonia_zonaid
            where licencias_fechavencimientopago < now()
        ";
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function getlicenciasallmapa($busqueda){
        $sql = "
            SELECT
            licencias_licencia title,
            licencias_nombregenerico website,
            licencias_licencia phone,
            licencias_latitud lat,
            licencias_longitud lng,
            giro_nombre giro,
            persona_razonsocial persona_nombre,
            persona_direccion direccion,
            colonia_nombre colonia,
            zona_nombre,
            giro_color
            FROM global_licencias
            left join cat_persona pp on persona_id = licencias_propietariopersonaid
            left join cat_rfc rp on rfc_id = persona_rfcid
            left join cat_colonia on colonia_id = persona_colonia
            left join cat_giro on giro_id = licencias_giro
            left join cat_zona on zona_id = colonia_zonaid
            where 1 = 1
        ";
        if ($busqueda <> ''){
            $res = json_decode(base64_decode($busqueda),true); 

                if ($res['bsqgiroid'] <> '' and $res['bsqgiroid'] <> 'null'){
                    $sql.= " and (giro_id = ".$res['bsqgiroid'].")";
                }
                if ($res['bsqpropietario'] <> '' and $res['bsqpropietario'] <> 'null'){
                    $sql.= " and (rp.rfc_rfc like '%".$res['bsqpropietario']."%' or pp.persona_razonsocial like '%".$res['bsqpropietario']."%')";
                }
                /*
                if ($res['bsqcomodatario'] <> '' and $res['bsqcomodatario'] <> 'null'){
                    $sql.= " and (rc.rfc_rfc like '%".$res['bsqcomodatario']."%' or pc.persona_razonsocial like '%".$res['bsqcomodatario']."%')";
                }
                */
                if ($res['bsqnombre'] <> '' and $res['bsqnombre'] <> 'null'){
                    $sql.= " and (licencias_nombregenerico like '%".$res['bsqnombre']."%')";
                }
                if ($res['bsqtipolicencia'] <> '' and $res['bsqtipolicencia'] <> 'null'){
                    $sql.= " and (licencias_tipolicencia = ".$res['bsqtipolicencia'].")";
                }   
                if ($res['bsqnumlicencia'] <> '' and $res['bsqnumlicencia'] <> 'null'){
                    $sql.= " and (licencias_licencia like '%".$res['bsqnumlicencia']."%')";
                }

        }
        
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
    }

}
