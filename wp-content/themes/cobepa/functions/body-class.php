<?php

add_action( 'body_class', 'mint_body_class' );

if ( ! function_exists( 'mint_body_class' ) ) {
	function mint_body_class($classes) {
		if ( ! is_404() && ! is_admin() ) {
			global $post;
			$id = $post->ID;
			$format = get_post_format( $post->ID );
			// Page Name
			if ( is_page() ) {
				$pn = $post->post_name;
				$classes[] = "page--".$pn."";
			}
			// Page Parent Name
			$post_parent = get_post($post->post_parent);
			$parentSlug = $post_parent->post_name;
			if ( is_page() && $post->post_parent ) {
				$classes[] = "parent-".$parentSlug;
			}
			// Post Category Name
			foreach ( ( get_the_category( $post->ID ) ) as $category ) {
				$classes[] = 'category-' .$category->category_nicename;
			}
			// Page Template Name
			$temp = get_page_template();
			if ( $temp != null ) {
				$path = pathinfo($temp);
				$tmp = $path['filename'] . "." . $path['extension'];
				$tn= str_replace(".php", "", $tmp);
				$classes[] = $tn;
			}
			foreach ( $classes as $key => $value ) {
				//if ( $value == 'home' ) unset( $classes[ $key ] );
				if ( $value == 'blog' ) unset( $classes[ $key ] );
				if ( $value == 'logged-in' ) unset( $classes[ $key ] );
				if ( $value == 'page-template-default' ) unset( $classes[ $key ] );
				if ( $value == 'page-template-templates' ) unset( $classes[ $key ] );
				if ( $value == 'page-template' ) unset( $classes[ $key ] );
				if ( $value == 'page-template-'.$tn.'' ) unset( $classes[ $key ] );
				if ( $value == 'page-template-templates'.$tn.'-php' ) unset( $classes[ $key ] );
				if ( $value == 'template-page' ) unset( $classes[ $key ] );
				//if ( $value == 'page-id-'.$id.'' ) unset( $classes[ $key ] );
				//if ( $value == 'postid-'.$id.'' ) unset( $classes[ $key ] );
				if ( $value == 'single-format-standard' ) unset( $classes[ $key ] );
				if ( $value == 'single-format-'.$format.'' ) unset( $classes[ $key ] );
				if ( $value == 'category-geen-categorie' ) unset( $classes[ $key ] );
				if ( $value == 'category-no-category' ) unset( $classes[ $key ] );
			}
			return $classes;
		} else {
			return $classes;
		}
	}

}
?>
