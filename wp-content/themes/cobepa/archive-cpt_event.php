<?php
/**
 * Evenementen – overzicht (/evenementen/)
 *
 * De main query wordt aangepast in functions/events.php (cobepa_event_archive_query):
 * aankomend/afgelopen, filter op discipline en paarden/pony's, 20 per pagina.
 */

$context = Timber::context();

$context['title']   = post_type_archive_title( '', false );
$context['intro']   = get_field( 'events_intro', 'option' );
$context['posts']   = new Timber\PostQuery( false, 'CobepaEvent' );
$context['groups']  = cobepa_group_events_by_month( $context['posts'] );
$context['filter']  = cobepa_event_filter_links();
$context['breadcrumbs'] = array(
	array( 'title' => __( 'Home', 'cobepa' ), 'link' => home_url( '/' ) ),
	array( 'title' => $context['title'], 'link' => get_post_type_archive_link( 'cpt_event' ) ),
);

Timber::render( 'archive-cpt_event.twig', $context );
