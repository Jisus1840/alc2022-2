<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para dar de alta licencia provisional
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('16',$usersessionpermisos);
?>
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
<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="MiFormulario" name="MiFormulario">
                </form>
            </div>

        </div>
    </div>
</div>