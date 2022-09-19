<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Parámtros de la base de datos
*********************************************************************************
*/
?>
<?
$GLOBALS['vu_global_site'] = "http://localhost/alcoholes/";

date_default_timezone_set("America/Mexico_City");

//Variables
include_once ("../config/global_variables.php");

//librerias
include_once ("../lib/tcpdf/tcpdf.php");

//Clases
include_once ("../clases/global_mysql.php");
include_once ("../clases/global_login.php");
include_once ("../clases/global_permisos.php");
include_once ("../clases/global_bitacora.php");
include_once ("../clases/global_paginacion.php");
include_once ("../clases/global_catalogos.php");
include_once ("../clases/global_ventanilla.php");
include_once ("../clases/global_tramite.php");
include_once ("../clases/global_licencias.php");
include_once ("../clases/global_gdocs.php");
include_once ("../clases/global_documentosupload.php");
include_once ("../clases/global_citas.php");
include_once ("../clases/global_calendario.php");
include_once ("../clases/global_util.php");
include_once ("../clases/global_indicadores.php");
include_once ("../clases/global_correo.php");
?>