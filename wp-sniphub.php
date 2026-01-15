<?php
/**
 * Plugin Name: WPSnipHub
 * Plugin URI: https://github.com/MaxG-WebProjects/wp-sniphub
 * Description: A dev-oriented central and modular hub for code snippets and utility functions of WordPress sites.
 * Version: 1.2.0
 * Stable tag: 1.2.0
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

define( 'WPSH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPSH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'WPSH_INC_DIR', WPSH_PLUGIN_DIR . 'inc/' );
define( 'WPSH_CSS_URL', WPSH_PLUGIN_URL . 'css/' );
define( 'WPSH_IMG_URL', WPSH_PLUGIN_URL . 'img/' );

/* ==========================================================
   Module definitions (SINGLE SOURCE)
   ========================================================== */

$wpsh_modules = [
	'setup.php' => [
		'title' => 'Configuration de base',
		'short_desc' => 'Configuration initiale et dépendances du site.',
		'long_desc' => 'Ce module gère les paramètres de base, les dépendances nécessaires et les configurations globales du site.',
	],
	'scripts.php' => [
		'title' => 'Scripts et styles',
		'short_desc' => 'Gestion des scripts et styles globaux.',
		'long_desc' => 'Permet de charger les fichiers CSS et JS globaux et d\'optimiser leur chargement en fonction de pages spécifiques.',
	],
	'custom-post-types.php' => [
		'title' => 'Types de contenu personnalisés',
		'short_desc' => 'Définition des Custom Post Types (CPT).',
		'long_desc' => 'Ajoute et configure des types de contenu spécifiques (ex : Portfolio, Recettes, etc.).',
	],
	'taxonomies.php' => [
		'title' => 'Définition des taxonomies personnalisées',
		'short_desc' => 'Définition des types de taxonomies personnalisées.',
		'long_desc' => 'Ajoute et configure des types de taxonomies personnalisées aux Custom Post Types : des catégories et/ou des étiquettes.',
	],
	'shortcodes.php' => [
		'title' => 'Ajout de codes courts utiles pour le site',
		'short_desc' => 'Créer des codes courts dont la fonction sera affichée sur le site.',
		'long_desc' => 'Permet de créer des codes courts (ex : Afficher l’année en cours automatiquement dans le footer).',
	],
	'security.php' => [
		'title' => 'Ajout de sécurisations backend / frontend',
		'short_desc' => 'Ajout de sécurisations backend / frontend.',
		'long_desc' => 'Permet d\'ajouter des sécurités à WordPress, non présentes nativement (ex : Bloquer l’édition de fichiers).',
	],
	'image-size.php' => [
		'title' => 'Ajout de tailles d\'images personnalisées',
		'short_desc' => 'Ajouter des tailles d\'images supplémentaires et personnalisées.',
		'long_desc' => 'Permet de créer de tailles d\'images à WordPress, non présentes nativement (ex : Taille Full HD - 1920px x 1080px).',
	],
	'cleanup.php' => [
		'title' => 'Désactivation de certaines fonctions natives',
		'short_desc' => 'Désactiver certaines fonctions de WordPress.',
		'long_desc' => 'Permet de désactiver des fonctions non utiles au site (ex : Désactiver les emojis, désactiver les filtres SVG Duotone).',
	],
	'hooks.php' => [
		'title' => 'Hooks et filtres personnalisés',
		'short_desc' => 'Ajout de hooks et filtres personnalisés.',
		'long_desc' => 'Permet d\'ajouter des hooks et des filtres PHP personnalisés (ex : Notification dans la barre du navigateur).',
	],
	'helpers.php' => [
		'title' => 'Fonctions utilitaires',
		'short_desc' => 'Ajoute des fonctions utilitaires réutilisables.',
		'long_desc' => 'Permet d\'ajouter des fonctions utilitaires réutilisables (ex : Récupérer un extrait de contenu).',
	],
	'woocommerce.php' => [
		'title' => 'Personnalisation de Woocommerce',
		'short_desc' => 'Ajouter des fonctions à Woocommerce.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions à Woocommerce (ex : Redirections, Remplissage automatique).',
	],
	'publications.php' => [
		'title' => 'Ajout de fonctions pour les articles',
		'short_desc' => 'Ajouter des fonctions aux articles.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions aux articles (ex : Copyright, Nombre maximum de mots pour les titres de publications).',
	],
	'custom-login.php' => [
		'title' => 'Personnalisation de la page de connexion',
		'short_desc' => 'Personnaliser l\'apparence de la page de connexion.',
		'long_desc' => 'Permet d\'ajouter/modifier l\'apparence de la page de connexion (ex : Arrière-plan, couleurs, logo, etc.).',
	],
	'custom-admin.php' => [
		'title' => 'Personnalisation de l\'interface du Dashboard',
		'short_desc' => 'Personnaliser l\'apparence du Dashboard.',
		'long_desc' => 'Permet d\'ajouter des modifications au Dashboard (ex : Palette de couleurs personnalisée, changer le Gravatar, texte de pied de page).',
	],
	'media-setup.php' => [
		'title' => 'Ajout de types de médias',
		'short_desc' => 'Ajouter des médias autres que jpeg, png, pdf, etc.',
		'long_desc' => 'Permet d\'ajouter des types de médias non pris en charge nativement par WordPress (ex : SVG, JSON).',
	],
	'gravity-forms.php' => [
		'title' => 'Personnalisation du plugin Gravity Forms',
		'short_desc' => 'Personnaliser le plugin de formulaire de contact Gravity Forms.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions du plugin (ex : Désactiver les CSS natifs, corriger l\'accessibilité).',
	],
	'favicon.php' => [
		'title' => 'Gestion du favicon personnalisé',
		'short_desc' => 'Personnaliser les formats du favicon.',
		'long_desc' => 'Permet d\'ajouter des favicons supplémentaires (ex : ICO, SVG, Darkmode).',
	],
	'performance.php' => [
		'title' => 'Optimisations de performance',
		'short_desc' => 'Ajout d\'optimisations de performance.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions pour augmenter les performances de chargement (ex : Désactiver Speculative Loading, utiliser la pré-loading sur les images affichées au-dessus de la ligne de flottaison pour améliorer LCP).',
	],
	'greenshift.php' => [
		'title' => 'Personnalisation du plugin GreenShift',
		'short_desc' => 'Ajout des fonctions au plugin GreenShift.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions du plugin GreenShift (ex : Points de rupture personnalisés, Darkmode).',
	],
];

