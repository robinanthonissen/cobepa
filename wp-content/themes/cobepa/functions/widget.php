<?php

function post_list_widget() { ?>

	<?php
	global $post;
	$args = array( 'numberposts' => -1 );
	$myposts = get_posts( $args );
	?>
	<ol>
		<?php foreach( $myposts as $post ) :  setup_postdata($post); ?>
			<li>
				<a href="<?php echo get_edit_post_link( $post->ID ); ?>">
					<img src="<?php echo get_field('case_avatar', $post->ID) ?>">
					<?php the_title(); ?> - <?php echo get_field('case_naam', $post->ID) ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ol>

<?php }

function init_custom_dashboard_widgets() {
	wp_add_dashboard_widget("postlistwidget", "Post list", "post_list_widget");
}
add_action("wp_dashboard_setup", "init_custom_dashboard_widgets");

?>
