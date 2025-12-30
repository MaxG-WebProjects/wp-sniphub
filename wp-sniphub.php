<?php
/**
 * Plugin Name: WPSnipHub
 * Plugin URI: https://github.com/MaxG-WebProjects/wp-sniphub.git
 * Description: Hub de centralisation de snippets et de fonctions utilitaires.
 * Version: 1.0
 * Author: Max Gremez
 * Requires at least: 6.3
 * Requires PHP: 7.4
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.fr.html
 * Text Domain: wp-sniphub
 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Constantes utiles
define( 'WPSH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPSH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Sous-dossiers
define( 'WPSH_INC_DIR', WPSH_PLUGIN_DIR . 'inc/' );
define( 'WPSH_CSS_URL', WPSH_PLUGIN_URL . 'css/' );
define( 'WPSH_IMG_URL', WPSH_PLUGIN_URL . 'img/' );

// Modules disponibles
$modules = [
	'setup.php' => [
		'title' => 'Configuration de base',
		'short_desc' => 'Configuration initiale et dépendances du site.',
		'long_desc' => 'Ce module gère les paramètres de base du site, les dépendances nécessaires et les configurations globales pour assurer le bon fonctionnement des autres modules.',
	],
	'scripts.php' => [
		'title' => 'Scripts et styles',
		'short_desc' => 'Gestion des scripts et styles globaux.',
		'long_desc' => 'Permet de charger les fichiers CSS et JS globaux, d\'optimiser leur chargement et de gérer les dépendances entre eux.',
	],
	'custom-post-types.php' => [
		'title' => 'Types de contenu personnalisés',
		'short_desc' => 'Définition des types de contenu personnalisés.',
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
		'long_desc' => 'Permet de créer des sécurités non implantées nativement dans WordPress (ex : Bloquer l’édition de fichiers via l’admin).',
	],
	'image-size.php' => [
		'title' => 'Ajout de tailles d\'images personnalisées',
		'short_desc' => 'Ajouter des tailles d\'images supplémentaires et personnalisées.',
		'long_desc' => 'Permet de créer de tailles d\'images non implantées nativement dans WordPress (ex : Taille Full HD - 1920px x 1080px).',
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
		'long_desc' => 'Permet d\'ajouter/modifier l\'apparence de la page de connexion (ex : Arrière-plan, remplacement du logo WordPress).',
	],
	'custom-admin.php' => [
		'title' => 'Personnalisation de l\'interface admin',
		'short_desc' => 'Personnaliser l\'apparence du Dashboard.',
		'long_desc' => 'Permet d\'ajouter des modifications au Dashboard (ex : Palette de couleurs personnalisée, Changer le Gravatar, le pied de page).',
	],
	'media-setup.php' => [
		'title' => 'Ajout de types de médias',
		'short_desc' => 'Ajouter des médias autres que jpeg, png, pdf, mp3, etc.',
		'long_desc' => 'Permet d\'ajouter des types de médias non pris en charge nativement par WordPress (ex : SVG, JSON).',
	],
	'gravity-forms.php' => [
		'title' => 'Personnalisation du plugin Gravity Forms',
		'short_desc' => 'Personnaliser le plugin de formulaire de contact Gravity Forms.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions du plugin (ex : Désactiver les CSS natifs, Corriger l\'accessibilité).',
	],
	'custom-favicon.php' => [
		'title' => 'Gestion du favicon personnalisé',
		'short_desc' => 'Personnaliser les formats du favicon.',
		'long_desc' => 'Permet d\'ajouter des favicons supplémentaires (ex : ICO, SVG, Darkmode).',
	],
	'performance.php' => [
		'title' => 'Optimisations de performance',
		'short_desc' => 'Ajout d\'optimisations de performance.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions pour augmenter les performances de chargement (ex : Désactiver Speculative Loading, Utiliser la pré-chargement pour améliorer le LCP si une image se situe au-dessus de la ligne de flottaison).',
	],
	'greenshift.php' => [
		'title' => 'Personnalisation du plugin GreenShift',
		'short_desc' => 'Ajout des fonctions au plugin GreenShift.',
		'long_desc' => 'Permet d\'ajouter/modifier des fonctions du plugin GreenShift (ex : Points de rupture personnalisés, Darkmode).',
	],
];

// Récupère les modules activés depuis la base de données
$enabled_modules = get_option( 'wpsh_enabled_modules', array_keys($modules) );

// Inclusion des modules activés
foreach ( $modules as $file => $module_info ) {
	if ( in_array( $file, $enabled_modules, true ) ) {
		$path = WPSH_INC_DIR . $file;
		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}

// Inclure et exécuter le module favicon
require_once plugin_dir_path(__FILE__) . 'inc/favicon.php';

/**
 * Menu d’admin pour gérer les modules
 */
