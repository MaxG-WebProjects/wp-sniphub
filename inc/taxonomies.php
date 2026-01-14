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
   Taxonomy
   ========================================================== */
/**
 * Taxonomy configuration table
 */
function wpsh_get_taxonomies_config() {
	return [
		'portfolio_category' => [
			'singular'   => 'Catégorie de Portfolio',
			'plural'     => 'Catégories de Portfolio',
			'slug'       => 'categorie-portfolio',
			'post_types' => [ 'portfolio' ],
			'hierarchical' => true, // true = categories (with hierarchy), false = labels
		],
		'event_type' => [
			'singular'   => 'Type d’événement',
			'plural'     => 'Types d’événements',
			'slug'       => 'type-evenement',
			'post_types' => [ 'event' ],
			'hierarchical' => false,
		],
	];
}

/**
 * Automatically generates labels for a taxonomy
 */
function wpsh_generate_tax_labels( $singular, $plural ) {
	return [
		'name'              => $plural,
		'singular_name'     => $singular,
		'search_items'      => 'Rechercher ' . strtolower($plural),
		'all_items'         => 'Toutes les ' . strtolower($plural),
		'parent_item'       => 'Catégorie parente',
		'parent_item_colon' => 'Catégorie parente :',
		'edit_item'         => 'Modifier ' . strtolower($singular),
		'update_item'       => 'Mettre à jour ' . strtolower($singular),
		'add_new_item'      => 'Ajouter une nouvelle ' . strtolower($singular),
		'new_item_name'     => 'Nouveau nom de ' . strtolower($singular),
		'menu_name'         => $plural,
	];
}

/**
 * Main function: recording taxonomies
 */
function wpsh_register_taxonomies() {
	$taxonomies = wpsh_get_taxonomies_config();

	foreach ( $taxonomies as $taxonomy => $args ) {
		$labels = wpsh_generate_tax_labels( $args['singular'], $args['plural'] );

		register_taxonomy( $taxonomy, $args['post_types'], [
			'labels'            => $labels,
			'hierarchical'      => $args['hierarchical'],
			'show_in_rest'      => true,
			'public'            => true,
			'rewrite'           => [ 'slug' => $args['slug'], 'with_front' => false ],
			'show_admin_column' => true,
		]);
	}
}
add_action( 'init', 'wpsh_register_taxonomies', 30 );
