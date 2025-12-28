<?php
/**
 * Personnalisation du dashboard (couleurs admin)
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

////////////////////////////////////////////////////

/* Add custom color scheme in back-office > Users > Profil
// via https://wpadmincolors.com/export/maxcustomcolorscheme2023
// via https://firstsiteguide.com/wordpress-admin-menu/
// motif géométrique : voir fichier CSS
*/

/**
 * Ajoute une palette de couleurs personnalisée pour l'admin
 */
function additional_admin_color_schemes() {
	 wp_admin_css_color(
		 'custom-color-scheme',
		 __( 'Color Scheme' ),
		 WPSH_CSS_URL . 'custom-admin-colors/color-scheme.css',
		 array( '#00106d', '#033fff', '#00bdff', '#EAAA00', '#ececec', '#fff' )
	 );
 }
 add_action( 'admin_init', 'additional_admin_color_schemes', 90 );

/**
 * Définir la palette par défaut pour les nouveaux utilisateurs
 */
function set_default_admin_color( $user_id ) {
	wp_update_user( array(
		'ID'          => $user_id,
		'admin_color' => 'custom-color-scheme'
	));
}
add_action( 'user_register', 'set_default_admin_color', 90 );

/**
 * Renommer la palette "Default" en "Fresh"
 */
function rename_fresh_color_scheme() {
	global $_wp_admin_css_colors;

	if ( isset( $_wp_admin_css_colors['fresh'] ) ) {
		if ( $_wp_admin_css_colors['fresh']->name === 'Default' ) {
			$_wp_admin_css_colors['fresh']->name = 'Fresh';
		}
	}

	return $_wp_admin_css_colors;
}
add_filter( 'admin_init', 'rename_fresh_color_scheme', 90 );

////////////////////////////////////////////////////

/* Ajouter un logo de tableau de bord personnalisé
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#customlogo
// + via https://www.wpbeginner.com/wp-themes/adding-a-custom-dashboard-logo-in-wordpress-for-branding/
*/
function wpb_custom_logo() {
	echo '
	<style type="text/css">
		#wpadminbar #wp-admin-bar-wp-logo > .ab-item .ab-icon:before {
			background-image: url(' . esc_url( WPSH_IMG_URL . 'dashboard-logo.svg' ) . ') !important;
			background-position: 0 0;
			color: rgba(0, 0, 0, 0);
			background-repeat: no-repeat;
		}
		#wpadminbar #wp-admin-bar-wp-logo.hover > .ab-item .ab-icon {
			background-position: 0 0;
		}
	</style>';
}
add_action( 'admin_head', 'wpb_custom_logo' );

////////////////////////////////////////////////////

/* Changer le Gravatar par défaut dans WordPress
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#defaultgravatar
// Changer le nom du fichier + Activer le Gravatar dans Réglages > Commentaires > Avatar par défaut et sélectionner votre visuel d'avatar.
*/

// Ajouter ton avatar dans la liste des choix de WordPress
function wpb_force_custom_gravatar( $url, $id_or_email, $args ) {
	// URL de ton image
	$myavatar = WPSH_IMG_URL . 'gravatar-icon-290x290px.png';

	// Vérifie si WordPress retourne l'avatar mystère ou vide → on remplace par le tien
	if ( strpos( $url, 'gravatar.com/avatar' ) !== false && strpos( $url, 'd=mm' ) !== false ) {
		return $myavatar;
	}

	return $url;
}
add_filter( 'get_avatar_url', 'wpb_force_custom_gravatar', 10, 3 );

////////////////////////////////////////////////////

/* Changer le pied de page dans le panneau d'administration WordPress
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#adminfooter
*/
function remove_footer_admin () { 
echo 'Propulsé par <a href="http://www.wordpress.org" target="_blank">WordPress</a> | Pens&eacute;, cr&eacute;&eacute; et con&ccedil;u par Max Gremez | Site web : <a href="https://maxgremez.com/" title="Site de Max Gremez - maxgremez.com" target="_blank">maxgremez.com</a></p>';
}
add_filter('admin_footer_text', 'remove_footer_admin', 80);

////////////////////////////////////////////////////

/** Afficher un message de bienvenue dans le tableau de bord
 * via https://blog.o2switch.fr/mu-plugins-wordpress/
 * Affiche un message uniquement sur le Tableau de bord (accueil de l'admin).
 * - Hook : admin_notices (déclenché sur la plupart des écrans d'administration)
 * - Filtrage : via get_current_screen() pour ne viser que le dashboard
 */
add_action('admin_notices', function () {
	// Sécurité : on ne fait rien si l'utilisateur n'est pas connecté
	if ( ! is_user_logged_in() ) {
		return;
	}

	// Récupère l'écran courant (exemples : 'dashboard', 'edit-post', etc.)
	if ( ! function_exists('get_current_screen') ) {
		return;
	}
	$screen = get_current_screen();

	// Ne rien afficher si on n'est pas sur la page d'accueil de l'admin
	// - 'dashboard'          = Tableau de bord du site
	// - 'dashboard-network'  = Tableau de bord réseau (multisite)
	if ( ! $screen || ( $screen->id !== 'dashboard' && $screen->id !== 'dashboard-network' ) ) {
		return;
	}

	// Construit un nom convivial : Prénom Nom > Nom d'affichage > Identifiant
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

	// Astuce : personnalisez le message ci-dessous selon votre projet
	$message = sprintf('👋 Bonjour %s, votre MU-plugin est bien actif.', $name);

	// Affiche un bandeau < succès > WordPress, repliable
	printf(
		'<div class="notice notice-success is-dismissible"><p>%s</p></div>',
		esc_html( $message )
	);
});
