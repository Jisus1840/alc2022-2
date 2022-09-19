<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$tramite = new tramite();
$datos = $tramite->getinfotramitebytramitevu(base64_decode($_GET['tramitevuid']),base64_decode($_GET['tipotramitevu']));

$html = '
<table width="650px" border="0">
<tr>
    <td>
        <table align="rigth" cellpadding="3">
            <tr>
                <td>
                    Saltillo, Coahuila a ______ de ____________ de '.date("Y").'
                </td>
            </tr>
        </table>
        <table align="left" cellpadding="3">
            <tr>
                <td>
                    <b>
                    LIC. MIGUEL ÁNGEL LOZANO CANTÚ<br>
                    COORDINACIÓN DE ALCOHOLES<br>
                    PRESENTE<br><br>
                    </b>
                </td>
            </tr>
        </table>
        <br><br>
        
        <table align="left" cellpadding="3">
            <tr>
                <td height="480px">
                        Solicito permiso para la venta de bebidas alcohólicas en el siguiente evento.<br><br>
                        <b>TIPO DE EVENTO:</b><br>
                        '.$datos[0]['tramitealtalicenciaprovisional_tipoevento'].'
                        <hr>&nbsp;<br><br>
                        <b>FECHA:</b><br>
                        '.$datos[0]['tramitealtalicenciaprovisional_fechai'].' a '.$datos[0]['tramitealtalicenciaprovisional_fechaf'].'
                        <hr>&nbsp;<br><br>
                        <b>LUGAR:</b><br>
                        <b>Calle: </b>'.$datos[0]['direccionp'].' <b>Núm. ext: </b>'.$datos[0]['numext_p'].'  <b>Col.</b> '.mb_strtoupper($datos[0]['coloniap']).'
                        <hr>&nbsp;<br><br>
                        <b>HORARIO:</b><br>
                        '.$datos[0]['tramitealtalicenciaprovisional_horario'].' - '.$datos[0]['tramitealtalicenciaprovisional_horariofin'].'
                        <hr>&nbsp;<br><br>
                        <b>NOMBRE DE LA PERSONA QUE ORGANIZA:</b><br>
                        '.$datos[0]['nombrep'].'
                        <hr>&nbsp;<br><br>
                        <b>TIPO DE VENTA QUE REALIZARÁ DURANTE EL EVENTO:</b><br>
                        '.$datos[0]['tramitealtalicenciaprovisional_descripcion'].'
                        <hr>&nbsp;<br><br>
                        <b>GIRO:</b><br>
                        '.$datos[0]['giro_nombre'].'
                        <hr>&nbsp;<br>
                </td>
            </tr>
        </table>
        <table align="center" cellpadding="3">
            <tr>
                <td height="100px">
                        ATENTAMENTE
                        <br><br><br>
                        ________________________________<br>
                        NOMBRE Y FIRMA
                        
                </td>
            </tr>
        </table>
        <table align="left" cellpadding="3">
            <tr>
                <td height="60px">
                        Teléfono:'.$datos[0]['telefonop'].'<br>
                        Correo:'.$datos[0]['correop'].'
                </td>
            </tr>
        </table>
        <table align="left" cellpadding="3" border="0">
            <tr>
                <td width="150px">
                    
                </td>
                <td width="100px" valign="bottom">
                    <!--||QR||-->
                </td>
                <td width="160px" valign="bottom">
                    ||CB||
                </td>
            </tr>
        </table>
    </td>
</tr>

</table>
';

$generarpdf = new gdocs();
$generarpdf->generapdf($html,'COORDINACION DE ALCOHOLES<br>
SOLICITUD PARA OBTENER PERMISO ESPECIAL', 'I', '', '../images/logo2.png', '','P','Letter','9',$GLOBALS['vu_global_site'].'gui/global_consultastatus.php?folio='.$datos[0]['tramitealtalicenciaprovisional_folio'].'&hora=1:21',$datos[0]['tramitevu_folio']);