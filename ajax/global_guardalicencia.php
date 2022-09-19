<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda Licencia
* Entrada
                [foliolicencia]
                [foliolicenciaestatal]
                [nombregenerico]
                [giroid]
                [personaid]
                [personaidcomodatario]
                [domiciliolic]
                [municipioid]
                [coloniaid]
                [entrecalle]
                [yentrecalle]
                [usuarioid]  
                [lat]
                [lng]    
                [fechavencimiento]    

* Salida
                
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//Guarda Licencia
$lic = new licencias();
$lic->guardalicencia(
	$_POST['fechaalta'],
    $_POST['foliolicencia'],
    $_POST['nombregenerico'],
    $_POST['giroid'],
    $_POST['personaid'],
    $_POST['personaidcomodatario'],
    $_POST['domiciliolic'],
    $_POST['numeroext'],
    $_POST['municipioid'],
    $_POST['coloniaid'],
    $_POST['entrecalle'],
    $_POST['yentrecalle'],
    $_POST['lat'],
    $_POST['lng'],
    $_POST['usuarioid']
);

echo "Licencia guardada con éxito";
?>