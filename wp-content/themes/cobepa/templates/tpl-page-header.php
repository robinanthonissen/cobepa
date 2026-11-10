<?php
/**
 * Template Name: Page with header
 * Description: Pagina met groene paginakop (titel, intro, optionele foto, kruimelpad).
 *
 * Velden: ACF-groep "Paginakop" (acf-json/group_cobepa_page_header.json)
 */

$context     = Timber::context();
$timber_post = new Timber\Post();

$context['post'] = $timber_post;

$image = get_field( 'header_image' );
$show_breadcrumbs = get_field( 'header_breadcrumbs' );

$context['header'] = array(
	'title'       => get_field( 'header_title' ) ?: $timber_post->title(),
	'intro'       => get_field( 'header_intro' ),
	'image'       => $image ? new Timber\Image( $image ) : null,
	'breadcrumbs' => ( null === $show_breadcrumbs || $show_breadcrumbs ) ? cobepa_breadcrumbs( $timber_post->ID ) : array(),
);

// Begint de pagina met een contact-block, dan schuift het formulier over de kop
$blocks = parse_blocks( $timber_post->post_content );
$blocks = array_values( array_filter( $blocks, function ( $block ) {
	return ! empty( $block['blockName'] );
} ) );
$context['header_overlap'] = $blocks && 'acf/contact' === $blocks[0]['blockName'];

Timber::render( 'pages/page-header.twig', $context );
