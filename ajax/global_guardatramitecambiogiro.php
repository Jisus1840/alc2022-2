<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda Licencia
* Entrada
                [licenciaid]
                [giroid]
                [giroanteriorid]
                [giroid]
                [usuarioid]
* Salida
                
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//Guarda Ventanilla
$vu = new ventanilla();
$lastid = $vu->guardar($_POST['usuarioid'],5,1,7,date("Y-m-d H:i:s"));

$tramite = new tramite();
$lastidsolicitud = $tramite->guardarcambiogiro(
    $lastid,
    $_POST['licenciaid'],
    $_POST['giroanteriorid'],
    $_POST['giroid'],
    $_POST['usuarioid']
);
//consulta folio
$folio = tramite::getfoliotramite($lastid);
$hora = tramite::gethorainiciotramite($lastid);
echo "1|".$folio."|".$hora;
?>