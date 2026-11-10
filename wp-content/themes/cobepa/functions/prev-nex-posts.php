<?php
function previous_post_link_looped($format, $link, $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
	if ( get_adjacent_post(false, '', true) ) {
		previous_post_link($format, $link, $in_same_term, $excluded_terms, $taxonomy);
	} else {
		$first = new WP_Query('post_type='.get_post_type().'&posts_per_page=1&order=DESC');
		$first->the_post();
		echo '<a href="' . get_permalink() . '">' . $link . '</a>';
		wp_reset_query();
	};
}

function next_post_link_looped($format, $link, $in_same_term = false, $excluded_terms = '', $taxonomy = 'category') {
	if (get_adjacent_post(false, '', false)) {
		next_post_link($format, $link, $in_same_term, $excluded_terms, $taxonomy);
	} else {
		$last = new WP_Query('post_type='.get_post_type().'&posts_per_page=1&order=ASC');
		$last->the_post();
		echo '<a href="' . get_permalink() . '">'. $link .'</a>';
		wp_reset_query();
	};
}
?>
