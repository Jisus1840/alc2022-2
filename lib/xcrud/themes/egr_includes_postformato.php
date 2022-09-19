<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Tabla que muestra CXP de prestaciones por usuario
*********************************************************************************
*/
?>
	<script>
		  $(function() {
              
			  $("#guardar").on("click",function(){
                  var form = document.getElementById('miFormulario');
                  var form_data = new FormData(form);
                  $.ajax({
                        url: '../ajax/egr_ajax_cxpguardaformatospprestaciones.php',
                        dataType: "text",
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,        
                        type: 'post',
                        beforeSend: function() {
                            $("#loading_dipetre").show();
                        },
                        success: function(data) {
                            alert("Formato Generado Correctamente");
                        },
                        complete: function(data) {
                            $("#loading_dipetre").hide();
                        }
                   });
			  });
              
		  });
	</script>
    
    <div id="loading_dipetre" style="display:none">
        <img id="loading-image_dipetre" src="../imagenes/global_imagenes_loading.gif"/>
    </div>
    
    <?
    //Get SOLICITUDES
    $cxp = new prestaciones();
    $res = $cxp->gettramitesporprogramar();
?>
<form id="miFormulario" name="miFormulario">
<table class="table table-sm table-striped table-bordered">
	<thead class="thead-dark">
		<tr>
			<th></th>
            <th scope="col" width="150px">EMISIÓN</th>
			<th scope="col">FECHA</th>
			<th scope="col">BENEFICIARIO</th>
			<th scope="col">MONTO</th>
		</tr>
	</thead>
	<tbody>
	<?
	foreach ($res as $row){
		?>
		<tr>
            <th><input type="checkbox" id="bloque[]" name="bloque[]" value="<?=$row['cxpbloque_bloque']?>"></th>
			<th scope="row"><?=$row['cxpbloque_bloque']?></th>
			<td><?=$row['fecha']?></td>
			<td><?=$row['cxpbloque_beneficiario']?></td>
			<td><?=number_format($row['cxpbloque_monto'],2,".",",")?></td>
		</tr>
		<?
	} 
	?>
</tbody>
</table>
<button type="button" class="btn btn-primary" id="guardar">Generar</button>
</form>