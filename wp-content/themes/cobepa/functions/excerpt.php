<?php
if ( ! function_exists( 'custom_excerpt_length' ) ) {
	function custom_excerpt_length( $length ) {
		return 20;
	}
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

if ( ! function_exists( 'custom_excerpt_more' ) ) {
	function custom_excerpt_more($more) {
		global $post;
		return ''. __('...', 'THEMENAME') .'';
	}
}
add_filter('excerpt_more', 'custom_excerpt_more');
?>
