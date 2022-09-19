<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax get tipo licencia
* Entrada
* Salida
                id
                nombre
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
$cat = new catalogos();
$tramites = $cat->gettipolicencia();
$array = array();
$i=0;
if ($tramites != 0){
    foreach ($tramites as $row){
        $array[$i] = 
            array(
                "id"=>$row['tipolicencia_id'],
                "nombre"=>$row['tipolicencia_nombre']
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