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
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
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
			<div class="div-newsletter">
				<div style="max-width: 1024px; margin: 0px auto; padding: 0px 15px;">
					<h2 class="title-newsletter">¡Suscríbete a nuestra <span style="color: #c64040;">NEWSLETTER</span> y podrás <span class="size-title-newsletter">ganar</span> una crema de <span class="size-title-newsletter">Elizabeth Arden!</span></h2>
					<img class="arrow-newsletter" src="https://www.bogadia.com/wp-content/uploads/2015/08/arrow.png" alt="flecha" />
				</div>
			</div>
			<div style="max-width: 1024px; min-height: 620px; margin: 0px auto 20px; padding: 20px;">			
				<div class="part-left">
					<div class="part-left-text">Suscríbete a nuestra newsletter antes del <span style="color: #c64040; font-size: 22px;">8 de noviembre</span> y entrarás en el <span style="color: #c64040; font-size: 22px;">sorteo</span> de una crema de <span style="font-size: 22px;">Elizabeth Arden</span>.<br>Así de sencillo. ¿A qué esperas?</div>
					<img class="bolso-sorteo-newsletter" src="https://www.bogadia.com/wp-content/uploads/newsletter/sorteo-elizabeth-motita.jpg" alt="Bolso Parfois" />
					<a target="_blank" class="bases-legales-sorteo-newsletter" title="Bases legales Concurso Newsletter Bogadia" href="https://www.bogadia.com/wp-content/uploads/pdf/Bases_legales_Concurso_Newsletter.pdf">Bases legales</a>
				</div>
				<div class="part-right">
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
					<!--End mc_embed_signup-->
					<div style="font-family: 'Open Sans', sans-serif;">Suscríbete a nuestra newsletter y recibirás cada 15 días una selección de los mejores contenidos, noticias y sorteos de Bogadia en tu correo electrónico.</div>					
					<img style="margin: 20px auto 0px auto; display: block;" src="https://www.bogadia.com/wp-content/uploads/2015/08/newsletter-example.jpg" alt="Ejemplo newsletter" />
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