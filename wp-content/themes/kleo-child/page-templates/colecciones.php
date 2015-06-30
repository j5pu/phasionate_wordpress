<?php
/**
 * Template Name: Colecciones
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
function content_collections(){
?>
    <h1 id="collectionsTitle">Colecciones Bogadia</h1>
    <div class="boxContCollections">
        <div class="boxCollection">
            <h2><a href="">Phetnia</a></h2>
            <a href=""><img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/003.jpg" /></a>
            <?php echo do_shortcode('[product_attribute attribute="disenadora" filter="lucrecia" columns="4" per_page="4"]'); ?>
            <div class="descriptionCollection">
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
            </div>
        </div>
        <div class="boxCollection">
            <h2><a href="">Late West</a></h2>
            <a href=""><img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/004.jpg" /></a>
            <?php echo do_shortcode('[product_attribute attribute="disenadora" filter="la_patino" columns="4" per_page="4"]'); ?>
            <div class="descriptionCollection">
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
            </div>
        </div>
        <div class="boxCollection">
            <h2><a href="">Azalia</a></h2>
            <a href=""><img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/005.jpg" /></a>
            <?php echo do_shortcode('[product_attribute attribute="disenadora" filter="lucrecia" columns="4" per_page="4"]'); ?>
            <div class="descriptionCollection">
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
            </div>
        </div>
        <div class="boxCollection">
            <h2><a href="">Nejliu</a></h2>
            <a href=""><img class="i" src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/img/photography/006.jpg" /></a>
            <?php echo do_shortcode('[product_attribute attribute="disenadora" filter="la_patino" columns="4" per_page="4"]'); ?>
            <div class="descriptionCollection">
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
                <p>Bolsos inspirados en las etnías centroafricanas. Coloridos, salvajes y elegantes. Descubre el safari que Lucrecia ha preparado en excluvidad para Bogadia.</p>
            </div>
        </div>
    </div>
<?php
}
add_shortcode( 'collectionsContent', 'content_collections' );


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