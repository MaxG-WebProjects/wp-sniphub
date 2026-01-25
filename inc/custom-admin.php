<?php
/**
 * Dashboard customization
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Add custom color scheme in back-office > Users > Profil
   ========================================================== */
/* 
// via https://wpadmincolors.com/export/maxcustomcolorscheme2023
// via https://firstsiteguide.com/wordpress-admin-menu/
// motif géométrique : voir fichier CSS
*/

/**
 * Custom color palette for the admin
*/
function wpsh_register_admin_color_schemes() {
	wp_admin_css_color(
		'custom-color-scheme',
		__( 'Color Scheme', 'wp-sniphub' ),
		WPSH_CSS_URL . 'custom-admin-colors/color-scheme.css',
		array( '#00106d', '#033fff', '#00bdff', '#EAAA00', '#ececec', '#fff' )
	);
}
add_action( 'admin_init', 'wpsh_register_admin_color_schemes', 90 );

/**
 * Set the default palette for new users
*/
function wpsh_set_default_admin_color( $user_id ) {
	wp_update_user(
		array(
			'ID'          => $user_id,
			'admin_color' => 'custom-color-scheme',
		)
	);
}
add_action( 'user_register', 'wpsh_set_default_admin_color', 90 );

/**
 * Rename the "Default" palette to "Fresh"
*/
function wpsh_rename_fresh_color_scheme() {
	global $_wp_admin_css_colors;

	if ( isset( $_wp_admin_css_colors['fresh'] ) && 'Default' === $_wp_admin_css_colors['fresh']->name ) {
		$_wp_admin_css_colors['fresh']->name = 'Fresh';
	}

	return $_wp_admin_css_colors;
}
add_filter( 'admin_init', 'wpsh_rename_fresh_color_scheme', 90 );

/* ==========================================================
   Add a custom dashboard logo
   ========================================================== */
/* 
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#customlogo
// + via https://www.wpbeginner.com/wp-themes/adding-a-custom-dashboard-logo-in-wordpress-for-branding/
*/
function wpsh_adminbar_custom_logo() {
	?>
	<style>
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			background-image: url('<?php echo esc_url( WPSH_IMG_URL . 'dashboard-logo.svg' ); ?>') !important;
			background-repeat: no-repeat;
			background-position: center;
			color: transparent;
		}
	</style>
	<?php
}
add_action( 'admin_head', 'wpsh_adminbar_custom_logo' );

/* ==========================================================
   Change the default Gravatar in WordPress
   ========================================================== */
/* 
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#defaultgravatar
// Change the file name + Enable Gravatar in Settings > Comments > Default Avatar and select your avatar image.
*/

// Add your avatar to the WordPress choice list
function wpsh_force_custom_gravatar( $url, $id_or_email, $args ) {
	$custom_avatar = WPSH_IMG_URL . 'gravatar-icon-290x290px.png';

	if (
		strpos( $url, 'gravatar.com/avatar' ) !== false &&
		strpos( $url, 'd=mm' ) !== false
	) {
		return esc_url( $custom_avatar );
	}

	return $url;
}
add_filter( 'get_avatar_url', 'wpsh_force_custom_gravatar', 10, 3 );

/* ==========================================================
   Change the default Gravatar in WordPress
   ========================================================== */
/* Change the footer in the WordPress admin panel
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#adminfooter
*/
function wpsh_admin_footer_text() {
	echo wp_kses_post(
		'Propulsé par <a href="https://wordpress.org" target="_blank" rel="noopener">WordPress</a> |
		Pensé, créé et conçu par Max Gremez |
		<a href="https://maxgremez.com/" target="_blank" rel="noopener">maxgremez.com</a>'
	);
}
add_filter( 'admin_footer_text', 'wpsh_admin_footer_text', 80 );

/* ==========================================================
   Display a welcome message in the dashboard
   ========================================================== */
/*
 * via https://blog.o2switch.fr/mu-plugins-wordpress/
 * - Hook : admin_notices (triggered on most administration screens)
 * - Filtrage : via get_current_screen() to focus solely on the dashboard
 */
add_action('admin_notices', function () {
	// Security: nothing is done if the user is not logged in
	if ( ! is_user_logged_in() ) {
		return;
	}

	// Retrieves the current screen (examples: 'dashboard', 'edit-post', etc.)
	if ( ! function_exists('get_current_screen') ) {
		return;
	}
	$screen = get_current_screen();

	// Display nothing if you are not on the admin homepage
	// - 'dashboard'          = Site dashboard
	// - 'dashboard-network'  = Network dashboard (multisite)
	if ( ! $screen || ( $screen->id !== 'dashboard' && $screen->id !== 'dashboard-network' ) ) {
		return;
	}

	// Create a friendly name: First Name Last Name > Display Name > Username
	$user  = wp_get_current_user();
	$first = trim( get_user_meta( $user->ID, 'first_name', true ) );
	$last  = trim( get_user_meta( $user->ID, 'last_name',  true ) );

	if ( $first || $last ) {
		$name = trim("$first $last");
	} elseif ( ! empty( $user->display_name ) ) {
		$name = $user->display_name;
	} else {
		$name = $user->user_login;
	}

	// Tip: Customize the message below to suit your project
	/* translators: %s: User name */
	$message = sprintf( __( 'Bonjour %s, WPSnipHub est bien actif.', 'wp-sniphub' ), $name );

	// Displays a collapsible WordPress <success> banner
	printf(
		'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
		esc_html( $message )
	);
});
