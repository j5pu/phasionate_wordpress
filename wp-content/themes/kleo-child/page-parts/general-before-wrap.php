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
	<!-- AdSpeed.com Tag 8.0.2 for [Ad] Swarovski - Laterales 120x600 -->
	<div style="float: left; margin-right: 20px; width: 121px;">
	<script type="text/javascript">var asdate=new Date();var q='&tz='+asdate.getTimezoneOffset()/60 +'&ck='+(navigator.cookieEnabled?'Y':'N') +'&jv='+(navigator.javaEnabled()?'Y':'N') +'&scr='+screen.width+'x'+screen.height+'x'+screen.colorDepth +'&z='+Math.random() +'&ref='+escape(document.referrer.substr(0,255)) +'&uri='+escape(document.URL.substr(0,255));document.write('<ifr'+'ame width="121" height="600" src="http://g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=121&ht=600&target=_blank'+q+'" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"></ifr'+'ame>');</script>
	<noscript><iframe width="121" height="600" src="http://g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=121&ht=600&target=_blank" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"><img style="border:0px;max-width:100%;height:auto;" src="http://g.adspeed.net/ad.php?do=img&aid=243394&oid=19457&wd=121&ht=600&pair=as" width="121" height="600"/></iframe>
	</noscript>
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