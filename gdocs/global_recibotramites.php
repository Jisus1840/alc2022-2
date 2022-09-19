<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//GET DATOS
$ventanilla = new ventanilla();
$datos = $ventanilla->gettramitesescaneados($_GET['bloque']);

$html = 
'<b>Fecha: </b> '.$datos[0]['historialvu_fechainicio'].
'
<br><br>
<table width="650px" border="1" cellpadding="5px">
';
$html .= '<tr>';
        $html .= '<th>TRAMITE VU</th>';
        $html .= '<th>FOLIO</th>';
        $html .= '<th>TIPO TRAMITE</th>';
        $html .= '<th>ORIGEN</th>';
        $html .= '<th>DESTINO</th>';
        $html .= '<th>COMENTARIO</th>';
        $html .= '<th>USUARIO</th>';
    $html .= '</tr>';
foreach ($datos as $row){
    $html .= '<tr>';
        $html .= '<td>'.$row['tramitevu_folio'].'</td>';
        $html .= '<td>'.$row['folio'].'</td>';
        $html .= '<td>'.$row['tipotramite_nombre'].'</td>';
        $html .= '<td>'.$row['fdinicio'].'</td>';
        $html .= '<td>'.$row['fdfin'].'</td>';
        $html .= '<td>'.$row['historialvu_comentario'].'</td>';
        $html .= '<td>'.$row['usuarios_nombre'].'</td>';
    $html .= '</tr>';
}
$html .= '
</table>
';

$generarpdf = new gdocs();
$generarpdf->generapdf($html,'COORDINACIOON DE ALCOHOLES<br>
SOLICITUD PARA OBTENER CAMBIOS EN UNA LICENCIA DE ALCHOLES', 'I', '', '../images/logo2.png', '','P','','9');
?>