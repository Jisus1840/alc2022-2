<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Recibir Trámite
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<!DOCTYPE HTML>
<html>
	<head>
        <!-- Include Header -->
        <? include_once ("../js/global_header.js");?>
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
                            <?
                                $p = new permisos();
                                $p->revisarpermisos('1003',$usersessionpermisos);
                            ?>
							<span class="heading-meta">Trámite</span>
                            <? include_once ("../includes/global_menutramite.php");?>
							<h1 class="animate-box" data-animate-effect="fadeInLeft">
                                Recibir Trámite
                            </h1>
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_tramiterecibir.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>
	</body>
</html>