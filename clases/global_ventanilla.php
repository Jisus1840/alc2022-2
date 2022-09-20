<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase Ventanilla
*********************************************************************************
*/
?>
<?
class ventanilla{
    
    var $tramitesescaneo;
    
    //Getinfo del trámite
    function getinfotramite($tramitevuid,$tabla,$tablacampo){
        $sql = "
        select *, case when docstotal = docsubidos then 1 else 0 end completo from
                (
                select 
                *,
                LENGTH((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos)) - LENGTH(REPLACE((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos), ',', '')) + 1 docstotal,
                (
                    select 
                    count(distinct documentosupload_tipodocumentosuploadid) 
                    from 
                    global_documentosupload
                    where 
					FIND_IN_SET(documentosupload_tipodocumentosuploadid, (select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos))
                    and documentosupload_tramitevuid = tuv.tramitevu_id
                    and documentosupload_activo = 1
                ) docsubidos
                from 
                    global_tramitevu tuv
                    left join vw_tramitestramitevu on tramitevu_id = vuid
                    left join conf_tipotramite on tipotramite_id = tuv.tramitevu_tipotramiteid
                    left join conf_flujo on flujo_id = tipotramite_flujo
                    left join conf_status on status_id = tramitevu_statusid
                    left join conf_flujodetalle on flujodetalle_casillaid = tramitevu_casillaid and flujodetalle_flujoid = flujo_id
                    left join ".$tabla." on tramitevu_id = ".$tablacampo."
                    where tramitevu_id = ".$tramitevuid."
                    ) todo
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->Close();
		return $res;
    }
    
    //Getinfo del trámite
    function getinfotramitebasica($tramitevuid){
        $sql = "
        select * from 
        global_tramitevu
        left join vw_tramitestramitevu on vuid = tramitevu_id
        left join conf_tipotramite tt on tipotramite_id = tramitevu_tipotramiteid
        where tramitevu_id = ".$tramitevuid;
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->Close();
		return $res;
    }
    
    //Get historial del trámite
    function gethistorialtramite($tramitevuid){
        $sql = "
        select * from 
        global_tramitevu
        left join vw_tramitestramitevu on vuid = tramitevu_id
        left join global_historialvu on historialvu_tramitevuid = tramitevu_id
        left join cat_usuarios u on usuarios_id = historialvu_usuarioid
        left join conf_flujodetalle fd on flujodetalle_casillaid = historialvu_casillaidfin
        where tramitevu_id = ".$tramitevuid." and flujodetalle_casillaid != 1
        order by historialvu_id asc
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->Close();
		return $res;
    }
	
