<?php
/**
 * Custom post types
 */

add_action( 'init', 'cobepa_register_cpt', 0 );
function cobepa_register_cpt() {

	/**
	 * Evenementen
	 * Overzicht: /evenementen/ (archive-cpt_event.php)
	 * Detail:    /evenementen/{slug}/ (single-cpt_event.php)
	 */
	$labels = array(
		'name'                  => _x( 'Evenementen', 'post type general name', 'cobepa' ),
		'singular_name'         => _x( 'Evenement', 'post type singular name', 'cobepa' ),
		'menu_name'             => __( 'Evenementen', 'cobepa' ),
		'name_admin_bar'        => __( 'Evenement', 'cobepa' ),
		'add_new'               => __( 'Nieuw evenement', 'cobepa' ),
		'add_new_item'          => __( 'Nieuw evenement toevoegen', 'cobepa' ),
		'new_item'              => __( 'Nieuw evenement', 'cobepa' ),
		'edit_item'             => __( 'Evenement bewerken', 'cobepa' ),
		'view_item'             => __( 'Evenement bekijken', 'cobepa' ),
		'view_items'            => __( 'Evenementen bekijken', 'cobepa' ),
		'update_item'           => __( 'Evenement bijwerken', 'cobepa' ),
		'all_items'             => __( 'Alle evenementen', 'cobepa' ),
		'search_items'          => __( 'Evenementen zoeken', 'cobepa' ),
		'not_found'             => __( 'Geen evenementen gevonden', 'cobepa' ),
		'not_found_in_trash'    => __( 'Geen evenementen in de prullenbak', 'cobepa' ),
		'featured_image'        => __( 'Afbeelding evenement', 'cobepa' ),
		'set_featured_image'    => __( 'Afbeelding instellen', 'cobepa' ),
		'remove_featured_image' => __( 'Afbeelding verwijderen', 'cobepa' ),
		'archives'              => __( 'Evenementen', 'cobepa' ),
	);

	register_post_type( 'cpt_event', array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'menu_icon'          => 'dashicons-calendar-alt',
		'menu_position'      => 5,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'evenementen', 'with_front' => false ),
		'capability_type'    => 'post',
		'has_archive'        => 'evenementen',
		'hierarchical'       => false,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
		'show_in_rest'       => true,
	) );
}

/**
 * Permalinks vernieuwen na activatie van het thema (nieuwe CPT-slugs)
 */
add_action( 'after_switch_theme', function () {
	cobepa_register_cpt();
	flush_rewrite_rules();
} );
