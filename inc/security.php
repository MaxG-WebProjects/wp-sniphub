<?php
/**
 * Security enhancements
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   External HTTP requests hardening
   ========================================================== */
/**
 * WordPress allows plugins and themes to perform outbound HTTP requests
 * (API calls, updates, external services).
 *
 * For security reasons, WordPress provides two core constants:
 * - define( 'WP_HTTP_BLOCK_EXTERNAL', true );
 * - define( 'WP_ACCESSIBLE_HOSTS', 'domain.com' );
 *
 * Minimal hosts configuration :
 * define( 'WP_ACCESSIBLE_HOSTS', 'api.wordpress.org,downloads.wordpress.org,*.wordpress.org' );
 *
 * Common domains you will almost certainly need to allow:
 * - *.wordpress.org //Wildcard for the entire official WordPress.org infrastructure
 * • api.wordpress.org //Checking for WordPress updates: Core, version number, PHP compatibility, changelogs, translations, plugins, themes
 * • downloads.wordpress.org //Download updates
 * • translate.wordpress.org //Translations
 * • plugins.svn.wordpress.org //Plugins
 * • themes.svn.wordpress.org //Themes
 * • s.w.org //Static ressources (images, assets, icons)
 * • stats.wordpress.com //Statistics
 * - secure.gravatar.com //Gravatar
 * - public-api.wordpress.com //Jetpack
 * - woocommerce.com, *.woocommerce.com //WooCommerce
 * Other important domains
 * - fonts.googleapis.com, fonts.gstatic.com //Google fonts
 * - updates.yoast.com //YoastSEO
 * - api.acf.com //Advanced Custom Fields
 * - wpml.org //WPML
 * - gravityforms.com //Gravity Forms
 * - api.stripe.com, checkout.stripe.com, hooks.stripe.com //Stripe
 * - paypal.com, api.paypal.com //Paypal
 * - Email service providers
 * - CDN and external asset domains
 * 
 * IMPORTANT:
 * These constants MUST be defined in wp-config.php to be effective.
 * They cannot be reliably defined in a plugin or mu-plugin.
 *
 * WPSnipHub does not enforce these settings automatically.
 * This module only documents and encourages their usage
 * for advanced security hardening on controlled environments.
 *
 * This feature is particularly useful for:
 * - Enterprise websites with strict security or compliance requirements
 * - Staging or pre-production environments that should not reach external services
 * - Performance optimisation by limiting unnecessary outbound requests
 * - Websites handling sensitive data where outbound traffic must be controlled and audited
 *   
 * ⚠️ Use with caution: blocking external HTTP requests can disrupt
 *  WordPress core updates, plugin/theme updates, or third-party integrations
 * if required domains are not explicitly allowed.
 * 
 * Do not enable external request blocking blindly.
 * Before activating it, monitor your site’s outbound connections using tools
 * such as Query Monitor. Build your allowlist based on real, observed traffic
 * to avoid unintentionally breaking site functionality.
 * Never activate WP_HTTP_BLOCK_EXTERNAL in production without prior auditing.
 */
 
/* ==========================================================
   Remove the WordPress version in <head>
   ========================================================== */
remove_action('wp_head', 'wp_generator');

/* ==========================================================
   Block file editing via admin
   ========================================================== */
// define('DISALLOW_FILE_EDIT', true);

/* ==========================================================
   Add an administrator user in WordPress
   ========================================================== */
/* 
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#adminuserftp

function wpsh_admin_account(){
    }
add_action('init','wpsh_admin_account');
*/