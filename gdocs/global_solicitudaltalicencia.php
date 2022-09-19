<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$tramite = new tramite();
$datos = $tramite->getinfotramitebytramitevu(base64_decode($_GET['tramitevuid']),base64_decode($_GET['tipotramitevu']));
$meses = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
$calles = $datos[0]['tramitealtalicencia_entrecalle'];
if($datos[0]['tramitealtalicencia_yentrecalle']) {
	$calles .= ' y '.$datos[0]['tramitealtalicencia_yentrecalle'];
}

$html = '
<table width="650px" border="0">
<tr>
    <td>
		<table align="rigth" cellpadding="3">
            <tr>
                <td>
					<b>FOLIO:</b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/'.date("Y").'</u><br><br>
                    <!--<b>FOLIO:</b> <u>'.$datos[0]['tramitealtalicencia_folio'].'</u><br><br>-->
                </td>
            </tr>
        </table>
		<br>
        <table align="left" cellpadding="3" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>PROPIETARIO LICENCIA</b></td></tr>
            <tr><td><b>NOMBRE:</b> '.$datos[0]['nombrep'].'</td></tr>
            <tr><td><b>GIRO:</b> '.$datos[0]['giro_nombre'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>TIPO:</b> '.$datos[0]['tipolicencia_nombre'].'</td></tr>
            <tr><td><b>NOMBRE GENÉRICO:</b> '.$datos[0]['tramitealtalicencia_nombregenerico'].'</td></tr>
            <tr><td><b>DOMICILIO:</b> '.$datos[0]['direccionp'].' <b>Núm. ext:</b>'.$datos[0]['numext_p'].' <b>Col.</b>'.mb_strtoupper($datos[0]['coloniap']).'</td></tr>
            <tr><td><b>R.F.C. (con homonimia): </b> '.$datos[0]['rfcp'].'<b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CURP: </b> '.$datos[0]['curpp'].'</td></tr>
			<tr><td><b> TEL/CEL:</b> '.$datos[0]['telefonop'].' - '.$datos[0]['celularp'].'</td></tr>
        </table>
        <br><br><br><br>
        <table align="left" cellpadding="3" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>DATOS COMODATARIO</b></td></tr>
            <tr><td><b>NOMBRE:</b> '.$datos[0]['nombrec'].'</td></tr>
            <tr><td><b>DOMICILIO:</b> '.$datos[0]['direccionc'].' <b>Núm. ext: </b>'.$datos[0]['numext_c'].' <b>Col.</b> '.mb_strtoupper($datos[0]['coloniac']).'</td></tr>
            <tr><td><b>R.F.C. (con homonimia): </b> .'.$datos[0]['rfcc'].' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>CURP:</b> '.$datos[0]['curpc'].'</td></tr>
            <tr><td><b>TEL/CEL:</b> '.$datos[0]['telefonoc'].' - '.$datos[0]['celularc'].'</td></tr>
        </table>
        <br><br><br><br>
        <table align="left" cellpadding="3" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>UBICACIÓN FÍSICA DE LICENCIA</b></td></tr>
            <tr><td><b>CALLE:</b> '.$datos[0]['tramitealtalicencia_domicilio'].' <b>Núm. ext: </b>'.$datos[0]['domicilionumext'].'</td></tr>
			<tr><td><b>COLONIA:</b> '.mb_strtoupper($datos[0]['nombrecolonia']).'</td></tr>
            <tr><td><b>ENTRE LAS CALLES DE: </b> '.$calles.'</td></tr>
        </table>
        <br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    <b><br>Declara bajo protesta de decir verdad<br>
                    que los datos contenidos en esta<br>
                    Solicitud son ciertos.</b>
                </td>
            </tr>
        </table>
        <br><br><br><br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    _____________________________________<br>
                    Nombre y firma del Propietario
                </td>
                <td>
                    _____________________________________<br>
                    Nombre y firma del Comodatario
                </td>
            </tr>
        </table>
        <br><br><br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
				<b>Saltillo, Coahuila a '.date('d')." de ".$meses[date('n')-1]. " del ".date('Y').'</b>
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
        </table>-->
        <br><br><br><br>
        <table align="left" cellpadding="3" border="0">
            <tr>
                <!--<td width="280px">
                    <br><br>Para llenado de Fiscalización<br><br>Autorizada Si __ No __<br><br>Autorización de Cabildo mediante Minuta No. _______________________ 
                    <br>y Acuerdo No. _____________________ <br><br>
                    De Fecha __________ de _________________________ de _________
                </td>-->
				<td width="240px">
				</td>
                <!--<td width="175px" valign="bottom">
                    ||QR||
                </td>-->
                <td width="200px" valign="bottom">
					<br><br><br>
                    ||CB||
                </td>
				</td width="150px">
				</td>
            </tr>
        </table>
    </td>
</tr>

</table>
';

$generarpdf = new gdocs();
$generarpdf->generapdf($html,'COORDINACION DE ALCOHOLES<br>
SOLICITUD PARA OBTENER LICENCIA DE ALCHOLES', 'I', '', '../images/logo2.png', '','P','Letter','9',$GLOBALS['vu_global_site'].'gui/global_consultastatus.php?folio='.$datos[0]['tramitealtalicencia_folio'].'&hora=1:21',$datos[0]['tramitevu_folio']);