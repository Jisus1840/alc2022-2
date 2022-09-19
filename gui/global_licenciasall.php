<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Ver todas las licencias
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
		<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
		<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
		
	</head>
	<style>
		body {
			font-size: 20px;
		}

	</style>
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
                                $p->revisarpermisos('1001',$usersessionpermisos);
                            ?>
							<span class="heading-meta">Trámite</span>
                            <? include_once ("../includes/global_menulicencias.php");?>
							<h1 class="animate-box" data-animate-effect="fadeInLeft">
                                Ver Licencias
                            </h1>
						</div>
					</div>
                    <!-- body -->
					<? include_once ("../includes/global_licenciasall.php"); ?>
				</div>
			</div>
		</div>
	</div>
    <!-- Include Footer -->
    <? include_once ("../js/global_footer.js");?>

	<script>
		$(document).ready( function () {
   		 	$('#tabla_lics').DataTable({
				"paging":   false,
        		"ordering": true,
        		"info":     false,
				"searching": false
				});
		} );
	</script>
	</body>
</html>