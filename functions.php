<?php

/**************************************************************************************
***************************************************************************************

Theme WooCommerce Extensions

***************************************************************************************
***************************************************************************************/

function cbc_GetStoreData(){
	global $woocommerce;

	return array(
		"cart_url" => WC()->cart->get_cart_url(),
		"shop_page_url" => get_permalink( woocommerce_get_page_id( 'shop' ) ),
		"cart_contents_count" => WC()->cart->cart_contents_count,
		"cart_contents" => sprintf(_n('%d', '%d', $cart_contents_count, 'cakeybakeyco'), $cart_contents_count),
		"cart_items" => WC()->cart->get_cart(),
		"cart_total" => WC()->cart->get_cart_total(),
	);
}

function cbc_CartContent() { 

	$output = '';

  	if ( sizeof( WC()->cart->get_cart() ) > 0 ):

	  	foreach( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {

	  		$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
			$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(array(40,40)), $cart_item, $cart_item_key );

			$quantity = $cart_item['quantity'];
			$_desc = $cart_item['data']->post->post_excerpt;


	  		$output .= '<li class = "basket_list_item">';
			$output .= '<div class = "basket_list_item_thumb">'.$thumbnail.'</div>';
			$output .= '<div class =  "basket_list_item_detail">';
			$output .= '<a href="'.get_permalink( $_product_id ).'" class = "basket_list_item_detail_title">'.$product_name.'</a>';
			$output .= '<h2 class = "basket_list_item_detail_desc">'.$_desc.'</h2>';
			$output .= '<div class = "basket_list_item_quantity">
                            <span class ="basket_list_item_detail_quantity_title">Quantity</span>
                            <span class ="basket_list_item_detail_quantity_amount">'.$quantity.'</span>
                        </div>';
            $output .= '</div>';
	        $output .= '</li>';


	  	}
	else: $output = '<div class = "basket_empty"><h2 class = "basket_empty_title">Your basket\'s empty</h2><a class = "">Why not fill me up!</a></div>';

	endif;

	return $output;
}

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

			$data = cbc_GetStoreData();
			$cartTotal = cbc_CartContent();

			$cart_url = $data["cart_url"];
			$shop_page_url = $data["shop_page_url"];
			$cart_contents_count = $data["cart_contents_count"];
			$cart_contents = $data["cart_contents"];
			$cart_total = $data["cart_total"];
			$cart_items = $data["cart_items"];

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
							<ul class = "basket_list">'.$cartTotal.'</ul>';

			if($cart_contents_count > 0){
				$item_output .= '<div class = "basket_subtotal">
								<span class = "basket_subtotal_label">Sub-Total  </span>
								<span class = "basket_subtotal_value">'.$cart_total.'</span>
							</div><!-- end basket_subtotal -->
							<footer class = "basket_footer">
							<a class = "btn_flat btn_flat-full" href="'.$cart_url.'">View basket</a>
                            </footer><!-- end basket_footer -->
                            </div><!-- end basket -->
                            </div><!-- end basket_link -->';
            }

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

/**************************************************************************************
***************************************************************************************

Footer Navigation Walker Class

***************************************************************************************
***************************************************************************************/

