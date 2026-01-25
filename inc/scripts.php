<?php
/**
 * Scripts & Styles
 */

if ( ! defined( 'ABSPATH' ) ) {
     exit;
}

/* ==========================================================
   Scripts
   ========================================================== */
/**
 * Enqueue frontend scripts.
 *
 * @return void

function wpsh_enqueue_scripts() {

     wp_enqueue_script(
          'wpsh-theme-script',
          get_template_directory_uri() . '/js/main.js',
          [ 'jquery' ],
          wp_get_theme()->get( 'Version' ),
          true
     );
}
add_action( 'wp_enqueue_scripts', 'wpsh_enqueue_scripts', 10 );
 */