<?php
/**
 * Template Name: Newsletter
 *
 * Description: Template landing-page newsletter
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

get_header(); ?>
<link href='http://fonts.googleapis.com/css?family=Expletus+Sans' rel='stylesheet' type='text/css'>
<?php
//create full width template
kleo_switch_layout('no');
?>

<?php get_template_part('page-parts/general-title-section'); ?>

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
        ?>

        <?php get_template_part( 'page-parts/posts-social-share' ); ?>
				<div style="background-color: #333; box-shadow: 0px -12px 20px 10px rgba(0,0,0,0.75); color: #FFF;">
					<div style="max-width: 1024px; margin: 0px auto;">
						<h2 style="line-height: 50px; font-family: 'Expletus Sans', cursive; float: left; width: 72%;">¡Suscríbete a nuestra <spam style="color: #c64040;">NEWSLETTER</spam> y podras <spam style="font-size: 50px;">ganar</spam> un bolso <span style="font-size: 50px;">PARFOIS</span>!</h2>
						<img class="arrow-newsletter" src="https://www.bogadia.com/wp-content/uploads/2015/08/arrow333.jpg" alt="flecha" />
					</div>
				</div>
			<div style="max-width: 1024px; min-height: 620px; margin: 0px auto 20px; padding: 20px;">

				<div style="background-color: white; float: right; border-radius: 5px; box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.75); padding: 20px; max-width: 340px;">
					<div style="color: #902828; text-align: center; font-family: 'Expletus Sans', cursive; font-size: 28px; border-bottom: 1px solid black; padding-bottom: 20px; margin-bottom: 20px;">NEWSLETTER</div>			
					<!-- Begin MailChimp Signup Form -->
					<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css">
					<style type="text/css">
						#mc_embed_signup{background:#fff; clear:left; font:14px Helvetica,Arial,sans-serif;  width:300px;}
						/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
						   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
					</style>
					<div id="mc_embed_signup">
					<form action="//bogadia.us10.list-manage.com/subscribe/post?u=2f7c3f6390d0e389e5a73d4b7&amp;id=73f14c9734" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					    <div id="mc_embed_signup_scroll">
						
					<div class="mc-field-group">
						<label for="mce-EMAIL">Email </label>
						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" style="border-radius: 5px;">
					</div>
						<div id="mce-responses" class="clear">
							<div class="response" id="mce-error-response" style="display:none"></div>
							<div class="response" id="mce-success-response" style="display:none"></div>
						</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					    <div style="position: absolute; left: -5000px;"><input type="text" name="b_2f7c3f6390d0e389e5a73d4b7_73f14c9734" tabindex="-1" value=""></div>
					    <div class="clear buttom-nl"><input type="submit" value="Suscríbirme" name="subscribe" id="mc-embedded-subscribe" class="button buttom-newsletter"></div>
					    </div>
					</form>
					</div>
					<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email'; /*
					 * Translated default messages for the $ validation plugin.
					 * Locale: ES
					 */
					$.extend($.validator.messages, {
					  required: "Este campo es obligatorio.",
					  remote: "Por favor, rellena este campo.",
					  email: "Por favor, escribe una dirección de correo válida",
					  url: "Por favor, escribe una URL válida.",
					  date: "Por favor, escribe una fecha válida.",
					  dateISO: "Por favor, escribe una fecha (ISO) válida.",
					  number: "Por favor, escribe un número entero válido.",
					  digits: "Por favor, escribe sólo dígitos.",
					  creditcard: "Por favor, escribe un número de tarjeta válido.",
					  equalTo: "Por favor, escribe el mismo valor de nuevo.",
					  accept: "Por favor, escribe un valor con una extensión aceptada.",
					  maxlength: $.validator.format("Por favor, no escribas más de {0} caracteres."),
					  minlength: $.validator.format("Por favor, no escribas menos de {0} caracteres."),
					  rangelength: $.validator.format("Por favor, escribe un valor entre {0} y {1} caracteres."),
					  range: $.validator.format("Por favor, escribe un valor entre {0} y {1}."),
					  max: $.validator.format("Por favor, escribe un valor menor o igual a {0}."),
					  min: $.validator.format("Por favor, escribe un valor mayor o igual a {0}.")
					});}(jQuery));var $mcj = jQuery.noConflict(true);</script>
					<!--End mc_embed_signup-->
					<div>Suscribete a nuestra newsletter y recibirás cada 15 días una selección de los mejores contenidos, noticias y sorteos de Bogadia en tu correo electrónico.</div>					
					<img style="margin-top: 20px;" src="https://www.bogadia.com/wp-content/uploads/2015/08/newsletter-example.jpg" alt="Ejemplo newsletter" />
				</div>
				<img class="img-bolso-newsletter" src="https://www.bogadia.com/wp-content/uploads/2015/08/modelo-bolso-gris.jpg" alt="Bolso Parfois" />				
				<div style="margin-top: 65px; font-size: 20px; line-height: 33px; text-align: center;">Suscribete a nuestra newsletter antes del 14 de septiembre y entrarás en el sorteo de un bolso de la firma Parfois.<br>Así de sencillo. ¿A qué esperas?
					<img style="margin: 50px auto 0px auto; display: block; float: right;" src="https://www.bogadia.com/wp-content/uploads/2015/08/bolso_parfois-gris.jpg" alt="Bolso Parfois" />
				</div>
			</div>
        <?php if ( sq_option( 'page_comments', 0 ) == 1 ): ?>

            <!-- Begin Comments -->
            <?php comments_template( '', true ); ?>
            <!-- End Comments -->

        <?php endif; ?>

	<?php endwhile;

endif;
?>
        
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>