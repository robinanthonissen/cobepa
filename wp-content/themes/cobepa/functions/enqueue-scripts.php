<?php
// ENQUEUE SCRIPTS
if ( ! function_exists( 'mint_scripts ' ) ) {
	function mint_enqueue_scripts() {
		if ( ! is_admin() ) {

			$jsAppLastUpdated = filemtime( get_template_directory() . '/dist/index.js' );

			wp_deregister_script( 'jquery' );

			wp_register_script( 'app', get_template_directory_uri() . "/dist/index.js", false, $jsAppLastUpdated, true );

			wp_enqueue_script( 'app' );

		}
	}
}
add_action('wp_enqueue_scripts', 'mint_enqueue_scripts');

add_filter( 'script_loader_tag', 'add_type_to_script', 10, 3 );
function add_type_to_script( $tag, $handle, $src ) {
    if ( 'app' === $handle ) {
        $tag = '<script type="module" src="' . esc_url( $src ) . '"></script>';
    }

    return $tag;
}

if ( ! function_exists( 'wp_deregister_scripts' ) ) {
	function wp_deregister_scripts() {
		wp_deregister_script( 'wp-embed' );
	}
}
add_action( 'wp_footer', 'wp_deregister_scripts' );
?>
