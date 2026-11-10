<?php

add_action('init', 'register_cpt', 0);
function register_cpt() {
    $cpt_name = 'cpt_news';
    $slug_name = __('news', 'rawd'); // unique slug name
    $plural_name = ucfirst('news');
    $singular_name = ucfirst('news');
    
    $labels = array(
        'name'               => _x( $plural_name, 'theme' ),
        'singular_name'      => _x( $singular_name, 'theme' ),
        'menu_name'          => _x( $plural_name, 'theme' ),
        'name_admin_bar'     => _x( $plural_name, 'theme' ),
        'add_new'            => _x( 'Add New', 'theme' ),
        'add_new_item'       => __( 'Add New '.$singular_name, 'theme' ),
        'new_item'           => __( 'New '.$singular_name, 'theme' ),
        'edit_item'          => __( 'Edit '.$singular_name, 'theme' ),
        'view_item'          => __( 'View '.$singular_name, 'theme' ),
        'update_item'        => __( 'Update '.$singular_name, 'theme' ),
        'all_items'          => __( 'All '.$plural_name, 'theme' ),
        'search_items'       => __( 'Search '.$plural_name, 'theme' ),
        'parent_item_colon'  => __( 'Parent: '.$singular_name, 'theme' ),
        'not_found'          => __( 'Not found', 'theme' ),
        'not_found_in_trash' => __( 'Not found in Trash', 'theme' )
    );
    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'			 => 'dashicons-portfolio', // Menu icon -> https://developer.wordpress.org/resource/dashicons/
        'query_var'          => true,
        'rewrite'            => array( 'slug' => $slug_name ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => null,
        'supports'           => array( 'title', 'thumbnail', 'excerpt', 'editor' ),
        'show_in_rest'		 => true // Gutenberg & REST API activation
    );
    //register_post_type( $cpt_name, $args );
}