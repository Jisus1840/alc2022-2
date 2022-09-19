<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda Tramite cambio de nombre generico
* Entrada
                [licenciaid]
                [nombregnuevo]
                [nombreganterior]
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
$lastid = $vu->guardar($_POST['usuarioid'],2,1,7,date("Y-m-d H:i:s"));

$tramite = new tramite();
$lastidsolicitud = $tramite->guardarcambionombregenerico(
    $lastid,
    $_POST['licenciaid'],
    $_POST['nombreganterior'],
    $_POST['nombregnuevo'],
    $_POST['usuarioid']
);
//consulta folio
$folio = tramite::getfoliotramite($lastid);
$hora = tramite::gethorainiciotramite($lastid);
echo "1|".$folio."|".$hora;
?>