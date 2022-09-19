
<? include_once ("../config/global_includes.php"); ?>
<?php

$documentosupload_id = $_POST['documentosupload_id'];
$is_checked = $_POST['is_checked'];

$documentos = new documentosupload();
$documentos->aprobar_desaprobar_documento($documentosupload_id, $is_checked);

?>