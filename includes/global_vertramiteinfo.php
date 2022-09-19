<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver toda la información del trámite
entrada
    tramitevuid,
    tabla
    tablacampo
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    //$p = new permisos();
    //$p->revisarpermisos('12',$usersessionpermisos);
?>
<style type="text/css">
    
    table.info {
    	border: solid black 1px;
    	border-spacing: 10px;
    }
    table.info td {
    	padding: 10px;
    }
    
    
    </style>
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
    $v = new ventanilla();
    $res = $v->getinfotramite( $_GET['tramitevuid'], $_GET['tabla'], $_GET['tablacampo']);
?>
<br>
<table class="table table-striped">
    <tbody>
        <tr>
            <th width="150px">Folio VU</th>
            <td><?=($res[0]['completo']==1)?$res[0]['tramitevu_folio']:'No Finalizado'?></td>
        </tr>
        <tr>
            <th>Folio </th>
            <td><?=($res[0]['completo']==1)?$res[0]['folio']:'No Finalizado'?></td>
        </tr>
        <tr>
            <th>Trámite </th>
            <td><?=$res[0]['tipotramite_nombre']?></td>
        </tr>
        <tr>
            <th>Cita </th>
            <td><?=($res[0]['completo']==1)?($res[0]['tramitevu_cita']=='')?'No asignada':substr($res[0]['tramitevu_cita'],0,-3):'No Finalizado'?></td>
        </tr>
    </tbody>
</table>
<br>
<h2>Requerimientos:</h2>
<? 
switch ($res[0]['tipotramite_id']){
    case 1:
        //Solicitud de Licencia
        include_once "../includes/global_inforequisitossolicitudlicencia.php";
        break;
    case 7:
        //Solicitud de Permiso
        include_once "../includes/global_inforequisitossolicitudpermisoespecial.php";
        break;
    case 9:
        //Solicitud de Cambio
        include_once "../includes/global_inforequisitossolicitudcambio.php";
        break;
    case 8:
        //solicitud de refrendo
        include_once "../includes/global_inforequisitossolicitudrefrendo.php";
        break;
    default:
}
?>
<? include_once ("../js/global_footer.js");?>