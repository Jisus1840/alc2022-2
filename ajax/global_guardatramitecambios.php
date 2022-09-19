<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda Trámite Cambios
* Entrada
                    [usuarioid] => 23
                    [licenciaid] => 1
                    subtramites
                    [domiciliolic] => irlanda 145
                    [estado] => COAHUILA DE ZARAGOZA
                    [estadoid] => 5
                    [municipio] => SALTILLO
                    [municipioid] => 66
                    [colonia] => Villa Olímpica
                    [coloniaid] => 478
                    [entrecalle] => carranza
                    [yentrecalle] => florencia
                    [latitud] => 25.458709553513312
                    [longitud] =>  -100.98294174565481
                    [adomiciliolic] => obsidiana 123
                    [aestado] => COAHUILA DE ZARAGOZA
                    [aestadoid] => 5
                    [amunicipio] => SALTILLO
                    [amunicipioid] => 66
                    [acolonia] => Miravalle
                    [acoloniaid] => 152
                    [aentrecalle] => 
                    [ayentrecalle] => 
                    [alatitud] => 25.396976326200360
                    [alongitud] => -100.998333444039050
                    [pnuevo] => rogm8402246j7
                    [pnuevoid] => 33
                    [personanombre] => MONICA SOFIA RORIGUEZ GARCIA
                    [direccion] => OBSIDIANA 123
                    [panteriorid] => 33
                    [cnuevo] => roas101010101
                    [cnuevoid] => 35
                    [personanombrec] => nombre 10
                    [direccionc] => domicilio 10
                    [canteriorid] => 
                    [nombregnuevo] => ng2
                    [nombreganterior] => monbre generico
                    [giroid] => 4
                    [giroanteriorid] => 5
                    usuarionombre,
                    correousuario
                    rfcusuario
* Salida
                
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
//Gral
$usuarioid = $_POST['usuarioid'];
$licenciaid = $_POST['licenciaid'];
$subtramites = $_POST['subtramites'];
$folio_licencia = substr($_POST['licencia'], 4);
//Cambio de Domicilio
$domiciliolic = (isset($_POST['domiciliolic']))?$_POST['domiciliolic']:'';
$domiciliolicnumext = (isset($_POST['domiciliolicnumext']))?$_POST['domiciliolicnumext']:'';
$estado = (isset($_POST['estado']))?$_POST['estado']:'';
$estadoid = (isset($_POST['estadoid']))?$_POST['estadoid']:'null';
$municipio = (isset($_POST['municipio']))?$_POST['municipio']:'';
$municipioid = (isset($_POST['municipioid']))?$_POST['municipioid']:'null';
$colonia = (isset($_POST['colonia']))?$_POST['colonia']:'';
$coloniaid = (isset($_POST['coloniaid']))?$_POST['coloniaid']:'null';
$entrecalle = (isset($_POST['entrecalle']))?$_POST['entrecalle']:'';
$yentrecalle = (isset($_POST['yentrecalle']))?$_POST['yentrecalle']:'';
$latitud = (isset($_POST['latitud']))?$_POST['latitud']:'';
$longitud = (isset($_POST['longitud']))?$_POST['longitud']:'';
$adomiciliolic = (isset($_POST['adomiciliolic']))?$_POST['adomiciliolic']:'';
$aestado = (isset($_POST['aestado']))?$_POST['aestado']:'';
$aestadoid = (isset($_POST['aestadoid']))?$_POST['aestadoid']:'null';
$amunicipio = (isset($_POST['amunicipio']))?$_POST['amunicipio']:'';
$amunicipioid = (isset($_POST['amunicipioid']))?$_POST['amunicipioid']:'null';
$acolonia = (isset($_POST['acolonia']))?$_POST['acolonia']:'';
$acoloniaid = (isset($_POST['acoloniaid']))?$_POST['acoloniaid']:'null';
$aentrecalle = (isset($_POST['aentrecalle']))?$_POST['aentrecalle']:'';
$ayentrecalle = (isset($_POST['ayentrecalle']))?$_POST['ayentrecalle']:'';
$alatitud = (isset($_POST['alatitud']))?$_POST['alatitud']:'';
$alongitud = (isset($_POST['alongitud']))?$_POST['alongitud']:'';

//Cambio de propietario
$pnuevo = (isset($_POST['pnuevo']))?$_POST['pnuevo']:'';
$pnuevoid = (isset($_POST['pnuevoid']))?$_POST['pnuevoid']:'null';
$personanombre = (isset($_POST['personanombre']))?$_POST['personanombre']:'';
$direccion = (isset($_POST['direccion']))?$_POST['direccion']:'';
$panteriorid = (isset($_POST['panteriorid']))?$_POST['panteriorid']:'null';
$personaidpropietario = (isset($_POST['pnuevoid']))?$_POST['pnuevoid']:'';

//Cambio Comodatario
$cnuevo = (isset($_POST['cnuevo']))?$_POST['cnuevo']:'';
$cnuevoid = (isset($_POST['cnuevoid']))?$_POST['cnuevoid']:'null';
$personanombrec = (isset($_POST['personanombrec']))?$_POST['personanombrec']:'';
$direccionc = (isset($_POST['direccionc']))?$_POST['direccionc']:'';
$canteriorid = (isset($_POST['canteriorid']))?$_POST['canteriorid']:'null';
$personaidcomodatario = (isset($_POST['cnuevoid']))?$_POST['cnuevoid']:'';

// Cambio nombre generico
$nombregnuevo = (isset($_POST['nombregnuevo']))?addslashes($_POST['nombregnuevo']):'';
$nombreganterior = (isset($_POST['nombreganterior']))?addslashes($_POST['nombreganterior']):'';

//Cambio de Giro
$giroid = (isset($_POST['giroid']))?$_POST['giroid']:'null';
$giroanteriorid = (isset($_POST['giroanteriorid']))?$_POST['giroanteriorid']:'null';

// Cambio de tipo de licencia 
$tipolicenciaid = (isset($_POST['tipolicenciaid']))?$_POST['tipolicenciaid']:'null';

if(isset($_POST['tramiteid'])) {
	$vu = new ventanilla();
	$vu->actualizar_tramitecambio(
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
		$tipolicenciaid,
		$folio_licencia,
		$_POST['tramiteid']
	);
	echo "1|Registro actualizado correctamente";
}
else {
	//Guarda Ventanilla
	$vu = new ventanilla();
	$lastid = $vu->guardar($_POST['usuarioid'],9,1,1,date("Y-m-d H:i:s"),'',$_POST['correousuario'],$_POST['rfcusuario'],$licenciaid);

	$tramite = new tramite();
	$lastidsolicitud = $tramite->guardarcambios(
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
		$lastid,
		$_POST['usuarionombre'],
		$_POST['correousuario'],
		$_POST['rfcusuario'],
		$tipolicenciaid,
		$folio_licencia
	);

	//consulta folio
	$folio = tramite::getfoliotramite($lastid);
	$hora = tramite::gethorainiciotramite($lastid);
	echo "1|".$folio."|".$hora;
}
?>