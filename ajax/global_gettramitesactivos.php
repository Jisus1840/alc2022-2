<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax get trámites activos
* Entrada
* Salida
                id
                nombre
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
$cat = new catalogos();
$tramites = $cat->gettramitesactivos();
$array = array();
$i=0;
if ($tramites != 0){
    foreach ($tramites as $row){
        $array[$i] = 
            array(
                "id"=>$row['tipotramite_id'],
                "nombre"=>$row['tipotramite_nombre']
            );
        $i++;
    }
}else{
    $array[0] = array(
                "id"=>'',
                "nombre"=>''
            );
}
echo json_encode($array);
?>