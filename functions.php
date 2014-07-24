<?php

 
/**************************************************************************************
***************************************************************************************

Main Navigation Walker Class

***************************************************************************************
***************************************************************************************/

function cbc_GetStoreData(){
	global $woocommerce;

	return array(
		"cart_url" => $woocommerce->cart->get_cart_url(),
		"shop_page_url" => get_permalink( woocommerce_get_page_id( 'shop' ) ),
		"cart_contents_count" => $woocommerce->cart->cart_contents_count,
		"cart_contents" => sprintf(_n('%d', '%d', $cart_contents_count, 'cakeybakeyco'), $cart_contents_count),
		"cart_total" => $woocommerce->cart->get_cart_total(),
	);
}


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

			$data = cbc_GetStoreData();

			global $woocommerce;
			$cart_url = $data["cart_url"];
			$shop_page_url = $data["shop_page_url"];
			$cart_contents_count = $data["cart_contents_count"];
			$cart_contents = $data["cart_contents"];
			$cart_total = $data["cart_total"];


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

			$dropdown = $args->walker->has_children;
			$styledropdown = $dropdown ? ' nav_main_list_item-dropdown' : '';
			$icondropdown = $dropdown ? '<span class = "icon-dropdown"></span>' : '';

			if ($depth > 0) {
				$output .= '<li class = "nav_main_list_item_sublist_item">';
			}
			else{
					$output .= '<li class = "nav_main_list_item '.$styledropdown.'">';
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


			$item_output = "$args->before<a $attributes>$args->link_before$title</a>"
							. "$args->link_after$args->after". $icondropdown;

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



/****************************************************************************************

Function to set everything up for the theme

****************************************************************************************/

function cakeybakeyco_setup(){

	// Theme Cleanup

	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');

	//Register Main Navigation
	add_action( 'init', 'register_main_nav' );

	add_action( 'wp_enqueue_scripts', 'cbc_load_js' );	
	add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );

	add_action( 'after_setup_theme', 'woocommerce_support' );

	add_filter('wp_title', 'cbc_main_title', 10, 2);


	//Function to add Site title before each individual page title.  Eg. > 'Cupcakes' becomes 'Cakey Bakey Co. - Cupcakes'
	function cbc_main_title($title, $sep){
		//Get site title 
		$sep = " - ";
		$bloginfo = get_bloginfo();
		$pagetitle = $title;

		if( is_home() || is_front_page() ){

			$title = $bloginfo;
			return $title;

		}

		$title = $bloginfo.$sep.$pagetitle;

		return $title;
	}

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

	function mobileBasket(){
		$data = cbc_GetStoreData();
		$basket = '<div class = "basket_link basket_link-mobile">';

		if($data['cart_contents_count'] > 0 ){
				$basket .= '<span class = "badge basket_badge basket_badge-mobile">'.$data['cart_contents_count'].'</span>';
			}
			else{
				$basket .= '';
		}

		$basket .= '<a href="'.$data['cart_url'].'" class = "icon-basket basket_link_icon-mobile icon-basket-empty"></a>';

		$basket .= '</div>';

		return $basket;

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
		    'items_wrap'      => '<ul class="%2$s"><a href = "#" class = "nav_main_btn nav_main_btn-close"><span class = "icon-close"></span>Close</a>%3$s</ul>'.mobileBasket(),
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