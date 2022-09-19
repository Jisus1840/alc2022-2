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
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<a href="#" class="js-colorlib-nav-toggle colorlib-nav-toggle"><i></i></a>
<aside id="colorlib-aside" role="complementary" class="border js-fullheight">
    <img src="../images/logo1.png" width="175px">
    <div class="colorlib-header" align="right">
        <i class="icon-user" style="font-size:12px"><?=$usersession[0]['usuarios_usuario']?></i>
    </div><br>
    <nav id="colorlib-main-menu" role="navigation">
        <ul>
            <!-- <li class="colorlib-active"> -->
            <li><a href="../gui/global_inicio.php">Inicio</a></li>
            <li><a href="../gui/global_tramiteall.php">Trámites</a></li>
            <li><a href="../gui/global_licenciasall.php">Licencias</a></li>
            <li><a href="../gui/global_licenciasprovisionalesall.php">Permisos Especiales</a></li>
            <li><a href="../gui/global_indicadores.php">Indicadores</a></li>
            <li><a href="../gui/global_catalogos.php">Catálogos</a></li>
            <li><a href="../gui/global_citasagendar.php">Citas</a></li>
            <li><a href="../gui/global_permisos.php">Permisos</a></li>
            <li><a href="../gui/global_bitacora.php">Bitácora</a></li>
            <li><a href="../gui/global_avisos.php">Avisos</a></li>
            <li><a href="../docs/preguntas_frecuentes.pdf">Ayuda</a></li>
            <li><a href="../includes/global_sesioncerrar.php" onclick="return confirm('Estas seguro que deseas salir?')">Salir</a></li>
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