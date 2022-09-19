<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para refrendo
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
    //$p = new permisos();
    //$p->revisarpermisos('21',$usersessionpermisos);
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
        
        $("#fechapago").datepicker({
           todayBtn: "linked",
           language: "es",
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'yy-mm-dd' 
        });
        
        $("#licencia").autocomplete({
            minLength: 10,
            source: function(request, response) {
                $.getJSON("../ajax/global_getinfolicenciabylicencia.php?licencia="+$("#licencia").val(), {
                    term: request.term
                }, function(data) {                     
                    var array = data.error ? [] : $.map(data, function(m) {
                        return {
                            label: m.licencia,
                            value: m.licencia,
                            id: m.id,
                            giroid: m.giroid,
                            giro: m.gironombre
                        };
                    });
                    response(array);
                });
            },
            select: function (event, ui) {
                $('#licencia').val(ui.item? ui.item.label : ''); 
                $('#licenciaid').val(ui.item? ui.item.id : '');
                $('#giroanterior').val(ui.item? ui.item.giro : ''); 
                $('#giroanteriorid').val(ui.item? ui.item.giroid : '');
                $("#giro").prop('disabled', false);
                $("#licencia").prop('disabled', true);
             },
            change: function( event, ui ) {
                $('#licencia').val(ui.item? ui.item.label : '');
                $( "#licenciaid" ).val(ui.item? ui.item.id : '');
                $('#giroanterior').val(ui.item? ui.item.giro : ''); 
                $('#giroanteriorid').val(ui.item? ui.item.giroid : '');
            }
        });
        
        $("#btnguardar").on("click",function(){
            //Validar formulario
            if ($("#licenciaid").val() == ''){
                alert ("Licencia es un campo obligatorio");
                $("#licencia").focus();
            }else if ($('#fechapago').val() == '') {
                alert ("Fecha de Pago es un campo obligatorio");
                $("#fechapago").focus();
                banderaguarda = 0;
            }else{
                var form_data = new FormData(document.getElementById("MiFormulario"));
                $.ajax({
                    url: '../ajax/global_guardatramiterefrendo.php',
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
</script>
<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>
<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="MiFormulario" name="MiFormulario">
                    <div class="form-group col-md-12">
                        <label for="licencia"># Licencia</label>
                        <input id="licencia" name="licencia" type="text" class="form-control" placeholder="ALCC-00001">
                        <small id="licenciahelp" class="form-text text-muted">ALCC o ALCA guión y 5 dígitos, selecciona la licencia</small>
                        <input id="licenciaid" name="licenciaid" type="hidden">
                    </div>
                    
                    <div class="form-group col-md-12">
                        <input type="text" id="fechapago" name="fechapago" class="form-control" placeholder="Fecha de Pago" readonly>
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
<?php
//Correo que se envía
$asunto = "Solicitud de Refrendo creada";
$cuerpo = "
<img src='".$GLOBALS['vu_global_site']."images/logo2.png' width='200px'>
<br><br>
Solicitud creada exitosamente.

Si deseas consultar el estatus de tu solicitud, accede a nuestro portal en la siguiente dirección <a href='".$GLOBALS['vu_global_site']."gui/global_loginext.php'>UAA</a> con tu correo y el RFC que utilizaste para accesar.
";
?>
<input type="hidden" id="asunto" value="<?=$asunto?>">
<input type="hidden" id="cuerpo" value="<?=$cuerpo?>">