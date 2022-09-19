<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX AGREGAR COMENTARIO
* * DATOS ENTRADA POST
                        comentario
                        usuarioid
                        tramiteid
                        
* DATOS DE SALIDA JSON	
* Catalogo cat_usuarios
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $v = new ventanilla();
	$res = $v->agregarcomentario($_POST['comentario'],$_POST['usuarioid'],$_POST['tramiteid']);
    echo "Comentario Agregado";
?>