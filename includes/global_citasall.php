<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todas las citas
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('23',$usersessionpermisos);
?>
<? 
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
?>
<style>
    .circle {
      height: 20px;
      width: 20px;
      border-radius: 50%;
    }
</style>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
        $("#bsqfecha").datepicker({
           todayBtn: "linked",
           language: "es",
           autoclose: true,
           todayHighlight: true,
           dateFormat: 'yy-mm-dd' 
        });
        
        //Get Eventos
        var items1="";
        $.getJSON("../ajax/global_getcalendarioeventos.php",function(data){
            items1+="<option value=''>Tipo cita</option>";
            $.each(data,function(index,item){
                items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#bsqevento").html(items1); 
        });
        
        //Get Usuarios
        var items2="";
        $.getJSON("../ajax/global_getcalendariousuarios.php",function(data){
            items2+="<option value=''>Usuario</option>";
            $.each(data,function(index,item){
                items2+="<option value='"+item.id+"'>"+item.nombre+"</option>";
            });
            $("#bsqusuario").html(items2); 
        });
        
        $("i").on("click",function(){
            var id = this.id;
            var arr = id.split("|");
            switch(arr[0]) {
						case'vercita':
				            var page = "../includes/global_citaverinfo.php?citaid="+arr[1];
                            var $dialog = $('<div></div>')
                                .html('<iframe style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
                                .css({overflow:"hidden"})	
                                .dialog({
                                       autoOpen: false,
                                       modal: true,
                                       show: { effect: "fold", duration: 1000 },
                                       hide: {effect: "fold", duration: 1000 },
                                       height: 400,
                                       width: 700,
                                       title: "Información Cita"
                               });
                               $dialog.dialog('open');
							break;
						case'eliminar':	
                            if (confirm("Seguro deseas eliminar la cita?")){
                                $.ajax({
                                    url: '../ajax/global_citaeliminar.php',
                                    dataType: "text",
                                    type: 'post',
                                    data: {
                                        "citaid": arr[1],
                                        "tramitevuid": arr[2]
                                    },
                                    beforeSend: function() {
                                        $("#loading").show();
                                    },
                                    success: function(data) {
                                        if (data == ""){
                                            alert ("Cita eliminada correctamente");
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
                            break; 
					  	default:
					}
        });    
        
        $("#btnbsq").on("click",function(){
            //Arma json y lo serealiza
            var busquedaaux = {
                    "bsqfecha": $("#bsqfecha").val(),
                    "bsqevento": $("#bsqevento").val(),
                    "bsqusuario": $("#bsqusuario").val()
            };
            busquedaaux = btoa(JSON.stringify(busquedaaux));
            document.location.href = window.location.href.split('?')[0]+'?busqueda='+busquedaaux;
        });

        $("#btnlimpiar").on("click",function(){
            window.location = window.location.href.split("?")[0];
        });
        
    });

    $(document).ajaxStop(function() {
        <? if ($busqueda != ''){?>
            var busquedaarray = JSON.parse(atob('<?=$busqueda?>'));
            $("#bsqfecha").val(busquedaarray.bsqfecha);
            $("#bsqevento").val(busquedaarray.bsqevento);
            $("#bsqusuario").val(busquedaarray.bsqusuario);
        <?}?>
        $("#loading").hide();
    });
    
</script>

<div id="loading" style="display:none">
    <img id="loading-image" src="../images/global_loading.gif"/>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-11 col-md-offset-1 col-md-pull-1 animate-box" data-animate-effect="fadeInLeft">
                <!-- FILTROS BÚSQUEDA -->
                <br><h2>Filtros de Búsqueda</h2>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <input id="bsqfecha" name="bsqfecha" type="text" class="form-control" placeholder="Fecha" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <select id="bsqevento" name="bsqevento" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select id="bsqusuario" name="bsqusuario" class="form-control">
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

                        $getquery = new citas();
                        $query = $getquery->getqueryallcitas($busqueda);
                        $Paginator  	= new Paginator($conn, $query);
                        $results    	= $Paginator->getData($limit, $page);
                        ?>
                        <?php echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hora</th>
                                    <th scope="col">Tramite</th>
                                    <th scope="col">Asesor</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                            if($results <> ''){
                                if(count($results->data) > 0){
                                    foreach ($results->data as $row){ 
                                        ?>
                                        <tr>
                                            <td><?=$row['citas_fecha']?></td>
                                            <td><?=$row['citas_horainicio']?></td>
                                            <td><?=$row['ceventos_nombre']?></td>
                                            <td>
                                                <div class="circle" style="background-color:#<?=$row['cusuarios_color']?>; float: left;"></div>&nbsp;
                                                <?=$row['cusuarios_nombre']?>
                                            </td>
                                            <td>
                                                <i id="vercita|<?=$row['citas_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Info" class="icon-printer"></i>
                                                <i id="eliminar|<?=$row['citas_id']?>|<?=$row['citas_tramitevuid']?>" style="cursor:pointer; font-size: 1.5em;" title="Eliminar" class="icon-delete"></i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="5">
                                                <?=$row['citas_descripcionsolicitante']?>
                                            </td>
                                            <td></td>
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