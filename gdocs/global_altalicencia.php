<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$lic = new licencias();
$datos = $lic->getinfobylicenciaid($_GET['id']);

$html = '
<table width="650px" border="0">
<tr>
    <td>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    COORDINACIÓN DE ALCOHOLES<br>
                    SOLICITUD PARA OBTENER LICENCIA DE ALCOHOLES<br>
                    <u>NUEVA CREACIÓN</u>
                </td>
            </tr>
        </table>
        <br><br>
        <table align="rigth" cellpadding="3">
            <tr>
                <td>
                    <b>FOLIO CA/005/2020</b><br>
                    <b>'.$datos[0]['tipolicencia_nombre'].'</b><br>
                </td>
            </tr>
        </table>
        <br><br>
        <table align="left" cellpadding="2" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>PROPIETARIO LICENCIA</b></td></tr>
            <tr><td><b>NOMBRE</b> '.$datos[0]['nombrepropietario'].'</td></tr>
            <tr><td><b>GIRO</b> '.$datos[0]['giro_nombre'].'</td></tr>
            <tr><td><b>NOMBRE GENÉRICO</b> '.$datos[0]['licencias_nombregenerico'].'</td></tr>
            <tr><td><b>DOMICILIO</b> '.$datos[0]['direccionpropietario'].' '.$datos[0]['coloniapropietario'].'</td></tr>
            <tr><td><b>RFC</b> '.$datos[0]['rfcpropietario'].'<b> CURP</b> '.$datos[0]['curppropietario'].'<b> TEL/CEL</b> '.$datos[0]['telefonopropietario'].' / '.$datos[0]['celularpropietario'].'</td></tr>
        </table>
        <br><br><br><br>
        <table align="left" cellpadding="2" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>DATOS COMODATARIO</b></td></tr>
            <tr><td><b>NOMBRE</b> '.$datos[0]['nombrecomodatario'].'</td></tr>
            <tr><td><b>DOMICILIO</b> '.$datos[0]['direccioncomodatario'].' '.$datos[0]['coloniacomodatario'].'</td></tr>
            <tr><td><b>TEL/CEL</b> '.$datos[0]['telefonocomodatario'].' / '.$datos[0]['celularcomodatario'].'</td></tr>
        </table>
        <br><br><br><br>
        <table align="left" cellpadding="2" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>UBICACIÓN FÍSICA DE LICENCIA</b></td></tr>
            <tr><td><b>DOMICILIO</b> '.$datos[0]['licencias_domicilio'].' <b>COLONIA</b> '.$datos[0]['colonia_nombre'].' <b>CP</b> '.$datos[0]['colonia_cp'].' <b>ZONA</b> '.$datos[0]['zona_nombre'].'</td></tr>
            <tr><td><b>Entre Calle </b> '.$datos[0]['licencias_entrecalle'].'<b> y Calle </b> '.$datos[0]['licencias_yentrecalle'].'</td></tr>
        </table>
        <br><br><br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    Decalara bajo protesta de decir verdad<br>
                    que los datos contenidos en esta<br>
                    Solicitud son ciertos
                </td>
            </tr>
        </table>
        <br><br><br><br><br><br>
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
        <br><br><br><br><br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    <b>Saltillo Coahuila a 5 de Marzo de 2020</b>
                </td>
            </tr>
        </table>
        <br><br><br><br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    _____________________________________<br>
                    ING. MIGUEL ANGEL LOZANO CANTÚ<br>
                    COORDINADOR DE ALCOHOLES
                </td>
            </tr>
        </table>
        <br><br><br><br>
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
        </table>
    </td>
</tr>

</table>
';

$generarpdf = new gdocs();
$generarpdf->generapdf($html,' ', 'I', '', '../imagenes/global_imagenes_bannerpdfbiochem.jpg', '../imagenes/global_imagenes_piepdfpurifika.jpg','P');
?>