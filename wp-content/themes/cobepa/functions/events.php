<?php
/**
 * Evenementen: Timber post class, queries, filters en admin.
 *
 * ACF-velden (acf-json/group_cobepa_event.json):
 *  event_date (Ymd), event_end_date (Ymd, optioneel), time_start, time_end (H:i),
 *  arena, registration_status, registration_deadline (Ymd), registration_link,
 *  registration_info, price, schedule (repeater), documents (repeater)
 *
 * Afgeleide meta `_event_end_sort` (Ymd) = einddatum of startdatum, voor queries.
 */

if ( ! class_exists( 'Timber\Post' ) ) {
	return;
}

/* -------------------------------------------------------------------------
 * Timber post class
 * ---------------------------------------------------------------------- */

class CobepaEvent extends Timber\Post {

	const DAYS_SHORT   = array( 'zo', 'ma', 'di', 'wo', 'do', 'vr', 'za' );
	const DAYS_LONG    = array( 'zondag', 'maandag', 'dinsdag', 'woensdag', 'donderdag', 'vrijdag', 'zaterdag' );
	const MONTHS_SHORT = array( 1 => 'jan', 'feb', 'mrt', 'apr', 'mei', 'jun', 'jul', 'aug', 'sep', 'okt', 'nov', 'dec' );
	const MONTHS_LONG  = array( 1 => 'januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december' );

	const STATUS_LABELS = array(
		'open'   => 'Inschrijven open',
		'full'   => 'Volzet',
		'soon'   => 'Binnenkort',
		'closed' => 'Inschrijvingen gesloten',
		'done'   => 'Afgelopen',
	);

	const ARENA_LABELS = array(
		'binnenpiste' => 'Binnenpiste',
		'buitenpiste' => 'Buitenpiste',
		'beide'       => 'Binnen- en buitenpiste',
	);

	/** @return DateTimeImmutable|null */
	protected function date_field( $name ) {
		$raw = get_post_meta( $this->ID, $name, true );
		if ( ! $raw ) {
			return null;
		}
		$date = DateTimeImmutable::createFromFormat( '!Ymd', $raw, wp_timezone() );
		return $date ?: null;
	}

	public function start() {
		return $this->date_field( 'event_date' );
	}

	public function end() {
		$end = $this->date_field( 'event_end_date' );
		$start = $this->start();
		if ( ! $end || ! $start || $end <= $start ) {
			return null;
		}
		return $end;
	}

	public function is_multiday() {
		return (bool) $this->end();
	}

	public function is_past() {
		$last = $this->end() ?: $this->start();
		if ( ! $last ) {
			return false;
		}
		return $last->format( 'Ymd' ) < wp_date( 'Ymd' );
	}

	/* ---------- Datumweergave ---------- */

	public function day() {
		return $this->start() ? $this->start()->format( 'd' ) : '';
	}

	public function month_short() {
		return $this->start() ? self::MONTHS_SHORT[ (int) $this->start()->format( 'n' ) ] : '';
	}

	public function weekday_short() {
		return $this->start() ? self::DAYS_SHORT[ (int) $this->start()->format( 'w' ) ] : '';
	}

	/** Bv. "November 2026" – gebruikt voor de groepering per maand */
	public function month_label() {
		if ( ! $this->start() ) {
			return '';
		}
		return ucfirst( self::MONTHS_LONG[ (int) $this->start()->format( 'n' ) ] ) . ' ' . $this->start()->format( 'Y' );
	}

	/** Bv. "Zaterdag 22 november 2026" of "Za 22 – zo 23 november 2026" */
	public function date_long() {
		$s = $this->start();
		if ( ! $s ) {
			return '';
		}
		$e = $this->end();
		if ( ! $e ) {
			return ucfirst( $this->format_date( $s, true, true, true ) );
		}
		$same_month = $s->format( 'Ym' ) === $e->format( 'Ym' );
		$same_year  = $s->format( 'Y' ) === $e->format( 'Y' );
		$from = $this->format_date( $s, false, ! $same_month, ! $same_year );
		$to   = $this->format_date( $e, false, true, true );
		return ucfirst( $from ) . ' – ' . $to;
	}

