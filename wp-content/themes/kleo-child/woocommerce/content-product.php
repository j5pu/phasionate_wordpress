<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';

/* Kleo*//*
if (sq_option('woo_product_animate', 1) == 1 ) {
    $classes[] = 'animated animate-when-almost-visible el-appear';
}*/

if (kleo_woo_get_first_image() == '') {
	$product_transition = 'single';
}
else {
	$product_transition = sq_option('woo_image_effect', 'default');
}

?>
<li <?php post_class( $classes ); ?>>
	<div class="product-loop-inner">
		<figure class="product-transition-<?php echo $product_transition; ?>">
			<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

			<a href="<?php the_permalink(); ?>">

				<?php
					/**
					 * woocommerce_before_shop_loop_item_title hook
					 *
					 * @hooked woocommerce_show_product_loop_sale_flash - 10
					 * @hooked woocommerce_template_loop_product_thumbnail - 10
					 */
					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>

			</a>

			<?php if ( sq_option( 'woo_catalog' , '0' ) != '1' ) { ?>
			<figcaption>
				<div class="shop-actions clearfix">
				<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
				</div>
			</figcaption>
			<?php } ?>
		</figure>

		<?php global $product;
		$units_sold = get_post_meta( $product->id, 'total_sales', true );
		?>

		<?php global $product;
		$product_release = get_the_time('U');
		?>

		<div class="product-details" data-pop="<?php echo $units_sold; ?>" data-release="<?php echo $product_release; ?>">

			<?php
				$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
				echo $product->get_categories( ', ', '<span class="posted_in">' . _n( '', '', $size, 'woocommerce' ) . ' ', '</span>' );
				?>			
			<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

			<p class="por_coleccion"><?php
			$subheadingvalues = get_the_terms( $product->id, 'pa_coleccion');

			if ( $subheadingvalues && ! is_wp_error( $subheadingvalues ) ) {
	      		foreach ( $subheadingvalues as $subheadingvalue ) {
	      			?>
	      			Colección <a href="<?php bloginfo('wpurl'); ?>/colecciones/<?php echo $subheadingvalue->slug ?>"><?php echo $subheadingvalue->name ?></a>
	       			<?php
		        }		
			}?>
			</p>

			<p class="por_disenador"><?php
			$subheadingvalues = get_the_terms( $product->id, 'pa_disenadora');

			if ( $subheadingvalues && ! is_wp_error( $subheadingvalues ) ) {
	      		foreach ( $subheadingvalues as $subheadingvalue ) {
	      			?>
	      			by <a href="<?php bloginfo('wpurl'); ?>/disenadores/<?php echo $subheadingvalue->slug ?>"><?php echo $subheadingvalue->name ?></a>
	       			<?php
		        }		
			}?>
			</p>
			
		</div>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
	</div>
</li>