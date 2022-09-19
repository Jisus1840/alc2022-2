<?
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todas las licencias
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2001',$usersessionpermisos);
?>
<? 
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
                //Get Giro búsqueda
                var items1="";
                $.getJSON("../ajax/global_getgiro.php",function(data){
                    items1+="<option value='' disabled selected>Giro</option>";
                    $.each(data,function(index,item){
                        items1+="<option value='"+item.id+"'>"+item.nombre+"</option>";
                    });
                    $("#bsqgiroid").html(items1); 
                });
        
                //Get Tipo licencia
                var items11="";
                $.getJSON("../ajax/global_gettipolicencia.php",function(data){
                    items11+="<option value='' disabled selected>Tipo Licencia</option>";
                    $.each(data,function(index,item){
                        let tipo = (item.id == 1 ? 'A Solo cerveza' : 'B Cualquier tipo de vinos, licores y cervezas');
                        items11+="<option value='"+item.id+"'>"+item.nombre+" tipo - "+ tipo +"</option>";
                    });
                    $("#bsqtipolicencia").html(items11); 
                });
        
				$("i").on("click",function(){
  					var id = this.id;
				  	var arr = id.split("|");
				    switch(arr[0]) {
						case'verinfo':
				            var page = "../includes/global_verinfolicencia.php?id="+arr[1];
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
									   title: "Información"
							   });
							   $dialog.dialog('open');
							   break; 
						case'mapa':	
							var page = "../includes/global_verubicacion.php?latitud="+arr[2]+"&longitud="+arr[3];
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
									   title: "Ubicación"
							   });
							   $dialog.dialog('open');
							   break; 
					  	default:
					}
				});
        
                $("#btnbsq").on("click",function(){
                    //Arma json y lo serealiza
                    var busquedaaux = {
                            "bsqgiroid": $("#bsqgiroid").val(),
                            "bsqpropietario": $("#bsqpropietario").val(),
                            "bsqcomodatario": $("#bsqcomodatario").val(),
                            "bsqnombre": $("#bsqnombre").val(),
                            "bsqtipolicencia": $("#bsqtipolicencia").val(),
                            "bsqnumlicencia": $("#bsqnumlicencia").val()
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
            $("#bsqgiroid").val(busquedaarray.bsqgiroid);
            $("#bsqpropietario").val(busquedaarray.bsqpropietario);
            $("#bsqcomodatario").val(busquedaarray.bsqcomodatario);
            $("#bsqnombre").val(busquedaarray.bsqnombre);
            $("#bsqtipolicencia").val(busquedaarray.bsqtipolicencia);
            $("#bsqnumlicencia").val(busquedaarray.bsqnumlicencia);
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
                    <div class="form-group col-md-3">
                        <select id="bsqgiroid" name="bsqgiroid" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <input id="bsqpropietario" name="bsqpropietario" type="text" class="form-control" placeholder="Propietario RFC o Razón Social">
                    </div>
                    <div class="form-group col-md-4">
                        <input id="bsqcomodatario" name="bsqcomodatario" type="text" class="form-control" placeholder="Comodatario RFC o Razón Social">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <input id="bsqnombre" name="bsqnombre" type="text" class="form-control" placeholder="Nombre Genérico">
                    </div>
                    <div class="form-group col-md-2">
                        <select id="bsqtipolicencia" name="bsqtipolicencia" class="form-control">
                        </select>
                    </div>
                    <div class="form-group col-md-2">
                        <input id="bsqnumlicencia" name="bsqnumlicencia" type="text" class="form-control" placeholder="Licencia">
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
                        <br><h2>Licencias</h2>
                        <?
                        
                        //paginador
                        $connclass  	= new DBmysqli();
                        $conn 			= $connclass->conn;
                        $limit      	= ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 50;
                        $page      		= ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
                        $links      	= ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
                        $morelinks      = ( isset( $_GET['busqueda'] ) ) ? "&busqueda=".$_GET['busqueda'] : "";

                        $getquery = new licencias();
                        $query = $getquery->getqueryall($busqueda);
                        $Paginator  	= new Paginator($conn, $query);
                        $results    	= $Paginator->getData($limit, $page);
                        ?>
                        <?php echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>
                        <table id="tabla_lics" class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Licencia</th>
                                    <th scope="col">Giro</th>
                                    <th scope="col">Propietario</th>
                                    <th scope="col">Nombre Genèrico</th>
                                    <th scope="col">Colonia</th>
                                    <th scope="col">Zona</th>
                                    <th scope="col">CP</th>
                                    <th width="120px"></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                            if($results <> ''){
                                if(count($results->data) > 0){
                                    foreach ($results->data as $row){ 
                                        ?>
                                        <tr>
                                            <td><?=$row['tipolicencia_nombre'].'-'.$row['licencias_licencia']?></td>
                                            <td><?=$row['giro_nombre']?></td>
                                            <td><?=$row['nombrepropietario']?></td>
                                            <td><?=$row['licencias_nombregenerico']?></td>
                                            <td><?=$row['colonia_nombre']?></td>
                                            <td><?=$row['zona_nombre']?></td>
                                            <td><?=$row['colonia_cp']?></td>
                                            <td width="120px">
                                                <!--info-->
                                                <i id="verinfo|<?=$row['licencias_id']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Info" class="icon-eye"></i>
                                                <!--mapa-->
                                                <i id="mapa|<?=$row['licencias_id']?>|<?=$row['licencias_latitud']?>|<?=$row['licencias_longitud']?>" style="cursor:pointer; font-size: 1.5em;" title="Ver Ubicación" class="icon-map"></i>
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
    </div>
</div>