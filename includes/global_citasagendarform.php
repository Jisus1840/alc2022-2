<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2020
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* FORMULARIO AGENDAR CITA
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('22',$usersessionpermisos);
?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
        $("#eventoid").change(function(){
            //selecciona la duracion del evento
            $.ajax({
                url: '../ajax/global_getduracioneventobyid.php',
                dataType: "text",
                type: 'post',
                data: {
                    "eventoid" : $("#eventoid").val()
                },
                beforeSend: function() {
                    $("#loading").show();	
                },
                success: function(data) { 
                    $("#duracion").val(data);
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
            
            //Get Asesor por evento
            var items4="";
            $.getJSON("../ajax/global_getcitasusuarios.php?eventoid="+$("#eventoid").val(),function(data){
                items4+="<option value=''></option>";
                $.each(data,function(index,item){
                    items4+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                });
                $("#asesorid").html(items4); 
            });
            
            $("#hora").val("");
            $("#fecha").val("");
        });
        
        //Fecha
        $("#fecha").datepicker({
           todayBtn: "linked",
           language: "es",
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'yy-mm-dd',
           onSelect: function(dateText, inst) {
                calcularfechas();
           }
        });
        
        //Get Eventos
        var items1="";
        $.getJSON("../ajax/global_getcitaseventos.php",function(data){
            items1+="<option value=''></option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#eventoid").html(items1); 
        });
        
        //Guardar
        $("#btnguardar").click(function() { 
            //Validar formulario
            if ($("#nombresolicitante").val() == ''){
                alert ("Nombre del Solicitante es un campo obligatorio");
                $("#nombresolicitante").focus();
            }else if ($("#correosolicitante").val() == ''){
                alert ("Correo del Solicitante es un campo obligatorio");
                $("#correosolicitante").focus();
            }else if ($("#descripcionsolicitante").val() == ''){
                alert ("Descripción del Solicitante es un campo obligatorio");
                $("#descripcionsolicitante").focus();
            }else if ($("#eventoid").val() == ''){
                alert ("Evento es un campo obligatorio");
                $("#eventoid").focus();
            }else if ($("#asesorid").val() == ''){
                alert ("Asesor es un campo obligatorio");
                $("#asesorid").focus();
            }else if ($("#fecha").val() == ''){
                alert ("Fecha es un campo obligatorio");
                $("#fecha").focus();
            }else if ($("#hora").val() == ''){
                alert ("Hora es un campo obligatorio");
                $("#hora").focus();
            }else{
                var form_data = new FormData(document.getElementById("miFormulario"));
					$.ajax({
						url: '../ajax/global_guardacita.php',
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
							alert (data);
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
    
    function calcularfechas(){
        if ($("#eventoid").val() == '' || $("#asesorid").val() == ''){
            alert ("Debes seleccionar un evento y un asesor");
            $("#eventoid").focus();
            $("#hora").val("");
            $("#fecha").val("");
        }else{
            //Get Horas Disponibles
            var items2="";
            $.getJSON("../ajax/global_getcitashoras.php?eventoid="+$("#eventoid").val()+"&asesorid="+$("#asesorid").val()+"&fecha="+$("#fecha").val(),function(data){
                items2+="<option value=''>Selecciona Hora *</option>";
                $.each(data,function(index,item){
                    items2+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                });
                $("#hora").html(items2); 
            });
        }
    }
</script>
<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="miFormulario" name="miFormulario">
                    <input id="statusid" name="statusid" type="hidden" value="2">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="nombresolicitante">Nombre de Solicitante *</label>
                            <input id="nombresolicitante" name="nombresolicitante" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="correosolicitante">Correo de Solicitante *</label>
                            <input id="correosolicitante" name="correosolicitante" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="descripcionsolicitante">Descripción *</label>
                            <textarea id="descripcionsolicitante" name="descripcionsolicitante" class="form-control" rows="4"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="eventoid">Trámite *</label>
                            <select id="eventoid" name="eventoid" class="form-control"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="duracion">Duración *</label>
                            <input id="duracion" name="duracion" type="text" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="asesorid">Asesor *</label>
                            <select id="asesorid" name="asesorid" class="form-control"></select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="text" class="form-control" id="fecha" name="fecha" value="" placeholder="Fecha" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <select id="hora" name="hora" class="form-control"></select>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="button" id="btnguardar" class="btn btn-primary btn-send-message" value="Guardar Licencia">
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>