	/** Korte notatie, bv. "Za 22 november 2026" */
	public function date_short() {
		$s = $this->start();
		if ( ! $s ) {
			return '';
		}
		if ( $this->end() ) {
			return $this->date_long();
		}
		return ucfirst( $this->format_date( $s, false, true, true ) );
	}

	protected function format_date( DateTimeImmutable $d, $long_day, $with_month, $with_year ) {
		$day_names = $long_day ? self::DAYS_LONG : self::DAYS_SHORT;
		$out = $day_names[ (int) $d->format( 'w' ) ] . ' ' . (int) $d->format( 'j' );
		if ( $with_month ) {
			$out .= ' ' . self::MONTHS_LONG[ (int) $d->format( 'n' ) ];
		}
		if ( $with_year ) {
			$out .= ' ' . $d->format( 'Y' );
		}
		return $out;
	}

	/** ISO-datum voor <time datetime=""> */
	public function date_iso() {
		return $this->start() ? $this->start()->format( 'Y-m-d' ) : '';
	}

	public function time_range() {
		$from = $this->meta( 'time_start' );
		$to   = $this->meta( 'time_end' );
		if ( $from && $to ) {
			return $from . ' – ' . $to;
		}
		return $from ?: '';
	}

	/* ---------- Locatie & taxonomies ---------- */

	public function arena_label() {
		$arena = $this->meta( 'arena' );
		return isset( self::ARENA_LABELS[ $arena ] ) ? self::ARENA_LABELS[ $arena ] : '';
	}

	public function discipline_names() {
		$terms = get_the_terms( $this->ID, 'event_discipline' );
		return ( $terms && ! is_wp_error( $terms ) ) ? wp_list_pluck( $terms, 'name' ) : array();
	}

	public function category_names() {
		$terms = get_the_terms( $this->ID, 'event_category' );
		return ( $terms && ! is_wp_error( $terms ) ) ? wp_list_pluck( $terms, 'name' ) : array();
	}

	/** Bv. "Springen · Pony's" of "Dressuur · Paarden & pony's" */
	public function tag_label() {
		$parts = array();
		$disciplines = $this->discipline_names();
		if ( $disciplines ) {
			$parts[] = implode( ' / ', $disciplines );
		}
		$categories = $this->category_names();
		if ( count( $categories ) > 1 ) {
			$parts[] = ucfirst( strtolower( implode( ' & ', $categories ) ) );
		} elseif ( $categories ) {
			$parts[] = $categories[0];
		}
		return implode( ' · ', $parts );
	}

	/* ---------- Inschrijving ---------- */

	/** open | full | soon | closed | done | '' (geen inschrijving) */
	public function status() {
		if ( $this->is_past() ) {
			return 'done';
		}
		$status = $this->meta( 'registration_status' );
		if ( 'open' === $status ) {
			$deadline = $this->date_field( 'registration_deadline' );
			if ( $deadline && $deadline->format( 'Ymd' ) < wp_date( 'Ymd' ) ) {
				return 'closed';
			}
		}
		return isset( self::STATUS_LABELS[ $status ] ) ? $status : '';
	}

	public function status_label() {
		$status = $this->status();
		return $status ? __( self::STATUS_LABELS[ $status ], 'cobepa' ) : '';
	}

	public function can_register() {
		$link = $this->meta( 'registration_link' );
		return 'open' === $this->status() && ! empty( $link['url'] );
	}

	public function registration_deadline_label() {
		$deadline = $this->date_field( 'registration_deadline' );
		return $deadline ? $this->format_date( $deadline, false, true, true ) : '';
	}