function wpsh_register_admin_menu() {
 
	 $icon_svg = 'data:image/svg+xml;base64,' . base64_encode(
		 file_get_contents( WPSH_PLUGIN_DIR . 'img/icon.svg' )
	 );
 
	 add_menu_page(
		 'WPSnipHub',
		 'WPSnipHub',
		 'manage_options',
		 'wpsh-helper',
		 'wpsh_admin_page',
		 $icon_svg,
		 // ou 'dashicons-admin-tools',
		 60
	 );
 }
 add_action( 'admin_menu', 'wpsh_register_admin_menu' );

/**
* Page d’admin
*/
   function wpsh_admin_page() {
		global $modules;
	
		if ( isset($_POST['wpsh_save_modules']) && check_admin_referer('wpsh_save_modules_nonce') ) {
			$enabled = isset($_POST['modules'])
				? array_map('sanitize_text_field', wp_unslash($_POST['modules']))
				: [];
			update_option( 'wpsh_enabled_modules', $enabled );
	
			echo '<div class="notice notice-success is-dismissible"><p>Modules mis à jour.</p></div>';
		}
	
		$enabled_modules = get_option( 'wpsh_enabled_modules', array_keys($modules) );
	
	// Inclure le logo
		echo '<div class="wrap wpsh-wrapper">';
		echo '<h1 class="wpsh-title">
			<span class="wpsh-title-text">WPSnipHub – Gestion des modules</span>
			<img 
				src="' . esc_url( WPSH_IMG_URL . 'wp-sniphub-logo.svg' ) . '"
				alt="WPSnipHub – Hub de snippets WordPress"
				class="wpsh-title-image"
				width="320"
				height="auto"
				loading="eager"
			>
		</h1>';
	
		echo '<form method="post">';
		wp_nonce_field('wpsh_save_modules_nonce');
	
		foreach ( $modules as $file => $module_info ) {
	
			$checkbox_id = 'wpsh-module-' . sanitize_title($file);
			$checked     = in_array( $file, $enabled_modules, true );
	
			echo '<section class="wpsh-card">';  
			echo '  <div class="wpsh-card-header">';
			echo '    <h2 class="wpsh-card-title">' . esc_html($module_info['title']) . '</h2>';
			echo '  </div>';  
			echo '  <div class="wpsh-card-body">';
			echo '    <p class="wpsh-card-short">' . esc_html($module_info['short_desc']) . '</p>';
			echo '    <p class="wpsh-card-long">' . esc_html($module_info['long_desc']) . '</p>';
			echo '  </div>'; 
			echo '  <div class="wpsh-card-footer">';
			echo '    <label for="' . esc_attr($checkbox_id) . '" class="wpsh-toggle">';
			echo '      <input type="checkbox" id="' . esc_attr($checkbox_id) . '" name="modules[]" value="' . esc_attr($file) . '" ' . checked($checked, true, false) . '>';
			echo '      <span class="wpsh-toggle-label">Activer le module</span>';
			echo '    </label>';
			echo '    <span class="wpsh-filename">' . esc_html($file) . '</span>';
			echo '  </div>';
	
			echo '</section>';
		}
	
		echo '<p class="wpsh-submit">';
		echo '  <input type="submit" name="wpsh_save_modules" class="button button-primary" value="Enregistrer">';
		echo '</p>';  
		echo '</form>';
		echo '</div>';
	}
   
   
   /**
	* Enqueue des styles admin pour WPSnipHub
	*/
   function wpsh_enqueue_admin_styles( $hook_suffix ) {
   
	   // Charger le CSS uniquement sur la page du plugin
	   if ( $hook_suffix !== 'toplevel_page_wpsh-helper' ) {
		   return;
	   }
   
	   wp_enqueue_style(
		   'wpsh-admin-style',
		   WPSH_PLUGIN_URL . 'css/admin/wpsh-admin.css',
		   [],
		   filemtime( WPSH_PLUGIN_DIR . 'css/admin/wpsh-admin.css' ) // cache-busting propre
	   );
   }
   add_action( 'admin_enqueue_scripts', 'wpsh_enqueue_admin_styles' );
