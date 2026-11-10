<?php
// ENQUEUE STYLES
if ( ! function_exists( 'mint_enqueue_style' ) ) {
	function mint_enqueue_style() {

		$cssFileLastUpdated = filemtime( get_stylesheet_directory() . '/dist/index.css' );

		wp_register_style( 'style', get_stylesheet_directory_uri() . '/dist/index.css', false, $cssFileLastUpdated, false );

		wp_enqueue_style( 'style' );

	}
}
add_action( 'wp_enqueue_scripts', 'mint_enqueue_style' );

add_action('admin_enqueue_scripts', 'rawd_enqueue_admin_assets');
function rawd_enqueue_admin_assets() {
    $template_directory = get_template_directory();
    $template_directory_uri = get_template_directory_uri();
    $stylesheet_directory_uri = get_stylesheet_directory_uri();

    // Scripts
    /*$cache_buster = filemtime($template_directory . '/dist/index.js');
    wp_enqueue_script('index.js', $stylesheet_directory_uri . '/dist/index.js', array(), null, true);
    wp_enqueue_script('index.js', $template_directory_uri . '/dist/index.js', array(), $cache_buster, true);

    // Script vars
    $vars = array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'templateurl' => $stylesheet_directory_uri,
        'siteurl' => get_site_url()
    );
    wp_localize_script('index.js', 'vars', $vars);*/

    // Admin styles
    wp_enqueue_style('index-admin.css', get_stylesheet_directory_uri() . '/dist/index-admin.css', false, '1.0.0');

    // Admin Scripts
    wp_enqueue_script('index.js', $template_directory_uri . '/dist/index.js');
    wp_register_script('index-admin.js', $template_directory_uri . '/dist/index-admin.js');
    wp_enqueue_script('index-admin.js');
}
?>