	// Función para actualizar la fecha en que fue leído el comentario
	function actualizarcomentariosvistos($tramitevuid, $userid) {
		if($userid == 'null') {
			$comparar_usuario = " is not null)";
		}
		else {
			$comparar_usuario = " != ".$userid." || comentariosvu_usuarioid is null)";
		}
		$db = new DB();
		date_default_timezone_set("America/Mexico_City");
		$fecha = date("Y-m-d H:i:s");
		$sql = "update global_comentariosvu set comentariosvu_visto = '".$fecha."' 
		where (comentariosvu_visto is null and comentariosvu_tramitevuid = ".$tramitevuid." and (comentariosvu_usuarioid".$comparar_usuario.")";
		$db->Insert($sql);
		$db->Close();     
	}
    
	# Función para actualizar un permiso 
	function actualizar_permiso($tipoevento, $giroid, $fechai, $fechaf, $horario, $horariofin, $descripcion, $personaid, $domiciliolic, $domiciliolicnumext, $municipioid, $colonialicid, $entrecallelic, $yentrecallelic, $lat, $lng, $tramiteid) {
		$sql = "UPDATE global_tramitealtalicenciaprovisional SET tramitealtalicenciaprovisional_propietariopersonaid =  $personaid, tramitealtalicenciaprovisional_tipoevento = '$tipoevento', tramitealtalicenciaprovisional_giro = $giroid, tramitealtalicenciaprovisional_fechai = '$fechai', tramitealtalicenciaprovisional_fechaf = '$fechaf', tramitealtalicenciaprovisional_horario = '$horario', tramitealtalicenciaprovisional_horariofin = '$horariofin', tramitealtalicenciaprovisional_descripcion = '$descripcion', tramitealtalicenciaprovisional_domicilio = '$domiciliolic', tramitealtalicenciaprovisional_domicilio_numext = '$domiciliolicnumext', tramitealtalicenciaprovisional_coloniaid = $colonialicid, tramitealtalicenciaprovisional_municipioid = $municipioid, tramitealtalicenciaprovisional_entrecalle = '$entrecallelic', tramitealtalicenciaprovisional_yentrecalle = '$yentrecallelic', tramitealtalicenciaprovisional_latitud = '$lat', tramitealtalicenciaprovisional_longitud = '$lng' WHERE tramitealtalicenciaprovisional_tramitevuid = $tramiteid";
		$db = new DB();
		$db->Insert($sql);
	}
	
	function actualizar_tramitecambio($licenciaid, $subtramites, $domiciliolic, $domiciliolicnumext, $coloniaid, $estadoid, $municipioid, $entrecalle, $yentrecalle, $latitud, $longitud, $adomiciliolic, $acoloniaid, $aestadoid, $amunicipioid, $aentrecalle, $ayentrecalle, $alatitud, $alongitud, $panteriorid, $pnuevoid, $canteriorid, $cnuevoid, $nombreganterior, $nombregnuevo, $giroanteriorid, $giroid, $tipolicenciaid, $folio_licencia, $tramiteid) {
		if($acoloniaid == null) {
			$acoloniaid = 'null';
		}
		if($tipolicenciaid != '' && $tipolicenciaid != 'null') {
			$num_licencia = $folio_licencia;
		}
		else {
			$num_licencia = 'null';
		}
		$sql = "UPDATE global_tramitecambio SET tramitecambio_licenciaid = $licenciaid, tramitecambio_domicilionuevo = '$domiciliolic', tramitecambio_domicilionuevo_numext = '$domiciliolicnumext', tramitecambio_domiciliocoloniaidnuevo = $coloniaid, tramitecambio_domicilioestadoidnuevo = $estadoid, tramitecambio_domiciliomunicipioidnuevo = $municipioid, tramitecambio_domicilioentrecallenuevo = '$entrecalle', tramitecambio_domicilioyentrecallenuevo = '$yentrecalle', tramitecambio_domiciliolatitudnuevo = '$latitud', tramitecambio_domiciliolongitudnuevo = '$longitud', tramitecambio_domicilioanterior = '$adomiciliolic', tramitecambio_domiciliocoloniaidanterior = $acoloniaid, tramitecambio_domicilioestadoidanterior = $aestadoid, tramitecambio_domiciliomunicipioidanterior = $amunicipioid, tramitecambio_domicilioentrecalleanterior = '$aentrecalle', tramitecambio_domicilioyentrecalleanterior = '$ayentrecalle', tramitecambio_domiciliolatitudanterior = '$alatitud', tramitecambio_domiciliolongitudanterior = '$alongitud', tramitecambio_propietarioidanterior = $panteriorid, tramitecambio_propietarioidnuevo = $pnuevoid, tramitecambio_comodatarioidanterior = $canteriorid, tramitecambio_comodatarioidnuevo = $cnuevoid, tramitecambio_nombreanterior = '$nombreganterior', tramitecambio_nombrenuevo = '$nombregnuevo', tramitecambio_giroidanterior = $giroanteriorid, tramitecambio_giroidnuevo = $giroid, tramitecambio_tipo_licencia_id = $tipolicenciaid, tramitecambio_folio_licencia_anterior = '$num_licencia'
        where tramitecambio_tramitevuid = $tramiteid";
		$db = new DB();
		$db->Insert($sql);
	}
	
    //Agregar Comentario
    function agregarcomentario($comentario,$usuarioid,$tramiteid){
        $sql = "
        insert into
        global_comentariosvu
        (
            comentariosvu_fecha,
            comentariosvu_comentario,
            comentariosvu_usuarioid,
            comentariosvu_tramitevuid
        )
        values
        (
            '".date("Y-m-d H:i:s")."',
            '".$comentario."',
            ".$usuarioid.",
            ".$tramiteid."
        )
        ";
        $db = new DB();
		$db->Insert($sql);
		$db->Close();
        
        //guardar en bitácora
        $bitacora = new bitacora();
        $bitacora->guardar('COMENTARIO','Se guardo comentario: '.$comentario,catalogos::getnombreusuariobyid($usuarioid),$tramiteid);
        //////////////////////
    }
    
	// Función para actualizar el trámite de licencia 
	function actualizar_tramite_licencia($nombregenerico, $giroid, $personaid, $personaidcomodatario, $domiciliolic, $domiciliolicnum, $municipioid, $colonialicid, $entrecallelic, $yentrecallelic, $lat, $lng, $tipoid, $tramiteid) {
		$sql = "UPDATE global_tramitealtalicencia SET tramitealtalicencia_propietariopersonaid = $personaid, tramitealtalicencia_comodatariopersonaid = $personaidcomodatario, tramitealtalicencia_nombregenerico = '$nombregenerico', tramitealtalicencia_giro = '$giroid', tramitealtalicencia_domicilio = '$domiciliolic', tramitealtalicencia_domicilio_numext = '$domiciliolicnum', tramitealtalicencia_coloniaid = $colonialicid, tramitealtalicencia_municipioid = $municipioid, tramitealtalicencia_entrecalle = '$entrecallelic', tramitealtalicencia_yentrecalle = '$yentrecallelic', tramitealtalicencia_latitud = '$lat', tramitealtalicencia_longitud = '$lng', tramitealtalicencia_tipo_licencia_id = $tipoid 
		WHERE tramitealtalicencia_tramitevuid = $tramiteid";
		$db = new DB();
		$db->Insert($sql);
	}
	
    //Get comentarios del trámite
    function getcomentariostramite($tramitevuid){
        $sql = "
        select * from global_comentariosvu
        left join cat_usuarios on usuarios_id = comentariosvu_usuarioid
        where comentariosvu_tramitevuid = ".$tramitevuid."
        order by comentariosvu_fecha asc
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->Close();
		return $res;
    }
    
    function getflujo($idtramite){
		$sql = "
		select
		ifnull(fd.flujodetalle_casillaidinicio,-1) idcasillapadre,
		fd.flujodetalle_casillaid idcasilla,
		tt.tipotramite_nombre, 
		h.historialvu_fechafin, h.historialvu_tiempominutos,
		u.usuarios_nombre,
		fd.flujodetalle_casillanombre,
		p.procesos_nombre,
		pe.perfiles_nombre,
		pe.perfiles_color,
		case when (h.historialvu_fechainicio is null) then '' else 'ok' end escaneado
		from global_tramitevu t
		left join conf_tipotramite tt on tt.tipotramite_id = t.tramitevu_tipotramiteid
		left join conf_relflujotramite rft on rft.relflujotramite_tipotramiteid = tt.tipotramite_id 
		left join (select * from global_historialvu where historialvu_comentario <> 'Solicitud Cancelada') h on t.tramitevu_id = h.historialvu_tramitevuid and rft.relflujotramite_casillaid = h.historialvu_casillaidfin
		left join conf_flujodetalle fd on fd.flujodetalle_casillaid = rft.relflujotramite_casillaid
		left join cat_usuarios u on u.usuarios_id = h.historialvu_usuarioid
		left join conf_procesos p on p.procesos_id = rft.relflujotramite_procesosid 
		left join conf_perfiles pe on pe.perfiles_id = rft.relflujotramite_perfilesid
		where t.tramitevu_id = {$idtramite}
		";
		$db = new DB();
		$res1 = $db->Ejecuta($sql);
		return $res1;
	}

	function imprimirflujo($datas, $parent, $depth=0){
		$ni=count($datas);
		if($ni === 0 || $depth > 1000) return ''; // Make sure not to have an endless recursion
		$tree = '<ul class="threeView">';
		for($i=0; $i < $ni; $i++){
			if($datas[$i]['idcasillapadre'] == $parent){
				$tree .= '<li>';
				$tree .= '<span style=" font-size: 30px; color: #'.$datas[$i]['perfiles_color'].'; vertical-align: middle">&#8226;</span>';     
				$tree .= '
				<span style = "vertical-align: middle">
					<b>'.$datas[$i]['procesos_nombre'].'</b> ('.$datas[$i]['perfiles_nombre'].')
				</span> 
				<span style = "color:#2E8B57; font-weight:bolder">'.$datas[$i]['escaneado'].'</span>';
				$tree .= $this->imprimirflujo($datas, $datas[$i]['idcasilla'], $depth+1);
				$tree .= '</li>';
			}
		}
		$tree .= '</ul>';
		return $tree;
	}
	
	function gethistorialcancelacion($idtramite) {
		$sql = "select gmc.motivo_cancelacion, gmc.fecha_cancelacion, cu.usuarios_nombre
		from global_motivoscancelacion gmc	
		left join cat_usuarios cu on cu.usuarios_id = gmc.usuarioid
		where gmc.tramiteid = ".$idtramite;
		$db = new DB();
		$res = $db->Ejecuta($sql);
        return $res;
	}
    
    function cancelartramite($idtramite,$idusuario,$motivocancelacion){
		$res = $this->getinfotramitebasica($idtramite);
		//Inserta Nuevo Registro en historial
		$fechatransaccion = date("Y-m-d H:i:s");
		
		//Realiza update de fecha a Registro anterior con la fecha de inicio del nuevo
		$sql = "update global_historialvu
				set historialvu_fechafin = '{$fechatransaccion}',
				historialvu_tiempominutos = round(time_to_sec(timediff('".$fechatransaccion."',historialvu_fechainicio))/60,2)
				where 
				historialvu_tramitevuid = {$idtramite} and
				historialvu_casillaidfin = {$res[0]['tramitevu_casillaid']}
				";
		$db = new DB();
		$db->Insert($sql);
		
		# Insertamos el motivo de cancelación
		$sql = "insert into global_motivoscancelacion (tramiteid, usuarioid, motivo_cancelacion, fecha_cancelacion)values(".$idtramite.",".$idusuario.",'".$motivocancelacion."','".$fechatransaccion."')";
		$db->Insert($sql);
		
		//Insertar en el historial 
		$sql = "insert into global_historialvu 
            (
                historialvu_tramitevuid, 
                historialvu_bloque,
                historialvu_casillaidinicio,
                historialvu_casillaidfin,
                historialvu_comentario,
                historialvu_fechainicio,
                historialvu_fechafin,
                historialvu_tiempominutos,
                historialvu_usuarioid
            )
				values
            (
                ".$res[0]['tramitevu_id'].",
                '0',
                ".$res[0]['tramitevu_casillaid'].",
                ".$res[0]['tramitevu_casillaid'].",
                'Solicitud Cancelada',
                '".$fechatransaccion."',
                '".$fechatransaccion."',
                0,
                ".$idusuario."
            )";
		$db = new DB();
		$db->Insert($sql);
		
		//Update estatus tramite
		$sql = "
		update global_tramitevu set
		tramitevu_statusid = 4,
		tramitevu_fechafin = '".$fechatransaccion."',
		tramitevu_duracionminutos = round(time_to_sec(timediff('".$fechatransaccion."',tramitevu_fechainicio))/60,2)
		where tramitevu_id = ".$idtramite."
		";
		$db = new DB();
		$db->Insert($sql);
		
		return "Solicitud cancelada correctamente";
	}
    
    //Get Query all
    function getqueryall($busqueda){
        $sql = "
            select *, case when docstotal = docsubidos then 1 else 0 end completo from
                (
                select 
                *,
                LENGTH((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos)) - LENGTH(REPLACE((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos), ',', '')) + 1 docstotal,
                (
                    select 
                    count(distinct documentosupload_tipodocumentosuploadid) 
                    from 
                    global_documentosupload
                    where 
					FIND_IN_SET(documentosupload_tipodocumentosuploadid, (select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos))
                    and documentosupload_tramitevuid = tuv.tramitevu_id
                    and documentosupload_activo = 1
				) docsubidos,
				(select UPPER(gta.tramitealtalicencia_nombregenerico) from global_tramitealtalicencia gta
				left join global_tramitevu gt on gt.tramitevu_id = gta.tramitealtalicencia_tramitevuid
				where gta.tramitealtalicencia_tramitevuid = tuv.tramitevu_id) as altalicencia_nombre_negocio,
				(select UPPER(gtalp.tramitealtalicenciaprovisional_tipoevento) from global_tramitealtalicenciaprovisional gtalp left join global_tramitevu gt on gt.tramitevu_id = gtalp.tramitealtalicenciaprovisional_tramitevuid
                where gtalp.tramitealtalicenciaprovisional_tramitevuid = tuv.tramitevu_id) as permiso_nombre_negocio,
                (select UPPER(gl.licencias_nombregenerico) from global_tramitecambio gtc 
				left join global_licencias gl on gl.licencias_id = gtc.tramitecambio_licenciaid
                where gtc.tramitecambio_tramitevuid = tuv.tramitevu_id) as licencia_nombre_negocio,
				(select UPPER(gtc.tramitecambio_nombrenuevo) from global_tramitecambio gtc 
				left join global_tramitevu gt on gt.tramitevu_id = gtc.tramitecambio_tramitevuid
                where gtc.tramitecambio_tramitevuid = tuv.tramitevu_id) as cambio_nombre_negocio		
                from 
                    global_tramitevu tuv
                    left join vw_tramitestramitevu on tramitevu_id = vuid
                    left join conf_tipotramite on tipotramite_id = tuv.tramitevu_tipotramiteid
                    left join conf_flujo on flujo_id = tipotramite_flujo
                    left join conf_status on status_id = tramitevu_statusid
                    left join conf_flujodetalle on flujodetalle_casillaid = tramitevu_casillaid and flujodetalle_flujoid = flujo_id
                    order by tramitevu_id desc
                    ) todo
        where 1 = 1 and tramitevu_mostrar = 1
        ";
        if ($busqueda <> ''){
            $res = json_decode(base64_decode($busqueda),true); 
                if ($res['bsqvuid'] <> '' and $res['bsqvuid'] <> 'null'){
                    $sql.= " and (tramitevu_folio like '%".$res['bsqvuid']."%')";
                }
                if ($res['bsqfolio'] <> '' and $res['bsqfolio'] <> 'null'){
                    $sql.= " and (folio like '%".$res['bsqfolio']."%')";
                }
                if ($res['bsqname'] <> '' and $res['bsqname'] <> 'null'){
                    $sql.= " and (licencia_nombre_negocio like '%".$res['bsqname']."%')";
                }
                if ($res['bsqtipotramite'] <> '' and $res['bsqtipotramite'] <> 'null'){
                    $sql.= " and (tramitevu_tipotramiteid = ".$res['bsqtipotramite'].")";
                }
                if ($res['bsqstatus'] <> '' and $res['bsqstatus'] <> 'null'){
                    $sql.= " and (tramitevu_statusid = ".$res['bsqstatus'].")";
                }
                if ($res['bsqcita'] <> '' and $res['bsqcita'] <> 'null'){
                    if ($res['bsqcita'] == 1){
                        //Agendado
                        $sql.= " and (tramitevu_cita is not null)";
                    }else{
                        //No agendado
                        $sql.= " and (tramitevu_cita is null)";
                    }
                }
                if ($res['bsqrequerimientos'] <> '' and $res['bsqrequerimientos'] <> 'null'){
                    if ($res['bsqrequerimientos'] == 1){
                        //Completado
                        $sql.= " and docsubidos >= docstotal ";
                    }else{
                        //No completado
                        $sql.= " and docsubidos < docstotal";
                    }
                }
				if($res['bsflujo'] <> '' and $res['bsflujo'] <> 'null') {
					$sql .= " and tramitevu_casillaid = ".$res['bsflujo'];
				}          
        }
		else {
			$sql.= " and (tramitevu_statusid = 1)";
		}
		$sql .= " order by folio desc";
        // var_dump($sql);die;
        return $sql;
    }

    function getqueryallV2($busqueda){
        $sql = 'SELECT *, CASE WHEN docstotal = docsubidos THEN 1 ELSE 0 END completo 
        FROM (
            SELECT tramitevu_aplicado, 
            tramitevu_cita, 
            tramitevu_fecha_enviado_revision, 
            tramitevu_folio, 
            tramitevu_statusid, 
            tramitevu_tipotramiteid, 
            tramitevu_licenciaid, 
            tramitevu_id, 
            tramitevu_mostrar, 
            tramitevu_casillaid, 
            tipotramite_nombre, 
            flujodetalle_casillanombre, 
            status_nombre, 
            status_color, 
            folio, 
            tabla, 
            (
                SELECT UPPER(tramitealtalicencia_nombregenerico) 
                FROM global_tramitealtalicencia 
                WHERE tramitealtalicencia_tramitevuid = tuv.tramitevu_id
            ) altalicencia_nombre_negocio, 
            (
                SELECT UPPER(tramitealtalicenciaprovisional_tipoevento) 
                FROM global_tramitealtalicenciaprovisional 
                WHERE tramitealtalicenciaprovisional_tramitevuid = tuv.tramitevu_id
            ) permiso_nombre_negocio, 
            (
                SELECT UPPER(licencias_nombregenerico) 
                FROM global_tramitecambio 
                LEFT JOIN global_licencias ON licencias_id = tramitecambio_licenciaid 
                WHERE tramitecambio_tramitevuid = tuv.tramitevu_id
            ) licencia_nombre_negocio, 
            (
                SELECT UPPER(tramitecambio_nombrenuevo) 
                FROM global_tramitecambio 
                WHERE tramitecambio_tramitevuid = tuv.tramitevu_id
            ) cambio_nombre_negocio, 
            LENGTH(
                (
                    SELECT GROUP_CONCAT(DISTINCT tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ",") 
                    FROM conf_tiposubtramite 
                    WHERE FIND_IN_SET(tiposubtramite_id, tiposubtramiteid) 
                    GROUP BY tiposubtramite_tipodocumentosuploadrequeridos
                )
            ) - LENGTH(
                REPLACE(
                    (
                        SELECT GROUP_CONCAT(DISTINCT tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ",") 
                        FROM conf_tiposubtramite 
                        WHERE FIND_IN_SET(tiposubtramite_id, tiposubtramiteid) 
                        GROUP BY tiposubtramite_tipodocumentosuploadrequeridos
                    ), ",", ""
                )
            ) + 1 docstotal, 
            (
                SELECT COUNT(DISTINCT documentosupload_tipodocumentosuploadid) 
                FROM global_documentosupload 
                WHERE FIND_IN_SET(
                    documentosupload_tipodocumentosuploadid, 
                    (
                        SELECT GROUP_CONCAT(DISTINCT tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ",") 
                        FROM conf_tiposubtramite 
                        WHERE FIND_IN_SET(tiposubtramite_id, tiposubtramiteid) 
                        GROUP BY tiposubtramite_tipodocumentosuploadrequeridos
                    )
                )
                AND documentosupload_tramitevuid = tuv.tramitevu_id 
                AND documentosupload_activo = 1
            ) docsubidos
            FROM global_tramitevu tuv 
            LEFT JOIN conf_tipotramite ON tipotramite_id = tramitevu_tipotramiteid 
            LEFT JOIN conf_flujo ON flujo_id = tipotramite_flujo 
            LEFT JOIN conf_flujodetalle ON flujodetalle_casillaid = tramitevu_casillaid 
            LEFT JOIN conf_status ON status_id = tramitevu_statusid 
            AND flujo_id = flujodetalle_flujoid 
            LEFT JOIN vw_tramitestramitevu ON tramitevu_id = vuid
        ) todo
        WHERE ';

        $where = ['tramitevu_mostrar = 1'];

        if ($busqueda) {
            $bsq = json_decode(base64_decode($busqueda), true);
            if ($bsq['bsqvuid'] != '' && $bsq['bsqvuid'] != 'null'){
                $where[] = '(tramitevu_folio like "%'.$bsq['bsqvuid'].'%")';
            }
            if ($bsq['bsqfolio'] != '' && $bsq['bsqfolio'] != 'null'){
                $where[] = '(folio like "%'.$bsq['bsqfolio'].'%")';
            }
            if ($bsq['bsqname'] != '' && $bsq['bsqname'] != 'null'){
                $where[] = '(
                    altalicencia_nombre_negocio like "%'.$bsq['bsqname'].'%" 
                    OR permiso_nombre_negocio like "%'.$bsq['bsqname'].'%" 
                    OR licencia_nombre_negocio like "%'.$bsq['bsqname'].'%" 
                    OR cambio_nombre_negocio like "%'.$bsq['bsqname'].'%"
                )';
            }
            if ($bsq['bsqtipotramite'] != '' && $bsq['bsqtipotramite'] != 'null'){
                $where[] = '(tramitevu_tipotramiteid = '.$bsq['bsqtipotramite'].')';
            }
            if ($bsq['bsqstatus'] != '' && $bsq['bsqstatus'] != 'null'){
                $where[] = '(tramitevu_statusid = '.$bsq['bsqstatus'].')';
            }
            if ($bsq['bsqcita'] != '' && $bsq['bsqcita'] != 'null'){
                $where[] = '(tramitevu_cita IS'.($bsq['bsqcita'] == 1 ? ' NOT' : '').' NULL)';
            }
            if ($bsq['bsqrequerimientos'] != '' && $bsq['bsqrequerimientos'] != 'null'){
                $where[] = 'docsubidos '.($bsq['bsqrequerimientos'] == 1 ? '>=' : '<').' docstotal ';
            }
            if($bsq['bsflujo'] != '' && $bsq['bsflujo'] != 'null') {
                $where[] = 'tramitevu_casillaid = '.$bsq['bsflujo'];
            }
        } else {
            $where[] = 'tramitevu_statusid = 1';
        }

        $sql .= implode(' 
        AND ', $where).' 
        ORDER BY folio DESC';

        return $sql;
    }
    
    function getqueryallpagos($busqueda){
        $sql = "
                select 
                tuv.*,
                vwt.*,
                tt.*,
                s.*,
                case when tramitevu_tipotramiteid = 7 then permisos_folio else concat(tipolicencia_nombre,licencias_licencia) end licencia
                from 
                    global_tramitevu tuv
                    left join vw_tramitestramitevu vwt on tramitevu_id = vuid
                    left join conf_tipotramite tt on tipotramite_id = tuv.tramitevu_tipotramiteid
                    left join conf_status s on status_id = tramitevu_statusid
                    left join global_licencias l on licencias_id = tuv.tramitevu_licenciaid
                    left join cat_tipolicencia tl on tipolicencia_id = licencias_tipolicencia
                    left join global_permisos p on permisos_id = tuv.tramitevu_licenciaid
                    where tramitevu_montopago > 0 
        ";
        if ($busqueda <> ''){
            $res = json_decode(base64_decode($busqueda),true); 

                if ($res['bsqciclo'] <> '' and $res['bsqciclo'] <> 'null'){
                    $sql.= " and (tramitevu_ciclo = '".$res['bsqciclo']."')";
                }
                if ($res['bsqtipotramite'] <> '' and $res['bsqtipotramite'] <> 'null'){
                    $sql.= " and (tramitevu_tipotramiteid = ".$res['bsqtipotramite'].")";
                }
            
        }else{
            $sql.= " and (tramitevu_ciclo = '".date('Y')."')";

        }
        $sql .= " order by tramitevu_id desc";
        return $sql;
    }
    
    //Get Query all by correo and user para usuarios externos
    function getqueryallbycorreoanduser($correo,$rfc,$inputbusqueda,$inputbusquedastatus){
        $sql = "
            select *, case when docstotal = docsubidos then 1 else 0 end completo from
                (
                select 
                *,
                LENGTH((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos)) - LENGTH(REPLACE((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos), ',', '')) + 1 docstotal,
				(select UPPER(gta.tramitealtalicencia_nombregenerico) from global_tramitealtalicencia gta
				left join global_tramitevu gt on gt.tramitevu_id = gta.tramitealtalicencia_tramitevuid
				where gta.tramitealtalicencia_tramitevuid = tuv.tramitevu_id) as altalicencia_nombre_negocio,
				(select UPPER(gtalp.tramitealtalicenciaprovisional_tipoevento) from global_tramitealtalicenciaprovisional gtalp left join global_tramitevu gt on gt.tramitevu_id = gtalp.tramitealtalicenciaprovisional_tramitevuid
                where gtalp.tramitealtalicenciaprovisional_tramitevuid = tuv.tramitevu_id) as permiso_nombre_negocio,
				(select UPPER(gl.licencias_nombregenerico) from global_tramitecambio gtc 
				left join global_licencias gl on gl.licencias_id = gtc.tramitecambio_licenciaid
                where gtc.tramitecambio_tramitevuid = tuv.tramitevu_id) as licencia_nombre_negocio,
				(select UPPER(gtc.tramitecambio_nombrenuevo) from global_tramitecambio gtc 
				left join global_tramitevu gt on gt.tramitevu_id = gtc.tramitecambio_tramitevuid
                where gtc.tramitecambio_tramitevuid = tuv.tramitevu_id) as cambio_nombre_negocio,
				(select tramitealtalicenciaprovisional_folio from global_tramitealtalicenciaprovisional where tramitealtalicenciaprovisional_tramitevuid = tuv.tramitevu_id) as folio_permiso,
				(select tramitealtalicenciaprovisional_folio from global_tramitealtalicenciaprovisional where tramitealtalicenciaprovisional_tramitevuid = tuv.tramitevu_id) as folio_altalicencia,
				(select tramitecambio_folio from global_tramitecambio where tramitecambio_tramitevuid = tuv.tramitevu_id) as folio_tramitecambio, (SELECT documentosupload_aprobado FROM global_documentosupload WHERE documentosupload_tramitevuid = tuv.tramitevu_id AND documentosupload_tipodocumentosuploadid IN(1, 24, 47) AND documentosupload_aprobado = 1)	as documento_solicitud_aprobado,
                (
                    select 
                    count(distinct documentosupload_tipodocumentosuploadid) 
                    from 
                    global_documentosupload
                    where 
					FIND_IN_SET(documentosupload_tipodocumentosuploadid, (select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos))
                    and documentosupload_tramitevuid = tuv.tramitevu_id
                    and documentosupload_activo = 1
                ) docsubidos
                from 
                    global_tramitevu tuv
                    left join vw_tramitestramitevu on tramitevu_id = vuid
                    left join conf_tipotramite on tipotramite_id = tuv.tramitevu_tipotramiteid
                    left join conf_flujo on flujo_id = tipotramite_flujo
                    left join conf_status on status_id = tramitevu_statusid
                    left join conf_flujodetalle on flujodetalle_casillaid = tramitevu_casillaid and flujodetalle_flujoid = flujo_id
                    where tramitevu_correo = '".$correo."' and tramitevu_rfc = '".$rfc."'
                    order by tramitevu_id desc
                    ) todo
        ";
        return $sql;
    }
    
    //Get Query by vuid
    function getresbyfoliohora($folio,$hora){
        $db = new DB();
        $sql = "
            select *, case when docstotal = docsubidos then 1 else 0 end completo from
                (
                select 
                *,
                LENGTH((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos)) - LENGTH(REPLACE((select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos), ',', '')) + 1 docstotal,
                (
                    select 
                    count(distinct documentosupload_tipodocumentosuploadid) 
                    from 
                    global_documentosupload
                    where 
					FIND_IN_SET(documentosupload_tipodocumentosuploadid, (select GROUP_CONCAT(distinct tiposubtramite_tipodocumentosuploadrequeridos SEPARATOR ',') from conf_tiposubtramite where FIND_IN_SET(tiposubtramite_id,tiposubtramiteid) group by tiposubtramite_tipodocumentosuploadrequeridos))
                    and documentosupload_tramitevuid = tuv.tramitevu_id
                    and documentosupload_activo = 1
                ) docsubidos
                from 
                    global_tramitevu tuv
                    left join vw_tramitestramitevu on tramitevu_id = vuid
                    left join conf_tipotramite on tipotramite_id = tuv.tramitevu_tipotramiteid
                    left join conf_flujo on flujo_id = tipotramite_flujo
                    left join conf_status on status_id = tramitevu_statusid
                    left join conf_flujodetalle on flujodetalle_casillaid = tramitevu_casillaid and flujodetalle_flujoid = flujo_id
                    where
                    DATE_FORMAT(tramitevu_fechainicio, '%k:%i') = '".$hora."'
                    and folio ='".$folio."'
                    order by tramitevu_id desc
                    ) todo
                    ";
        $res = $db->Ejecuta($sql);
        return $res;
    }
    
    //Guarda Trámite Ventanilla
    function guardar($usuarioid,$tipotramite,$statusid,$flujoid,$fechainicio,$fechafin='',$correousuario='',$rfcusuario='',$licenciaid){
    
        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_tramitevu
        (
            tramitevu_id,
            tramitevu_folioid,
            tramitevu_folio,
            tramitevu_ciclo,
            tramitevu_tipotramiteid,
            tramitevu_statusid,
            tramitevu_casillaid,
            tramitevu_fechainicio,
            tramitevu_fechafin,
            tramitevu_usuarioid,
            tramitevu_correo,
            tramitevu_rfc,
            tramitevu_licenciaid
        )
        values
        (
            null,
            (select folioid from (
				select ifnull(max(tramitevu_folioid),0) + 1 folioid
				from global_tramitevu
				where tramitevu_ciclo = (select ciclo_id from conf_ciclo where ciclo_activo=1)
			)folioid),
			(select folio from (
				select concat(LPAD(ifnull(max(tramitevu_folioid),0) + 1,5,'0'),'-',(select substring(ciclo_id,3,2) from conf_ciclo where ciclo_activo=1)) folio
				from global_tramitevu
				where tramitevu_ciclo = (select ciclo_id from conf_ciclo where ciclo_activo=1)
			)folio),
            (select substring(ciclo_id,3,2) from conf_ciclo where ciclo_activo=1),
            ".$tipotramite.",
            ".$statusid.",
            ".$flujoid.",
            ".(($fechainicio == '')?'null':"'".$fechainicio."'").",
            ".(($fechafin == '')?'null':"'".$fechafin."'").",
            ".$usuarioid.",
            '".$correousuario."',
            '".$rfcusuario."',
            ".$licenciaid."
        )
        ";
        $db->Insert($sql);
       
        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        //Guarda Historial
        $this->guardarhistorial($usuarioid,$lastinsert,'null',$flujoid,'Solicitud Creada',$fechainicio,'');
        
        //Guarda Bitacora
        return $lastinsert;
    }
    
    function guardarhistorial($usuarioid,$tramiteid,$flujoidinicio,$flujoidfin,$comentario,$fechainicio,$fechafin,$bloque='',$tiempominutos='null'){
        
        //Guarda Vetanilla
        $db = new DB();
        $sql = "
        insert into global_historialvu
        (
            historialvu_id,
            historialvu_bloque,
            historialvu_tramitevuid,
            historialvu_casillaidinicio,
            historialvu_casillaidfin,
            historialvu_comentario,
            historialvu_fechainicio,
            historialvu_fechafin,
            historialvu_usuarioid,
            historialvu_tiempominutos
        )
        values
        (
            null,
            '".$bloque."',
            ".$tramiteid.",
            ".$flujoidinicio.",
            ".$flujoidfin.",
            '".$comentario."',
            ".(($fechainicio == '')?'null':"'".$fechainicio."'").",
            ".(($fechafin == '')?'null':"'".$fechafin."'").",
            ".$usuarioid.",
            ".$tiempominutos."
        )
        ";

        $db->Insert($sql);
        
		$sql = "update global_historialvu
				set historialvu_fechafin = '{$fechainicio}',
				historialvu_tiempominutos = round(time_to_sec(timediff('".$fechainicio."',historialvu_fechainicio))/60,2)
				where 
				historialvu_tramitevuid = {$tramiteid} and
				historialvu_casillaidfin = {$flujoidinicio}
				";

		$db->Insert($sql);
        
        $db->Close();
    }
    
    
	function recibir($tramites){
		$usuarioperfilescaneo = $_SESSION['alcoholes']['perfil_escaneo'];
		$sql1 = "
		select gral.id idaux, gral.idtramite, gral.fechacreacion, gral.idstatus, gral.nomstatus, gral.colorstatus, permisos.idcasilla, 
        permisos.idcasillainicio idcasillaanterior, permisos.inicio, permisos.final, permisos.idcasillainicio, permisos.nomcasilla, 
fdactual.flujodetalle_casillanombre nomcasillaactual, gral.nomtramite, fdactual.flujodetalle_casillaid idcasillaactual, gral.tipotramite, gral.idstatus idperfil, gral.idhistorial,
case when permisos.permisos is null or gral.idstatus = 4 then 0 else 1 end valido
from
(
	select tramitevu_tipotramiteid tipotramite, tramitevu_id id, tramitevu_id idtramite, tramitevu_fechainicio fechacreacion, tramitevu_statusid idstatus, status_nombre nomstatus, status_color colorstatus, historialvu_casillaidfin idcasilla, historialvu_casillaidinicio idcasillainicial, tipotramite_nombre nomtramite, historialvu_id idhistorial
	from global_tramitevu t
	left join conf_status s on status_id = tramitevu_statusid
	left join conf_tipotramite tt on tipotramite_id = tramitevu_tipotramiteid
	left join global_historialvu h on historialvu_tramitevuid = tramitevu_id and historialvu_casillaidfin = tramitevu_casillaid
	where tramitevu_folio in (".$tramites.")
	and historialvu_comentario <> 'Solicitud Cancelada'
) gral
left join (
	select concat(flujodetalle_casillaidinicio,'-',relflujotramite_perfilesid) permisos, flujodetalle_casillaid idcasilla, 
    flujodetalle_casillaidinicio idcasillainicio, 
    relflujotramite_tipotramiteid tipotramite, 
    flujodetalle_inicio inicio, flujodetalle_final final, 
    flujodetalle_casillanombre nomcasilla
from conf_flujodetalle afd
left join conf_relflujotramite arft on relflujotramite_casillaid = flujodetalle_casillaid
) permisos on permisos.permisos = concat(gral.idcasilla,'-','".$usuarioperfilescaneo."') and gral.tipotramite = permisos.tipotramite
left join conf_flujodetalle fdactual on fdactual.flujodetalle_casillaid = permisos.idcasillainicio
        ";
		$db = new DB();
		$res1 = $db->Ejecuta($sql1);
		$db->Close();
        
		$this->tramitesescaneo = $res1;
		return $res1;
		
	}
	
	function recibirGuardar($tramites,$bloquetramite){
		//Guarda y update
		foreach ($this->tramitesescaneo as $tramite){
            $tiempominutos = 'null';
			$fecha = date("Y-m-d H:i:s");
			if ($tramite['valido']==1){
				//si es final
                if ($tramite['final'] == 1){
					$sql = "update global_tramitevu set tramitevu_casillaid = {$tramite['idcasilla']}, tramitevu_statusid = 3, tramitevu_fechafin = '".$fecha."' where tramitevu_id ={$tramite['idtramite']}";
					$db = new DB();
					$db->Insert($sql);
					$fechafin = $fecha;
					//Actualiza duraci�n de tr�mite en vu_tramite
					$sqlduracion = "update (
					select tramitevu_id, tramitevu_fechainicio, tramitevu_fechafin, 
					round(time_to_sec(TIMESTAMPDIFF(minute,tramitevu_fechafin,tramitevu_fechainicio))/60,2) duraciontotal
					from global_tramitevu
					where tramitevu_id = {$tramite['idaux']}) t1
					left join global_tramitevu t2 on t1.tramitevu_id = t2.tramitevu_id
					set
					t2.tramitevu_duracionminutos = t1.duraciontotal";
                    
					$db = new DB();
					$db->Insert($sqlduracion);
                    //Si es final manda tiempo en minutos
                    $tiempominutos = 0;
				}else{
					$sql = "update global_tramitevu set tramitevu_casillaid = {$tramite['idcasilla']} where tramitevu_id={$tramite['idtramite']}";
					$db = new DB();
					$db->Insert($sql);
                    
					$fechafin = null;
				}
				
				//si es principio
				if ($tramite['inicio'] == 1){
					$updatehora = "update global_tramitevu set tramitevu_statusid = 2 where tramitevu_id=".$tramite['idaux'];
					$db = new DB();
					$db->Insert($updatehora);
				}
                
			}
			
            $usersession =  unserialize($_SESSION['alcoholes']['usuario_info']);
			$historialcomentario = $this->guardarhistorial($usersession[0]['usuarios_id'],$tramite['idaux'],$tramite['idcasillaanterior'],$tramite['idcasilla'],'Solicitud Escaneada',$fecha,$fechafin,$bloquetramite,$tiempominutos);	
			
            //guardar en bitácora
            $bitacora = new bitacora();
            $bitacora->guardar('TRAMITE ESCANEO','Trámite escaneado',catalogos::getnombreusuariobyid($usersession[0]['usuarios_id']),$tramite['idaux']);
            //////////////////////
            
		}
		//manda correo
		/*
        foreach ($this->tramitesescaneo as $tramite){
			if ($tramite['valido']==1){
				//si es final
				//manda correo
			}
				
		}
        */
		
	}
	
