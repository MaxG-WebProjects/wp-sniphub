<?php
/**
 * Custom Post Types
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   CPT configuration table
   ========================================================== */
/**
 * CPT configuration table.
 *
 * @return array Array of CPT configuration definitions.
 */
function wpsh_get_cpts_config() {
	return [
		'portfolio' => [
			'singular' => __( 'Portfolio', 'wp-sniphub' ),
			'plural' => __( 'Portfolios', 'wp-sniphub' ),
			'slug' => 'portfolio',
			'menu_icon' => 'dashicons-portfolio',
			'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
			'has_archive' => true,
		],
		'testimonial' => [
			'singular' => __( 'Testimonial', 'wp-sniphub' ),
			'plural' => __( 'Testimonials', 'wp-sniphub' ),
			'slug' => 'temoignages',
			'menu_icon' => 'dashicons-format-quote',
			'supports' => [ 'title', 'editor', 'thumbnail' ],
			'has_archive' => false,
		],
		'event' => [
			'singular' => __( 'Event', 'wp-sniphub' ),
			'plural' => __( 'Events', 'wp-sniphub' ),
			'slug' => 'evenements',
			'menu_icon' => 'dashicons-calendar-alt',
			'supports' => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'has_archive' => true,
		],
	];
}

/* ==========================================================
   Generate CPT labels
   ========================================================== */
/**
 * Automatically generates labels for a CPT.
 *
 * @param string $singular Singular label.
 * @param string $plural   Plural label.
 * @return array Array of CPT labels.
 */
function wpsh_generate_labels( $singular, $plural ) {
	return [
		'name' => $plural,
		'singular_name' => $singular,
		'menu_name' => $plural,
		'name_admin_bar' => $singular,
		'add_new' => __( 'Add New', 'wp-sniphub' ),
		/* translators: %s: singular label, lowercase */
		'add_new_item' => sprintf( _x( 'Add new %s', 'custom post type label', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: singular label, lowercase */
		'edit_item' => sprintf( __( 'Edit %s', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: singular label, lowercase */
		'new_item' => sprintf( __( 'New %s', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: singular label, lowercase */
		'view_item' => sprintf( __( 'View %s', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: plural label, lowercase */
		'search_items' => sprintf( __( 'Search %s', 'wp-sniphub' ), strtolower( $plural ) ),
		/* translators: %s: singular label, lowercase */
		'not_found' => sprintf( __( 'No %s found', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: singular label, lowercase */
		'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'wp-sniphub' ), strtolower( $singular ) ),
	];
}

/* ==========================================================
   Register CPTs
   ========================================================== */
/**
 * Main function: recording of CPTs.
 *
 * @return void
 */
function wpsh_register_cpts() {
	$cpts = wpsh_get_cpts_config();

	foreach ( $cpts as $type => $args ) {
		$labels = wpsh_generate_labels( $args['singular'], $args['plural'] );

		register_post_type( $type, [
			'labels' => $labels,
			'public' => true,
			'show_in_rest' => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller', // Gutenberg / REST API compatibility.
			'supports' => $args['supports'],
			'rewrite' => [ 'slug' => $args['slug'], 'with_front' => false ],
			'has_archive' => $args['has_archive'],
			'menu_icon' => $args['menu_icon'],
			'hierarchical' => false,
			'exclude_from_search' => false,
			'publicly_queryable' => true,
			'show_in_menu' => true,
			'capability_type' => 'post',
		] );
	}
}
add_action( 'init', 'wpsh_register_cpts', 20 );
