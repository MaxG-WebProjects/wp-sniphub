<?php
/**
 * Plugin Name: WPSnipHub
 * Plugin URI: https://github.com/MaxG-WebProjects/wp-sniphub.git
 * Description: A dev-oriented central and modular hub for code snippets and utility functions of WordPress sites.
 * Version: 1.2.5
 * Stable tag: 1.2.5
 * Author: Max Gremez
 * Author URI: https://maxgremez.com/
 * Requires at least: 6.7
 * Tested up to: 6.9
 * Requires PHP: 8.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.fr.html
 * Text Domain: wp-sniphub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Constants
   ========================================================== */

define( 'WPSH_VERSION', '1.2.5' );

define( 'WPSH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPSH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'WPSH_INC_DIR', WPSH_PLUGIN_DIR . 'inc/' );
define( 'WPSH_CSS_URL', WPSH_PLUGIN_URL . 'css/' );
define( 'WPSH_IMG_URL', WPSH_PLUGIN_URL . 'img/' );

/* ==========================================================
   Module definitions (SINGLE SOURCE)
   ========================================================== */

/**
 * Get the list of available modules.
 *
 * @return array Array of module definitions.
 */
function wpsh_get_modules() {
	return apply_filters( 'wpsh_modules', [
	'setup.php' => [
		'title' => 'Configuration de base',
		'short_desc' => 'Configuration initiale et dépendances du site.',
		'long_desc' => 'Ce module gère les paramètres de base, les dépendances nécessaires et les configurations globales du site.',
		'icon'  => 'dashicons-admin-settings',
	],
	'scripts.php' => [
		'title' => 'Scripts',
		'short_desc' => 'Gestion des scripts.',
		'long_desc' => 'Permet de charger les fichiers JS globaux et d\'optimiser leur chargement en fonction de pages spécifiques.',
		'icon'  => 'dashicons-media-code',
	],
	'styles.php' => [
		'title' => 'Styles',
		'short_desc' => 'Gestion des styles.',
		'long_desc' => 'Permet de charger les fichiers CSS et d\'optimiser leur chargement en fonction de pages spécifiques.',
		'icon'  => 'dashicons-art',
	],
	'custom-post-types.php' => [
		'title' => 'Types de contenu personnalisés',
		'short_desc' => 'Définition des Custom Post Types (CPT).',
		'long_desc' => 'Ajoute et configure des types de contenu spécifiques (ex : Portfolio, Recettes, etc.).',
		'icon'  => 'dashicons-admin-post',
	],
	'taxonomies.php' => [
		'title' => 'Définition des taxonomies personnalisées',
		'short_desc' => 'Définition des types de taxonomies personnalisées.',
		'long_desc' => 'Ajoute et configure des types de taxonomies personnalisées aux Custom Post Types : des catégories et/ou des étiquettes.',
		'icon'  => 'dashicons-tag',
	],
	'shortcodes.php' => [
		'title' => 'Ajout de codes courts utiles pour le site',
		'short_desc' => 'Créer des codes courts dont la fonction sera affichée sur le site.',
		'long_desc' => 'Permet de créer des codes courts (ex : Afficher l’année en cours automatiquement dans le footer).',
		'icon'  => 'dashicons-shortcode',
	],
	'security.php' => [
		'title' => 'Ajout de sécurisations backend / frontend',
		'short_desc' => 'Ajout de sécurisations backend / frontend.',
		'long_desc' => 'Permet d\'ajouter des sécurités à WordPress, non présentes nativement (ex : Bloquer l’édition de fichiers.',
		'icon'  => 'dashicons-shield',
	],
	'image-size.php' => [
		'title' => 'Ajout de tailles d\'images personnalisées',
		'short_desc' => 'Ajouter des tailles d\'images supplémentaires et personnalisées.',
		'long_desc' => 'Permet de créer de tailles d\'images à WordPress, non présentes nativement (ex : Taille Full HD - 1920px x 1080px).',
		'icon'  => 'dashicons-format-image',
	],
	'cleanup.php' => [
		'title' => 'Désactivation de certaines fonctions natives',
		'short_desc' => 'Désactiver certaines fonctions de WordPress.',
		'long_desc' => 'Permet de désactiver des fonctions non utiles au site (ex : Désactiver les emojis, désactiver les filtres SVG Duotone).',
		'icon'  => 'dashicons-dismiss',
	],
	'hooks.php' => [
		'title' => 'Hooks et filtres personnalisés',
		'short_desc' => 'Ajout de hooks et filtres personnalisés.',
		'long_desc' => 'Permet d\'ajouter des hooks et des filtres PHP personnalisés (ex : Notification dans la barre du navigateur).',
		'icon'  => 'dashicons-admin-links',
	],
	'helpers.php' => [
		'title' => 'Fonctions utilitaires',
		'short_desc' => 'Ajoute des fonctions utilitaires réutilisables.',
		'long_desc' => 'Permet d\'ajouter des fonctions utilitaires réutilisables (ex : Récupérer un extrait de contenu).',
		'icon'  => 'dashicons-admin-tools',
	],
	'woocommerce.php' => [
		'title' => 'Personnalisation de Woocommerce',
		'short_desc' => 'Ajouter des fonctions à Woocommerce.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions à Woocommerce (ex : Redirections, Remplissage automatique).',
		'icon'  => 'dashicons-cart',
	],
	'publications.php' => [
		'title' => 'Ajout de fonctions pour les articles',
		'short_desc' => 'Ajouter des fonctions aux articles.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions aux articles (ex : Copyright, Nombre maximum de mots pour les titres de publications).',
		'icon'  => 'dashicons-edit',
	],
	'custom-login.php' => [
		'title' => 'Personnalisation de la page de connexion',
		'short_desc' => 'Personnaliser l\'apparence de la page de connexion.',
		'long_desc' => 'Permet d\'ajouter/modifier l\'apparence de la page de connexion (ex : Arrière-plan, couleurs, logo, etc.).',
		'icon'  => 'dashicons-lock',
	],
	'custom-admin.php' => [
		'title' => 'Personnalisation de l\'interface du Dashboard',
		'short_desc' => 'Personnaliser l\'apparence du Dashboard.',
		'long_desc' => 'Permet d\'ajouter des modifications au Dashboard (ex : Palette de couleurs personnalisée, changer le Gravatar, texte de pied de page).',
		'icon'  => 'dashicons-admin-appearance',
	],
	'media-setup.php' => [
		'title' => 'Ajout de types de médias',
		'short_desc' => 'Ajouter des médias autres que jpeg, png, pdf, etc.',
		'long_desc' => 'Permet d\'ajouter des types de médias non pris en charge nativement par WordPress (ex : SVG, JSON).',
		'icon'  => 'dashicons-admin-media',
	],
	'gravity-forms.php' => [
		'title' => 'Personnalisation du plugin Gravity Forms',
		'short_desc' => 'Personnaliser le plugin de formulaire de contact Gravity Forms.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions du plugin (ex : Désactiver les CSS natifs, corriger l\'accessibilité).',
		'icon'  => 'dashicons-email-alt',
	],
	'favicon.php' => [
		'title' => 'Gestion du favicon personnalisé',
		'short_desc' => 'Personnaliser les formats du favicon.',
		'long_desc' => 'Permet d\'ajouter des favicons supplémentaires (ex : ICO, SVG, Darkmode).',
		'icon'  => 'dashicons-star-filled',
	],
	'performance.php' => [
		'title' => 'Optimisations de performance',
		'short_desc' => 'Ajout d\'optimisations de performance.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions pour augmenter les performances de chargement (ex : Désactiver Speculative Loading, utiliser la pré-loading sur les images affichées au-dessus de la ligne de flottaison pour améliorer LCP).',
		'icon'  => 'dashicons-performance',
	],
	'greenshift.php' => [
		'title' => 'Personnalisation du plugin GreenShift',
		'short_desc' => 'Ajout des fonctions au plugin GreenShift.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions du plugin GreenShift (ex : Points de rupture personnalisés, Darkmode).',
		'icon'  => 'dashicons-layout',
	],
	] );
}

/* ==========================================================
   Loading active modules
   ========================================================== */

/**
 * Load active modules.
 *
 * @return void
 */
function wpsh_load_modules() {
	$wpsh_modules = wpsh_get_modules();

	$enabled_modules = get_option(
		'wpsh_enabled_modules',
		array_keys( $wpsh_modules )
	);

	foreach ( $wpsh_modules as $module_file => $module_info ) {
		if ( in_array( $module_file, $enabled_modules, true ) ) {
			$path = WPSH_INC_DIR . $module_file;
			if ( file_exists( $path ) ) {
				require_once $path;
			}
		}
	}
}
add_action( 'plugins_loaded', 'wpsh_load_modules' );

/* ==========================================================
   Menu admin
   ========================================================== */

/**
 * Register admin menu.
 *
 * @return void
 */
function wpsh_register_admin_menu() {
	$icon_path = WPSH_PLUGIN_DIR . 'img/admin/icon.svg';
	$icon_svg  = 'dashicons-admin-generic';

	if ( file_exists( $icon_path ) ) {
		$icon_content = file_get_contents( $icon_path );
		if ( false !== $icon_content ) {
			$icon_svg = 'data:image/svg+xml;base64,' . base64_encode( $icon_content );
		}
	}

	add_menu_page(
		'WPSnipHub',
		'WPSnipHub',
		'manage_options',
		'wpsh-helper',
		'wpsh_admin_page',
		$icon_svg,
		60
	);
}
add_action( 'admin_menu', 'wpsh_register_admin_menu' );

/* ==========================================================
   Page admin
   ========================================================== */

/**
 * Admin page callback.
 *
 * @return void
 */
function wpsh_admin_page() {
	// Verify permissions
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Vous n\'avez pas les permissions nécessaires pour accéder à cette page.', 'wp-sniphub' ) );
	}

	$wpsh_modules = wpsh_get_modules();

	if (
		isset( $_POST['wpsh_save_modules'] ) &&
		check_admin_referer( 'wpsh_save_modules_nonce' )
	) {
		$submitted_modules = isset( $_POST['modules'] )
			? array_map( 'sanitize_text_field', wp_unslash( $_POST['modules'] ) )
			: [];

		// Verify that all submitted modules exist in $wpsh_modules
		$enabled = array_intersect( $submitted_modules, array_keys( $wpsh_modules ) );

		update_option( 'wpsh_enabled_modules', $enabled );

		echo '<div class="notice notice-success is-dismissible wpsh-notice-fit"><p>';
		esc_html_e( 'Modules mis à jour.', 'wp-sniphub' );
		echo '</p></div>';
	}

	$enabled_modules = get_option(
		'wpsh_enabled_modules',
		array_keys( $wpsh_modules )
	);
   
	echo '<div class="wrap wpsh-wrapper">';

	echo '<div class="wpsh-header-banner">';
	echo '<div class="wpsh-header-banner-left">';
	echo '<h1 class="wpsh-title">';
	echo '<span class="wpsh-title-text">';
	esc_html_e( 'WPSnipHub – Gestion des modules', 'wp-sniphub' );
	echo '</span>';
	echo '<img src="' . esc_url( WPSH_IMG_URL . '/admin/wp-sniphub-logo.svg' ) . '" alt="' . esc_attr__( 'Logo WPSnipHub', 'wp-sniphub' ) . '" class="wpsh-title-image">';
	echo '</h1>';
	echo '<p class="wpsh-header-banner-description">';
	esc_html_e( 'Un hub central et modulaire orienté développement pour les extraits de code et les fonctions utilitaires des sites WordPress.', 'wp-sniphub' );
	echo '</p>';
	echo '</div>';

	echo '<div class="wpsh-header-banner-actions">';
	echo '<button type="submit" form="wpsh-modules-form" class="button button-primary" name="wpsh_save_modules" value="1">';
	esc_html_e( 'Enregistrer', 'wp-sniphub' );
	echo '</button>';
	echo '</div>';
	echo '</div>';

	echo '<form method="post" id="wpsh-modules-form">';
	wp_nonce_field( 'wpsh_save_modules_nonce' );

	foreach ( $wpsh_modules as $file => $module ) {
		$id      = 'wpsh-module-' . sanitize_title( $file );
		$checked = in_array( $file, $enabled_modules, true );

		$module_icon = isset( $module['icon'] ) ? $module['icon'] : 'dashicons-admin-generic';

		echo '<section class="wpsh-card">';
		echo '<header class="wpsh-card-header">';
		if ( $module_icon ) {
			echo '<span class="wpsh-module-icon dashicons ' . esc_attr( $module_icon ) . '"></span>';
		}
		echo '<h2 class="wpsh-card-title">' . esc_html( $module['title'] ) . '</h2>';
		echo '<span class="wpsh-status-badge"></span>';
		echo '</header>';

		echo '<div class="wpsh-card-body">';
		echo '<p class="wpsh-card-short">' . esc_html( $module['short_desc'] ) . '</p>';
		echo '<p class="wpsh-card-long">' . esc_html( $module['long_desc'] ) . '</p>';
		echo '</div>';

		echo '<footer class="wpsh-card-footer">';

		echo '<div class="wpsh-toggle-container">';
		echo '<div class="wpsh-toggle-wrapper">';
		echo '<input
			type="checkbox"
			id="' . esc_attr( $id ) . '"
			name="modules[]"
			value="' . esc_attr( $file ) . '"
			class="wpsh-toggle-input"
			aria-label="' . esc_attr(
				sprintf(
					/* translators: %s: module title */
					__( 'Enable or disable the %s module', 'wp-sniphub' ),
					$module['title']
				)
			) . '"
			' . checked( $checked, true, false ) . '
		>';
		echo '<label for="' . esc_attr( $id ) . '" class="wpsh-toggle-switch" aria-hidden="true"></label>';
		echo '<span class="wpsh-toggle-text"></span>';

		echo '</div>';

		echo '<span class="wpsh-save-notice">';
		esc_html_e( 'Les modifications seront appliquées après l\'enregistrement.', 'wp-sniphub' );
		echo '</span>';

		echo '<span class="wpsh-filename">' . esc_html( $file ) . '</span>';
		echo '</div>';

		echo '</footer>';
		echo '</section>';
	}

	echo '<p class="wpsh-submit">';
	submit_button( __( 'Enregistrer', 'wp-sniphub' ), 'primary', 'wpsh_save_modules', false );
	echo '</p>';

	echo '</form>';
	echo '</div>';
   }

/* ==========================================================
   Styles admin
   ========================================================== */

/**
 * Enqueue admin styles.
 *
 * @param string $hook_suffix Current admin page hook suffix.
 * @return void
 */
function wpsh_enqueue_admin_styles( $hook_suffix ) {
	if ( $hook_suffix !== 'toplevel_page_wpsh-helper' ) {
		return;
	}

	// Ensure dashicons are loaded for module icons
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style(
		'wpsh-admin-style',
		WPSH_PLUGIN_URL . 'css/admin/wpsh-admin.css',
		[],
		apply_filters( 'wpsh_admin_css_version', WPSH_VERSION )
	);
}
add_action( 'admin_enqueue_scripts', 'wpsh_enqueue_admin_styles' );

