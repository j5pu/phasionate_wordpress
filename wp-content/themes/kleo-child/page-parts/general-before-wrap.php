<?php
/**
 * Before content wrap
 * Used in all templates
 */
?>
<?php
$main_tpl_classes = apply_filters('kleo_main_template_classes', '');

if (kleo_has_shortcode('kleo_bp_')) {
	$section_id = 'id="buddypress" ';
}	else {
	$section_id = '';
}

$container = apply_filters('kleo_main_container_class','container');
?>

<section class="container-wrap main-color">
	<div class="bannerleft">
	<!-- COMIENZO del código HTML de zanox-affiliate -->
	<!-- ( El código HTML no debe cambiarse en pro de una funcionalidad correcta. ) -->
	<a href="http://ad.zanox.com/ppc/?35378194C332490500T"><img src="http://ad.zanox.com/ppv/?35378194C332490500" align="bottom" border="0" hspace="1" alt="120X600-Vitalinea"></a>
	<!--FIN del código HTML de zanox-affiliate -->
	</div>
	<!-- AdSpeed.com End -->
	<div id="main-container" class="<?php echo $container; ?>">
		<?php if($container == 'container') { ?><div class="row"> <?php } ?>

			<?php
			/**
			 * Before main content - action
			 */
			do_action('kleo_before_content');
			?>
			<div <?php echo $section_id;?>class="template-page <?php echo $main_tpl_classes; ?>">
				<div class="wrap-content">
			
				<?php
				/**
				 * Before main content - action
				 * Cambiado para que salga el oops si no ha posts en el resultado de bisqueda
				 */
				if ( is_search() && have_posts() || is_archive() || is_singular() ) :
					do_action('kleo_before_main_content');
				endif;
				?>