<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario parta alta de Licencia
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>

<table width="600px">
    <tr>
        <td>ID</td>
        <td>DIRECCION</td>
        <td>LATITUD</td>
        <td>LONGITUD</td>
    </tr>
<?php
    //Consulta en la bd
    $sql = "
    SELECT 
    licencias_id, 
    licencias_licencia, 
    concat(licencias_domicilio,' ',ifnull(c.colonia_nombre,'')) consultalatlong_direccion
    FROM global_licencias l
    left join cat_colonia c on c.colonia_id = l.licencias_coloniaid
    where  licencias_latitud is null
    ";
    $db = new DB();
    $res = $db->Ejecuta($sql);
    foreach ($res as $row){
        // Get lat and long by address         
        $address = $row['consultalatlong_direccion']." Saltillo Coahuila";
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?key=AIzaSyCH-qH3BIJ5qnuA1EE98X5ED17FPLS_XUU&address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        echo "<tr><td>".$row['licencias_id']."</td><td>".$row['consultalatlong_direccion']."</td><td>".$output->results[0]->geometry->location->lat."</td><td>".$output->results[0]->geometry->location->lng."</td></tr>";
        //update
        $sql2 = "
        UPDATE global_licencias
        SET
        licencias_latitud = '".$output->results[0]->geometry->location->lat."',
        licencias_longitud = '".$output->results[0]->geometry->location->lng."'
        where licencias_id = ".$row['licencias_id']."
        ";
        $db->Insert($sql2);
    }
?>
</table>