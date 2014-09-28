<?php
/**
 * Single Product Price, including microdata for SEO
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">

	<p class="single_product_info_price"><?php echo wp_strip_all_tags($product->get_price_html()); ?></p>
	<meta itemprop="price" content="<?php echo wp_strip_all_tags($product->get_price_html()); ?>" />
	<meta itemprop="priceCurrency" content="<?php echo get_woocommerce_currency(); ?>" />
	<link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
	
</div>

<meta itemprop = "category" content = "Food, Beverages & Tobacco > Food Items > Bakery > Cupcakes" />

<!--<meta itemprop = "category" content = "Food, Beverages & Tobacco > Food Items > Bakery >Cakes & Dessert Bars" />-->



