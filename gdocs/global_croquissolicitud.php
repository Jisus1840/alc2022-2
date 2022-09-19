<? include_once ("../config/global_includes.php"); ?>
<?

date_default_timezone_set("America/Mexico_City");
$fecha = date("Y-m-d");

$d = new documentosupload();
$imagenes = $d->get_imagenes_croquis(base64_decode($_GET['tramitevuid']));
///if(count($imagenes) != 2) {
if (1 == 2) {
	echo '<script type="text/javascript">
        alert("Para poder generar este documento deberás subir primero las dos fotografías del negocio");
		window.close();
        </script>';
}
else {
	$imagen1 = $imagenes[0]['documentosupload_ruta'].'/'.$imagenes[0]['documentosupload_nombrearchivo'];
	$imagen2 = $imagenes[1]['documentosupload_ruta'].'/'.$imagenes[1]['documentosupload_nombrearchivo'];
	//GET DATOS
	$tramite = new tramite();
	$datos = $tramite->getinfotramitebytramitevu(base64_decode($_GET['tramitevuid']),base64_decode($_GET['tipotramitevu']));

	$folio = $datos[0]['folio'];
	
	if($datos[0]['tramitevu_tipotramiteid'] == 9) {
		$giro = $datos[0]['girocambio'] ? $datos[0]['girocambio'] : '';
		$nombre = $datos[0]['tramitecambio_nombrenuevo'] ? $datos[0]['tramitecambio_nombrenuevo'] : '';
		$domicilio = $datos[0]['tramitecambio_domicilionuevo'] ? $datos[0]['tramitecambio_domicilionuevo'] : '';
		$numext_domicilio = $datos[0]['tramitecambio_domicilionuevo_numext'] ? $datos[0]['tramitecambio_domicilionuevo_numext'] : '';
		$colonia = $datos[0]['colonianuevo'] ? $datos[0]['colonianuevo'] : '';
		$licencia = $datos[0]['tipo_licencia_anterior'].$datos[0]['licencias_licencia'];
	}
	else {
		$giro = $datos[0]['giro_nombre'] ? $datos[0]['giro_nombre'] : '';
		$nombre = $datos[0]['nombregenerico'] ? $datos[0]['nombregenerico'] : '';
		$domicilio = $datos[0]['domicilio'] ? $datos[0]['domicilio'] : '';
		$numext_domicilio = $datos[0]['domicilionumext'] ? $datos[0]['domicilionumext'] : '';
		$colonia = $datos[0]['nombrecolonia'] ? $datos[0]['nombrecolonia'] : '';
		$licencia = '';
	}
	$latitud = $datos[0]['latitud'];
	$longitud = $datos[0]['longitud'];
       
	$gmapUrl = 'http://maps.google.com/maps/api/staticmap?';
	$zoom = 16.5;
	$size = '700x350'; 
	$sensor='false'; 
	$format = 'gif'; 
	$color = 'red'; 
	$label = ''; 
	$saveFile = 'tmp.'. $format;
	
	$http_req = $gmapUrl. 'center='. $latitud. ','.$longitud. '&zoom='. $zoom. '&size='. $size. '&sensor='. $sensor. '&format='. $format;
	
	$http_req .= '&markers=color:'. $color. '|label:'. $label. '|'. $latitud. ','. $longitud.'&key=AIzaSyAMv3GeCle9P1XS_X_pr5n8tHX1sKs-dQo';

	//$image_map = file_get_contents($http_req);

	$html = '
	<table width="650px" border="0">
	<tr>
		<td>
			<table border="1" cellpadding="5px">
				<tr>
					<td colspan="2" bgcolor="lightgray">
						<b>DATOS GENERALES</b>
					</td>
				</tr>
				<tr>
					<td><b>NOMBRE GENÉRICO:</b> '.mb_strtoupper($nombre).'</td>
					<td><b>FECHA: </b>'.$fecha.'</td>
				</tr>
				<tr>
					<td><b>UBICACIÓN:</b> '.mb_strtoupper($domicilio).' '.$numext_domicilio.'</td>
					<td><b>COL.</b> '.mb_strtoupper($colonia).'</td>
				</tr>
				<tr>
					<td><b>GIRO:</b> '.mb_strtoupper($giro).'</td>
					<td><b>LICENCIA NO.</b> '.$licencia.'</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table border="1" cellpadding="5px">
				<tr>
					<td bgcolor="lightgray">
						<b>UBICACIÓN</b>
					</td>
				</tr>
				<tr>
					<td style="text-align: center;">
						<img src="'.$http_req.'" style="width:630;height:340;">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table>
				<tr>
					<td colspan="3"><br><br>Art. 11 Se debe guardar una distancia no menor de 100 metros perimetrales entre las siguientes:</td>
				</tr>
				<tr>
					<td>1.- CENTRO EDUCATIVO</td>
					<td>5.- MERCADOS</td>
					<td>9.- CENTROS CULTURALES</td>
				</tr>
				<tr>
					<td>2.- HOSPITALES</td>
					<td>6.- CUARTELES</td>
					<td>10.- TEMPLOS RELIGIOSOS</td>
				</tr>
				<tr>
					<td>3.- PARQUES Y JARDINES PUBLICOS</td>
					<td>7.- OFICINAS PÚBLICAS</td>
					<td></td>
				</tr>
				<tr>
					<td>4.- INSTALACIONES DEPORTIVAS</td>
					<td>8.- FABRICAS</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3">OBSERVACIONES: <br>_____________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: center;">
						NOMBRE, FIRMA Y NO. EMPLEADO RESPONSABLE<br>
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: center;">
					_____________________________________________________________
					</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: center;">Nombre y Firma</td>
				</tr>
				<tr>
					<td colspan="3" style="text-align: center;">No. Empleado __________</td>
				</tr>
				<tr>
					<td colspan="3">
						Fundamento Legal:
						<br>Art. 43 Para obtener licencia de cualquiera de las modalidades
						<br>Fracc. II. Inciso n) Croquis de ubicación con cumplimiento en Art. 11
						<br>Art. 11 Las distancias de ubicación que se deben observar (arriba mencionadas)
						<br>Del Art 11 se omiten para los siguientes giros: centros educativos, hospitales, parques y jardines públicos, instalaciones deportivas, mercados, cuarteles, oficinas públicas, fábricas, centros culturales y templos religiosos. 
						<br>Art. 18 Venta de bebidas alcohólicas en modalidad envase cerrado: supermercados, tiendas de conveniencia y tiendas departamentales
						<br>Art. 19 Venta de bebidas alcohólicas envase abierto o al copeo: restaurante, centros de espectáculos deportivos o recreativos, club social, club social deportivo y semejante, hotel y motel y cine.
					</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
';	
/*
	<br><br><br>
	
	<table cellpadding="10px" border="0" align="center">
		<tr>
			<td>
				<b>Fotografía 1</b><br>
				<img src="'.$imagen1.'" style="width:550px;height:300px;" />
			</td>
		</tr>
		<tr>
			<td>
				<b>Fotografía 2</b><br>
				<img src="'.$imagen2.'" style="width:550px;height:300px;" />
			</td>
		</tr>
	</table>
	';
*/	
	$generarpdf = new gdocs();
	$generarpdf->generapdf($html,'CROQUIS DE UBICACIÓN', 'I', '', '../images/logo2.png', '','P','Letter','9',$GLOBALS['vu_global_site'].'gui/global_consultastatus.php?folio='.$datos[0]['folio'].'&hora=1:21',$datos[0]['tramitevu_folio']);
}