/* ==========================================================
   Loading active modules
   ========================================================== */

function wpsh_load_modules() {
	global $wpsh_modules;

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

function wpsh_register_admin_menu() {
	$icon_path = WPSH_PLUGIN_DIR . 'img/admin/icon.svg';
	$icon_svg  = file_exists( $icon_path )
		? 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( $icon_path ) )
		: 'dashicons-admin-generic';

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

function wpsh_admin_page() {
	   global $wpsh_modules;
   
	   if (
		   isset( $_POST['wpsh_save_modules'] ) &&
		   check_admin_referer( 'wpsh_save_modules_nonce' )
	   ) {
		   $enabled = isset( $_POST['modules'] )
			   ? array_map( 'sanitize_text_field', wp_unslash( $_POST['modules'] ) )
			   : [];
   
		   update_option( 'wpsh_enabled_modules', $enabled );
   
		   echo '<div class="notice notice-success is-dismissible"><p>';
		   esc_html_e( 'Modules mis à jour.', 'wp-sniphub' );
		   echo '</p></div>';
	   }
   
	   $enabled_modules = get_option( 'wpsh_enabled_modules', [] );
   
	   echo '<div class="wrap wpsh-wrapper">';
   
	   echo '<h1 class="wpsh-title">';
	   echo '<span class="wpsh-title-text">';
	   esc_html_e( 'WPSnipHub – Gestion des modules', 'wp-sniphub' );
	   echo '</span>';
	   echo '<img src="' . esc_url( WPSH_IMG_URL . '/admin/wp-sniphub-logo.svg' ) . '" alt="' . esc_attr__( 'Logo WPSnipHub', 'wp-sniphub' ) . '" class="wpsh-title-image">';
	   echo '</h1>';
   
	   echo '<form method="post">';
	   wp_nonce_field( 'wpsh_save_modules_nonce' );
   
	   foreach ( $wpsh_modules as $file => $module ) {
		   $id      = 'wpsh-module-' . sanitize_title( $file );
		   $checked = in_array( $file, $enabled_modules, true );
   
		   echo '<section class="wpsh-card">';
		   echo '<header class="wpsh-card-header">';
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
			   ' . checked( $checked, true, false ) . '
		   >';
		   echo '<label for="' . esc_attr( $id ) . '" class="wpsh-toggle-switch"></label>';
		   echo '<span class="wpsh-toggle-text"></span>';

		   echo '</div>';
   
		   echo '<span class="wpsh-save-notice">';
		   echo 'Les modifications seront appliquées après l\'enregistrement.';
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
	   
	   echo '<span class="wpsh-save-notice">';
	   echo 'Les modifications seront appliquées après l\'enregistrement.';
	   echo '</span>';
   }

/* ==========================================================
   Styles admin
   ========================================================== */

function wpsh_enqueue_admin_styles( $hook_suffix ) {
	if ( $hook_suffix !== 'toplevel_page_wpsh-helper' ) {
		return;
	}

	wp_enqueue_style(
		'wpsh-admin-style',
		WPSH_PLUGIN_URL . 'css/admin/wpsh-admin.css',
		[],
		filemtime( WPSH_PLUGIN_DIR . 'css/admin/wpsh-admin.css' )
	);
}
add_action( 'admin_enqueue_scripts', 'wpsh_enqueue_admin_styles' );
