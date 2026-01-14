<?php
/**
 * Performance
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Disable Speculative Loading
   ========================================================== */
// Christine Siembida (via LinkedIn) :
// Disable Speculative Loading via the Speculation Rules API (WordPress v6.8)
add_filter( 'wp_speculation_rules_configuration', '__return_null' );

/* ============================================================================
   Restrict the loading of the cookie consent banner to the 'Contact' page ONLY
   ============================================================================ */
/* 
// will only be displayed on the page that loads cookies: those of Cloudflare Turnstile
// via ChatGPT :

add_action('wp_enqueue_scripts', 'control_pressidium_cookie_scripts', 100);
function control_pressidium_cookie_scripts() {
	// Disable global loading of plugin scripts and styles
	wp_dequeue_style('cookie-consent-client-style-css'); // Replace with the exact handle of the style if known
	wp_dequeue_script('cookie-consent-client-script');   // Replace with the exact handle of the script
	wp_dequeue_script('cookie-consent-client-script-js-extra'); // Replace with the exact handle of the script

	// Upload files only on a specific page
	if (is_page(75)) { // Number is the ID of the target page 'Contact'
		// Load the CSS file
		wp_enqueue_style(
			'cookie-consent-client-style-css',
			get_site_url() . 'https://maxgremez.com/site/plugins/pressidium-cookie-consent/public/bundle.client.css',
			array(), // No dependencies
			null     // No specific version
		);

		// Load the JavaScript file `consent-mode.js`
		wp_enqueue_script(
			'cookie-consent-client-script',
			get_site_url() . '/site/plugins/pressidium-cookie-consent/public/consent-mode.js',
			array(), // No dependencies
			null,    // No specific version
			true     // Load in footer
		);

		// Load the JavaScript file `bundle.client.js`
		wp_enqueue_script(
			'cookie-consent-client-script-js-extra',
			get_site_url() . '/site/plugins/pressidium-cookie-consent/public/bundle.client.js',
			array('cookie-consent-client-script'), // Depends on the consent-mode.js file
			null,                                // No specific version
			true                                 // Load in footer
		);
	}
} */

/* ============================================================================
   Use Preload To Improve LCP If Image Is Necessary Above Fold 
   ============================================================================ */
/*
// via https://itchycode.com/use-preload-to-improve-lcp-if-image-is-necessary-above-fold/
// + via https://www.artwai.com/preload-image-responsive-ameliorer-le-lcp/
// + via https://wpalpha.io/how-to-preload-lcp-image-in-wordpress/
// + via https://www.wppagebuilders.com/preload-images-wordpress/#preloading-image-in-gutenberg
// Preload a responsive image only on homepage
>>>> DOES NOT WORK: causes a display bug with removal of external margins and duplicate content (logo)
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

/* ====================================================================================
   Set Fetchpriority to High for the >>Featured Image<< in WordPress (without a Plugin)
   ==================================================================================== */
/* 
// via https://www.janinedalton.com/disable-lazy-loading-featured-image/
>>>>> DISABLING FOLLOWING THE ADDITION OF THE 'Fetchpriority' FUNCTION IN WP ROCKET v3.16
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