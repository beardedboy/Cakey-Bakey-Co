<?php

 
/**************************************************************************************
***************************************************************************************

Main Navigation Walker Class

***************************************************************************************
***************************************************************************************/


class mainnav_walker extends Walker_Nav_Menu{
		/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */


	function start_el( &$output, $item, $depth, $args )
	{	
		/* The menu handle from the register_nav_menu statement in functions.php
		$theme_location = 'main-nav';

		$theme_locations = get_nav_menu_locations();

		$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );

		// Echo count of items in menu
		echo $menu_obj->count;*/

		if ($item->title == 'Basket'){

			global $woocommerce;
			$cart_url = $woocommerce->cart->get_cart_url();
			$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
			$cart_contents_count = $woocommerce->cart->cart_contents_count;
			$cart_contents = sprintf(_n('%d', '%d', $cart_contents_count, 'cakeybakeyco'), $cart_contents_count);
			$cart_total = $woocommerce->cart->get_cart_total();

			if($cart_contents_count > 0 ){
				$counter = '<span class = "badge basket_badge">'.$cart_contents_count.'</span>';
			}
			else{
				$counter = '';
			}
			$output .= '<li class = "basket_wrapper basket_link_icon-desktop">';

			$attributes  = '';
	 
			! empty ( $item->attr_title )
				// Avoid redundant titles
				and $item->attr_title !== $item->title
				and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';
	 
	 		$attributes .= ' href="' . $cart_url .'"';

			$attributes .= 'class= "basket_link_title" ';
	 
			$attributes  = trim( $attributes );
			$title       = apply_filters( 'the_title', $item->title, $item->ID );

			$item_output = '<div class="basket_link">'.$counter
                            ."$args->before<a $attributes>$args->link_before$title</a>"
							."$args->link_after$args->after"
							.'<div class = "basket">
							<ul class = "basket_list">
							<footer class = "basket_footer">
							<a class = "btn_flat btn_flat-full" href="'.$cart_url.'">View basket</a>
                            </footer><!-- end basket_footer -->
                            </div><!-- end basket -->
                            </div><!-- end basket_link -->';

		}

		else{
			if ($depth > 0) {
				$output .= '<li class = "nav_main_list_item_sublist_item">';
			}
			else{
					$output .= '<li class = "nav_main_list_item">';
			}

			$attributes  = '';
	 
			! empty ( $item->attr_title )
				// Avoid redundant titles
				and $item->attr_title !== $item->title
				and $attributes .= ' title="' . esc_attr( $item->attr_title ) .'"';
	 
			! empty ( $item->url )
				and $attributes .= ' href="' . esc_attr( $item->url ) .'"';
	 
			$attributes  = trim( $attributes );
			$title       = apply_filters( 'the_title', $item->title, $item->ID );

			$dropdown = ($args->walker->has_children) ? '<span class = "icon-dropdown"></span>' : '';

			$item_output = "$args->before<a $attributes>$args->link_before$title</a>"
							. "$args->link_after$args->after". $dropdown;

		};
	 
			// Since $output is called by reference we don't need to return anything.
			$output .= apply_filters(
				'walker_nav_menu_start_el'
				,   $item_output
				,   $item
				,   $depth
				,   $args
			);
	}
 
