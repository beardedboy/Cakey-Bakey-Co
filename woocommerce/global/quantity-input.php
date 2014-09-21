<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<div class="single_product_info_option_quantity">
	<label for = "<?php echo esc_attr( $input_name ); ?>" class = "single_product_info_option_quantity_label">Quantity</label>
	<input type="number" step="<?php echo esc_attr( $step ); ?>" <?php if ( is_numeric( $min_value ) ) : ?>min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?> <?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php _ex( 'Qty', 'Product quantity input tooltip', 'woocommerce' ) ?>" class="input-text qty text form_input-number single_product_info_option_quantity_input" size="4" />
	<input type="button" value="+" class="plus single_product_info_option_quantity_button" />
	<input type="button" value="-" class="minus single_product_info_option_quantity_button" />
</div>