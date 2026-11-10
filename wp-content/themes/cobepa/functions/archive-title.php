<?php
if ( ! function_exists( 'theme_archive_title' ) ) {

	function theme_archive_title( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$title = '<span class="vcard">' . get_the_author() . '</span>';
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		} else {
			$title = single_cat_title( '', false );
		}
		return $title;
	}

}

add_filter( 'get_the_archive_title', 'theme_archive_title' );
?>
