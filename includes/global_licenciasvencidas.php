<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todas las licencias vencidas
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    //$p = new permisos();
    //$p->revisarpermisos('23',$usersessionpermisos);
?>
<?
$licencia = new licencias();
$marcadores = $licencia->getlicenciasvencidas();
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
var icon = "http://path/to/icon.png";
var json = "http://path/to/universities.json";
var infowindow = new google.maps.InfoWindow();

function initialize() {

  var mapProp = {
    center: new google.maps.LatLng(25.423634, -100.960000), //LLANDRINDOD WELLS
    zoom: 13,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById("map"), mapProp);

  //  $.getJSON(json, function(json1) {
  var json1 = {
    "universities": <?=json_encode($marcadores)?>
  };
  $.each(json1.universities, function(key, data) {

    var latLng = new google.maps.LatLng(data.lat, data.lng);

    var marker = new google.maps.Marker({
      position: latLng,
      map: map,
      // icon: icon,
      title: data.title
    });

    var details = 'Nombre Genérico: ' + data.website + "<br> Licencia: " + data.phone + ".";

    bindInfoWindow(marker, map, infowindow, details);

    //    });

  });

}

function bindInfoWindow(marker, map, infowindow, strDescription) {
  google.maps.event.addListener(marker, 'click', function() {
    infowindow.setContent(strDescription);
    infowindow.open(map, marker);
  });
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
<a href="../gdocs/global_reportelicenciasvencidas.php" target="_blank">Ver Reporte</a><br><br>
<div id="map"></div>