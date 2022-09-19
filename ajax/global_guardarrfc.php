<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GUARDA RFC
* * DATOS ENTRADA POST
						[rfctext] => rogm8402246j7
                        [nombretext] => monica sofia rodriguez garcia
                        [curptext] => 
                        [direcciontext] => irlanda 530
                        [estadotext] => COAHUILA DE ZARAGOZA
                        [estadoidtext] => 5
                        [municipiotext] => SALTILLO
                        [municipioidtext] => 66
                        [coloniatext] => Miravalle
                        [coloniaidtext] => 152
                        [entrecalletext] => 
                        [yentrecalletext] => 
                        [telefonotext] => 8
                        [celulartext] => 8
                        [correotext] => MONICA.RODRÍGUEZ@EVOTEK.COM.MX
                        
* DATOS DE SALIDA 
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$cat = new catalogos();
	$res = $cat->guardapersonayrfc(
        $_POST['rfctext'],
        $_POST['curptext'],
        $_POST['nombretext'],
        $_POST['direcciontext'],
        $_POST['direcciontextnum'],
        $_POST['entrecalletext'],
        $_POST['yentrecalletext'],
        $_POST['estadoidtext'],
        $_POST['municipioidtext'],
        $_POST['coloniaidtext'],
        $_POST['telefonotext'],
        $_POST['celulartext'],
        $_POST['correotext']
    );
?>