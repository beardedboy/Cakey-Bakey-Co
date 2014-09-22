<?php
/**
 * Subtitle
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $post, $product;

$content = '';
$content .= '<div class = "single_product_info_desc_container">';
$content .= '<h2 class = "h4 single_product_info_desc_title">Allergy Advice</h2>';
$content .=  "<div class = 'pg single_product_info_desc_content'>".get_post_meta( $post->ID, 'allergy', true )."</div><!-- end .single_product_info_subtitle -->";
$content .= "</h2>";
$content .= "</div><!-- end single_product_info_desc_container -->";

echo $content;
?>
