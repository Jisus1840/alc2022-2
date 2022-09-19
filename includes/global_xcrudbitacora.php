<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Bitácora
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
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('global_bitacora');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');
//$xcrud->join('bitacora_relid', 'global_tramitevu', 'tramitevu_id','t','not_insert');

$xcrud->order_by('bitacora_id','desc');

$xcrud->label(
        array(
        'bitacora_id'=>'Id',
        'bitacora_fecha'=>'Fecha',
        'bitacora_usuario'=>'Usuario',
        'bitacora_tipo'=>'Tipo',
        'bitacora_comentario'=>'Comentario',
        )
);

$xcrud->columns(array('bitacora_fecha','bitacora_tipo','bitacora_comentario','bitacora_usuario'));

//$xcrud->columns('bitacora_fecha','bitacora_tipo','bitacora_comentario','bitacora_usuario');

$xcrud->unset_add();
$xcrud->unset_edit();
$xcrud->unset_remove();

echo $xcrud->render();
//echo Xcrud::load_js();
?>