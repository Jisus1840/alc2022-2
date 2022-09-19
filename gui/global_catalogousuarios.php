<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Catálog Usuarios
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<!DOCTYPE HTML>
<html>
	<head>
        <!-- Include Header -->
        <? include_once ("../js/global_headerxcrud.js");?>
	</head>
	<body>
	<div id="colorlib-page">
		<? include_once ("../includes/global_menu.php");?>
        <!-- Main -->
		<div id="colorlib-main">
			<div class="colorlib-contact">
				<div class="container-fluid">
					<!-- titulo -->
                    <div class="row">
						<div class="col-md-12">
							<span class="heading-meta">Catálogos</span>
							<h1>
                                Usuarios
                            </h1>
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_xcrudusuarios.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? // include_once ("../js/global_footer.js");?>
	</body>
</html>