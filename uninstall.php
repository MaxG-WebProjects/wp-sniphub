<?php
/**
 * Uninstall WPSnipHub.
 *
 * Removes every trace of the plugin from the database: its options, its transient,
 * the `admin_color` user-meta value it may have set, and all content created through
 * its custom post types and taxonomies (portfolio items, testimonials, events, and
 * their terms). Once the plugin is gone, these post types/taxonomies are no longer
 * registered, so that content can no longer appear anywhere in the Dashboard — leaving
 * it in the database would just be orphaned, inaccessible rows.
 *
 * @package WPSnipHub
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Load the CPT/taxonomy config functions (single source of truth), without relying on
// the plugin's normal `init`-hooked registration, which never fires this late in the
// uninstall request.
require_once __DIR__ . '/inc/custom-post-types.php';
require_once __DIR__ . '/inc/taxonomies.php';

// Register the post types/taxonomies just long enough for this script to safely use
// the standard `get_posts()`/`get_terms()`/`wp_delete_post()`/`wp_delete_term()` APIs,
// which otherwise cannot resolve unregistered post types/taxonomies correctly.
wpsh_register_cpts();
wpsh_register_taxonomies();

/* ==========================================================
   Options
   ========================================================== */

$wpsh_options_to_delete = [
	'wpsh_enabled_modules',
	'square_size_w',
	'square_size_h',
	'fullhd_size_w',
	'fullhd_size_h',
];

foreach ( $wpsh_options_to_delete as $wpsh_option_name ) {
	delete_option( $wpsh_option_name );
}

/* ==========================================================
   Transients
   ========================================================== */

delete_transient( 'wpsh_missing_featured_image' );

/* ==========================================================
   Custom post type & taxonomy content
   ========================================================== */

// Delete posts first: wp_delete_post() with force-delete also removes their postmeta,
// comments, and term relationships, so no orphaned rows are left behind either way.
// Queried directly via $wpdb, not get_posts()/'any', because 'any' silently excludes
// 'auto-draft' and 'trash' posts — which must still be cleaned up here.
global $wpdb;

foreach ( array_keys( wpsh_get_cpts_config() ) as $wpsh_post_type ) {
	$wpsh_post_ids = $wpdb->get_col(
		$wpdb->prepare(
			"SELECT ID FROM {$wpdb->posts} WHERE post_type = %s", // phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared -- $wpdb->posts is a core table name, not user input.
			$wpsh_post_type
		)
	);

	foreach ( $wpsh_post_ids as $wpsh_post_id ) {
		wp_delete_post( (int) $wpsh_post_id, true );
	}
}

foreach ( array_keys( wpsh_get_taxonomies_config() ) as $wpsh_taxonomy ) {
	$wpsh_term_ids = get_terms(
		[
			'taxonomy'   => $wpsh_taxonomy,
			'hide_empty' => false,
			'fields'     => 'ids',
		]
	);

	if ( is_wp_error( $wpsh_term_ids ) ) {
		continue;
	}

	foreach ( $wpsh_term_ids as $wpsh_term_id ) {
		wp_delete_term( $wpsh_term_id, $wpsh_taxonomy );
	}
}

/* ==========================================================
   User meta
   ========================================================== */

// Reset the admin color scheme for any user still assigned to the scheme this plugin
// registered, back to WordPress's own default. The scheme itself stops being registered
// as soon as the plugin's files are gone, so this only cleans up the leftover reference.
$wpsh_custom_scheme_users = get_users(
	[
		'meta_key'   => 'admin_color', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key -- one-time uninstall cleanup, not a runtime query.
		'meta_value' => 'custom-color-scheme', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value -- see above.
		'fields'     => 'ID',
	]
);

foreach ( $wpsh_custom_scheme_users as $wpsh_user_id ) {
	update_user_meta( $wpsh_user_id, 'admin_color', 'fresh' );
}
