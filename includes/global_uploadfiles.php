<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* TABLA PARA VER LA INFORMACION SOBRE DOCUMENTOS CARGADOS Y CARGAR NUEVOS
*********************************************************************************
*/
?>
<?
session_start();
if (isset($_SESSION['alcoholes']['usuario_info'])) {
	$usersession =  unserialize($_SESSION['alcoholes']['usuario_info']);
	$usersessionpermisos =  unserialize($_SESSION['alcoholes']['permisos']);
} else {
	$usersession =  unserialize($_SESSION['alcoholesext']['usuarioext_info']);
}
?>
<? include_once("../config/global_includes.php"); ?>
<?
$tramitevuid = (isset($_GET['tramitevuid'])) ? $_GET['tramitevuid'] : 0;
$tramitevu_tipotramiteid = (isset($_GET['tramitevu_tipotramiteid'])) ? $_GET['tramitevu_tipotramiteid'] : 0;

$du = new documentosupload();
$datosactivos = $du->getdocumentosuploadactivosbytramitevuid($tramitevuid);
$datosinactivos = $du->getdocumentosuploadinactivosbytramitevuid($tramitevuid);
$select = $du->getalltipodocumentosactivos($tramitevu_tipotramiteid);
?>
<html lang="es">

<head>
	<? include_once("../js/global_header.js"); ?>
	<script>
		$(document).ready(function() {
			$("img").on("click", function() {
				var id = this.id;
				var arr = id.split("_");
				switch (arr[0]) {
					case 'delete':
						$.ajax({
							url: '../ajax/global_deletedocumentouploadbyid.php',
							dataType: "text",
							data: {
								'documentosupload_id': arr[1]
							},
							type: 'post',
							beforeSend: function() {
								$("#loading").show();
							},
							success: function(data) {
								if (data == 1) {
									location.reload();
								} else {
									alert("Ocurrió un error, vuelve a intentar más tarde. " + data);
									location.reload();
								}
							},
							complete: function(data) {
								//$("#loading").hide();
							}
						});
						break;
					case 'reactivar':
						$.ajax({
							url: '../ajax/global_reactivardocumentouploadbyid.php',
							dataType: "text",
							data: {
								'documentosupload_id': arr[1]
							},
							type: 'post',
							beforeSend: function() {
								$("#loading").show();
							},
							success: function(data) {
								if (data == 1) {
									location.reload();
								} else {
									alert("Ocurrió un error, vuelve a intentar más tarde. " + data);
									location.reload();
								}
							},
							complete: function(data) {
								//$("#loading").hide();
							}
						});
						break;
					default:
						// code block
				}
			});
			$("#deletearchivosboton").on("click", function() {
				$('.borrar').each(function() {
					this.click();
				});
				// var id = this.id;
				// var arr = id.split("_");
				// switch(arr[0]) {
				// 	case 'deletebutton':
				// 		$.ajax({
				// 				url: '../ajax/global_deletedocumentouploadbyid.php',
				// 				dataType: "text",
				// 				data: { 
				// 					'documentosupload_id': arr[1]
				// 				},                 
				// 				type: 'post',
				// 				beforeSend: function() {
				// 					$("#loading").show();
				// 				},
				// 				success: function(data) {
				// 					if (data == 1){
				// 						location.reload();
				// 					}else{
				// 						alert ("Ocurrió un error, vuelve a intentar más tarde. "+data);
				// 						location.reload();
				// 					}
				// 				},
				// 				complete: function (data) {
				// 					//$("#loading").hide();
				// 				}

				// 		});	
				// 	}
			});

			$("#imguploaddocs").on("click", function() {
				if ($("#selectdocs").val() != '' && $("#nombrearcivopersonalizado").val() != '') {
					$("#inputuploaddocs").trigger('click');
				} else {
					alert("Debes seleccionar tipo de Archivo y capturar Nombre");
				}
			});

			$('#inputuploaddocs').change(function(evt) {
				var nombre_archivo = $("#inputuploaddocs").prop("files")[0].name;
				var ext_archivo = nombre_archivo.split('.').pop().toLowerCase();

				var form_data = new FormData();
				form_data.append("tramitevuid", $("#frmtramitevuid").val());
				form_data.append("userid", $("#userid").val());
				form_data.append("inputuploaddocs", $("#inputuploaddocs").prop("files")[0]);
				form_data.append("tipodocumentoupload", $("#selectdocs").val());
				form_data.append("nombrearcivopersonalizado", $("#nombrearcivopersonalizado").val());
				form_data.append("ext_archivo", ext_archivo);

				$.ajax({
					url: '../ajax/global_uploaddocumentos.php',
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
						if (data == 1) {
							location.reload();
						} else if (data == 2) {
							alert("No se subió el documento. Ya has subido un archivo para este número de requisito.");
						} else {
							alert(data.trim());
						}
					},
					complete: function(data) {
						$("#loading").hide();
					}
				});
			});

			$(".aprobar_documento").on("click", function() {
				var is_checked = Number($(this).is(":checked"));
				var documentosupload_id = this.id;
				if (is_checked == 1) {
					document.getElementById('doc_' + documentosupload_id).style.backgroundColor = 'lightgreen';
					document.getElementById('actions_' + documentosupload_id).style.backgroundColor = 'lightgreen';
				} else {
					document.getElementById('doc_' + documentosupload_id).style.backgroundColor = '#FF6347';
					document.getElementById('actions_' + documentosupload_id).style.backgroundColor = '#FF6347';
				}
				var form_data = new FormData();
				form_data.append("documentosupload_id", documentosupload_id);
				form_data.append("is_checked", is_checked);
				$.ajax({
					url: '../ajax/global_uploaddocumentos_aprobar.php',
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

					},
					complete: function(data) {
						$("#loading").hide();
					}
				});
			});

		});
	</script>