	/** Google Calendar-link om het evenement toe te voegen */
	public function calendar_link() {
		$s = $this->start();
		if ( ! $s ) {
			return '';
		}
		$from = $this->meta( 'time_start' );
		$to   = $this->meta( 'time_end' );
		$end  = $this->end() ?: $s;
		if ( $from && $to && ! $this->end() ) {
			$tz = wp_timezone();
			$start_dt = DateTimeImmutable::createFromFormat( 'Ymd H:i', $s->format( 'Ymd' ) . ' ' . $from, $tz );
			$end_dt   = DateTimeImmutable::createFromFormat( 'Ymd H:i', $s->format( 'Ymd' ) . ' ' . $to, $tz );
			if ( $start_dt && $end_dt ) {
				$utc = new DateTimeZone( 'UTC' );
				$dates = $start_dt->setTimezone( $utc )->format( 'Ymd\THis\Z' ) . '/' . $end_dt->setTimezone( $utc )->format( 'Ymd\THis\Z' );
			}
		}
		if ( empty( $dates ) ) {
			$dates = $s->format( 'Ymd' ) . '/' . $end->modify( '+1 day' )->format( 'Ymd' );
		}
		$location = trim( 'Rijhal Kraaienhorst ' . implode( ' ', array_filter( array(
			get_field( 'address', 'option' ),
			get_field( 'zip_code', 'option' ),
			get_field( 'city', 'option' ),
		) ) ) );
		return add_query_arg( array(
			'action'   => 'TEMPLATE',
			'text'     => rawurlencode( html_entity_decode( $this->title(), ENT_QUOTES ) ),
			'dates'    => $dates,
			'details'  => rawurlencode( $this->link() ),
			'location' => rawurlencode( $location ),
		), 'https://calendar.google.com/calendar/render' );
	}
}

// Timber 1 geeft een string (standaardklasse) of een array (post type => klasse) door
add_filter( 'Timber\PostClassMap', function ( $classmap ) {
	if ( is_string( $classmap ) ) {
		$default = ltrim( $classmap, '\\' );
		if ( 'Timber\Post' !== $default ) {
			return $classmap; // expliciet gevraagde klasse respecteren
		}
		$classmap = array();
	}
	$classmap['cpt_event'] = 'CobepaEvent';
	return $classmap;
} );

/* -------------------------------------------------------------------------
 * Sorteerdatum bijhouden
 * ---------------------------------------------------------------------- */

add_action( 'acf/save_post', 'cobepa_event_update_sort_meta', 20 );
function cobepa_event_update_sort_meta( $post_id ) {
	if ( 'cpt_event' !== get_post_type( $post_id ) ) {
		return;
	}
	$start = get_post_meta( $post_id, 'event_date', true );
	$end   = get_post_meta( $post_id, 'event_end_date', true );
	$sort  = ( $end && $end > $start ) ? $end : $start;
	update_post_meta( $post_id, '_event_end_sort', $sort ?: '00000000' );
}

/* -------------------------------------------------------------------------
 * Queries
 * ---------------------------------------------------------------------- */

/**
 * meta_query + orderby voor aankomende of afgelopen evenementen.
 * Een meerdaags evenement blijft "aankomend" tot de laatste dag voorbij is.
 */
function cobepa_event_query_args( $period = 'aankomend' ) {
	$today = wp_date( 'Ymd' );
	$past  = ( 'afgelopen' === $period );
	return array(
		'meta_query' => array(
			'relation'    => 'AND',
			'start_date'  => array(
				'key'     => 'event_date',
				'compare' => 'EXISTS',
			),
			'end_date'    => array(
				'key'     => '_event_end_sort',
				'value'   => $today,
				'compare' => $past ? '<' : '>=',
				'type'    => 'NUMERIC',
			),
		),
		'orderby'    => array( 'start_date' => $past ? 'DESC' : 'ASC', 'title' => 'ASC' ),
	);
}

/**
 * Aankomende evenementen (homepage, events-block, "andere evenementen")
 *
 * @param array $args number, exclude, disciplines (term ids), categories (term ids)
 * @return array CobepaEvent[]
 */
