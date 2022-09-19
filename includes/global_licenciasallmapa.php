<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todas las licencias mapa
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2003',$usersessionpermisos);
?>
<? 
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
?>
<?
$licencia = new licencias();
$marcadores = $licencia->getlicenciasallmapa($busqueda);
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
      icon: {
        path: google.maps.SymbolPath.BACKWARD_CLOSED_ARROW,
        strokeColor: data.giro_color,
        scale: 5,
        fillColor: data.giro_color,
        fillOpacity: 1
    },
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
        //Get Giro búsqueda
        var items1="";
        $.getJSON("../ajax/global_getgiro.php",function(data){
            items1+="<option value=''></option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#bsqgiroid").html(items1); 
        });

        //Get Tipo licencia
        var items11="";
        $.getJSON("../ajax/global_gettipolicencia.php",function(data){
            items11+="<option value='' disabled selected>Tipo Licencia</option>";
            $.each(data,function(index,item){
                items11+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#bsqtipolicencia").html(items11); 
        });
        
        $("#btnbsq").on("click",function(){
            //Arma json y lo serealiza
            var busquedaaux = {
                    "bsqgiroid": $("#bsqgiroid").val(),
                    "bsqpropietario": $("#bsqpropietario").val(),
                    "bsqcomodatario": $("#bsqcomodatario").val(),
                    "bsqnombre": $("#bsqnombre").val(),
                    "bsqtipolicencia": $("#bsqtipolicencia").val(),
                    "bsqnumlicencia": $("#bsqnumlicencia").val()
            };
            busquedaaux = btoa(JSON.stringify(busquedaaux));
            document.location.href = window.location.href.split('?')[0]+'?busqueda='+busquedaaux;
        });

        $("#btnlimpiar").on("click",function(){
            location.reload();
        });
        
    });

    $(document).ajaxStop(function() {
        <? if ($busqueda != ''){?>
            var busquedaarray = JSON.parse(atob('<?=$busqueda?>'));
            $("#bsqgiroid").val(busquedaarray.bsqgiroid);
            $("#bsqpropietario").val(busquedaarray.bsqpropietario);
            $("#bsqcomodatario").val(busquedaarray.bsqcomodatario);
            $("#bsqnombre").val(busquedaarray.bsqnombre);
            $("#bsqtipolicencia").val(busquedaarray.bsqtipolicencia);
            $("#bsqnumlicencia").val(busquedaarray.bsqnumlicencia);
        <?}?>
        $("#loading").hide();
    });
    
</script>

<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<!-- FILTROS BÚSQUEDA -->
<br><h2>Filtros de Búsqueda</h2>
<div class="form-row">
    <div class="form-group col-md-3">
        <select id="bsqgiroid" name="bsqgiroid" class="form-control">
        </select>
    </div>
    <div class="form-group col-md-4">
        <input id="bsqpropietario" name="bsqpropietario" type="text" class="form-control" placeholder="Propietario RFC o Razón Social">
    </div>
    <div class="form-group col-md-4">
        <input id="bsqcomodatario" name="bsqcomodatario" type="text" class="form-control" placeholder="Comodatario RFC o Razón Social">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-4">
        <input id="bsqnombre" name="bsqnombre" type="text" class="form-control" placeholder="Nombre Genérico">
    </div>
    <div class="form-group col-md-2">
        <select id="bsqtipolicencia" name="bsqtipolicencia" class="form-control">
        </select>
    </div>
    <div class="form-group col-md-2">
        <input id="bsqnumlicencia" name="bsqnumlicencia" type="text" class="form-control" placeholder="Licencia">
    </div>
    <div class="form-group col-md-2">
        <table>
            <tr>
                <td>
                    <input type="button" id="btnbsq" value="Búsqueda" class="btn btn-primary btn-send-message">
                </td>
                <td>
                    <input type="button" id="btnlimpiar" value="Limpiar" class="btn btn-primary btn-send-message">
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-12">
        <a href="../gdocs/global_reportelicenciastodas.php" target="_blank">Ver Reporte</a><br><br>
    </div>
</div>
<div id="map"></div>