<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2020
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* ADMIN USUARIOS CITAS
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('25',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('citas_cusuarios');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');

$xcrud->label(
        array(
        'cusuarios_nombre'=>'Nombre Usuario',
        'cusuarios_iniciales'=>'Iniciales',
        'cusuarios_color'=>'Color'
        )
);

$xcrud->columns('cusuarios_nombre,cusuarios_iniciales');

//Formulario
$xcrud->fields('cusuarios_nombre,cusuarios_iniciales,cusuarios_color'); 

//Validacion
$xcrud->validation_required('cusuarios_nombre');
$xcrud->validation_required('cusuarios_iniciales');
$xcrud->validation_required('cusuarios_color');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

echo $xcrud->render();
//echo Xcrud::load_js();
?>