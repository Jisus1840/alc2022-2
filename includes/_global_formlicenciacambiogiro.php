<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para editar giro
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('21',$usersessionpermisos);
?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
        //Get Giro
        var items1="";
        $.getJSON("../ajax/global_getgiro.php",function(data){
            items1+="<option value='' disabled selected>Giro</option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#giroid").html(items1); 
        });
        
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
            }else if ($('#giroid').find('option:selected').attr('disabled')) {
                alert ("Giro es un campo obligatorio");
                $("#giroid").focus();
                banderaguarda = 0;
            }else{
                var form_data = new FormData(document.getElementById("MiFormulario"));
                $.ajax({
                    url: '../ajax/global_guardatramitecambiogiro.php',
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
                        <select id="giroid" name="giroid" class="form-control">
                        </select>
                    </div>
                    
                    <div class="form-group col-md-12">
                        <label for="giro">Giro Anterior</label>
                        <input id="giroanterior" name="giroanterior" type="text" class="form-control" disabled>
                        <input id="giroanteriorid" name="giroanteriorid" type="hidden">
                    </div>
                    <div class="form-group col-md-12">
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>