<?php
/* ------------------------------------------------------------------------- *

START ALL FUNCTIONS

/* ------------------------------------------------------------------------- */
add_action('after_setup_theme','mint_startup');

if( ! function_exists( 'mint_startup ' ) ) {
	function mint_startup() {
		add_action('init', 'mint_head_cleanup');
		add_filter('the_generator', 'mint_rss_version');
		add_filter('wp_head', 'mint_remove_wp_widget_recent_comments_style', 1 );
		add_action('wp_head', 'mint_remove_recent_comments_style', 1);
		add_filter('gallery_style', 'mint_gallery_style');
		add_filter('get_image_tag_class', 'mint_image_tag_class', 0, 4);
		add_filter( 'the_content', 'mint_img_unautop', 30 );
	}
}
/* ------------------------------------------------------------------------- *

WP_HEAD CLEAN UP

/* ------------------------------------------------------------------------- */
if( ! function_exists( 'mint_head_cleanup ' ) ) {
	function mint_head_cleanup() {
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_generator' );
	}
}
if( ! function_exists( 'mint_rss_version ' ) ) {
	function mint_rss_version() { return ''; }
}
if( ! function_exists( 'mint_remove_wp_ver_css_js ' ) ) {
	function mint_remove_wp_ver_css_js( $src ) {
		if ( strpos( $src, 'ver=' ) )
		$src = remove_query_arg( 'ver', $src );
		return $src;
	}
}
if( ! function_exists( 'mint_remove_wp_widget_recent_comments_style ' ) ) {
	function mint_remove_wp_widget_recent_comments_style() {
		if ( has_filter('wp_head', 'wp_widget_recent_comments_style') ) {
			remove_filter('wp_head', 'wp_widget_recent_comments_style' );
		}
	}
}
if( ! function_exists( 'mint_remove_recent_comments_style ' ) ) {
	function mint_remove_recent_comments_style() {
		global $wp_widget_factory;
		if (isset($wp_widget_factory->widgets['WP_Widget_Recent_Comments'])) {
			remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
		}
	}
}
if( ! function_exists( 'mint_gallery_style ' ) ) {
	function mint_gallery_style($css) {
		return preg_replace("!<style type='text/css'>(.*?)</style>!s", '', $css);
	}
}
/* ------------------------------------------------------------------------- *

CLEAN UP POST

/* ------------------------------------------------------------------------- */
// Clean the output of attributes of images in editor. Courtesy of SitePoint. http://www.sitepoint.com/wordpress-change-img-tag-html/
if( ! function_exists( 'mint_image_tag_class ' ) ) {
	function mint_image_tag_class($class, $id, $align, $size) {
		$align = 'align' . esc_attr($align);
		return $align;
	}
}
// Wrap images with figure tag. Courtesy of Interconnectit http://interconnectit.com/2175/how-to-remove-p-tags-from-images-in-wordpress/
if( ! function_exists( 'mint_img_unautop ' ) ) {
	function mint_img_unautop($pee) {
		$pee = preg_replace('/<p>\\s*?(<a .*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s', '<figure>$1</figure>', $pee);
		return $pee;
	}
}
?>
