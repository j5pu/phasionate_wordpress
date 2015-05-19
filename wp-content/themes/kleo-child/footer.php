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
			do_action('kleo_after_main');
			?>

		</div><!-- #main -->

		<?php get_sidebar('footer');?>
	
		<?php 
		/**
		 * After footer hook
		 * @hooked kleo_go_up
		 * @hooked kleo_show_contact_form
		 */
		do_action('kleo_after_footer');
		?>
		
	</div><!-- #page -->
	
	<!-- Analytics -->
	<?php echo sq_option('analytics', ''); ?>
	
	<?php wp_footer(); ?>
	
</body>
<!-- Script Facebook -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/sdk.js#xfbml=1&appId=783363955070748&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- Script Twitter -->
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<!-- Script Pinterest -->
<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
<!-- Script Instagram -->
<script>(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.src="//x.instagramfollowbutton.com/follow.js";s.parentNode.insertBefore(g,s);}(document,"script"));</script>
</html>