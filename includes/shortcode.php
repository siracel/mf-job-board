<?php
/**
 * Shortcode [mk_vacatures] (alias [mf_jobs]) + render-helpers (lijstweergave).
 *
 * Gebruik:
 *   [mk_vacatures]                              -> kop + lijst + open sollicitatie
 *   [mk_vacatures aantal="5"]                   -> maximaal 5
 *   [mk_vacatures categorie="finance"]          -> filter op categorie-slug
 *   [mk_vacatures titel="Open positions"]       -> koptekst aanpassen
 *   [mk_vacatures info="Amersfoort"]            -> tekst rechts in de kop
 *   [mk_vacatures kop="nee"]                    -> sectiekop verbergen
 *   [mk_vacatures open_sollicitatie="nee"]      -> onderste CTA-blok verbergen
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* --------------------------------------------------------------------------
 * Helpers
 * ----------------------------------------------------------------------- */

/** Eerste categorienaam van een vacature (leeg als geen). */
function mkv_primary_category( $post_id ) {
	$terms = get_the_terms( $post_id, 'vacature_categorie' );
	if ( $terms && ! is_wp_error( $terms ) ) {
		return $terms[0]->name;
	}
	return '';
}

/** Meta-regel rechts: locatie · dienstverband. */
function mkv_row_meta( $post_id ) {
	$parts = array_filter(
		array(
			mkv_get( $post_id, '_mkv_location' ),
			mkv_get( $post_id, '_mkv_employment' ),
		)
	);
	return implode( ' &middot; ', array_map( 'esc_html', $parts ) );
}

/** Het sollicitatie-e-mailadres: instelling -> constante, daarna filterbaar. */
function mkv_apply_email_address( $post_id = 0 ) {
	$opt   = get_option( 'mkv_apply_email_opt' );
	$email = ( $opt && is_email( $opt ) ) ? $opt : MKV_APPLY_EMAIL;
	return apply_filters( 'mkv_apply_email', $email, $post_id );
}

/** Meta-chips (uren / locatie / dienstverband) — gebruikt op de detailpagina. */
function mkv_render_chips( $post_id ) {
	$chips = array(
		'clock'     => mkv_get( $post_id, '_mkv_hours' ),
		'location'  => mkv_get( $post_id, '_mkv_location' ),
		'briefcase' => mkv_get( $post_id, '_mkv_employment' ),
	);

	$out = '';
	foreach ( $chips as $icon => $value ) {
		if ( $value ) {
			$out .= sprintf(
				'<span class="mkv-chip mkv-chip--%1$s">%2$s</span>',
				esc_attr( $icon ),
				esc_html( $value )
			);
		}
	}

	return $out ? '<div class="mkv-chips">' . $out . '</div>' : '';
}

/* --------------------------------------------------------------------------
 * Lijstrij
 * ----------------------------------------------------------------------- */

function mkv_render_row( $post_id, $index ) {
	$subtitle = mkv_get( $post_id, '_mkv_subtitle' );
	$category = mkv_primary_category( $post_id );
	$meta     = mkv_row_meta( $post_id );
	$link     = get_permalink( $post_id );

	ob_start();
	?>
	<a class="mkv-row" href="<?php echo esc_url( $link ); ?>">
		<span class="mkv-row__num"><?php echo esc_html( sprintf( '%02d', $index ) ); ?></span>

		<?php if ( has_post_thumbnail( $post_id ) ) : ?>
			<span class="mkv-row__thumb"><?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'alt' => '', 'loading' => 'lazy' ) ); ?></span>
		<?php endif; ?>

		<span class="mkv-row__main">
			<span class="mkv-row__title"><?php echo esc_html( get_the_title( $post_id ) ); ?></span>
			<?php if ( $subtitle ) : ?>
				<span class="mkv-row__desc"><?php echo esc_html( $subtitle ); ?></span>
			<?php endif; ?>
		</span>

		<span class="mkv-row__aside">
			<?php if ( $category ) : ?>
				<span class="mkv-row__cat"><?php echo esc_html( $category ); ?></span>
			<?php endif; ?>
			<?php if ( $meta ) : ?>
				<span class="mkv-row__meta"><?php echo $meta; // phpcs:ignore — onderdelen al geëscaped ?></span>
			<?php endif; ?>
		</span>

		<span class="mkv-row__arrow" aria-hidden="true">
			<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
		</span>
	</a>
	<?php
	return ob_get_clean();
}

/* --------------------------------------------------------------------------
 * Open sollicitatie-blok
 * ----------------------------------------------------------------------- */

