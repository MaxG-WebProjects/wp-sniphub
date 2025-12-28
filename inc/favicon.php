<?php
/**
 * Favicon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Favicon
// via https://www.billerickson.net/favicon-dark-mode/

function max_favicon() {
	echo '<link rel="icon" href="' . esc_url( get_stylesheet_directory_uri() . '/img/favicon.ico' ) . '"type="image/x-icon" sizes="48x48">'; /* media="(prefers-color-scheme: dark)" */
	/* echo '<link rel="icon" href="' . esc_url( get_stylesheet_directory_uri() . '/assets/favicons/apple-touch-icon-60x60-precomposed.png' ) . '" type="image/png" sizes="48x48">'; /* media="(prefers-color-scheme: nightmode)" 
}
add_action( 'wp_head', 'max_favicon', 10 ); */

// via https://www.webtimiser.de/en/wordpress-favicon/#5-add-favicon-to-wordpress-manually
/*function favicon() { 
echo '<link rel="icon" type="image/svg+xml" href="/wp-content/plugins/wp-sniphub/img/favicons/favicon.svg">
	<link rel="apple-touch-icon" sizes="180x180" href="/wp-content/plugins/wp-sniphub/img/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/wp-content/plugins/wp-sniphub/img/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/wp-content/plugins/wp-sniphub/img/favicons/favicon-16x16.png">
	<link rel="manifest" href="/wp-content/plugins/wp-sniphub/img/favicons/site.webmanifest">
	<link rel="mask-icon" href="/wp-content/plugins/wp-sniphub/img/favicons/safari-pinned-tab.svg" color="#fffdfa">
	<meta name="msapplication-TileColor" content="#fffdfa">
	<meta name="theme-color" content="#FFFDFA">'; 
 }
add_action('wp_head', 'favicon');
*/
/*
function sniphub_favicon() {
	$plugin_url = plugin_dir_url(__FILE__) . '../img/favicons/';
	echo '
	<link rel="icon" type="image/svg+xml" href="' . $plugin_url . 'favicon.svg">
	<link rel="shortcut icon" href="' . $plugin_url . 'favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon" sizes="180x180" href="' . $plugin_url . 'apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="' . $plugin_url . 'favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="' . $plugin_url . 'favicon-16x16.png">
	<link rel="manifest" href="' . $plugin_url . 'site.webmanifest">
	<link rel="mask-icon" href="' . $plugin_url . 'safari-pinned-tab.svg" color="#fffdfa">
	<meta name="msapplication-TileColor" content="#fffdfa">
	<meta name="theme-color" content="#FFFDFA">
	';
}
add_action('wp_head', 'favicon');
*/
////////////////////////////////////////////////////

/**
 * Favicon – injection fiable
 */
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Base URLs & paths depuis ce fichier (inc/favicon.php)
 */
function wpsh_favicons_base() {
	// URL vers /img/favicons/ à partir du plugin (peu importe le sous-dossier inc/)
	$base_url  = trailingslashit( plugins_url( 'img/favicons', __DIR__ ) );
	// Chemin disque vers /img/favicons/
	$base_path = plugin_dir_path( __DIR__ ) . 'img/favicons/';
	return [ $base_url, $base_path ];
}

/**
 * Construit une URL versionnée (cache-busting)
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

/**
 * Sortie des balises favicon
 */
function wpsh_output_favicons() {
	echo "\n" . '<!-- Favicons by WP SnipHub -->' . "\n";
	echo '<link rel="icon" type="image/svg+xml" href="' . wpsh_favicon_url('favicon.svg') . '">' . "\n";
	echo '<link rel="shortcut icon" type="image/x-icon" href="' . wpsh_favicon_url('favicon.ico') . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . wpsh_favicon_url('favicon-32x32.png') . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . wpsh_favicon_url('favicon-16x16.png') . '">' . "\n";
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . wpsh_favicon_url('apple-touch-icon.png') . '">' . "\n";
	echo '<link rel="manifest" href="' . wpsh_favicon_url('site.webmanifest') . '">' . "\n";
	echo '<link rel="mask-icon" href="' . wpsh_favicon_url('safari-pinned-tab.svg') . '" color="#fffdfa">' . "\n";
	echo '<meta name="msapplication-TileColor" content="#fffdfa">' . "\n";
	echo '<meta name="theme-color" content="#FFFDFA">' . "\n";
}

/**
 * Hooks – on met très tôt pour le front, l’admin et la page de login
 */
add_action( 'wp_head',    'wpsh_output_favicons', 1 );
add_action( 'admin_head', 'wpsh_output_favicons', 1 );
add_action( 'login_head', 'wpsh_output_favicons', 1 );

/**
 * (Optionnel) Désactiver le Site Icon WordPress pour éviter les conflits
 * Passez ce filtre à false si vous voulez laisser l’icône du Customizer.
 */
function wpsh_maybe_disable_wp_site_icon() {
	if ( apply_filters( 'wpsh_disable_wp_site_icon', false ) ) {
		remove_action( 'wp_head',    'wp_site_icon', 99 );
		remove_action( 'admin_head', 'wp_site_icon', 99 );
		remove_action( 'login_head', 'wp_site_icon', 99 );
	}
}
add_action( 'init', 'wpsh_maybe_disable_wp_site_icon' );
