<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Solicitud de Cambios 2
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
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_formcambios2.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>
	</body>
</html>