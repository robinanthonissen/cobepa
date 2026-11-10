<?php
/**
 * Evenement – detailpagina (/evenementen/{slug}/)
 */

$context = Timber::context();
$event   = Timber::query_post( false, 'CobepaEvent' );

$context['post']  = $event;
$context['event'] = $event;
$context['more']  = cobepa_get_upcoming_events( array( 'number' => 3, 'exclude' => array( $event->ID ) ) );
$context['events_archive'] = get_post_type_archive_link( 'cpt_event' );
$context['breadcrumbs'] = array(
	array( 'title' => __( 'Home', 'cobepa' ), 'link' => home_url( '/' ) ),
	array( 'title' => post_type_archive_title( '', false ) ?: __( 'Evenementen', 'cobepa' ), 'link' => $context['events_archive'] ),
	array( 'title' => $event->title(), 'link' => $event->link() ),
);

if ( post_password_required( $event->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( 'single-cpt_event.twig', $context );
}
