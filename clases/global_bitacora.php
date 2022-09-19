<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase bitacora
*********************************************************************************
*/
class bitacora{
    
	function guardar($tipo,$comentario,$usuario="",$idtramite="NULL",$tramitetabla=""){
		if (isset($_SESSION['alcoholes']['usuario_info'])){
            $usersession =  unserialize($_SESSION['alcoholes']['usuario_info'])[0]['usuarios_nombre'];
        }elseif ($usuario <> ""){
            $usersession = $usuario;
        }else{
            $usersession = '';
        }
        $db = new DB();
		$sql = "insert into 
		global_bitacora 
		(
			bitacora_tipo, 
			bitacora_fecha, 
			bitacora_usuario, 
			bitacora_comentario,
            bitacora_relid,
            bitacora_relidtablajoin
		) 
		values 
		(
			'".$tipo."',
			'".date("Y-m-d H:i:s")."',
			'".$usersession."',
			'".mysqli_real_escape_string($db->conn,$comentario)."',
            ".$idtramite.",
            '".$tramitetabla."'
		)";
        
		$db->Insert($sql);
		$db->Close();
		
	}
		
	function querygetbitacora($busqueda){
		$sql = "
		select b.*
		FROM global_bitacora b ";
		if ($busqueda <> ''){
			$sql .= " where bitacora_usuario like '%".$busqueda."%' or bitacora_comentario like '%".$busqueda."%' or bitacora_tipo like '%".$busqueda."%'";
		}
		$sql .= " order by bitacora_fecha desc";
		return $sql;
	}
	
	function getbitacora(){
		$sql = "
		select b.* 
		FROM global_bitacora b
		order by bitacora_fecha desc";
		$db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
	}
    
}
?>