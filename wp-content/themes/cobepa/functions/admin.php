<?php
// CUSTOM ADMIN CSS
if ( ! function_exists( 'custom_admin_css' ) ) {

	function custom_admin_css() {
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/src/css/wp/admin.css' );
		wp_enqueue_style( 'admin_css', get_template_directory_uri() . '/dist/index.css' );
	}

}
//add_action('admin_print_styles', 'custom_admin_css' );

// HIDE ADMIN NAVIGATION LINKS
if ( ! function_exists( 'remove_menus' ) ) {

	function remove_menus() {
		remove_menu_page( 'edit-comments.php' ); // Comments
	}

}
add_action( 'admin_menu', 'remove_menus' );
?>