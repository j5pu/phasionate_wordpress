<?php
/**
 * Template Name: Full Width sin Titulo Interstitial
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

<?php get_template_part('page-parts/general-before-wrap-no-title'); ?>

<!-- AdSpeed.com Tag 8.0.2 for [Ad] Swarovski - Laterales 120x600 -->
<div style="float: left; margin-right: 20px; width: 121px;">
<script type="text/javascript">var asdate=new Date();var q='&tz='+asdate.getTimezoneOffset()/60 +'&ck='+(navigator.cookieEnabled?'Y':'N') +'&jv='+(navigator.javaEnabled()?'Y':'N') +'&scr='+screen.width+'x'+screen.height+'x'+screen.colorDepth +'&z='+Math.random() +'&ref='+escape(document.referrer.substr(0,255)) +'&uri='+escape(document.URL.substr(0,255));document.write('<ifr'+'ame width="120" height="600" src="'+(document.location.protocol=='https:'?'https://':'http://')+'g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=120&ht=600&target=_blank'+q+'" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"></ifr'+'ame>');</script>
<noscript><iframe width="120" height="600" src="//g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=120&ht=600&target=_blank" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"><img style="border:0px;max-width:100%;height:auto;" src="//g.adspeed.net/ad.php?do=img&aid=243394&oid=19457&wd=120&ht=600&pair=as" width="120" height="600"/></iframe>
</noscript>
</div>
<!-- AdSpeed.com End -->
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

        <?php if ( sq_option( 'page_comments', 0 ) == 1 ): ?>

            <!-- Begin Comments -->
            <?php comments_template( '', true ); ?>
            <!-- End Comments -->

        <?php endif; ?>

    <?php endwhile;

endif;
?>

<!-- AdSpeed.com Tag 8.0.2 for [Ad] Swarovski - Laterales 120x600 -->
<div style="float: left; margin-right: 20px; width: 121px;">
<script type="text/javascript">var asdate=new Date();var q='&tz='+asdate.getTimezoneOffset()/60 +'&ck='+(navigator.cookieEnabled?'Y':'N') +'&jv='+(navigator.javaEnabled()?'Y':'N') +'&scr='+screen.width+'x'+screen.height+'x'+screen.colorDepth +'&z='+Math.random() +'&ref='+escape(document.referrer.substr(0,255)) +'&uri='+escape(document.URL.substr(0,255));document.write('<ifr'+'ame width="120" height="600" src="'+(document.location.protocol=='https:'?'https://':'http://')+'g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=120&ht=600&target=_blank'+q+'" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"></ifr'+'ame>');</script>
<noscript><iframe width="120" height="600" src="//g.adspeed.net/ad.php?do=html&aid=243394&oid=19457&wd=120&ht=600&target=_blank" frameborder="0" scrolling="no" allowtransparency="true" hspace="0" vspace="0"><img style="border:0px;max-width:100%;height:auto;" src="//g.adspeed.net/ad.php?do=img&aid=243394&oid=19457&wd=120&ht=600&pair=as" width="120" height="600"/></iframe>
</noscript>
</div>
<!-- AdSpeed.com End -->

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>