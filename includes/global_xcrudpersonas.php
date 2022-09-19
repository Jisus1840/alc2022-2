<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Personas
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('3',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_persona');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');
$xcrud->join('persona_rfcid', 'cat_rfc', 'rfc_id','r','not_insert');
$xcrud->join('persona_colonia', 'cat_colonia', 'colonia_id','c','not_insert');
//$xcrud->join('c.colonia_zonaid', 'cat_zona', 'zona_id','z','not_insert');
//$xcrud->join('c.colonia_municipio', 'cat_municipio', 'municipio_id','m','not_insert');
//$xcrud->join('m.municipio_estadoid', 'cat_estado', 'estado_id','e','not_insert');

$xcrud->label(
        array(
        'r.rfc_rfc'=>'RFC',
        'persona_rfcid'=>'RFC',
        'persona_curp'=>'CURP',
        'persona_razonsocial'=>'Nombre',
        'persona_direccion'=>'Dirección',
        'persona_entrecalle'=>'Entre Calle',
        'persona_yentrecalle'=>'y Calle',
        'c.colonia_nombre'=>'Colonia',
        'persona_colonia'=>'Colonia',
        'persona_telefono'=>'Teléfono',
        'persona_celular'=>'Celular',
        'persona_correo'=>'Correo'
        )
);

$xcrud->columns('r.rfc_rfc,persona_razonsocial,persona_direccion,c.colonia_nombre');

//Formulario
$xcrud->change_type('persona_direccion','textarea');

$xcrud->relation('persona_rfcid','cat_rfc','rfc_id','rfc_rfc');
$xcrud->relation('persona_colonia','cat_colonia','colonia_id','colonia_nombre');

//$xcrud->fields('persona_rfc,persona_nombre,persona_direccion,persona_colonia,c.colonia_cp,z.zona_nombre,m.municipio_nombre,e.estado_nombre,persona_telefono,persona_celular,persona_correo'); 
$xcrud->fields('persona_rfcid,persona_curp,persona_direccion,persona_entrecalle,persona_yentrecalle,persona_colonia,persona_telefono,persona_celular,persona_correo');
//Validacion
$xcrud->readonly_on_edit('persona_rfc');
$xcrud->validation_required('persona_direccion');
$xcrud->validation_required('persona_colonia');
$xcrud->readonly('c.colonia_cp,z.zona_nombre,m.municipio_nombre,e.estado_nombre');
$xcrud->validation_required('persona_telefono');
$xcrud->validation_required('persona_celular');
$xcrud->validation_required('persona_correo');
$xcrud->validation_pattern('persona_correo', 'email');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

$bitacora = new bitacora();

$xcrud->after_insert($bitacora->guardar("CATÁLOGOS","Se agregó registro existosamente"));
$xcrud->after_update($bitacora->guardar("CATÁLOGOS","Se modificó registro existosamente"));
$xcrud->after_remove($bitacora->guardar("CATÁLOGOS","Se elimino registro existosamente"));

echo $xcrud->render();
//echo Xcrud::load_js();
?>
