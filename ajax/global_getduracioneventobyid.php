<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2020
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET DURACION EVENTO BY ID
* * DATOS ENTRADA POST
						eventoid
* DATOS DE SALIDA JSON	
                        duracion
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$citas = new citas();
    $duracion = $citas->getduracioneventobyid($_POST['eventoid']);
    echo $duracion;
?>