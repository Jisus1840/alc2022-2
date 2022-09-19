
<?php 
	include_once ("../includes/global_sesion.php");
	include_once ("../config/global_includes.php"); 
	include_once ("../js/global_header.js");

    $p = new permisos();
    $p->revisarpermisos('2010',$usersessionpermisos);
	
	(isset($_GET['ciclo']))?$ciclo=$_GET['ciclo']:$ciclo=date("Y");
	(isset($_GET['mes_inicial']))?$mes_inicial=$_GET['mes_inicial']:$mes_inicial=$ciclo.'-01';
	(isset($_GET['mes_final']))?$mes_final=$_GET['mes_final']:$mes_final=$ciclo.'-12';

	# Traemos los datos de las gráficas
	$indi = new indicadores();
	$grafica1 = $indi->getgrafica1totaltramitesporstatus($ciclo, $mes_inicial, $mes_final);
	$grafica2 = $indi->getgrafica2totalportramitesporstatus($ciclo, $mes_inicial, $mes_final);
	$grafica3 = $indi->getgraficatotalmontospagados($ciclo, $mes_inicial, $mes_final);
?>
<style>
    #grafica1 {
		width: 100%;
		height: 250px;
    }
    
    #grafica2 {
		width: 100%;
		height: 500px;
    }
	
	#grafica3 {
		width: 100%;
		height: 550px;
		font-size: 15px;
    }

</style>

<script src="../lib/amcharts4/core.js"></script>
<script src="../lib/amcharts4/charts.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/kelly.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>

<script>

// Cuando cargue la página, cargamos el ciclo, mes inicial y final por default y las gráficas
$(document).ready(function(){
	set_inputs();
	stacked_bar_chart(); // Estatus de los trámites
	bar_chart();  // Cantidad de trámites generados
	clustered_bar_chart();  // Montos recabados por trámites
});

// Arreglo para guardar las gráficas a mostrar en el pdf
var graficas = [];
  
set_inputs = () => {
	// Traemos valores del ciclo, fecha inicial y fecha final
	const current_year = new Date().getFullYear();
	const fecha_inicial = `${current_year}-01`;
	const fecha_final = `${current_year}-12`;
	
	const queryString = window.location.search;
	const urlParams = new URLSearchParams(queryString);
	const mes_inicial = urlParams.get('mes_inicial') ? urlParams.get('mes_inicial') : fecha_inicial;
	const mes_final = urlParams.get('mes_final') ? urlParams.get('mes_final') : fecha_final;
	const ciclo = urlParams.get('ciclo') ? urlParams.get('ciclo') : '';

	// Ponemos estos valores en los inputs correspondientes
	get_ciclos(current_year, ciclo);
	document.getElementById('desde').value = mes_inicial;
	document.getElementById('hasta').value = mes_final;
}

// Función para mostrar los ciclos en el select de ciclos
get_ciclos = (current_year, ciclo) => { 
	const select_ciclos = document.getElementById('ciclo');
	for(let i = current_year; i >= 2019; i--) {	
		let option = document.createElement("option");
		option.text = i;
		option.value = i;
		select_ciclos.appendChild(option);
	}	
	if(ciclo != '') {
		document.getElementById("ciclo").value = ciclo;
	}
	else {
		document.getElementById("ciclo").value = current_year;
	}
}