class footernav_walker extends Walker_Nav_Menu
{
	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	public function start_el( &$output, $item, $depth, $args )
	{
		$output     .= '<li class = "nav_footer_list_item">';
		$attributes  = '';

		$attributes .= ' href="' . esc_attr( $item->url ) .'"';
 
		$attributes  = trim( $attributes );
		$title       = apply_filters( 'the_title', $item->title, $item->ID );
		$item_output = "<a $attributes>$args->link_before$title</a>"
						. "$args->link_after$args->after";
 
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
	public function start_lvl( &$output )
	{
		$output .= '<ul class="nav_footer_list">';
	}
 
	/**
	 * @see Walker::end_lvl()
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @return void
	 */
	public function end_lvl( &$output )
	{
		$output .= '</ul>';
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
}



/****************************************************************************************

Function to set everything up for the theme

****************************************************************************************/

function cakeybakeyco_setup(){

	// Theme Cleanup

	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wp_generator');

	// REGISTER THEME NAVIGATIONS
	add_action( 'init', 'register_main_nav' );

	add_action( 'wp_enqueue_scripts', 'cbc_load_js' );	
	add_action( 'wp_enqueue_scripts', 'child_manage_woocommerce_styles', 99 );

	//ADDS WOOCOMMERCE SUPPORT
	add_action( 'after_setup_theme', 'woocommerce_support' );

	//CHANGES PAGE TITLE
	add_filter('wp_title', 'cbc_main_title', 10, 2);

	// WOOCOMMERCE SETUP ACTIONS

	remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	add_action('woocommerce_before_main_content', 'cbc_wrapper_start', 10);
	add_action('woocommerce_after_main_content', 'cbc_wrapper_end', 10);

	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	//remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	remove_action('woocommerce_before_shop_loop_item_title','woocommerce_template_loop_product_thumbnail', 10);
	add_action('woocommerce_before_shop_loop_item_title','cbc_product_loop_img', 10);

	add_filter('woocommerce_short_description', 'cbc_filter_short_description', 10);

	//Function to add custom html tag around a products short description
	function cbc_filter_short_description( $desc ){
	    global $product;

	    $newDesc = '<div class = "product_container_info_desc">'.wp_strip_all_tags($desc).'</div>';

	    return $newDesc;
	}

	//Function echos a revised thumbnail function only
	function cbc_product_loop_img() {
		echo cbc_product_loop_thumbnail();
	}

	//Function that replaces the default thumbnail image generation in the Woocommerce product page loop with one that gives the
	//images 100% responsive width.
	function cbc_product_loop_thumbnail( $size = 'shop_catalog', $placeholder_width = 1, $placeholder_height = 0  ) {
		global $post;
		if ( has_post_thumbnail() ){
			$blah = wp_get_attachment_image_src( get_post_thumbnail_id() ,$size );
     		return '<img width="100%" class = "product_container_img" src="' . $blah[0] . '">';
		}
	}

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

		$basket .= '<a href="'.$data['cart_url'].'" class = "icon-basket basket_link_icon-mobile icon-basket-empty">';

		if($data['cart_contents_count'] > 0 ){
			$basket .= '<span class = "badge basket_badge basket_badge-mobile">'.$data['cart_contents_count'].'</span>';
		}
		else{
			$basket .= '';
		}

		$basket .= '</a></div>';

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
		    'items_wrap'      => '<div class = "nav_main_container"> <ul class="%2$s"> <a href = "#" class = "nav_main_btn nav_main_btn-close"> <span class = "icon-close"></span> Go back</a>%3$s</ul> </div>'.mobileBasket(),
		    'depth'           => 0,
		    'walker'          => new mainnav_walker()
		);
	}

	function footerNav1(){
		return array(
		    'theme_location'  => 'footer-one',
		    'menu'            => 'Footer Links #1',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => 'nav_footer_list',
		    'menu_id'         => '',
		    'echo'            => true,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '<nav class = "nav nav_footer"><h1 class = "nav_footer_title">Ordering</h1> <ul class="%2$s">%3$s</ul> </nav>',
		    'depth'           => 0,
		    'walker'          => new footernav_walker()
		);
	}

	function footerNav2(){
		return array(
		    'theme_location'  => 'footer-two',
		    'menu'            => 'Footer Links #2',
		    'container'       => '',
		    'container_class' => '',
		    'container_id'    => '',
		    'menu_class'      => 'nav_footer_list',
		    'menu_id'         => '',
		    'echo'            => true,
		    'fallback_cb'     => 'wp_page_menu',
		    'before'          => '',
		    'after'           => '',
		    'link_before'     => '',
		    'link_after'      => '',
		    'items_wrap'      => '<nav class = "nav nav_footer"><h1 class = "nav_footer_title">Information</h1> <ul class="%2$s">%3$s</ul> </nav>',
		    'depth'           => 0,
		    'walker'          => new footernav_walker()
		);
	}

	function footerNav3(){
			return array(
			    'theme_location'  => 'footer-three',
			    'menu'            => 'Footer Links #3',
			    'container'       => '',
			    'container_class' => '',
			    'container_id'    => '',
			    'menu_class'      => 'nav_footer_list',
			    'menu_id'         => '',
			    'echo'            => true,
			    'fallback_cb'     => 'wp_page_menu',
			    'before'          => '',
			    'after'           => '',
			    'link_before'     => '',
			    'link_after'      => '',
			    'items_wrap'      => '<nav class = "nav nav_footer"><h1 class = "nav_footer_title">Social</h1> <ul class="%2$s">%3$s</ul> </nav>',
			    'depth'           => 0,
			    'walker'          => new footernav_walker()
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

	/*
		WOOCOMMERCE SETUP FUNCTIONS
	*/
	function cbc_wrapper_start() {
		if(is_shop()){
			echo '<section class="main_content main_content-shop">';
		}
			else{
				echo '<section class="main_content">';
			}
	}

	function cbc_wrapper_end() {
	  echo '</section>';
	}


	// Register Script
	function cbc_load_js() {

		wp_deregister_script('jquery');

		wp_register_script( 'jquery', get_template_directory_uri().'/js/vendor/jquery.js', false, '1.11.1', true );
		wp_enqueue_script( 'jquery' );

		wp_register_script( 'modernizr', get_template_directory_uri().'/js/vendor/modernizr.js', false, '2.8.3', false );
		wp_enqueue_script( 'modernizr' );

		wp_register_script( 'jsmain', get_template_directory_uri().'/js/deploy/production.min.js', array( 'jquery' ), '1.0.0', true );
		wp_enqueue_script( 'jsmain' );

	}

}

add_action( 'after_setup_theme', 'cakeybakeyco_setup' );

?>