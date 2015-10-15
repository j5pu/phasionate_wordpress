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
	<script type="text/javascript">var asdate=new Date();var q='&tz='+asdate.getTimezoneOffset()/60 +'&ck='+(navigator.cookieEnabled?'Y':'N') +'&jv='+(navigator.javaEnabled()?'Y':'N') +'&scr='+screen.width+'x'+screen.height+'x'+screen.colorDepth +'&z='+Math.random() +'&ref='+escape(document.referrer.substr(0,255)) +'&uri='+escape(document.URL.substr(0,255));document.write('<ifr'+'ame width="121" height="600" src="http://g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=121&ht=600&target=_blank'+q+'" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"></ifr'+'ame>');</script>
	<noscript><iframe width="121" height="600" src="http://g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=121&ht=600&target=_blank" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"><img style="border:0px;max-width:100%;height:auto;" src="http://g.adspeed.net/ad.php?do=img&aid=243394&oid=19457&wd=121&ht=600&pair=as" width="121" height="600"/></iframe>
	</noscript>
	</div>
	<!-- AdSpeed.com End -->
</section>
<!--END MAIN SECTION-->