	/**
	 * @see Walker::start_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function start_lvl( &$output )
	{
		$output .= '<ul class="nav_main_list_item_sublist">';
	}
 
	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_lvl( &$output )
	{
	    $output .= "</ul>";
	}
 
	/**
	 * @see Walker::end_el()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	function end_el( &$output )
	{
		$output .= '</li>';
	}

	function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

	                if ( !$element )
                        return;

	                $id_field = $this->db_fields['id'];
	                $id       = $element->$id_field;
	
	                //display this element
	                $this->has_children = ! empty( $children_elements[ $id ] );
	                if ( isset( $args[0] ) && is_array( $args[0] ) ) {
	                        $args[0]['has_children'] = $this->has_children; // Backwards compatibility.
	                }

	                $cb_args = array_merge( array(&$output, $element, $depth), $args);


	                call_user_func_array(array($this, 'start_el'), $cb_args);

	
	                // descend only when the depth is right and there are childrens for this element
	                if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {
	
	                        foreach( $children_elements[ $id ] as $child ){
									//print_r($children_elements[$id]);
	                                if ( !isset($newlevel) ) {
	                                        $newlevel = true;
	                                        //start the child delimiter
	                                        $cb_args = array_merge( array(&$output, $depth), $args);
	                                        call_user_func_array(array($this, 'start_lvl'), $cb_args);
	                                }
	                                $this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
	                        }
	                        unset( $children_elements[ $id ] );
	                }
	
	                if ( isset($newlevel) && $newlevel ){
	                        //end the child delimiter
	                        $cb_args = array_merge( array(&$output, $depth), $args);
	                        call_user_func_array(array($this, 'end_lvl'), $cb_args);
	                }
	
	                //end this element
	                $cb_args = array_merge( array(&$output, $element, $depth), $args);
	                call_user_func_array(array($this, 'end_el'), $cb_args);
	        }

}
 
/**
 * Place a cart icon with number of items and total cost in the menu bar.
 *
 * Source: http://wordpress.org/plugins/woocommerce-menu-bar-cart/
 */
//add_filter('wp_nav_menu_items','sk_wcmenucart', 10, 2);

function sk_wcmenucart($menu, $args) {
 
	// Check if WooCommerce is active and add a new item to a menu assigned to Primary Navigation Menu location
	if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) || 'primary' !== $args->theme_location )
		return $menu;
 
	ob_start();
		global $woocommerce;
		$viewing_cart = __('View your shopping cart', 'cakeybakeyco');
		$start_shopping = __('Start shopping', 'cakeybakeyco');
		$cart_url = $woocommerce->cart->get_cart_url();
		$shop_page_url = get_permalink( woocommerce_get_page_id( 'shop' ) );
		$cart_contents_count = $woocommerce->cart->cart_contents_count;
		$cart_contents = sprintf(_n('%d item', '%d items', $cart_contents_count, 'cakeybakeyco'), $cart_contents_count);
		$cart_total = $woocommerce->cart->get_cart_total();
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// if ( $cart_contents_count > 0 ) {
			if ($cart_contents_count == 0) {
				$menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $shop_page_url .'" title="'. $start_shopping .'">';
			} else {
				$menu_item = '<li class="right"><a class="wcmenucart-contents" href="'. $cart_url .'" title="'. $viewing_cart .'">';
			}
 
			$menu_item .= '<i class="fa fa-shopping-cart"></i> ';
 
			$menu_item .= $cart_contents.' - '. $cart_total;
			$menu_item .= '</a></li>';
		// Uncomment the line below to hide nav menu cart item when there are no items in the cart
		// }
		echo $menu_item;
	$social = ob_get_clean();
	return $menu . $social;
 
}



/****************************************************************************************

Function to set everything up for the theme

****************************************************************************************/

function cakeybakeyco_setup(){

	// Theme Cleanup

	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');

	add_action( 'init', 'register_main_nav' );

	add_action( 'wp_enqueue_scripts', 'cbc_load_js' );	
	add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );

	add_action( 'after_setup_theme', 'woocommerce_support' );


	//Register theme menus

	function register_main_nav(){
		register_nav_menus(
			array(
				'main-nav' => __( 'Main Navigation', 'cakeybakeyco' ),
				'footer-one' => __( 'Footer One' , 'cakeybakeyco'),
				'footer-two' => __( 'Footer Two' , 'cakeybakeyco'),
				'footer-three' => __( 'Footer Three' , 'cakeybakeyco' )
			)
		);
	}


	function mainNav(){
		return array(
		    'theme_location'  => 'main-nav',
		    'menu'            => 'Main Navigation',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => 'nav_main_list',
		    'menu_id'         => '',
		    'echo'            => true,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '<ul class="%2$s"><a href = "#" class = "nav_main_btn nav_main_btn-close"><span class = "icon-close"></span>Close</a>%3$s</ul><a href="#" class = "icon-basket basket_link_icon-mobile icon-basket-empty"></a>',
		    'depth'           => 0,
		    'walker'          => new mainnav_walker()
		);
	}

	function woocommerce_support() {
	    add_theme_support( 'woocommerce' );
	}

 
	function child_manage_woocommerce_styles() {
	    //first check that woo exists to prevent fatal errors
	    if ( function_exists( 'is_woocommerce' ) ) {
	        //dequeue scripts and styles
	        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() ) {
	        	wp_dequeue_style( 'woocommerce-layout' );
				wp_dequeue_style( 'woocommerce-smallscreen' );
				wp_dequeue_style( 'woocommerce-general' );
				wp_dequeue_script( 'wc-add-to-cart' );
				wp_dequeue_script( 'wc-cart-fragments' );
				wp_dequeue_script( 'woocommerce' );
				wp_dequeue_script( 'jquery-blockui' );
				wp_dequeue_script( 'jquery-placeholder' );
	        }
	    }	 
	}


	// Register Script
	function cbc_load_js() {

		wp_deregister_script('jquery');

		wp_register_script( 'jquery', get_template_directory_uri().'js/vendor/jquery.js', false, '1.11.1', true );
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'modernizr', get_template_directory_uri().'/js/vendor/modernizr.js', false, '2.8.3', false );
		wp_enqueue_script( 'modernizr' );

		wp_register_script( 'jsmain', get_template_directory_uri().'/js/deploy/production.min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'jsmain' );

	}

}

add_action( 'after_setup_theme', 'cakeybakeyco_setup' );

?>