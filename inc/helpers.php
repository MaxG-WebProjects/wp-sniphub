<?php
/**
 * Helpers - Utility functions
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Get a trimmed content excerpt
   ========================================================== */
/**
 * Retrieves a content excerpt (20 words by default).
 *
 * @param int      $length  Number of words.
 * @param int|null $post_id Post ID.
 * @return string
 */
function wpsh_get_excerpt( $length = 20, $post_id = null ) {
	$post_content = $post_id
		? get_post_field( 'post_content', $post_id )
		: get_the_content();

	return wp_trim_words(
		wp_strip_all_tags( $post_content ),
		absint( $length )
	);
}

/* ==========================================================
   Featured image output
   ========================================================== */
/**
 * Displays the featured image with the complete <img> tag.
 *
 * @param string $size  Image size.
 * @param string $class CSS class.
 * @return void
 */
function wpsh_the_post_thumbnail( $size = 'large', $class = '' ) {
	if ( ! has_post_thumbnail() ) {
		return;
	}

	$id  = get_post_thumbnail_id();
	$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
	$alt = $alt ? $alt : get_the_title();

	echo wp_get_attachment_image(
		$id,
		$size,
		false,
		[
			'class' => esc_attr( $class ),
			'alt'   => esc_attr( $alt ),
		]
	);
}

/* ==========================================================
   Customizer color helper
   ========================================================== */
/**
 * Retrieves a color defined in the Customizer.
 *
 * @param string $setting Setting name.
 * @param string $default Default value.
 * @return string
 */
function wpsh_get_color( $setting = 'theme_primary_color', $default = '#00155A' ) {
	return get_theme_mod( $setting, $default );
}

/* ==========================================================
   Localized date formatting helper
   ========================================================== */
/**
 * Returns a formatted and localized date (in French, for example).
 *
 * @param string|null $date   Source date.
 * @param string      $format Date format.
 * @return string
 */
function wpsh_format_date( $date = null, $format = 'j F Y' ) {
	if ( ! $date ) {
		$date = get_the_date( 'Y-m-d' );
	}

	return wp_date( $format, strtotime( $date ) );
}

/* ==========================================================
   Subpage detection helper
   ========================================================== */
/**
 * Checks if the current page is a subpage.
 *
 * @param int|null $parent_id Parent post ID.
 * @return bool
 */
function wpsh_is_subpage( $parent_id = null ) {
	global $post;

	if ( is_page() && ! empty( $post->post_parent ) ) {
		return $parent_id
			? (int) $post->post_parent === (int) $parent_id
			: true;
	}

	return false;
}

/* ==========================================================
   Debug entry point
   ========================================================== */
/**
 * Debug entry point (no output).
 *
 * @param mixed $var Data to inspect.
 * @return void
 */
function wpsh_debug_log( $var ) {
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
		do_action( 'wpsh_debug', $var );
	}
}
