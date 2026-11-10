<?php
/**
 * Custom taxonomies
 *
 * Evenementen hebben twee onafhankelijke taxonomies:
 *  - event_discipline: Springen / Dressuur
 *  - event_category:   Paarden / Pony's (een evenement kan beide hebben)
 *
 * Geen eigen archiefpagina's: filteren gebeurt op /evenementen/ met
 * ?discipline=… en ?voor=… (zie functions/events.php).
 */

add_action( 'init', 'cobepa_register_tax', 0 );
function cobepa_register_tax() {

	register_taxonomy( 'event_discipline', array( 'cpt_event' ), array(
		'labels'            => array(
			'name'          => __( 'Disciplines', 'cobepa' ),
			'singular_name' => __( 'Discipline', 'cobepa' ),
			'menu_name'     => __( 'Disciplines', 'cobepa' ),
			'all_items'     => __( 'Alle disciplines', 'cobepa' ),
			'edit_item'     => __( 'Discipline bewerken', 'cobepa' ),
			'add_new_item'  => __( 'Nieuwe discipline', 'cobepa' ),
			'new_item_name' => __( 'Naam nieuwe discipline', 'cobepa' ),
			'search_items'  => __( 'Disciplines zoeken', 'cobepa' ),
			'not_found'     => __( 'Geen disciplines gevonden', 'cobepa' ),
		),
		'hierarchical'      => true, // checkboxen in de editor
		'public'            => false,
		'publicly_queryable'=> false,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => false,
		'rewrite'           => false,
	) );

	register_taxonomy( 'event_category', array( 'cpt_event' ), array(
		'labels'            => array(
			'name'          => __( 'Paarden / pony\'s', 'cobepa' ),
			'singular_name' => __( 'Categorie', 'cobepa' ),
			'menu_name'     => __( 'Paarden / pony\'s', 'cobepa' ),
			'all_items'     => __( 'Alle categorieën', 'cobepa' ),
			'edit_item'     => __( 'Categorie bewerken', 'cobepa' ),
			'add_new_item'  => __( 'Nieuwe categorie', 'cobepa' ),
			'new_item_name' => __( 'Naam nieuwe categorie', 'cobepa' ),
			'search_items'  => __( 'Categorieën zoeken', 'cobepa' ),
			'not_found'     => __( 'Geen categorieën gevonden', 'cobepa' ),
		),
		'hierarchical'      => true,
		'public'            => false,
		'publicly_queryable'=> false,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'query_var'         => false,
		'rewrite'           => false,
	) );
}

/**
 * Standaardtermen aanmaken (eenmalig)
 */
add_action( 'init', 'cobepa_default_terms', 20 );
function cobepa_default_terms() {
	if ( get_option( 'cobepa_default_terms_v1' ) ) {
		return;
	}
	$defaults = array(
		'event_discipline' => array( 'springen' => 'Springen', 'dressuur' => 'Dressuur' ),
		'event_category'   => array( 'paarden' => 'Paarden', 'ponys' => 'Pony\'s' ),
	);
	foreach ( $defaults as $taxonomy => $terms ) {
		foreach ( $terms as $slug => $name ) {
			if ( ! term_exists( $slug, $taxonomy ) ) {
				wp_insert_term( $name, $taxonomy, array( 'slug' => $slug ) );
			}
		}
	}
	update_option( 'cobepa_default_terms_v1', 1 );
}
