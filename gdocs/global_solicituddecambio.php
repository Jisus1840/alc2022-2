<? //include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$tramite = new tramite();
$datos = $tramite->getinfotramitebytramitevu(base64_decode($_GET['tramitevuid']),base64_decode($_GET['tipotramitevu']));

$img_square = '<img align="center" src="../images/square.jpg" width="33" height="33">';
$img_checked = '<img align="center" src="../images/checked_square.png" width="33" height="33">';
$img_nombre_generico = $img_square;
$img_domicilio = $img_square;
$img_comodatario = $img_square;
$img_propietario = $img_square;
$img_giro = $img_square;
$img_tipo_licencia = $img_square;


$direccionp = '<b>Calle: </b>'.$datos[0]['direccionp'];
if ($direccionp) {
	$direccionp .= ' <b>Núm. ext: </b>'.$datos[0]['numext_p'].' <b>Col: </b>'.mb_strtoupper($datos[0]['coloniap']).' <b>C.P. </b>'.$datos[0]['codpp'];
}

$direccion_negocio = $datos[0]['licencias_domicilio'].' <b>Núm. ext: </b>'.$datos[0]['licencias_domicilio_numext'].', <b>Col.</b> '.mb_strtoupper($datos['colonia_nombre_negocio']);

switch (base64_decode($_GET['tipotramitevu'])){
	//Cualquier cambio 
	case 9:
	
	// Datos comodatario anterior 
	if($datos[0]['tramitecambio_comodatarioidanterior']) {
		$nombre_comodatario_anterior = $datos[0]['razonsocial_canterior'];
	}
	else {
		$nombre_comodatario_anterior = $datos[0]['nombrec'];
	}


/*$datos[0]['nombrec']
$direccionc
$datos[0]['licencias_nombregenerico']*/


		$folio = "";
		// Cambio de nombre genérico
        $nombregenerico = $datos[0]['tramitecambio_nombrenuevo'];
		if($nombregenerico) {
			$img_nombre_generico = $img_checked;
		}
		
		// Cambio de propietario
        $nombrennuevop = $datos[0]['nombrenuevop'];
		if($nombrennuevop) {
			$img_propietario = $img_checked;
			$rfcnuevop = $datos[0]['rfcnuevop'];
			$curpnuevop = $datos[0]['curpnuevop'];
			$telnuevop = $datos[0]['telnuevop'];
			$celnuevop = $datos[0]['celnuevop'];
			$domicilionnuevop = $datos[0]['domicilionuevop'].' <b>Núm. ext: </b>'.$datos[0]['domicilionump'].' <b>Col. </b>'.mb_strtoupper($datos[0]['colonia_nombre_np']);
		}
		
		// Cambio de comodatario
		$nombrennuevoc = $datos[0]['nombrenuevoc'];
		if($nombrennuevoc) {
			$img_comodatario = $img_checked;
			$rfcnuevoc = $datos[0]['rfcc'];
			$curpnuevoc = $datos[0]['curpnuevoc'];
			$telnuevoc = $datos[0]['telnuevoc'];
			$celnuevoc = $datos[0]['celnuevoc'];
			$domicilionnuevoc = $datos[0]['domicilionuevoc'].' <b>Núm. ext: </b>'.$datos[0]['domicilionuevonumc'].' <b>Col. </b>'.mb_strtoupper($datos[0]['colonia_nombre_nc']);
		}
		
		// Cambio de domicilio
		$cambiodomiciliodomicilio = $datos[0]['tramitecambio_domicilionuevo'];
		if($cambiodomiciliodomicilio) {
			$img_domicilio = $img_checked;
			$cambiodomiciliocolonia = mb_strtoupper($datos[0]['colonianuevo']);
			if($cambiodomiciliodomicilio) {
				$cambiodomiciliodomicilio .= ' <b>Núm. ext: </b>'.$datos[0]['tramitecambio_domicilionuevo_numext'].", <b>Col.</b> ".mb_strtoupper($cambiodomiciliocolonia);
			}
			$cambiodomicilioentrecalle = $datos[0]['tramitecambio_domicilioentrecallenuevo'];
			$cambiodomicilioyentrecalle = $datos[0]['tramitecambio_domicilioyentrecallenuevo'];
			if($cambiodomicilioyentrecalle) {
				$cambiodomicilioentrecalle .= " <b>Y CALLE</b> ".$cambiodomicilioyentrecalle;
			}
		}
	
		// Cambio de giro
		$giro = $datos[0]['girocambio'];
		if($giro) {
			$giro_inicial = $datos[0]['giro_nombre'];
			$img_giro = $img_checked;
		}
		
		// Cambio de tipo de licencia 
		$tipo_licencia_nuevo = $datos[0]['tipo_licencia_nuevo'];
		if($tipo_licencia_nuevo) {
			$img_tipo_licencia = $img_checked;
			$tipo_licencia_anterior = $datos[0]['tipo_licencia_anterior'];
		}
		break;
    //Cambio Domicilio
    case 6:
        $folio = $datos[0]['tramitecambiodomicilio_folio'];
        $giro = "";
        $nombregenerico = "";
        $rfcnuevop = "";
        $curpnuevop = "";
        $telnuevop = "";
        $celnuevop = "";
        $nombrennuevop = "";
        $domicilionnuevop = "";
        $rfcnuevoc = $datos[0]['rfcc'];
        $curpnuevoc = "";
        $telnuevoc = "";
        $celnuevoc = "";
        $nombrennuevoc = "";
        $domicilionnuevoc = "";
        $cambiodomiciliocolonia = $datos[0]['colonianuevo'];
        $cambiodomiciliodomicilio = $datos[0]['tramitecambiodomicilio_domicilionuevo'];
        $cambiodomicilioentrecalle = $datos[0]['tramitecambiodomicilio_entrecallenuevo'];
		$cambiodomicilioyentrecalle = $datos[0]['tramitecambiodomicilio_yentrecallenuevo'];
		if($cambiodomicilioyentrecalle) {
			$cambiodomicilioentrecalle .= " <b>Y CALLE</b> ".$cambiodomicilioyentrecalle;
		}
    
        break;
    //Cambio Giro
    case 5:
        $folio = $datos[0]['tramitecambiogiro_folio'];
        $giro = $datos[0]['girocambio'];
        $nombregenerico = "";
        $rfcnuevop = "";
        $curpnuevop = "";
        $telnuevop = "";
        $celnuevop = "";
        $nombrennuevop = "";
        $domicilionnuevop = "";
        $rfcnuevoc = $datos[0]['rfcc'];
        $curpnuevoc = "";
        $telnuevoc = "";
        $celnuevoc = "";
        $nombrennuevoc = "";
        $domicilionnuevoc = "";
        $cambiodomiciliocolonia = "";
        $cambiodomiciliodomicilio = "";
        $cambiodomicilioentrecalle = "";
        $cambiodomicilioyentrecalle = "";
        break;
    //Cambio Propietario
    case 4:
        $folio = $datos[0]['tramitecambiopropietario_folio'];
        $nombregenerico = "";
        $giro = "";
        $rfcnuevop = $datos[0]['rfcnuevop'];
        $curpnuevop = $datos[0]['curpnuevop'];
        $telnuevop = $datos[0]['telnuevop'];
        $celnuevop = $datos[0]['celnuevop'];
        $nombrennuevop = $datos[0]['nombrenuevop'];
        $domicilionnuevop = $datos[0]['domicilionuevop'];
        $rfcnuevoc = $datos[0]['rfcc'];
        $curpnuevoc = "";
        $telnuevoc = "";
        $celnuevoc = "";
        $nombrennuevoc = "";
        $domicilionnuevoc = "";
        $cambiodomiciliocolonia = "";
        $cambiodomiciliodomicilio = "";
        $cambiodomicilioentrecalle = "";
        $cambiodomicilioyentrecalle = "";
        break;
    //Cambio Comodatario
    case 3:
        $folio = $datos[0]['tramitecambiocomodatario_folio'];
        $nombregenerico = "";
        $giro = "";
        $rfcnuevop = "";
        $curpnuevop = "";
        $telnuevop = "";
        $celnuevop = "";
        $nombrennuevop = "";
        $domicilionnuevop = "";
        $rfcnuevoc = $datos[0]['rfcc'];
        $curpnuevoc = $datos[0]['curpnuevoc'];
        $telnuevoc = $datos[0]['telnuevoc'];
        $celnuevoc = $datos[0]['celnuevoc'];
        $nombrennuevoc = $datos[0]['nombrenuevoc'];
        $domicilionnuevoc = $datos[0]['domicilionuevoc'];
        $cambiodomiciliocolonia = "";
        $cambiodomiciliodomicilio = "";
        $cambiodomicilioentrecalle = "";
        $cambiodomicilioyentrecalle = "";
        break;
    //Cambio Nombre Genérico
    case 2:
        $folio = $datos[0]['tramitecambionombregenerico_folio'];
        $nombregenerico = $datos[0]['tramitecambionombregenerico_nombrenuevo'];
        $giro = "";
        $rfcnuevop = "";
        $curpnuevop = "";
        $telnuevop = "";
        $celnuevop = "";
        $nombrennuevop = "";
        $domicilionnuevop = "";
        $rfcnuevoc = $datos[0]['rfcc'];
        $curpnuevoc = "";
        $telnuevoc = "";
        $celnuevoc = "";
        $nombrennuevoc = "";
        $domicilionnuevoc = "";
        $cambiodomiciliocolonia = "";
        $cambiodomiciliodomicilio = "";
        $cambiodomicilioentrecalle = "";
        $cambiodomicilioyentrecalle = "";
        break; 
}
$html = '
<table width="650px" border="0" cellpadding="5">
<tr>
    <td>
        <table align="rigth" cellpadding="3">
            <tr>
                <td>
                    <!--<b>FOLIO</b> <u>'.$folio.'</u><br>
                    <b>LICENCIA:</b> <u>'.$datos[0]['licencias_licencia'].'</u><br>-->
					<b>FOLIO No.</b> _____________________<br>
					<span style="font-size: 9px;">(Asignado por la Coordinación de Alcoholes)</span>
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
	<td>
		<span style="text-align: center; font-size: 16px;"><b>PROPIETARIO DE LA LICENCIA</b></span>
	</td>
