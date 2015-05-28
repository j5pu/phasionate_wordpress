<?php
/**
 * Template Name: Registro
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('no');
?>

<?php /*get_template_part('page-parts/general-title-section'); */?>

<?php /*get_template_part('page-parts/general-before-wrap'); */?>

<img style="border-top: 2px solid #F66; border-bottom: 2px solid #F66; width: 100%; position: relative; top: -5px;" src="/wp-content/themes/kleo-child/assets/img/portada_login.jpg" alt="portada_login" />
<p style="text-align: center; font-size: 15px; color: #f66; margin-top: 40px; font-family: 'Open Sans', sans-serif;"><strong>¡PHASIONATE SE HACE CONTIGO!</strong></p>

<h2 style="text-align: center; color: #747a7f; margin: 20px 0px 40px; font-family: 'Open Sans', sans-serif; font-weight: 600; font-size: 40px;">Ábrete al mundo de la moda</h2>
<p class="login_descripcion">Llega <strong>My Phasion</strong>, la comunidad más cercana en la que te meterás de lleno en el universo de la moda, la belleza y el <em>lifestyle</em>. Somos la primera revista digital en desarrollar una red social donde los lectores son parte del mundo <strong>Phasionate</strong>. En <strong>My Phasion</strong> encontrarás:</p>

<div class="all_img_login">
	<a class="login_book" href="/book-vivo" target="_blank"><span>Tu book en vivo</span></a>
	<a class="login_concurso" href="/concursos-premios" target="_blank"><span>Concursos y premios</span></a>
	<a class="login_foros" href="/foros-consejos-novedades" target="_blank"><span>Foros, consejos, novedades...</span></a>
</div>

<h2 style="text-align: center; color: #747a7f; margin: 40px 0px; padding: 0px 10px; font-family: 'Open Sans', sans-serif; font-weight: 600;">¿A que esperas para convertirte en <em>Phasionista</em>?</h2>
<p class="login_descripcion"><a class="botton_register_main" href="#">Regístrate</a></p>
<?php
if ( have_posts() ) :
	// Start the Loop.
	while ( have_posts() ) : the_post();

		/*
		 * Include the post format-specific template for the content. If you want to
		 * use this in a child theme, then include a file called called content-___.php
		 * (where ___ is the post format) and that will be used instead.
		 */
		get_template_part( 'content', 'page' );

	endwhile;

endif;
?>
        
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>