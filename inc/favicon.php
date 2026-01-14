<?php
/**
 * Favicon
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Favicon
   ========================================================== */
/* via https://www.billerickson.net/favicon-dark-mode/
// Hooks – we put them in very early for the front end, the admin panel, and the login page
*/
add_action( 'wp_head',    'wpsh_output_favicons', 1 );
add_action( 'admin_head', 'wpsh_output_favicons', 1 );
add_action( 'login_head', 'wpsh_output_favicons', 1 );

/* ==========================================================
   (Optional) Disable the WordPress Site Icon to avoid conflicts
   ========================================================== */
/**
 * Set this filter to false if you want to keep the Customizer icon.
 */
function wpsh_maybe_disable_wp_site_icon() {
	if ( apply_filters( 'wpsh_disable_wp_site_icon', false ) ) {
		remove_action( 'wp_head',    'wp_site_icon', 99 );
		remove_action( 'admin_head', 'wp_site_icon', 99 );
		remove_action( 'login_head', 'wp_site_icon', 99 );
	}
}
add_action( 'init', 'wpsh_maybe_disable_wp_site_icon' );

/* ==========================================================
   Base URLs & paths depuis ce fichier (inc/favicon.php)
   ========================================================== */
/* via https://www.webtimiser.de/en/wordpress-favicon/#5-add-favicon-to-wordpress-manually
//
*/
function wpsh_favicons_base() {
	// URL to /img/favicons/ from the plugin (regardless of the inc/ subfolder)
	$base_url  = trailingslashit( plugins_url( 'img/favicons', __DIR__ ) );
	// Path to /img/favicons/
	$base_path = plugin_dir_path( __DIR__ ) . 'img/favicons/';
	return [ $base_url, $base_path ];
}

/* ==========================================================
   Versioned URL
   ========================================================== */
/*
 * Constructs a versioned (cache-busting) URL
 */
function wpsh_favicon_url( $filename ) {
	list( $base_url, $base_path ) = wpsh_favicons_base();
	$url  = $base_url . $filename;
	$path = $base_path . $filename;
	if ( file_exists( $path ) ) {
		$url = add_query_arg( 'v', filemtime( $path ), $url );
	}
	return esc_url( $url );
}

/* ==========================================================
   Favicon tags removed
   ========================================================== */
function wpsh_output_favicons() {

	echo "\n<!-- Favicons by WPSnipHub -->\n";

	echo '<link rel="icon" type="image/svg+xml" href="' . esc_url( wpsh_favicon_url( 'favicon.svg' ) ) . '">' . "\n";
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . esc_url( wpsh_favicon_url( 'favicon.ico' ) ) . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( wpsh_favicon_url( 'favicon-32x32.png' ) ) . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( wpsh_favicon_url( 'favicon-16x16.png' ) ) . '">' . "\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( wpsh_favicon_url( 'apple-touch-icon.png' ) ) . '">' . "\n";
	echo '<link rel="manifest" href="' . esc_url( wpsh_favicon_url( 'site.webmanifest' ) ) . '">' . "\n";
	echo '<link rel="mask-icon" href="' . esc_url( wpsh_favicon_url( 'safari-pinned-tab.svg' ) ) . '" color="#fffdfa">' . "\n";

	echo '<meta name="msapplication-TileColor" content="#fffdfa">' . "\n";
	echo '<meta name="theme-color" content="#FFFDFA">' . "\n";
}
