<?php
/**
 * Template Name: Designers
 *
 * Description: Template withour sidebar
 *
 * @package WordPress
 * @subpackage Kleo
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since Kleo 1.0
 */

add_filter('body_class','woocommerce_body_class');

/*
*
* Shortcode para la pagina de colecciones de la tienda
*
*/
function content_designers(){
?>
    <h1 id="designersTitle"><span style="font-family:impact">D</span><span style="font-family:Comic Sans MS">I</span><span style="font-family:Arial">S</span><span style="font-family:Luicda Sans Unicode, Lucida Grande">E</span><span style="font-family:Tahoma">Ñ</span><span style="font-family:Trebuchet MS">A</span><span style="font-family:impact">D</span><span style="font-family:Verdana">O</span><span style="font-family:Comic Sans MS">R</span><span style="font-family:Arial">E</span><span style="font-family:impact">S</span></h1>

    <div class="boxContDesigners">

    <div class="boxDesigner">
        <a href="<?php bloginfo('wpurl'); ?>/lucrecia/">
            <img class="imageBoxDesigner" src="<?php bloginfo('wpurl'); ?>/wp-content/uploads/2015/05/lucrecia-foto-bio-1024x683.jpg" alt="lucrecia pq" width="1024" height="683">
            <p>Lucrecia<span id="lucreciaTextDesign" class="descripTextDesign"></span></p>
        </a>
    </div>

    <div class="boxDesigner">
        <a href="<?php bloginfo('wpurl'); ?>/lucrecia/">
            <img class="imageBoxDesigner" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/guimmet.jpg" alt="guimmet pq" width="1024" height="683">
            <p>Guimmet<span id="guimmetTextDesign" class="descripTextDesign"></span></p>
        </a>
    </div>

    <div class="boxDesigner">
        <a href="<?php bloginfo('wpurl'); ?>/lucrecia/">
            <img class="imageBoxDesigner" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/sartoria.jpg" alt="sartoria pq" width="1024" height="683">
            <p>Sartoria</p>
        </a>
    </div>

    <div class="boxDesigner">
        <a href="<?php bloginfo('wpurl'); ?>/lucrecia/">
            <img class="imageBoxDesigner" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/mario.jpg" alt="mario pq" width="1024" height="683">
            <p>Mario</p>
        </a>
    </div>

    <div class="boxDesigner">
        <a href="<?php bloginfo('wpurl'); ?>/lucrecia/">
            <img class="imageBoxDesigner" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/blondies.jpg" alt="blondies pq" width="1024" height="683">
            <p>Blondies</p>
        </a>
    </div>

</div>
<?php
}
add_shortcode( 'designersContent', 'content_designers' );

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('no');
?>

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

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php
/*
function add_my_scriptDesigners() {
    ?><script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/scriptDesigners.js"></script><?php
}
add_action('wp_footer', 'add_my_scriptDesigners');
*/
?>

<?php get_footer(); ?>
