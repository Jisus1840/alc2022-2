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
<!DOCTYPE html>
<html>
    <head>
        <style>
			input, textarea {
				text-transform: uppercase;
			}
		</style>
        
        <script>
        // On mouse-over, execute myFunction
        
        </script>
        
        <script language="javascript">

            $(document).ajaxStart(function() {
                $("#loading").show();
            });

            $(document).ready(function(){
                $("#consultar").click(function(){
                    if ($("#folio").val() == '' || $("#hora").val() == ''){
                        alert ("Folio y Hora son campos obligatorios");
                        $("#folio").focus();
                    }else{
                    
                        $.ajax({
                            url: '../ajax/global_getvuidbyfoliohora.php',
                            dataType: "json",
                            data: {
                                    'folio' : $("#folio").val(),
                                    'hora' : $("#hora").val()
                            },  
                            type: 'post',
                            beforeSend: function() {
                                $("#loading").show();	
                            },
                            success: function(data) { 
                                if (data[0].vuid != 0){
                                    //Rellena Info
                                    
                                    var html = 
                                    '<table class="table table-striped">'+
                                        '<thead>'+
                                            '<tr>'+
                                                '<th scope="col">VU / Folio</th>'+
                                                '<th scope="col">Fecha / Tramite</th>'+
                                                '<th scope="col">Status / Flujo</th>'+
                                                '<th scope="col"></th>'+
                                            '</tr>'+
                                        '</thead>'+
                                        '<tbody>'+
                                            '<tr>'+
                                                '<td>'+
                                                    data[0].tramitevu+'<br>'+
                                                    '<b>'+data[0].folio+'</b>'+
                                                '</td>'+
                                                '<td>'+ 
                                                    data[0].fecha+'<br>'+
                                                    '<b>'+data[0].tramite+'</b>'+
                                                '</td>'+
                                                '<td>'+ 
                                                    data[0].statusnombre+'<br>'+
                                                    '<b>'+data[0].flujo+'</b>'+
                                                '</td>'+
                                                '<td>'+
                                                    '<i id="verinfo|'+data[0].vuid+'|'+data[0].tabla+'|'+data[0].tablacampo+'" style="cursor:pointer; font-size: 1.5em;" title="Ver Info" class="icon-eye"></i>'+
                                                    '<i id="comentario|'+data[0].vuid+'" style="cursor:pointer; font-size: 1.5em;" title="Comentarios" class="icon-message"></i>'+
                                                    '<i id="historial|'+data[0].vuid+'" style="cursor:pointer; font-size: 1.5em;" title="Historial" class="icon-time"></i>';
                                                    
                                                    if (data[0].vuid == 6 || data[0].vuid == 5 || data[0].vuid == 4 || data[0].vuid == 3 || data[0].vuid == 2){
                                                            html += '<i id="pdfsolicitudcambio|'+data[0].vuid+'|'+data[0].tipotramiteid+'" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Cambio" class="icon-document"></i>';
                                                    }
                                                    
                                                    if (data[0].tipotramiteid == 1){
                                                        html += '<i id="pdfsolicitudalta|'+data[0].vuid+'|'+data[0].tipotramiteid+'" style="cursor:pointer; font-size: 1.5em;" title="Formato Solicitud de Cambio" class="icon-document"></i>';
                                                    }
                                    
                                                    html +='<i id="upload|'+data[0].vuid+'" style="cursor:pointer; font-size: 1.5em;" title="Agregar Documentos" class="icon-upload"></i>'+
                                                    '<i id="verflujo|'+data[0].vuid+'" style="cursor:pointer; font-size: 1.5em;" title="Ver Flujo" class="icon-arrow-right"></i>'+
                                                '</td>'+
                                                
                                            '</tr>'+
                                        '</tbody>'+
                                    '</table>';
                                    $("#infotabla").html(html);
                                    
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
                                               width: 700,
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
                                case 'pdfsolicitudcambio':
                                    window.open("../gdocs/global_solicituddecambio.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(arr[2]));
                                    break;
                                case 'pdfsolicitudalta':
                                    window.open("../gdocs/global_solicitudaltalicencia.php?tramitevuid="+btoa(arr[1])+"&tipotramitevu="+btoa(arr[2]));
                                    break;
                                default:
                            }
                        });
                                    
                                    
                                }else{
                                    $("#infotabla").html("No se encontró información");
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
                
            if ($("#folio").val() != '' && $("#hora").val() != ''){
                $("#consultar").trigger("click");
            }
            
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
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="folio" name="folio" type="text" class="form-control" placeholder="Folio *" maxlength="20" value="<?=$folio?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input id="hora" name="hora" type="text" class="form-control" placeholder="Hora hh:mm *" maxlength="5" value="<?=$hora?>">
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="button" id="consultar" name="consultar" class="btn btn-primary btn-send-message" value="Consulta trámite">
                    </div>
                </form>

                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div id="infotabla">
                        </div>
                    </div>
                </div>        
                
            </div>
        </div>
    </div>
</div>
</body>
</html>
