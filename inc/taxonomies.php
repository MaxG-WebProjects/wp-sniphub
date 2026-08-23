<?php
/**
 * Taxonomies
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Taxonomy configuration table
   ========================================================== */
/**
 * Taxonomy configuration table.
 *
 * @return array Array of taxonomy configuration definitions.
 */
function wpsh_get_taxonomies_config() {
	return [
		'portfolio_category' => [
			'singular' => __( 'Portfolio Category', 'wp-sniphub' ),
			'plural' => __( 'Portfolio Categories', 'wp-sniphub' ),
			'slug' => 'categorie-portfolio',
			'post_types' => [ 'portfolio' ],
			'hierarchical' => true, // True = categories (with hierarchy), false = labels.
		],
		'event_type' => [
			'singular' => __( 'Event Type', 'wp-sniphub' ),
			'plural' => __( 'Event Types', 'wp-sniphub' ),
			'slug' => 'type-evenement',
			'post_types' => [ 'event' ],
			'hierarchical' => false,
		],
	];
}

/* ==========================================================
   Generate taxonomy labels
   ========================================================== */
/**
 * Automatically generates labels for a taxonomy.
 *
 * @param string $singular Singular label.
 * @param string $plural   Plural label.
 * @return array Array of taxonomy labels.
 */
function wpsh_generate_tax_labels( $singular, $plural ) {
	return [
		'name' => $plural,
		'singular_name' => $singular,
		/* translators: %s: plural label, lowercase */
		'search_items' => sprintf( __( 'Search %s', 'wp-sniphub' ), strtolower( $plural ) ),
		/* translators: %s: plural label, lowercase */
		'all_items' => sprintf( __( 'All %s', 'wp-sniphub' ), strtolower( $plural ) ),
		'parent_item' => __( 'Parent Category', 'wp-sniphub' ),
		'parent_item_colon' => __( 'Parent Category:', 'wp-sniphub' ),
		/* translators: %s: singular label, lowercase */
		'edit_item' => sprintf( __( 'Edit %s', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: singular label, lowercase */
		'update_item' => sprintf( __( 'Update %s', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: singular label, lowercase */
		'add_new_item' => sprintf( _x( 'Add new %s', 'custom taxonomy label', 'wp-sniphub' ), strtolower( $singular ) ),
		/* translators: %s: singular label, lowercase */
		'new_item_name' => sprintf( __( 'New %s name', 'wp-sniphub' ), strtolower( $singular ) ),
		'menu_name' => $plural,
	];
}

/* ==========================================================
   Register taxonomies
   ========================================================== */
/**
 * Main function: recording taxonomies.
 *
 * @return void
 */
function wpsh_register_taxonomies() {
	$taxonomies = wpsh_get_taxonomies_config();

	foreach ( $taxonomies as $taxonomy => $args ) {
		$labels = wpsh_generate_tax_labels( $args['singular'], $args['plural'] );

		register_taxonomy( $taxonomy, $args['post_types'], [
			'labels' => $labels,
			'hierarchical' => $args['hierarchical'],
			'show_in_rest' => true,
			'public' => true,
			'rewrite' => [ 'slug' => $args['slug'], 'with_front' => false ],
			'show_admin_column' => true,
		] );
	}
}
add_action( 'init', 'wpsh_register_taxonomies', 30 );
