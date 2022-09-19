<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD RFC
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('33',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_rfc');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');

$xcrud->label(
        array(
        'rfc_rfc'=>'RFC'
        )
);

$xcrud->columns('rfc_rfc');
$xcrud->fields('rfc_rfc');
//Validacion
$xcrud->readonly_on_edit('rfc_rfc');
$xcrud->validation_required('rfc_rfc',12);

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

$bitacora = new bitacora();

$xcrud->after_insert($bitacora->guardar("CATÁLOGOS","Se agregó registro existosamente"));
$xcrud->after_update($bitacora->guardar("CATÁLOGOS","Se modificó registro existosamente"));
$xcrud->after_remove($bitacora->guardar("CATÁLOGOS","Se elimino registro existosamente"));

echo $xcrud->render();
//echo Xcrud::load_js();
?>