function mkv_render_open_application() {
	$email = mkv_apply_email_address( 0 );

	// Vrij in te vullen teksten uit de instellingen; leeg = vertaling als fallback.
	$title    = trim( (string) get_option( 'mkv_open_title' ) );
	$body     = trim( (string) get_option( 'mkv_open_body' ) );
	$questions = trim( (string) get_option( 'mkv_open_questions' ) );
	$btn      = trim( (string) get_option( 'mkv_open_btn' ) );

	if ( '' === $title ) {
		$title = __( "Didn't find a suitable position?", 'mf-job-board' );
	}
	if ( '' === $body ) {
		$body = __( 'We grow fast and are always looking for new talent. Send an open application and tell us how you help entrepreneurs move forward.', 'mf-job-board' );
	}
	if ( '' === $questions ) {
		$questions = __( 'Questions? Email', 'mf-job-board' );
	}
	if ( '' === $btn ) {
		$btn = __( 'Open application', 'mf-job-board' );
	}

	$mailto = 'mailto:' . antispambot( $email ) . '?subject=' . rawurlencode( $btn );

	ob_start();
	?>
	<section class="mkv-open">
		<div class="mkv-open__text">
			<h2 class="mkv-open__title"><?php echo esc_html( $title ); ?></h2>
			<p><?php echo nl2br( esc_html( $body ) ); ?></p>
			<p class="mkv-open__mail"><?php echo esc_html( $questions ); ?> <a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></p>
		</div>
		<a class="mkv-btn mkv-btn--lg" href="<?php echo esc_url( $mailto ); ?>"><?php echo esc_html( $btn ); ?>
			<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
		</a>
	</section>
	<?php
	return ob_get_clean();
}

/* --------------------------------------------------------------------------
 * De volledige lijst (kop + rijen + open sollicitatie)
 * ----------------------------------------------------------------------- */

function mkv_render_grid( $args = array(), $opts = array() ) {
	$opts = wp_parse_args(
		$opts,
		array(
			'titel'             => __( 'Open positions', 'mf-job-board' ),
			'info'              => '',
			'header'            => true,
			'open_sollicitatie' => true,
		)
	);

	$defaults = array(
		'posts_per_page' => -1,
		'post_type'      => 'vacature',
		'post_status'    => 'publish',
		'orderby'        => array( 'menu_order' => 'ASC', 'date' => 'DESC' ),
	);
	$q = new WP_Query( wp_parse_args( $args, $defaults ) );

	if ( ! $q->have_posts() ) {
		wp_reset_postdata();
		$out = '<p class="mkv-empty">' . esc_html__( 'There are no open positions at the moment. Check back soon — we are growing fast.', 'mf-job-board' ) . '</p>';
		if ( $opts['open_sollicitatie'] ) {
			$out .= mkv_render_open_application();
		}
		return $out;
	}

	$out = '';

	if ( $opts['header'] ) {
		$out .= '<header class="mkv-listhead">';
		$out .= '<h2 class="mkv-listhead__title">' . esc_html( $opts['titel'] )
			. ' <span class="mkv-listhead__count">(' . intval( $q->post_count ) . ')</span></h2>';
		if ( $opts['info'] ) {
			$out .= '<span class="mkv-listhead__info">' . esc_html( $opts['info'] ) . '</span>';
		}
		$out .= '</header>';
	}

	$out .= '<div class="mkv-list">';
	$i = 0;
	while ( $q->have_posts() ) {
		$q->the_post();
		$i++;
		$out .= mkv_render_row( get_the_ID(), $i );
	}
	$out .= '</div>';

	wp_reset_postdata();

	if ( $opts['open_sollicitatie'] ) {
		$out .= mkv_render_open_application();
	}

	return $out;
}

/* --------------------------------------------------------------------------
 * Shortcode
 * ----------------------------------------------------------------------- */

function mkv_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'aantal'            => -1,
			'categorie'         => '',
			'titel'             => '',
			'info'              => '',
			'kop'               => 'ja',
			'open_sollicitatie' => 'ja',
		),
		$atts,
		'mk_vacatures'
	);

	mkv_register_style();
	wp_enqueue_style( 'mkv-style' );

	$truthy = array( 'ja', 'yes', 'true', '1', 'on' );

	$args = array( 'posts_per_page' => intval( $atts['aantal'] ) );

	if ( ! empty( $atts['categorie'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'vacature_categorie',
				'field'    => 'slug',
				'terms'    => sanitize_title( $atts['categorie'] ),
			),
		);
	}

	$titel = ( '' !== $atts['titel'] ) ? sanitize_text_field( $atts['titel'] ) : __( 'Open positions', 'mf-job-board' );

	$opts = array(
		'titel'             => $titel,
		'info'              => sanitize_text_field( $atts['info'] ),
		'header'            => in_array( strtolower( $atts['kop'] ), $truthy, true ),
		'open_sollicitatie' => in_array( strtolower( $atts['open_sollicitatie'] ), $truthy, true ),
	);

	// Onthoud (los van de handmatige instelling) op welke pagina de lijst staat.
	if ( is_singular() && in_the_loop() && is_main_query() ) {
		$current = get_the_ID();
		if ( $current && (int) get_option( 'mkv_listing_page_auto' ) !== (int) $current ) {
			update_option( 'mkv_listing_page_auto', $current );
		}
	}

	return '<div class="mkv mkv-shortcode">' . mkv_render_grid( $args, $opts ) . '</div>';
}
add_shortcode( 'mk_vacatures', 'mkv_shortcode' );
add_shortcode( 'mf_jobs', 'mkv_shortcode' ); // gemerkte alias

