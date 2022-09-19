
<? include_once ("../config/global_includes.php"); ?>
<?
    $t = new tramite();
	$res = $t->actualizafoliotramite($_POST['tabla'], $_POST['tramitevuid'], $_POST['foliotramite']);
    echo $res;
?>