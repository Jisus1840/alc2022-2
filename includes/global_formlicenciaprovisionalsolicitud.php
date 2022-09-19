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
<!DOCTYPE html>
<html>
    <head>
        
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
            
            function geocodeAddress(geocoder, resultsMap) {
                var marker;                
                var address = document.getElementById('domiciliolic').value;
                var colonia = $( "#colonialicid option:selected" ).text();
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
                    $("#domiciliolic").focus();
                    $("#colonialicid").val("");
                    $("#colonialic").val("");
                    $("#map").css('visibility', 'hidden');
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
		
		setTimeout(function() {
			const urlParams = new URLSearchParams(window.location.search);
			const tramiteid = urlParams.get('tramiteid');
			if(tramiteid != null) {
				var permiso_especial = get_datos_permiso_especial(tramiteid);
				mostrar_datos_permiso_especial(permiso_especial);
			}
		}, 3000);
        
        $("#fechai").datepicker({
           todayBtn: "linked",
           language: "es",
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'yy-mm-dd' 
        });
        
        $("#fechaf").datepicker({
           todayBtn: "linked",
           language: "es",
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'yy-mm-dd' 
        });
        
        //Get Giro
        var items1="";
        $.getJSON("../ajax/global_getgiro.php",function(data){
            items1+="<option value='' disabled selected>Giro *</option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#giroid").html(items1); 
        });
		
		//Get Colonias
		var colonias="";
		$.getJSON("../ajax/global_getcoloniasbycp.php?codigo_postal=&municipioid=66",function(data){
			colonias+="<option value='' disabled selected>Colonia *</option>";
			$.each(data,function(index,item){
				colonias+="<option value='"+item.id+"'>"+item.nombre+"</option>";
			});
			$("#colonialicid").html(colonias); 
		});
		
		//Get Colonias
		$("#codigopostal").autocomplete({
			minLength: 5,
			source: function(request, response) {				
				var colonias="";
				$.getJSON("../ajax/global_getcoloniasbycp.php?codigo_postal="+$("#codigopostal").val()+"&municipioid=66",function(data){
					colonias+="<option value='' disabled selected>Colonia *</option>";
					$.each(data,function(index,item){
						colonias+="<option value='"+item.id+"'>"+item.nombre+"</option>";
					});
					$("#colonialicid").html(colonias); 
				});
			}
		});
        
        //Get RFC propietario
        $("#rfcsource").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#rfcsource").val(), {
                    term: request.term
                }, function(data) {                     
                    var array = data.error ? [] : $.map(data, function(m) {
                        return {
                            label: m.rfc + ' - ' + m.nombre + ' - ' + m.domicilio,
                            value: m.rfc + ' - ' + m.nombre + ' - ' + m.domicilio,
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
                $('#direccion').val(ui.item.domicilio);
                $('#personanombre').val(ui.item.nombre);
                $('#personaid').val(ui.item.id);
                return false;
             },
            change: function( event, ui ) {
                $('#rfcsource').val(ui.item? ui.item.label : '');
                $( "#direccion" ).val( ui.item? ui.item.domicilio : '' );
                $( "#personanombre" ).val( ui.item? ui.item.nombre : '' );
                $( "#personaid" ).val( ui.item? ui.item.id : '' );
            }
        });
		
		// Ubicar dirección en el mapa 
		$("#btnubicardireccion").on("click", function() {
			//mostrar mapa
			document.getElementById('lat').value = '';
			document.getElementById('lng').value = '';
			$("#map").css('visibility', 'visible');
			var myLatlng = {lat: 25.423634, lng: -101.000851};
		
			var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: myLatlng});
			var geocoder = new google.maps.Geocoder();
			geocodeAddress(geocoder, map);
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
        $("#colonialic").on("click",function(){
            if ($("#municipioid").val() == ''){
                alert ("Debes seleccionar Municipio");
                $("#municipio").focus();
            }
        });
        
        //Get Colonias
        $("#colonialic").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getcolonias.php?busqueda="+$("#colonialic").val()+"&municipioid="+$("#municipioid").val(), {
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
                $('#colonialic').val(ui.item? ui.item.label : ''); 
                $('#colonialicid').val(ui.item? ui.item.id : '');
             },
            change: function( event, ui ) {
                //mostrar mapa
                $("#map").css('visibility', 'visible');
                $('#colonialic').val(ui.item? ui.item.label : '');
                $( "#colonialicid" ).val(ui.item? ui.item.id : '');
                var myLatlng = {lat: 25.423634, lng: -101.000851};

                var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: myLatlng});
                var geocoder = new google.maps.Geocoder();
                geocodeAddress(geocoder, map);
            }
        });
        
        //Get Colonias para propietario
        $("#colonia").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getcolonias.php?busqueda="+$("#colonia").val()+"&municipioid=66", {
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
            }
        });
        
        $("#altarfc").on("click",function(){
            
            let contenedor = document.getElementById("prueba");
                            contenedor.innerHTML = '';
                            var html =  '<form id="MiFormularioRFC" name="MiFormularioRFC">'+
                                            '<input type="text" id="rfctext" name="rfctext" class="form-control" placeholder="RFC *" maxlength="13" autocomplete="off">'+
                                            '<input type="text" id="nombretext" name="nombretext" class="form-control" placeholder="Razón Social *" maxlength="250" autocomplete="off">'+        
                                            '<input type="text" id="curptext" name="curptext" class="form-control" placeholder="CURP" maxlength="18" autocomplete="off">'+
                                            '<input type="text" id="direcciontext" name="direcciontext" class="form-control" placeholder="Dirección (calle)*" maxlength="250" autocomplete="off">'+
                                            '<input type="text" id="direcciontextnum" name="direcciontextnum" class="form-control" placeholder="Dirección (Número ext)*" maxlength="250" autocomplete="off">'+
                                            '<input id="estadotext" name="estadotext" type="text" class="form-control" placeholder="Estado *" autocomplete="off">'+
                                            '<input id="estadoidtext" name="estadoidtext" type="hidden">'+
                                            '<input id="municipiotext" name="municipiotext" type="text" class="form-control" placeholder="Municipio *" autocomplete="off">'+
                                            '<input id="municipioidtext" name="municipioidtext" type="hidden">'+
                                            '<input type="text" id="coloniatext" name="coloniatext" class="form-control" placeholder="Colonia" maxlength="250" autocomplete="off">'+
                                            '<input type="hidden" id="coloniaidtext" name="coloniaidtext">'+
                                            '<input type="text" id="entrecalletext" name="entrecalletext" class="form-control" placeholder="Entre calle" maxlength="100" autocomplete="off">'+
                                            '<input type="text" id="yentrecalletext" name="yentrecalletext" class="form-control" placeholder="y Entre calle" maxlength="100" autocomplete="off">'+
                                            '<input type="text" id="telefonotext" name="telefonotext" class="form-control" placeholder="Teléfono *" maxlength="50" onkeypress="return enteros(event)" onpaste="return false;" autocomplete="off">'+
                                            '<input type="text" id="celulartext" name="celulartext" class="form-control" placeholder="Celular *" maxlength="50" onkeypress="return enteros(event)" onpaste="return false;" autocomplete="off">'+
                                            '<input type="text" id="correotext" name="correotext" class="form-control" placeholder="Correo *" maxlength="250" autocomplete="off">'+
                                            '<br><input type="button" id="guardarrfc" class="btn btn-primary btn-send-message" value="Guardar RFC">'+
                                        '</form>'
                            contenedor.innerHTML = html;
                            
                            //Get Estado
                            $("#estadotext").autocomplete({
                                minLength: 2,
                                source: function(request, response) {
                                    $.getJSON("../ajax/global_getestados.php?busqueda="+$("#estadotext").val(), {
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
                                    $('#estadotext').val(ui.item? ui.item.label : ''); 
                                    $('#estadoidtext').val(ui.item? ui.item.id : '');
                                 },
                                change: function( event, ui ) {
                                    $('#estadotext').val(ui.item? ui.item.label : '');
                                    $( "#estadoidtext" ).val(ui.item? ui.item.id : '');
                                    $('#municipiotext').val('');
                                    $( "#municipioidtext" ).val('');
                                    $('#coloniatext').val('');
                                    $( "#coloniaidtext" ).val('');
                                }
                            });

                            $("#municipiotext").on("click",function(){
                                if ($("#estadoidtext").val() == ''){
                                    alert ("Debes seleccionar Estado");
                                    $("#estadotext").focus();
                                }
                            });
        
                            //Get Municipio
                            $("#municipiotext").autocomplete({
                                minLength: 2,
                                source: function(request, response) {
                                    $.getJSON("../ajax/global_getmunicipios.php?busqueda="+$("#municipiotext").val()+"&estadoid="+$("#estadoidtext").val(), {
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
                                    $('#municipiotext').val(ui.item? ui.item.label : ''); 
                                    $('#municipioidtext').val(ui.item? ui.item.id : '');
                                 },
                                change: function( event, ui ) {
                                    $('#municipiotext').val(ui.item? ui.item.label : '');
                                    $( "#municipioidtext" ).val(ui.item? ui.item.id : '');
                                    $('#coloniatext').val('');
                                    $( "#coloniaidtext" ).val('');
                                }
                            });
            
                            $("#coloniatext").on("click",function(){
                                if ($("#municipioidtext").val() == ''){
                                    alert ("Debes seleccionar Municipio");
                                    if ($("#estadoidtext").val() == ''){
                                        $("#estadotext").focus();
                                    }else{
                                        $("#municipiotext").focus();
                                    }
                                }
                            });
            
                            $("#coloniatext").autocomplete({
                                minLength: 2,
                                source: function(request, response) {
                                    $.getJSON("../ajax/global_getcolonias.php?busqueda="+$("#coloniatext").val()+"&municipioid="+$("#municipioidtext").val(), {
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
                                    $('#coloniatext').val(ui.item? ui.item.label : ''); 
                                    $('#coloniaidtext').val(ui.item? ui.item.id : '');
                                 },
                                change: function( event, ui ) {
                                    $('#coloniatext').val(ui.item? ui.item.label : '');
                                    $( "#coloniaidtext" ).val(ui.item? ui.item.id : '');
                                }
                            });
        
                            $("#guardarrfc").on("click",function(){
                                if ($("#rfctext").val() == '' || ($("#rfctext").val().length < 12 || $("#rfctext").val().length > 13)){
                                    alert ("RFC es un campo obligatorio y debe tener como mínimo 12 caracteres");
                                    $("#rfctext").focus();
                                }else if ($("#nombretext").val() == ''){
                                    alert ("Razón Social es un campo obligatorio");
                                    $("#nombretext").focus();
                                }else if ($("#direcciontext").val() == ''){
                                    alert ("Dirección es un campo obligatorio");
                                    $("#direcciontext").focus();
								}else if ($("#direcciontextnum").val() == ''){
                                    alert ("Número exterior del domicilio es un campo obligatorio");
                                    $("#direcciontextnum").focus();
                                }else if ($("#estadoidtext").val() == ''){
                                    alert ("Estado es un campo obligatorio");
                                    $("#estadotext").focus();
                                }else if ($("#municipioidtext").val() == ''){
                                    alert ("Municipio es un campo obligatorio");
                                    $("#municipiotext").focus();
                                }else if ($("#telefonotext").val() == ''){
                                    alert ("Teléfono es un campo obligatorio");
                                    $("#telefonotext").focus();
                                }else if ($("#celulartext").val() == ''){
                                    alert ("Celular es un campo obligatorio");
                                    $("#celulartext").focus();
                                }else if ($("#correotext").val() == ''){
                                    alert ("Correo es un campo obligatorio");
                                    $("#correotext").focus();
                                }
                                else{
                                    var form_datarfc = new FormData(document.getElementById("MiFormularioRFC"));
                                    $.ajax({
                                        url: '../ajax/global_guardarrfc.php',
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        dataType: "text",
                                        type: 'post',
                                        data: form_datarfc,  
                                        beforeSend: function() {
                                            $("#loading").show();	
                                        },
                                        success: function(data) { 
                                            if (data == ''){
                                                //Cerrar dialog si data es blanco
                                                alert ("RFC guardado con éxito");
                                                $('#exampleModal').modal('toggle');
                                            }else{
                                                alert (data);
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
        
        $("#btnguardar").on("click",function(){
            var banderaguarda = 1;
            //Validar formulario
            if ($("#tipoevento").val() == ''){
                alert ("Tipo de Evento es un campo obligatorio");
                $("#tipoevento").focus();
                banderaguarda = 0;
            }else if(document.getElementById('giroid').value == '') {
				alert ("Giro es un campo obligatorio");
                $("#giroid").focus();
                banderaguarda = 0;
			}else if ($("#fechai").val() == ''){
                alert ("Fecha de inicio es un campo obligatorio");
                $("#fechai").focus();
                banderaguarda = 0;
            }else if ($("#fechaf").val() == ''){
                alert ("Fecha de fin es un campo obligatorio");
                $("#fechaf").focus();
                banderaguarda = 0;
            }else if ($("#horario").val() == ''){
                alert ("Horario de Inicio es un campo obligatorio");
                $("#horario").focus();
                banderaguarda = 0;
            }else if ($("#horariofin").val() == ''){
                alert ("Horario de Fin es un campo obligatorio");
                $("#horariofin").focus();
                banderaguarda = 0;
            }else if ($("#descripcion").val() == ''){
                alert ("Tipo de venta es un campo obligatorio");
                $("#descripcion").focus();
                banderaguarda = 0;
            }else if ($("#rfcsource").val() == ''){
                alert ("RFC del propietario es un campo obligatorio");
                $("#rfcsource").focus();
                banderaguarda = 0;
            }else if ($("#bandera").val() == 0){
                //Valida los dato del rfc para guardarlo en el catálogo de personas
                if ($("#curp").val() == '' || $("#curp").val().length < 18){
                    alert ("CURP del propietario es un campo obligatorio");
                    $("#curp").focus();
                    banderaguarda = 0;
                }else if ($("#personanombre").val() == ''){
                    alert ("Nombre o Razón Social del propietario es un campo obligatorio");
                    $("#personanombre").focus();
                    banderaguarda = 0;
                }else if ($("#direccion").val() == ''){
                    alert ("Diección del propietario es un campo obligatorio");
                    $("#direccion").focus();
                    banderaguarda = 0;
                }else if ($("#colonia").val() == ''){
                    alert ("Colonia del propietario es un campo obligatorio");
                    $("#colonia").focus();
                    banderaguarda = 0;
                }else if ($("#entrecallelic").val() == '' || $("#entrecallelic").val() == null){
                    alert ("Entre Calle es un campo obligatorio");
                    $("#entrecallelic").focus();
                    banderaguarda = 0;
                }else if ($("#yentrecallelic").val() == '' || $("#yentrecallelic").val() == null){
                    alert ("Y entre calle es un campo obligatorio");
                    $("#yentrecalle").focus();
                    banderaguarda = 0;
                }else if ($("#telefono").val() == ''){
                    alert ("Teléfono es un campo obligatorio");
                    $("#telefono").focus();
                    banderaguarda = 0;
                }else if ($("#celular").val() == ''){
                    alert ("Celular es un campo obligatorio");
                    $("#celular").focus();
                    banderaguarda = 0;
                }else if ($("#correo").val() == ''){
                    alert ("Correo es un campo obligatorio");
                    $("#correo").focus();
                    banderaguarda = 0;
                }
            }else if ($("#domiciliolic").val() == ''){
                alert ("Domicilio de ubicación física es un campo obligatorio");
                $("#domiciliolic").focus(); 
                banderaguarda = 0;
			}else if ($("#domiciliolicnumext").val() == ''){
                alert ("Número exterior del domicilio de ubicación física es un campo obligatorio");
                $("#domiciliolicnumext").focus(); 
                banderaguarda = 0;
            }else if ($("#estadoid").val() == ''){
                alert ("Estado es un campo obligatorio");
                $("#estado").focus();  
                banderaguarda = 0;
            }else if ($("#municipioid").val() == ''){
                alert ("Municipio es un campo obligatorio");
                $("#municipio").focus();  
                banderaguarda = 0;
            }else if ($("#colonialicid").val() == '' || $("#colonialicid").val() == null){
                alert ("Colonia es un campo obligatorio");
                $("#colonialic").focus();  
                banderaguarda = 0;
			}else if ($("#entrecallelic").val() == '' || $("#entrecallelic").val() == null){
                alert ("Entre Calle es un campo obligatorio");
                $("#entrecalle").focus();
                banderaguarda = 0;
            }else if ($("#yentrecallelic").val() == '' || $("#yentrecallelic").val() == null){
                alert ("Y entre calle es un campo obligatorio");
                $("#yentrecalle").focus();
                banderaguarda = 0;
            }else if ($("#lat").val() == ''){
                alert ("Latitud es un campo obligatorio, ubica en el mapa tu dirección");
                $("#map").focus();  
                banderaguarda = 0;
            }else if ($("#lng").val() == ''){
                alert ("Longitud es un campo obligatorio, ubica en el mapa tu dirección");
                $("#map").focus();  
                banderaguarda = 0;
            }
            
            if (banderaguarda == 1){
                var form_data = new FormData(document.getElementById("MiFormulario"));
				const urlParams = new URLSearchParams(window.location.search);
				const tramiteid = urlParams.get('tramiteid');
				if(tramiteid != null) {
					form_data.append('tramiteid', tramiteid);
				}
	
                $.ajax({
                    url: '../ajax/global_guardatramitelicenciaprovisional.php',
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
                            alert ("Trámite guardado con éxito.");
                            //Enviar correo
                            $.ajax({
                                url: '../ajax/global_enviarcorreo.php',
                                dataType: "text",
                                type: 'post',
                                data: {
                                    "destinatario": $("#correousuario").val(),
                                    "asunto": $("#asunto").val(),
                                    "cuerpo": $("#cuerpo").val()
                                },  
                                success: function(data) { 
                                    alert (data);
                                    if ($("#usuarioid").val() == '' || $("#usuarioid").val() == 'null'){
                                        //Es usuario externo
                                        location.href = "../gui/global_tramiteexterno.php";
                                    }else{
                                        //Usuario logeado
                                        location.href = "../gui/global_tramiteall.php";
                                    }
                                    $("#loading").hide();
                                }
                            });
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
                        
                    }
                });
            }
        });        
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
		
	function get_datos_permiso_especial(tramitevu_id) {
		var ajax = new XMLHttpRequest();
		var method = "GET";
		var url = "../ajax/global_getinfopermisoespecial.php?tramitevu_id="+tramitevu_id;
		var asynchronous = false;
		var data;
		ajax.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				data = JSON.parse(this.responseText.trim());
			}
		}
		ajax.open(method, url, asynchronous);
		ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		ajax.send();
		return data;
	}
	
	function mostrar_datos_permiso_especial(pe) {
		if (pe[0].tipo_evento != null && pe[0].tipo_evento != '') 
			$("#tipoevento").val(pe[0].tipo_evento);
		
		if(pe[0].giro_id != null && pe[0].giro_id != '')
			$("#giroid").val(pe[0].giro_id);
		
		if (pe[0].fecha_inicial != null && pe[0].fecha_inicial != '') 
			$("#fechai").val(pe[0].fecha_inicial);
		
		if (pe[0].fecha_final != null && pe[0].fecha_final != '') 
			$("#fechaf").val(pe[0].fecha_final);
		
		if (pe[0].horario_inicio != null && pe[0].horario_inicio != '') 
			$("#horario").val(pe[0].horario_inicio);
		
		if (pe[0].horario_fin != null && pe[0].horario_fin != '') 
			$("#horariofin").val(pe[0].horario_fin);
		
		if (pe[0].descripcion != null && pe[0].descripcion != '') 
			$("#descripcion").val(pe[0].descripcion);
		
		if (pe[0].rfc_rfc != null && pe[0].rfc_rfc != '') 
			$("#rfcsource").val(pe[0].rfc_rfc);
		
		if (pe[0].propietario_id != null && pe[0].propietario_id != '') 
			$("#personaid").val(pe[0].propietario_id);
		
		if (pe[0].persona_razonsocial != null && pe[0].persona_razonsocial != '') 
			$("#personanombre").val(pe[0].persona_razonsocial);
		
		if (pe[0].propietario_direccion != null && pe[0].propietario_direccion != '') 
			$("#direccion").val(pe[0].propietario_direccion);
		
		if (pe[0].domicilio != null && pe[0].domicilio != '') 
			$("#domiciliolic").val(pe[0].domicilio);
		
		if (pe[0].domicilio_num != null && pe[0].domicilio_num != '') 
			$("#domiciliolicnumext").val(pe[0].domicilio_num);
		
		if (pe[0].colonia_cp != null && pe[0].colonia_cp != '') 
			$("#codigopostal").val(pe[0].colonia_cp);
		
		if (pe[0].colonia_id != null && pe[0].colonia_id != '') 
			$("#colonialicid").val(pe[0].colonia_id);
		
		if (pe[0].entrecalle != null && pe[0].entrecalle != '') 
			$("#entrecallelic").val(pe[0].entrecalle);
		
		if (pe[0].yentrecalle != null && pe[0].yentrecalle != '') 
			$("#yentrecallelic").val(pe[0].yentrecalle);
		
		if (pe[0].latitud != null && pe[0].latitud != '') 
			$("#lat").val(pe[0].latitud);
		
		if (pe[0].longitud != null && pe[0].longitud != '') 
			$("#lng").val(pe[0].longitud);
		
		$("#map").css('visibility', 'visible');
        var lat_lng = {lat: pe[0].latitud, lng: pe[0].longitud};

        var map = new google.maps.Map(document.getElementById('map'));
		map.setCenter(new google.maps.LatLng(pe[0].latitud, pe[0].longitud));
		map.setZoom(16);
			
		var myLatlng = new google.maps.LatLng(pe[0].latitud,pe[0].longitud);
		var marker;
        marker = new google.maps.Marker({
			position: myLatlng,
			map: map
		});
				
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
				
		document.getElementById('btnguardar').value = 'Actualizar registro';
	}
	
</script>
  </head>
  <body>
    <div id="loading" style="display:none">
        <img id="loading-image" src="../images/global_loading.gif"/>
    </div>
    * Para mas información consulta el Artículo 24 en el <a href="../docs/reglamento.pdf" target="_blank">Reglamento de la Unidad Administrativa de Alcoholes</a>
    <br><br>
    <a target="_blank" href="../gui/global_startayuda10.php">Da click aquí para más información</a>
    <br><br>
    <div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="MiFormulario" name="MiFormulario">
                    <div class="form-group col-md-12">
                        <h4>Datos Generales</h4>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="tipoevento" name="tipoevento" type="text" class="form-control" placeholder="Tipo de Evento *" maxlength="250" autocomplete="off">
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
							Para desplazarte a meses siguientes en el calendario, haz click en el cuadrito verde que aparece en la parte superior derecha del calendario.
						</div>
					</div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="fechai" name="fechai" type="text" class="form-control" placeholder="Fecha Inicio *" maxlength="250" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="fechaf" name="fechaf" type="text" class="form-control" placeholder="Fecha Fin*" maxlength="250" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="horario" name="horario" type="time" class="form-control" placeholder="Horario Inicio *" maxlength="250">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="horariofin" name="horariofin" type="time" class="form-control" placeholder="Horario Fin *" maxlength="250">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Tipo de venta que se realizará en el evento *" rows="3" maxlength="1000" autocomplete="off"></textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <br><h4>Datos de la persona que organiza</h4>
                    </div>
                    <div class="form-row" align="right">
                        <div class="form-group col-md-12">
                            <a id="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentras el RFC de la persona que organiza ó faltan datos ó están incorrrectos, dalo de alta aquí</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="rfcsource" name="rfcsource" type="text" class="form-control" placeholder="RFC *" maxlength="13" autocomplete="off">
                            <input id="personaid" name="personaid" type="hidden">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <input id="personanombre" name="personanombre" type="text" class="form-control" placeholder="Nombre" readonly maxlength="250">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="direccion" name="direccion" type="text" class="form-control" placeholder="Domicilio" readonly maxlength="250">
                    </div>
                    <div class="form-group col-md-12">
                        <br><h4>Lugar del Evento</h4>
                    </div>
                    <table width="100%">
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-group col-md-12">
                                    <input id="domiciliolic" name="domiciliolic" type="text" class="form-control" placeholder="Domicilio (calle)*" autocomplete="off">
                                </div>
								<div class="form-group col-md-12">
                                    <input id="domiciliolicnumext" name="domiciliolicnumext" type="text" class="form-control" placeholder="Domicilio (número ext)*" autocomplete="off">
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
                                    <input id="codigopostal" name="codigopostal" type="text" class="form-control" placeholder="Código Postal *" autocomplete="off">
                                </div>
                                <div class="form-group col-md-12">
                                    <select id="colonialicid" name="colonialicid" class="form-control">
									</select>
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="entrecallelic" name="entrecallelic" type="text" class="form-control" placeholder="Entre Calle" autocomplete="off">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="yentrecallelic" name="yentrecallelic" type="text" class="form-control" placeholder="Y Calle" autocomplete="off">
                                </div>
								<div class="form-group col-md-12">
									<input type="button" id="btnubicardireccion" class="btn btn-primary btn-send-message" value="Ubicar en el mapa">
								</div>
								<div class="form-group col-md-12" style="text-align: justify">
									<span style="font-size: 20px;">Después de haber llenado todos los campos anteriores, haz click en "Ubicar en el mapa" y después haz click en el mapa en el punto donde se ubicará el establecimiento y así poder llenar el campo de latitud y longitud.
									<br><span style="color: red;">*Nota:</span> En caso de que Google Maps no localice correctamente la ubicación, arrastrar el mapa con el mouse hasta localizar el punto del establecimiento. Puedes hacer click en el ícono de + o de - para hacer zoom al mapa.</span>
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
                        <tr>
                            <td colspan="2">
                                <? if (isset($usersessionext[0]['correoexterno'])){?>
                                    <div class="form-group col-md-12">
                                        <input type="hidden" id="usuarioid" name="usuarioid" value="null">
                                        <input type="hidden" id="usuarionombre" name="usuarionombre" value="">
                                        <input type="hidden" id="correousuario" name="correousuario" class="form-control" readonly value="<?=$usersessionext[0]['correoexterno']?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <input type="hidden" id="rfcusuario" name="rfcusuario" class="form-control" readonly value="<?=$usersessionext[0]['rfcexterno']?>">
                                    </div>
                                <?}else{?>
                                    <input type="hidden" id="usuarioid" name="usuarioid" value="<?=$usersession[0]['usuarios_id']?>">
                                    <input type="hidden" id="usuarionombre" name="usuarionombre" value="<?=$usersession[0]['usuarios_nombre']?>">
                                    <input type="hidden" id="correousuario" name="correousuario" value="<?=$usersession[0]['usuarios_correo']?>">
                                    <input type="hidden" id="rfcusuario" name="rfcusuario" value="">
                                <?}?>
                                <div class="form-group col-md-12">
                                    <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar Solicitud">
                                </div>
                            </td>
                        </tr>
                    </table>
                    
                </form>
            </div>

        </div>
    </div>
</div>
<div id="htmldiv">
    <!--Descripción del servicio -->
    <!--<br><br>
    <b>DERECHOS PARA VENTA EN EVENTOS Y ESPECTÁCULOS PÚBLICOS</b>
    <br/><br/>
    a) Por cerveza igual o superior a los 940 mililitros ($10.20)
    b) Por cerveza inferior a los 940 mililitros ($9.00)
    c) Por descorche de botella ($125.00)
    <br><br>
    <b>POR EL PERMISO ESPECIAL PARA LA VENTA DE VINOS, LICORES Y CERVEZAS SE PAGARÁ EL 8% DEL VALOR DE LA LICENCIA, EL CUAL TENDRÁ VIGENCIA DE UNO A TREINTA DÍAS NATURALES.</b>
    <br/><br/>
    EJEMPLO:
    <br><br>
    1 chárola  - $9.00 * 24 = <b>$216.00</b><br>
    2 chárolas - $9.00 * 2 * 24 = <b>$432.00</b><br>
    3 chárolas - $9.00 * 3 * 24 = <b>$648.00</b><br>
    4 chárolas - $9.00 * 4 * 24 = <b>$864.00</b><br>
    etc.
    <br><br>
    <b>POR EL PERMISO ESPECIAL PARA LA VENTA, DEGUSTACIÓN DE VINOS, LICORES Y CERVEZA SE PAGARÁ EL 8% DEL VALOR DE LA LICENCIA, EL CUAL TENDRÁ VIGENCIA DE UNO A TREINTA DÍAS NATURALES.</b>-->
</div>
</body>
</html>
<!-- Container modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ui-front">
            <div class="modal-body"  id="prueba">

            </div>
            <div class="modal-footer">
                <i id="close" style="cursor:pointer; font-size: 1.5em;" title="Cerrar" class="icon-circle-cross" data-dismiss="modal"></i>
            </div>
        </div>
    </div>
</div>
<?php
//Correo que se envía
$asunto = "Solicitud de Permiso especial creada";
$cuerpo = "
<img src='".$GLOBALS['vu_global_site']."images/logo2.png' width='200px'>
<br><br>
Solicitud creada exitosamente.

Si deseas consultar el estatus de tu solicitud, accede a nuestro portal en la siguiente dirección <a href='".$GLOBALS['vu_global_site']."gui/global_loginext.php'>UAA</a> con tu correo y el RFC que utilizaste para accesar.
";
?>
<input type="hidden" id="asunto" value="<?=$asunto?>">
<input type="hidden" id="cuerpo" value="<?=$cuerpo?>">