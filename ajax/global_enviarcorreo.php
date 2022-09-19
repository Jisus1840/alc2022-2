<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX ENVIAR CORREO
* * DATOS ENTRADA POST
                        destinatario
                        asunto
                        cuerpo
                        
* DATOS DE SALIDA JSON	
* Catalogo cat_usuarios
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $v = new correo();
	$res = $v->enviarcorreo($_POST['destinatario'],$_POST['destinatario'],$cc='',$_POST['asunto'],$_POST['cuerpo']);
    echo $res;
?>