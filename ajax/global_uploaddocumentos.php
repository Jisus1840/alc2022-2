<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX QUE CARGA DOCUMETOS A UN tramite de ventanilla
* DATOS ENTRADA POST 	tramitevuid
						userid
						inputuploaddocs
						tipodocumentoupload
						nombrearcivopersonalizado
* DATOS DE SALIDA json	1 o 0
*****************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
$bloque = date("ymdHis")."-".rand(10000,99999);
$tramitevuid = $_POST['tramitevuid'];
$userid = $_POST['userid'];
$nombrearcivopersonalizado = $_POST['nombrearcivopersonalizado'];
$tipodocumentoupload = $_POST['tipodocumentoupload'];
$ext_archivo = $_POST['ext_archivo'];

$dir = '../uploads/tramites/'.$tramitevuid;
$nombrearchivo = $bloque.".".$extension;

$documentos = new documentosupload();
$extensiones = $documentos->get_extensiones_tipodocumentos_upload($tipodocumentoupload);
$extensiones_aceptar = explode(",", $extensiones[0]['tipodocumentosupload_extension']);

$extension_correcta = false;
for($i = 0; $i < count($extensiones_aceptar); $i++) {
	if(trim($extensiones_aceptar[$i]) == $ext_archivo) {
		$extension_correcta = true;
	}
}
if($extension_correcta == false) {
	echo "Formato de archivo no válido. Formatos aceptados para este número de archivo: ".$extensiones[0]['tipodocumentosupload_extension'];
}
else {
	$docs_existentes = $documentos->getinfodocumentobytramitevuid($tramitevuid, $tipodocumentoupload);
	if($docs_existentes) {
		echo 2;
	}
	else {
		//Crea directorio si no existe
		if (!is_dir($dir)) {
			mkdir($dir, 0777, true);
			chmod($dir, 0777);     
		}

		if (move_uploaded_file($_FILES['inputuploaddocs']['tmp_name'], $dir."/".$bloque.".".$extension)){
			//Guarda en base de datos
			$documentos = new documentosupload();
			$documentos->insertdocumentosupload($userid,$dir,$nombrearchivo,$tipodocumentoupload,$tramitevuid,$nombrearcivopersonalizado);
			echo 1;
		}
	}
}
?>