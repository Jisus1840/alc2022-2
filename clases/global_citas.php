<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase Citas
*********************************************************************************
*/
?>
<?
class citas{
    
    //Get all Citas
    
    function getqueryallcitas($busqueda=""){
        $sql = "
        select * 
        from citas_citas
        left join citas_ceventos on ceventos_id = citas_ceventosid
        left join citas_cusuarios on cusuarios_id = citas_cusuariosid
        where 1 = 1 ";
        if ($busqueda <> ""){
             $res = json_decode(base64_decode($busqueda),true); 
                
            if ($res['bsqfecha'] <> '' and $res['bsqfecha'] <> 'null'){
                $sql.= " and (citas_fecha = '".$res['bsqfecha']."')";
            }
            if ($res['bsqevento'] <> '' and $res['bsqevento'] <> 'null'){
                $sql.= " and (citas_ceventosid = '".$res['bsqevento']."')";
            }
            if ($res['bsqusuario'] <> '' and $res['bsqusuario'] <> 'null'){
                $sql.= " and (citas_cusuariosid = '".$res['bsqusuario']."')";
            }
        }
        $sql .= " order by citas_fecha desc";
        return $sql;
    }
    
    function getinfocitabyid($citaid){
        $sql = "
        select * 
        from citas_citas
        left join citas_ceventos on ceventos_id = citas_ceventosid
        left join citas_cusuarios on cusuarios_id = citas_cusuariosid
        where citas_id = ".$citaid;
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
    
    //Get Eventos 
    function geteventosactivos(){
        $sql = "
            select * from 
            citas_ceventos
            where ceventos_activo = 1
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
    
    //Get usuarios por evento
    function getusuariosactivosbyeventoid($eventoid){
        $sql = "
            SELECT ceventosusuario_cusuariosid, cusuarios_nombre
            FROM citas_ceventosusuario 
            left join citas_cusuarios on cusuarios_id = ceventosusuario_cusuariosid
            ";
        if ($eventoid <> ''){
            $sql .= " where ceventosusuario_ceventosid = ".$eventoid;
        }
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
    
    //Get Horas Disponibles x evento y fecha
    function gethorasdisponibles($eventoid,$asesorid,$fecha){
        $horas = array('09:00','09:15','09:30','10:00');
        /*
        //Validar q este de Lunes A Viernes        
        $dayweek = date("W", strtotime($fecha));
        if ($dayweek <> 0 and $dayweek <> 6){
            $horas[0] = '1:00';
            
        }
        */
        return $horas;
    }
    
    function getduracioneventobyid($eventoid){
        $sql = "
            SELECT ceventos_duracionminutos FROM alcoholes.citas_ceventos where ceventos_id = ".$eventoid;
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res[0]['ceventos_duracionminutos'];
    }
    
    function guardacita ($statusid,$nombresolicitante, $correosolicitante, $descripcionsolicitante, $eventoid, $asesorid, $fecha, $horai, $horaf, $tramitevuid="null"){
        $sql = "
            insert into
            citas_citas
            (
                citas_fechacreacion,
                citas_ceventosid,
                citas_cusuariosid,
                citas_cstatusid,
                citas_descripcionsolicitante,
                citas_nombresolicitante,
                citas_correosolicitante,
                citas_fecha,
                citas_horainicio,
                citas_horafin,
                citas_tramitevuid
            )
            values
            (
                '".date("Y-m-d H:i:s")."',
                ".$eventoid.",
                ".$asesorid.",
                ".$statusid.",
                '".$descripcionsolicitante."',
                '".$nombresolicitante."',
                '".$correosolicitante."',
                '".$fecha."',
                '".$horai."',
                '".$horaf."',
                ".(($tramitevuid==0)?'null':$tramitevuid)."
            )
            ";
        $db = new DB();
		$res = $db->Insert($sql);
		$db->close();
        
        //Bitacora
        $bitacora = new bitacora();
        $bitacora->guardar('CITAS','SE AGREGÓ CITA: '.$descripcionsolicitante,'',($tramitevuid == 0)?'null':$tramitevuid,'global_tramitevu');
        
    }
    
    function eliminar($citaid,$tramitevuid=''){
        $sql = "
        delete
        from citas_citas 
        where
        citas_id = ".$citaid."
        ";
        
        $db = new DB();
		$db->Insert($sql);
        
        if ($tramitevuid <> ''){
            $sql = "
            update global_tramitevu
            set tramitevu_cita = null
            where tramitevu_id = ".$tramitevuid."
            ";
            $db->Insert($sql);
        }
        
		$db->close();
        
        //Bitacora
        $bitacora = new bitacora();
        $bitacora->guardar('CITAS','SE ELIMINÓ CITA: ','',($tramitevuid == '')?'null':$tramitevuid,'global_tramitevu');
        
    }
    
    function getallcitasbyanioandmes($anio,$mes){
        $sql = "
        select 
        day(citas_fecha) dia, 
        month(citas_fecha) mes, 
        year(citas_fecha) anio, 
        c.* , e.*, u.* 
        from citas_citas c
        left join citas_ceventos e on ceventos_id = citas_ceventosid
        left join citas_cusuarios u on cusuarios_id = citas_cusuariosid
        where
        month(citas_fecha) = ".$mes." 
        and year(citas_fecha) = ".$anio."
        order by citas_fecha, citas_horainicio asc
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
    
    function getallcitasbyanioandmesdia($anio,$mes,$dia){
        $sql = "
        select 
        day(citas_fecha) dia, 
        month(citas_fecha) mes, 
        year(citas_fecha) anio, 
        c.* , e.*, u.* 
        from citas_citas c
        left join citas_ceventos e on ceventos_id = citas_ceventosid
        left join citas_cusuarios u on cusuarios_id = citas_cusuariosid
        where
        month(citas_fecha) = ".$mes." 
        and year(citas_fecha) = ".$anio."
        and day(citas_fecha) = ".$dia."
        order by citas_fecha, citas_horainicio asc
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
    
    function getusuariocitasbyanioandmes($anio,$mes,$usuario){
        $sql = "
        select 
        day(citas_fecha) dia, 
        month(citas_fecha) mes, 
        year(citas_fecha) anio, 
        c.* , e.*, u.* 
        from citas_citas c
        left join citas_ceventos e on ceventos_id = citas_ceventosid
        left join citas_cusuarios u on cusuarios_id = citas_cusuariosid
        where
        month(citas_fecha) = ".$mes." 
        and year(citas_fecha) = ".$anio."
        and cusuarios_id) = ".$usuario."
        order by citas_fecha, citas_horainicio asc
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
    
    function getusuariocitasbyanioandmesdia($anio,$mes,$dia,$usuario){
        $sql = "
        select 
        day(citas_fecha) dia, 
        month(citas_fecha) mes, 
        year(citas_fecha) anio, 
        c.* , e.*, u.* 
        from citas_citas c
        left join citas_ceventos e on ceventos_id = citas_ceventosid
        left join citas_cusuarios u on cusuarios_id = citas_cusuariosid
        where
        month(citas_fecha) = ".$mes." 
        and year(citas_fecha) = ".$anio."
        and day(citas_fecha) = ".$dia."
        and cusuarios_id) = ".$usuario."
        order by citas_fecha, citas_horainicio asc
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
    
    function checkdisponibilidad($fecha, $hi, $hf, $usuario){
        $sql= "
        SELECT 
          * 
        FROM 
          citas_citas 
        WHERE 
          citas_fecha  = '".$fecha."' AND 
          ('".$hi."' >= citas_horainicio AND '".$hi."' < citas_horafin OR 
          (citas_horainicio >= '".$hi."' AND citas_horainicio < '".$hf."'))
          and citas_cusuariosid = ".$usuario."
        ";
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
		return $res;
    }
}