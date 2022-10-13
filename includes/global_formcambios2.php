<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para consultar status
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
$cambios = json_decode($_GET['cambios']);								
$subtramites = implode(',', $cambios); 
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
            #map {
                height: 537px !important;
            }

            #mapori {
                height: 538px !important;
            }
        </style>
        
        
        
        <? foreach ($cambios as $row){?>
            <? if ($row == 1){?>
                <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCH-qH3BIJ5qnuA1EE98X5ED17FPLS_XUU&callback=initMap&libraries=&v=weekly" defer></script>
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
        
            <?}?>
        <?}?>
        
        <script language="javascript">

            $(document).ajaxStart(function() {
                $("#loading").show();
            });
			
			// Función para revisar si ya existe un trámite de cambio para esta licencia
			function revisar_existencia_tramite(num_licencia) {
				var ajax = new XMLHttpRequest();
				var method = "GET";
				var url = "../ajax/global_getexistenciatramitecambio.php?num_licencia="+num_licencia;
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

			// Función para traer los datos de la licencia
			function get_datos_cambios_licencias(tramitevu_id) {
				var ajax = new XMLHttpRequest();
				var method = "GET";
				var url = "../ajax/global_getinfotramitecambio.php?tramitevu_id="+tramitevu_id;
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
			
			function mostrar_cambios_licencia(cl) {
				if (cl[0].licencia != null && cl[0].licencia != '') 
					$("#licencia").val(cl[0].licencia);
				
				if (cl[0].licenciaid != null && cl[0].licenciaid != '') 
					$("#licenciaid").val(cl[0].licenciaid);
				
				if (cl[0].direccion_nueva != null && cl[0].direccion_nueva != '') 
					$("#domiciliolic").val(cl[0].direccion_nueva);
				
				if (cl[0].direccion_num_nuevo != null && cl[0].direccion_num_nuevo != '') 
					$("#domiciliolicnumext").val(cl[0].direccion_num_nuevo);
				
				if (cl[0].codigopostal != null && cl[0].codigopostal != '') 
					$("#codigopostal").val(cl[0].codigopostal);
				
				if (cl[0].coloniaid != null && cl[0].coloniaid != '') 
					$("#coloniaid").val(cl[0].coloniaid);
				
				if (cl[0].entrecalle != null && cl[0].entrecalle != '') 
					$("#entrecalle").val(cl[0].entrecalle);
				
				if (cl[0].yentrecalle != null && cl[0].yentrecalle != '') 
					$("#yentrecalle").val(cl[0].yentrecalle);
				
				if (cl[0].latitud != null && cl[0].latitud != '') 
					$("#latitud").val(cl[0].latitud);
				
				if (cl[0].longitud != null && cl[0].longitud != '') 
					$("#longitud").val(cl[0].longitud);
				
				if (cl[0].domicilio_anterior != null && cl[0].domicilio_anterior != '') 
					$("#adomiciliolic").val(cl[0].domicilio_anterior);
				
				if (cl[0].acolonia != null && cl[0].acolonia != '') 
					$("#acolonia").val(cl[0].acolonia);
				
				if (cl[0].acoloniaid != null && cl[0].acoloniaid != '') 
					$("#acoloniaid").val(cl[0].acoloniaid);
				
				if (cl[0].aentrecalle != null && cl[0].aentrecalle != '') 
					$("#aentrecalle").val(cl[0].aentrecalle);
				
				if (cl[0].ayentrecalle != null && cl[0].ayentrecalle != '') 
					$("#ayentrecalle").val(cl[0].ayentrecalle);
				
				if (cl[0].alatitud != null && cl[0].alatitud != '') 
					$("#alatitud").val(cl[0].alatitud);
			
				if (cl[0].alongitud != null && cl[0].alongitud != '') 
					$("#alongitud").val(cl[0].alongitud);
				
				if (cl[0].pnuevo != null && cl[0].pnuevo != '') 
					$("#pnuevo").val(cl[0].pnuevo);
				
				if (cl[0].pnuevoid != null && cl[0].pnuevoid != '') 
					$("#pnuevoid").val(cl[0].pnuevoid);
				
				if (cl[0].personanombre != null && cl[0].personanombre != '') 
					$("#personanombre").val(cl[0].personanombre);
				
				if (cl[0].direccion != null && cl[0].direccion != '') 
					$("#direccion").val(cl[0].direccion);
				
				if (cl[0].panteriorid != null && cl[0].panteriorid != '') {
					$("#panteriorid").val(cl[0].panteriorid);
					if (cl[0].panterior != null && cl[0].panterior != '') {
						$("#panterior").val(cl[0].panterior);
					}
				
					if (cl[0].nombre_propietario_anterior != null && cl[0].nombre_propietario_anterior != '') {
						$("#personanombrepanterior").val(cl[0].nombre_propietario_anterior);
					}
				
					if (cl[0].direccion_panterior != null && cl[0].direccion_panterior != '') {
						$("#direccionpanterior").val(cl[0].direccion_panterior);
					}
				}
				else if (cl[0].propietario_licencia_id != null && cl[0].propietario_licencia_id != '') {
					$("#panteriorid").val(cl[0].propietario_licencia_id);
					if (cl[0].propietario_licencia_rfc != null && cl[0].propietario_licencia_rfc != '') {
						$("#panterior").val(cl[0].propietario_licencia_rfc);
					}
				
					if (cl[0].propietario_licencia_nombre != null && cl[0].propietario_licencia_nombre != '') {
						$("#personanombrepanterior").val(cl[0].propietario_licencia_nombre);
					}
				
					if (cl[0].propietario_licencia_domicilio != null && cl[0].propietario_licencia_domicilio != '') {
						$("#direccionpanterior").val(cl[0].propietario_licencia_domicilio);
					}
				}
				
				if (cl[0].cnuevo != null && cl[0].cnuevo != '') 
					$("#cnuevo").val(cl[0].cnuevo);
	
				if (cl[0].cnuevoid != null && cl[0].cnuevoid != '') 
					$("#cnuevoid").val(cl[0].cnuevoid);
				
				if (cl[0].personanombrec != null && cl[0].personanombrec != '') 
					$("#personanombrec").val(cl[0].personanombrec);
				
				if (cl[0].direccionc != null && cl[0].direccionc != '') 
					$("#direccionc").val(cl[0].direccionc);
				
				if (cl[0].canteriorid != null && cl[0].canteriorid != '') {
					$("#canteriorid").val(cl[0].canteriorid);
					if (cl[0].canterior != null && cl[0].canterior != '') {
						$("#canterior").val(cl[0].canterior);
					}
					if (cl[0].nombre_anterior_comodatario != null && cl[0].nombre_anterior_comodatario != '') {
						$("#personanombrecanterior").val(cl[0].nombre_anterior_comodatario);
					}			
					if(cl[0].direccion_canterior != null && cl[0].direccion_canterior != '') {
						$("#direccioncanterior").val(cl[0].direccion_canterior);
					}
				}	
				else if(cl[0].comodatario_licencia_id != null && cl[0].comodatario_licencia_id != '') {
					$("#canteriorid").val(cl[0].comodatario_licencia_id);
					if (cl[0].comodatario_licencia_rfc != null && cl[0].comodatario_licencia_rfc != '') {
						$("#canterior").val(cl[0].comodatario_licencia_rfc);
					}
					if (cl[0].comodatario_licencia_nombre != null && cl[0].comodatario_licencia_nombre != '') {
						$("#personanombrecanterior").val(cl[0].comodatario_licencia_nombre);
					}			
					if(cl[0].comodatario_licencia_domicilio != null && cl[0].comodatario_licencia_domicilio != '') {
						$("#direccioncanterior").val(cl[0].comodatario_licencia_domicilio);
					}
				}		
		
				if (cl[0].nombregnuevo != null && cl[0].nombregnuevo != '') 
					$("#nombregnuevo").val(cl[0].nombregnuevo);
				
				if (cl[0].nombreganteriordis != null && cl[0].nombreganteriordis != '') 
					$("#nombreganteriordis").val(cl[0].nombreganteriordis);
				
				if (cl[0].nombreganterior != null && cl[0].nombreganterior != '') 
					$("#nombreganterior").val(cl[0].nombreganterior);
				
				if (cl[0].giroid != null && cl[0].giroid != '') 
					$("#giroid").val(cl[0].giroid);
				
				if (cl[0].giroanterior != null && cl[0].giroanterior != '') 
					$("#giroanterior").val(cl[0].giroanterior);
				
				if (cl[0].giroanteriorid != null && cl[0].giroanteriorid != '') 
					$("#giroanteriorid").val(cl[0].giroanteriorid);
				
				if (cl[0].tipolicenciaid != null && cl[0].tipolicenciaid != '') 
					$("#tipolicenciaid").val(cl[0].tipolicenciaid);
				
				if (cl[0].tipolicenciaanterior != null && cl[0].tipolicenciaanterior != '') 
					$("#tipolicenciaanterior").val(cl[0].tipolicenciaanterior);
				
				if (cl[0].tipolicenciaidanterior != null && cl[0].tipolicenciaidanterior != '') 
					$("#tipolicenciaidanterior").val(cl[0].tipolicenciaidanterior);
				
				document.getElementById('licencia').disabled = true;
				document.getElementById('pnuevo').disabled = false;
				document.getElementById('cnuevo').disabled = false;
				document.getElementById('nombregnuevo').disabled = false;
				
				if(cl[0].direccion_nueva != null && cl[0].direccion_nueva != '') {
					$("#map").css('visibility', 'visible');
					var lat_lng = {lat: cl[0].latitud, lng: cl[0].longitud};
					var map = new google.maps.Map(document.getElementById('map'));
					map.setCenter(new google.maps.LatLng(cl[0].latitud, cl[0].longitud));
					map.setZoom(16);
			
					var myLatlng = new google.maps.LatLng(cl[0].latitud,cl[0].longitud);
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
					
					$("#mapori").css('visibility', 'visible');
					var lat_lng = {lat: cl[0].alatitud, lng: cl[0].alongitud};
					var map = new google.maps.Map(document.getElementById('mapori'));
					map.setCenter(new google.maps.LatLng(cl[0].alatitud, cl[0].alongitud));
					map.setZoom(16);
			
					var myLatlng = new google.maps.LatLng(cl[0].alatitud,cl[0].alongitud);
					var marker;
					marker = new google.maps.Marker({
						position: myLatlng,
						map: map
					});
				}
				document.getElementById('btnguardar').value = 'Actualizar registro';
			}
			
			
            $(document).ready(function(){

                $("#licencia").autocomplete({
                    minLength: 8,
                    source: function(request, response) {
						var existe = revisar_existencia_tramite($("#licencia").val());
						if(existe) {
							var folio = existe[0]['tramitevu_folio'];
							alert("Ya existe un trámite de cambio para esta licencia. Puedes verlo en la opción 'Ver trámites'. El tramite asociado a esta licencia tiene codigo de barras: " + folio);
							// window.location.href = "../gui/global_tramiteexterno.php";
                            				document.getElementById("licencia").value = "";
						}
						else {
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
						}
                    },
                    select: function (event, ui) {
                        $('#licencia').val(ui.item? ui.item.label : ''); 
                        $('#licenciaid').val(ui.item? ui.item.id : '');
                        $("#licencia").prop('disabled', true);
                        <? foreach ($cambios as $row){ ?>
                            <? if ($row == 1){?>
                                $('#adomiciliolic').val(ui.item? ui.item.domicilio : ''); 
                                $('#acolonia').val(ui.item? ui.item.colonia : ''); 
                                $('#acoloniaid').val(ui.item? ui.item.coloniaid : '');
                                $('#aentrecalle').val(ui.item? ui.item.entrecalle : ''); 
                                $('#ayentrecalle').val(ui.item? ui.item.ycalle : '');
                                $('#alatitud').val(ui.item? ui.item.latitud : '');
                                $('#alongitud').val(ui.item? ui.item.longitud : '');
                                
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
                            <?}?>
                            <? if ($row == 2){?>
                                $('#panterior').val(ui.item? ui.item.prfc : ''); 
                                $('#panteriorid').val(ui.item? ui.item.pid : '');
                                $("#pnuevo").prop('disabled', false);
                            <?}?>
                            <? if ($row == 3){?>
                                $('#canterior').val(ui.item? ui.item.crfc : ''); 
                                $('#canteriorid').val(ui.item? ui.item.cid : '');
                                $("#cnuevo").prop('disabled', false);
                            <?}?>
                            <? if ($row == 4){?>
                                $('#nombreganterior').val(ui.item? ui.item.nombregenerico : ''); 
                                $('#nombreganteriordis').val(ui.item? ui.item.nombregenerico : ''); 
                                $("#nombregnuevo").prop('disabled', false);
                            <?}?>
                            <? if ($row == 5){?>
                                $('#giroanterior').val(ui.item? ui.item.giro : ''); 
                                $('#giroanteriorid').val(ui.item? ui.item.giroid : '');
                                $("#giro").prop('disabled', false);
                            <?}?>
                            <? if ($row == 6){?>
                                $('#tipolicenciaanterior').val(ui.item? ui.item.tipolicencia : ''); 
                                $('#tipolicenciaidanterior').val(ui.item? ui.item.idtipolicencia : '');
                            <?}?>
                        <?}?>
                     },
                    change: function( event, ui ) {
                        
                    }
                });
				
				// Ubicar dirección en el mapa 
				$("#btnubicardireccion").on("click", function() {
					//mostrar mapa
					document.getElementById('latitud').value = '';
					document.getElementById('longitud').value = '';
					$("#map").css('visibility', 'visible');
					var myLatlng = {lat: 25.423634, lng: -101.000851};
		
					var map = new google.maps.Map(document.getElementById('map'), {zoom: 15, center: myLatlng});
					var geocoder = new google.maps.Geocoder();
					geocodeAddress(geocoder, map);
				});

                <? foreach ($cambios as $row){?>
                    <? if ($row == 1){?>
                        //Cambio de Domicilio
						// Get colonias 
						var colonias="";
						$.getJSON("../ajax/global_getcoloniasbycp.php?codigo_postal=&municipioid=66",function(data){
							colonias+="<option value='' disabled selected>Colonia *</option>";
							$.each(data,function(index,item){
								colonias+="<option value='"+item.id+"'>"+item.nombre+"</option>";
							});
							$("#coloniaid").html(colonias); 
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
									$("#coloniaid").html(colonias); 
								});
							}
						});
                       /* $("#colonia").autocomplete({
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
                                $('#colonialicid').val(ui.item? ui.item.id : '');
                             },
                            change: function( event, ui ) {
                                $('#colonialicid').val(ui.item? ui.item.label : '');
                                if ($('#domiciliolic').val() == ''){
                                    alert("Porfavor, completa el campo dirección");
                                    $("#domiciliolic").focus();
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
                        });*/
						
						
                    <?}?>
                    <? if ($row == 2){?>
                        //Get RFC propietario nuevo
                        $("#pnuevo").autocomplete({
                            minLength: 2,
                            source: function(request, response) {
                                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#pnuevo").val(), {
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
                                $('#pnuevo').val(ui.item.label); 
                                $('#direccion').val(ui.item.domicilio);
                                $('#personanombre').val(ui.item.nombre);
                                $('#pnuevoid').val(ui.item.id);
                                return false;
                             },
                            change: function( event, ui ) {
                                $('#pnuevo').val(ui.item? ui.item.label : '');
                                $( "#direccion" ).val( ui.item? ui.item.domicilio : '' );
                                $( "#personanombre" ).val( ui.item? ui.item.nombre : '' );
                                $( "#pnuevoid" ).val( ui.item? ui.item.id : '' );
                            }
                        });
					<?}?>
						// Get RFC propietario anterior
						$("#panterior").autocomplete({
                            minLength: 2,
                            source: function(request, response) {
                                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#panterior").val(), {
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
                                $('#panterior').val(ui.item.label); 
                                $('#direccionpanterior').val(ui.item.domicilio);
                                $('#personanombrepanterior').val(ui.item.nombre);
                                $('#panteriorid').val(ui.item.id);
                                return false;
                             },
                            change: function( event, ui ) {
                                $('#panterior').val(ui.item? ui.item.label : '');
                                $( "#direccionpanterior" ).val( ui.item? ui.item.domicilio : '' );
                                $( "#personanombrepanterior" ).val( ui.item? ui.item.nombre : '' );
                                $( "#panteriorid" ).val( ui.item? ui.item.id : '' );
                            }
                        });
                  
                    <? if ($row == 3){?>
						// Datos del comodatario nuevo
                        $("#cnuevo").autocomplete({
                            minLength: 2,
                            source: function(request, response) {
                                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#cnuevo").val(), {
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
                                $('#cnuevo').val(ui.item.label); 
                                $('#direccionc').val(ui.item.domicilio);
                                $('#personanombrec').val(ui.item.nombre);
                                $('#cnuevoid').val(ui.item.id);
                                return false;
                             },
                            change: function( event, ui ) {
                                $('#cnuevo').val(ui.item? ui.item.label : '');
                                $( "#direccionc" ).val( ui.item? ui.item.domicilio : '' );
                                $( "#personanombrec" ).val( ui.item? ui.item.nombre : '' );
                                $( "#cnuevoid" ).val( ui.item? ui.item.id : '' );
                            }
                        });
						
					<?}?>
						// Datos del comodatario anterior
						$("#canterior").autocomplete({
                            minLength: 2,
                            source: function(request, response) {
                                $.getJSON("../ajax/global_getpersonas.php?busqueda="+$("#canterior").val(), {
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
                                $('#canterior').val(ui.item.label); 
                                $('#direccioncanterior').val(ui.item.domicilio);
                                $('#personanombrecanterior').val(ui.item.nombre);
                                $('#canteriorid').val(ui.item.id);
                                return false;
                             },
                            change: function( event, ui ) {
                                $('#canterior').val(ui.item? ui.item.label : '');
                                $( "#direccioncanterior" ).val( ui.item? ui.item.domicilio : '' );
                                $( "#personanombrecanterior" ).val( ui.item? ui.item.nombre : '' );
                                $( "#canteriorid" ).val( ui.item? ui.item.id : '' );
                            }
                        });
               
                    <? if ($row == 5){?>
                        //Get Giro
                        var items1="";
                        $.getJSON("../ajax/global_getgiro.php",function(data){
                            items1+="<option value='' disabled selected>Giro</option>";
                            $.each(data,function(index,item){
                                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                            });
                            $("#giroid").html(items1); 
                        });
                    <?}?>
                    <? if ($row == 6){?>
                        //Get Tipo licencia
						var items11="";
						$.getJSON("../ajax/global_gettipolicencia.php",function(data){
                            items11+="<option value='' disabled selected>Tipo Licencia</option>";
                            $.each(data,function(index,item){
                                items11+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                            });
                            $("#tipolicenciaid").html(items11); 
                        });
	
                    <?}?>
                <?}?>

                $(".altarfc").on("click",function(){
            
                    let contenedor = document.getElementById("prueba");
                                    contenedor.innerHTML = '';
                                    var html =  '<form id="MiFormularioRFC" name="MiFormularioRFC">'+
                                                    '<input type="text" id="rfctext" name="rfctext" class="form-control" placeholder="RFC *" maxlength="13" autocomplete="off">'+
                                                    '<input type="text" id="nombretext" name="nombretext" class="form-control" placeholder="Razón Social *" maxlength="250" autocomplete="off">'+        
                                                    '<input type="text" id="curptext" name="curptext" class="form-control" placeholder="CURP" maxlength="18" autocomplete="off">'+
                                                    '<input type="text" id="direcciontext" name="direcciontext" class="form-control" placeholder="Dirección (calle)*" maxlength="250" autocomplete="off">'+											
                                                    '<input type="text" id="direcciontextnum" name="direcciontextnum" class="form-control" placeholder="Dirección (número ext)*" maxlength="250" autocomplete="off">'+
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
                                                    '<input type="text" id="correotext" name="correotext" class="form-control" placeholder="Correo *" maxlength="250">'+
                                                    '<br><input type="button" id="guardarrfc" class="btn btn-primary btn-send-message" value="Guardar RFC" autocomplete="off">'+
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
                    if ($("#licenciaid").val() == ''){
                        alert ("Licencia es un campo obligatorio");
                        banderaguarda = 0;
                        $("#licencia").focus();
                    }
                    <? foreach ($cambios as $row){?>
                        <? if ($row == 1){?>
                            //Validar formulario cambio domicilio
                            else if ($("#domiciliolic").val() == ''){
                                alert ("Domicilio es un campo obligatorio");
                                $("#domiciliolic").focus();
                                banderaguarda = 0;
							}else if ($("#domiciliolicnumext").val() == ''){
                                alert ("Número exterior del domicilio es un campo obligatorio");
                                $("#domiciliolicnumext").focus();
                                banderaguarda = 0;
                            }else if ($("#coloniaid").val() == '' || $("#coloniaid").val() == null){
                                alert ("Colonia es un campo obligatorio");
                                $("#coloniaid").focus();
                                banderaguarda = 0;
                            }else if ($("#entrecalle").val() == '' || $("#entrecalle").val() == null){
                                alert ("Calle es un campo obligatorio");
                                $("#entrecalle").focus();
                                banderaguarda = 0;
                            }else if ($("#yentrecalle").val() == '' || $("#yentrecalle").val() == null){
                                alert ("Calle es un campo obligatorio");
                                $("#yentrecalle").focus();
                                banderaguarda = 0;
                            }else if ($("#latitud").val() == ''){
                                alert ("Latitud es un campo obligatorio selecciona en el mapa la ubicación.");
                                $("#latitud").focus();
                                banderaguarda = 0;
                            }else if ($("#longitud").val() == ''){
                                alert ("Longitud es un campo obligatorio selecciona en el mapa la ubicación.");
                                $("#longitud").focus();
                                banderaguarda = 0;
                            }
							else if ($("#panterior").val() == '') {
								alert ("Propietario es un campo obligatorio");
								$("#panterior").focus();
								banderaguarda = 0;
							}
							else if ($("#canterior").val() == '') {
								alert ("Comodatario es un campo obligatorio");
								$("#canterior").focus();
								banderaguarda = 0;
							}
                        <?}?>
                        <? if ($row == 2){?>
                            //Validar formulario cambio propietario
                            else if ($("#pnuevo").val() == ''){
                                alert ("Propietario es un campo obligatorio");
                                $("#pnuevo").focus();
                                banderaguarda = 0;
                            }
							else if ($("#panterior").val() == '') {
								alert ("Propietario anterior es un campo obligatorio");
								$("#panterior").focus();
								banderaguarda = 0;
							}
							// else if ($("#canterior").val() == '') {
							// 	alert ("Comodatario es un campo obligatorio");
							// 	$("#canterior").focus();
							// 	banderaguarda = 0;
							// }
                        <?}?>
                        <? if ($row == 3){?>
                            //Validar formulario cambio comodatario
                            else if ($("#cnuevo").val() == ''){
                                alert ("Comodatario es un campo obligatorio");
                                $("#cnuevo").focus();
                                banderaguarda = 0;
                            }
							else if ($("#canterior").val() == '') {
								alert ("Comodatario anterior es un campo obligatorio");
								$("#canterior").focus();
								banderaguarda = 0;
							}
							else if ($("#panterior").val() == '') {
								alert ("Propietario es un campo obligatorio");
								$("#panterior").focus();
								banderaguarda = 0;
							}
                        <?}?>
                        <? if ($row == 4){?>
                            //Validar formulario cambio nombre generico
                            if ($("#nombregnuevo").val() == ''){
                                alert ("Nombre genérico es un campo obligatorio");
                                $("#nombregnuevo").focus();
                                banderaguarda = 0;
                            }
							else if ($("#panterior").val() == '') {
								alert ("Propietario es un campo obligatorio");
								$("#panterior").focus();
								banderaguarda = 0;
							}
							else if ($("#canterior").val() == '') {
								alert ("Comodatario es un campo obligatorio");
								$("#canterior").focus();
								banderaguarda = 0;
							}
                        <?}?>
                        <? if ($row == 5){?>
                            //Validar formulario cambio giro
                            if ($('#giroid').find('option:selected').attr('disabled')) {
                                alert ("Giro es un campo obligatorio");
                                $("#giroid").focus();
                                banderaguarda = 0;
                            }
							else if ($("#panterior").val() == '') {
								alert ("Propietario es un campo obligatorio");
								$("#panterior").focus();
								banderaguarda = 0;
							}
							else if ($("#canterior").val() == '') {
								alert ("Comodatario es un campo obligatorio");
								$("#canterior").focus();
								banderaguarda = 0;
							}
                        <?}?>
                        <? if ($row == 6){?>
                            //Validar formulario cambio giro
                            if ($('#tipolicenciaid').find('option:selected').attr('disabled')) {
                                alert ("Tipo Licencia es un campo obligatorio");
                                $("#tipolicenciaid").focus();
                                banderaguarda = 0;
                            }
							else if ($("#panterior").val() == '') {
								alert ("Propietario es un campo obligatorio");
								$("#panterior").focus();
								banderaguarda = 0;
							}
							else if ($("#canterior").val() == '') {
								alert ("Comodatario es un campo obligatorio");
								$("#canterior").focus();
								banderaguarda = 0;
							}
                        <?}?>
                    <?}?>
                    
                    if (banderaguarda == 1){
                        var form_data = new FormData(document.getElementById("MiFormulario"));
						const urlParams = new URLSearchParams(window.location.search);
						const tramiteid = urlParams.get('tramiteid');
						if(tramiteid != null) {
							form_data.append('tramiteid', tramiteid);
						}
						form_data.append('licencia', $("#licencia").val());
                        $.ajax({
                            url: '../ajax/global_guardatramitecambios.php',
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
                                    alert("Error: aqui tambine" + errorThrown); 
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
            
        </script>
        
		<script>
           
			
            function geocodeAddress(geocoder, resultsMap) {
                var marker;
                var address = document.getElementById('domiciliolic').value;
                var colonia = $( "#coloniaid option:selected" ).text();
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
                    $("#coloniaid").val("");
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
                if ($("#coloniaid").val() == ""){
                    $("#map").css('visibility', 'hidden');
                }else{
                    $("#map").css('visibility', 'visible');
                }
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
                <?
                if (isset($_GET['folio'])){
                    $folio = $_GET['folio'];
                    $hora = $_GET['hora'];
                }else{
                    $folio = "";
                    $hora = "";
                }
                ?>
                
                <form id="MiFormulario" name="MiFormulario">
                    <div class="form-group col-md-12">
                        <label for="licencia"># Licencia</label>
                        <input id="licencia" name="licencia" type="text" class="form-control" placeholder="ALCC0001 o ALCA0001" autocomplete="off">
                        <small id="licenciahelp" class="form-text text-muted">ALCC o ALCA y 4 dígitos, selecciona la licencia</small>
                        <input id="licenciaid" name="licenciaid" type="hidden">
                        <input id="subtramites" name="subtramites" type="hidden" value="<?=$subtramites?>">
                    </div>
                    <? foreach ($cambios as $row){?>
                        <? if ($row == 1){?>
                            <!-- CAMBIO DE DOMICILIO -->
                            <br>&nbsp;<br>        
                            <h1>Cambio de Domicilio</h1>
                            <br><h4>Ubicación Fiscal del nuevo domicilio</h4>
                            <table>
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
                                            <input id="municipio" name="municipio" type="text" class="form-control" placeholder="Municipio *" value="SALTILLO" readonly>
                                            <input id="municipioid" name="municipioid" type="hidden" value="66">
                                        </div>
										<div class="form-group col-md-12">
                                            <input id="codigopostal" name="codigopostal" type="text" class="form-control" placeholder="Código Postal *" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <select id="coloniaid" name="coloniaid" class="form-control">
											</select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input id="entrecalle" name="entrecalle" type="text" class="form-control" placeholder="Entre Calle" autocomplete="off">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input id="yentrecalle" name="yentrecalle" type="text" class="form-control" placeholder="Y Calle" autocomplete="off">
                                        </div>
										<div class="form-group col-md-12">
											<input type="button" id="btnubicardireccion" class="btn btn-primary btn-send-message" value="Ubicar en el mapa">
										</div>
										<div class="form-group col-md-12" style="text-align: justify">
											<span style="font-size: 20px;">Después de haber llenado todos los campos anteriores, haz click en "Ubicar en el mapa" y después haz click en el mapa en el punto donde se ubicará el establecimiento y así poder llenar el campo de latitud y longitud.
											<br><span style="color: red;">*Nota:</span> En caso de que Google Maps no localice correctamente la ubicación, arrastrar el mapa con el mouse hasta localizar el punto del establecimiento. Puedes hacer click en el ícono de + o de - para hacer zoom al mapa.</span>
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
                    
                        <?}?>
                        <? if ($row == 2){?>
                            <!-- CAMBIO DE PROPIETARIO -->
                            <br>&nbsp;<br>        
                            <h1>Cambio de Propietario</h1>
                            <div class="form-row" align="right">
                                <div class="form-group col-md-12">
                                    <a  class="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentras el RFC del propietario (nuevo y/o anterior) ó faltan datos ó están incorrectos, dalo de alta aquí</a>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="pnuevo">Propietario Nuevo</label>
                                <input id="pnuevo" name="pnuevo" type="text" class="form-control" maxlength="13" placeholder="RFC *" autocomplete="off" disabled>
                                <input id="pnuevoid" name="pnuevoid" type="hidden">
                            </div>
                            <div class="form-group col-md-12">
                                <input id="personanombre" name="personanombre" type="text" class="form-control" placeholder="Nombre" readonly maxlength="250" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                                <input id="direccion" name="direccion" type="text" class="form-control" placeholder="Domicilio" readonly maxlength="250" autocomplete="off">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="panterior">Propietario Anterior</label>
                                <input id="panterior" name="panterior" type="text" class="form-control" placeholder="RFC *" autocomplete="off" required>
                                <input id="panteriorid" name="panteriorid" type="hidden">
                            </div>
							<div class="form-group col-md-12">
                                <input id="personanombrepanterior" name="personanombrepanterior" type="text" class="form-control" placeholder="Nombre" readonly maxlength="250">
                            </div>
                            <div class="form-group col-md-12">
                                <input id="direccionpanterior" name="direccionpanterior" type="text" class="form-control" placeholder="Domicilio" readonly maxlength="250">
                            </div>
                        <?}?>
                        <? if ($row == 3){?>
                            <!-- CAMBIO DE COMODATARIO -->
                            <br>&nbsp;<br>        
                            <h1>Cambio de Comodatario</h1>
                            <div class="form-row" align="right">
                                <div class="form-group col-md-12">
                                    <a class="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentras el RFC del comodatario (nuevo y/o anterior) ó faltan datos ó están incorrectos, dalo de alta aquí</a>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="cnuevo">Comodatario Nuevo</label>
                                <input id="cnuevo" name="cnuevo" type="text" class="form-control" maxlength="13" placeholder="RFC *" autocomplete="off" required>
                                <input id="cnuevoid" name="cnuevoid" type="hidden">
                            </div>
                            <div class="form-group col-md-12">
                                <input id="personanombrec" name="personanombrec" type="text" class="form-control" placeholder="Nombre" maxlength="250">
                            </div>
                            <div class="form-group col-md-12">
                                <input id="direccionc" name="direccionc" type="text" class="form-control" placeholder="Domicilio" maxlength="250">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="canterior">Comodatario Anterior</label>
                                <input id="canterior" name="canterior" type="text" class="form-control" placeholder="RFC *" autocomplete="off" required>
                                <input id="canteriorid" name="canteriorid" type="hidden">
                            </div>
							<div class="form-group col-md-12">
                                <input id="personanombrecanterior" name="personanombrecanterior" type="text" class="form-control" placeholder="Nombre" maxlength="250">
                            </div>
                            <div class="form-group col-md-12">
                                <input id="direccioncanterior" name="direccioncanterior" type="text" class="form-control" placeholder="Domicilio" maxlength="250">
                            </div>
                        <?}?>
                        <? if ($row == 4){?>
                            <!-- CAMBIO DE NOMBRE GENERICO -->
                            <br>&nbsp;<br>        
                            <h1>Cambio de Nombre Genérico</h1>
                            <div class="form-group">
                                <label for="nombregnuevo">Nombre Genérico Nuevo</label>
                                <input id="nombregnuevo" name="nombregnuevo" type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label for="nombreganteriordis">Nombre Genérico Anterior</label>
                                <input id="nombreganteriordis" name="nombreganteriordis" type="text" class="form-control" disabled>
                                <input id="nombreganterior" name="nombreganterior" type="hidden" class="form-control">
                            </div>
                        <?}?>
                        <? if ($row == 5){?>
                            <!-- CAMBIO DE GIRO -->
                            <br>&nbsp;<br>        
                            <h1>Cambio de Giro</h1>
                            <div class="form-group col-md-12">
                                <label for="giro">Giro Nuevo</label>
                                <select id="giroid" name="giroid" class="form-control">
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="giro">Giro Anterior</label>
                                <input id="giroanterior" name="giroanterior" type="text" class="form-control" disabled>
                                <input id="giroanteriorid" name="giroanteriorid" type="hidden">
                            </div>
                        <?}?>
                        <? if ($row == 6){?>
                            <!-- CAMBIO DE TIPO DE LICENCIA -->
                            <br>&nbsp;<br>        
                            <h1>Cambio de Tipo</h1>
                            <div class="form-group col-md-12">
                                <label for="tipolicenciaid">Tipo Licencia Nuevo</label>
                                <select id="tipolicenciaid" name="tipolicenciaid" class="form-control">
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="tipolicenciaanterior">Tipo Licencia Anterior</label>
                                <input id="tipolicenciaanterior" name="tipolicenciaanterior" type="text" class="form-control" disabled>
                                <input id="tipolicenciaidanterior" name="tipolicenciaidanterior" type="hidden">
                            </div>
                        <?}?>
                    <?}?>
						<div id="ver_datos_comodatario_propietario_anterior" style="width: 100%">
						</div>
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
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
	<script language="javascript">
		document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML = '';		
		if(!document.getElementById('canterior')) {
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-row" align="right"><div class="form-group col-md-12"><a  class="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentras el RFC del propietario (nuevo y/o anterior) ó faltan datos ó están incorrectos, dalo de alta aquí</a></div></div>';
							
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-group col-md-12"><label for="canterior">Comodatario</label><input id="canterior" name="canterior" type="text" class="form-control" placeholder="RFC *" data-required><input id="canteriorid" name="canteriorid" type="hidden"></div>';
		
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-group col-md-12"><input id="personanombrecanterior" name="personanombrecanterior" type="text" class="form-control" placeholder="Nombre" maxlength="250"></div>';
		
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-group col-md-12"><input id="direccioncanterior" name="direccioncanterior" type="text" class="form-control" placeholder="Domicilio" maxlength="250"></div>';
		}

		if(!document.getElementById('panterior')) {
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-row" align="right"><div class="form-group col-md-12"><a  class="altarfc" style="cursor:pointer" data-toggle="modal" data-target="#exampleModal">Si no encuentras el RFC del propietario (nuevo y/o anterior) ó faltan datos ó están incorrectos, dalo de alta aquí</a></div></div>';
			
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-group col-md-12"><label for="panterior">Propietario</label><input id="panterior" name="panterior" type="text" class="form-control" placeholder="RFC *" required><input id="panteriorid" name="panteriorid" type="hidden"></div>';
			
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-group col-md-12"><input id="personanombrepanterior" name="personanombrepanterior" type="text" class="form-control" placeholder="Nombre" readonly maxlength="250"></div>';
			
			document.getElementById('ver_datos_comodatario_propietario_anterior').innerHTML += '<div class="form-group col-md-12"><input id="direccionpanterior" name="direccionpanterior" type="text" class="form-control" placeholder="Domicilio" readonly maxlength="250"></div>';
		}
		
		setTimeout(function() {
			const urlParams = new URLSearchParams(window.location.search);
			const tramiteid = urlParams.get('tramiteid');
			if(tramiteid != null) {
				var solicitud_cambios = get_datos_cambios_licencias(tramiteid);
				mostrar_cambios_licencia(solicitud_cambios);
			}
		},2000);
		
	</script>
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
$asunto = "Solicitud de cambio creada";
$cuerpo = "
<img src='".$GLOBALS['vu_global_site']."images/logo2.png' width='200px'>
<br><br>
Solicitud creada exitosamente.

Si deseas consultar el estatus de tu solicitud, accede a nuestro portal en la siguiente dirección <a href='".$GLOBALS['vu_global_site']."gui/global_loginext.php'>UAA</a> con tu correo y el RFC que utilizaste para accesar.
";
?>
<input type="hidden" id="asunto" value="<?=$asunto?>">
<input type="hidden" id="cuerpo" value="<?=$cuerpo?>">
