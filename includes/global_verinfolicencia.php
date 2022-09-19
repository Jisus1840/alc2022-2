<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver toda la información del trámite
entrada
    id
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $v = new licencias();
    $res = $v->getinfobylicenciaid($_GET['id']);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH-qH3BIJ5qnuA1EE98X5ED17FPLS_XUU"></script>

<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
    #map {
        height: 300px !important;
    }

</style>
<script>
var map;

function initialize() {

    var uluru = {lat: <?=$res[0]['licencias_latitud']?>, lng: <?=$res[0]['licencias_longitud']?>};
    
    var mapProp = {
        center: new google.maps.LatLng(uluru), //LLANDRINDOD WELLS
        zoom: 17,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };

    map = new google.maps.Map(document.getElementById("map"), mapProp);
    var marker = new google.maps.Marker({position: uluru, map: map});
    
}

google.maps.event.addDomListener(window, 'load', initialize);
    
</script>
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
<br>
<table class="table table-striped">
    <tbody>
        <tr>
            <th width="35%">Licencia</th>
            <td width="65%"><?=$res[0]['tipolicencia_nombre']?>-<?=$res[0]['licencias_licencia']?></td>
        </tr>
        <tr>
            <th>Nombre Genérico </th>
            <td><?=$res[0]['licencias_nombregenerico']?></td>
        </tr>
        <tr>
            <th>Giro </th>
            <td><?=$res[0]['giro_nombre']?></td>
        </tr>
        <tr>
            <th>Dirección Licencia </th>
            <td>
                <?=$res[0]['licencias_domicilio']?> 
                <br>Col: <?=$res[0]['colonia_nombre']?> 
                <br>CP: <?=$res[0]['colonia_cp']?>
                <br>Entre calle: <?=$res[0]['licencias_entrecalle']?>
                <br>Y calle: <?=$res[0]['licencias_yentrecalle']?>
            </td>
        </tr>
        <tr>
            <th>Mapa </th>
            <td><div id="map"></div></td>
        </tr>
        <tr>
            <th>Propietario </th>
            <td><?=$res[0]['rfcpropietario']?> <?=$res[0]['nombrepropietario']?></td>
        </tr>
        <tr>
            <th>Domicilio Propietario </th>
            <td><?=$res[0]['direccionpropietario']?> <?=$res[0]['coloniapropietario']?></td>
        </tr>
        <tr>
            <th>Tel/Cel Propietario </th>
            <td>Tel: <?=$res[0]['telefonopropietario']?> Cel:<?=$res[0]['celularpropietario']?></td>
        </tr>
        <tr>
            <th>Comodatario </th>
            <td><?=$res[0]['rfccomodatario']?> <?=$res[0]['nombrecomodatario']?></td>
        </tr>
        <tr>
            <th>Tel/Cel Comodatario </th>
            <td>Tel: <?=$res[0]['telefonocomodatario']?> Cel:<?=$res[0]['celularcomodatario']?></td>
        </tr>
    </tbody>
</table>
<br>
<? include_once ("../js/global_footer.js");?>