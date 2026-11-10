<?php
/*
 * Removing dashboard widgets.
 */

add_action('admin_init', function() {
    // Remove 'Welcome' panel
    remove_action('welcome_panel', 'wp_welcome_panel');
    // Remove 'At a Glance' metabox
    remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    // Remove 'Activity' metabox
    remove_meta_box('dashboard_activity', 'dashboard', 'normal');
    // Remove 'WordPress News' metabox
    remove_meta_box('dashboard_primary', 'dashboard', 'side');
    // Remove 'Quick Draft' metabox
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    // Remove 'Pagebuilder' metabox
    remove_meta_box('so-dashboard-news', 'dashboard', 'side');
    // Remove 'Yoast' metabox
    remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'side');
    // Remove 'Gravityforms' metabox
    remove_meta_box('rg_forms_dashboard', 'dashboard', 'side');
    // Remove 'Wordfence' metabox
    remove_meta_box('wordfence_activity_report_widget', 'dashboard', 'side');
    // Remove 'Site Health' metabox
    remove_meta_box('dashboard_site_health', 'dashboard', 'normal');
});


if ( ! function_exists( 'mint_remove_dashboard_widgets' ) ) {
	function mint_remove_dashboard_widgets() {
		$widgets = array(
			'dashboard_incoming_links' => 'normal',
			'dashboard_right_now' => 'normal',
			'dashboard_plugins' => 'normal',
			'dashboard_recent_comments' => 'normal',
			'dashboard_activity' => 'normal',
			'dashboard_quick_press' => 'side',
			'dashboard_primary' => 'side',
			'dashboard_secondary' => 'side',
			'dashboard_recent_drafts' => 'side',
		);
		foreach ($widgets as $id => $context) {
			remove_meta_box($id, 'dashboard', $context);
		}
	}
}
add_action('wp_dashboard_setup', 'mint_remove_dashboard_widgets');
?>
