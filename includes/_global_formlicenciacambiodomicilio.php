<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para editar domicilio
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('17',$usersessionpermisos);
?>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH-qH3BIJ5qnuA1EE98X5ED17FPLS_XUU&callback=initMap&libraries=&v=weekly" defer></script>

<style>
    input, textarea {
        text-transform: uppercase;
    }
</style>

<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
    * element that contains the map. */
    #map {
        height: 537px !important;
    }
    
    #mapori {
        height: 538px !important;
    }
</style>
<script>
    (function(exports) {
        "use strict";

            function initMap() {
                exports.map = new google.maps.Map(document.getElementById("map"), {
                    center: {
                        lat: 25.423634,
                        lng: -101.000851
                    },
                    zoom: 15
                });
            }

        exports.initMap = initMap;
    })((this.window = this.window || {}));
</script>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
        $("#licencia").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getinfolicenciabylicencia.php?licencia="+$("#licencia").val(), {
                    term: request.term
                }, function(data) {                     
                    var array = data.error ? [] : $.map(data, function(m) {
                        return {
                            label: m.licencia,
                            value: m.licencia,
                            id: m.id,
                            domicilio: m.domicilio,
                            colonia: m.colonia,
                            coloniaid: m.coloniaid,
                            entrecalle: m.entrecalle,
                            ycalle: m.ycalle,
                            latitud: m.latitud,
                            longitud: m.longitud,
                        };
                    });
                    response(array);
                });
            },
            select: function (event, ui) {
                $('#licencia').val(ui.item? ui.item.label : ''); 
                $('#licenciaid').val(ui.item? ui.item.id : '');
                $('#adomiciliolic').val(ui.item? ui.item.domicilio : ''); 
                $('#acolonia').val(ui.item? ui.item.colonia : ''); 
                $('#acoloniaid').val(ui.item? ui.item.coloniaid : '');
                $('#aentrecalle').val(ui.item? ui.item.entrecalle : ''); 
                $('#ayentrecalle').val(ui.item? ui.item.ycalle : '');
                $('#alatitud').val(ui.item? ui.item.latitud : '');
                $('#alongitud').val(ui.item? ui.item.longitud : '');
                $("#licencia").prop('disabled', true);
                //Show mapori
                $("#mapori").css('visibility', 'visible');
                
                var mapOptions = {
                    zoom: 18,
                    center: new google.maps.LatLng(ui.item.latitud, ui.item.longitud)
                };
                map = new google.maps.Map(document.getElementById('mapori'), mapOptions);
                
                //posicionar mapaori original
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng( ui.item.latitud,ui.item.longitud),
                    map: map,
                    title: 'Hello World!'
                });

                // To add the marker to the map, call setMap();
                marker.setMap(map);
             },
            change: function( event, ui ) {
                $('#licencia').val(ui.item? ui.item.label : '');
                $( "#licenciaid" ).val(ui.item? ui.item.id : '');
                $('#adomiciliolic').val(ui.item? ui.item.domicilio : ''); 
                $('#acolonia').val(ui.item? ui.item.colonia : ''); 
                $('#acoloniaid').val(ui.item? ui.item.coloniaid : '');
                $('#aentrecalle').val(ui.item? ui.item.entrecalle : ''); 
                $('#ayentrecalle').val(ui.item? ui.item.ycalle : '');
                $('#alatitud').val(ui.item? ui.item.latitud : '');
                $('#alongitud').val(ui.item? ui.item.longitud : '');
            }
        });
        
        //Get Colonias
        $("#colonia").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getcolonias.php?busqueda="+$("#colonia").val()+"&municipioid="+$("#municipioid").val(), {
                    term: request.term
                }, function(data) {                     
                    var array = data.error ? [] : $.map(data, function(m) {
                        return {
                            label: m.nombre,
                            value: m.nombre,
                            id: m.id
                        };
                    });
                    response(array);
                });
            },
            select: function (event, ui) {
                $('#colonia').val(ui.item? ui.item.label : ''); 
                $('#coloniaid').val(ui.item? ui.item.id : '');
             },
            change: function( event, ui ) {
                $('#colonia').val(ui.item? ui.item.label : '');
                $( "#coloniaid" ).val(ui.item? ui.item.id : '');
                if ($('#domiciliolic').val() == ''){
                    alert("Porfavor, completa el campo dirección");
                    $("#domiciliolic").focus();
                    $("#coloniaid").val("");
                    $("#colonia").val("");
                    $("#map").css('visibility', 'hidden');
                }else{
                    var address = document.getElementById('domiciliolic').value;
                    var colonia = document.getElementById('colonia').value;
                    var geocoder = new google.maps.Geocoder();
                    var marker;
                    
                    var mapOptions = {
                        zoom: 18,
                        center: new google.maps.LatLng(0,0)
                    };
                    map = new google.maps.Map(document.getElementById('map'), mapOptions);
                    
                    geocoder.geocode({'address': address +" "+colonia +" Saltillo, Coahuila"}, function(results, status) {          
                        if (status === 'OK') {
                            map.setCenter(results[0].geometry.location);
                            map.setZoom(18);
                        } else {
                            alert('error al localizar la dirección: ' + status);
                        }
                    });

                    google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
                    
                        // Create a new InfoWindow.
                        var latlng = mapsMouseEvent.latLng.toString();
                        var dividir =  latlng.replace('(', '').replace(')', '').split(',');
                        var lat = dividir[0];
                        var lng = dividir[1];
                        //asignar valores
                        $("#latitud").val(lat);
                        $("#longitud").val(lng);

                        var myLatlng = new google.maps.LatLng(lat,lng);

                        if ( marker ) {
                           marker.setPosition(myLatlng);
                         } else {
                            marker = new google.maps.Marker({
                                position: myLatlng,
                                map: map
                            });
                         }
                    });
                
                    //Si no hay nada en el campo de colonia se esconde el mapa
                    if ($("#colonia").val() == ""){
                        $("#map").css('visibility', 'hidden');
                    }else{
                        $("#map").css('visibility', 'visible');
                    }

                }
            }
        });
        
        $("#btnguardar").on("click",function(){
            //Validar formulario
            if ($("#licenciaid").val() == ''){
                alert ("Licencia es un campo obligatorio");
                $("#licencia").focus();
            }else if ($("#domiciliolic").val() == ''){
                alert ("Domicilio es un campo obligatorio");
                $("#domiciliolic").focus();
            }else if ($("#colonia").val() == ''){
                alert ("Colonia es un campo obligatorio");
                $("#colonia").focus();
            }else if ($("#latitud").val() == ''){
                alert ("Latitud es un campo obligatorio selecciona en el mapa la ubicación.");
                $("#latitud").focus();
            }else if ($("#longitud").val() == ''){
                alert ("Longitud es un campo obligatorio selecciona en el mapa la ubicación.");
                $("#longitud").focus();
            }else{
                var form_data = new FormData(document.getElementById("MiFormulario"));
                $.ajax({
                    url: '../ajax/global_guardatramitecambiodomicilio.php',
                    dataType: "text",
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,  
                    type: 'post',
                    beforeSend: function() {
                        $("#loading").show();	
                    },
                    success: function(data) { 
                        var spl = data.split("|");
                        if (spl[0] == "1"){
                            alert ("Trámite guardado con éxito.\n\rGuarda \nfolio: "+spl[1]+" y \nhora: "+spl[2]+" \npara futuras consultas.");
                            if ($("#usuarioid").val() == '' || $("#usuarioid").val() == ''){
                                //Es usuario externo
                                location.href = "../gui/global_consultastatus.php?folio="+spl[1]+"&hora="+spl[2];
                            }else{
                                //Usuario logeado
                                location.href = "../gui/global_tramiteall.php";
                            }
                        }else{
                            alert ("Error: "+data);
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert (textStatus);
                        if (textStatus == "error"){
                            alert("Error: " + errorThrown); 
                        }
                    },
                    complete: function(data) { 
                        $("#loading").hide();
                    }
                });
            }
        });
        
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="MiFormulario" name="MiFormulario">
                    <input type="hidden" id="usuarioid" name="usuarioid" value="<?=$usersession[0]['usuarios_id']?>">
                    <div class="form-group col-md-12">
                        <label for="licencia"># Licencia</label>
                        <input id="licencia" name="licencia" type="text" class="form-control">
                        <input id="licenciaid" name="licenciaid" type="hidden">
                    </div>
                    <br><h4>Ubicación Físical de Licencia</h4>
                    <table>
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-group col-md-12">
                                    <input id="domiciliolic" name="domiciliolic" type="text" class="form-control" placeholder="Domicilio *">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="estado" name="estado" type="text" class="form-control" placeholder="Estado" value="COAHUILA DE ZARAGOZA" readonly>
                                    <input id="estadoid" name="estadoid" type="hidden" value="5">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="municipio" name="municipio" type="text" class="form-control" placeholder="Municipio *" value="SALTILLO" readonly>
                                    <input id="municipioid" name="municipioid" type="hidden" value="66">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="colonia" name="colonia" type="text" class="form-control" placeholder="Colonia *">
                                    <input id="coloniaid" name="coloniaid" type="hidden">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="entrecalle" name="entrecalle" type="text" class="form-control" placeholder="Entre Calle">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="yentrecalle" name="yentrecalle" type="text" class="form-control" placeholder="Y Calle">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="latitud" name="latitud" type="text" class="form-control" placeholder="Latitud *" readonly>
                                </div>
                                 <div class="form-group col-md-12">
                                    <input id="longitud" name="longitud" type="text" class="form-control" placeholder="Longitud *" readonly>
                                </div>
                            </td>
                            <td valign="top">
                                <div id="map" style="visibility: hidden"></div>
                            </td>
                        </tr>
                    </table>
                        
                    <br><h4>Ubicación Anterior</h4>
                    
                    <table>
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-group col-md-12">
                                    <input id="adomiciliolic" name="adomiciliolic" type="text" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="aestado" name="aestado" type="text" class="form-control" placeholder="Estado" value="COAHUILA DE ZARAGOZA" readonly>
                                    <input id="aestadoid" name="aestadoid" type="hidden" value="5">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="amunicipio" name="amunicipio" type="text" class="form-control" placeholder="Municipio" value="SALTILLO" readonly>
                                    <input id="amunicipioid" name="amunicipioid" type="hidden" value="66">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="acolonia" name="acolonia" type="text" class="form-control" readonly>
                                    <input id="acoloniaid" name="acoloniaid" type="hidden">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="aentrecalle" name="aentrecalle" type="text" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="ayentrecalle" name="ayentrecalle" type="text" class="form-control" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="alatitud" name="alatitud" type="text" class="form-control" readonly>
                                </div>
                                 <div class="form-group col-md-12">
                                    <input id="alongitud" name="alongitud" type="text" class="form-control" readonly>
                                </div>
                            </td>
                            <td valign="top" style="visibility: hidden">
                                <div id="mapori"></div>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group col-md-12">
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar Solicitud">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>