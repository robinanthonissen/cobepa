<?php
/**
 * ACF Options pages
 */

if ( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Website',
		'menu_title'	=> 'Website',
		'menu_slug' 	=> 'website-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

/**
 * Set default ACF values
 */

add_filter('acf/load_field/type=select', 'set_default_true_false_value');
add_filter('acf/load_field/type=true_false', 'set_default_true_false_value');
function set_default_true_false_value($field) {
    $field['ui'] = true;
    return $field;
}

add_filter('acf/load_field/type=wysiwyg', 'set_default_wysiwyg_value');
function set_default_wysiwyg_value($field) {
    $field['media_upload'] = false;
    return $field;
}

add_filter('acf/load_field/type=repeater', 'set_default_repeater_value');
function set_default_repeater_value($field) {
    $field['layout'] = 'row';
    return $field;
}

/**
 * ACF - Add sync WP-CLI command to use on install
 */

class ACF_Command {
	function sync($args, $assoc_args) {
		$groups = acf_get_field_groups();
		$sync   = [];
		if (empty($groups)) {
			return WP_CLI::success('> Nothing to synchronize.');
		}
		foreach ($groups as $group) {
			$local    = acf_maybe_get($group, 'local', false);
			$modified = acf_maybe_get($group, 'modified', 0);
			$private  = acf_maybe_get($group, 'private', false);
			if ($local !== 'json' || $private) {
			} elseif ( ! $group['ID']) {
				$sync[$group['key']] = $group;
			} elseif ($modified && $modified > get_post_modified_time('U', true, $group['ID'], true)) {
				$sync[$group['key']] = $group;
			}
		}
		if (empty($sync)) {
			return WP_CLI::success('> Nothing to synchronize.');
		}
		if ( ! empty($sync)) {
			$new_ids = array();
			foreach ($sync as $key => $v) {
				if (acf_have_local_fields($key)) {
					$sync[$key]['fields'] = acf_get_fields($key);
				}
				$field_group = acf_import_field_group($sync[$key]);
			}
			WP_CLI::success('> ACF has been synchronized successfull.');
		}
	}
}
if (defined('WP_CLI') && WP_CLI) {
	WP_CLI::add_command('acf', 'ACF_Command');
}

?>