<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todos los Trámite
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesionext.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<!DOCTYPE HTML>
<html>
	<head>
        <!-- Include Header -->
        <? include_once ("../js/global_header.js");?>
		<style>
			body {
				font-size: 20px;
			}
		</style>
	</head>
	<body>
	<div id="colorlib-page">
		<? include_once ("../includes/global_menuexterno.php");?>
        <!-- Main -->
		<div id="colorlib-main">
			<div class="colorlib-contact">
				<div class="container-fluid">
					<!-- titulo -->
                    <div class="row">
						<div class="col-md-12">
							<span class="heading-meta">Trámite</span>
							<h1 class="animate-box" data-animate-effect="fadeInLeft">
                                Ver Trámites
                            </h1>
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_tramiteallexterno.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>
	</body>
</html>