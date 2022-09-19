<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Menu Principal
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesionext.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
<aside id="colorlib-aside" role="complementary" class="border js-fullheight">
    <img src="../images/logo1.png" width="175px">
    <div class="colorlib-header" align="right">
        <i class="icon-user" style="font-size:12px"><?=$usersessionext[0]['rfcexterno']?></i>
    </div>
    <br>
	<?php 
		if(isset($usersessionext[0]['pagina'])) {
			$pagina = $usersessionext[0]['pagina'];
		}
		else {
			$pagina = null;
		}
	?>
    <nav id="colorlib-main-menu" role="navigation">
        <ul>
            <!-- <li class="colorlib-active"> -->
            <!--<li><a href="../gui/global_inicioext.php">Inicio</a></li>-->
			<?php 
				switch ($pagina) {
					case 1: echo '<li><a href="../gui/global_solicitudlicenciaexterno.php">Solicitud de una licencia nueva</a></li>'; break;
					case 2: echo '<li><a href="../gui/global_solicitudcambiosexterno.php">Solicitud de cambio en licencia ya existente</a></li>'; break;
					case 3: echo '<li><a href="../gui/global_solicitudlicenciaprovisionalexterno.php">Permiso Especial</a></li>'; break;
				}
			?>
			<li><a href="../gui/global_tramiteexterno.php">Ver Trámites</a></li>
            <!--<li><a href="../gui/global_refrendoexterno.php">Refrendo</a></li>-->
            <!--<li><a href="../gui/global_consultastatus.php">Consulta Solicitud</a></li>-->
            <li><a href="../includes/global_sesioncerrarext.php" onclick="return confirm('Estas seguro que deseas salir?')">Salir</a></li>
        </ul>
    </nav>

    <div class="colorlib-footer">
        <p>
            <small>
                MUNICIPIO DE SALTILLO <script>document.write(new Date().getFullYear());</script>
            </small>
        </p>
        <ul>
            <li><a href="#"><i class="icon-facebook2"></i></a></li>
            <li><a href="#"><i class="icon-twitter2"></i></a></li>
            <li><a href="#"><i class="icon-instagram"></i></a></li>
            <li><a href="#"><i class="icon-linkedin2"></i></a></li>
        </ul>
    </div>

</aside>