
<?
session_start();
if (isset($_SESSION['alcoholes']['usuario_info'])){
	//session_start();
	$usersession =  unserialize($_SESSION['alcoholes']['usuario_info']);
    $usersessionpermisos =  unserialize($_SESSION['alcoholes']['permisos']);
}

$tramitevuid = $_GET['tramitevuid'];
$usuarioid = $_GET['usuarioid'];

?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        $("#guardarmotivo").on("click",function(){
			var motivo_cancelacion = document.getElementById('motivo_cancelacion').value.trim();
			if (motivo_cancelacion == '' || motivo_cancelacion.length < 5) {
				alert('Porfavor, ingresa un motivo para poder continuar');
			}
			else {
				$.ajax({
					url: '../ajax/global_cancelartramite.php',
					dataType: "text",
					type: 'post',
					data: {
						"motivocancelacion" : $("#motivo_cancelacion").val(),
						"tramiteid" : $("#tramitevuid_cancelar").val(),
						"usuarioid" : $("#usuarioid_cancelar").val()					
					},
					beforeSend: function() {
						$("#loading").show();	
					},
					success: function(data) { 
						alert (data.trim());
						location.reload();
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
        })
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<br>
<h3>Cancelar trámite</h3>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="motivo_cancelacion">Motivo de cancelación del trámite</label>
        <input type="text" id="motivo_cancelacion" name="motivo_cancelacion" class="form-control" maxlength="1000" required />
		<input type="hidden" id="tramitevuid_cancelar" name="tramitevuid_cancelar" value="<?=$tramitevuid?>" />
		<input type="hidden" id="usuarioid_cancelar" name="usuarioid_cancelar" value="<?=$usuarioid?>" />
    </div>
</div>
<div class="form-group col-md-12">
    <input type="button" id="guardarmotivo" class="btn btn-primary btn-send-message" value="Cancelar trámite">
</div>