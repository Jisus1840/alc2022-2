<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GUARDAR CITA Y VU
* * DATOS ENTRADA POST
                        anio
                        mes
                        dia
                        fechaagenda
                        hi
                        hf
                        cita
                        usuario
                        tramitevu
                        nombre
                        correo
                        asunto
                        
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $c = new citas();
    $res = $c->checkdisponibilidad ($_POST['fechaagenda'],$_POST['hi'],$_POST['hf'],$_POST['usuario']);

    if ($res == 0){
        //Guarda
        $res2 = $c->guardacita(2,$_POST['nombre'], $_POST['correo'], $_POST['asunto'], $_POST['cita'], $_POST['usuario'], $_POST['fechaagenda'], $_POST['hi'], $_POST['hf'],$_POST['tramitevu']);
        if ($_POST['tramitevu'] <> 0){
            //Actualiza cita
            $v = new ventanilla();
            $v->updatecitavu($_POST['tramitevu'],$_POST['fechaagenda']." ".$_POST['hi'].":00");
        }
        //Mandar correo
        $cuerpo = "
        <img src='".$GLOBALS['vu_global_site']."images/logo2.png' width='200px'>
        <br>
        Nombre del solicitante: ".$_POST['nombre']."
        <br>
        Cita agendada.<br>

        La Unidad Administrativa de Alcoholes te agendo una cita el día ".$_POST['fechaagenda']." a las ".$_POST['hi']."
        
        <br><br>
        Favor de presentarte con los documentos en original y copias para la revisión de tu solicitud.
        ";
            
        $v = new correo();
	    $v->enviarcorreo($_POST['correo'],$_POST['correo'],$cc='',"Cita Agendada",$cuerpo);
        echo $res2;
    }else{
        echo "Cita no puede ser guardada ya que se empalma con un evento el día ".$res[0]['citas_fecha']." de ".substr($res[0]['citas_horainicio'],0,-2)." a ".substr($res[0]['citas_horafin'],0,-2);
    }
?>