<?php
if ( ! function_exists( 'custom_login_stylesheet' ) ) {
	function custom_login_stylesheet() { ?>
		<link rel="stylesheet" id="custom_wp_admin_css"  href="<?php echo get_bloginfo( 'stylesheet_directory' ) . '/src/css/wp/login.css'; ?>" type="text/css" media="all" />
	<?php }
}
add_action( 'login_enqueue_scripts', 'custom_login_stylesheet' );
?>
