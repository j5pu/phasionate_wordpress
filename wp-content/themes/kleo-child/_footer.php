<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */
?>

			<?php
			/**
			 * After main part - action
			 */
			//do_action('kleo_after_main');
			?>

		</div><!-- #main -->
		<?php get_sidebar('footer');?>	
		<?php //si es la front pinto el footer_text
			/*if( is_front_page()): 
		?>
			<div class="footer-home-text">
		<?php
			do_action('kleo_after_footer');
			get_template_part('page-parts/socket');
			endif;*/
		?>	
			</div>
	</div><!-- #page -->
	
	<!-- Analytics -->
	<?php echo sq_option('analytics', ''); ?>
	
	<?php  wp_footer(); ?>
	<?php /*if( is_front_page() ):	?>
		<script src="http://www.phasionate.com/wp-content/themes/kleo/assets/js/jquery.fittext.js"></script>
 		<script src="http://www.phasionate.com/wp-content/themes/kleo/assets/js/jquery.slabtext.min.js"></script>
		<script src="http://www.phasionate.com/wp-content/themes/kleo/assets/js/background-check.min.js"></script>
		<script src="http://www.phasionate.com/wp-content/themes/kleo/assets/js/fixed-nav.js"></script>
		<script src="http://www.phasionate.com/wp-content/themes/kleo/assets/js/classie.js"></script>
		<script src="http://www.phasionate.com/wp-content/themes/kleo/assets/js/footer-js.js"></script>
	<?php
		title_post_magazine_home();
		echo '</article>';// div article class="content"

		echo '</div>'; //div container containerM
		endif;*/
	?>
		<?php 
			/**
			 * After footer hook
			 * @hooked kleo_go_up
			 * @hooked kleo_show_contact_form
			 */
		?>
			 <a class="kleo-go-top" href="#"><i class="icon-up-open-big"></i></a>
		<?php
			if( !is_front_page()):
			//do_action('kleo_after_footer');  //go_up + socket En phasionate dividido por problemas con la home().
			get_template_part('page-parts/socket');
			endif;
		?>	
</body>
</html>