<?
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todos los trámites
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('2007',$usersessionpermisos);
?>
<?
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
?>
<style>
    .modal-open .ui-datepicker{z-index: 2000!important}
	body {
		font-size: 20px;
	}
</style>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
        $("i").on("click",function(){
  					var id = this.id;
				  	var arr = id.split("|");
				    switch(arr[0]) {
                        case 'verinfolicencia':
                            var page = "../includes/global_verinfolicencia.php?id="+arr[1];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 900,
									   title: "Información Licencia"
							   });
							   $dialog.dialog('open');
                            break;
                        case 'verinfopermiso':
                            var page = "../includes/global_verinfolicenciaprovisional.php?id="+arr[1];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 900,
									   title: "Información Permiso"
							   });
							   $dialog.dialog('open');
                            break;
						case'asigna_folio':
							var page = "../includes/global_folio.php?tramitevuid="+arr[1]+"&tabla="+arr[2];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 900,
									   title: "Folio del trámite"
							   });
							   $dialog.dialog('open');
                            break;
						case'cancelar':
							var page = "../includes/global_cancelar_tramite.php?tramitevuid="+arr[1]+"&usuarioid="+$("#usuarioid").val();
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 900,
									   title: "Motivo de cancelación"
							   });
							   $dialog.dialog('open');
                            break;
						case'verinfo':
				           var page = "../includes/global_vertramiteinfo.php?tramitevuid="+arr[1]+"&tabla="+arr[2]+"&tablacampo="+arr[3];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 900,
									   title: "Información Trámite"
							   });
							   $dialog.dialog('open');
							   break;
						case'comentario':	
							var page = "../includes/global_comentarios.php?tramitevuid="+arr[1];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 700,
									   title: "Comentarios Trámite"
							   });
							   $dialog.dialog('open');
							   break;
						case 'info_pagos':
							var info_pagos = getinfo_pagos(arr[1]);
							var monto_primer_pago = info_pagos[0].monto_primer_pago ? info_pagos[0].monto_primer_pago : '';
							var fecha_primer_pago = info_pagos[0].fecha_primer_pago ? info_pagos[0].fecha_primer_pago : '';
							var monto_segundo_pago = info_pagos[0].monto_segundo_pago ? info_pagos[0].monto_segundo_pago : '';
							var fecha_segundo_pago = info_pagos[0].fecha_segundo_pago ? info_pagos[0].fecha_segundo_pago : ''; 
							let contenedor4 = document.getElementById("prueba");
                            contenedor4.innerHTML = '';
                            var html =  '<form id="form" name="form">'+
                            '<h2>Pagos</h2>'+
                            '<h3>Datos del primer pago</h3>'+
                            '<input type="date" id="fechaprimerpago" name="fechaprimerpago" class="form-control" placeholder="Fecha de Pago" value="'+fecha_primer_pago+'">'+
                            '<input type="text" id="montoprimerpago" name="montoprimerpago" class="form-control" placeholder="Monto del primer pago" value="'+monto_primer_pago+'">'+
							'<br><h3>Datos del segundo pago</h3>'+
							'<input type="date" id="fechasegundopago" name="fechasegundopago" class="form-control" placeholder="Fecha de Pago" value="'+fecha_segundo_pago+'">'+
							'<input type="text" id="montosegundopago" name="montosegundopago" class="form-control" placeholder="Monto del segundo pago" value="'+monto_segundo_pago+'">'+
							'<input type="hidden" id="tramitevuid" name="tramitevuid" value="'+arr[1]+'">'+
                            '<input type="hidden" id="foliovu" name="foliovu" value="'+arr[2]+'">'+
							'<br><input type="button" id="guardarpagos" class="btn btn-primary btn-send-message" value="Guardar pagos">'+
							'</form>';                                 
                            contenedor4.innerHTML = html;
						  
							$("#guardarpagos").on("click",function(){
								var primer_pago = document.getElementById('montoprimerpago').value.trim();
								var date_primer_pago = document.getElementById('fechaprimerpago').value.trim();
								var segundo_pago = document.getElementById('montosegundopago').value.trim();
								var date_segundo_pago = document.getElementById('fechasegundopago').value.trim();
                                $.ajax({
                                    url: '../ajax/global_guardarinfopagos.php',
                                    dataType: "text",
                                    type: 'post',
                                    data: {
                                        "tramitevuid" : arr[1],
										"fechaprimerpago": date_primer_pago,
                                        "montoprimerpago" : primer_pago,
                                        "fechasegundopago" : date_segundo_pago,
                                        "montosegundopago" : segundo_pago
                                    },
                                    beforeSend: function() {
                                        $("#loading").show();	
                                    },
                                    success: function(data) { 
										var data = data.trim();
                                        if (data == ""){
                                            alert ("Pagos actualizados correctamente");
                                        }else{
                                            alert ("Error: "+data);
                                        }
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
                            });         
                            break;
                        case 'historial':
                            var page = "../includes/global_historial.php?tramitevuid="+arr[1];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 1000,
									   title: "Historial Trámite"
							   });
							   $dialog.dialog('open');
							   break;
                        case'upload':	
							var page = "../includes/global_uploadfiles.php?tramitevuid="+arr[1];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 700,
									   title: "Upload de Documentos"
							   });
							   $dialog.dialog('open');
							   break;
                        case'verflujo':	
							var page = "../includes/global_verflujo.php?tramitevuid="+arr[1];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 525,
									   width: 700,
									   title: "Flujo trámite"
							   });
							   $dialog.dialog('open');
							   break;
                        case 'cita':
                            var page = "../includes/global_citaadd.php?tramitevuid="+arr[1];
							var $dialog = $('<div></div>')
								.html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
								.css({overflow:"hidden"})	
								.dialog({
									   autoOpen: false,
									   modal: true,
									   show: { effect: "fold", duration: 1000 },
    								   hide: {effect: "fold", duration: 1000 },
									   height: 700,
									   width: 1000,
									   title: "Historial Trámite"
							   });
							   $dialog.dialog('open');
							   break;
                        case 'crearlicencia':
                            let contenedor = document.getElementById("prueba");
                            contenedor.innerHTML = '';
                            var html =  '<form id="form" name="form">'+
                                            'Se creará Licencia con la información de la solicitud <b> '+arr[2]+'</b><br><br>'+
                                            '<h3>Datos Generales</h3>'+
                                            '<select id="tipolicencia" name="tipolicencia" class="form-control"></select>'+
                                            '<input type="text" id="numlicencia" name="numlicencia" class="form-control" placeholder="Número de Licencia" maxlength="45" onkeypress="return enteros(event)" onpaste="return false;">'+
                                            '<input type="date" id="fechaalta" name="fechaalta" class="form-control" placeholder="Fecha de Alta">'+
											'<input type="hidden" id="tramitevuid" name="tramitevuid" value="'+arr[1]+'">'+
                                            '<input type="hidden" id="foliovu" name="foliovu" value="'+arr[2]+'">'+
                                            '<br><input type="button" id="crear" class="btn btn-primary btn-send-message" value="Crear Licencia">'+
										'</form>';
                            contenedor.innerHTML = html;
                            
                            //Get Tipolicencia
                            var items11="";
                            $.getJSON("../ajax/global_gettipolicencia.php",function(data){
                                items11+="<option value='' disabled selected>Tipo Licencia *</option>";
                                $.each(data,function(index,item){
                                    items11+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                                });
                                $("#tipolicencia").html(items11); 
                            });
                            
                            $("#fechapago").datepicker({
                               todayBtn: "linked",
                               language: "es",
                               autoclose: true,
                               todayHighlight: true,
                               dateFormat: 'yy-mm-dd' 
                            });
                            
                            $("#fechaalta").datepicker({
                               todayBtn: "linked",
                               language: "es",
                               autoclose: true,
                               todayHighlight: true,
                               dateFormat: 'yy-mm-dd' 
                            });
                            
                            $("#crear").on("click",function(){
                                if ($('#tipolicencia').find('option:selected').attr('disabled')) {
                                    alert ("Tipo de Licencia es un campo obligatorio");
                                    $("#tipolicencia").focus();
                                }else if ($("#numlicencia").val() == ''){
                                    alert ("Número de Licencia es un campo obligatorio");
                                    $("#numlicencia").focus();
                                }else if ($("#fechaalta").val() == ''){
                                    alert ("Fecha alta es un campo obligatorio");
                                    $("#fechaalta").focus();
                                }
								else{
                                    $.ajax({
                                        url: '../ajax/global_crearlicenciabysolicitud.php',
                                        dataType: "text",
                                        type: 'post',
                                        data: {
                                            "tipolicencia" : $("#tipolicencia").val(),
                                            "numlicencia" : $("#numlicencia").val(),
                                            "fechaalta" : $("#fechaalta").val(),
                                            "tramitevuid" : arr[1]
                                        },
                                        beforeSend: function() {
                                            $("#loading").show();	
                                        },
                                        success: function(data) { 
                                            if (data == ""){
                                                alert ("Licencia creada correctamente");
                                            }else{
                                                alert ("Error: "+data);
                                            }
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
                            break;
                        case 'crearpermiso':
                            let contenedor2 = document.getElementById("prueba");
                            contenedor2.innerHTML = '';
                            var html =  '<form id="form" name="form">'+
                                            'Se creará Permiso con la información de la solicitud <b> '+arr[2]+'</b><br><br>'+
                                            '<h3>Datos Generales</h3>'+
                                            '<input type="text" id="numpermiso" name="numpermiso" class="form-control" placeholder="Número de Permiso" maxlength="45" onkeypress="return enteros(event)" onpaste="return false;">'+
                                            '<input type="date" id="fechaalta" name="fechaalta" class="form-control" placeholder="Fecha de Alta">'+
                                            '<input type="hidden" id="tramitevuid" name="tramitevuid" value="'+arr[1]+'">'+
                                            '<input type="hidden" id="foliovu" name="foliovu" value="'+arr[2]+'">'+
                                            '<br><input type="button" id="crear" class="btn btn-primary btn-send-message" value="Crear Permiso">'+
                                        '</form>'
                            contenedor2.innerHTML = html;
                            
                            $("#fechapago").datepicker({
                               todayBtn: "linked",
                               language: "es",
                               autoclose: true,
                               todayHighlight: true,
                               dateFormat: 'yy-mm-dd' 
                            });
                            
                            $("#fechaalta").datepicker({
                               todayBtn: "linked",
                               language: "es",
                               autoclose: true,
                               todayHighlight: true,
                               dateFormat: 'yy-mm-dd' 
                            });
                            
                            $("#crear").on("click",function(){
                                if ($("#numpermiso").val() == ''){
                                    alert ("Número de Permiso es un campo obligatorio");
                                    $("#numpermiso").focus();
                                }else if ($("#fechaalta").val() == ''){
                                    alert ("Fecha alta es un campo obligatorio");
                                    $("#fechaalta").focus();
                                }else{
                                    $.ajax({
                                        url: '../ajax/global_crearpermisobysolicitud.php',
                                        dataType: "text",
                                        type: 'post',
                                        data: {
                                            "numpermiso" : $("#numpermiso").val(),
                                            "fechaalta" : $("#fechaalta").val(),
                                            "tramitevuid" : arr[1]                                        
                                        },
                                        beforeSend: function() {
                                            $("#loading").show();	
                                        },
                                        success: function(data) { 
                                            if (data == ""){
                                                alert ("Permiso creado con éxito");
                                            }else{
                                                alert ("Error: "+data);
                                            }
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
                            break;
                        case 'updatelicencia':
							var info = get_info_tramitecambio(arr[1]);
                            let contenedor3 = document.getElementById("prueba");
                            contenedor3.innerHTML = '';
                            var html =  '<form id="form" name="form">'+
                            'Se actualizará la información de la licencia con la información de la solicitud <b> '+arr[2]+'</b><br><br>';
							if(info[0].tipolicenciaid != '' && info[0].tipolicenciaid != null && info[0].folio_licencia_anterior != '' && info[0].folio_licencia_anterior != null) {
								html += 'Tipo de licencia anterior<br><input type="text" id="tipolicenciaanterior_text" name="tipolicenciaanterior_text" class="form-control" value="'+info[0].tipolicenciaanterior+'" readonly>';
								html += '<input type="text" id="folioanterior" name="folioanterior" class="form-control" value="'+info[0].folio_licencia_anterior+'" readonly>';
								html += 'Tipo de licencia nuevo<br><input type="text" id="tipolicencia_text" name="tipolicencia_text" class="form-control" value="'+info[0].tipolicencia_nombre_nuevo+'" readonly>';
								html += '<input type="text" id="folionuevo" name="folionuevo" class="form-control" value="" placeholder="Folio nuevo de la licencia Ej. 0001" maxlength="4">';
							}
                            html += '<input type="hidden" id="tramitevuid" name="tramitevuid" value="'+arr[1]+'">'+
                            '<input type="hidden" id="foliovu" name="foliovu" value="'+arr[2]+'">'+
                            '<br><input type="button" id="update" class="btn btn-primary btn-send-message" value="Actualizar Licencia">'+
                                        '</form>'
                            contenedor3.innerHTML = html;
                            
                            $("#fechapago").datepicker({
                               todayBtn: "linked",
                               language: "es",
                               autoclose: true,
                               todayHighlight: true,
                               dateFormat: 'yy-mm-dd' 
                            });
                            
                            $("#update").on("click",function(){
								if(document.getElementById('folionuevo') && document.getElementById('folionuevo').value.trim() == '') {
									alert('Porfavor, captura el folio nuevo de la licencia');
								}
								else {
									if(document.getElementById('folionuevo')) {
										var folionuevo = document.getElementById('folionuevo').value.trim();
									}
									else {
										var folionuevo = '';
									}
                                    $.ajax({
                                        url: '../ajax/global_updatelicenciabysolicitud.php',
                                        dataType: "text",
                                        type: 'post',
                                        data: {
                                            "tramitevuid" : arr[1],
											"folionuevo" : folionuevo
                                        },
                                        beforeSend: function() {
                                            $("#loading").show();	
                                        },
                                        success: function(data) { 
                                            if (data == ""){
                                                alert ("Cambios realizados con éxito");
                                            }else{
                                                alert ("Error: "+data);
                                            }
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
                               /* }*/
                            });           
                            break;
                        case 'croquis':
                            window.open("../gdocs/global_croquissolicitud.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(arr[2]));
                            break;
                        case 'pdfsolicitudcambio':
                            window.open("../gdocs/global_solicituddecambio.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(arr[2]));
                            break;
                        case 'pdfsolicitudalta':
                            window.open("../gdocs/global_solicitudaltalicencia.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(arr[2]));
                            break;
                        case 'pdfsolicitudcambiotodos':
                            window.open("../gdocs/global_solicituddecambiotodos.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(9));
                            break;
                        case 'pdfsolicitudpermiso':
                            window.open("../gdocs/global_solicitudaltapermiso.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(7));
                            break;
					  	default:
					}
				});
                
        $("#btnbsq").on("click",function(){
            //Arma json y lo serealiza
            var busquedaaux = {
                    "bsqvuid": $("#bsqvuid").val(),
                    "bsqfolio": $("#bsqfolio").val(),
                    "bsqtipotramite": $("#bsqtipotramite").val(),
                    "bsqstatus": $("#bsqstatus").val(),
                    "bsqcita": $("#bsqcita").val(),
                    "bsqrequerimientos": $("#bsqrequerimientos").val(),
					"bsflujo": $("#bsflujo").val(),
                    "bsqname":$("#bsqname").val()
            };
            busquedaaux = btoa(JSON.stringify(busquedaaux));
            document.location.href = window.location.href.split('?')[0]+'?busqueda='+busquedaaux;
            // window.open(window.location.href.split('?')[0]+'?busqueda='+busquedaaux);
        });

        $("#btnlimpiar").on("click",function(){
            window.location = window.location.href.split("?")[0];
        });
        
        <? if ($busqueda != ''){?>
            var busquedaarray = JSON.parse(atob('<?=$busqueda?>'));
            $("#bsqvuid").val(busquedaarray.bsqvuid);
            $("#bsqfolio").val(busquedaarray.bsqfolio);
            $("#bsqtipotramite").val(busquedaarray.bsqtipotramite);
            $("#bsqstatus").val(busquedaarray.bsqstatus);
            $("#bsqcita").val(busquedaarray.bsqcita);
            $("#bsqrequerimientos").val(busquedaarray.bsqrequerimientos);
			$("#bsflujo").val(busquedaarray.bsflujo);
        <?}?>
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
	
	// Función para traer información del cambio de trámite
	function get_info_tramitecambio(tramitevu_id) {
		var ajax = new XMLHttpRequest();
		var method = "GET";
		var url = "../ajax/global_getinfotramitecambio.php?tramitevu_id="+tramitevu_id;
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
	
	// Función para traer la información del trámite
	function getinfo_pagos(tramitevu_id) {
		var ajax = new XMLHttpRequest();
		var method = "GET";
		var url = "../ajax/global_getinfo_pagos.php?tramitevu_id="+tramitevu_id;
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
    
</script>
<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                
                <!-- FILTROS BÚSQUEDA -->
                <!--<h3>Filtros de Búsqueda</h3>-->
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <input type="text" id="bsqvuid" name="bsqvuid" class="form-control" placeholder="Código barras">
                    </div>
                    <div class="form-group col-md-3" style="display:none;">
                        <input type="text" id="bsqfolio" name="bsqfolio" class="form-control" placeholder="Folio">
                    </div>
                    <div class="form-group col-md-4">
                        <input type="text" id="bsqname" name="bsqname" class="form-control" placeholder="Nombre génerico">
                    </div>
                    <div class="form-group col-md-3">
                        <select id="bsqtipotramite" name="bsqtipotramite" class="form-control">
                            <option value="">Tipo Trámite</option>
                            <option value="1">Solicitud de Licencia</option>
                            <option value="7">Solicitud de Permiso Especial</option>
                            <option value="9">Solicitud de Cambio</option>
                            <option value="8">Solicitud de Refrendo</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <select id="bsqstatus" name="bsqstatus" class="form-control">
                            <option value="" selected>Status</option>
                            <option value="1">Trámite Nuevo</option>
                            <option value="2">Fiscalización</option>
                            <option value="3">Finalizado</option>
                            <option value="4">Cancelado</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select id="bsqcita" name="bsqcita" class="form-control">
                            <option value="">Cita</option>
                            <option value="1">Agendada</option>
                            <option value="2">Pendiente</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <select id="bsqrequerimientos" name="bsqrequerimientos" class="form-control">
                            <option value="">Requerimientos</option>
                            <option value="1">Completado</option>
                            <option value="2">No completado</option>
                        </select>
                    </div>
					<div class="form-group col-md-3" style="display:none;">
                        <select id="bsflujo" name="bsflujo" class="form-control">
                            <option value="">Filtro</option>
                            <option value="1">Trámite Nuevo</option>
                            <option value="3">Aceptado en Alcoholes</option>
                            <option value="4">Enviado a Fiscalización</option>
                            <option value="5">Finalizado</option>
                        </select>
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
                        <?
                        //paginador
                        $connclass  	= new DBmysqli();
                        $conn 			= $connclass->conn;
                        $limit      	= ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 50;
                        $page      		= ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
                        $links      	= ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
                        $morelinks      = ( isset( $_GET['busqueda'] ) ) ? "&busqueda=".$_GET['busqueda'] : "";
                        $getquery = new ventanilla();
                        $query = $getquery->getqueryallV2($busqueda);
                        $Paginator  	= new Paginator($conn, $query);
                        $results    	= $Paginator->getData($limit, $page);
                        ?>
                        <?php echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>
                        <input type="hidden" id="usuarioid" name="usuarioid" value="<?=$usersession[0]['usuarios_id']?>">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Nombre genérico / Cita</th>
                                    <th scope="col">Fecha envío / Tramite / Código barras</th>
                                    <th scope="col">Status / Flujo</th>
                                    <th scope="col">DOCS</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                            if($results <> ''){
                                if(count($results->data) > 0){
                                    foreach ($results->data as $row){
                                        //Si esta completo y esta en status no aplicado se pinta de color amarillo
                                        if ($row['completo'] == 1 and $row['tramitevu_aplicado'] == 0){
                                            $bgcolor = 'style="background-color:#FFFEEA"';
                                        }else{
                                            $bgcolor = '';
                                        }
                                        ?>
                                        <tr <?=$bgcolor?>>
                                            <td>
                                                <b><?=$row['folio']?></b>
                                            </td>
                                            <td>
												<span style="font-size:20px">
												
											<?=$row['permiso_nombre_negocio']?>
											<?=$row['altalicencia_nombre_negocio']?>
											<? if($row['licencia_nombre_negocio'] || $row['cambio_nombre_negocio']) { 
												echo $row['licencia_nombre_negocio'].' <b>/</b> '.$row['cambio_nombre_negocio'];
											}?>
											
												</span><br>
                                                <span style="background-color:#ECFFEA">
                                                    <?=substr($row['tramitevu_cita'],0,-3)?>
                                                </span>
                                            </td>
                                            <td>
                                                <?=$row['tramitevu_fecha_enviado_revision']?><br>
                                                <b><?=$row['tipotramite_nombre']?></b>
												<br><?=$row['tramitevu_folio']?><br>
                                            </td>
                                            <td>
                                                <span style="color:#<?=$row['status_color']?>">
                                                    <?=$row['status_nombre']?>
                                                </span><br>
                                                <b><?=$row['flujodetalle_casillanombre']?></b>
                                            </td>
                                            <td>
                                                <b><?=$row['docsubidos']?> / <?=$row['docstotal']?></b>
                                            </td>
                                            <td>
                                                <!--<i id="verinfo|<?//=$row['tramitevu_id']?>//|<?//=$row['tabla']?>|<?//=$row['tablacampo']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Info" class="icon-eye"></i>-->
												<i id="asigna_folio|<?=$row['tramitevu_id']?>|<?=$row['tabla']?>" style="cursor:pointer; font-size: 1.5em;" title="Asignar folio" class="icon-pencil"></i>
												<i id="info_pagos|<?=$row['tramitevu_id']?>|<?=$row['tabla']?>" style="cursor:pointer; font-size: 1.5em;" title="Pagos" class="icon-puzzle"data-toggle="modal" data-target="#exampleModal"></i>
												<i id="comentario|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Comentarios" class="icon-message"></i>
                                                <i id="historial|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Historial" class="icon-time"></i>
                                                <i id="upload|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Agregar Documentos" class="icon-upload"></i>
                                                <i id="verflujo|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Flujo" class="icon-arrow-right"></i>
                                                <!-- Agendar Cita -->
                                                <? if ($row['tramitevu_cita'] == ''){ ?>
                                                <i id="cita|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Agendar Cita" class="icon-calender"></i>
                                                <?}?>
                                                <!-- Cancelar -->
                                                <? if ($row['tramitevu_statusid'] <> 4){ ?>
                                                    <!--Si es diferente de cancelado muestra el icono para cancelar-->
                                                    <i id="cancelar|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Cancelar" class="icon-cancel"></i>
                                                <?}?>
                                                <!-- Convertir -->
                                                <? if ($row['tramitevu_statusid'] == 3 and $row['tramitevu_aplicado'] == 0){ ?>
                                                    <? 
                                                        switch($row['tramitevu_tipotramiteid']){
                                                            case 1:
                                                                echo '<i id="crearlicencia|'.$row['tramitevu_id'].'|'.$row['folio'].'" style="cursor:pointer; font-size: 1.5em;" title="Crear Licencia" class="icon-location-arrow" data-toggle="modal" data-target="#exampleModal"></i>';
                                                                break;
                                                            case 7:
                                                                echo '<i id="crearpermiso|'.$row['tramitevu_id'].'|'.$row['folio'].'" style="cursor:pointer; font-size: 1.5em;" title="Crear Permiso" class="icon-location-arrow" data-toggle="modal" data-target="#exampleModal"></i>';
                                                                break;
                                                            case 8:
                                                                break;
                                                            case 9:
                                                                echo '<i id="updatelicencia|'.$row['tramitevu_id'].'|'.$row['folio'].'" style="cursor:pointer; font-size: 1.5em;" title="Aplicar cambios" class="icon-location-arrow" data-toggle="modal" data-target="#exampleModal"></i>';
                                                                break;
                                                            default:
                                                                break;
                                                        }
                                                    ?>
                                                <?}?>
                                                <!--<br>-->
                                                <!-- --------------------------------------- -->
                                                <!--FORMATOS -->
                                                <!-- CROQUIS -->
                                                <? if ($row['tramitevu_tipotramiteid'] == 7 or $row['tramitevu_tipotramiteid'] == 1){ ?>
                                                    <!--<i id="croquis|<?//=$row['tramitevu_id']?>|<?//=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Croquis" class="icon-document"></i>-->
                                                <? } ?>
                                                <!-- Formato Cambios individuales -->
                                                <? if ($row['tramitevu_tipotramiteid'] == 6 or $row['tramitevu_tipotramiteid'] == 5 or $row['tramitevu_tipotramiteid'] == 4 or $row['tramitevu_tipotramiteid'] == 3 or $row['tramitevu_tipotramiteid'] == 2){ ?>
                                                    <!--<i id="pdfsolicitudcambio|<?//=$row['tramitevu_id']?>|<?//=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Cambio" class="icon-document"></i>-->
                                                <? } ?>
                                                <!-- Formato Cambio -->
                                                <? if ($row['tramitevu_tipotramiteid'] == 9){ ?>
                                                    <!--<i id="pdfsolicitudcambio|<?//=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Cambio" class="icon-document"></i>-->
                                                    <? if ($row['tramitevu_licenciaid'] <> ''){ ?>
                                                        <i id="verinfolicencia|<?=$row['tramitevu_licenciaid']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Información de Licencia" class="icon-info"></i>
                                                    <? } ?>
                                                <? } ?>
                                                <!-- Formato Solicitud de Licencia -->
                                                <? if ($row['tramitevu_tipotramiteid'] == 1){ ?>
                                                    <!--<i id="pdfsolicitudalta|<?//=$row['tramitevu_id']?>|<?//=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Licencia" class="icon-document"></i>-->
                                                    <? if ($row['tramitevu_licenciaid'] <> ''){ ?>
                                                        <i id="verinfolicencia|<?=$row['tramitevu_licenciaid']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Información de Licencia" class="icon-info"></i>
                                                    <? } ?>
                                                <? } ?>
                                                <!-- Formato Solicitud de permiso especial -->
                                                <? if ($row['tramitevu_tipotramiteid'] == 7){ ?>
                                                    <!--<i id="pdfsolicitudpermiso|<?//=$row['tramitevu_id']?>|<?//=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Licencia" class="icon-document"></i>-->
                                                    <? if ($row['tramitevu_licenciaid'] <> ''){ ?>
                                                        <i id="verinfopermiso|<?=$row['tramitevu_licenciaid']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Información de Permiso" class="icon-info"></i>
                                                    <? } ?>
                                                <? } ?>
                                            </td>
                                        </tr>
                                        <?
                                    }
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                        <br>
        		        <? echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
