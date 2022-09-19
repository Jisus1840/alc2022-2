<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver Flujo del trámite
entrada
    tramitevuid
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    //$p = new permisos();
    //$p->revisarpermisos('12',$usersessionpermisos);
?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<?
    $v = new ventanilla();
	$res = $v->getflujo($_GET['tramitevuid']);
	$html = $v->imprimirflujo($res,-1);
    echo $html;
?>