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
                if ($("#colonialicid").val() == ""){
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
				var solicitud_licencia = get_datos_solicitud_licencia(tramiteid);
				mostrar_datos_licencia(solicitud_licencia);
			}
		}, 1000);
        
        //Get Giro
        var items1="";
        $.getJSON("../ajax/global_getgiro.php",function(data){
            items1+="<option value='' disabled selected>Giro *</option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#giroid").html(items1); 
        });
		
		// Get tipo licencia
		var items2="";
        $.getJSON("../ajax/global_gettipolicencia.php",function(data){
            items2+="<option value='' disabled selected>Tipo de licencia *</option>";
            $.each(data,function(index,item){
                let tipo = (item.id == 1 ? 'A Solo cerveza' : 'B Cualquier tipo de vinos, licores y cervezas');
                items2+="<option value='"+item.id+"'>"+item.nombre+" tipo - " + tipo +"  </option>";
            });
            $("#tipoid").html(items2); 
        });
		
		// Get colonias 
		var items3="";
		$.getJSON("../ajax/global_getcoloniasbycp.php?codigo_postal=&municipioid=66",function(data){
            items3+="<option value='' disabled selected>Colonia *</option>";
            $.each(data,function(index,item){
                items3+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#colonialicid").html(items3); 
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
                $('#direccionnumext').val(ui.item.domicilionumext);
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
        
        //Get RFC comodatario
        $("#rfcsourcecomodatario").autocomplete({
            minLength: 2,
            source: function(request, response) {
                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#rfcsourcecomodatario").val(), {
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
                $('#rfcsourcecomodatario').val(ui.item.label); 
                $('#direccioncomodatario').val(ui.item.domicilio);
                $('#personanombrecomodatario').val(ui.item.nombre);
                $('#personaidcomodatario').val(ui.item.id);
                return false;
             },
            change: function( event, ui ) {
                $('#rfcsourcecomodatario').val(ui.item? ui.item.label : '');
                $( "#direccioncomodatario" ).val( ui.item? ui.item.domicilio : '' );
                $( "#personanombrecomodatario" ).val( ui.item? ui.item.nombre : '' );
                $( "#personaidcomodatario" ).val( ui.item? ui.item.id : '' );
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
        $("#colonialicid").on("click",function(){
            if ($("#municipioid").val() == ''){
                alert ("Debes seleccionar Municipio");
                $("#municipio").focus();
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
        
        $(".altarfc").on("click",function(){
            
            let contenedor = document.getElementById("prueba");
                            contenedor.innerHTML = '';
                            var html =  '<form id="MiFormularioRFC" name="MiFormularioRFC">'+
                                            '<input type="text" id="rfctext" name="rfctext" class="form-control" placeholder="RFC *" maxlength="13" autocomplete="off">'+
                                            '<input type="text" id="nombretext" name="nombretext" class="form-control" placeholder="Razón Social *" maxlength="250" autocomplete="off">'+        
                                            '<input type="text" id="curptext" name="curptext" class="form-control" placeholder="CURP" maxlength="18" autocomplete="off">'+
                                            '<input type="text" width="80%" id="direcciontext" name="direcciontext" class="form-control" placeholder="Dirección (calle)*" maxlength="250" autocomplete="off">'+
											'<input type="text" width="20%" id="direcciontextnum" name="direcciontextnum" class="form-control" placeholder="Dirección (número ext) *" maxlength="10" autocomplete="off">'+
                                            '<input id="estadotext" name="estadotext" type="text" class="form-control" placeholder="Estado *" autocomplete="off">'+
                                            '<input id="estadoidtext" name="estadoidtext" type="hidden">'+
                                            '<input id="municipiotext" name="municipiotext" type="text" class="form-control" placeholder="Municipio *" autocomplete="off">'+
                                            '<input id="municipioidtext" name="municipioidtext" type="hidden">'+
                                            '<input type="text" id="coloniatext" name="coloniatext" class="form-control" placeholder="Colonia" maxlength="250" autocomplete="off">'+
                                            '<input type="hidden" id="coloniaidtext" name="coloniaidtext">'+
                                            '<input type="text" id="entrecalletext" name="entrecalletext" class="form-control" placeholder="Entre calle" maxlength="100" autocomplete="off">'+
                                            '<input type="text" id="yentrecalletext" name="yentrecalletext" class="form-control" placeholder="y Entre calle" maxlength="100" autocomplete="off">'+
                                            '<input type="text" id="telefonotext" name="telefonotext" class="form-control" placeholder="Teléfono *" maxlength="10" onkeypress="return enteros(event)" onpaste="return false;" autocomplete="off">'+
                                            '<input type="text" id="celulartext" name="celulartext" class="form-control" placeholder="Celular" maxlength="10" onkeypress="return enteros(event)" onpaste="return false;" autocomplete="off">'+
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
                                }else if($("#direcciontextnum").val() == ''){
									alert("Número exterior es un campo obligatorio");
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
                                }else if ($("#correotext").val() == ''){
                                    alert ("Correo es un campo obligatorio");
                                    $("#correotext").focus();
                                }else if (validarcorreo($('#correotext').val()) == 0){
                                    alert ("Correo no válido");
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
            if ($("#nombregenerico").val() == ''){
                alert ("Nombre Genérico es un campo obligatorio");
                $("#nombregenerico").focus();
                banderaguarda = 0;
            }else if ($('#giroid').find('option:selected').attr('disabled')) {
                alert ("Giro es un campo obligatorio");
                $("#giroid").focus();
                banderaguarda = 0;
			}else if ($('#tipoid').find('option:selected').attr('disabled')) {
                alert ("Tipo de licencia es un campo obligatorio");
                $("#tipoid").focus();
                banderaguarda = 0;
            }else if ($("#rfcsource").val() == ''){
                alert ("RFC del propietario es un campo obligatorio");
                $("#rfcsource").focus();
                banderaguarda = 0; 
            }else if ($("#domiciliolic").val() == ''){
                alert ("Domicilio de ubicación física es un campo obligatorio");
                $("#domiciliolic").focus(); 
                banderaguarda = 0;
			}else if ($("#domiciliolicnum").val() == ''){
                alert ("Número exterior del domicilio es un campo obligatorio");
                $("#domiciliolicnum").focus(); 
                banderaguarda = 0;
            }else if ($("#estadoid").val() == ''){
                alert ("Estado es un campo obligatorio");
                $("#estado").focus();  
                banderaguarda = 0;
            }else if ($("#municipioid").val() == ''){
                alert ("Municipio es un campo obligatorio");
                $("#municipio").focus();  
                banderaguarda = 0;
            }else if ($("#colonialicid").val() == ''){
                alert ("Colonia es un campo obligatorio");
                $("#colonialic").focus();  
                banderaguarda = 0;
            }else if ($("#lat").val() == ''){
                alert ("Latitud es un campo obligatorio, ubica en el mapa tu dirección");
                $("#map").focus();  
                banderaguarda = 0;
            }else if ($("#lng").val() == ''){
                alert ("Lonitud es un campo obligatorio, ubica en el mapa tu dirección");
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
                    url: '../ajax/global_guardatramitelicencia.php',
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
          
      function validarcorreo(correos){
            var bandera = 1;
            var correo = correos.split(",");
            for(i=0;i<correo.length;i++){
                if (!(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(correo[i]))){
                   bandera = 0;
                }
            }
            return bandera;    
        }
		
		// Función para traer los datos de la solicitud de licencia
		function get_datos_solicitud_licencia(tramiteid) {
			var ajax = new XMLHttpRequest();
			var method = "GET";
			var url = "../ajax/global_getdatossolicitudlicencia.php?tramitevu_id="+tramiteid;
			var asynchronous = false;
			var data;
			ajax.onreadystatechange = function(){
				if (this.readyState == 4 && this.status == 200){
					data = JSON.parse(this.responseText);
				}
			}
			ajax.open(method, url, asynchronous);
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send();
			return data;
		}
		
		// Función para mostrar los datos de la licencia en los inputs
		function mostrar_datos_licencia(lic) {
			if (lic[0].nombregenerico != null && lic[0].nombregenerico != '') 
				$("#nombregenerico").val(lic[0].nombregenerico);
			
			if (lic[0].giro_id != null && lic[0].giro_id != '') 
				$("#giroid").val(lic[0].giro_id);
			
			if (lic[0].tipo_licencia_id != null && lic[0].tipo_licencia_id != '') 
				$("#tipoid").val(lic[0].tipo_licencia_id);
			
			if (lic[0].rfc_propietario != null && lic[0].rfc_propietario != '') 
				$("#rfcsource").val(lic[0].rfc_propietario);
			
			if (lic[0].propietario_id != null && lic[0].propietario_id != '') 
				$("#personaid").val(lic[0].propietario_id);
			
			if (lic[0].nombre_propietario != null && lic[0].nombre_propietario != '') 
				$("#personanombre").val(lic[0].nombre_propietario)		
			
			if (lic[0].direccion_propietario != null && lic[0].direccion_propietario != '') 
				$("#direccion").val(lic[0].direccion_propietario);
			
			if (lic[0].rfc_comodatario != null && lic[0].rfc_comodatario != '') 
				$("#rfcsourcecomodatario").val(lic[0].rfc_comodatario);			
			
			if (lic[0].nombre_comodatario != null && lic[0].nombre_comodatario != '') 
				$("#personanombrecomodatario").val(lic[0].nombre_comodatario);
			
			if (lic[0].comodatario_id != null && lic[0].comodatario_id != '') 
				$("#personaidcomodatario").val(lic[0].comodatario_id);
			
			if (lic[0].direccion_comodatario != null && lic[0].direccion_comodatario != '') 
				$("#direccioncomodatario").val(lic[0].direccion_comodatario);
			
			if (lic[0].domicilio_licencia != null && lic[0].domicilio_licencia != '') 
				$("#domiciliolic").val(lic[0].domicilio_licencia);
			
			if (lic[0].domicilio_licencia_num != null && lic[0].domicilio_licencia_num != '') 
				$("#domiciliolicnum").val(lic[0].domicilio_licencia_num);
			
			if (lic[0].colonia_licencia_id != null && lic[0].colonia_licencia_id != '') 
				$("#colonialicid").val(lic[0].colonia_licencia_id);
			
			if (lic[0].colonia_cp != null && lic[0].colonia_cp != '') 
				$("#codigopostal").val(lic[0].colonia_cp);
			
			if (lic[0].entrecalle != null && lic[0].entrecalle != '') 
				$("#entrecallelic").val(lic[0].entrecalle);
			
			if (lic[0].yentrecalle != null && lic[0].yentrecalle != '') 
				$("#yentrecallelic").val(lic[0].yentrecalle);
			
			if (lic[0].latitud != null && lic[0].latitud != '') 
				$("#lat").val(lic[0].latitud);
			
			if (lic[0].longitud != null && lic[0].longitud != '') 
				$("#lng").val(lic[0].longitud);
			
			$("#map").css('visibility', 'visible');
            var lat_lng = {lat: lic[0].latitud, lng: lic[0].longitud};

            var map = new google.maps.Map(document.getElementById('map'));
			map.setCenter(new google.maps.LatLng(lic[0].latitud, lic[0].longitud));
			map.setZoom(16);
			
			var myLatlng = new google.maps.LatLng(lic[0].latitud,lic[0].longitud);
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
    <div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="MiFormulario" name="MiFormulario">
                    <div class="form-group col-md-12">
                        <h4>Datos del establecimiento</h4>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="nombregenerico" name="nombregenerico" type="text" class="form-control" placeholder="Nombre Genérico *" maxlength="250" autocomplete="off">
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
                            <select id="tipoid" name="tipoid" class="form-control">
                            </select>
                        </div>
                    </div>
					<div class="form-row" align="left">
						<div class="form-group col-md-12">
							<br><h4>Datos Propietario Licencia</h4>
                        </div>
					</div>
                    <div class="form-row" align="right">
                        <div class="form-group col-md-12">
                            <a class="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentras el RFC del propietario ó faltan datos ó están incorrectos, dalo de alta aquí</a>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="rfcsource" name="rfcsource" type="text" class="form-control" placeholder="RFC *" maxlength="13" autocomplete="off">
                            <input id="personaid" name="personaid" type="hidden">
                        </div>
                    </div>
                    <input id="bandera" name="bandera" type="hidden" value="0">
                    <div class="form-group col-md-12">
                        <input id="personanombre" name="personanombre" type="text" class="form-control" placeholder="Nombre" readonly maxlength="250">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="direccion" name="direccion" type="text" class="form-control" placeholder="Domicilio" readonly maxlength="250">
                    </div>
					
                    <div class="form-group col-md-12">
                        <br><h4>Datos Comodatario</h4>
                    </div>
                    <div class="form-row" align="right">
                        <div class="form-group col-md-12">
                            <a class="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentras el RFC del comodatario ó faltan datos ó están incorrectos, dalo de alta aquí</a>
                        </div>
                    </div>
                    <div class="form-row"> 
                        <div class="form-group col-md-12">
                            <input id="rfcsourcecomodatario" name="rfcsourcecomodatario" type="text" class="form-control" placeholder="RFC" maxlength="13" autocomplete="off">
                            <input id="personaidcomodatario" name="personaidcomodatario" type="hidden">
                        </div>
                    </div>
                    <input id="banderacomodatario" name="banderacomodatario" type="hidden" value="0">
                    <div class="form-group col-md-12">
                        <input id="personanombrecomodatario" name="personanombrecomodatario" type="text" class="form-control" placeholder="Nombre" maxlength="250">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="direccioncomodatario" name="direccioncomodatario" type="text" class="form-control" placeholder="Domicilio" maxlength="250" autocomplete="off">
                    </div>
                    <div class="form-group col-md-12">
                        <br><h4>Ubicación Fiscal de Licencia</h4>
                    </div>
                    <table width="100%">
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-group col-md-12">
                                    <input id="domiciliolic" name="domiciliolic" type="text" class="form-control" placeholder="Domicilio (calle)*" autocomplete="off">
                                </div>
								<div class="form-group col-md-12">
                                    <input id="domiciliolicnum" name="domiciliolicnum" type="text" class="form-control" placeholder="Domicilio (número ext)*" autocomplete="off">
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
$asunto = "Solicitud de Licencia Creada";
$cuerpo = "
<img src='".$GLOBALS['vu_global_site']."images/logo2.png' width='200px'>
<br><br>
Solicitud creada exitosamente.

Si deseas consultar el estatus de tu solicitud, accede a nuestro portal en la siguiente dirección <a href='".$GLOBALS['vu_global_site']."gui/global_loginext.php'>UAA</a> con tu correo y el RFC que utilizaste para accesar.
";
?>
<input type="hidden" id="asunto" value="<?=$asunto?>">
<input type="hidden" id="cuerpo" value="<?=$cuerpo?>">