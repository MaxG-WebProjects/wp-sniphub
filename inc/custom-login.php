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
// How do I customize the WordPress login page?
// via https://astuceswp.fr/tutos/478/personnalisation-page-login-wordpress
// Here's my custom CSS that removes the back link in a function
function wpsh_login_remove_back_to_link() {
	?>
	<style type="text/css">
		body.login div#login p#backtoblog {
			display: none;
		}
	</style>
	<?php
}
//This loads the function above on the login page
add_action( 'login_enqueue_scripts', 'wpsh_login_remove_back_to_link' );

/* ==========================================================
   Custom login stylesheet
   ========================================================== */
// Replace style-login.css with the name of your custom CSS file
function wpsh_login_enqueue_styles() {
	$css_file = WPSH_CSS_URL . 'custom-login/login-styles.css';
	$css_path = WPSH_PLUGIN_DIR . 'css/custom-login/login-styles.css';

	wp_enqueue_style(
		'wpsh-custom-login',
		esc_url( $css_file ),
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : null // Automatic update of the date of the style.css file > avoids loading the cached one
	);
}
add_action( 'login_enqueue_scripts', 'wpsh_login_enqueue_styles' );

/* ==========================================================
   Login logo URL
   ========================================================== */
// Change logo URL
function wpsh_login_logo_url() {
	return esc_url( home_url( '/' ) );
}
add_filter( 'login_headerurl', 'wpsh_login_logo_url' );

/* ==========================================================
   Login logo title
   ========================================================== */
// Change logo title
function wpsh_login_logo_title() {
	return esc_html__( 'Max Gremez | Responsable de Projets Web & Marketing Digital', 'wp-sniphub' );
}
add_filter( 'login_headertext', 'wpsh_login_logo_title' );

/* ==========================================================
   Custom login error message
   ========================================================== */
// Change default login error message
function wpsh_login_error_message() {
	return esc_html__( 'Ce n’est pas la bonne combinaison', 'wp-sniphub' );
}
add_filter( 'login_errors', 'wpsh_login_error_message' );

/* ==========================================================
   Disable login shake animation
   ========================================================== */

function wpsh_login_disable_shake() {
	remove_action( 'login_head', 'wp_shake_js', 12 );
}
add_action( 'login_head', 'wpsh_login_disable_shake', 50 );