function cobepa_get_upcoming_events( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'number'      => 3,
		'exclude'     => array(),
		'disciplines' => array(),
		'categories'  => array(),
	) );

	$query = array_merge( array(
		'post_type'      => 'cpt_event',
		'post_status'    => 'publish',
		'posts_per_page' => (int) $args['number'],
		'post__not_in'   => (array) $args['exclude'],
		'no_found_rows'  => true,
	), cobepa_event_query_args( 'aankomend' ) );

	$tax_query = array();
	if ( $args['disciplines'] ) {
		$tax_query[] = array( 'taxonomy' => 'event_discipline', 'field' => 'term_id', 'terms' => array_map( 'intval', (array) $args['disciplines'] ) );
	}
	if ( $args['categories'] ) {
		$tax_query[] = array( 'taxonomy' => 'event_category', 'field' => 'term_id', 'terms' => array_map( 'intval', (array) $args['categories'] ) );
	}
	if ( $tax_query ) {
		$query['tax_query'] = array_merge( array( 'relation' => 'AND' ), $tax_query );
	}

	return Timber::get_posts( $query, 'CobepaEvent' );
}

/** Eerstvolgend evenement of null */
function cobepa_get_next_event() {
	$events = cobepa_get_upcoming_events( array( 'number' => 1 ) );
	return $events ? $events[0] : null;
}

/* -------------------------------------------------------------------------
 * Overzichtspagina: filters via ?periode= &discipline= &voor=
 * ---------------------------------------------------------------------- */

function cobepa_event_current_filters() {
	$period = isset( $_GET['periode'] ) ? sanitize_key( wp_unslash( $_GET['periode'] ) ) : '';
	return array(
		'periode'    => ( 'afgelopen' === $period ) ? 'afgelopen' : 'aankomend',
		'discipline' => isset( $_GET['discipline'] ) ? sanitize_title( wp_unslash( $_GET['discipline'] ) ) : '',
		'voor'       => isset( $_GET['voor'] ) ? sanitize_title( wp_unslash( $_GET['voor'] ) ) : '',
	);
}

add_action( 'pre_get_posts', 'cobepa_event_archive_query' );
function cobepa_event_archive_query( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'cpt_event' ) ) {
		return;
	}
	$filters = cobepa_event_current_filters();
	$args    = cobepa_event_query_args( $filters['periode'] );

	$query->set( 'posts_per_page', 20 );
	$query->set( 'meta_query', $args['meta_query'] );
	$query->set( 'orderby', $args['orderby'] );

	$tax_query = array();
	if ( $filters['discipline'] ) {
		$tax_query[] = array( 'taxonomy' => 'event_discipline', 'field' => 'slug', 'terms' => $filters['discipline'] );
	}
	if ( $filters['voor'] ) {
		$tax_query[] = array( 'taxonomy' => 'event_category', 'field' => 'slug', 'terms' => $filters['voor'] );
	}
	if ( $tax_query ) {
		$query->set( 'tax_query', array_merge( array( 'relation' => 'AND' ), $tax_query ) );
	}
}

/**
 * Filterknoppen voor de overzichtspagina (links, werkt zonder JavaScript)
 */
function cobepa_event_filter_links() {
	$base    = get_post_type_archive_link( 'cpt_event' );
	$current = cobepa_event_current_filters();

	$build = function ( $changes ) use ( $base, $current ) {
		$params = array_merge( $current, $changes );
		if ( 'aankomend' === $params['periode'] ) {
			unset( $params['periode'] );
		}
		return add_query_arg( array_filter( $params ), $base );
	};

	$periods = array();
	foreach ( array( 'aankomend' => __( 'Aankomend', 'cobepa' ), 'afgelopen' => __( 'Afgelopen', 'cobepa' ) ) as $key => $label ) {
		$periods[] = array(
			'label'  => $label,
			'link'   => $build( array( 'periode' => $key ) ),
			'active' => $current['periode'] === $key,
		);
	}

	$groups = array(
		'discipline' => array( 'label' => __( 'Discipline', 'cobepa' ), 'taxonomy' => 'event_discipline' ),
		'voor'       => array( 'label' => __( 'Voor', 'cobepa' ), 'taxonomy' => 'event_category' ),
	);
	$filters = array();
	foreach ( $groups as $param => $group ) {
		$terms = get_terms( array( 'taxonomy' => $group['taxonomy'], 'hide_empty' => false ) );
		if ( ! $terms || is_wp_error( $terms ) ) {
			continue;
		}
		$options = array( array(
			'label'  => __( 'Alle', 'cobepa' ),
			'link'   => $build( array( $param => '' ) ),
			'active' => '' === $current[ $param ],
		) );
		foreach ( $terms as $term ) {
			$options[] = array(
				'label'  => $term->name,
				'link'   => $build( array( $param => $term->slug ) ),
				'active' => $current[ $param ] === $term->slug,
			);
		}
		$filters[] = array( 'label' => $group['label'], 'options' => $options );
	}

	return array(
		'current'   => $current,
		'periods'   => $periods,
		'filters'   => $filters,
		'is_filtered' => $current['discipline'] || $current['voor'],
		'reset'     => $build( array( 'discipline' => '', 'voor' => '' ) ),
	);
}

