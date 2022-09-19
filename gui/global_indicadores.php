<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Indicadores
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
                                $p->revisarpermisos('1004',$usersessionpermisos);
                            ?>
							<span class="heading-meta">Trámite</span>
							<h1 class="animate-box" data-animate-effect="fadeInLeft">
                                Indicadores
                            </h1>
                            <? include_once ("../includes/global_indicadores.php");?>
						</div>
					</div>
                    <!-- body -->
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>
	</body>
</html>