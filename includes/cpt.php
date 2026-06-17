<?php
/**
 * Custom Post Type 'vacature' + taxonomie 'vacature_categorie'.
 * (Interne slugs blijven 'vacature' om bestaande URL's/data niet te breken.)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function mkv_register_cpt() {

	$labels = array(
		'name'               => __( 'Vacancies', 'mf-job-board' ),
		'singular_name'      => __( 'Vacancy', 'mf-job-board' ),
		'menu_name'          => __( 'Vacancies', 'mf-job-board' ),
		'add_new'            => __( 'Add new', 'mf-job-board' ),
		'add_new_item'       => __( 'Add new vacancy', 'mf-job-board' ),
		'edit_item'          => __( 'Edit vacancy', 'mf-job-board' ),
		'new_item'           => __( 'New vacancy', 'mf-job-board' ),
		'view_item'          => __( 'View vacancy', 'mf-job-board' ),
		'search_items'       => __( 'Search vacancies', 'mf-job-board' ),
		'not_found'          => __( 'No vacancies found', 'mf-job-board' ),
		'not_found_in_trash' => __( 'No vacancies in the trash', 'mf-job-board' ),
		'all_items'          => __( 'All vacancies', 'mf-job-board' ),
	);

	$args = array(
		'labels'          => $labels,
		'public'          => true,
		'has_archive'     => false,
		'rewrite'         => array( 'slug' => 'vacature', 'with_front' => false ),
		'menu_icon'       => 'dashicons-businessperson',
		'menu_position'   => 25,
		'supports'        => array( 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest'    => true,
		'capability_type' => 'post',
	);

	register_post_type( 'vacature', $args );

	register_taxonomy(
		'vacature_categorie',
		'vacature',
		array(
			'labels'             => array(
				'name'          => __( 'Categories', 'mf-job-board' ),
				'singular_name' => __( 'Category', 'mf-job-board' ),
				'menu_name'     => __( 'Categories', 'mf-job-board' ),
			),
			'public'             => false,
			'publicly_queryable' => false,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'hierarchical'       => true,
			'show_admin_column'  => true,
			'show_in_rest'       => true,
			'rewrite'            => false,
		)
	);
}
add_action( 'init', 'mkv_register_cpt' );
