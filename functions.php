<?php

function cakeybakeyco_setup(){

	function register_main_nav(){
		register_nav_menu(
			array(
				'main-nav',__( 'Main Navigation', 'cakeybakeyco' ),
				'footer-one',__( 'Footer One', 'cakeybakeyco'  ),
				'footer-two',__( 'Footer Two', 'cakeybakeyco'  ),
				'footer-three',__( 'Footer Three', 'cakeybakeyco'  )
			)
		);
	}

	add_action( 'init', 'register_main_nav' );

}

add_action( 'after_setup_theme', 'cakeybakeyco_setup' );

?>