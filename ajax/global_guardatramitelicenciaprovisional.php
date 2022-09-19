<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda Tramite licencia provisional
* Entrada
                Array
                    (
                        [usuarioid] => 23
                        [tipoevento] => hola
                        [giroid] => 15
                        fechai
                        fechaf
                        horario
                        horariofin
                        descripcion
                        [rfcsource] => ROGM8402246J7
                        [personaid] => 33
                        [personanombre] => MONICA SOFIA RORIGUEZ GARCIA
                        [direccion] => OBSIDIANA 123
                        [domiciliolic] => obsidiana 123
                        [estado] => COAHUILA DE ZARAGOZA
                        [estadoid] => 5
                        [municipio] => SALTILLO
                        [municipioid] => 66
                        [colonialic] => Miravalle
                        [colonialicid] => 152
                        [entrecallelic] => 
                        [yentrecallelic] => 
                        [lng] =>  -100.998393312601
                        usuarionombre,
                        correousuario
                        rfcusuario
                    )


* Salida
                
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?

if(isset($_POST['tramiteid'])) {
	$vu = new ventanilla();
	$vu->actualizar_permiso(
		$_POST['tipoevento'],
		$_POST['giroid'],
		$_POST['fechai'],
		$_POST['fechaf'],
		$_POST['horario'],
		$_POST['horariofin'],
		$_POST['descripcion'],
		$_POST['personaid'],
		$_POST['domiciliolic'],
		$_POST['domiciliolicnumext'],
		$_POST['municipioid'],
		$_POST['colonialicid'],
		$_POST['entrecallelic'],
		$_POST['yentrecallelic'],
		$_POST['lat'],
		$_POST['lng'],
		$_POST['tramiteid']
	);
	echo "1|Registro actualizado correctamente";
}
else {
	//Guarda Ventanilla
	$vu = new ventanilla();
	$lastid = $vu->guardar($_POST['usuarioid'],7,1,1,date("Y-m-d H:i:s"),'',$_POST['correousuario'],$_POST['rfcusuario'],'null');

	//Guarda Licencia
	$tramite = new tramite();
	$lastidsolicitud = $tramite->guardarsolicitudlicenciaprovisional(
		$_POST['tipoevento'],
		$_POST['giroid'],
		$_POST['fechai'],
		$_POST['fechaf'],
		$_POST['horario'],
		$_POST['horariofin'],
		$_POST['descripcion'],
		$_POST['personaid'],
		$_POST['domiciliolic'],
		$_POST['domiciliolicnumext'],
		$_POST['municipioid'],
		$_POST['colonialicid'],
		$_POST['entrecallelic'],
		$_POST['yentrecallelic'],
		$_POST['lat'],
		$_POST['lng'],
		$lastid,
		$_POST['usuarioid'],
		$_POST['usuarionombre'],
		$_POST['correousuario'],
		$_POST['rfcusuario']
	);
	//consulta folio
	$folio = tramite::getfoliotramite($lastid);
	$hora = tramite::gethorainiciotramite($lastid);
	echo "1|".$folio."|".$hora;
}
?>