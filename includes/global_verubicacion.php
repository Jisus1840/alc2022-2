<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver Ubicacion
entrada
        latitud
        longitud
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    //$p = new permisos();
    //$p->revisarpermisos('23',$usersessionpermisos);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH-qH3BIJ5qnuA1EE98X5ED17FPLS_XUU"></script>

<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
    #map {
        height: 530px !important;
    }

</style>
<script>
var map;

function initialize() {

    var uluru = {lat: <?=$_GET['latitud']?>, lng: <?=$_GET['longitud']?>};
    
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

<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<div id="map"></div>