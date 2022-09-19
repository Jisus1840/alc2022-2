<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* MODIFICADO: ANGELA SANCHEZ
* Ajax Guarda Trámite Cambios
                
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<?
//Gral
$usuarioid = $_POST['usuarioid'];
$licenciaid = $_POST['licenciaid'];

$adomiciliolic = (isset($_POST['adomiciliolic']) && $_POST['adomiciliolic'] != '')?"'".$_POST['adomiciliolic']."'":"NULL";
$aestado = (isset($_POST['aestado']) && $_POST['aestado'] != '')?"'".$_POST['aestado']."'":"NULL";
$aestadoid = (isset($_POST['aestadoid']) && $_POST['aestadoid'] != '')?"'".$_POST['aestadoid']."'":"NULL";
$amunicipio = (isset($_POST['amunicipio']) && $_POST['amunicipio'] != '')?"'".$_POST['amunicipio']."'":"NULL";
$amunicipioid = (isset($_POST['amunicipioid']) && $_POST['amunicipioid'] != '')?"'".$_POST['amunicipioid']."'":"NULL";
$acolonia = (isset($_POST['acolonia']) && $_POST['acolonia'] != '')?"'".$_POST['acolonia']."'":"NULL";
$acoloniaid = (isset($_POST['acoloniaid']) && $_POST['acoloniaid'] != '')?"'".$_POST['acoloniaid']."'":"NULL";
$aentrecalle = (isset($_POST['aentrecalle']) && $_POST['aentrecalle'] != '')?"'".$_POST['aentrecalle']."'":"NULL";
$ayentrecalle = (isset($_POST['ayentrecalle']) && $_POST['ayentrecalle'] != '')?"'".$_POST['ayentrecalle']."'":"NULL";
$alatitud = (isset($_POST['alatitud']) && $_POST['alatitud'] != '')?"'".$_POST['alatitud']."'":"NULL";
$alongitud = (isset($_POST['alongitud']) && $_POST['alongitud'] != '')?"'".$_POST['alongitud']."'":"NULL";
$pnuevo = (isset($_POST['pnuevo']) && $_POST['pnuevo'] != '')?"'".$_POST['pnuevo']."'":"NULL";
$pnuevoid = (isset($_POST['pnuevoid']) && $_POST['pnuevoid'] != '')?"'".$_POST['pnuevoid']."'":"NULL";
$cnuevo = (isset($_POST['cnuevo']) && $_POST['cnuevo'] != '')?"'".$_POST['cnuevo']."'":"NULL";
$cnuevoid = (isset($_POST['cnuevoid']) && $_POST['cnuevoid'] != '')?"'".$_POST['cnuevoid']."'":"NULL";
$nombregnuevo = (isset($_POST['nombregnuevo']) && $_POST['nombregnuevo'] != '')?"'".$_POST['nombregnuevo']."'":"NULL";
$giroid = (isset($_POST['giroid']) && $_POST['giroid'] != '')?"'".$_POST['giroid']."'":"NULL";
$tipolicenciaid = (isset($_POST['tipolicenciaid']) && $_POST['tipolicenciaid'] != '')?"'".$_POST['tipolicenciaid']."'":"NULL";

$lic = new licencias();
$res = $lic->update(
    $licenciaid,
    $pnuevoid,
    $cnuevoid,
    $nombregnuevo,
    $giroid,
    $adomiciliolic,
    $acoloniaid,
    $aentrecalle,
    $ayentrecalle,
    $alatitud,
    $alongitud,
    $tipolicenciaid
    
);
?>