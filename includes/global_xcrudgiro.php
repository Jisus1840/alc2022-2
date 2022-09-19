<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Giro
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('13',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_giro');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');

$xcrud->label(
        array(
        'giro_nombre'=>'Nombre',
        'giro_color'=>'Color'
        )
);

$xcrud->columns('giro_nombre');
$xcrud->columns('giro_color');

//Formulario
$xcrud->fields('giro_nombre');
$xcrud->fields('giro_color');
//Validacion
$xcrud->validation_required('giro_nombre');
$xcrud->validation_required('giro_color');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

echo $xcrud->render();
//echo Xcrud::load_js();
?>