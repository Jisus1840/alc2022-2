<? include_once ("../config/global_includes.php"); ?>
<?

$html = '
<br><br><table border="1" class="table" style="text-align: justify;" cellpadding="4" cellspacing="0">
	<tr>
		<td style="width: 50px">
			1
		</td>
		<td style="width: 290px">
			LLENAR FORMATO DE SOLICITUD AL COORDINADOR DE ALCOHOLES. <b>(SOLICITARLO EN ALCOHOLES)</b> SEÑALANDO MOTIVO DEL EVENTO O 
			CELEBRACIÓN, FECHA Y HORARIO. <b>MIGUEL ANGEL LOZANO CANTU. TITULAR DE LA UNIDAD ADMINISTRATIVA DE ALCOHOLES</b>. CON 15 DÍAS
			HÁBILES ANTERIOR AL EVENTO, PRESENTANDO EL EXPEDIENTE DEBIDAMENTE INTEGRADO.
		</td>
		<td style="width: 290px">
			LO GENERA EL SISTEMA.
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			2
		</td>
		<td style="width: 290px">
			<b>PERSONA FÍSICA:</b> CREDENCIAL DE ELECTOR U OTRA IDENTIFICACIÓN OFICIAL VIGENTE DEL SOLICITANTE. Y R.F.C. DEL QUE FIRME EL OFICIO DE
			SOLICITUD DEL EVENTO.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			3
		</td>
		<td style="width: 290px">
			<b>PERSONA MORAL:</b> ACTA CONSTITUTIVA Y CREDENCIAL DE ELECTOR U OTRA IDENTIFICACIÓN OFICIAL.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			4
		</td>
		<td style="width: 290px">
			COPIA DE RECIBO DE TRÁMITE DE LA CARTA DE LIBERACIÓN ANTE LA JEFATURA DE LA UNIDAD DE PROTECCIÓN CIVIL.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			5
		</td>
		<td style="width: 290px">
			COMPROBANTE DE DOMICILIO DEL SOLICITANTE (VIGENCIA MÁX. 1 MES).
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			6
		</td>
		<td style="width: 290px">
			CONSENTIMIENTO MAYORITARIO DE VECINOS COLINDANTES (RANGO NO MAYOR A 40 MTS. PERIMETRALES).
			(FORMATO PROPORCIONADO POR COORDINACIÓN DE ALCOHOLES).
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			7
		</td>
		<td style="width: 290px">
			PERMISO DE ESPECTÁCULOS Y PAGO DE DERECHOS.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			8
		</td>
		<td style="width: 290px">
			2 FOTOGRAFÍAS DEL NEGOCIO Y CROQUIS DE UBICACIÓN DEL ÁREA DE VENTA, CONSUMO O SERVICIO (DENTRO DEL ESTABLECIMIENTO).(EL CROQUIS LO GENERA EL SISTEMA UNA VEZ SUBIDAS LAS DOS FOTOGRAFÍAS). IMPRIME ESTE DOCUMENTO EN UNA SOLA HOJA, DE TAL FORMA QUE LAS FOTOGRAFÍAS ESTÉN EN LA PARTE TRASERA DEL CROQUIS.
		</td>
		<td style="width: 290px">
			LAS FOTOGRAFÍAS DEBERÁN ESTAR EN ORIENTACIÓN <i>HORIZONTAL</i> Y EN FOTMATO <i>JPG, JPEG Ó PNG</i>.
			<br>* FOTOGRAFÍA 1: SERÁ DEL FRENTE DEL NEGOCIO.
			<br>* FOTOGRAFÍA 2: SERÁ DEL FRENTE DEL NEGOCIO A UNA DISTANCIA DE APROX. 10 METROS, DONDE APAREZCA LA PARTE FRONTAL NEGOCIO Y LOS ALREDEDORES.
		</td>
	</tr>
	<tr>	
		<td style="width: 50px">
			9
		</td>
		<td style="width: 290px">
			EN CASO DE QUE EL EVENTO SE REALICE EN UN EJIDO DEBERÁ CONTAR CON VISTO BUENO DE DESARROLLO RURAL. TRAMITAR EN OFICINAS UBICADAS EN CALLE 16 DE SEPTIEMBRE S/NO. COLONIA 
			CENTENARIO. TELÉFONO 4-14-27-14.
		</td>
		<td style="width: 290px">
			TRAMITAR EN OFICINAS UBICADAS EN: DIRECCIÓN DE DESARROLLO RURAL DEL MUNICIPIO<br>
		CALLE 16 DE SEPTIEMBRE S/NO. <br>COLONIA CENTENARIO.<br>
		TELÉFONO: 844 414 2714
		</td>
	</tr>
	<tr>	
		<td style="width: 50px">
			10
		</td>
		<td style="width: 290px">
			PAGO DE DERECHOS.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			11
		</td>
		<td style="width: 290px">
			LA COORDINACIÓN REMITE SOLICITUD A LA COMISIÓN DE ALCOHOLES, INTEGRADA POR CUATRO REGIDORES DEL R. AYUNTAMIENTO DE SALTILLO.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			12
		</td>
		<td style="width: 290px">
			LA COMISIÓN DE ALCOHOLES AUTORIZA O RECHAZA LA SOLICITUD.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
	<tr>
		<td style="width: 50px">
			13
		</td>
		<td style="width: 290px">
			LA COORDINACIÓN INFORMA A LOS INTERESADOS DEL RESULTADO DE LA COMISIÓN, SI FUE AUTORIZADO, EL PERMISO ESPECIAL SE OTORGA, PREVIO PAGO DE 
			LOS DERECHOS ESTABLECIDOS.
		</td>
		<td style="width: 290px">
		</td>
	</tr>
</table>

';

$generarpdf = new gdocs();
$generarpdf->generapdf($html,'<h2>REQUISITOS PARA TRAMITAR UN PERMISO ESPECIAL</h2>', 'I', '', '../images/logo2.png', '','P','Legal','9','','');