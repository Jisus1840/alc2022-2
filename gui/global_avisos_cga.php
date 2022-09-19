
<? session_start(); ?>
<? include_once ("../config/global_includes.php"); ?>
<? include_once ("../js/global_headerxcrud.js");?>

<!DOCTYPE html>
<html class="no-js" lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unidad Administrativa de Alcoholes</title>
    <link rel='stylesheet' id='x-stack-css' href='../css/integrity-light.css?ver=5.2.5' type='text/css' media='all'/>
    <link rel='stylesheet' id='x-cranium-migration-css' href='../css/integrity-light2.css?ver=5.2.5' type='text/css' media='all'/>
    <script type='text/javascript' src='../js/jquery.js?ver=1.12.4-wp'></script>
    <script type='text/javascript' src='../js/x-head.min.js?ver=5.2.5'></script>
    <link rel='stylesheet' href='../css/startstyle.css' type='text/css' media='all'/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel='stylesheet' href='../css/fuente.css' type='text/css' media='all'/>
</head>

<body data-rsssl=1 class="home page-template page-template-template-blank-4 page-template-template-blank-4-php page page-id-23111 x-integrity x-integrity-light x-full-width-layout-active x-content-sidebar-active wpb-js-composer js-comp-ver-5.4.5 vc_responsive x-navbar-fixed-top-active x-one-page-navigation-active x-v5_2_5 cornerstone-v2_1_7">
    <div id="x-root" class="x-root">
        <div id="top" class="site">
            <!-- header-->
            <header class="masthead masthead-inline" role="banner">
                <? include "../includes/global_menustart.php"?>
            </header>
            <!-- body-->
            <div class="x-main full" role="main">
                <article id="post-23111" class="post-23111 page type-page status-publish hentry no-post-thumbnail">

                    <div class="entry-content content; text-align: center !important;">
                        <div id="cs-content" class="cs-content">
                            <div class="el56 x-section">
                                <div class="el57 x-container max width;">
								<h2 style="text-align:center;"><b style="font-size:45px;">Avisos</span></b></h2>
								<br>
			<?
			
				include_once('../lib/xcrud/xcrud.php');

				$xcrud = Xcrud::get_instance();
				$xcrud->table('conf_avisos');
				$xcrud->limit(50);
				$xcrud->unset_limitlist();
				$xcrud->table_name(' ');
		
				$xcrud->change_type('imagen', 'file', '', array('path' =>'../../avisos/', 'not_rename'=>false));
				$xcrud->fields('fecha, resumen_aviso, imagen');
				$xcrud->columns('fecha, resumen_aviso, imagen');
				$xcrud->order_by('fecha','desc');
				$xcrud->validation_required('imagen, fecha, resumen_aviso');
				$xcrud->label(array('fecha' => 'Fecha del aviso', 'resumen_aviso' => 'Resumen del aviso', 'imagen' => 'Archivo del aviso'));

				$xcrud->unset_view();
				$xcrud->unset_remove();
				$xcrud->unset_add();
				$xcrud->unset_edit();
				$xcrud->unset_csv();
				$xcrud->unset_print();
				$xcrud->unset_search();
	
				echo $xcrud->render();
?>
<br>
                                </div>
                            </div>

                            <div id="x-section-8" class="x-section bg-image" style="margin: 0px;padding: 45px 0px; background-image: url(https://saltillo.gob.mx/wp-content/uploads/2020/09/fondoverde.jpeg); background-color: transparent;" data-x-element="section">
                                <div class="x-container max width" style="margin: 0px auto;padding: 0px;">
                                    <? include "../includes/global_piepaginastart.php"?>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <!-- footer-->
            <footer class="x-colophon bottom" role="contentinfo">
                <div class="x-container max width">
                    <div class="x-colophon-content">
                        <p style="letter-spacing: 2px; text-transform: uppercase;">
                            Unidad Administrativa de Alcoholes
                            <a href="#" title="Unidad Administrativa de Alcoholes ">2020</a>
                        </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script type='text/javascript' src='../js/x-body.min.js?ver=5.2.5'></script>
</body>
</html>