// Gráfica de barras horizontal
stacked_bar_chart = () => {
	// Themes begin
	am4core.useTheme(am4themes_kelly);
	//am4core.useTheme(am4themes_material);
	am4core.useTheme(am4themes_animated);
	// Themes end
	
	// Create chart instance
	let chart = am4core.create("grafica1", am4charts.XYChart);

	// Add data
	chart.data = <?=$grafica1?>;	
	chart.legend = new am4charts.Legend();
	chart.legend.position = "right";
	
	// Create axes
	let categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
	categoryAxis.dataFields.category = "Titulo";
	categoryAxis.renderer.grid.template.opacity = 0;
	
	let valueAxis = chart.xAxes.push(new am4charts.ValueAxis());
	valueAxis.min = 0;
	valueAxis.renderer.grid.template.opacity = 0;
	valueAxis.renderer.ticks.template.strokeOpacity = 0.5;
	valueAxis.renderer.ticks.template.stroke = am4core.color("#495C43");
	valueAxis.renderer.ticks.template.length = 10;
	valueAxis.renderer.line.strokeOpacity = 0.5;
	valueAxis.renderer.baseGrid.disabled = true;
	valueAxis.renderer.minGridDistance = 40;
	
	// Create series
	function createSeries(field, name, coloraux) {
		let series = chart.series.push(new am4charts.ColumnSeries());
		series.dataFields.valueX = field;
		series.dataFields.categoryY = "Titulo";
		series.stacked = true;
		series.name = name;
		series.fill = am4core.color(coloraux);
		series.columns.template.stroke = am4core.color("#ffffff");
  
		series.columns.template.column.fillOpacity = 0.8;
		let labelBullet = series.bullets.push(new am4charts.LabelBullet());
		labelBullet.locationX = 0.5;
		labelBullet.label.text = "{valueX}";
		labelBullet.label.fill = am4core.color("#fff");  
	}	

	createSeries("Creado", "Creado", "yellow");
	createSeries("En proceso", "en Proceso", "orange");
	createSeries("Finalizado", "Finalizado", "green");
	createSeries("Cancelado", "Cancelado", "red");
}

// Gráfica de barras
bar_chart = () => {
	// Themes begin
    am4core.useTheme(am4themes_kelly);
	//am4core.useTheme(am4themes_material);
	am4core.useTheme(am4themes_animated);
	// Themes end

	// Create chart instance
	let chart = am4core.create("grafica2", am4charts.XYChart);

	// Add percent sign to all numbers
	chart.numberFormatter.numberFormat = "#.#";

	// Add data
	chart.data = <?=$grafica2?>;
	// Create axes
	let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
	categoryAxis.dataFields.category = "tramite";
	categoryAxis.renderer.grid.template.location = 0;
	categoryAxis.renderer.minGridDistance = 30;
	
	let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
	valueAxis.title.text = "Número de trámites";
	valueAxis.title.fontWeight = 800;
	
	// Create series
	let series4 = chart.series.push(new am4charts.ColumnSeries());
	series4.dataFields.valueY = "cancelado";
	series4.dataFields.categoryX = "tramite";
	series4.clustered = false;
	series4.columns.template.width = am4core.percent(90);
	series4.tooltipText = "Cancelado {categoryX}: [bold]{valueY}[/]";
	series4.columns.template.column.cornerRadiusTopLeft = 10;
	series4.columns.template.column.cornerRadiusTopRight = 10;
	series4.columns.template.column.fillOpacity = 0.8;
	series4.columns.template.stroke = am4core.color("#ffffff");
	series4.columns.template.fill = am4core.color("red");
		
	let series = chart.series.push(new am4charts.ColumnSeries());
	series.dataFields.valueY = "finalizado";
	series.dataFields.categoryX = "tramite";
	series.clustered = false;
	series.columns.template.width = am4core.percent(80);
	series.tooltipText = "Finalizados {categoryX}: [bold]{valueY}[/]";
	series.columns.template.column.cornerRadiusTopLeft = 10;
	series.columns.template.column.cornerRadiusTopRight = 10;
	series.columns.template.column.fillOpacity = 0.8;
	series.columns.template.stroke = am4core.color("#ffffff");
	series.columns.template.fill = am4core.color("green");

	let series2 = chart.series.push(new am4charts.ColumnSeries());
	series2.dataFields.valueY = "proceso";
	series2.dataFields.categoryX = "tramite";
	series2.clustered = false;
	series2.columns.template.width = am4core.percent(70);
	series2.tooltipText = "En Proceso {categoryX}: [bold]{valueY}[/]";
	series2.columns.template.column.cornerRadiusTopLeft = 10;
	series2.columns.template.column.cornerRadiusTopRight = 10;
	series2.columns.template.column.fillOpacity = 0.8;
	series2.columns.template.stroke = am4core.color("#ffffff");
	series2.columns.template.fill = am4core.color("orange");
		
	let series3 = chart.series.push(new am4charts.ColumnSeries());
	series3.dataFields.valueY = "creado";
	series3.dataFields.categoryX = "tramite";
	series3.clustered = false;
	series3.columns.template.width = am4core.percent(60);
	series3.tooltipText = "Creado {categoryX}: [bold]{valueY}[/]";
	series3.columns.template.column.cornerRadiusTopLeft = 10;
	series3.columns.template.column.cornerRadiusTopRight = 10;
	series3.columns.template.column.fillOpacity = 0.8;
	series3.columns.template.stroke = am4core.color("#ffffff");
	series3.columns.template.fill = am4core.color("yellow");
    
	chart.cursor = new am4charts.XYCursor();
	chart.cursor.lineX.disabled = true;
	chart.cursor.lineY.disabled = true;
}

