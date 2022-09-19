<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2020
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Admin Citas Eventos
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
                                $p->revisarpermisos('1009',$usersessionpermisos);
                            ?>
							<span class="heading-meta">Admin</span>
                            <? include_once ("../includes/global_menucitas.php");?>
							<h1 class="animate-box" data-animate-effect="fadeInLeft">
                                Admin Eventos
                            </h1>
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_citasxcrudadmineventos.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>
	</body>
</html>