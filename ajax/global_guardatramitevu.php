<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda tyrámite Ventanilla ünica
* Entrada
                tipotramite
                usuarioid
* Salida
                lastinsertid
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?

$vu = new ventanilla();
$lastid = $vu->guardar($_POST['usuarioid'],$_POST['tipotramite'],1,1,date("Y-m-d H:i:s"));

$t = new tramite();
$idt = $t->guardar(date("Y"),$lastid);

echo $lastid;
?>