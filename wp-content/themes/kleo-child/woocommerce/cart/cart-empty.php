<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

wc_print_notices();

?>

<p class="cart-empty"><?php _e( 'Your cart is currently empty.', 'woocommerce' ) ?></p>

<?php do_action( 'woocommerce_cart_is_empty' ); ?>

<p class="return-to-shop"><a class="button wc-backward" href="<?php bloginfo('wpurl'); ?>/tienda"><?php _e( 'Return To Shop', 'woocommerce' ) ?></a></p>

<div class="hr-title hr-full hr-center">
    <a href="<?php bloginfo('wpurl'); ?>/productos-bogadia"><abbr>Productos destacados</abbr></a>
</div>    

<?php echo do_shortcode( '[recent_products orderby="rand" per_page="6" columns="6"]' ); ?>