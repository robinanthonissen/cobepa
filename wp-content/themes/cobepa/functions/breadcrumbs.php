<?php
/**
 * Kruimelpad: Home › (bovenliggende pagina's) › huidige pagina
 *
 * @param int|null $post_id
 * @return array [ ['title' => '', 'link' => ''], ... ]
 */
function cobepa_breadcrumbs( $post_id = null ) {
	$post_id = $post_id ?: get_queried_object_id();
	$crumbs  = array(
		array( 'title' => __( 'Home', 'cobepa' ), 'link' => home_url( '/' ) ),
	);
	if ( ! $post_id || (int) get_option( 'page_on_front' ) === (int) $post_id ) {
		return $crumbs;
	}
	foreach ( array_reverse( get_post_ancestors( $post_id ) ) as $ancestor ) {
		$crumbs[] = array( 'title' => get_the_title( $ancestor ), 'link' => get_permalink( $ancestor ) );
	}
	$crumbs[] = array( 'title' => get_the_title( $post_id ), 'link' => get_permalink( $post_id ) );
	return $crumbs;
}
