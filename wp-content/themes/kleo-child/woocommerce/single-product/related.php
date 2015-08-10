<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

$related = $product->get_related( $posts_per_page );

if ( sizeof( $related ) == 0 ) return;

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'no_found_rows' 		=> 1,
	'posts_per_page' 		=> $posts_per_page,
	'orderby' 				=> $orderby,
	'post__in' 				=> $related,
	'post__not_in'			=> array( $product->id )
) );

$products = new WP_Query( $args );

$woocommerce_loop['columns'] = $columns;

$items = sq_option( 'woo_related_columns', 3 );

$subheadingvalues = get_the_terms( $product->id, 'pa_coleccion');

if ( $subheadingvalues && ! is_wp_error( $subheadingvalues ) ) {
	foreach ( $subheadingvalues as $subheadingvalue ) {
		echo do_shortcode('[product_attribute attribute="coleccion" filter="'.$subheadingvalue->slug.'" columns="3" per_page="3"]');
	}		
}else{

if ( $products->have_posts() ) : ?>

	<div class="related products kleo-shop-<?php echo $items;?>">

		<div class="hr-title hr-full"><abbr><?php _e( 'Related Products', 'woocommerce' ); ?></abbr></div>

		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

}

wp_reset_postdata();
