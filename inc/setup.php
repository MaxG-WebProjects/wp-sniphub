<?php
/**
 * Setup
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit;
}

/* ==========================================================
 Control the Heartbeat API and adjust the frequency.
 ========================================================== */
/**
// (see Chrome console alert: Failed to load resource: the server responded with a status of 400 > wp-admin/admin-ajax.php)
// via https://www.wptechnic.com/how-to-disable-limit-wordpress-heartbeat/
* @param array $settings Heartbeat settings.
* @return array
*/
function wpsh_custom_heartbeat_frequency( $settings ) {
  $settings['interval'] = 180; // Interval in seconds. Change the value to your desired frequency.
  return $settings;
}
add_filter( 'heartbeat_settings', 'wpsh_custom_heartbeat_frequency' );


/* ==========================================================
 Reset WordPress settings to default
 ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#30_Reinitialiser_les_parametres_par_defaut_de_WordPress_sur_votre_site
function set_theme_defaults() {
    $o = array(
        'avatar_default'         => 'blank',
        'avatar_rating'          => 'G',
        'category_base'          => '/thema',
        'comment_max_links'      => 0,
        'comments_per_page'      => 0,
        'date_format'            => 'd.m.Y',
        'default_ping_status'    => 'closed',
        'default_post_edit_rows' => 30,
        'links_updated_date_format' => 'j. F Y, H:i',
        'permalink_structure'    => '/%year%/%postname%/',
        'rss_language'           => 'de',
        'timezone_string'        => 'Etc/GMT-1',
        'use_smilies'            => 0,
    );
    foreach ( $o as $k => $v ){update_option($k, $v);}
    // Delete dummy post and comment.
    wp_delete_post(1, TRUE);
    wp_delete_comment(1);
    return;
}
register_activation_hook(__FILE__, 'set_theme_defaults');
*/