<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;

$tag_count = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
?>
<div class="single_product_info_desc_container">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php echo $product->get_tags( ', ', '<p class="pg">' . _n( 'Info:', 'Info:', $tag_count, 'woocommerce' ) . ' ', '.</p>' ); ?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div><!-- end single_product_info_desc_container -->