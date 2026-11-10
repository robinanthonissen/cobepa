<?php
/**
 * If you are installing Timber as a Composer dependency in your theme, you'll need this block
 * to load your dependencies and initialize Timber. If you are using Timber via the WordPress.org
 * plug-in, you can safely delete this block.
 */
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists($composer_autoload) ) {
	require_once( $composer_autoload );
	$timber = new Timber\Timber();
}

/**
 * This ensures that Timber is loaded and available as a PHP class.
 * If not, it gives an error message to help direct developers on where to activate
 */
if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});
	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});
	return;
}

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;

/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class themeSite extends Timber\Site {

	public function __construct() {
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		parent::__construct();
	}

	public function add_to_context( $context ) {
		// Enkel menu's voor toegewezen locaties: Timber valt anders terug op het eerste menu
		foreach ( array( 'main', 'footer_col_1', 'footer_col_2', 'footer_col_3', 'legal' ) as $location ) {
			$context[ $location ] = has_nav_menu( $location ) ? new \Timber\Menu( $location ) : null;
		}
		
		$context['stuff'] = 'This is a test value'; // add me anywhere in a twig template to show me: {{ stuff }}
		$context['options'] = get_fields('option'); // get all ACF option fields -> example: "{{ options.analytics }}", you can use them globaly on every page
		return $context;

	}

}

new themeSite();