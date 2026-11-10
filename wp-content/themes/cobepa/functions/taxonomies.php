<?php

add_action('init', 'register_tax', 0);
function register_tax() {
    $cpt_names = array('cpt_news');

    $tax_name = 'category_news';
    $tax_slug_name = __('news-cat', 'rawd'); // unique slug name
	$tax_plural_name = ucfirst('news categories');
    $tax_singular_name = ucfirst('news category');

    $labels = array(
        'name'              => _x( $tax_plural_name, 'theme' ),
        'singular_name'     => _x( $tax_singular_name, 'theme' ),
        'search_items'      => __( 'Search '.$tax_plural_name, 'theme' ),
        'all_items'         => __( 'All '.$tax_plural_name, 'theme' ),
        'parent_item'       => __( 'Parent '.$tax_singular_name, 'theme' ),
        'parent_item_colon' => __( 'Parent: '.$tax_singular_name, 'theme' ),
        'edit_item'         => __( 'Edit '.$tax_singular_name, 'theme' ),
        'update_item'       => __( 'Update '.$tax_singular_name, 'theme' ),
        'add_new_item'      => __( 'Add New '.$tax_singular_name, 'theme' ),
        'new_item_name'     => __( 'New '.$tax_singular_name, 'theme' ),
        'menu_name'         => __( $tax_plural_name, 'theme' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => $tax_slug_name ),
    );

    //register_taxonomy( $tax_name, $cpt_names, $args );
}