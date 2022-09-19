<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para consultar status
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<!DOCTYPE html>
<html>
    <head>
        <style>
			input, textarea {
				text-transform: uppercase;
			}
		</style>
        
        <script>
        // On mouse-over, execute myFunction
        
        </script>
        
        <script language="javascript">

            $(document).ajaxStart(function() {
                $("#loading").show();
            });

            $(document).ready(function(){
                $("#continuar").click(function(){
                    var checked = []
                    $("input[name='cambio[]']:checked").each(function (){
                        checked.push(parseInt($(this).val()));
                    });
                    if (checked.length < 1){
                        alert ("Debes de seleccionar al menos un movimiento");
                    }else{
                        //Redireccionar 
                        var cambios = JSON.stringify(checked);
                        <? if (isset($usersession[0]['usuarios_id'])){?>
                            location.href = "../gui/global_solicitudcambios2.php?cambios="+cambios;
                        <?}else{?>
                            location.href = "../gui/global_solicitudcambios2externo.php?cambios="+cambios;
                        <?}?>
                    }
                });
            });

            $(document).ajaxStop(function() {
                $("#loading").hide();
            });
            
        </script>
    </head>
    <body>
    <div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <form id="MiFormulario" name="MiFormulario">
                    
                    <div class="form-group col-md-12">
                        <h3>Selecciona el o los cambios que deseas solicitar</h3>
                        <input type="checkbox" value="1"  id="cambio" name="cambio[]"> Cambio de Domicilio
                        <br><input type="checkbox" value="2" id="cambio" name="cambio[]"> Cambio de Propietario
                        <br><input type="checkbox" value="3"  id="cambio" name="cambio[]"> Cambio de Comodatario
                        <br><input type="checkbox" value="4"  id="cambio" name="cambio[]"> Cambio de Nombre Genérico
                        <br><input type="checkbox" value="5"  id="cambio" name="cambio[]"> Cambio de Giro
                        <br><input type="checkbox" value="6"  id="cambio" name="cambio[]"> Cambio de Tipo de Licencia
                    </div>
                    <div class="form-group col-md-12">
                        <input type="button" id="continuar" name="continuar" class="btn btn-primary btn-send-message" value="Continuar">
                    </div>
                </form>  
            </div>
        </div>
    </div>
</div>
</body>
</html>