// Gráfica de barras
clustered_bar_chart = () => {
	am4core.useTheme(am4themes_animated);
	let chart = am4core.create('grafica3', am4charts.XYChart)
	chart.numberFormatter.numberFormat = "$ #,###.##";
	chart.colors.step = 2;

	chart.legend = new am4charts.Legend()
	chart.legend.position = 'top'
	chart.legend.paddingBottom = 20
	chart.legend.labels.template.maxWidth = 95
	
	let xAxis = chart.xAxes.push(new am4charts.CategoryAxis())
	xAxis.dataFields.category = 'tramite'
	xAxis.renderer.cellStartLocation = 0.1
	xAxis.renderer.cellEndLocation = 0.9
	xAxis.renderer.grid.template.location = 0;
	
	let yAxis = chart.yAxes.push(new am4charts.ValueAxis());
	yAxis.min = 0;

	function createSeries(value, name) {
		let series = chart.series.push(new am4charts.ColumnSeries())
		series.dataFields.valueY = value
		series.dataFields.categoryX = 'tramite'
		series.name = name

		series.events.on("hidden", arrangeColumns);
		series.events.on("shown", arrangeColumns);

		let bullet = series.bullets.push(new am4charts.LabelBullet())
		bullet.interactionsEnabled = false
		bullet.dy = 0;
		bullet.label.text = '{valueY}'
		bullet.label.fill = am4core.color('#000000')
	
		return series;
	}

	chart.data = <?=$grafica3;?>;
	createSeries('pago_total', 'Total');
	createSeries('pago_solicitud', 'Solicitud');
	graficas.push(chart);

	function arrangeColumns() {
		let series = chart.series.getIndex(0);

		let w = 1 - xAxis.renderer.cellStartLocation - (1 - xAxis.renderer.cellEndLocation);
		if (series.dataItems.length > 1) {
			let x0 = xAxis.getX(series.dataItems.getIndex(0), "categoryX");
			let x1 = xAxis.getX(series.dataItems.getIndex(1), "categoryX");
			let delta = ((x1 - x0) / chart.series.length) * w;
			if (am4core.isNumber(delta)) {
				let middle = chart.series.length / 2;
	
				let newIndex = 0;
				chart.series.each(function(series) {
					if (!series.isHidden && !series.isHiding) {
						series.dummyData = newIndex;
						newIndex++;
					}
					else {
						series.dummyData = chart.series.indexOf(series);
					}
				})
				let visibleCount = newIndex;
				let newMiddle = visibleCount / 2;
	
				chart.series.each(function(series) {
					let trueIndex = chart.series.indexOf(series);
					let newIndex = series.dummyData;
	
					let dx = (newIndex - trueIndex + middle - newMiddle) * delta

					series.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
					series.bulletsContainer.animate({ property: "dx", to: dx }, series.interpolationDuration, series.interpolationEasing);
				})
			}
		}
	}
}

