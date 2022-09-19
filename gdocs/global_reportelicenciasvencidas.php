<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$lic = new licencias();
$datos = $lic->getlicenciasvencidas();
$html = 
'
<table width="650px" border="1" cellpadding="5px">
';
$html .= '<tr>';
        $html .= '<th>LICENCIA</th>';
        $html .= '<th>NOMBRE GENÉRICO</th>';
        $html .= '<th>GIRO</th>';
        $html .= '<th>DIRECCIÓN</th>';
        $html .= '<th>COLONIA</th>';
        $html .= '<th>ZONA</th>';
        $html .= '<th>FECHA VENCIMIENTO</th>';
    $html .= '</tr>';
foreach ($datos as $row){
    $html .= '<tr>';
        $html .= '<td>'.$row['title'].'</td>';
        $html .= '<td>'.$row['website'].'</td>';
        $html .= '<td>'.$row['giro'].'</td>';
        $html .= '<td>'.$row['direccion'].'</td>';
        $html .= '<td>'.$row['colonia'].'</td>';
        $html .= '<td>'.$row['zona_nombre'].'</td>';
        $html .= '<td>'.$row['licencias_fechavencimientopago'].'</td>';
    $html .= '</tr>';
}
$html .= '
</table>
';

$generarpdf = new gdocs();
$generarpdf->generapdf($html,'COORDINACION DE ALCOHOLES<br>
LICENCIAS VENCIDAS', 'I', '', '../images/global_bannerpdf.jpg', '../imagenes/global_imagenes_piepdfpurifika.jpg','P');
?>