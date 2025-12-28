<?php
/**
 * Personnalisation du login
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Comment personnaliser la page de connexion à WordPress ?
// via https://astuceswp.fr/tutos/478/personnalisation-page-login-wordpress
// Here's my custom CSS that removes the back link in a function
function my_login_page_remove_back_to_link() { ?>
	<style type="text/css">
		body.login div#login p#backtoblog {
		  display: none;
		}
	</style>
<?php }
//This loads the function above on the login page
add_action( 'login_enqueue_scripts', 'my_login_page_remove_back_to_link' );

// Replace style-login.css with the name of your custom CSS file
function my_custom_login_stylesheet() {
	$css_file = WPSH_CSS_URL . 'custom-login/styles.css';
	$css_path = WPSH_PLUGIN_DIR . 'css/custom-login/styles.css';

	wp_enqueue_style(
		'custom-login',
		$css_file,
		[],
		file_exists( $css_path ) ? filemtime( $css_path ) : false // Automatic update of the date of the style.css file > avoids loading the cached one
	);
}
add_action( 'login_enqueue_scripts', 'my_custom_login_stylesheet' );

// Change logo URL
function my_login_logo_url() {
	return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

// Change logo title
function my_login_logo_url_title() {
	return 'Max Gremez | Responsable de Projets Web & Marketing Digital';
}
add_filter( 'login_headertext', 'my_login_logo_url_title' );

// Change default login error message
function login_error_override() {
	return 'Ce n&rsquo;est pas la bonne combinaison';
}
add_filter('login_errors', 'login_error_override');

// Disable shake animation
function my_login_head() {
	remove_action('login_head', 'wp_shake_js', 12);
}
add_action('login_head', 'my_login_head', 50);