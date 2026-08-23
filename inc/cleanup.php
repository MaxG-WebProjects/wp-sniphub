<?php
/**
 * Theme cleanup
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Disabling WordPress emojis
   ========================================================== */
/*
// via https://www.keycdn.com/blog/speed-up-wordpress
// via https://www.denisbouquet.com/remove-wordpress-emoji-code/
*/
/**
 * Removes all emoji-related hooks (detection script, styles, TinyMCE plugin).
 *
 * @return void
 */
function wpsh_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'wpsh_disable_emojis_tinymce' );
}
add_action( 'init', 'wpsh_disable_emojis' );

/* ==========================================================
   Remove the TinyMCE emoji plugin
   ========================================================== */
/**
 * Remove the TinyMCE emoji plugin.
 *
 * @param array $plugins TinyMCE plugins.
 * @return array
 */
function wpsh_disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, [ 'wpemoji' ] );
	}

	return [];
}

/* ==========================================================
   Disabling the RSD link, Windows Live Writer, and shortlink
   ========================================================== */
remove_action( 'wp_head', 'rsd_link', 50 );
remove_action( 'wp_head', 'wlwmanifest_link', 50 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 50 );

/* ==========================================================
   Remove WordPress header "junk" (RSS feed links)
   ========================================================== */
/*
// via https://www.wpexplorer.com/clean-wordpress-head/
*/
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

/* ==========================================================
   Disable RSS feeds
   ========================================================== */
/**
 * Kills a disabled RSS feed request with a translated message.
 *
 * @return void
 */
function wpsh_disable_feed() {
	wp_die( esc_html__( 'RSS disabled', 'wp-sniphub' ) );
}
add_action( 'do_feed', 'wpsh_disable_feed', 1 );
add_action( 'do_feed_rdf', 'wpsh_disable_feed', 1 );
add_action( 'do_feed_rss', 'wpsh_disable_feed', 1 );
add_action( 'do_feed_rss2', 'wpsh_disable_feed', 1 );
add_action( 'do_feed_atom', 'wpsh_disable_feed', 1 );

/* ==========================================================
   Disabling Duotone SVG filters in WordPress
   ========================================================== */
/*
// via https://codecolibri.fr/supprimer-filtres-svg-duotone-wordpress/
// via https://www.rankya.com/wordpress/how-to-disable-gutenberg-duotone-filter/
// via https://www.deefuse.fr/journal-developpement-full-stack-php-laravel-codeigniter/desactiver-completement-les-filtres-duotone-sur-wordpress/
// Alternative: theme.json > "customDuotone": false, "defaultDuotone": false, "duotone": [].
*/
if ( has_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' ) ) {
	remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
}

/* Removing duotone SVGs from the Gutenberg plugin. */
if ( has_action( 'wp_body_open', 'gutenberg_global_styles_render_svg_filters' ) ) {
	remove_action( 'wp_body_open', 'gutenberg_global_styles_render_svg_filters' );
}

/* ==========================================================
   Remove Gutenberg library CSS and global inline styles
   ========================================================== */
/*
// via https://foolhat.party/blog/remove-gutenberg-css/
// via https://smartwp.com/remove-gutenberg-css/
*/
/**
 * Dequeues the WooCommerce/Storefront block styles that conflict with GreenShift.
 *
 * Alternative: fully disable the block editor with
 * add_filter( 'use_block_editor_for_post_type', '__return_false', 10 ) and stop
 * loading Gutenberg stylesheets entirely — not done here, since dequeuing
 * `wp-block-library`/`wp-block-library-theme` breaks the header display in
 * GreenShift and on the frontend.
 *
 * @return void
 */
function wpsh_remove_block_css() {
	wp_dequeue_style( 'wc-block-style' );
	wp_dequeue_style( 'storefront-gutenberg-blocks' );
}
add_action( 'wp_enqueue_scripts', 'wpsh_remove_block_css', 100 );
