<?
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Tramite catalogo
*********************************************************************************
*/
?>
<? include_once ("../includes/global_sesion.php"); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_header.js");?>
<?
    $p = new permisos();
    $p->revisarpermisos('2006',$usersessionpermisos);
?>
<div class="colorlib-services">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-8">
                            
							<div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
                                <a href="../gui/global_solicitudlicencia.php">
								    <div class="colorlib-icon">
                                        <i class="icon-arrow-right-thick"></i>
                                    </div>
                                </a>
								<div class="colorlib-text">
									<h3>Solicitud de Licencia</h3>
									<p>Solicitud de Licencia</p>
								</div>
							</div>

                            <div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_solicitudlicenciaprovisional.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Solicitud de Permiso Especial</h3>
									<p>Solicitud de Permiso Especial</p>
								</div>
							</div>
                            
                            <div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_solicitudcambios.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Solicitud de Cambios</h3>
									<p>Solicitud de Cambio de Domicilio, de Prpoietario, de Comodtarario, de Nómbre Genérico y/o de Giro</p>
								</div>
							</div>
                            
                            <div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_refrendo.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Refrendo Licencia</h3>
									<p>Refrendo Licencia. </p>
								</div>
							</div>
                            
                            <!--
							<div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_cambiodomicilio.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Cambio de Domicilio</h3>
									<p>Cambio de Domicilio de Licencia. </p>
								</div>
							</div>
                            
                            <div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_cambionombregenerico.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Cambio de Nombre Genérico</h3>
									<p>Cambio de Nombre Genérico de Licencia. </p>
								</div>
							</div>
                            -->
						</div>
                        <!--
						<div class="col-md-6">
                            
							<div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_cambiocomodatario.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
                                <div class="colorlib-text">
									<h3>Cambio de Comodatario</h3>
									<p>Cambio de Comodatario de Licencia. </p>
								</div>
							</div>

							<div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_cambiopropietario.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Cambio de Propietario</h3>
									<p>Cambio de propietario de Licencia. </p>
								</div>
							</div>

							<div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_cambiogiro.php">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Cambio de Giro</h3>
									<p>Cambio de Giro de Licencia. </p>
								</div>
							</div>
                            
                            <div class="colorlib-feature animate-box" data-animate-effect="fadeInLeft">
								<a href="../gui/global_consultastatus.php" target="_blank">
                                <div class="colorlib-icon">
									<i class="icon-arrow-right-thick"></i>
								</div>
                                </a>
								<div class="colorlib-text">
									<h3>Consulta Status</h3>
									<p>Consulta el status de tu trámite. </p>
								</div>
							</div>
                            
						</div>
                        -->
					</div>
				</div>
			</div>