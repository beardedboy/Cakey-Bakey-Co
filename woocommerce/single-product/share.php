<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>

<?php do_action( 'woocommerce_share' ); 

$content = '';
$content .= '<div class = "single_product_info_desc_container">';
$content .= '<h2 class = "h4 single_product_info_desc_title">Share</h2>';
$content .= "</div><!-- end single_product_info_desc_container -->";

echo $content;

?>