<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para editar licencia
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2002',$usersessionpermisos);
?>
<?
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            input, textarea {
                text-transform: uppercase;
            }
        </style>

        <style type="text/css">
            /* Always set the map height explicitly to define the size of the div
            * element that contains the map. */
            #mapori {
                height: 538px !important;
            }
        </style>
  
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH-qH3BIJ5qnuA1EE98X5ED17FPLS_XUU&callback=initMap&libraries=&v=weekly" defer></script>
        <script>
            (function(exports) {
                "use strict";

                    function initMap() {
                        exports.map = new google.maps.Map(document.getElementById("mapori"), {
                            center: {
                                lat: 25.423634,
                                lng: -101.000851
                            },
                            zoom: 15
                        });
                    }

                exports.initMap = initMap;
            })((this.window = this.window || {}));
			
			function geocodeAddress(geocoder, resultsMap) {
				var marker;
				var address = document.getElementById('adomiciliolic').value;
				var colonia = document.getElementById('acolonia').value;
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
			}

        var map = resultsMap;

        google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {

            // Create a new InfoWindow.
            var latlng = mapsMouseEvent.latLng.toString();
            var dividir =  latlng.replace('(', '').replace(')', '').split(',');
            var lat = dividir[0];
            var lng = dividir[1];
            //asignar valores
            $("#alatitud").val(lat);
            $("#alongitud").val(lng);

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
    }
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
                                    pid: m.pid,
                                    prfc: m.prfc,
                                    pnombre: m.pnombre,
                                    cid: m.cid,
                                    crfc: m.crfc,
                                    cnombre: m.cnombre,
                                    nombregenerico: m.nombregenerico,
                                    giroid: m.giroid,
                                    giro: m.gironombre,
                                    tipolicencia: m.tipolicencia,
                                    idtipolicencia: m.idtipolicencia
                                };
                            });
                            response(array);
                        });
                    },
                    select: function (event, ui) {
						$('#adomiciliolic').val(ui.item? ui.item.domicilio : ''); 
                        $('#licencia').val(ui.item? ui.item.label : ''); 
                        $('#licenciaid').val(ui.item? ui.item.id : '');                  
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
                            title: ''
                        });

                        // To add the marker to the map, call setMap();
                        marker.setMap(map);
						
						google.maps.event.addListener(map, 'click', function(mapsMouseEvent) {
							// Create a new InfoWindow.
							var latlng = mapsMouseEvent.latLng.toString();
							var dividir =  latlng.replace('(', '').replace(')', '').split(',');
							var lat = dividir[0];
							var lng = dividir[1];
							//asignar valores
							$("#alatitud").val(lat);
							$("#alongitud").val(lng);
	
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
                            
                        $('#pnuevo').val(ui.item? ui.item.prfc : ''); 
                        $('#pnuevoid').val(ui.item? ui.item.pid : '');
                        $("#pnuevo").prop('readonly', false);
                        $('#cnuevo').val(ui.item? ui.item.cnombre : ''); 
                        $('#cnuevoid').val(ui.item? ui.item.cid : '');
                        $("#cnuevo").prop('readonly', false);
                        $('#nombregnuevo').val(ui.item? ui.item.nombregenerico : ''); 
                        $('#nombregnuevodis').val(ui.item? ui.item.nombregenerico : ''); 
                        $("#nombregnuevo").prop('readonly', false);
                        $('#giroid').val(ui.item? ui.item.giroid : '');
                        $('#tipolicenciaid').val(ui.item? ui.item.idtipolicencia : '');                             
                    },
                    change: function( event, ui ) {
                        /*$('#licencia').val(ui.item? ui.item.label : '');
                        $( "#licenciaid" ).val(ui.item? ui.item.id : '');
                        
                                $('#adomiciliolic').val(ui.item? ui.item.domicilio : ''); 
                                $('#acolonia').val(ui.item? ui.item.colonia : ''); 
                                $('#acoloniaid').val(ui.item? ui.item.coloniaid : '');
                                $('#aentrecalle').val(ui.item? ui.item.entrecalle : ''); 
                                $('#ayentrecalle').val(ui.item? ui.item.ycalle : '');
                                $('#alatitud').val(ui.item? ui.item.latitud : '');
                                $('#alongitud').val(ui.item? ui.item.longitud : '');
                            
                                $('#pnuevo').val(ui.item? ui.item.prfc : ''); 
                                $('#pnuevoid').val(ui.item? ui.item.pid : '');
                                $("#pnuevo").prop('readonly', false);
                                $('#cnuevo').val(ui.item? ui.item.crfc : ''); 
                                $('#cnuevoid').val(ui.item? ui.item.cid : '');
                                $("#cnuevo").prop('readonly', false);
                                $('#nombregnuevo').val(ui.item? ui.item.nombregenerico : ''); 
                                $('#nombregnuevodis').val(ui.item? ui.item.nombregenerico : ''); 
                                $("#nombregnuevo").prop('readonly', false);
                                $('#giroid').val(ui.item? ui.item.giroid : '');
                                $('#tipolicenciaid').val(ui.item? ui.item.idtipolicencia : ''); 
                            */
                    }
                });

				// Ubicar dirección en el mapa 
				$("#btnubicardireccion").on("click", function() {
					//mostrar mapa
					document.getElementById('alatitud').value = '';
					document.getElementById('alongitud').value = '';
					$("#mapori").css('visibility', 'visible');
					var myLatlng = {lat: 25.423634, lng: -101.000851};
				
					var map = new google.maps.Map(document.getElementById('mapori'), {zoom: 15, center: myLatlng});
					var geocoder = new google.maps.Geocoder();
					geocodeAddress(geocoder, map);
				});
                    
                //Cambio de Domicilio
                //Get Colonias
                $("#acolonia").autocomplete({
                    minLength: 4,
                    source: function(request, response) {
                        $.getJSON("../ajax/global_getcolonias.php?busqueda="+$("#acolonia").val()+"&municipioid="+$("#amunicipioid").val(), {
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
                        $('#acolonia').val(ui.item? ui.item.label : ''); 
                        $('#acoloniaid').val(ui.item? ui.item.id : '');
                     },
                    change: function( event, ui ) {
                        $('#acolonia').val(ui.item? ui.item.label : '');
                        $( "#acoloniaid" ).val(ui.item? ui.item.id : '');
                        if ($('#adomiciliolic').val() == ''){
                            alert("Porfavor, completa el campo dirección");
                            $("#adomiciliolic").focus();
                            $("#acoloniaid").val("");
                            $("#acolonia").val("");
                            $("#mapori").css('visibility', 'hidden');
                        }else{
                            var address = document.getElementById('adomiciliolic').value;
                            var colonia = document.getElementById('acolonia').value;
                            var geocoder = new google.maps.Geocoder();
                            var marker;

                            var mapOptions = {
                                zoom: 18,
                                center: new google.maps.LatLng(0,0)
                            };
                            map = new google.maps.Map(document.getElementById('mapori'), mapOptions);

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
                                $("#alatitud").val(lat);
                                $("#alongitud").val(lng);

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
                            if ($("#acolonia").val() == ""){
                                $("#mapori").css('visibility', 'hidden');
                            }else{
                                $("#mapori").css('visibility', 'visible');
                            }

                        }
                    }
                });
                    
                //Get RFC propietario
                $("#pnuevo").autocomplete({
                    minLength: 2,
                    source: function(request, response) {
                        $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#pnuevo").val(), {
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
                        $('#pnuevo').val(ui.item.label); 
                        $('#pnuevoid').val(ui.item.id);
                        return false;
                     },
                    change: function( event, ui ) {
                        $('#pnuevo').val(ui.item? ui.item.label : '');
                        $( "#pnuevoid" ).val( ui.item? ui.item.id : '' );
                    }
                });
                    
                $("#cnuevo").autocomplete({
                    minLength: 2,
                    source: function(request, response) {
                        $.getJSON("../ajax/global_getinfopersona.php?busqueda="+$("#cnuevo").val(), {
                            term: request.term
                        }, function(data) {                     
                            var array = data.error ? [] : $.map(data, function(m) {
                                return {
                                    label: m.nombre,
                                    value: m.nombre,
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
                        $('#cnuevo').val(ui.item.label); 
                        $('#cnuevoid').val(ui.item.id);
                        return false;
                     },
                    change: function( event, ui ) {
                        $('#cnuevo').val(ui.item? ui.item.label : '');
                        $( "#cnuevoid" ).val( ui.item? ui.item.id : '' );
                    }
                });
                    
                //Get Giro
                var items1="";
                $.getJSON("../ajax/global_getgiro.php",function(data){
                    items1+="<option value='' disabled>Giro</option>";
                    $.each(data,function(index,item){
                        items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                    });
                    $("#giroid").html(items1); 
                });
                    
                //Get Tipo licencia
                var items11="";
                $.getJSON("../ajax/global_gettipolicencia.php",function(data){
                    items11+="<option value='' disabled selected>Tipo Licencia</option>";
                    $.each(data,function(index,item){
                        items11+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                    });
                    $("#tipolicenciaid").html(items11); 
                });

                $("#altarfc").on("click",function(){
            
                    let contenedor = document.getElementById("prueba");
                                    contenedor.innerHTML = '';
                                    var html =  '<form id="MiFormularioRFC" name="MiFormularioRFC">'+
                                                    '<input type="text" id="rfctext" name="rfctext" class="form-control" placeholder="RFC *" maxlength="13">'+
                                                    '<input type="text" id="nombretext" name="nombretext" class="form-control" placeholder="Razón Social *" maxlength="250">'+        
                                                    '<input type="text" id="curptext" name="curptext" class="form-control" placeholder="CURP" maxlength="18">'+
                                                    '<input type="text" id="direcciontext" name="direcciontext" class="form-control" placeholder="Dirección *" maxlength="250">'+
                                                    '<input id="estadotext" name="estadotext" type="text" class="form-control" placeholder="Estado *">'+
                                                    '<input id="estadoidtext" name="estadoidtext" type="hidden">'+
                                                    '<input id="municipiotext" name="municipiotext" type="text" class="form-control" placeholder="Municipio *">'+
                                                    '<input id="municipioidtext" name="municipioidtext" type="hidden">'+
                                                    '<input type="text" id="coloniatext" name="coloniatext" class="form-control" placeholder="Colonia" maxlength="250">'+
                                                    '<input type="hidden" id="coloniaidtext" name="coloniaidtext">'+
                                                    '<input type="text" id="entrecalletext" name="entrecalletext" class="form-control" placeholder="Entre calle" maxlength="100">'+
                                                    '<input type="text" id="yentrecalletext" name="yentrecalletext" class="form-control" placeholder="y Entre calle" maxlength="100">'+
                                                    '<input type="text" id="telefonotext" name="telefonotext" class="form-control" placeholder="Teléfono *" maxlength="50" onkeypress="return enteros(event)" onpaste="return false;">'+
                                                    '<input type="text" id="celulartext" name="celulartext" class="form-control" placeholder="Celular *" maxlength="50" onkeypress="return enteros(event)" onpaste="return false;">'+
                                                    '<input type="text" id="correotext" name="correotext" class="form-control" placeholder="Correo *" maxlength="250">'+
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
                    if ($("#licenciaid").val() == ''){
                        alert ("Licencia es un campo obligatorio");
                        banderaguarda = 0;
                        $("#licencia").focus();
                    }
                    //Validar formulario cambio domicilio
                    else if ($("#adomiciliolic").val() == ''){
                        alert ("Domicilio es un campo obligatorio");
                        $("#adomiciliolic").focus();
                        banderaguarda = 0;
                    }else if ($("#acolonia").val() == ''){
                        alert ("Colonia es un campo obligatorio");
                        $("#acolonia").focus();
                        banderaguarda = 0;
                    }
                    // }else if ($("#aentrecalle").val() == ''){
                    //     alert ("Calle es un campo obligatorio");
                    //     $("#aentrecalle").focus();
                    //     banderaguarda = 0;
                    // }else if ($("#ayentrecalle").val() == ''){
                    //     alert ("Calle es un campo obligatorio");
                    //     $("#ayentrecalle").focus();
                    //     banderaguarda = 0;
                    // }
                    else if ($("#alatitud").val() == ''){
                        alert ("Latitud es un campo obligatorio selecciona en el mapa la ubicación.");
                        $("#alatitud").focus();
                        banderaguarda = 0;
                    }else if ($("#alongitud").val() == ''){
                        alert ("Longitud es un campo obligatorio selecciona en el mapa la ubicación.");
                        $("#alongitud").focus();
                        banderaguarda = 0;
                    }
                        
                    //Validar formulario cambio propietario
                    else if ($("#pnuevo").val() == ''){
                        alert ("Propietario es un campo obligatorio");
                        $("#pnuevo").focus();
                        banderaguarda = 0;
                    }

                    //Validar formulario cambio nombre generico
                    if ($("#nombregnuevo").val() == ''){
                        alert ("Nombre genérico es un campo obligatorio");
                        $("#nombregnuevo").focus();
                        banderaguarda = 0;
                    }
                        
                    //Validar formulario cambio giro
                    if ($('#giroid').find('option:selected').attr('disabled')) {
                        alert ("Giro es un campo obligatorio");
                        $("#giroid").focus();
                        banderaguarda = 0;
                    }

                    //Validar formulario cambio giro
                    if ($('#tipolicenciaid').find('option:selected').attr('disabled')) {
                        alert ("Tipo Licencia es un campo obligatorio");
                        $("#tipolicenciaid").focus();
                        banderaguarda = 0;
                    }
                        
                    if (banderaguarda == 1){
                        var form_data = new FormData(document.getElementById("MiFormulario"));
                        $.ajax({
                            url: '../ajax/global_updatelicencia.php',
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
								alert ("Trámite modificado con éxito.");                              
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
        
    </head>
    <body>
      <div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                
                <form id="MiFormulario" name="MiFormulario">
                    <div class="form-group col-md-12">
                        <label for="licencia"># Licencia</label>
                        <input id="licencia" name="licencia" type="text" class="form-control" placeholder="ALCC0001">
                        <small id="licenciahelp" class="form-text text-muted">ALCC o ALCA y 4 dígitos, selecciona la licencia</small>
                        <input id="licenciaid" name="licenciaid" type="hidden">
                        <input id="subtramites" name="subtramites" type="hidden" value="<?=$subtramites?>">
                    </div>
                    <!-- CAMBIO DE DOMICILIO -->
                    <br><h4>Ubicación Licencia</h4>
                    <table>
                        <tr>
                            <td width="50%" valign="top">
                                <div class="form-group col-md-12">
                                    <input id="adomiciliolic" name="adomiciliolic" type="text" class="form-control" placeholder="Dirección">
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
                                    <input id="acolonia" name="acolonia" type="text" class="form-control" placeholder="Colonia">
                                    <input id="acoloniaid" name="acoloniaid" type="hidden">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="aentrecalle" name="aentrecalle" type="text" class="form-control" placeholder="Entre calle">
                                </div>
                                <div class="form-group col-md-12">
                                    <input id="ayentrecalle" name="ayentrecalle" type="text" class="form-control" placeholder="y entre calle">
                                </div>
								<div class="form-group col-md-12">
									<input type="button" id="btnubicardireccion" class="btn btn-primary btn-send-message" value="Ubicar en el mapa">
								</div>
								<div class="form-group col-md-12" style="text-align: justify">
									<span style="font-size: 20px;">Después de haber llenado todos los campos anteriores, haz click en "Ubicar en el mapa" y después haz click en el mapa en el punto donde se ubicará el establecimiento y así poder llenar el campo de latitud y longitud.
									<br><span style="color: red;">*Nota:</span> En caso de que Google Maps no localice correctamente la ubicación, arrastrar el mapa con el mouse hasta localizar el punto del establecimiento. Puedes hacer click en el ícono de + o de - para hacer zoom al mapa.</span>
								</div>
                                <div class="form-group col-md-12">
                                    <input id="alatitud" name="alatitud" type="text" class="form-control" readonly placeholder="Latitud">
                                </div>
                                 <div class="form-group col-md-12">
                                    <input id="alongitud" name="alongitud" type="text" class="form-control" readonly placeholder="Longitud">
                                </div>
                            </td>
                            <td valign="top" style="visibility: hidden">
                                <div id="mapori"></div>
                            </td>
                        </tr>
                    </table>

                    <div class="form-row" align="right">
                        <div class="form-group col-md-12">
                            <a id="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentrás tu RFC dalo de alta aquí</a>
                        </div>
                    </div>
                    <!-- CAMBIO DE PROPIETARIO -->
                    <div class="form-group col-md-12">
                        <label for="pnuevo">Propietario</label>
                        <input id="pnuevo" name="pnuevo" type="text" class="form-control"  placeholder="RFC" readonly>
                        <input id="pnuevoid" name="pnuevoid" type="hidden">
                    </div>
                    <!-- CAMBIO DE COMODATARIO -->
                    <div class="form-group col-md-12">
                        <label for="cnuevo">Comodatario</label>
                        <input id="cnuevo" name="cnuevo" type="text" class="form-control"  placeholder="Nombre comodatario" readonly>
                        <input id="cnuevoid" name="cnuevoid" type="hidden">
                    </div>
                    <!-- CAMBIO DE NOMBRE GENERICO -->
                    <div class="form-group col-md-12">
                        <label for="nombregnuevo">Nombre Genérico</label>
                        <input id="nombregnuevo" name="nombregnuevo" type="text" class="form-control" readonly placeholder="Nombre Generico">
                    </div>
                    <!-- CAMBIO DE GIRO -->
                    <div class="form-group col-md-12">
                        <label for="giro">Giro</label>
                        <select id="giroid" name="giroid" class="form-control">
                        </select>
                    </div>
                    <!-- CAMBIO DE TIPO DE LICENCIA -->
                    <div class="form-group col-md-12">
                        <label for="tipolicenciaid">Tipo Licencia</label>
                        <select id="tipolicenciaid" name="tipolicenciaid" class="form-control">
                        </select>
                    </div>

                    <input type="hidden" id="usuarioid" name="usuarioid" value="<?=$usersession[0]['usuarios_id']?>">
                    <input type="hidden" id="usuarionombre" name="usuarionombre" value="<?=$usersession[0]['usuarios_nombre']?>">
                    <input type="hidden" id="correousuario" name="correousuario" value="">
                    <input type="hidden" id="rfcusuario" name="rfcusuario" value="">

                    <div class="form-group col-md-12">
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar">
                    </div>
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