    function getqueryallrecibos (){
        $sql = "
            select * from 
            (SELECT 
            historialvu_bloque,
            count(*) numero,
            historialvu_usuarioid
            FROM global_historialvu 
            where historialvu_bloque <> '' and historialvu_bloque <> 0
            group by historialvu_bloque, historialvu_usuarioid
            ) aux
            left join cat_usuarios on usuarios_id = historialvu_usuarioid
            order by historialvu_bloque desc
        ";
        return $sql;
    }
    
    function gettramitesescaneados($bloque){
        $sql = "
            select h.*, t.*, vwtt.*, tt.*, fdinicio.flujodetalle_casillanombre fdinicio, fdfin.flujodetalle_casillanombre fdfin, u.* from 
            global_historialvu h
            left join global_tramitevu t on tramitevu_id = historialvu_tramitevuid
            left join vw_tramitestramitevu vwtt on vuid = tramitevu_id
            left join conf_tipotramite tt on tipotramite_id = tramitevu_tipotramiteid
            left join conf_flujodetalle fdinicio on fdinicio.flujodetalle_casillaid = historialvu_casillaidinicio
            left join conf_flujodetalle fdfin on fdfin.flujodetalle_casillaid = historialvu_casillaidfin
            left join cat_usuarios u on usuarios_id = historialvu_usuarioid
            where historialvu_bloque = '".$bloque."'
        ";
        
        $db = new DB();
        $res = $db->Ejecuta($sql);
        return $res;
    }
    
