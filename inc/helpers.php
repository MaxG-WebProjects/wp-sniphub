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
   Helpers WPSnipHub
   ========================================================== */
/**
 * Retrieves a content excerpt (20 words by default)
 *
 * @param int      $length  Nombre de mots.
 * @param int|null $post_id ID du post.
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
   Displays the featured image with the complete <img> tag
   ========================================================== */
/*
 * @param string $size  Taille d’image.
 * @param string $class Classe CSS.
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
   Retrieves a color defined in the Customizer
   ========================================================== */
 /*
 * @param string $setting Setting name.
 * @param string $default Valeur par défaut.
 * @return string
 */
function wpsh_get_color( $setting = 'theme_primary_color', $default = '#00155A' ) {
    return get_theme_mod( $setting, $default );
}

/* ================================================================
   Returns a formatted and localized date (in French, for example).
   ================================================================ */
 /*
 *
 * @param string|null $date   Date source.
 * @param string      $format Format.
 * @return string
 */
function wpsh_format_date( $date = null, $format = 'j F Y' ) {
    if ( ! $date ) {
        $date = get_the_date( 'Y-m-d' );
    }

    return wp_date( $format, strtotime( $date ) );
}

/* ==========================================================
   Checks if the current page is a subpage
   ========================================================== */
 /*
 * @param int|null $parent_id ID du parent.
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
/*
 * Debug entry point (no output) //safe WordPress.org
 *
 * @param mixed $var Donnée à inspecter.
 * @return void
 */
function wpsh_debug_log( $var ) {
    if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
        do_action( 'wpsh_debug', $var );
    }
}