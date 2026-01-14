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