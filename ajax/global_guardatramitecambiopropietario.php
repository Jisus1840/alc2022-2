<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ajax Guarda Tramite cambio propietario
* Entrada
                [licenciaid]
                [pnuevoid]
                [panteriorid]
                [usuarioid]
                [bandera] => 1
                [curp] => ROGM8402246J7UIJKS
                [personanombre] => MONICA SOFIA RORIGUEZ GARCIA
                [direccion] => OBSIDIANA 123
                [colonia] => Miravalle
                [coloniaid] => 152
                [entrecalle] => OBSIDIANA
                [yentrecalle] => TOPACIO
                [telefono] => 8441221249
                [celular] => 8441221249
                [correo] => RDZGARCIAMONICA@GMAIL.COM
* Salida
                
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
//Guarda Ventanilla
$vu = new ventanilla();
$lastid = $vu->guardar($_POST['usuarioid'],4,1,7,date("Y-m-d H:i:s"));

//Si no existe propietario en persona lo guarda en la base de datos
if ($_POST['bandera'] == 0 and $_POST['pnuevo'] <> ''){
    $catalogo = new catalogos();
    $personaid = $catalogo->guardapersona($_POST['pnuevo'],$_POST['curp'],$_POST['personanombre'],$_POST['direccion'],$_POST['entrecalle'],$_POST['yentrecalle'],$_POST['coloniaid'],$_POST['telefono'],$_POST['celular'],$_POST['correo']);
}else{
    $personaid = $_POST['pnuevoid'];
}

$tramite = new tramite();
$lastidsolicitud = $tramite->guardarcambiopropietario(
    $lastid,
    $_POST['licenciaid'],
    $_POST['panteriorid'],
    $_POST['pnuevoid'],
    $_POST['usuarioid']
);
//consulta folio
$folio = tramite::getfoliotramite($lastid);
$hora = tramite::gethorainiciotramite($lastid);
echo "1|".$folio."|".$hora;
?>