/* --------------------------------------------------------------------------
 * Overzichtspagina-URL (voor "terug naar alle vacatures" + redirect)
 * Volgorde: handmatige instelling -> automatisch -> geseedde landing -> home.
 * ----------------------------------------------------------------------- */

function mkv_listing_url() {
	$url = '';

	foreach ( array( 'mkv_listing_page_id', 'mkv_listing_page_auto', 'mkv_landing_page_id' ) as $opt ) {
		$page_id = (int) get_option( $opt );
		if ( $page_id ) {
			$candidate = get_permalink( $page_id );
			if ( $candidate ) {
				$url = $candidate;
				break;
			}
		}
	}

	if ( ! $url ) {
		$url = home_url( '/' );
	}

	return apply_filters( 'mkv_listing_url', $url );
}

/* --------------------------------------------------------------------------
 * Detailpagina: velden injecteren in de thema-inhoud.
 * ----------------------------------------------------------------------- */

function mkv_inject_single_content( $content ) {
	if ( ! is_singular( 'vacature' ) || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	$post_id  = get_the_ID();
	$subtitle = mkv_get( $post_id, '_mkv_subtitle' );

	$top = '<div class="mkv mkv-detail">';
	if ( has_post_thumbnail( $post_id ) ) {
		$top .= '<div class="mkv-detail__media">' . get_the_post_thumbnail( $post_id, 'large', array( 'alt' => '' ) ) . '</div>';
	}
	if ( $subtitle ) {
		$top .= '<p class="mkv-detail__subtitle">' . esc_html( $subtitle ) . '</p>';
	}
	$top .= mkv_render_chips( $post_id );
	$top .= '<div class="mkv-single__content">';

	$bottom  = '</div>'; // .mkv-single__content
	$bottom .= mkv_render_apply( $post_id );
	$bottom .= '<p class="mkv-back"><a href="' . esc_url( mkv_listing_url() ) . '">'
		. '<span class="mkv-arrow mkv-arrow--left" aria-hidden="true">&larr;</span> '
		. esc_html__( 'Back to all vacancies', 'mf-job-board' ) . '</a></p>';
	$bottom .= '</div>'; // .mkv

	return $top . $content . $bottom;
}
add_filter( 'the_content', 'mkv_inject_single_content' );

/* --------------------------------------------------------------------------
 * Sollicitatieblok op de detailpagina (volledige breedte)
 * ----------------------------------------------------------------------- */

function mkv_render_apply( $post_id ) {
	$email    = mkv_apply_email_address( $post_id );
	$function = get_the_title( $post_id );
	/* translators: %s is the vacancy title. */
	$subject  = rawurlencode( sprintf( __( 'Application: %s', 'mf-job-board' ), $function ) );
	$mailto   = 'mailto:' . antispambot( $email ) . '?subject=' . $subject;

	ob_start();
	?>
	<aside class="mkv-apply">
		<h2 class="mkv-apply__title"><?php esc_html_e( 'Interested?', 'mf-job-board' ); ?></h2>
		<p class="mkv-apply__text"><?php esc_html_e( 'Do you want to contribute to a future in which no entrepreneur stands alone? Send your CV and a short motivation, mentioning the position title.', 'mf-job-board' ); ?></p>
		<a class="mkv-btn mkv-btn--lg" href="<?php echo esc_url( $mailto ); ?>"><?php esc_html_e( 'Apply for this position', 'mf-job-board' ); ?>
			<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14"/><path d="m13 6 6 6-6 6"/></svg>
		</a>
		<p class="mkv-apply__meta"><?php esc_html_e( 'Or email directly to', 'mf-job-board' ); ?> <a href="<?php echo esc_url( 'mailto:' . antispambot( $email ) ); ?>"><?php echo esc_html( antispambot( $email ) ); ?></a></p>
	</aside>
	<?php
	return ob_get_clean();
}
