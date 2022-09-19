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
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('15',$usersessionpermisos);
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
        height: 530px !important;
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

<script>
    var marker;

    function geocodeAddress(geocoder, resultsMap) {


        var address = document.getElementById('domiciliolic').value;
        var colonia = document.getElementById('colonia').value;
        if (address != ""){
            geocoder.geocode({'address': address +" "+colonia +" Saltillo, Coahuila"}, function(results, status) {          
                if (status === 'OK') {
                    resultsMap.setCenter(results[0].geometry.location);
                    resultsMap.setZoom(18);
                } else {
                    alert('error al localizar la dirección: ' + status);
                }
            });
        }else{
            alert("Porfavor, completa el campo dirección");
            $("#map").css('visibility', 'hidden');
            $("#domiciliolic").focus();
            $("#coloniaid").val("");
            $("#colonia").val("");
        }

        var map = resultsMap;

        google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {

            // Create a new InfoWindow.
            var latlng = mapsMouseEvent.latLng.toString();
            var dividir =  latlng.replace('(', '').replace(')', '').split(',');
            var lat = dividir[0];
            var lng = dividir[1];
            //asignar valores
            $("#lat").val(lat);
            $("#lng").val(lng);

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
        if ($("#colonialic").val() == ""){
            $("#map").css('visibility', 'hidden');
        }else{
            $("#map").css('visibility', 'visible');
        }
    }

</script>

<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){

        $("#fechavencimiento").datepicker({
           todayBtn: "linked",
           language: "es",
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'yy-mm-dd' 
        });
        
        //Get Tipolicencia
        var items11="";
        $.getJSON("../ajax/global_gettipolicencia.php",function(data){
            items11+="<option value='' disabled selected>Tipo Licencia</option>";
            $.each(data,function(index,item){
                items11+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#tipolicencia").html(items11); 
        });
        
        //Get Giro
        var items1="";
        $.getJSON("../ajax/global_getgiro.php",function(data){
            items1+="<option value='' disabled selected>Giro</option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#giroid").html(items1); 
        });
        
        //XCRUD PERSONAS
        $("#ialtarfc").on("click",function(){
            var page = "../includes/global_xcrudpersonas.php";
            var $dialog = $('<div></div>')
                .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
                .css({overflow:"hidden"})	
                .dialog({
                       autoOpen: false,
                       modal: true,
                       show: { effect: "fold", duration: 1000 },
                       hide: {effect: "fold", duration: 1000 },
                       height: 600,
                       width: 600,
                       title: "Orden de Compra"
               });
            $dialog.dialog('open');
        });
        
        //Get RFC
        $("#rfcsource").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#rfcsource").val(), {
                    term: request.term
                }, function(data) {                     
                    var array = data.error ? [] : $.map(data, function(m) {
                        return {
                            label: m.rfc + ' - ' + m.nombre,
                            value: m.rfc + ' - ' + m.nombre,
                            nombre: m.nombre,
                            rfc: m.rfc,
                            curp: m.curp,
                            domicilio: m.domicilio,
                            telefonos: m.telefonos,
                            id: m.id
                        };
                    });
                    response(array);
                });
            },
            select: function (event, ui) {
                $('#rfcsource').val(ui.item.label); 
                $('#rfc').val(ui.item.rfc);
                $('#curp').val(ui.item.curp);
                $('#domicilio').val(ui.item.domicilio);
                $('#personanombre').val(ui.item.nombre);
                $('#personaid').val(ui.item.id);
                $('#telefonos').val(ui.item.telefonos);
                return false;
             },
            change: function( event, ui ) {
                $('#rfcsource').val(ui.item? ui.item.label : '');
                $( "#rfc" ).val( ui.item? ui.item.rfc : '' );
                $( "#curp" ).val( ui.item? ui.item.curp : '' );
                $( "#domicilio" ).val( ui.item? ui.item.curp : '' );
                $( "#personanombre" ).val( ui.item? ui.item.domicilio : '' );
                $( "#personaid" ).val( ui.item? ui.item.id : '' );
                $( "#telefonos" ).val( ui.item? ui.item.telefonos : '' );
            }
        });
        
        //Get RFC Comodatorio
        $("#rfcsourcecomodatario").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#rfcsourcecomodatario").val(), {
                    term: request.term
                }, function(data) {                     
                    var array = data.error ? [] : $.map(data, function(m) {
                        return {
                            label: m.rfc + ' - ' + m.nombre,
                            value: m.rfc + ' - ' + m.nombre,
                            nombre: m.nombre,
                            rfc: m.rfc,
                            curp: m.curp,
                            domicilio: m.domicilio,
                            telefonos: m.telefonos,
                            id: m.id
                        };
                    });
                    response(array);
                });
            },
            select: function (event, ui) {
                $('#rfcsourcecomodatario').val(ui.item.label); 
                $('#rfccomodatario').val(ui.item.rfc);
                $('#domiciliocomodatario').val(ui.item.domicilio);
                $('#personanombrecomodatario').val(ui.item.nombre);
                $('#personaidcomodatario').val(ui.item.id);
                $('#telefonoscomodatario').val(ui.item.telefonos);
                return false;
             },
            change: function( event, ui ) {
                $('#rfcsourcecomodatario').val(ui.item? ui.item.label : '');
                $( "#rfccomodatario" ).val( ui.item? ui.item.rfc : '' );
                $( "#domiciliocomodatario" ).val( ui.item? ui.item.curp : '' );
                $( "#personanombrecomodatario" ).val( ui.item? ui.item.domicilio : '' );
                $( "#personaidcomodatario" ).val( ui.item? ui.item.id : '' );
                $( "#telefonoscomodatario" ).val( ui.item? ui.item.telefonos : '' );
            }
        });
        
        //Get Estado
        $("#estado").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getestados.php?busqueda="+$("#estado").val(), {
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
                $('#estado').val(ui.item? ui.item.label : ''); 
                $('#estadoid').val(ui.item? ui.item.id : '');
             },
            change: function( event, ui ) {
                $('#estado').val(ui.item? ui.item.label : '');
                $( "#estadoid" ).val(ui.item? ui.item.id : '');
                $('#municipio').val('');
                $( "#municipioid" ).val('');
            }
        });
        
        $("#municipio").on("click",function(){
            if ($("#estadoid").val() == ''){
                alert ("Debes seleccionar Estado");
                $("#estado").focus();
            }
        });
        
        //Get Municipio
        $("#municipio").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getmunicipios.php?busqueda="+$("#municipio").val()+"&estadoid="+$("#estadoid").val(), {
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
                $('#municipio').val(ui.item? ui.item.label : ''); 
                $('#municipioid').val(ui.item? ui.item.id : '');
             },
            change: function( event, ui ) {
                $('#municipio').val(ui.item? ui.item.label : '');
                $( "#municipioid" ).val(ui.item? ui.item.id : '');
                $('#colonia').val('');
                $( "#coloniaid" ).val('');
            }
        });
        
        //On click colonia
        $("#colonia").on("click",function(){
            if ($("#municipioid").val() == ''){
                alert ("Debes seleccionar Municipio");
                $("#municipio").focus();
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
                //mostrar mapa
                $("#map").css('visibility', 'visible');
                $('#colonia').val(ui.item? ui.item.label : '');
                $( "#coloniaid" ).val(ui.item? ui.item.id : '');
                var myLatlng = {lat: 25.423634, lng: -101.000851};

                var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: myLatlng});
                var geocoder = new google.maps.Geocoder();
                geocodeAddress(geocoder, map);
            }
        });
        
        $("#btnguardar").on("click",function(){
            //Validar formulario
            if ($("#foliolicencia").val() == ''){
                alert ("Folio Licencia es un campo obligatorio");
                $("#foliolicencia").focus();
            }else if ($('#tipolicencia').find('option:selected').attr('disabled')) {
                alert ("Tipo de Licencia es un campo obligatorio");
                $("#tipolicencia").focus();
                banderaguarda = 0;
            }else if ($("#nombregenerico").val() == ''){
                alert ("Nombre Genérico es un campo obligatorio");
                $("#nombregenerico").focus();
            }else if ($('#giroid').find('option:selected').attr('disabled')) {
                alert ("Giro es un campo obligatorio");
                $("#giroid").focus();
                banderaguarda = 0;
            }else if ($("#fechavencimiento").val() == ''){
                alert ("Fecha de Vencimiento es un campo obligatorio");
                $("#fechavencimiento").focus();      
            }else if ($("#personaid").val() == ''){
                alert ("RFC del propietario es un campo obligatorio");
                $("#personaid").focus();      
            }else if ($("#domiciliolic").val() == ''){
                alert ("Domicilio de ubicación física es un campo obligatorio");
                $("#domiciliolic").focus();      
            }else if ($("#estadoid").val() == ''){
                alert ("Estado es un campo obligatorio");
                $("#estado").focus();      
            }else if ($("#municipioid").val() == ''){
                alert ("Municipio es un campo obligatorio");
                $("#municipio").focus();      
            }else if ($("#coloniaid").val() == ''){
                alert ("Colonia es un campo obligatorio");
                $("#colonia").focus();      
            }else if ($("#lat").val() == ''){
                alert ("Latitud es un campo obligatorio, ubica en el mapa tu dirección");
                $("#map").focus();  
                banderaguarda = 0;
            }else if ($("#lng").val() == ''){
                alert ("Lonitud es un campo obligatorio, ubica en el mapa tu dirección");
                $("#map").focus();  
                banderaguarda = 0;
            }else{
                var form_data = new FormData(document.getElementById("MiFormulario"));
                $.ajax({
                    url: '../ajax/global_guardalicencia.php',
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
                        alert (data);
                        location.reload();
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
    
    function enteros(elEvento) {
        // Variables que definen los caracteres permitidos
        var permitidos = "0123456789";
        var teclas_especiales = [8];

        // Obtener la tecla pulsada 
        var evento = elEvento || window.event;
        var codigoCaracter = evento.charCode || evento.keyCode;
        var caracter = String.fromCharCode(codigoCaracter);

        // Comprobar si la tecla pulsada es alguna de las teclas especiales
        // (teclas de borrado y flechas horizontales)
        var tecla_especial = false;
        for(var i in teclas_especiales) {
            if(codigoCaracter == teclas_especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        return permitidos.indexOf(caracter) != -1 || tecla_especial;
    }
</script>
<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="MiFormulario" name="MiFormulario">
                    <input type="hidden" id="usuarioid" name="usuarioid" value="<?=$usersession[0]['usuarios_id']?>">
                    <h4>Propietario Licencia</h4>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="foliolicencia" name="foliolicencia" type="text" class="form-control" placeholder="Folio Licencia *" onkeypress="return enteros(event)" onpaste="return false;">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select id="tipolicencia" name="tipolicencia" class="form-control"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="nombregenerico" name="nombregenerico" type="text" class="form-control" placeholder="Nombre Genérico *" maxlength="250">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select id="giroid" name="giroid" class="form-control">
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="fechavencimiento" name="fechavencimiento" type="text" class="form-control" placeholder="Fecha de Vencimiento *" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-11">
                            <input id="rfcsource" name="rfcsource" type="text" class="form-control" placeholder="Teclea RFC ó Nombre *">
                            <input id="personaid" name="personaid" type="hidden">
                        </div>
                        <div class="form-group col-md-1">
                            <i id="ialtarfc" class="icon-plus" style="font-size:50px; cursor:pointer" title="Alta RFC"></i>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="rfc" name="rfc" type="text" class="form-control" placeholder="RFC" readonly>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="personanombre" name="personanombre" type="text" class="form-control" placeholder="Nombre" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="domicilio" name="domicilio" type="text" class="form-control" placeholder="Domicilio" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="curp" name="curp" type="text" class="form-control" placeholder="CURP" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="telefonos" name="telefonos" type="text" class="form-control" placeholder="TEL / CEL" readonly>
                    </div>
                    <br><h4>Datos Comodatario</h4>
                    <div class="form-row"> 
                        <div class="form-group col-md-11">
                            <input id="rfcsourcecomodatario" name="rfcsourcecomodatario" type="text" class="form-control" placeholder="Teclea RFC ó Nombre">
                            <input id="personaidcomodatario" name="personaidcomodatario" type="hidden">
                        </div>
                        <div class="form-group col-md-1">
                            <i id="ialtarfc" class="icon-plus" style="font-size:50px; cursor:pointer" title="Alta RFC"></i>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="rfccomodatario" name="rfccomodatario" type="text" class="form-control" placeholder="RFC" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="personanombrecomodatario" name="personanombrecomodatario" type="text" class="form-control" placeholder="Nombre" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="domiciliocomodatario" name="domiciliocomodatario" type="text" class="form-control" placeholder="Domicilio" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="telefonoscomodatario" name="telefonoscomodatario" type="text" class="form-control" placeholder="TEL / CEL" readonly>
                    </div>
                    <br><h4>Ubicación Físical de Licencia</h4>
                    <table>
                        <tr>
                            <td width="50%">
                                <div class="form-group col-md-12">
                                    <input id="domiciliolic" name="domiciliolic" type="text" class="form-control" placeholder="Domicilio" maxlength="250">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="estado" name="estado" type="text" class="form-control" placeholder="Estado" value="COAHUILA DE ZARAGOZA" readonly>
                                    <input id="estadoid" name="estadoid" type="hidden" value="5">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="municipio" name="municipio" type="text" class="form-control" placeholder="Municipio" value="SALTILLO" readonly>
                                    <input id="municipioid" name="municipioid" type="hidden" value="66">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="colonia" name="colonia" type="text" class="form-control" placeholder="Colonia">
                                    <input id="coloniaid" name="coloniaid" type="hidden">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="entrecalle" name="entrecalle" type="text" class="form-control" placeholder="Entre Calle" maxlength="100">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="yentrecalle" name="yentrecalle" type="text" class="form-control" placeholder="Y Calle" maxlength="100">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="lat" name="lat" type="text" class="form-control" placeholder="Latitud" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="lng" name="lng" type="text" class="form-control" placeholder="Longitud" readonly>
                                </div>
                            </td>
                            <td valign="top">
                                <div id="map" style="visibility: hidden"></div>
                            </td>
                        </tr>
                    </table>
                    <div class="form-group col-md-12">
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar Licencia">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>