<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase catalogos
*********************************************************************************
*/
?>
<?
class permisos{
	
	function updatepermisos($idusuario,$idmenu,$permiso){
		//Valida si inserta o elimnina
        if ($permiso == "true"){
            //Inserta en la BD
            $db = new DB();
            $sql = "
            insert into conf_permisosusuario
            (
                permisosusuario_usuariosid,
                permisosusuario_codigo
            )
            values
            (
                ".$idusuario.",
                ".$idmenu."
            )
            ";
            $db->Insert($sql);
            $db->Close();
            
            $bitacora = new bitacora();
            $bitacora->guardar('PERMISOS','Se agregó permiso: '.$idmenu);
            
        }else{
            //Elimina de la BD
            $db = new DB();
            $sql = "
            delete from conf_permisosusuario
            where
                permisosusuario_usuariosid = ".$idusuario." and 
                permisosusuario_codigo = ".$idmenu."
            ";
            $db->Insert($sql);
            $db->Close();
            
            $bitacora = new bitacora();
            $bitacora->guardar('PERMISOS','Se eliminó permiso: '.$idmenu);
            
        }
	}
	
    function getpermisosbyusuarioid($idusuario){
        $db = new DB();
        $sql = "
        select * from conf_permisosusuario
        where
            permisosusuario_usuariosid = ".$idusuario;
        $res = $db->Ejecuta($sql);
        $db->Close();
        return $res;
    }
    
    function revisarpermisos($pagina,$arraypermisos){
        
        if (!in_array($pagina, $arraypermisos)) {
            echo '<i class="icon-warning"></i> No cuentas con suficientes privilegios para ver esta página';
            die;
        }
    }
    
}
?>