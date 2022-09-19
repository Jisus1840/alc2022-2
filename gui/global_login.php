<? 
session_start();
if (isset($_SESSION)){
    session_unset();
    session_destroy();
} 
?>
<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Login
*********************************************************************************
*/
?>
<!DOCTYPE HTML>
<html>
	<head>
        <!-- Include Header -->
        <? include_once ("../js/global_header.js");?>
	</head>
	<body>
	<div id="colorlib-page">
		<img src="../images/logo1.png" width="300px">
        <!-- Main -->
		<div id="colorlib-main">
			<div class="colorlib-contact">
				<div class="container-fluid">
					<!-- titulo -->
                    <div class="row">
						<div class="col-md-12">
							<span class="heading-meta">Trámite</span>
							<h1 class="animate-box" data-animate-effect="fadeInLeft">
                                Acceso
                            </h1>
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_formlogin.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>
	</body>
</html>