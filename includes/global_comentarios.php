<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver toda la información del trámite
entrada
    tramitevuid
*********************************************************************************
*/
?>
<?
session_start();
if (isset($_SESSION['alcoholes']['usuario_info'])){
	//session_start();
	$usersession =  unserialize($_SESSION['alcoholes']['usuario_info']);
    $usersessionpermisos =  unserialize($_SESSION['alcoholes']['permisos']);
}
?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        $("#agregar").on("click",function(){
            $.ajax({
                url: '../ajax/global_agregarcomentario.php',
                dataType: "text",
                type: 'post',
                data: {
                    "comentario" : $("#comentario").val(),
                    "usuarioid" : $("#usuarioid").val(),
                    "tramiteid" : $("#tramiteid").val()
                },
                beforeSend: function() {
                    $("#loading").show();	
                },
                success: function(data) { 
                    alert (data);
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
    $v = new ventanilla();
	$usuario_id = isset($usersession[0]['usuarios_id']) ? $usersession[0]['usuarios_id'] : 'null';
	$v->actualizarcomentariosvistos($_GET['tramitevuid'], $usuario_id);
    $res = $v->getcomentariostramite($_GET['tramitevuid']);
?>
<br>
<h3>Agregar Comentario</h3>
<table class="table table-striped">
    <thead>
        <tr>
            <th style="width: 46%">Comentario</th>
            <th style="width: 19%">Fecha</th>
            <th style="width: 19%">Usuario</th>
            <th style="width: 19%">Visto</th>
        </tr>
    </thead>
    <tbody>
        <? if ($res <> ''){ ?>
            <? foreach ($res as $row){ ?>
                <tr>
                    <td><?=$row['comentariosvu_comentario']?></td>
                    <td><?=$row['comentariosvu_fecha']?></td>
                    <td><?=$row['usuarios_nombre']?></td>
					<td><?=$row['comentariosvu_visto']?></td>
                </tr>
            <?}?>
        <?}?>
    </tbody>
</table>

<div class="form-row">
    <input type="hidden" id="usuarioid" name="usuarioid" value="<?=isset($usersession[0]['usuarios_id'])?$usersession[0]['usuarios_id']:'null'?>">
    <input type="hidden" id="tramiteid" name="tramiteid" value="<?=$_GET['tramitevuid']?>">
    <div class="form-group col-md-12">
        <label for="comentario">Escribe un comentario</label>
        <textarea id="comentario" name="comentario" class="form-control" maxlength="1000"></textarea>
    </div>
</div>
<div class="form-group col-md-12">
    <input type="button" id="agregar" class="btn btn-primary btn-send-message" value="Agregar">
</div>