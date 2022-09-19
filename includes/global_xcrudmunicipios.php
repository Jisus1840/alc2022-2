<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Municipios
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('8',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_municipio');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');
$xcrud->join('municipio_estadoid', 'cat_estado', 'estado_id','e','not_insert');

$xcrud->label(
        array(
        'municipio_nombre'=>'Municipio', 
        'e.estado_nombre'=>'Estado'
        )
);

$xcrud->columns('municipio_nombre,e.estado_nombre');

//Formulario
$xcrud->change_type('persona_direccion','textarea');

$xcrud->relation('municipio_estadoid','cat_estado','estado_id','estado_nombre');

$xcrud->fields('municipio_nombre,municipio_estadoid'); 
//Validacion
$xcrud->validation_required('municipio_nombre');
$xcrud->validation_required('municipio_estadoid');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

$xcrud->unset_remove();

echo $xcrud->render();
//echo Xcrud::load_js();
?>