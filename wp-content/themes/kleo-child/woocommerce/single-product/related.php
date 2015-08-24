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


$woocommerce_loop['columns'] = $columns;

$items = sq_option( 'woo_related_columns', 3 );

$coleccion = get_the_terms( $product->id, 'pa_coleccion');

$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'           => 'product',
	'post_status'         => 'publish',
	'ignore_sticky_posts' => 1,
	'posts_per_page'      => 3,
	'meta_query'          => WC()->query->get_meta_query(),
	'post__not_in'			=> array( $product->id ),
	'tax_query'           => array(
		array(
			'taxonomy' => $coleccion[0]->taxonomy,
			'terms'    => array_map( 'sanitize_title', explode( ',', $coleccion[0]->slug ) ),
			'field'    => 'slug'
		)
	)
) );

$products = new WP_Query( $args );

if ( $coleccion && ! is_wp_error( $coleccion ) ) {
	?>

	<div class="related products kleo-shop-<?php echo $items;?>">

		<div class="hr-title hr-full"><abbr><?php _e( 'Related Products', 'woocommerce' ); ?></abbr></div>
		<?php woocommerce_product_loop_start(); ?>

			<?php while ( $products->have_posts() ) : $products->the_post(); ?>

				<?php wc_get_template_part( 'content', 'product' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
		?>
	</div>
	<?php
}

wp_reset_postdata();
