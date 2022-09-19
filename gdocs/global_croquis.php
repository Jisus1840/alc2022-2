<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$tramite = new tramite();
$datos = $tramite->getinfotramitebytramitevu(base64_decode($_GET['tramitevuid']),base64_decode($_GET['tipotramitevu']));

switch (base64_decode($_GET['tipotramitevu'])) {
    case 1:
        $licencia = "";
        $giro = $datos[0]['giro_nombre'];
        $nombre = $datos[0]['tramitealtalicencia_nombregenerico'];
        $domicilio = $datos[0]['tramitealtalicencia_domicilio'].' '.$datos[0]['nombrecolonia'];
        $latitud = $datos[0]['tramitealtalicencia_latitud'];
        $longitud = $datos[0]['tramitealtalicencia_longitud'];
        break;
    default:
        $licencia = "";
        $giro = "";
        $nombre = "";
        $domicilio = "";
        $latitud = "0";
        $longitud = "0";
} 
$gmapUrl = 'http://maps.google.com/maps/api/staticmap?';
$zoom = 16.5;
$size = '530x450'; 
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
                <td width="184px">NÚMERO LICENCIA</td>
                <td width="460px">'.$licencia.'</td>
            </tr>
            <tr>
                <td>GIRO</td>
                <td>'.$giro.'</td>
            </tr>
            <tr>
                <td>NOMBRE GENÉRICO</td>
                <td>'.$nombre.'</td>
            </tr>
            <tr>
                <td>DOMICILIO</td>
                <td>'.$domicilio.'</td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td>
        <br><br><br>
        <table border="1" cellpadding="5px">
            <tr>
                <td bgcolor="lightgray">
                    <b>UBICACIÓN</b>
                </td>
            </tr>
            <tr>
                <td>
                    <img src="'.$http_req.'" style="width:610;height:490;">
                </td>
            </tr>
        </table>
    </td>
</tr>
<tr>
    <td colspan="2" align="right">
        <br><br>
        ||QR||
    </td>
</tr>
</table>
';

$generarpdf = new gdocs();
$generarpdf->generapdf($html,'CROQUIS', 'I', '', '../images/logo2.png', '','P','Letter','9',$GLOBALS['vu_global_site'].'gui/global_consultastatus.php?folio='.$datos[0]['tramitealtalicencia_folio'].'&hora=1:21',$datos[0]['tramitevu_folio']);