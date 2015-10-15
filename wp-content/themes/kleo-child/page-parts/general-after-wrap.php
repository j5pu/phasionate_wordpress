<?php
/**
 * After content wrap
 * Used in all templates
 */
?>
<?php
$container = apply_filters('kleo_main_container_class','container');
?>

				<?php
				/**
				 * After main content - action
				 */
				do_action('kleo_after_main_content');
				?>

				</div><!--end wrap-content-->
			</div><!--end main-page-template-->
			<?php
			/**
			 * After main content - action
			 */  
			do_action('kleo_after_content');

			?>
			<?php if($container == 'container') { ?></div><!--end .row--><?php } ?>
		</div><!--end .container-->
  	<!-- AdSpeed.com Tag 8.0.2 for [Ad] Swarovski - Laterales 120x600 -->
	<div style="float: right; margin-right: 20px; width: 121px;">
		<!-- COMIENZO del código HTML de zanox-affiliate -->
		<!-- ( El código HTML no debe cambiarse en pro de una funcionalidad correcta. ) -->
		<a href="http://ad.zanox.com/ppc/?35233618C1503781728T"><img src="http://ad.zanox.com/ppv/?35233618C1503781728" align="bottom" border="0" hspace="1" alt="Aktion_120X600"></a>
		<!--FIN del código HTML de zanox-affiliate -->
	</div>
	<!-- AdSpeed.com End -->
</section>
<!--END MAIN SECTION-->