<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Página Principal para Impresión de Formatos SP
*********************************************************************************
*/
?>
<? include_once ("../includes/global_includes_session.php")  ?>
<? include_once ("../config/global_config_includes.php")  ?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<? include_once ("../config/global_config_head.php"); ?>
	</head>
	<body translate="no">
		<div class="container-fluid">
		
		</div>
			<div class="page-wrapper chiller-theme toggled">
				<a id="show-sidebar" class="btn btn-sm btn-dark" href="#">
					<i class="fas fa-bars"></i>
				</a>
				<? include_once ("../includes/egr_includes_menuprestaciones.php");?>
				<main class="page-content">
					<!-- Loading -->
					<div id="loading_dipetre" style="display:none">
						<img id="loading-image_dipetre" src="../imagenes/global_imagenes_loading.gif"/>
					</div>
					<!-- Encabezado -->
					<div class="container-fluid">
						<? include_once("../includes/global_includes_menu.php"); ?>
					</div>
					<!-- Container -->
					<hr>
					<div class="container">
						<br><h2><img src="../imagenes/egr_imagenes_prestaciones.png" width="50px">&nbsp;&nbsp;Impresión de Formatos</h2><br>
						<? include_once ("../includes/egr_includes_prestacionesimpresionformatosp.php");?>
					</div>
				</main>
			</div>
	</body>
</html>