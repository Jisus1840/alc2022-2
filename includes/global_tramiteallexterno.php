<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todos los trámites
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesionext.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<style>
    .modal-open .ui-datepicker{z-index: 2000!important}
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
                        case 'upload':
							var page = "../includes/global_uploadfiles.php?tramitevuid="+arr[1]+"&tramitevu_tipotramiteid="+arr[2];
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
									title: "Upload de Documentos",
									close: function (){
										location.reload();
									},
							   });
							   $dialog.dialog('open');
							   break;
						case 'editartramite':
							var tramitevu_id = arr[1];
							var tabla_tramite = arr[2];
							if(tabla_tramite == 'global_tramitealtalicencia') {
								window.location.href = '../gui/global_solicitudlicenciaexterno.php?tramiteid='+tramitevu_id;
							}
							else if(tabla_tramite == 'global_tramitecambio') {
								var infotramite = get_info_tramitecambio(tramitevu_id);
								window.location.href = '../gui/global_solicitudcambios2externo.php?cambios=['+infotramite[0]['tiposubtramiteids']+']&tramiteid='+tramitevu_id;
							}
							else if(tabla_tramite == 'global_tramitealtalicenciaprovisional') {
								window.location.href = '../gui/global_solicitudlicenciaprovisionalexterno.php?tramiteid='+tramitevu_id;
							}
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
                        case'cancelar':
                          if (confirm("Seguro que deseas cancelar el trámite?")){
                                $.ajax({
                                    url: '../ajax/global_cancelartramite.php',
                                    dataType: "text",
                                    type: 'post',
                                    data: {
                                        "usuarioid" : $("#usuarioid").val(),
                                        "tramiteid" : arr[1]
                                    },
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
                            }else{
                                return false;
                            }
                            break;
                        case 'crearlicencia':
                            let contenedor = document.getElementById("prueba");
                            contenedor.innerHTML = '';
                            var html =  '<form id="form" name="form">'+
                                            'Se creará Licencia con la información de la solicitud <b> '+arr[2]+'</b><br><br>'+
                                            '<input type="text" id="numlicencia" name="numlicencia" class="form-control" placeholder="Número de Licencia" maxlength="45">'+
                                            '<input type="text" id="numlicenciaestado" name="numlicenciaestado" class="form-control" placeholder="Número de Licencia Estado" maxlength="45">'+
                                            '<input type="text" id="fechavencimiento" name="fechavencimiento" class="form-control" placeholder="Fecha de Pago" readonly>'+
                                            '<input type="text" id="fechapago" name="fechapago" class="form-control" placeholder="Fecha de Vencimiento de Refrendo" readonly>'+
                                            '<input type="text" id="montopago" name="montopago" class="form-control" placeholder="Monto de Pago">'+
                                            '<input type="hidden" id="tramitevuid" name="tramitevuid" value="'+arr[1]+'">'+
                                            '<input type="hidden" id="foliolic" name="foliolic" value="'+arr[3]+'">'+
                                            '<br><input type="button" id="crear" class="btn btn-primary btn-send-message" value="Crear Licencia">'+
                                        '</form>'
                            contenedor.innerHTML = html;

                            $("#fechapago").datepicker({
                               todayBtn: "linked",
                               language: "es",
                               autoclose: true,
                               todayHighlight: true,
                               dateFormat: 'yy-mm-dd'
                            });

                            $("#fechavencimiento").datepicker({
                               todayBtn: "linked",
                               language: "es",
                               autoclose: true,
                               todayHighlight: true,
                               dateFormat: 'yy-mm-dd'
                            });

                            $("#crear").on("click",function(){
                                if ($("#numlicencia").val() == ''){
                                    alert ("Número de Licencia es un campo obligatorio");
                                    $("#numlicencia").focus();
                                }else{
                                    $.ajax({
                                        url: '../ajax/global_crearlicenciabysolicitud.php',
                                        dataType: "text",
                                        type: 'post',
                                        data: {
                                            "numlicencia" : $("#numlicencia").val(),
                                            "numlicenciaestado" : $("#numlicenciaestado").val(),
                                            "tramitevuid" : arr[1],
                                            "fechavencimiento": $("#fechavencimiento").val()
                                        },
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
                        case 'pdfsolicitudpermiso':
                            window.open("../gdocs/global_solicitudaltapermiso.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(arr[2]));
                            break;
						case 'pdfvecinoscolindantes':
							window.open("../docs/formato_vecinos_colindantes.pdf");
							break;
						case 'pdfnovecinoscolindantes':
							window.open("../docs/carta_no_vecinos.pdf");
							break;
						case 'pdfcartacompromiso':
							window.open("../docs/"+arr[1]);
							break;
					  	default: break;
					}
				});
        
        $("#masayuda").on("click",function(){
            var page = "../includes/global_masinformacion.php";
            var $dialog = $('<div></div>')
                .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
                .css({overflow:"hidden"})
                .dialog({
                       autoOpen: false,
                       modal: true,
                       show: { effect: "fold", duration: 1000 },
                       hide: {effect: "fold", duration: 1000 },
                       height: 525,
                       width: 800,
                       title: "Historial Trámite"
               });
               $dialog.dialog('open');
        });


    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
	
	function enviar_a_programar_cita(tramitevu_id) {
		$.ajax({
			url: '../ajax/global_enviar_a_programar_cita.php',
			data: {tramitevu_id: tramitevu_id},
			type: 'POST',
			dataType: 'text',
			async: false,
			success: function(data) {
				alert(data.trim());
				location.reload();
			},
			error: function (jqXHR, exception) {
				alert(jqXHR+' '+exception);
			}
		});
	}
	
	function get_info_tramitecambio(tramitevu_id) {
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
	
</script>
<?
$inputbusqueda = isset($_GET['inputbusqueda']) ? $_GET['inputbusqueda'] : '';
$inputbusquedastatus = isset($_GET['inputbusquedastatus']) ? $_GET['inputbusquedastatus'] : '';
?>
<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                <b style="background-color: #ECF9FF;"> *  Para finalizar tu solicitud, debes de cargar tus documentos digitalizados en el ícono <i style="font-size: 1.5em;" class="icon-upload"></i></b>
                <br>
				<b style="background-color: #ECF9FF;"> *  Para cada número de requisito deberás cargar ÚNICAMENTE UN ARCHIVO, y recuerda que deberá estar en formato pdf. En caso de tener varios documentos para un requisito, júntalos todos en un mismo pdf para poderlos subir</b>
                <br>
				<b style="background-color: #ECF9FF;"> *  En caso de que algún documento no aplique, favor de cargar una hoja en blanco con el mensaje "NO APLICA" y el motivo
				<br>
				<b style="background-color: #ECF9FF;"> *  En caso de haber subido un archivo incorrecto, es necesario eliminarlo y volverlo a subir
				<br>
				<b style="background-color: #ECF9FF;"> *  Los documentos que aparecen en el ícono <i style="font-size: 1.5em;" class="icon-document"></i> deberán ser impresos, llenados y escaneados para ser subidos en el tipo de documento que corresponda
				<br>
				<b style="background-color: #ECF9FF;"> *  Una vez que hayas cargado todos tus documentos, haz click en el botón "ENVIAR A REVISIÓN" para que te sea agendada tu cita</b>
				<br>
				<b style="background-color: #ECF9FF;"> *  Ya que envíes a revisión tus documentos, se te asignará un folio y una cita (consérvalos y tráelos contigo cuando asistas a tu cita a la Unidad Administrativa de Alcoholes).</b>
				<br>
				<b style="background-color: #ECF9FF;"> *  Para ver el proceso de tu trámite, haz click en el ícono <i style="font-size: 1.5em;" class="icon-time"></i></b>
				<br>
				<b style="background-color: #ECF9FF;"> *  Una vez enviado el expediente a revisión, podrás ver comentarios de seguimiento del proceso de tu trámite o realizar comentarios, haciendo click en el ícono <i style="font-size: 1.5em;" class="icon-message"></i></b>
				<br>
				<b style="background-color: #ECF9FF;"> *  Para editar el registro, haz click en el ícono <i style="font-size: 1.5em;" class="icon-edit"></i></b>, NOTA: si editas el registro, tendrás que subir nuevamente el archivo de solicitud
                <?
                //paginador
                $connclass  	= new DBmysqli();
                $conn 			= $connclass->conn;
                $limit      	= ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 50;
                $page      		= ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
                $links      	= ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
                $morelinks      = ( isset( $_GET['inputbusqueda'] ) ) ? "&inputbusqueda=".$_GET['inputbusqueda'] : "";

                $getquery = new ventanilla();
                $query = $getquery->getqueryallbycorreoanduser($usersessionext[0]['correoexterno'],$usersessionext[0]['rfcexterno'],$inputbusqueda,$inputbusquedastatus);
	
                $Paginator  	= new Paginator($conn, $query);
                $results    	= $Paginator->getData($limit, $page);
                ?>
                <?php echo "<br>".$Paginator->createLinks($links, 'pagination',$morelinks ); ?>
                <input type="hidden" id="usuarioid" name="usuarioid" value="<?=(isset($usersession[0]['usuarios_id']))?$usersession[0]['usuarios_id']:'null'?>">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Folio</th>
                            <th scope="col">Cita / Nombre del negocio</th>
                            <th scope="col">Fecha solicitud / Tramite / Código de barras</th>
                            <th scope="col">Estatus / Flujo</th>
                            <th scope="col">Documentos</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?
                    if($results <> ''){
                        if(count($results->data) > 0){
                            foreach ($results->data as $row){
                                ?>
                                <tr>
                                    <td>
                                        <?if ($row['folio_permiso'] || $row['folio_altalicencia'] || $row['folio_tramitecambio']) {
											echo $row['folio_permiso'];
											echo $row['folio_altalicencia'];
											echo $row['folio_tramitecambio'];
										}
										else {
											echo "Folio no asignado";
										}
                                        ?>
                                    </td>
                                    <td>
                                        <?if ($row['completo'] == 0){?>
                                            Cita no asignada
                                            <? $coloricon = "red"; ?>
                                        <?}else{?>
                                                <? if ($row['tramitevu_cita'] != ''){?>
                                                    <span style="background-color:#ECFFEA">
                                                    <?=substr($row['tramitevu_cita'],0,-3)?>
                                                    </span>													
                                                <?}else{?>
                                                    No asignada
                                                <?}?>
                                        <?}?>
                                            <br><?=$row['permiso_nombre_negocio']?>
											<?=$row['altalicencia_nombre_negocio']?>
											<? if($row['licencia_nombre_negocio'] || $row['cambio_nombre_negocio']) { 
												echo $row['licencia_nombre_negocio'].' / '.$row['cambio_nombre_negocio'];
											}?>
                                    </td>
                                    <td>
                                        <?=$row['tramitevu_fechainicio']?><br>
                                        <b><?=$row['tipotramite_nombre']?></b>
                                        <br><b><?=$row['tramitevu_folio']?></b>
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
										<? 
											# Si el documento de solicitud ya fue aprobado, no poder editar el registro, igualmente si ya está cancelado, no poder editar el registro
											if ($row['documento_solicitud_aprobado'] == 0 && $row['status_id'] != 4) { ?>
												<i id="editartramite|<?=$row['tramitevu_id']?>|<?=$row['tabla']?>|<?=$row['tablacampo']?>" style="cursor:pointer; font-size: 1.5em;" title="Editar" class="icon-edit"></i>
											<? } ?>
                                        <!--<i id="verinfo|<?//=$row['tramitevu_id']?>|<?//=$row['tabla']?>|<?//=$row['tablacampo']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Info" class="icon-eye"></i>-->
										<?php if($row['tramitevu_mostrar'] == 1) { ?>
										<i id="comentario|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Comentarios" class="icon-message"></i>
										<?php } ?>
                                        <!--<i id="historial|<?//=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Historial" class="icon-time"></i>-->
                                        <i id="upload|<?=$row['tramitevu_id']?>|<?=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Agregar Documentos" class="icon-upload"></i>
                                        <i id="verflujo|<?=$row['tramitevu_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Flujo" class="icon-time"></i>
               
                                              <!--FORMATOS -->
                                              <!-- CROQUIS -->
                                              <? if ($row['tramitevu_tipotramiteid'] == 1 or $row['tramitevu_tipotramiteid'] == 7 or $row['tramitevu_tipotramiteid'] == 9){ ?>
											  
                                              <i id="croquis|<?=$row['tramitevu_id']?>|<?=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Croquis" class="icon-document"></i> 
                                              <i id="pdfvecinoscolindantes" style="cursor:pointer; font-size: 1.5em;" title="Formato vecinos colindantes" class="icon-document"></i>
											  <i id="pdfnovecinoscolindantes" style="cursor:pointer; font-size: 1.5em;" title="Formato NO vecinos colindantes" class="icon-document"></i>
                                              <? } ?>
                                              <? if ($row['tramitevu_tipotramiteid'] == 6 or $row['tramitevu_tipotramiteid'] == 5 or $row['tramitevu_tipotramiteid'] == 4 or $row['tramitevu_tipotramiteid'] == 3 or $row['tramitevu_tipotramiteid'] == 2 or $row['tramitevu_tipotramiteid'] == 9){ ?>
                                                  <i id="pdfsolicitudcambio|<?=$row['tramitevu_id']?>|<?=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Cambio" class="icon-document"></i>
                                              <? } ?>
                                              <? if ($row['tramitevu_tipotramiteid'] == 1){ ?>
                                                  <i id="pdfsolicitudalta|<?=$row['tramitevu_id']?>|<?=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Alta" class="icon-document"></i> 
                                              <? } ?>
											<?php
											if ($row['tramitevu_tipotramiteid'] == 1 || $row['tramitevu_tipotramiteid'] == 9) {
												$tramite = new tramite();
												$datos_tra = $tramite->getinfotramitebytramitevu($row['tramitevu_id'], $row['tramitevu_tipotramiteid']);
												$giro = $datos_tra[0]['giro_id'];
												$catalogos = new catalogos();
												$info_giro = $catalogos->getgiro($giro);
												$documento = $info_giro[0]['documento_nombre'];
											?>
											<i id="pdfcartacompromiso|<?=$documento?>" style="cursor:pointer; font-size: 1.5em;" title="Carta compromiso" class="icon-document"></i>
											  <?php } ?>
											
                                              <!-- Formato Solicitud de permiso especial -->
                                                <? if ($row['tramitevu_tipotramiteid'] == 7){ ?>
                                                    <i id="pdfsolicitudpermiso|<?=$row['tramitevu_id']?>|<?=$row['tramitevu_tipotramiteid']?>" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de permiso" class="icon-document"></i> 
                                                <? } ?>
                                       
										<?php 
											if($row['docsubidos'] != $row['docstotal']) { 
												$enable_disable = 'disabled';
											}
											else {
												$enable_disable = '';
											}
										?>
										<br>
										<?php 
											if($row['tramitevu_mostrar'] == 0) { 
												echo "Pendiente de enviar a revisión";
										?>		
											<input type="button" id="enviar_revision" name="enviar_revision" class="btn btn-primary btn-send-message" onclick="enviar_a_programar_cita(<?=$row['tramitevu_id']?>)" value="Enviar a revisión" <?=$enable_disable; ?>>
										<?php  }  
											else {
												echo "Enviado a revisión<br>";
												echo $row['tramitevu_fecha_enviado_revision'];
											}
										?>
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
