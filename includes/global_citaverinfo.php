<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario parta alta de Licencia
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>
<?
//Get INFO
$citas = new citas();
$res = $citas->getinfocitabyid($_GET['citaid']);
?>
<table class="table table-striped" width="100%">
    <tbody>
    <tr>
        <td width="30%"><b>Fecha y Hora</b></td>
        <td><?=$res[0]['citas_fecha']?> <?=$res[0]['citas_horainicio']?></td>
    </tr>
    <tr>
        <td><b>Trámite</b></td>
        <td><?=$res[0]['ceventos_nombre']?></td>
    </tr>
    <tr>
        <td><b>Duración</b></td>
        <td><?=$res[0]['citas_duracion']?> minutos</td>
    </tr>
    <tr>
        <td><b>Fin</b></td>
        <td><?=$res[0]['citas_horafin']?></td>
    </tr>
    <tr>
        <td><b>Nombre</b></td>
        <td><?=$res[0]['citas_nombresolicitante']?></td>
    </tr>
    <tr>
        <td><b>Correo</b></td>
        <td><?=$res[0]['citas_correosolicitante']?></td>
    </tr>
    <tr>
        <td><b>Descripción</b></td>
        <td><?=$res[0]['citas_descripcionsolicitante']?></td>
    </tr>
    </tbody>
</table>