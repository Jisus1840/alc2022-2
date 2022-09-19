<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver historial del trámite
entrada
    tramitevuid
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>

<?
$v = new ventanilla();
$res = $v->gethistorialtramite($_GET['tramitevuid']);
$grafica = $v->jsongraficahistorico($_GET['tramitevuid']);
$grafica2 = $v->jsongraficahistorico2($_GET['tramitevuid']);
$historial_cancelacion = $v->gethistorialcancelacion($_GET['tramitevuid']);
?>

<style>
    #charthistorialtramite {
        width: 100%;
        height: 200px;
        font-size: 8px;
    }
</style>

<script src="../lib/amcharts4/core.js"></script>
<script src="../lib/amcharts4/charts.js"></script>
<script src="../lib/amcharts4/themes/animated.js"></script>

<script language="javascript">

    $(document).ajaxStart(function() {
        $("#loading").show();
    });

    $(document).ready(function(){
        
    });

    $(document).ajaxStop(function() {
        $("#loading").hide();
    });
</script>


<?php 
	if($historial_cancelacion) {
		echo '<p style="text-align: center;"><b>Motivo de cancelación:</b> '.$historial_cancelacion[0]['motivo_cancelacion'].'<br>
		<b>Fecha de cancelación: </b>'.$historial_cancelacion[0]['fecha_cancelacion'].'<br>
		<b>Cancelado por: </b>'.$historial_cancelacion[0]['usuarios_nombre'].'<br>
		</p>
		';
	}
?> 

<table class="table table-striped" style="text-align: center">
    <thead>
        <tr>
            <th width="50px" style="text-align: center;">Tramite</th>
            <th width="50px" style="text-align: center;">Fecha Inicio</th>
            <th width="50px" style="text-align: center;">Fecha Fin</th>
            <th width="50px" style="text-align: center;">Duración Minutos</th>
            <th width="50px" style="text-align: center;">Flujo</th>
            <th width="50px" style="text-align: center;">Usuario</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($res as $row){ ?>
            <tr>
                <td><?=$row['tramitevu_folio']?></td>
                <td><?=$row['historialvu_fechainicio']?></td>
                <td><?=$row['historialvu_fechafin']?></td>
                <td><?=$row['historialvu_tiempominutos']?></td>
                <td><?=$row['flujodetalle_casillanombre']?></td>
                <td><?=$row['usuarios_nombre']?></td>
            </tr>
        <? } ?>
    </tbody>
</table>

<div id="charthistorialtramite"></div>

<script>	
	var arr = <?=$grafica?>;
	var arr2 = <?=$grafica2?>;

	if(Object.keys(arr[0]).length > 1 && Object.keys(arr2[0]).length > 1) {
		am4core.ready(function() {
			am4core.useTheme(am4themes_animated);
			var chart = am4core.create("charthistorialtramite", am4charts.XYChart);        
			
			chart.data = arr;
        
			chart.legend = new am4charts.Legend();
			chart.legend.position = "bottom";
			chart.legend.contentAlign = "right";
			chart.legend.fontSize = "15";
			// Create axes
			var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
			categoryAxis.dataFields.category = "tramite";
			categoryAxis.renderer.grid.template.opacity = 0;
	
			var valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
			valueAxis.min = 0;
			valueAxis.renderer.grid.template.opacity = 0;
			valueAxis.renderer.ticks.template.strokeOpacity = 0.5;
			valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
			valueAxis.renderer.ticks.template.length = 5;
			valueAxis.renderer.line.strokeOpacity = 0.5;
			valueAxis.renderer.baseGrid.disabled = true;
			valueAxis.renderer.minGridDistance = 40;
	
			// Create series
			var colors = ["yellow", "orange", "green", "#800040"];
			var count = 0;
			function createSeries(field, name) {
				var series = chart.series.push(new am4charts.ColumnSeries());
				series.dataFields.valueX = field;
				series.dataFields.categoryY = "tramite";
				series.stacked = true;
				series.name = name;
				series.fill = am4core.color(colors[count]);
				series.stroke = "white";
	
				var labelBullet = series.bullets.push(new am4charts.LabelBullet());
				labelBullet.locationX = 0.5;
				labelBullet.locationY = 0.5;
				labelBullet.label.text = "{valueX}";
				labelBullet.label.fill = am4core.color("#000");
				labelBullet.label.fontSize = "15";
				count+=1;
			}

			for (var i = 0; i < arr2.length; i++){
				var obj = arr2[i];
				for (var key in obj){
					if (key != 'tramite'){
						createSeries(key, obj[key]);
					}
				}
			}
		});
	}
	else {
		document.getElementById('charthistorialtramite').innerHTML = 'Este trámite aún no ha sido escaneado';
		document.getElementById('charthistorialtramite').style.fontSize = '20px';
		document.getElementById('charthistorialtramite').style.textAlign = 'center';
	}
</script>