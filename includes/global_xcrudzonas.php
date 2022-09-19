<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Zonas
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('5',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_zona');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');

$xcrud->label(
        array(
        'zona_nombre'=>'Zona'
        )
);

$xcrud->columns('zona_nombre');

//Formulario
$xcrud->fields('zona_nombre'); 
//Validacion
$xcrud->validation_required('zona_nombre');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

echo $xcrud->render();
//echo Xcrud::load_js();
?>