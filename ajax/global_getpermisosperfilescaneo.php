<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* XAJAX GET PERMISOS DE PERFIL PARA ESCANEO
* * DATOS ENTRADA
* DATOS DE SALIDA JSON	id
						nombre
* Catalogo cat_usuarios
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<?php
	$catalogos = new catalogos();
	$res = $catalogos->getpermisosperfilescaneo($usersession[0]['usuarios_perfilescaneo'],$usersession[0]['usuarios_perfil']);
	$array = array();
	$i=0;
	if ($res != 0){
		foreach ($res as $row){
			$array[$i] = 
				array(
					"id"=>$row['perfiles_id'],
					"nombre"=>$row['perfiles_nombre']
				);
			$i++;
		}
	}else{
		$array[0] = array(
					"id"=>'',
					"nombre"=>''
				);
	}
echo json_encode($array);
?>