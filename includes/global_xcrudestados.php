<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Estados
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('6',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_estado');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');

$xcrud->label(
        array(
        'estado_nombre'=>'Nombre'
        )
);

$xcrud->columns('estado_nombre');

//Formulario
$xcrud->fields('estado_nombre'); 
//Validacion
$xcrud->validation_required('estado_nombre');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

$xcrud->unset_remove();

echo $xcrud->render();
//echo Xcrud::load_js();
?>