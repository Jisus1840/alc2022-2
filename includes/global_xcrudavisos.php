<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: ANGÉLICA MARÍA RODRÍGUEZ CABELLO
XCRUD Avisos
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_headerxcrud.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2012',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');

$xcrud = Xcrud::get_instance();
$xcrud->table('conf_avisos');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');

$xcrud->change_type('imagen', 'file', '', array('path' =>'../../avisos/', 'not_rename'=>false));
$xcrud->fields('fecha, resumen_aviso, imagen');
$xcrud->columns('fecha, resumen_aviso, imagen');
$xcrud->order_by('fecha','desc');	
$xcrud->validation_required('imagen, fecha, resumen_aviso');
$xcrud->label(array('fecha' => 'Fecha del aviso', 'resumen_aviso' => 'Resumen del aviso', 'imagen' => 'Archivo del aviso'));		

$xcrud->unset_csv();
$xcrud->unset_print();
$xcrud->unset_search();

echo $xcrud->render();
?>