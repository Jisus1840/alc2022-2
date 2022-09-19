<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para editar nombre genérico
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('18',$usersessionpermisos);
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
                            giroid: m.giroid,
                            giro: m.gironombre,
                            nombregenerico: m.nombregenerico
                        };
                    });
                    response(array);
                });
            },
            select: function (event, ui) {
                $('#licencia').val(ui.item? ui.item.label : ''); 
                $('#licenciaid').val(ui.item? ui.item.id : '');
                $('#nombreganterior').val(ui.item? ui.item.nombregenerico : ''); 
                $('#nombreganteriordis').val(ui.item? ui.item.nombregenerico : ''); 
                $("#nombregnuevo").prop('disabled', false);
                $("#licencia").prop('disabled', true);
             },
            change: function( event, ui ) {
                $('#licencia').val(ui.item? ui.item.label : '');
                $( "#licenciaid" ).val(ui.item? ui.item.id : '');
                $('#nombreganterior').val(ui.item? ui.item.nombregenerico : ''); 
            }
        });
        
        $("#btnguardar").on("click",function(){
            //Validar formulario
            if ($("#licenciaid").val() == ''){
                alert ("Licencia es un campo obligatorio");
                $("#licencia").focus();
            }else if ($("#nombregnuevo").val() == ''){
                alert ("Nombre genérico es un campo obligatorio");
                $("#nombregnuevo").focus();
            }else{
                var form_data = new FormData(document.getElementById("MiFormulario"));
                $.ajax({
                    url: '../ajax/global_guardatramitecambionombregenerico.php',
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
                    <div class="form-group">
                        <label for="licencia"># Licencia</label>
                        <input id="licencia" name="licencia" type="text" class="form-control">
                        <input id="licenciaid" name="licenciaid" type="hidden">
                    </div>
                    <div class="form-group">
                        <label for="nombregnuevo">Nombre Genérico Nuevo</label>
                        <input id="nombregnuevo" name="nombregnuevo" type="text" class="form-control" disabled>
                    </div>
                    <div class="form-group">
                        <label for="nombreganteriordis">Nombre Genérico Anterior</label>
                        <input id="nombreganteriordis" name="nombreganteriordis" type="text" class="form-control" disabled>
                        <input id="nombreganterior" name="nombreganterior" type="hidden" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>