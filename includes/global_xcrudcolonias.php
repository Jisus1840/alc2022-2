<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Colonias
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('7',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_colonia');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');
$xcrud->join('colonia_zonaid', 'cat_zona', 'zona_id','z','not_insert');
$xcrud->join('colonia_municipio', 'cat_municipio', 'municipio_id','m','not_insert');
$xcrud->join('colonia_coloniatipoid', 'cat_coloniatipo', 'coloniatipo_id','ct','not_insert');

$xcrud->label(
        array(
        'colonia_nombre'=>'Colonia', 
        'ct.coloniatipo_nombre'=>'Tipo', 
        'z.zona_nombre'=>'Zona',
        'colonia_cp'=>'CP',
        'm.municipio_nombre'=>'Municipio'
        )
);

$xcrud->columns('colonia_nombre,ct.coloniatipo_nombre,z.zona_nombre,colonia_cp,m.municipio_nombre');

//Formulario
$xcrud->relation('colonia_zonaid','cat_zona','zona_id','zona_nombre');
$xcrud->relation('colonia_municipio','cat_municipio','municipio_id','municipio_nombre','municipio_estadoid=5');
$xcrud->relation('colonia_coloniatipoid','cat_coloniatipo','coloniatipo_id','coloniatipo_nombre');

$xcrud->fields('colonia_coloniatipoid,colonia_nombre,colonia_zonaid,colonia_cp,colonia_municipio'); 

//Validacion
$xcrud->readonly_on_edit('persona_rfc');
$xcrud->validation_required('persona_rfc');
$xcrud->validation_required('persona_rfc',13);
$xcrud->validation_required('persona_nombre');
$xcrud->validation_required('persona_direccion');
$xcrud->validation_required('persona_colonia');
$xcrud->validation_required('persona_telefono');
$xcrud->validation_required('persona_celular');
$xcrud->validation_required('persona_correo');
$xcrud->validation_pattern('persona_correo', 'email');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

echo $xcrud->render();
//echo Xcrud::load_js();
?>