<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todas las citas
* ENTRADA GET: 
                    tramitevuid
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('22',$usersessionpermisos);
?>
<?
(isset($_GET['tramitevuid']))?$tramitevu = $_GET['tramitevuid']:$tramitevu=0;
if ($tramitevu == 0){
    $correo = "";
    $nombre = "";
    $asunto = "";
    $show = "text";
}else{
    //Consulta info tramitevu
    $vu = new ventanilla();
    $infovu = $vu->getinfotramitebasica($tramitevu);
    
    $correo = $infovu[0]['tramitevu_correo'];
    $nombre = $infovu[0]['tramitevu_rfc'];
    $asunto = "Revisión solicitud ".$infovu[0]['tramitevu_folio']." Folio: ".$infovu[0]['folio'];
    $show = "hidden";
}
?>

<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
        $("#anio").on("change",function(){
            actualizarcalendario();
        });  
        
        $("#mes").on("change",function(){
            actualizarcalendario();
        });  
        
        //Get Eventos
        var items1="";
        $.getJSON("../ajax/global_getcalendarioeventos.php",function(data){
            items1+="<option value=''>cita</option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#cita").html(items1); 
        });
        
        $("#usuario").on("click",function(){
            if ($("#cita").val() == ''){
                alert ("Debes de seleccionar primero una cita");
                $("#cita").focus();
            }
        });  
        
        $("#cita").on("change",function(){
            //Get Usuarios
            var items2="";
            $.getJSON("../ajax/global_getcalendariousuarios.php?eventoid="+$("#cita").val(),function(data){
                items2+="<option value=''>usuario</option>";
                $.each(data,function(index,item){
                    items2+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                });
                $("#usuario").html(items2); 
            });
        });  
        
        $("#agendar").on("click",function(){
            var fechaseleccion = $("#anio").val()+'-'+$("#mes").val()+'-'+('0'+$("#dia").val()).slice(-2);
            if ($("#dia").val() == ''){
                alert ("Día es un campo obligatorio");
                $("#dia").focus();
            }else if ($("#hi").val() == ''){
                alert ("Hora de Inicio es un campo obligatorio");
                $("#hi").focus();
            }else if ($("#hi").val() == ''){
                alert ("Hora de Inicio es un campo obligatorio");
                $("#hi").focus();
            }else if ($("#hf").val() == ''){
                alert ("Hora de Fin es un campo obligatorio");
                $("#hf").focus();
            }else if ($("#cita").val() == ''){
                alert ("Cita es un campo obligatorio");
                $("#cita").focus();
            }else if ($("#usuario").val() == ''){
                alert ("Usuario es un campo obligatorio");
                $("#usuario").focus();
            }else{
                $("#fechaagenda").val(fechaseleccion);
                //Agendar
                var form_data = new FormData(document.getElementById("MiFormulario"));
                $.ajax({
                    url: '../ajax/global_guardarcalendariovu.php',
                    dataType: "text",
                    type: 'post',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    beforeSend: function() {
                        $("#loading").show();
                    },
                    success: function(data) {
                        if (data == ""){
                            alert ("Cita agregada correctamente");
                            location.reload();
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
    
    var getDaysInMonth = function(month,year) {
        // Here January is 1 based
        //Day 0 is the last day in the previous month
        return new Date(year, month, 0).getDate();
        // Here January is 0 based
        // return new Date(year, month+1, 0).getDate();
        };
    
    function validateHhMm(inputField) {
        var isValid = /^([0-1][0-9]|2[0-3]):([0-5][0-9])$/.test(inputField.value);

        if (isValid) {
            inputField.style.backgroundColor = '#fff';
        } else {
            inputField.style.backgroundColor = '#fba';
            alert ("hora no valida formato hh:mm");
            inputField.value = '';
            inputField.focus();
        }

        return isValid;
    }
    
    function actualizarcalendario(){
        $.ajax({
            url: '../ajax/global_getcalendarioaniomes.php',
            dataType: "text",
            type: 'post',
            data: {
                "anio" : $("#anio").val(),
                "mes" : $("#mes").val()
            },
            beforeSend: function() {
                $("#loading").show();
            },
            success: function(data) {
                $("#calendario").html(data);
                //Recalcula dias
                var monthdays = getDaysInMonth($("#mes").val(), $("#anio").val());
                var items1="";
                items1+="<option value=''></option>";
                for (i=1;i<=monthdays; i++) { 
                    items1+="<option value='"+i+"'>"+i+"</option>";
                }
                $("#dia").html(items1); 
                
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
    
</script>

<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>

<div class="row">
    <div class="col-md-12">
        <table width="100%">
            <tr>
                <td width="20%" valign="top">
                    <br>
                    <form id="MiFormulario" name="MiFormulario">
                        <table width="100%">
                            <tr>
                                <td width="15%">
                                    <select id="anio" name="anio" class="form-control">
                                        <? 
                                            $anio = date("Y");
                                            for ($anio;$anio>=2019;$anio--){
                                                ?>
                                                <option value="<?=$anio?>"><?=$anio?></option>
                                                <?

                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">
                                    <select id="mes" name="mes" class="form-control">
                                        <? 
                                            $mes = array( 
                                                "01"=>"Enero",  
                                                "02"=>"Febrero",  
                                                "03"=>"Marzo",  
                                                "04"=>"Abril",
                                                "05"=>"Mayo",  
                                                "06"=>"Junio",  
                                                "07"=>"Julio",  
                                                "08"=>"Agosto",
                                                "09"=>"Septiembre",  
                                                "10"=>"Octubre",  
                                                "11"=>"Noviembre",  
                                                "12"=>"Diciembre",
                                            );
                                            foreach ($mes as $key=>$m){
                                                if ($key == date("m")){
                                                    ?>
                                                    <option value="<?=$key?>" selected><?=$m?></option>
                                                    <?
                                                }else{
                                                    ?>
                                                    <option value="<?=$key?>"><?=$m?></option>
                                                    <?
                                                }
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="15%">
                                    <select id="dia" name="dia" class="form-control">
                                        <option value="">día</option>
                                        <?
                                        $numdias = cal_days_in_month(CAL_GREGORIAN, 7, 2020); // 31
                                        for ($i=1;$i<=$numdias;$i++){
                                            ?>
                                            <option value="<?=$i?>"><?=$i?></option>
                                            <?

                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" id="hi" name="hi" placeholder="hh:mm Inicio" class="form-control" onchange="validateHhMm(this);">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="text" id="hf" name="hf" placeholder="hh:mm Fin" class="form-control" onchange="validateHhMm(this);">
                                </td>
                            </tr>
                            <tr valign="center">
                                <td>
                                    <select id="cita" name="cita" class="form-control">
                                        <option value="">cita</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select id="usuario" name="usuario" class="form-control">
                                        <option value="">usuario</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="<?=$show?>" id="nombre" name="nombre" class="form-control" placeholder="Nombre" value="<?=$nombre?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="<?=$show?>" id="correo" name="correo" class="form-control" placeholder="Correo" value="<?=$correo?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <input type="<?=$show?>" id="asunto" name="asunto" class="form-control" value="<?=$asunto?>">
                                </td>
                            </tr>
                            <tr>
                                <td align="right">
                                    <input type="hidden" id="tramitevu" name="tramitevu" value="<?=$tramitevu?>">
                                    <input type="hidden" id="fechaagenda" name="fechaagenda">
                                    <br>
                                    <input type="button" id="agendar" class="btn btn-primary btn-send-message" value="Agendar">
                                </td>
                            </tr>
                            
                        </table>
                    </form>
                </td>
                <td width="80%" valign="top">
                    <br>
                    <div id="calendario">
                    <?
                    $calendar = new calendario();
                    echo $calendar->show(date("Y"),date("m"));
                    ?>
                </div>
                </td>
            </tr>
        </table>
        <br>
    </div>
</div>