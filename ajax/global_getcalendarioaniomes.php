<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX imprime calendario por año y mes
* * DATOS ENTRADA POST
                        anio
                        mes
                        
* DATOS DE SALIDA html	
* Catalogo cat_usuarios
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $calendar = new calendario();
    echo $calendar->show($_POST['anio'],$_POST['mes']);
?>