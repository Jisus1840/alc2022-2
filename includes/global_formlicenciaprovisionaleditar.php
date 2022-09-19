<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Formulario para editar permiso
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2005',$usersessionpermisos);
?>
<?
?>
<!DOCTYPE html>
<html>
    <head>
        
    </head>
    <body>
      <div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                
            </div>
        </div>
    </div>
</div>
</body>
</html>
<!-- Container modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content ui-front">
            <div class="modal-body"  id="prueba">

            </div>
            <div class="modal-footer">
                <i id="close" style="cursor:pointer; font-size: 1.5em;" title="Cerrar" class="icon-circle-cross" data-dismiss="modal"></i>
            </div>
        </div>
    </div>
</div>