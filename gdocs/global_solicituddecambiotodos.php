<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$tramite = new tramite();
$datos = $tramite->getinfotramitebytramitevu(base64_decode($_GET['tramitevuid']),base64_decode($_GET['tipotramitevu']));
switch (base64_decode($_GET['tipotramitevu'])){
    //Cambio
    case 9:
        $folio = $datos[0]['tramitecambio_folio'];
        $giro = $datos[0]['girocambio'];
        $nombregenerico = $datos[0]['tramitecambio_nombrenuevo'];
        $rfcnuevop = $datos[0]['rfcnuevop'];
        $curpnuevop = $datos[0]['curpnuevop'];
        $telnuevop = $datos[0]['telnuevop'];
        $celnuevop = $datos[0]['celnuevop'];
        $nombrennuevop = $datos[0]['nombrenuevop'];
        $domicilionnuevop = $datos[0]['domicilionuevop'];
        $rfcnuevoc = $datos[0]['rfcnuevoc'];
        $curpnuevoc = $datos[0]['curpnuevoc'];
        $telnuevoc = $datos[0]['telnuevoc'];
        $celnuevoc = $datos[0]['celnuevoc'];
        $nombrennuevoc = $datos[0]['nombrenuevoc'];
        $domicilionnuevoc = $datos[0]['domicilionuevoc'];
        $cambiodomiciliocolonia = $datos[0]['colonianuevo'];
        $cambiodomiciliodomicilio = $datos[0]['tramitecambio_domicilionuevo'];
        $cambiodomicilioentrecalle = $datos[0]['tramitecambio_domicilioentrecallenuevo'];
        $cambiodomicilioyentrecalle = $datos[0]['tramitecambio_domicilioyentrecallenuevo'];
        break;

}
$html = '
<table width="650px" border="0">
<tr>
    <td>
        <table align="rigth" cellpadding="3">
            <tr>
                <td>
                    <b>FOLIO</b> <u>'.$folio.'</u><br>
                    <b>LICENCIA:</b> <u>'.$datos[0]['licencias_licencia'].'</u><br>
                </td>
            </tr>
        </table>
        <br>
        <table align="left" cellpadding="2" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>PROPIETARIO LICENCIA</b></td></tr>
            <tr><td><b>NOMBRE</b> '.$datos[0]['nombrep'].'</td></tr>
            <tr><td><b>GIRO</b> '.$datos[0]['giro_nombre'].'</td></tr>
            <tr><td><b>NOMBRE GENÉRICO</b> '.$datos[0]['licencias_nombregenerico'].'</td></tr>
            <tr><td><b>DOMICILIO</b> '.$datos[0]['direccionp'].' <b>COLONIA </b>'.$datos[0]['coloniap'].'</td></tr>
            <tr><td><b>RFC</b> '.$datos[0]['rfcp'].'<b> CURP</b> '.$datos[0]['curpp'].'<b> TEL/CEL</b> '.$datos[0]['telefonop'].' / '.$datos[0]['celularp'].'</td></tr>
        </table>
        <br><br>
        <table align="left" cellpadding="2" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>DATOS COMODATARIO</b></td></tr>
            <tr><td><b>NOMBRE</b> '.$datos[0]['nombrec'].'</td></tr>
        </table>
        <br><br>
        <table align="left" cellpadding="2" border="1">
            <tr><td align="center" bgcolor="#CCCCCC"><b>FAVOR DE LLENAR DEPENDIENDO DEL TRÁMITE QUE SE LLEVE A CABO</b></td></tr>
            <tr><td align="center"><b>CAMBIO DE DOMICILIO</b></td></tr>
            <tr><td><b>DOMICILIO</b> '.$cambiodomiciliodomicilio.' <b>COLONIA</b> '.$cambiodomiciliocolonia.'</td></tr>
            <tr><td><b>Entre Calle </b> '.$cambiodomicilioentrecalle.'<b> y Calle </b> '.$cambiodomicilioyentrecalle.'</td></tr>
            <tr><td align="center"><b>CAMBIO DE NOMBRE GENÉRICO</b></td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="100px"><b>NOMBRE GENÉRICO</b></td>
                            <td width="525px">'.$nombregenerico.'</td>
                            <td width="10px" bgcolor="#CCCCCC"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td align="center"><b>CAMBIO DE COMODATARIO</b></td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="100px"><b>NOMBRE</b></td>
                            <td width="525px">'.$nombrennuevoc.'</td>
                            <td width="10px" bgcolor="#CCCCCC"></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>DOMICILIO</b></td>
                            <td width="525px">'.$domicilionnuevoc.'</td>
                            <td width="10px"></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>RFC / CURP </b></td>
                            <td width="525px">'.$rfcnuevoc.' / '.$curpnuevoc.'</td>
                            <td width="10px"></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>TEL / CEL </b></td>
                            <td width="525px">'.$telnuevoc.' / '.$celnuevoc.'</td>
                            <td width="10px"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td align="center"><b>CAMBIO DE PROPIETARIO</b></td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="100px"><b>NOMBRE</b></td>
                            <td width="525px">'.$nombrennuevop.'</td>
                            <td width="10px" bgcolor="#CCCCCC"></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>DOMICILIO</b></td>
                            <td width="525px">'.$domicilionnuevop.'</td>
                            <td width="10px"></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>RFC / CURP </b></td>
                            <td width="525px">'.$rfcnuevop.' / '.$curpnuevop.'</td>
                            <td width="10px"></td>
                        </tr>
                        <tr>
                            <td width="100px"><b>TEL / CEL </b></td>
                            <td width="525px">'.$telnuevop.' / '.$celnuevop.'</td>
                            <td width="10px"></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td align="center"><b>CAMBIO DE NOMBRE GIRO</b></td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td width="60px"><b>GIRO</b></td>
                            <td width="565px">'.$giro.'</td>
                            <td width="10px" bgcolor="#CCCCCC"></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <br>
        <table align="center" cellpadding="3">
            <tr>
                <td>
                    Decalara bajo protesta de decir verdad<br>
                    que los datos contenidos en esta solicitud son ciertos
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
        <br><br><br>
        <table align="left" cellpadding="3" border="0">
            <tr>
                <td width="390px">
                    <br><br>Para llenado de Fiscalización<br><br>Autorizada Si __ No __<br><br>Autorización de Cabildo mediante Minuta No. _______________________ 
                    <br>y Acuerdo No. _____________________ <br><br>
                    De Fecha __________ de _________________________ de _________
                </td>
                <td width="100px" valign="bottom">
                    ||QR||
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
SOLICITUD DE CAMBIOS', 'I', '', '../images/logo2.png', '','P','Letter','7',$GLOBALS['vu_global_site'].'gui/global_consultastatus.php?folio='.$datos[0]['tramitecambio_folio'].'&hora=1:21',$datos[0]['tramitevu_folio']);
?>