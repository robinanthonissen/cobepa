<?php

add_action( 'after_setup_theme', 'theme_supports' );
function theme_supports() {

	add_theme_support('post-thumbnails');
	add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
	add_theme_support( 'title-tag' );

	add_image_size( 'img-small', 600 ); // small size
	add_image_size( 'img-medium', 1000 ); // medium size
	add_image_size( 'img-large', 1200 ); // large size
	add_image_size( 'img-xlarge', 1600 ); // xlarge size
	add_image_size( 'img-xxlarge', 2000 ); // xxlarge size

	register_nav_menus( array(
		'main'			 => 'Main',
		'footer_col_1'	 => 'Footer Col 1',
		'footer_col_2'	 => 'Footer Col 2',
		'footer_col_3'	 => 'Footer Col 3',
		'legal'			 => 'Legal'
	));

	add_post_type_support( 'post', 'page-attributes' );
	add_filter( 'widget_text', 'do_shortcode' );

}

/*if ( ! function_exists( 'mint_load' ) ) {

	function mint_load() {

		add_theme_support('post-thumbnails');
  		add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );
   		add_theme_support( 'title-tag' );

    	add_image_size( 'img-small', 600 ); // small size
		add_image_size( 'img-medium', 1000 ); // medium size
		add_image_size( 'img-large', 1200 ); // large size
		add_image_size( 'img-xlarge', 1600 ); // xlarge size
		add_image_size( 'img-xxlarge', 2000 ); // xxlarge size

    	register_nav_menus( array(
			'header' => 'Main',
			'footer' => 'Footer',
    	));

		add_post_type_support( 'post', 'page-attributes' );
		add_filter( 'widget_text', 'do_shortcode' );

	}

}
add_action( 'after_setup_theme', 'mint_load' );*/
?>
