<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Refrendo
* Entrada
                [licenciaid]
                [fechapago]
                [usuarioid]
                usuarionombre,
                correousuario
                rfcusuario
* Salida
                
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
//Guarda Ventanilla
$vu = new ventanilla();
$lastid = $vu->guardar($_POST['usuarioid'],8,1,7,date("Y-m-d H:i:s"),'',$_POST['correousuario'],$_POST['rfcusuario'],'null');

$tramite = new tramite();
$lastidsolicitud = $tramite->guardarrefrendo(
    $lastid,
    $_POST['licenciaid'],
    $_POST['fechapago'],
    $_POST['usuarioid'],
    $_POST['usuarionombre'],
    $_POST['correousuario'],
    $_POST['rfcusuario']
);
//consulta folio
$folio = tramite::getfoliotramite($lastid);
$hora = tramite::gethorainiciotramite($lastid);
echo "1|".$folio."|".$hora;
?>