</tr>
<tr>
	<td>
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr><td><b>LICENCIA NÚMERO:</b> '.$datos[0]['tipo_licencia_anterior'].$datos[0]['licencias_licencia'].'</td></tr>
            <tr><td><b>NOMBRE COMPLETO DEL PROPIETARIO:</b> '.$datos[0]['nombrep'].'</td></tr>
			<tr>
				<td><b>DOMICILIO:</b> '.$direccionp.'</td>
			</tr>
            <tr><td><b>GIRO:</b> '.$datos[0]['giro_nombre'].'</td></tr>
            <!--<tr><td><b>NOMBRE GENÉRICO</b> '.$datos[0]['licencias_nombregenerico'].'</td></tr>-->
            <tr>
				<td style="width: 50%"><b>R.F.C. (con Homonimia):</b> '.$datos[0]['rfcp'].'</td>
				<td style="width: 50%"><b>CURP:</b> '.$datos[0]['curpp'].'</td>
			</tr>
        </table>
	</td>
</tr>
<tr>
	<td>   		
		<span style="text-align: center; font-size: 16px;">
			<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;DATOS DEL COMODATARIO Y DOMICILIO DEL NEGOCIO ANTERIOR</b>
		</span>
	</td>
</tr>
<tr>
	<td>
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr><td><b>NOMBRE COMPLETO DEL COMODATARIO:</b> '.$nombre_comodatario_anterior.'</td></tr>
            <tr><td><b>CALLE, NÚMERO Y COLONIA DEL NEGOCIO: </b>'.$direccion_negocio.'</td></tr>
            <tr><td><b>NOMBRE GENÉRICO: </b> '.$datos[0]['licencias_nombregenerico'].'</td></tr>
        </table>
    </td>
