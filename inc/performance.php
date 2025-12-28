<?php
/**
 * Performance
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Christine Siembida (via LinkedIn) :
// Désactiver Speculative Loading via the Speculation Rules API (WordPress v6.8)
add_filter( 'wp_speculation_rules_configuration', '__return_null' );

////////////////////////////////////////////////////

/* Restreindre le chargement de la bannière de consentement aux cookies à la page 'Contact' UNIQUEMENT
// >> ne s'affichera que sur la page qui charge des cookies : ceux de Cloudflare Turnstile
// via ChatGPT :

add_action('wp_enqueue_scripts', 'control_pressidium_cookie_scripts', 100);
function control_pressidium_cookie_scripts() {
	// Désactiver le chargement global des scripts et styles du plugin
	wp_dequeue_style('cookie-consent-client-style-css'); // Remplacez par le handle exact du style si connu
	wp_dequeue_script('cookie-consent-client-script');   // Remplacez par le handle exact du script
	wp_dequeue_script('cookie-consent-client-script-js-extra'); // Remplacez par le handle exact du script

	// Charger les fichiers uniquement sur une page spécifique
	if (is_page(75)) { // 75 est l'ID de la page cible 'Contact'
		// Charger le fichier CSS
		wp_enqueue_style(
			'cookie-consent-client-style-css',
			get_site_url() . 'https://maxgremez.com/site/plugins/pressidium-cookie-consent/public/bundle.client.css',
			array(), // Pas de dépendances
			null     // Pas de version spécifique
		);

		// Charger le fichier JavaScript `consent-mode.js`
		wp_enqueue_script(
			'cookie-consent-client-script',
			get_site_url() . '/site/plugins/pressidium-cookie-consent/public/consent-mode.js',
			array(), // Pas de dépendances
			null,    // Pas de version spécifique
			true     // Charger dans le footer
		);

		// Charger le fichier JavaScript `bundle.client.js`
		wp_enqueue_script(
			'cookie-consent-client-script-js-extra',
			get_site_url() . '/site/plugins/pressidium-cookie-consent/public/bundle.client.js',
			array('cookie-consent-client-script'), // Dépend du fichier consent-mode.js
			null,                                // Pas de version spécifique
			true                                 // Charger dans le footer
		);
	}
} */

////////////////////////////////////////////////////

/* Use Preload To Improve LCP If Image Is Necessary Above Fold 
// via https://itchycode.com/use-preload-to-improve-lcp-if-image-is-necessary-above-fold/
// + via https://www.artwai.com/preload-image-responsive-ameliorer-le-lcp/
// + via https://wpalpha.io/how-to-preload-lcp-image-in-wordpress/
// + via https://www.wppagebuilders.com/preload-images-wordpress/#preloading-image-in-gutenberg
// Preload a responsive image only on homepage
>>>> NE FONCTIONNE PAS : provoque un bug d'affichage avec une suppression des marges externes et des doublons de contenus (logo)
function preload_featured_image_home() {
  if (is_front_page()) {
	echo '<link rel="preload" as="image" href="https://git.maxgremez.com/site/img/max-gremez-portrait-bw-underlined-575x575px.webp" media="(max-width: 575px)>';
  }
}
add_action( 'wp_head', 'preload_featured_image_home', 90 );
*/

/*
// via https://www.wppagebuilders.com/preload-images-wordpress/
// + via https://docs.wp-rocket.me/article/1494-preload-largest-contentful-paint-image
function wpp_preloadimages() {
  echo '
  <link rel="preload" as="image" href="https://maxgremez.com/site/img/max-gremez-portrait-bw-362x420px-144dpi.webp" />
  ';
}
add_action( 'wp_head', 'wpp_preloadimages' );
*/

// If you are using different images for desktop and mobile:
// <link rel="preload" href="https://yourdomain.com/your-lcp-image-mobile.jpg" as="image" media="(max-width: 480px)">
// <link rel="preload" href="https://yourdomain.com/your-lcp-image-desktop.jpg" as="image" media="(min-width: 481px)">

////////////////////////////////////////////////////

/* Set Fetchpriority to High for the >>Featured Image<< in WordPress (without a Plugin)
// via https://www.janinedalton.com/disable-lazy-loading-featured-image/
>>>>> DÉSACTIVATION SUITE AJOUT DE LA FONCTION 'Fetchpriority' DANS WP ROCKET v3.16
*/
/*Set high fetch priority for the featured image
function featured_image_fixes($html) {
	if ( !is_single() && !is_page()) {
		return $html;
	}
	$remove = 'decoding="async"';
	$add = 'fetchpriority="high"';
	$html = str_replace($remove, $add, $html);
	return $html;
}
add_filter( 'post_thumbnail_html', 'featured_image_fixes' );
*/

////////////////////////////////////////////////////

/* Annuler le chargement du fichier CSS du block du plugin 'Social Sharing Block' puis le déclencher uniquement lors de l'affichage du footer
// via l'aide de Damien Chantelouve (https://dam.cht.lv/) sur le Slack 'WordPressFR' + ChatGTP - le 27.04.2024
// NE FONCTIONNE PAS COMME PRÉVU > LE FICHIER CSS CONTINUE DE SE CHARGER DÈS LE LANCEMENT DU SITE
// Dequeue the social block style
add_action( 'init', 'dequeue_social_block_style', 11 );
function dequeue_social_block_style() {
	wp_dequeue_style( 'outermost-social-sharing-style' );
}

// Enqueue back the social block style (if it was supposed to load)
add_action( 'wp_footer', 'enqueue_social_block_style' );
function enqueue_social_block_style() {
	if ( wp_style_is( 'outermost-social-sharing-style', 'registered' ) ) {
		wp_enqueue_style( 'outermost-social-sharing-style' );
	}
}
*/

/* via ChatGPT 
// Dequeue the CSS file during initialization
add_action( 'wp_enqueue_scripts', 'dequeue_css_initially', 999 );
function dequeue_css_initially() {
	wp_dequeue_style( 'outermost-social-sharing-style' ); // Replace 'style-handle' with the handle of the CSS file you want to dequeue
}

// Enqueue the CSS file in the footer
add_action( 'wp_footer', 'enqueue_css_in_footer', 10 );
function enqueue_css_in_footer() {
	wp_enqueue_style( 'outermost-social-sharing-style' ); // Replace 'style-handle' with the handle of the CSS file you want to enqueue
}
*/

/* Reporter le chargement du fichier CSS du block 'Social Sharing'
// via ChatGPT
// NE FONCTIONNE PAS
function enqueue_custom_css_in_footer() {
	// Enqueue votre fichier CSS dans le footer pour toutes les pages
	wp_enqueue_style('social-sharing', 'https://maxgremez.com/site/plugins/social-sharing-block/build/social-sharing/style-index.css', array(), 'version', true);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_css_in_footer');


function deregister_plugin_css() {
	if (!is_admin()) {
		wp_dequeue_style('social-sharing-block-style'); // Remplacez 'social-sharing-block-style' par le handle réel du CSS du plugin.
	}
}
add_action('wp_enqueue_scripts', 'deregister_plugin_css', 100);

function enqueue_plugin_css_in_footer() {
	if (!is_admin()) {
		wp_register_style('social-sharing-block-style', 'https://maxgremez.com/site/plugins/social-sharing-block/build/social-sharing/style-index.css');
		add_action('wp_footer', 'load_plugin_css');
	}
}
add_action('wp_enqueue_scripts', 'enqueue_plugin_css_in_footer', 11);

function load_plugin_css() {
	wp_enqueue_style('social-sharing-block-style');
}
*/

////////////////////////////////////////////////////