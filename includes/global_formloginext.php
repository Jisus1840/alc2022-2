<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Login para usuarios externos
*********************************************************************************
*/
?>
<style>
    input, textarea {
        text-transform: uppercase;
    }
</style>
<script language="javascript">
    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        $("#accesar").click(function(){
			var tramite = $('input[name="tramites_opciones"]:checked').val();
            event.preventDefault(); // stop the click to redirect to the URL in href
            //Peticion AJAX validar usuario y crear sesion
            if ($("#correo").val() != '' && $("#rfc").val() != ''){
                if (!(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\. [0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test($("#correo").val()))){
                    alert  ("Correo inválido, ingresa un correo válido.");
                    $("#correo").focus();
                }else if (($("#rfc").val().length < 12 || $("#rfc").val().length > 13 ) && ($("#rfcsource").val() != '' || $("#rfcsource").val() != 'null')){
                    alert ("El RFC debe contener al menos 12 carácteres");
                    $("#rfc").focus();
                }
				else if(tramite == null){
					alert("Porfavor, selecciona una acción para poder continuar");
				}			
				else{
                    $.ajax({
                        url: '../ajax/global_loginext.php',
                        dataType: "text",
                        async: true,
                        data: {
                            'correo' : $('#correo').val(),
                            'rfc' : $('#rfc').val(),
							'numero_pagina' : tramite
                        },  
                        type: 'post',
                        beforeSend: function() {
                            $("#loading").show();	
                        },
                        success: function(data) { 
                            if (data == 1 && tramite == 1) {
                                location.href='../gui/global_solicitudlicenciaexterno.php';
                            }
							else if(data == 1 && tramite == 2) {
								location.href='../gui/global_solicitudcambiosexterno.php';
							}
							else if(data == 1 && tramite == 3) {
								location.href='../gui/global_solicitudlicenciaprovisionalexterno.php';
							}
							else if(data == 1 && tramite == 4) {
								location.href='../gui/global_tramiteexterno.php';
							}
							else{
                                alert ("Error: "+data);
                                $("#rfc").val("");
                                $("#correo").val("");
								$("#numero_pagina").val("");
                            }
                        },
                        complete: function(data) { 
                            $("#loading").hide();
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) { 
                            alert (textStatus);
                            if (textStatus == "error"){
                                alert("Error: " + errorThrown); 
                            }
                        }
                    });  
                }
            }else{
                alert ("Correo y RFC son campos obligatorios");
                $("#correo").focus();
            }
        });
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });    
</script>
<!--<i class="material-icons">chat</i>-->
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                <form action="">
                    <div class="form-group">
                        <input id="correo" name="correo" type="text" class="form-control" placeholder="Correo">
                    </div>
                    <div class="form-group">
                        <input id="rfc" name="rfc" type="text" class="form-control" placeholder="RFC" maxlength="13">
                    </div>
					<div class="form-group">
                        <input id="numero_pagina" name="numero_pagina" type="hidden" value="<?php if(isset($_GET['pagina'])) { echo $_GET['pagina']; } ?>" class="form-control">
                    </div>
                    <b>Es importante que recuerdes el correo y RFC que utilizas para darle seguimiento a tu trámite.</b><br><br>
					
					¿Qué acción deseas realizar?
					<br>
					<input type="radio" id="seguimiento_t" name="tramites_opciones" value="4">
					<label for="seguimiento_t">Dar seguimiento a mi trámite</label><br>
					<input type="radio" id="licencia_t" name="tramites_opciones" value="1">
					<label for="licencia_t">Solicitud de licencia de nueva creación</label><br>
					<input type="radio" id="cambio_licencia_t" name="tramites_opciones" value="2">
					<label for="cambio_licencia_t">Solicitud de un cambio en una licencia ya existente</label><br>
					<input type="radio" id="permiso_especial_t" name="tramites_opciones" value="3">
					<label for="permiso_especial_t">Tramitar un permiso especial</label>

					
					
                    <div class="form-group">
                        <input id="accesar" name="accesar" type="button" class="btn btn-primary btn-send-message" value="Entrar">
                    </div>
					
                    <a href="../gui/global_login.php" style="font-size:9px">Login como Administrador</a>
                </form>
            </div>
        </div>
    </div>
</div>
