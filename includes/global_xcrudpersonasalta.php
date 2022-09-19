<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Personas formulario alta
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
$xcrud->join('persona_colonia', 'cat_colonia', 'colonia_id','c','not_insert');
//$xcrud->join('c.colonia_zonaid', 'cat_zona', 'zona_id','z','not_insert');
//$xcrud->join('c.colonia_municipio', 'cat_municipio', 'municipio_id','m','not_insert');
//$xcrud->join('m.municipio_estadoid', 'cat_estado', 'estado_id','e','not_insert');

$xcrud->label(
        array(
        'persona_rfc'=>'RFC', 
        'persona_curp'=>'CURP',
        'persona_nombre'=>'Nombre', 
        'persona_direccion'=>'Dirección',
        'persona_entrecalle'=>'Entre Calle',
        'persona_yentrecalle'=>'y Calle',
        'colonia_nombre'=>'Colonia',
        'persona_colonia'=>'Colonia',
        'persona_telefono'=>'Teléfono',
        'persona_celular'=>'Celular',
        'persona_correo'=>'Correo'
        )
);

$xcrud->columns('persona_rfc,persona_nombre,persona_direccion,c.colonia_nombre');

//Formulario
$xcrud->change_type('persona_direccion','textarea');

$xcrud->relation('persona_colonia','cat_colonia','colonia_id','colonia_nombre');

//$xcrud->fields('persona_rfc,persona_nombre,persona_direccion,persona_colonia,c.colonia_cp,z.zona_nombre,m.municipio_nombre,e.estado_nombre,persona_telefono,persona_celular,persona_correo'); 
$xcrud->fields('persona_rfc,persona_curp,persona_nombre,persona_direccion,persona_entrecalle,persona_yentrecalle,persona_colonia,persona_telefono,persona_celular,persona_correo'); 
//Validacion
$xcrud->readonly_on_edit('persona_rfc');
$xcrud->validation_required('persona_rfc');
$xcrud->validation_required('persona_rfc',13);
$xcrud->validation_required('persona_curp');
$xcrud->validation_required('persona_curp',18);
$xcrud->validation_required('persona_nombre');
$xcrud->validation_required('persona_direccion');
$xcrud->validation_required('persona_colonia');
$xcrud->readonly('c.colonia_cp,z.zona_nombre,m.municipio_nombre,e.estado_nombre');
$xcrud->validation_required('persona_telefono');
$xcrud->validation_required('persona_celular');
$xcrud->validation_required('persona_correo');
$xcrud->validation_pattern('persona_correo', 'email');

$xcrud->hide_button('save_return');
$xcrud->hide_button('save_edit');
$xcrud->hide_button('return');

$bitacora = new bitacora();

$xcrud->after_insert($bitacora->guardar("CATÁLOGOS","Se agregó registro existosamente"));

echo $xcrud->render('create');
//echo Xcrud::load_js();
?>