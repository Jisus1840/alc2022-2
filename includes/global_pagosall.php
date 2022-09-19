<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todos los pagos
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('2007',$usersessionpermisos);
?>
<?
$busqueda = isset($_GET['busqueda']) ? $_GET['busqueda'] : '';
?>
<style>
    .modal-open .ui-datepicker{z-index: 2000!important}
</style>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
              
        $("#btnbsq").on("click",function(){
            //Arma json y lo serealiza
            var busquedaaux = {
                    "bsqciclo": $("#bsqciclo").val(),
                    "bsqtipotramite": $("#bsqtipotramite").val()
            };
            busquedaaux = btoa(JSON.stringify(busquedaaux));
            document.location.href = window.location.href.split('?')[0]+'?busqueda='+busquedaaux;
        });

        $("#btnlimpiar").on("click",function(){
            window.location = window.location.href.split("?")[0];
        });
        
        $("#btnexcel").on("click",function(){
            window.location = '../gdocs/ingresos_desglosados.php';
        });
        
		$("#ingresostotales").on("click",function(){
			var mapForm = document.createElement("form");
			mapForm.method = "POST";
			mapForm.action = "../gdocs/global_reporte_ingresos_totales.php";
			mapForm.target = '_blank';
			document.body.appendChild(mapForm);
			mapForm.submit();
			document.body.removeChild(mapForm);
		});
		
		$("#ingresosdesglosados").on("click",function(){
			var mapForm = document.createElement("form");
			var year = document.getElementById('bsqciclo').value;
			mapForm.method = "POST";
			mapForm.action = "../gdocs/global_reporte_ingresos_desglosados.php";
			mapForm.target = '_blank';		
			create_input(mapForm, "year", year);		
			document.body.appendChild(mapForm);
			mapForm.submit();
			document.body.removeChild(mapForm);
		});
		
		$("#vertodospagos").on("click",function(){
			var mapForm = document.createElement("form");
			var year = document.getElementById('bsqciclo').value;
			mapForm.method = "POST";
			mapForm.action = "../gdocs/global_reporte_todos_pagos.php";
			mapForm.target = '_blank';				
			document.body.appendChild(mapForm);
			mapForm.submit();
			document.body.removeChild(mapForm);
		});
	
        <? if ($busqueda != ''){?>
            var busquedaarray = JSON.parse(atob('<?=$busqueda?>'));
            $("#bsqciclo").val(busquedaarray.bsqciclo);
            $("#bsqtipotramite").val(busquedaarray.bsqtipotramite);
        <?}?>
    });
	
	// Función para crear un input
	function create_input(formulario, nombre, valor){
		var mapInput = document.createElement("input");
		mapInput.type = "text";
		mapInput.name = nombre;
		mapInput.value = valor;
		formulario.appendChild(mapInput);
	}


    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
    
    function enteros(elEvento) {
        // Variables que definen los caracteres permitidos
        var permitidos = "0123456789";
        var teclas_especiales = [8];

        // Obtener la tecla pulsada 
        var evento = elEvento || window.event;
        var codigoCaracter = evento.charCode || evento.keyCode;
        var caracter = String.fromCharCode(codigoCaracter);

        // Comprobar si la tecla pulsada es alguna de las teclas especiales
        // (teclas de borrado y flechas horizontales)
        var tecla_especial = false;
        for(var i in teclas_especiales) {
            if(codigoCaracter == teclas_especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        return permitidos.indexOf(caracter) != -1 || tecla_especial;
    }
    
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
                        <select id="bsqciclo" name="bsqciclo" class="form-control">
                            <?
                            for ($i = date("Y"); $i>=2019; $i--){
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <select id="bsqtipotramite" name="bsqtipotramite" class="form-control">
                            <option value="">Tipo Trámite</option>
                            <option value="1">Solicitud de Licencia</option>
                            <option value="7">Solicitud de Permiso Especial</option>
                            <option value="9">Solicitud de Cambio</option>
                        </select>
                    </div>
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
				<br>
				<table>
					<tr>
						<td>
							<input type="button" id="ingresostotales" value="Exportar ingresos totales" class="btn btn-primary btn-send-message">
						</td>
						<td>
							<input type="button" id="ingresosdesglosados" value="Exportar ingresos desglosados" class="btn btn-primary btn-send-message">
						</td>
					</tr>
                </table>
                
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <br><h2>Ver Trámites</h2>
                        <?
                        //paginador
                        $connclass  	= new DBmysqli();
                        $conn 			= $connclass->conn;
                        $limit      	= ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 50;
                        $page      		= ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
                        $links      	= ( isset( $_GET['links'] ) ) ? $_GET['links'] : 2;
                        $morelinks      = ( isset( $_GET['busqueda'] ) ) ? "&busqueda=".$_GET['busqueda'] : "";

                        $getquery = new ventanilla();
                        $query = $getquery->getqueryallpagos($busqueda);
                        $_SESSION['reportepagos'] = $query;
                        $Paginator  	= new Paginator($conn, $query);
                        $results    	= $Paginator->getData($limit, $page);
                        ?>
                        <?php echo $Paginator->createLinks($links, 'pagination',$morelinks ); ?>
                        <input type="hidden" id="usuarioid" name="usuarioid" value="<?=$usersession[0]['usuarios_id']?>">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Ciclo</th>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Tramite</th>
                                    <th scope="col">Licencia / Permiso</th>
                                    <th scope="col">Fecha Pago</th>
                                    <th scope="col">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?
                            if($results <> ''){
                                if(count($results->data) > 0){
                                    foreach ($results->data as $row){ 
                                        ?>
                                        <tr>
                                            <td>
                                                <?=$row['tramitevu_ciclo']?>
                                            </td>
                                            <td>
                                                <b><?=$row['folio']?></b>
                                            </td>
                                            <td>
                                                <b><?=$row['tipotramite_nombre']?></b>
                                            </td>
                                            <td>
                                                <?=$row['licencia']?>
                                            </td>
                                            <td>
                                                <?=$row['tramitevu_fechapago']?>
                                            </td>
                                            <td align="right">
                                                <?=number_format($row['tramitevu_montopago'],2,'.',',')?>
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
<!-- Container modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ui-front">
            <div class="modal-body"  id="prueba">

            </div>
            <div class="modal-footer">
                <i id="close" style="cursor:pointer; font-size: 1.5em;" title="Cerrar" class="icon-circle-cross" data-dismiss="modal"></i>
            </div>
        </div>
    </div>
</div>