<?php
/**
 * Taxonomies personnalisées
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tableau de configuration des taxonomies
 */
function wpsh_get_taxonomies_config() {
	return [
		'portfolio_category' => [
			'singular'   => 'Catégorie de Portfolio',
			'plural'     => 'Catégories de Portfolio',
			'slug'       => 'categorie-portfolio',
			'post_types' => [ 'portfolio' ],
			'hierarchical' => true, // true = catégories (avec hiérarchie), false = étiquettes
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
 * Génère automatiquement les labels pour une taxonomie
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
 * Fonction principale : enregistrement des taxonomies
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
