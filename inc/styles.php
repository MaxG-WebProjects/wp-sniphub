<?php
/**
 * Scripts & Styles
 */

if ( ! defined( 'ABSPATH' ) ) {
     exit;
}

/* ==========================================================
   Styles
   ========================================================== */
/**
 * Enqueue frontend styles.
 *
 * @return void

function wpsh_enqueue_styles() {
	$stylesheet_uri = apply_filters( 'wpsh_stylesheet_uri', get_stylesheet_uri() );

	wp_enqueue_style(
		'wpsh-theme-style',
		$stylesheet_uri,
		[],
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'wpsh_enqueue_styles', 10 );
 */