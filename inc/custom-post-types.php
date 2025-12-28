<?php
/**
 * Custom Post Types
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Tableau de configuration des CPTs
 * Chaque entrée correspond à un CPT
 */
function wpsh_get_cpts_config() {
	return [
		'portfolio' => [
			'singular'   => 'Portfolio',
			'plural'     => 'Portfolios',
			'slug'       => 'portfolio',
			'menu_icon'  => 'dashicons-portfolio',
			'supports'   => [ 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ],
			'has_archive'=> true,
		],
		'testimonial' => [
			'singular'   => 'Témoignage',
			'plural'     => 'Témoignages',
			'slug'       => 'temoignages',
			'menu_icon'  => 'dashicons-format-quote',
			'supports'   => [ 'title', 'editor', 'thumbnail' ],
			'has_archive'=> false,
		],
		'event' => [
			'singular'   => 'Événement',
			'plural'     => 'Événements',
			'slug'       => 'evenements',
			'menu_icon'  => 'dashicons-calendar-alt',
			'supports'   => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
			'has_archive'=> true,
		],
	];
}

/**
 * Génère automatiquement les labels pour un CPT
 */
function wpsh_generate_labels( $singular, $plural ) {
	return [
		'name'               => $plural,
		'singular_name'      => $singular,
		'menu_name'          => $plural,
		'name_admin_bar'     => $singular,
		'add_new'            => 'Ajouter',
		'add_new_item'       => 'Ajouter un ' . strtolower($singular),
		'edit_item'          => 'Modifier ' . strtolower($singular),
		'new_item'           => 'Nouveau ' . strtolower($singular),
		'view_item'          => 'Voir ' . strtolower($singular),
		'search_items'       => 'Rechercher ' . strtolower($plural),
		'not_found'          => 'Aucun ' . strtolower($singular) . ' trouvé',
		'not_found_in_trash' => 'Aucun ' . strtolower($singular) . ' dans la corbeille',
	];
}

/**
 * Fonction principale : enregistrement des CPTs
 */
function wpsh_register_cpts() {
	$cpts = wpsh_get_cpts_config();

	foreach ( $cpts as $type => $args ) {
		$labels = wpsh_generate_labels( $args['singular'], $args['plural'] );

		register_post_type( $type, [
			'labels'             => $labels,
			'public'             => true,
			'show_in_rest'       => true,
			'rest_controller_class' => 'WP_REST_Posts_Controller', // Compatibilité Gutenberg / API REST.
			'supports'           => $args['supports'],
			'rewrite'            => [ 'slug' => $args['slug'], 'with_front' => false ],
			'has_archive'        => $args['has_archive'],
			'menu_icon'          => $args['menu_icon'],
			'hierarchical'       => false,
			'exclude_from_search'=> false,
			'publicly_queryable' => true,
			'show_in_menu'       => true,
			'capability_type'    => 'post',
		]);
	}
}
add_action( 'init', 'wpsh_register_cpts', 20 );


