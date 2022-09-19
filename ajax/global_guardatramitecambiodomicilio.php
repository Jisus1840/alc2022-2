<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda Tramite cambio domicilio
* Entrada
                [licenciaid]
                [domiciliolic]
                [adomiciliolic]
                [coloniaid]
                [acoloniaid]
                [estadoid]
                [aestadoid]
                [municipioid]
                [amunicipioid]
                [entrecalle]
                [aentrecalle]
                [yentrecalle]
                [auentrecalle]
                [usuarioid]
                [latitud]
                [longitud]
* Salida
                
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//Guarda Ventanilla
$vu = new ventanilla();
$lastid = $vu->guardar($_POST['usuarioid'],6,1,7,date("Y-m-d H:i:s"));

$tramite = new tramite();
$lastidsolicitud = $tramite->guardarcambiodomicilio(
    $lastid,
    $_POST['licenciaid'],
    $_POST['domiciliolic'],
    $_POST['coloniaid'],
    $_POST['estadoid'],
    $_POST['municipioid'],
    $_POST['entrecalle'],
    $_POST['yentrecalle'],
    $_POST['adomiciliolic'],
    $_POST['acoloniaid'],
    $_POST['aestadoid'],
    $_POST['amunicipioid'],
    $_POST['aentrecalle'],
    $_POST['ayentrecalle'],
    $_POST['latitud'],
    $_POST['longitud'],
    $_POST['usuarioid']
);
//consulta folio
$folio = tramite::getfoliotramite($lastid);
$hora = tramite::gethorainiciotramite($lastid);
echo "1|".$folio."|".$hora;
?>