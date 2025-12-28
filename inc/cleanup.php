<?php
/**
 * Nettoyage du thème
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* Disable the emoji's
// via https://www.keycdn.com/blog/speed-up-wordpress
// ou via https://www.denisbouquet.com/remove-wordpress-emoji-code/
*/
  function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
    add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
  }
  add_action( 'init', 'disable_emojis' );

/* Filter function used to remove the tinymce emoji plugin.
// @param    array  $plugins
// @return   array             Difference betwen the two arrays
*/
  function disable_emojis_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
      return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
      return array();
    }
  }
  
/* REMOVE WP EMOJI
// ou via https://www.denisbouquet.com/remove-wordpress-emoji-code/
  
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  
// Supprimer les emojis
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
*/

////////////////////////////////////////////////////

// Supprime le lien RSD, Windows Live Writer et autres
remove_action( 'wp_head', 'rsd_link', 50 );
remove_action( 'wp_head', 'wlwmanifest_link', 50 );
remove_action( 'wp_head', 'wp_shortlink_wp_head', 50 );

////////////////////////////////////////////////////

/* How to Remove WordPress Header “Junk”
// via https://www.wpexplorer.com/clean-wordpress-head/
*/
// Remove RSS feed links.
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );

////////////////////////////////////////////////////

/* Suppression des filtres SVG Duotone de WordPress
// via https://codecolibri.fr/supprimer-filtres-svg-duotone-wordpress/
// + via https://www.rankya.com/wordpress/how-to-disable-gutenberg-duotone-filter/
// + via https://www.deefuse.fr/journal-developpement-full-stack-php-laravel-codeigniter/desactiver-completement-les-filtres-duotone-sur-wordpress/
// Suppression des Duotone dans l'éditeur backoffice via theme.json >> "customDuotone": false,"defaultDuotone": false,"duotone": [],
*/
if(has_action("wp_body_open", "wp_global_styles_render_svg_filters"))
  remove_action("wp_body_open", "wp_global_styles_render_svg_filters");
/* Suppression des SVG duotone du plugin Gutenberg */
if(has_action("wp_body_open", "gutenberg_global_styles_render_svg_filters"))
  remove_action("wp_body_open", "gutenberg_global_styles_render_svg_filters");

////////////////////////////////////////////////////

/* Remove Gutenberg library CSS and global inline styles
// via https://foolhat.party/blog/remove-gutenberg-css/
// via https://smartwp.com/remove-gutenberg-css/
*/
/* Fully Disable Gutenberg editor. */
// add_filter('use_block_editor_for_post_type', '__return_false', 10);
// Don't load Gutenberg-related stylesheets.
add_action( 'wp_enqueue_scripts', 'remove_block_css', 100 );
function remove_block_css() {
//	wp_dequeue_style( 'wp-block-library' ); // Wordpress core
//	wp_dequeue_style( 'wp-block-library-theme' ); // Wordpress core
/* >> CREE UN BUG D'AFFICHAGE DU HEADER DANS GREENSHIFT & FRONTEND */
    wp_dequeue_style( 'wc-block-style' ); // WooCommerce
    wp_dequeue_style( 'storefront-gutenberg-blocks' ); // Storefront theme
}

////////////////////////////////////////////////////
