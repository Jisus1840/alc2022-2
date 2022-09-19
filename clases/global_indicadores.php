<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase Indicadores
*********************************************************************************
*/
class indicadores {
    
    function getgrafica1totaltramitesporstatus ($ciclo, $fecha_inicial, $fecha_final){
		$sql = '
            select status_nombre nombre, ifnull(total,0) total  from
            (
                select tramitevu_statusid, count(*) total 
                from global_tramitevu
                where tramitevu_ciclo = '.$ciclo.'
				and tramitevu_fecha_enviado_revision between "'.$fecha_inicial.'-01 00:00:00" and "'.$fecha_final.'-31 23:59:59"
                group by tramitevu_statusid
            ) tramites
            right join conf_status on status_id = tramitevu_statusid
            union all
            select "Titulo", "Trámites" 
		';

        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
        foreach ($res as $row){
            $res2[0][$row['nombre']] = $row['total'];
        }
        return json_encode($res2);
    }
    
    function getgrafica2totalportramitesporstatus ($ciclo, $fecha_inicial, $fecha_final){
		$sql = '
            select 
                tramites.tipotramite_nombre tramite,
                (select count(*) from global_tramitevu where tramitevu_tipotramiteid = tipotramite_id and tramitevu_statusid = 1 and tramitevu_ciclo = '.$ciclo.' and tramitevu_mostrar = 1 and tramitevu_fecha_enviado_revision between "'.$fecha_inicial.'-01 00:00:00" and "'.$fecha_final.'-31 23:59:59") creado,
                (select count(*) from global_tramitevu where tramitevu_tipotramiteid = tipotramite_id and tramitevu_statusid = 2 and tramitevu_ciclo = '.$ciclo.' and tramitevu_mostrar = 1 and tramitevu_fecha_enviado_revision between "'.$fecha_inicial.'-01 00:00:00" and "'.$fecha_final.'-31 23:59:59") proceso,
                (select count(*) from global_tramitevu where tramitevu_tipotramiteid = tipotramite_id and tramitevu_statusid = 3 and tramitevu_ciclo = '.$ciclo.' and tramitevu_mostrar = 1 and tramitevu_fecha_enviado_revision between "'.$fecha_inicial.'-01 00:00:00" and "'.$fecha_final.'-31 23:59:59") finalizado,
                (select count(*) from global_tramitevu where tramitevu_tipotramiteid = tipotramite_id and tramitevu_statusid = 4 and tramitevu_ciclo = '.$ciclo.' and tramitevu_mostrar = 1 and tramitevu_fecha_enviado_revision between "'.$fecha_inicial.'-01 00:00:00" and "'.$fecha_final.'-31 23:59:59") cancelado
                from 
                    (
                        select tipotramite_id, tipotramite_nombre 
                        from conf_tipotramite 
                        where tipotramite_id in (1,7,9) 
                    ) tramites 
		';
        $db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
        return json_encode($res);
    }
	
	function getgraficatotalmontospagados($ciclo, $fecha_inicial, $fecha_final) {
		$sql = "
			select 
                tramites.tipotramite_nombre tramite, 
                (select sum(tramitevu_montopago) from global_tramitevu where tramitevu_tipotramiteid = tipotramite_id and tramitevu_fechapago like '".$ciclo."%' and tramitevu_fechapago between '".$fecha_inicial."-01 00:00:00' and '".$fecha_final."-31 23:59:59') pago_solicitud,		
				(select sum(tramitevu_montototalpago) from global_tramitevu where tramitevu_tipotramiteid = tipotramite_id and tramitevu_fechatotalpago like '".$ciclo."%' and tramitevu_fechatotalpago between '".$fecha_inicial."-01 00:00:00' and '".$fecha_final."-31 23:59:59') pago_total
                from 
                    (
                        select tipotramite_id, tipotramite_nombre 
                        from conf_tipotramite 
                        where tipotramite_id in (1,7,9)
                    ) tramites";
		$db = new DB();
		$res = $db->Ejecuta($sql);
		$db->close();
        return json_encode($res);
	}
    
}
?>