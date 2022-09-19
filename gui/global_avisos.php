<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Inicio
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
                            <?
                                $p = new permisos();
                                $p->revisarpermisos('1008',$usersessionpermisos);
                            ?>
							<span class="heading-meta">Trámite</span>
							<h1>
                                Avisos
                            </h1>
						</div>
					</div>
                    <!-- body -->
                    <? include_once ("../includes/global_xcrudavisos.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? //include_once ("../js/global_footer.js");?>
	</body>
</html>