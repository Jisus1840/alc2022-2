<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX ELIMINAR UNA CITAS
* DATOS ENTRADA
                        tramitevuid
                        citaid
* DATOS DE SALIDA JSON	id
						nombre
*********************************************************************************
*/
?>
<? session_start(); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$c = new citas();
    $res = $c->eliminar($_POST['citaid'],$_POST['tramitevuid']);
    echo $res;
?>