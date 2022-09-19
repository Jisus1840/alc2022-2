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
    $p->revisarpermisos('24',$usersessionpermisos);
?>
<style>
    input, textarea {
        text-transform: uppercase;
    }
</style>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('citas_ceventos');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');

$xcrud->label(
        array(
        'ceventos_nombre'=>'Trámite', 
        'ceventos_duracionminutos'=>'Duración Minutos'
        )
);

$xcrud->columns('ceventos_nombre,ceventos_duracionminutos');

//Formulario
$xcrud->fields('ceventos_nombre,ceventos_duracionminutos'); 

//Validacion
$xcrud->validation_required('ceventos_nombre');
$xcrud->validation_required('ceventos_duracionminutos');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

echo $xcrud->render();
//echo Xcrud::load_js();
?>