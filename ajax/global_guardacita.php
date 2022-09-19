<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GUARDA CITA
* * DATOS ENTRADA POST
						statusid
                        nombresolicitante
                        correosolicitante
                        descripcionsolicitante
                        eventoid
                        asesorid
                        fecha
                        hora
                        duracion
                        
* DATOS DE SALIDA 
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$citas = new citas();
	$res = $citas->guardacita(
        $_POST['statusid'],
        $_POST['nombresolicitante'],
        $_POST['correosolicitante'],
        $_POST['descripcionsolicitante'],
        $_POST['eventoid'],
        $_POST['asesorid'],
        $_POST['fecha'],
        $_POST['hora'],
        $_POST['duracion']
    );
?>