</head>
<div id="loading" style="display:none">
	<img id="loading-image" src="../images/global_loading.gif" />
</div>

<body translate="no">
	<div class="container-fluid">
		<main class="page-content">
			<br>
			<h2>DOCUMENTOS SOPORTE</h2>
			<!-- <p style="color: red;">Para usuarios nuevos, seleccionar solo los tramites que dicen (NUEVO)</p> -->
			<!-- Agregar Documento-->
			<select id="selectdocs" class="form-control">
				<option value="">Haz click AQUÍ para seleccionar un documento</option>
				<? foreach ($select as $row) {
					if ($row["tipodocumentosupload_estatus"] == 2) { ?>
						<option value="<?= $row['tipodocumentosupload_id'] ?>"><?= $row['tipodocumentosupload_nombre'] ?></option>
				<? }
				} ?>
			</select>
			<input type="file" id="inputuploaddocs" name="inputuploaddocs" style="display:none">
			<input type="hidden" id="frmtramitevuid" value="<?= $_GET['tramitevuid'] ?>">
			<input type="hidden" id="userid" value="<?= isset($usersession[0]['usuarios_id']) ? $usersession[0]['usuarios_id'] : 'null' ?>">
			<!-- <input type="text" class="form-control" id="nombrearcivopersonalizado" placeholder="Captura Nombre Archivo"> -->
			<br>
			Carga el documento en el ícono verde
			<img id="imguploaddocs" src="../images/global_upload.png" width="30px" style="cursor: pointer">
			<br><br>
			<!--Tabla para mostrar documentos activos-->
			<? if ($datosactivos != 0) { ?>
				<table class="table table-sm table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col">TIPO ARCHIVO</th>
							<!--<th scope="col">USUARIO</th>-->
							<th scope="col" width="120px"></th>
						</tr>
					</thead>
					<tbody>

						<? foreach ($datosactivos as $row) {
							if ($row['documentosupload_aprobado'] == 1) {
								$style = 'style="background-color: lightgreen"';
								$checked = 'checked';
							} else {
								$style = 'style="background-color: #FF6347"';
								$checked = '';
							}
						?>
							<tr>
								<td class="align-middle" id="doc_<?= $row['documentosupload_id'] ?>" <? echo $style; ?>><?= $row['tipodocumentosupload_nombre'] ?></td>
								<!--<td class="align-middle"><? //=$row['usuarios_nombre']
																?></td>-->
								<td class="align-middle" id="actions_<?= $row['documentosupload_id'] ?>" <? echo $style; ?>>
									<? if (isset($usersession[0]['usuarios_id'])) { ?>
										<input type="checkbox" id="<?= $row['documentosupload_id'] ?>" class="aprobar_documento" value="aprobado" <? echo $checked ?>>
									<? } ?>
									<img src="../images/global_informacion.png" height="30px" title="Nombre Archivo <?= $row['documentosupload_nombrearchivo'] ?>&#xA;Fecha <?= $row['documentosupload_fechacreacion'] ?>">
									<a href="<?= $row['documentosupload_ruta'] ?>/<?= $row['documentosupload_nombrearchivo'] ?>" target="_blank">
										<img src="../images/global_documento.png" height="25px">
									</a>
									<? if ($row['documentosupload_aprobado'] == 0 || isset($usersession[0]['usuarios_id'])) { ?>
										<img title="Borrar archivo" id="delete_<?= $row['documentosupload_id'] ?>" src="../images/global_borrar.png" height="25px" style="cursor: pointer" class="borrar">
									<? } ?>
								</td>
							</tr>
						<? } ?>
					</tbody>
				</table>
				<button class="btn btn-primary btn-send-message" id="deletearchivosboton">Eliminar todo los archivos</button>
			<? } ?>
			<!--Tabla para mostrar documentos inactivos-->
			<? if ($datosinactivos != 0) { ?>
				<br>Documentos Eliminados<br>
				<table class="table table-sm table-striped table-bordered">
					<thead class="thead-dark">
						<tr>
							<th scope="col" style="background-color:silver; border-color: azure">TIPO ARCHIVO</th>
							<th scope="col" style="background-color:silver; border-color: azure">USUARIO</th>
							<th scope="col" style="background-color:silver; border-color: azure" width="120px"></th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($datosinactivos as $row) { ?>
							<tr>
								<td class="align-middle" style="color: #A6A6A6"><?= $row['documentosupload_nombrearchivo'] ?></td>
								<td class="align-middle" style="color: #A6A6A6"><?= $row['usuarios_nombre'] ?></td>
								<td class="align-middle">
									<a href="<?= $row['documentosupload_ruta'] ?>/<?= $row['documentosupload_nombrearchivo'] ?>" target="_blank">
										<img src="../images/global_documento.png" height="25px">
									</a>
									<? if (isset($usersession[0]['usuarios_id'])) { ?>
										<img title="Reactivar archivo" id="reactivar_<?= $row['documentosupload_id'] ?>" src="../images/global_reactivar.jpg" height="25px" style="cursor: pointer">
									<? } ?>
								</td>
							</tr>
						<? } ?>
					</tbody>
				</table>
			<? } ?>
		</main>
	</div>
</body>

</html>