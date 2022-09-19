<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase Login
*********************************************************************************
*/
class loginuser {
    function acceso ($usuario,$pwd){
		$sql = "
		select 
		u.*, p.perfiles_nombre perfil_nombre
		from cat_usuarios u
		left join conf_perfiles p on u.usuarios_perfil = p.perfiles_id
		where u.usuarios_usuario='".$usuario."' 
		and usuarios_password = MD5('".$pwd."')
		and usuarios_activo = 1
		";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
        
        if ($res <> 0){
            if($res[0]['usuarios_id'] <> ''){
                $_SESSION['alcoholes']['usuario_info'] = serialize($res);
                $_SESSION['alcoholes']['perfil_escaneo'] = $res[0]['usuarios_perfil'];
                
                //consulta permisos de codigo
                $sql2 = "
                select 
                permisosusuario_codigo
                from conf_permisosusuario
                where 
                permisosusuario_usuariosid = ".$res[0]['usuarios_id'];
                $db = new DB();
                $res2 = $db->Ejecuta($sql2);
                $db->close();
                
                $array = array();
                $i = 0;
                if ($res2 <> ''){
                    
                    foreach ($res2 as $r){
                        $array[$i] = $r['permisosusuario_codigo'];
                        $i++;
                    }
                    
                    $_SESSION['alcoholes']['permisos'] = serialize($array);
                    
                    $bitacora = new bitacora();
                    $bitacora->guardar('LOGIN','Acceso usuario: '.$usuario,$res[0]['usuarios_nombre']);
                    echo 1;

                }else{
                    $bitacora = new bitacora();
                    $bitacora->guardar('LOGIN','Error acceso a usuario: '.$usuario);
                    echo "Usuario no cuenta con ningún permiso de acceso";
                }
            }else{
                $bitacora = new bitacora();
                $bitacora->guardar('LOGIN','Error acceso a usuario: '.$usuario);
                echo "Usuario no válido";
            }
        }else{
            $bitacora = new bitacora();
            $bitacora->guardar('LOGIN','Error acceso a usuario: '.$usuario);
            echo "Usuario no válido";
        }
	}   
}

class loginext {
	function acceso ($correo,$rfc,$pagina){
		$usuario = array();
        $usuario[0]['correoexterno'] = $correo;
        $usuario[0]['rfcexterno'] = $rfc;
		$usuario[0]['pagina'] = $pagina;
        $_SESSION['alcoholesext']['usuarioext_info'] = serialize($usuario);
        echo 1;
	}
}
?>