/**
 * Evenementen groeperen per maand: [ ['label' => 'November 2026', 'items' => [...]], ... ]
 */
function cobepa_group_events_by_month( $events ) {
	$groups = array();
	foreach ( $events as $event ) {
		$label = $event->month_label() ?: __( 'Datum volgt', 'cobepa' );
		$last  = end( $groups );
		if ( ! $last || $last['label'] !== $label ) {
			$groups[] = array( 'label' => $label, 'items' => array() );
		}
		$groups[ count( $groups ) - 1 ]['items'][] = $event;
	}
	return $groups;
}

/* -------------------------------------------------------------------------
 * Menu: archief-item actief op detailpagina's
 * ---------------------------------------------------------------------- */

add_filter( 'timber/context', function ( $context ) {
	$context['current_archive_link'] = '';
	if ( is_singular() ) {
		$archive = get_post_type_archive_link( get_post_type() );
		if ( $archive ) {
			$context['current_archive_link'] = untrailingslashit( $archive );
		}
	}
	return $context;
} );

/* -------------------------------------------------------------------------
 * Editor: in evenementen gewone tekstblokken toelaten
 * ---------------------------------------------------------------------- */

add_filter( 'allowed_block_types_all', 'cobepa_event_allowed_blocks', 20, 2 );
function cobepa_event_allowed_blocks( $allowed, $context ) {
	if ( empty( $context->post ) || 'cpt_event' !== $context->post->post_type ) {
		return $allowed;
	}
	return array( 'core/paragraph', 'core/heading', 'core/list', 'core/list-item', 'core/quote', 'core/image' );
}

/* -------------------------------------------------------------------------
 * Admin: kolom datum + standaard sortering
 * ---------------------------------------------------------------------- */

add_filter( 'manage_cpt_event_posts_columns', function ( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['event_date'] = __( 'Datum evenement', 'cobepa' );
			$new['event_status'] = __( 'Inschrijving', 'cobepa' );
		}
	}
	unset( $new['date'] );
	return $new;
} );

add_action( 'manage_cpt_event_posts_custom_column', function ( $column, $post_id ) {
	$event = new CobepaEvent( $post_id );
	if ( 'event_date' === $column ) {
		echo esc_html( $event->date_short() ?: '—' );
		if ( $event->time_range() ) {
			echo '<br><span style="color:#646970">' . esc_html( $event->time_range() ) . '</span>';
		}
	}
	if ( 'event_status' === $column ) {
		echo esc_html( $event->status_label() ?: '—' );
	}
}, 10, 2 );

add_filter( 'manage_edit-cpt_event_sortable_columns', function ( $columns ) {
	$columns['event_date'] = 'event_date';
	return $columns;
} );

add_action( 'pre_get_posts', function ( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() || 'cpt_event' !== $query->get( 'post_type' ) ) {
		return;
	}
	$orderby = $query->get( 'orderby' );
	if ( ! $orderby || 'event_date' === $orderby ) {
		$query->set( 'meta_key', 'event_date' );
		$query->set( 'orderby', 'meta_value' );
		if ( ! $query->get( 'order' ) || ! $orderby ) {
			$query->set( 'order', 'DESC' );
		}
	}
} );
