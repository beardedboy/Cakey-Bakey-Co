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
$internal_loop;

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

//Increase internal loop
$internal_loop++;

// Extra post classes
$classes = array();

if($woocommerce_loop['loop'] == 1 || $woocommerce_loop['loop'] == 4 || $woocommerce_loop['loop'] == 7 ){ ?>
	<div class="row product_row">
<?php }

$classes[] = 'product_container';
$classes[] = 'col-4-12';

?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a class ="product_link" href="<?php the_permalink(); ?>">

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
	<div class = "product_container_info">
	<a class = "product_link" href="<?php the_permalink(); ?>">
		<h3 class = "h3 product_container_info_title"><?php the_title(); ?></h3>
	</a>
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
	</div><!-- end product_container_info -->

</li>

<?php
if($woocommerce_loop['loop'] == 3 || $woocommerce_loop['loop'] == 6 || $woocommerce_loop['loop'] == 9 ){ ?>
	</div><!-- end row -->
	<?php
 } ?>