</tr>
<tr>
	<td>
		<span style="text-align: center; font-size: 16px;"><b>MARCAR Y LLENAR EL TIPO DE TRÁMITE QUE SE VA A REALIZAR</b></span>
	</td>
</tr>
<tr>
	<td>
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr>
				<td align="center;"><b><span style="font-size: 14px;">CAMBIO DE DOMICILIO</span></b></td>
			</tr>
			<tr>
				<td style="width: 595px;"><b>CALLE, NÚMERO Y COLONIA: </b>'.mb_strtoupper($cambiodomiciliodomicilio).'</td>
				<td style="width: 40px;" rowspan="2">
					'.$img_domicilio.'
				</td>
			</tr>
			<tr>
				<td><b>ENTRE CALLES DE: </b>'.mb_strtoupper($cambiodomicilioentrecalle).'</td>
			</tr>
        </table>
	</td>
</tr>
<tr>
	<td>
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr>
				<td align="center" style="width: 595px;"><b><span style="font-size: 14px;">CAMBIO DE NOMBRE GENÉRICO</span></b></td>
				<td style="width: 40px;" rowspan="2">
					'.$img_nombre_generico.'
				</td>
			</tr>
			<tr><td><b>NOMBRE GENÉRICO: </b>'.$nombregenerico.'</td></tr>
        </table>
	</td>
