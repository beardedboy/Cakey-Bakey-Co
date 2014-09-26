<?php
/**
 * Social Meta Tags
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;

?>

<?php 

if(is_product()){

	the_title(); //title of product

	echo wp_get_attachment_url( get_post_thumbnail_id() ); //echos main image url

echo get_post_meta( $post->ID, '_regular_price', true); //Gets regular price of static product

	$currentpost = get_post(); 
	$content = $currentpost->post_content;

	echo $content; // Description


	echo get_post_meta( $post->ID, 'subtitle', true ); //subtitle of product


	//if ( $product->is_type('variable') ) {

	//echo 'variable';
	
	//}
	//else{
	//	echo get_post_meta( $post->ID, '_regular_price', true);
	//}


}

?>

<link href="[profile_url]" rel="publisher" />  <!-- links to Google+ page -->

<!-- Twitter Card data -->
<meta name="twitter:card" content="product">
<meta name="twitter:site" content="@CakeyBakeyCo">
<meta name="twitter:creator" content="@CakeyBakeyCo">
<meta name="twitter:domain" content="cakeybakey.co">
<meta name="twitter:title" content="Coconut & Lime Cupcake">
<meta name="twitter:image:src" content="http://cakeybakeyco/coconutlimecake.jpg">
<meta name="twitter:image:width" content="800px"> <!-- optional -->
<meta name="twitter:image:height" content="800px"><!-- optional -->
<meta name="twitter:description" content="A yummy cake blah blah....">
<meta name="twitter:label1" content="Sizes">
<meta name="twitter:data1" content="Box of 6 (Large) | Box of 24 ( Small )">
<meta name="twitter:label2" content="Price">
<meta name="twitter:data2" content="£10">

<!-- Open Graph data -->
<meta property="og:title" content="Coconut & Lime Cupcake" />
<meta property="og:type" content="product" />
<meta property="og:url" content="http://cakeybakey.co" />
<meta property="og:image" content="http://cakeybakeyco/coconutlimecake.jpg" />
<meta property="og:description" content="A yummy cake blah blah...." />
<meta property="og:site_name" content="CakeyBakey Co" />
<meta property="og:price:amount" content="10.00" />
<meta property="og:price:currency" content="GBP" />