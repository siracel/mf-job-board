<?php
/**
 * Meta box met de gestructureerde vacaturevelden.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Velden: key => label (gelokaliseerd via mkv_fields()). */
function mkv_fields() {
	return array(
		'_mkv_subtitle'   => __( 'Catch phrase (subtitle)', 'mf-job-board' ),
		'_mkv_hours'      => __( 'Hours per week', 'mf-job-board' ),
		'_mkv_location'   => __( 'Location', 'mf-job-board' ),
		'_mkv_employment' => __( 'Employment type', 'mf-job-board' ),
	);
}

/** Helper om een veldwaarde op te halen. */
function mkv_get( $post_id, $key ) {
	return get_post_meta( $post_id, $key, true );
}

function mkv_add_meta_box() {
	add_meta_box(
		'mkv_details',
		__( 'Vacancy details', 'mf-job-board' ),
		'mkv_render_meta_box',
		'vacature',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'mkv_add_meta_box' );

function mkv_render_meta_box( $post ) {
	wp_nonce_field( 'mkv_save_meta', 'mkv_meta_nonce' );

	foreach ( mkv_fields() as $key => $label ) {
		$value = mkv_get( $post->ID, $key );
		printf(
			'<p style="margin:0 0 14px;"><label for="%1$s" style="display:block;font-weight:600;margin-bottom:4px;">%2$s</label>'
			. '<input type="text" id="%1$s" name="%1$s" value="%3$s" style="width:100%%;" /></p>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $value )
		);
	}

	echo '<p style="margin:0;color:#666;font-size:12px;">'
		. esc_html__( 'Tip: write the tasks, "why this fits you" and "what we offer" in the main content field above, using headings and lists.', 'mf-job-board' )
		. '</p>';
}

function mkv_save_meta( $post_id ) {
	if ( ! isset( $_POST['mkv_meta_nonce'] ) || ! wp_verify_nonce( $_POST['mkv_meta_nonce'], 'mkv_save_meta' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( array_keys( mkv_fields() ) as $key ) {
		if ( isset( $_POST[ $key ] ) ) {
			update_post_meta( $post_id, $key, sanitize_text_field( wp_unslash( $_POST[ $key ] ) ) );
		}
	}
}
add_action( 'save_post_vacature', 'mkv_save_meta' );

/** Admin-kolommen: uren en locatie tonen in de lijst. */
function mkv_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['mkv_hours']    = __( 'Hours', 'mf-job-board' );
			$new['mkv_location'] = __( 'Location', 'mf-job-board' );
		}
	}
	return $new;
}
add_filter( 'manage_vacature_posts_columns', 'mkv_admin_columns' );

function mkv_admin_column_content( $column, $post_id ) {
	if ( 'mkv_hours' === $column ) {
		echo esc_html( mkv_get( $post_id, '_mkv_hours' ) );
	}
	if ( 'mkv_location' === $column ) {
		echo esc_html( mkv_get( $post_id, '_mkv_location' ) );
	}
}
add_action( 'manage_vacature_posts_custom_column', 'mkv_admin_column_content', 10, 2 );
