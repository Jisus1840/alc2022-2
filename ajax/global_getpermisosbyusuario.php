<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX ELIMINA O AGREGA UN PERMISO DE LA BASE DE DATOS
* DATOS ENTRADA GET 	idusuario
* DATOS DE SALIDA		json
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
$p = new permisos();
$res = $p->getpermisosbyusuarioid($_GET['idusuario']);
$array = array();
$i=0;
if ($res != 0){
    foreach ($res as $row){
        $array[$i] = 
            array(
                "idmenu"=>$row['permisosusuario_codigo']
            );
        $i++;
    }
}else{
    $array[0] = array(
                "idmenu"=>''
            );
}
echo json_encode($array);
?>