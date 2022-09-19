<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para editar propietario
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('20',$usersessionpermisos);
?>
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
                            pid: m.pid,
                            prfc: m.prfc,
                            pnombre: m.pnombre
                        };
                    });
                    response(array);
                });
            },
            select: function (event, ui) {
                $('#licencia').val(ui.item? ui.item.label : ''); 
                $('#licenciaid').val(ui.item? ui.item.id : '');
                $('#panterior').val(ui.item? ui.item.prfc : ''); 
                $('#panteriorid').val(ui.item? ui.item.pid : '');
                $("#pnuevo").prop('disabled', false);
                $("#licencia").prop('disabled', true);
             },
            change: function( event, ui ) {
                $('#licencia').val(ui.item? ui.item.label : '');
                $( "#licenciaid" ).val(ui.item? ui.item.id : '');
                $('#panterior').val(ui.item? ui.item.prfc : ''); 
                $('#panteriorid').val(ui.item? ui.item.pid : '');
            }
        });
        
        $("#pnuevo").on("blur",function(){
            if (($("#pnuevo").val().length < 12 || $("#pnuevo").val().length > 13 ) && ($("#pnuevo").val() != '' || $("#pnuevo").val() != 'null')){
                alert ("El RFC debe contener al menos 12 carácteres");
                $("#pnuevo").val('');
                $("#rfcsource").focus();
            }else{
                //Consulta informacion de RFC
                $.ajax({
                    url: '../ajax/global_getinforfc.php',
                    dataType: "json",
                    data: {
                            'rfc' : $("#pnuevo").val()
                    },  
                    type: 'post',
                    beforeSend: function() {
                        $("#loading").show();	
                    },
                    success: function(data) { 
                        if (data[0].bandera == 1){
                            //Rellena Info
                            $("#bandera").val(data[0].bandera);
                            $("#curp").val(data[0].curp);
                            $("#pnuevoid").val(data[0].id);
                            $("#personanombre").val(data[0].nombre);
                            $("#direccion").val(data[0].direccion);
                            $("#entrecalle").val(data[0].entrecalle);
                            $("#yentrecalle").val(data[0].yentrecalle);
                            $("#telefono").val(data[0].telefono);
                            $("#celular").val(data[0].celular);
                            $("#correo").val(data[0].correo);
                            $("#coloniaid").val(data[0].coloniaid);
                            $("#colonia").val(data[0].colonia);
                            //Set Readonly
                            $("#bandera").prop('readOnly', true);
                            $("#curp").prop('readOnly', true);
                            $("#pnuevoid").prop('readonly', true);
                            $("#personanombre").prop('readonly', true);
                            $("#direccion").prop('readonly', true);
                            $("#entrecalle").prop('readonly', true);
                            $("#yentrecalle").prop('readonly', true);
                            $("#telefono").prop('readonly', true);
                            $("#celular").prop('readonly', true);
                            $("#correo").prop('readonly', true);
                            $("#coloniaid").prop('readonly', true);
                            $("#colonia").prop('readonly', true);
                        }else{
                            $("#bandera").prop('readOnly', false);
                            $("#curp").prop('readOnly', false);
                            $("#pnuevoid").prop('readonly', false);
                            $("#personanombre").prop('readonly', false);
                            $("#direccion").prop('readonly', false);
                            $("#entrecalle").prop('readonly', false);
                            $("#yentrecalle").prop('readonly', false);
                            $("#telefono").prop('readonly', false);
                            $("#celular").prop('readonly', false);
                            $("#correo").prop('readonly', false);
                            $("#coloniaid").prop('readonly', false);
                            $("#colonia").prop('readonly', false);
                            $("#bandera").val('');
                            $("#curp").val('');
                            $("#personanombre").val('');
                            $("#direccion").val('');
                            $("#entrecalle").val('');
                            $("#yentrecalle").val('');
                            $("#telefono").val('');
                            $("#celular").val('');
                            $("#correo").val('');
                            $("#coloniaid").val('');
                            $("#colonia").val('');
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
        
        $("#btnguardar").on("click",function(){
            var banderaguarda = 1;
            //Validar formulario
            if ($("#licenciaid").val() == ''){
                alert ("Licencia es un campo obligatorio");
                $("#licencia").focus();
                banderaguarda = 0;
            }else if ($("#pnuevo").val() == ''){
                alert ("Propietario es un campo obligatorio");
                $("#pnuevo").focus();
                banderaguarda = 0;
            }else if ($("#bandera").val() != '1'){
                //Valida los dato del rfc para guardarlo en el catálogo de personas
                if ($("#curp").val() == '' || $("#curp").val().length < 18){
                    alert ("CURP del propietario es un campo obligatorio y debe de contener 18 caracteres");
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
                }else if ($("#entrecalle").val() == ''){
                    alert ("Entre Calle es un campo obligatorio");
                    $("#entrecalle").focus();
                    banderaguarda = 0;
                }else if ($("#yentrecalle").val() == ''){
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
            }
            
            if (banderaguarda == 1){
                var form_data = new FormData(document.getElementById("MiFormulario"));
                $.ajax({
                    url: '../ajax/global_guardatramitecambiopropietario.php',
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
                    <div class="form-group col-md-12">
                        <label for="pnuevo">Propietario Nuevo</label>
                        <input id="pnuevo" name="pnuevo" type="text" class="form-control" maxlength="13" disabled>
                        <input id="pnuevoid" name="pnuevoid" type="hidden">
                    </div>
                    <input id="bandera" name="bandera" type="hidden" value="0">
                    <div class="form-group col-md-12">
                        <input id="curp" name="curp" type="text" class="form-control" placeholder="CURP" readonly maxlength="18">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="personanombre" name="personanombre" type="text" class="form-control" placeholder="Nombre" readonly maxlength="250">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="direccion" name="direccion" type="text" class="form-control" placeholder="Domicilio" readonly maxlength="250">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="colonia" name="colonia" type="text" class="form-control" placeholder="Colonia" readonly>
                        <input id="coloniaid" name="coloniaid" type="hidden">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="entrecalle" name="entrecalle" type="text" class="form-control" placeholder="Entre Calle" readonly maxlength="100">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="yentrecalle" name="yentrecalle" type="text" class="form-control" placeholder="y Calle" readonly maxlength="100">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="telefono" name="telefono" type="text" class="form-control" placeholder="Teléfono" readonly maxlength="50">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="celular" name="celular" type="text" class="form-control" placeholder="Celular" readonly maxlength="50">
                    </div>
                    <div class="form-group col-md-12">
                        <input id="correo" name="correo" type="text" class="form-control" placeholder="Correo" readonly maxlength="250">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="panterior">Propietario Anterior</label>
                        <input id="panterior" name="panterior" type="text" class="form-control" disabled>
                        <input id="panteriorid" name="panteriorid" type="hidden">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>