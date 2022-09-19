<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2020
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* ADMIN EVENTOS CITAS
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('26',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('citas_ceventosusuario');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');
$xcrud->join('ceventosusuario_ceventosid', 'citas_ceventos', 'ceventos_id','e','not_insert');
$xcrud->join('ceventosusuario_cusuariosid', 'citas_cusuarios', 'cusuarios_id','u','not_insert');

$xcrud->label(
        array(
        'e.ceventos_nombre'=>'Trámite', 
        'u.cusuarios_nombre'=>'Usuario',
        'ceventosusuario_ceventosid'=>'Trámite',
        'ceventosusuario_cusuariosid'=>'Usuario'
        )
);

$xcrud->columns('e.ceventos_nombre,u.cusuarios_nombre');

//Formulario
$xcrud->relation('ceventosusuario_ceventosid','citas_ceventos','ceventos_id','ceventos_nombre');
$xcrud->relation('ceventosusuario_cusuariosid','citas_cusuarios','cusuarios_id','cusuarios_nombre');

$xcrud->fields('ceventosusuario_ceventosid,ceventosusuario_cusuariosid'); 

//Validacion
$xcrud->validation_required('ceventosusuario_ceventosid');
$xcrud->validation_required('ceventosusuario_cusuariosid');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

echo $xcrud->render();
//echo Xcrud::load_js();
?>