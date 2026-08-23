<?php
/**
 * Customizing the login
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Remove "Back to site" link
   ========================================================== */
/*
// via https://astuceswp.fr/tutos/478/personnalisation-page-login-wordpress
*/
/**
 * Outputs CSS that hides the "Back to site" link on the login page.
 *
 * @return void
 */
function wpsh_login_remove_back_to_link() {
	?>
	<style type="text/css">
		body.login div#login p#backtoblog {
			display: none;
		}
	</style>
	<?php
}
add_action( 'login_enqueue_scripts', 'wpsh_login_remove_back_to_link' );

/* ==========================================================
   Custom login stylesheet
   ========================================================== */
/**
 * Enqueues the custom login stylesheet.
 *
 * @return void
 */
function wpsh_login_enqueue_styles() {
	$css_file = WPSH_CSS_URL . 'custom-login/login-styles.css';
	$css_path = WPSH_PLUGIN_DIR . 'css/custom-login/login-styles.css';

	wp_enqueue_style(
		'wpsh-custom-login',
		esc_url( $css_file ),
		[],
		// Cache-bust on file modification time instead of the plugin version.
		file_exists( $css_path ) ? filemtime( $css_path ) : null
	);
}
add_action( 'login_enqueue_scripts', 'wpsh_login_enqueue_styles' );

/* ==========================================================
   Login logo URL
   ========================================================== */
/**
 * Changes the login logo link to point to the site's home URL.
 *
 * @return string
 */
function wpsh_login_logo_url() {
	return esc_url( home_url( '/' ) );
}
add_filter( 'login_headerurl', 'wpsh_login_logo_url' );

/* ==========================================================
   Login logo title
   ========================================================== */
/**
 * Changes the login logo title text.
 *
 * @return string
 */
function wpsh_login_logo_title() {
	return esc_html__( 'Max Gremez | Web & Digital Marketing Project Manager', 'wp-sniphub' );
}
add_filter( 'login_headertext', 'wpsh_login_logo_title' );

/* ==========================================================
   Custom login error message
   ========================================================== */
/**
 * Changes the default login error message.
 *
 * @return string
 */
function wpsh_login_error_message() {
	return esc_html__( 'That\'s not the right combination', 'wp-sniphub' );
}
add_filter( 'login_errors', 'wpsh_login_error_message' );

/* ==========================================================
   Disable login shake animation
   ========================================================== */
/**
 * Disables the shake animation on a failed login attempt.
 *
 * @return void
 */
function wpsh_login_disable_shake() {
	remove_action( 'login_head', 'wp_shake_js', 12 );
}
add_action( 'login_head', 'wpsh_login_disable_shake', 50 );
