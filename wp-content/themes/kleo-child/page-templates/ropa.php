<?php
/**
 * Template Name: Ropa
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
function content_ropa(){
?>
    <div id="contenidoRopa">
        <?php echo do_shortcode( '[recent_products orderby="rand" per_page="24" columns="4"]' ); ?>
    </div>
<?php
}
add_shortcode( 'contentRopa', 'content_ropa' );


/*
*
* Shortcode para la pagina de colecciones de la tienda
*
*/
function menu_ropa(){
?>
    <script src="<?php bloginfo('wpurl'); ?>/wp-content/themes/kleo-child/assets/js/menuRopa.js"></script>
    <ul class="menuRopa">

        <h2>Categoria</h2>
        <li slug="bolsos">Bolsos</li>

        <h2>Diseñador</h2>
        <?php

            $terms = get_terms("pa_disenadora");
            foreach ( $terms as $term ) {
            echo "<li attr='pa_disenadora' slug='".$term->slug."'>" . $term->name . "</li>";
            }

        ?>
        <h2>Colección</h2>
        <?php
            $terms = get_terms("pa_coleccion");
            foreach ( $terms as $term ) {
            echo "<li attr='pa_coleccion' slug='".$term->slug."'>" . $term->name . "</li>";
            }
        ?>
    </ul>
<?php
}
add_shortcode( 'menuRopa', 'menu_ropa' );

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
