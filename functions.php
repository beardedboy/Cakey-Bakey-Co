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
		$indent = str_repeat("\t");
	    $output .= "$indent</ul>\n";
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
		    'items_wrap'      => '<ul class="%2$s">%3$s</ul>',
		    'depth'           => 0,
		    'walker'          => new mainnav_walker()
		);
}


	add_action( 'init', 'register_main_nav' );

}

add_action( 'after_setup_theme', 'cakeybakeyco_setup' );

?>