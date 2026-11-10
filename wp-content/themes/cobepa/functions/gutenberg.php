<?php
function wp_dequeue_gutenberg_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_print_styles', 'wp_dequeue_gutenberg_styles', 100 );

// new gutenberg blocks category
function rawd_block_category( $categories, $post ) {
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'rawd-blocks',
				'title' => __( 'RAWD Blocks', 'rawd' ),
			),
		)
	);
}
add_filter( 'block_categories', 'rawd_block_category', 10, 2);

//add_filter( 'use_block_editor_for_post', 'rawd_disable_gutenberg_project', 10, 2 );
function rawd_disable_gutenberg_project( $use_block_editor, $post ) {
    if( $post->post_type == 'cpt_project' ) {
        return false;
    }
    return $use_block_editor;
}

add_action( 'acf/init', 'my_acf_init' );
function my_acf_init() {

	if ( ! function_exists( 'acf_register_block' ) ) {
		return;
	}
	  
	  // Hero
	acf_register_block( array(
		'name'            => 'hero',
		'title'           => __( 'Hero', 'rawd' ),
		'description'     => __( 'Hero', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'hero', 'header' ),
	));

	// Aankomende evenementen
	acf_register_block( array(
		'name'            => 'events',
		'title'           => __( 'Evenementen', 'cobepa' ),
		'description'     => __( 'Aankomende evenementen als kaarten', 'cobepa' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'calendar-alt',
		'mode'            => 'preview',
		'supports'        => array(
			'align'  => false,
			'anchor' => true,
		),
		'keywords'        => array( 'events', 'evenementen', 'kalender' ),
	));

	// Features (icoon + titel + tekst)
	acf_register_block( array(
		'name'            => 'features',
		'title'           => __( 'Features', 'cobepa' ),
		'description'     => __( 'Raster met iconen, titels en korte tekst (bv. infrastructuur)', 'cobepa' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'grid-view',
		'mode'            => 'preview',
		'supports'        => array(
			'align'  => false,
			'anchor' => true,
		),
		'keywords'        => array( 'features', 'infrastructuur', 'iconen' ),
	));

	acf_register_block( array(
		'name'            => 'contact',
		'title'           => __( 'Contact', 'rawd' ),
		'description'     => __( 'Contact', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'contact', 'form' ),
	));

	acf_register_block( array(
		'name'            => 'cards',
		'title'           => __( 'Cards', 'rawd' ),
		'description'     => __( 'Cards', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'cards', 'items' ),
	));
	
	/*acf_register_block( array(
		'name'            => 'images-grid',
		'title'           => __( 'Images Grid', 'rawd' ),
		'description'     => __( 'Images Grid', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'images', 'grid' ),
	));*/

	acf_register_block( array(
		'name'            => 'editor',
		'title'           => __( 'Editor', 'rawd' ),
		'description'     => __( 'Editor', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'content', 'editor', 'text' ),
	));

	acf_register_block( array(
		'name'            => 'image-text',
		'title'           => __( 'Image Text', 'rawd' ),
		'description'     => __( 'Image Text', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'image', 'text' ),
	));

	/*acf_register_block( array(
		'name'            => 'news-slider',
		'title'           => __( 'News Slider', 'rawd' ),
		'description'     => __( 'News Slider', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'news', 'slider' ),
	));*/

	acf_register_block( array(
		'name'            => 'cta',
		'title'           => __( 'CTA', 'rawd' ),
		'description'     => __( 'CTA', 'rawd' ),
		'render_callback' => 'block_render_callback',
		'category'        => 'rawd-blocks',
		'icon'            => 'welcome-widgets-menus',
		'mode' 			  => 'auto',
		'supports'	      => array(
			'align'		      => false
		),
		'keywords'        => array( 'cta', 'action' ),
	));

}  

function block_render_callback( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	$context = Timber::context();
	// In de editor-preview is er geen globale post: gebruik de post die ACF doorgeeft
	$context['post'] = $post_id ? new Timber\Post( $post_id ) : new Timber\Post();
	$context['block'] = $block;
	$context['fields'] = get_fields();
	//$content['parent'] = $parent;
	$context['is_preview'] = $is_preview;
	$slug = str_replace('acf/', '', $block['name']);
	Timber::render( "views/blocks/block-{$slug}.twig", $context );
}

add_filter('allowed_block_types_all', 'allowed_blocks_function');
function allowed_blocks_function( $allowed_block_types ) {
	$allowed_block_types =  array('core/block');//, 'jetpack/layout-grid'); 
	$rawd_blocks = acf_get_block_types();
	foreach($rawd_blocks as $rawd_block) {
		array_push($allowed_block_types, $rawd_block['name']);
	}

    return $allowed_block_types;
}
?>
