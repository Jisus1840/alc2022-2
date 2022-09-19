
<?
session_start();
if (isset($_SESSION['alcoholes']['usuario_info'])){
	//session_start();
	$usersession =  unserialize($_SESSION['alcoholes']['usuario_info']);
    $usersessionpermisos =  unserialize($_SESSION['alcoholes']['permisos']);
}

$tramitevuid = $_GET['tramitevuid'];
$tabla = $_GET['tabla'];

?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        $("#actualizarfolio").on("click",function(){
            $.ajax({
                url: '../ajax/global_asignafolio.php',
                dataType: "text",
                type: 'post',
                data: {
					"foliotramite" : $("#foliotramite").val(),
                    "tabla" : $("#tabla_a_actualizar").val(),
                    "tramitevuid" : $("#tramitevuid_actualizar").val()
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
        })
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<?
	// Traemos folio actual
    $t = new tramite();
    $result = $t->get_folio_tramite($tabla, $tramitevuid);
?>
<br>
<h3>Actualizar folio del trámite</h3>

<div class="form-row">
    <div class="form-group col-md-12">
        <label for="foliotramite">Folio</label>
        <input type="text" id="foliotramite" name="foliotramite" class="form-control" maxlength="50" value="<?=$result[0]['folio_tramite']?>" />
		<input type="hidden" id="tabla_a_actualizar" name="tabla_a_actualizar" value="<?=$tabla?>" />
		<input type="hidden" id="tramitevuid_actualizar" name="tramitevuid_actualizar" value="<?=$tramitevuid?>" />
    </div>
</div>
<div class="form-group col-md-12">
    <input type="button" id="actualizarfolio" class="btn btn-primary btn-send-message" value="Actualizar">
</div>