</tr>
<tr>
	<td>	
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr>
				<td align="center;"><b><span style="font-size: 14px;">CAMBIO DE COMODATARIO</span></b></td>
			</tr>
			<tr>
				<td style="width: 595px;"><b>COMODATARIO: </b>'.$nombrennuevoc.'</td>
				<td style="width: 40px;" rowspan="3">
					'.$img_comodatario.'
				</td>
			</tr>
			<tr>
				<td><b>DOMICILIO: </b>'.$domicilionnuevoc.'</td>
			</tr>
			<tr>
				<td style="width: 50%;"><b>R.F.C. (Con Homonimia): </b>'.$rfcnuevoc.'</td>
				<td style="width: 50%;"><b>CURP:</b> '.$curpnuevoc.'</td>
			</tr>
			<tr><td><b>TEL/CEL: </b>'.$telnuevoc.' - '.$celnuevoc.'</td></tr>
        </table>		
	</td>
</tr>
<tr>
	<td>
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr>
				<td align="center;"><b><span style="font-size: 14px;">CAMBIO DE PROPIETARIO</span></b></td>
			</tr>
			<tr>
				<td style="width: 595px;"><b>NOMBRE PROPIETARIO: </b>'.$nombrennuevop.'</td>
				<td style="width: 40px;" rowspan="4">
					'.$img_propietario.'
				</td>
			</tr>
			<tr>
				<td><b>DOMICILIO: </b>'.$domicilionnuevop.'</td>
			</tr>
			<tr>
				<td style="width: 50%;"><b>R.F.C. (Con Homonimia): </b>'.$rfcnuevop.'</td>
				<td style="width: 50%;"><b>CURP:</b> '.$curpnuevop.'</td>
			</tr>
			<tr><td><b>TEL/CEL: </b>'.$telnuevop.' - '.$celnuevop.'</td></tr>
        </table>
	</td>
</tr>
<tr>
	<td>
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr>
				<td align="center;" style="width: 595px;"><b><span style="font-size: 14px;">CAMBIO DE GIRO</span></b></td>
				<td style="width: 40px;" rowspan="2">
					'.$img_giro.'
				</td>
			</tr>
			<tr>
				<td style="width: 50%;"><b>GIRO DE: </b>'.$giro_inicial.'</td>				
				<td style="width: 50%;"><b>A: </b>'.$giro.'</td>
			</tr>
        </table>
	</td>
</tr>
<tr>
	<td>
        <table align="left" cellpadding="2" style="border:3px solid black;">
			<tr>
				<td align="center" style="width: 595px;"><b><span style="font-size: 14px;">CAMBIO DE TIPO DE LICENCIA</span></b></td>
				<td style="width: 40px;" rowspan="2">
					'.$img_tipo_licencia.'
				</td>
			</tr>
			<tr>
				<td style="width: 50%;"><b>TIPO DE: </b>'.$tipo_licencia_anterior.'</td>				
				<td style="width: 50%;"><b>A: </b>'.$tipo_licencia_nuevo.'</td>
			</tr>
        </table>
	</td>
</tr>
<tr>
	<td>
		<span style="text-align: center;">
			Declara bajo protesta de decir verdad que los datos contenidos en esta Solicitud son ciertos.
		</span>
	</td>
</tr>
<tr>
	<td>	
        <br><br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    _____________________________________<br>
                    Nombre y firma del Propietario ó Representante Legal
                </td>
                <td>
                    _____________________________________<br>
                    Nombre y firma del Comodatario
                </td>
            </tr>
        </table>
        <br>
        <table align="center" cellpadding="3">
            <tr>
				<td style="width: 50px">
				</td>
				<td style="width: 140px">
					||CB||
				</td>
                <td style="width: 400px">
					<br><br><br>
                    <b>Saltillo Coahuila a _____ de _______________ del '.date("Y").'</b>
                </td>
            </tr>
        </table>
        <!--<br><br><br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    _____________________________________<br>
                    ING. MIGUEL ANGEL LOZANO CANTÚ<br>
                    COORDINADOR DE ALCOHOLES
                </td>
            </tr>
        </table>
        <br><br><br>
        <table align="left" cellpadding="3">
            <tr>
                <td>
                    _________________________________________________________________________________________________________________________________________________________<br>
                    <br><br>
                    Para llenado de Fiscalización<br><br>
                    Autorizada Si __ No __<br><br>
                    Autorización de Cabildo mediante Minuta No. _______________________ y Acuerdo No. _____________________ <br><br>
                    De Fecha __________ de _________________________ de _________
                </td>
            </tr>
        </table>-->
    </td>
</tr>

</table>
';

$generarpdf = new gdocs();
$generarpdf->generapdf($html, 1, 'I', '', '', '','P','Letter','9','',$datos[0]['tramitevu_folio']);
?>