    function jsongraficahistorico($tramitevuid){
        $sql = "
        select 'tramite' id, 'tramite' nombre, tramitevu_folio tiempo from global_tramitevu where tramitevu_id = ".$tramitevuid."
        union all
        select flujodetalle_casillaid id, flujodetalle_casillanombre nombre, ifnull(historialvu_tiempominutos,round(time_to_sec(timediff('".date("Y-m-d H:i:s")."',historialvu_fechainicio))/60,2)) tiempo
        FROM global_historialvu 
        left join conf_flujodetalle on flujodetalle_casillaid = historialvu_casillaidfin
        where historialvu_tramitevuid = ".$tramitevuid." and flujodetalle_casillaid != 1
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
        $res2 = array();
        foreach ($res as $row){
            $res2[0][$row['id']] = $row['tiempo'];
        }
		$db->Close();
		return json_encode($res2);
    }
    
    function jsongraficahistorico2($tramitevuid){
        $sql = "
        select 'tramite' id, 'tramite' nombre, tramitevu_folio tiempo from global_tramitevu where tramitevu_id = ".$tramitevuid."
        union all
        select flujodetalle_casillaid id, flujodetalle_casillanombre nombre, historialvu_tiempominutos tiempo
        FROM global_historialvu 
        left join conf_flujodetalle on flujodetalle_casillaid = historialvu_casillaidfin
        where historialvu_tramitevuid = ".$tramitevuid." and flujodetalle_casillaid != 1
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
        $res2 = array();
        foreach ($res as $row){
            $res2[0][$row['id']] = $row['nombre'];
        }
		$db->Close();
		return json_encode($res2);
    }
    
    function updatecitavu($id,$fecha){
        $sql = "
            update global_tramitevu
            set tramitevu_cita = '".$fecha."'
            where tramitevu_id = ".$id." 
        ";
        $db = new DB();
        $db->Insert($sql);
    }
}