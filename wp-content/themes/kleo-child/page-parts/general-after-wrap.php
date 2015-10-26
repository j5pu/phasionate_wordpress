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
	<div class="bannerright">
	<!-- COMIENZO del código HTML de zanox-affiliate -->
	<!-- ( El código HTML no debe cambiarse en pro de una funcionalidad correcta. ) -->
	<a href="http://ad.zanox.com/ppc/?35378194C332490500T"><img src="http://ad.zanox.com/ppv/?35378194C332490500" align="bottom" border="0" hspace="1" alt="120X600-Vitalinea"></a>
	<!--FIN del código HTML de zanox-affiliate -->
	</div>
</section>
<!--END MAIN SECTION-->