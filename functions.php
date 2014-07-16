<?php

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
	public function start_el( &$output, $item, $depth, $args )
	{	

			//print_r($item);


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
		$item_output = "$args->before<a $attributes>$args->link_before$title</a>"
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
		$output .= '<ul class="nav_main_list_item_sublist">';
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


function cakeybakeyco_setup(){

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
		    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
		    'depth'           => 0,
		    'walker'          => new mainnav_walker()
		);
}


	add_action( 'init', 'register_main_nav' );

}

add_action( 'after_setup_theme', 'cakeybakeyco_setup' );

?>