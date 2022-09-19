<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Consulta Status
*********************************************************************************
*/
?>
<? include_once ("../config/global_includes.php"); ?>
<!DOCTYPE HTML>
<html>
	<head>
        <!-- Include Header -->
        <? include_once ("../js/global_header.js");?>
	</head>
	<body>
	<div id="colorlib-page">
        <!-- Main -->
		<div id="colorlib-main">
			<div class="colorlib-contact">
				<div class="container-fluid">
					<!-- titulo -->
                    <div class="row">
						<div class="col-md-12">
							<span class="heading-meta">Trámite</span>
							<h1 class="animate-box" data-animate-effect="fadeInLeft">
                                Consulta de Status
                            </h1>
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_formconsultastatus.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>
	</body>
</html>