function get_month_name(month) {
	var nombre_mes = '';
	switch(month) {
		case '01': nombre_mes = 'enero'; break;
		case '02': nombre_mes = 'febrero'; break;
		case '03': nombre_mes = 'marzo'; break;
		case '04': nombre_mes = 'abril'; break;
		case '05': nombre_mes = 'mayo'; break;
		case '06': nombre_mes = 'junio'; break;
		case '07': nombre_mes = 'julio'; break;
		case '08': nombre_mes = 'agosto'; break;
		case '09': nombre_mes = 'septiembre'; break;
		case '10': nombre_mes = 'octubre'; break;
		case '11': nombre_mes = 'novienbre'; break;
		case '12': nombre_mes = 'diciembre'; break;
	}
	return nombre_mes;
}

function savePDF() {
	$("#loading").show();
	var desde = document.getElementById('desde').value;
	var hasta = document.getElementById('hasta').value;
	var ciclo = document.getElementById('ciclo').value;
	var mes_inicial = get_month_name(desde.slice(-2));
	var mes_final = get_month_name(hasta.slice(-2));
	var label_graficas = 'Ingresos de '+mes_inicial+' a '+mes_final+' del '+ciclo;
	var chart = graficas;
	var graficas_exportar = [];
	graficas_exportar.push(graficas[0].exporting.pdfmake);
	
	for (var i = 0; i < chart.length; i++){
		var obj = graficas[i].exporting.getImage("png");
		graficas_exportar.push(obj);
	}

	Promise.all(graficas_exportar).then(function(res) {   
		var pdfMake = res[0];
    
		// pdfmake is ready
		// Create document template
		var doc = {
			pageSize: "A4",
			startposition: {
				pageNumber:1
			},
			pageOrientation: "landscape",
			pageMargins: [0, 10, 0, 0],
			content: []
		};
	
		doc.content.push({
			text: label_graficas,
			fontSize: 18,
			bold: true,
			color: 'black',
			margin: [280, 35, 0, 15]
		});
		
		doc.content.push({
			image: res[1],
			width: 680,
			margin: [70, 50, 0, 15]
		});
	
		pdfMake.createPdf(doc).download("Ingresos_"+mes_inicial+"_"+mes_final+"_"+ciclo+".pdf");
	});
	$("#loading").hide();
}

generar_graficas = () => {
	let ciclo = document.getElementById('ciclo').value;
	let mes_inicial = document.getElementById('desde').value;
	let mes_final = document.getElementById('hasta').value;
	location.href = "../gui/global_indicadores.php?ciclo="+ciclo+"&mes_inicial="+mes_inicial+"&mes_final="+mes_final;
}

</script>
<div class="form-group col-md-2">
    <label>Ciclo actual:</label>
    <select id="ciclo" name="ciclo" class="form-control browser-default">
    </select>
</div>
<div class="form-group col-md-3">
    <label>Desde:</label><br>
    <input type="month" id="desde" name="desde" value="2021-01" style="width: 270px" />
    </select>
</div>
<div class="form-group col-md-3">
    <label>Hasta:</label><br>
    <input type="month" id="hasta" name="hasta" style="width: 270px" />
</div>
<div class="form-group col-md-3">
	<br>
    <button type="button" class="btn btn-primary" onclick="generar_graficas()">Generar gráficas</button>
</div>
<div class="row">
    <div class="col-md-11">
        <div class="row">
            <div>
                <br>
                <h3>Solicitudes Totales</h3>
                <div id="grafica1"></div>
            </div>
        </div>
    </div>
    <div class="col-md-11">
        <div class="row">
            <div>
                <br><br>
                <h3>Solicitudes por tipo de trámite</h3>
                <div id="grafica2"></div>
            </div>
        </div>
    </div>
	<div class="col-md-11">
        <div class="row">
            <div>
                <br><br>
                <h3>Ingresos por tipo de trámite</h3>
                <div id="grafica3"></div>
            </div>
			<div style="text-align: right">
				<button class="btn btn-primary" onclick="savePDF()">Generar pdf</button>
			</div>
        </div>
    </div>
</div>

<div id="loading" style="display:none">
    <img id="loading-image" src="../imagenes/loading.gif" width="100%"/>
</div>