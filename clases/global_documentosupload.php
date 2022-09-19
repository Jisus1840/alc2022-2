<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase Documentos Upload
*********************************************************************************
*/
class documentosupload {
	
	function getalltipodocumentosactivos($tramitevu_tipotramiteid){
		$db = new DB();
		$sql = "SELECT * FROM cat_tipodocumentosupload 
		where tipodocumentosupload_activo = 1 and tipodocumentosupload_tipotramiteid = ".$tramitevu_tipotramiteid."
		order by tipodocumentosupload_numeracion asc";
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
	
	function getdocumentosuploadactivosbytramitevuid($tramitevuid){
		$db = new DB();
		$sql = "
		SELECT d.*, u.usuarios_nombre, td.tipodocumentosupload_id, td.tipodocumentosupload_nombre
		FROM global_documentosupload d
		left join cat_usuarios u on u.usuarios_id = d.documentosupload_usuariosid
		left join cat_tipodocumentosupload td on td.tipodocumentosupload_id = d.documentosupload_tipodocumentosuploadid
		where d.documentosupload_activo = 1 and d.documentosupload_tramitevuid = ".$tramitevuid."
		order by td.tipodocumentosupload_numeracion asc
		";
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
	
	function getdocumentosuploadinactivosbytramitevuid($tramitevuid){
		$db = new DB();
		$sql = "
		SELECT d.*, u.usuarios_nombre, td.tipodocumentosupload_id, td.tipodocumentosupload_nombre
		FROM global_documentosupload d
		left join cat_usuarios u on u.usuarios_id = d.documentosupload_usuariosid
		left join cat_tipodocumentosupload td on td.tipodocumentosupload_id = d.documentosupload_tipodocumentosuploadid
		where d.documentosupload_activo = 0 and d.documentosupload_tramitevuid = ".$tramitevuid."
		order by documentosupload_fechacreacion desc
		";
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
	
	function aprobar_desaprobar_documento($documentosupload_id, $is_checked) {
		$db = new DB();
		$sql = "UPDATE global_documentosupload SET documentosupload_aprobado = ".$is_checked." WHERE documentosupload_id = ".$documentosupload_id;
		$db->Insert($sql);
		$db->close();
	}
	
	function insertdocumentosupload($userid,$dir,$nombrearchivo,$tipodocumentosuploadid,$tramitevuid="null",$nombrearcivopersonalizado,$correousuario=''){
		$db = new DB();
		$sql = "
		insert into global_documentosupload
		(
			documentosupload_fechacreacion,
			documentosupload_tipodocumentosuploadid,
			documentosupload_nombrearchivo,
			documentosupload_ruta,
			documentosupload_usuariosid,
			documentosupload_activo,
			documentosupload_tramitevuid,
			documentosupload_nombrearchivopersonalizado
		)
		values
		(
			'".date('Y-m-d H:i:s')."',
			".$tipodocumentosuploadid.",
			'".$nombrearchivo."',
			'".$dir."',
			".$userid.",
			1,
			".$tramitevuid.",
			'".$nombrearcivopersonalizado."'
		)
		";

		$db->Insert($sql);
		
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		
		$lastinsert = $resultsql[0]['lastinsert'];
		
		$db->close();

        $usuario = ($userid == 'null' or $userid == '')?$correousuario:catalogos::getnombreusuariobyid($userid);
        $folio = tramite::getfoliotramite($tramitevuid);
        $bitacora = new bitacora();
        $bitacora->guardar('SOLICITUDES','SE GUARDÓ DOCUMENTO DE SOPORTE '.$nombrearcivopersonalizado.' AL FOLIO: '.$folio,$usuario,$tramitevuid);
        
	}

	
	function inactivardocumentobyid($id){
		$db = new DB();
		$sql = "
		update global_documentosupload
		set 
		documentosupload_activo = 0
		where documentosupload_id = ".$id."
		";
		$db->Insert($sql);
		$db->close();
		
		$info = $this->getinfodocumentobyid($id);
		
		return 1;
	}
	
	function reactivardocumentobyid($id){
		$db = new DB();
		$sql = "
		update global_documentosupload
		set 
		documentosupload_activo = 1
		where documentosupload_id = ".$id."
		";
		$db->Insert($sql);
		$db->close();
		
		$info = $this->getinfodocumentobyid($id);
		
		return 1;
	}

	function get_imagen_aviso() {
		$db = new DB();
		$sql = "select * from conf_avisos where id = 1";
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
	
	function getinfodocumentobyid($id){
		$db = new DB();
		$sql = "
		select * from global_documentosupload
		where documentosupload_id = ".$id."
		";
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
	
	# Función para traer las extensiones aceptadas por cada tipo de documento
	function get_extensiones_tipodocumentos_upload($tipodocumentosupload_id) {
		$db = new DB();
		$sql = "SELECT tipodocumentosupload_extension 
		FROM cat_tipodocumentosupload WHERE tipodocumentosupload_id = ".$tipodocumentosupload_id;
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
	
	function getinfodocumentobytramitevuid($tramitevuid, $tipodocumentosuploadid){
		$db = new DB();
		$sql = "select * from global_documentosupload
		where documentosupload_tramitevuid = ".$tramitevuid." and documentosupload_tipodocumentosuploadid = ".$tipodocumentosuploadid." and documentosupload_activo = 1";
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
	
	# Función para traer las imágenes del croquis
	function get_imagenes_croquis($tramitevuid) {
		$db = new DB();
		$sql = "SELECT * FROM global_documentosupload 
		WHERE documentosupload_tramitevuid = ".$tramitevuid." 
		AND documentosupload_tipodocumentosuploadid in (76,98,108)
		AND documentosupload_activo = 1";
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
}
?>