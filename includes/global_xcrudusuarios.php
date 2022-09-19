<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
XCRUD Usuarios
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?
    $p = new permisos();
    $p->revisarpermisos('4',$usersessionpermisos);
?>
<?
include_once('../lib/xcrud/xcrud.php');
//echo Xcrud::load_css();
$xcrud = Xcrud::get_instance();
$xcrud->table('cat_usuarios');
$xcrud->limit(50);
$xcrud->unset_limitlist();
$xcrud->table_name(' ');
$xcrud->join('usuarios_perfil', 'conf_perfiles', 'perfiles_id','p','not_insert');

$xcrud->label(
        array(
        'usuarios_usuario'=>'Usuario', 
        'usuarios_password'=>'Password', 
        'usuarios_iniciales'=>'Iniciales',
        'usuarios_nombre'=>'Nombre',
        'usuarios_correo'=>'Correo',
        'p.perfiles_nombre'=>'Perfil',
        'usuarios_activo'=>'Activo'
        )
);

$xcrud->columns('usuarios_usuario,usuarios_iniciales,usuarios_nombre,usuarios_correo,p.perfiles_nombre');

//Formulario
$xcrud->relation('usuarios_perfil','conf_perfiles','perfiles_id','perfiles_nombre');
$xcrud->relation('usuarios_perfilescaneo','conf_perfiles','perfiles_id','perfiles_nombre','','perfiles_nombre',true);

$xcrud->fields('usuarios_usuario,usuarios_password,usuarios_iniciales,usuarios_nombre,usuarios_correo,usuarios_perfil,usuarios_perfilescaneo,usuarios_activo'); 

$xcrud->change_type('usuarios_password','password', 'md5', array('maxlength'=>10,'placeholder'=>''));

//Validacion
$xcrud->readonly_on_edit('usuarios_usuario');
$xcrud->readonly_on_edit('usuarios_iniciales');
$xcrud->validation_required('usuarios_usuario');
$xcrud->validation_required('usuarios_nombre');
//$xcrud->validation_required('usuarios_password');
$xcrud->validation_required('usuarios_correo');
$xcrud->validation_pattern('usuarios_correo', 'email');
$xcrud->validation_required('usuarios_iniciales');
$xcrud->validation_required('usuarios_perfil');

$xcrud->hide_button('save_new');
$xcrud->hide_button('save_edit');

echo $xcrud->render();
//echo Xcrud::load_js();
?>