<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase de consulta de catálogos
*********************************************************************************
*/
?>
<?
class catalogos{

    function gettramitesactivos(){
        $db = new DB();
        $sql = "
        select * from conf_tipotramite where tipotramite_activo = 1 order by tipotramite_orden
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function getusuariosactivos($busqueda){
        $db = new DB();
        $sql = "
        select * from cat_usuarios where usuarios_activo = 1 and usuarios_nombre like '%".$busqueda."%'
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

    public static function getnombreusuariobyid($id){
        $db = new DB();
        $sql = "
        select * from cat_usuarios where usuarios_id = ".$id."
        ";
        $res = $db->Ejecuta($sql);
        return $res[0]['usuarios_nombre'];
    }

    function getpermisosperfilescaneo($perfiles,$perfilid){
        $db = new DB();
        if ($perfiles == ''){
            $sql2 = "
            select * from conf_perfiles where perfiles_id = ".$perfilid."
            ";
            $res = $db->Ejecuta($sql2);
        }else{
            $sql = "
            select * from conf_perfiles where perfiles_id in (".$perfiles.")
            ";
            $res = $db->Ejecuta($sql);
        }
        return $res;
    }

    function getpersonas($busqueda){
        $db = new DB();
        $sql = "
        select p.*, c.*, rfc_rfc persona_rfc, persona_razonsocial persona_nombre from cat_persona p
        left join cat_rfc r on rfc_id = persona_rfcid
        left join cat_colonia c on colonia_id = persona_colonia
        where rfc_rfc like '%".$busqueda."%' or persona_razonsocial like '%".$busqueda."%' 
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function getpersonabyrfc($rfc){
        $db = new DB();
        $sql = "
        select p.*, c.*, z.*, rfc_rfc persona_rfc, persona_razonsocial persona_nombre from cat_persona p
        left join cat_rfc r on rfc_id = persona_rfcid
        left join cat_colonia c on colonia_id = persona_colonia
        left join cat_zona z on zona_id = colonia_zonaid
        where rfc_rfc = '".$rfc."'
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function guardapersona($rfc,$curp,$nombre,$direccion,$entrecalle,$yentrecalle,$colonia,$telefono,$celular,$correo){
        $db = new DB();
        $sql = "
        insert into cat_persona
        (
            persona_rfc,
            persona_curp,
            persona_nombre,
            persona_direccion,
            persona_entrecalle,
            persona_yentrecalle,
            persona_colonia,
            persona_telefono,
            persona_celular,
            persona_correo
        )
        values
        (
            '".$rfc."',
            '".$curp."',
            '".$nombre."',
            '".$direccion."',
            '".$entrecalle."',
            '".$yentrecalle."',
            ".$colonia.",
            '".$telefono."',
            '".$celular."',
            '".$correo."'
        )
        ";
        $db->Insert($sql);

        //LAST INSERT ID
		$sql2 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql2);
		$lastinsert = $resultsql[0]['lastinsert'];

        return $lastinsert;

    }

    function guardapersonayrfc($rfc,$curp,$nombre,$direccion,$direccionnumext,$entrecalle,$yentrecalle,$estado,$municipio,$colonia,$telefono,$celular,$correo){
        $db = new DB();

        $sql0 = "
            select rfc_id from cat_rfc where rfc_rfc = '".$rfc."'
        ";
        $res0 = $db->Ejecuta($sql0);

        if ($res0 == ''){
            //Si no lo encontro inserta y retorna id
            $sql1 = "
            insert into cat_rfc
            (rfc_rfc)
                values
            ('".util::strupper($rfc)."')
            ";
            $db->Insert($sql1);
            //LAST INSERT ID
            $sql2 = "SELECT LAST_INSERT_ID() lastinsert";
            $resultsql = $db->Ejecuta($sql2);
            $rfcid = $resultsql[0]['lastinsert'];
        }else{
            $rfcid = $res0[0]['rfc_id'];
        }

        $sql3 = "
        insert into cat_persona
        (
            persona_rfcid,
            persona_razonsocial,
            persona_curp,
            persona_direccion,
			persona_direccion_numero,
            persona_entrecalle,
            persona_yentrecalle,
            persona_estadoid,
            persona_municipioid,
            persona_colonia,
            persona_telefono,
            persona_celular,
            persona_correo
        )
        values
        (
            ".$rfcid.",
            '".util::strupper($nombre)."',
            '".util::strupper($curp)."',
            '".util::strupper($direccion)."',
            '".util::strupper($direccionnumext)."',
            '".util::strupper($entrecalle)."',
            '".util::strupper($yentrecalle)."',
            ".$estado.",
            ".$municipio.",
            ".(($colonia == '')?'null':$colonia).",
            '".$telefono."',
            '".$celular."',
            '".util::strupper($correo)."'
        )
        ";
        $db->Insert($sql3);

        //LAST INSERT ID
		$sql4 = "SELECT LAST_INSERT_ID() lastinsert";
		$resultsql = $db->Ejecuta($sql4);
		$lastinsert = $resultsql[0]['lastinsert'];

        return $lastinsert;
    }

    function getestados($busqueda){
        $db = new DB();
        $sql = "
        select * from cat_estado
        where estado_nombre like '%".$busqueda."%' order by estado_nombre asc
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function getmunicipios($busqueda,$estadoid){
        $db = new DB();
        $sql = "
        select * from cat_municipio
        where municipio_nombre like '%".$busqueda."%'
        and municipio_estadoid = ".$estadoid."
        order by municipio_nombre asc
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function getcolonias($busqueda,$municipioid){
        $db = new DB();
        $sql = "
        select * from cat_colonia
        where colonia_nombre like '%".$busqueda."%'
        and colonia_municipio = ".$municipioid."
        order by colonia_nombre asc
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }
	
	function getcoloniasbycp($codigo_postal='',$municipioid){
		$where = "";
		if($codigo_postal != '') {
			$where = " and colonia_cp = ".$codigo_postal;
		}
        $db = new DB();
        $sql = "
        select * from cat_colonia
        where colonia_municipio = ".$municipioid.$where." 
        order by colonia_nombre asc
        ";
        $res = $db->Ejecuta($sql);
		
		if($res == 0) {
			$sql = "
			select * from cat_colonia
			where colonia_municipio = ".$municipioid." 
			order by colonia_nombre asc
			";
			$res = $db->Ejecuta($sql);
		}
        return $res;
    }

    function getgiro($giro_id=''){
		if($giro_id) {
			$where = "where giro_id = ".$giro_id;
		}
        $db = new DB();
        $sql = "
        select * from cat_giro ".$where." 
        order by giro_nombre asc
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

    function getcomodatario($busqueda){
        $db = new DB();
        $sql = "
        select p.*, c.*, rfc_rfc persona_rfc, persona_razonsocial persona_nombre from cat_persona p
        left join cat_rfc r on rfc_id = persona_rfcid
        left join cat_colonia c on colonia_id = persona_colonia
        where persona_razonsocial like '%".$busqueda."%'
        ";
        $res = $db->Ejecuta($sql);
        return $res;

    }

    function gettipolicencia(){
        $db = new DB();
        $sql = "
        select * from cat_tipolicencia order by tipolicencia_nombre asc
        ";
        $res = $db->Ejecuta($sql);
        return $res;
    }

}
