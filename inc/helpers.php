<?php
/**
 * Fonctions utilitaires du MU-plugin
 *
 * Ces fonctions ne sont pas accrochées à des hooks,
 * elles sont appelées directement dans les templates ou modules.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Récupère un extrait de contenu (par défaut 20 mots)
 */
function theme_get_excerpt( $length = 20, $post_id = null ) {
    $post_content = $post_id ? get_post_field( 'post_content', $post_id ) : get_the_content();
    return wp_trim_words( wp_strip_all_tags( $post_content ), $length );
}

/**
 * Affiche l'image mise en avant avec balise <img> complète
 */
function theme_the_post_thumbnail( $size = 'large', $class = '' ) {
    if ( has_post_thumbnail() ) {
        $id  = get_post_thumbnail_id();
        $alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
        $alt = $alt ?: get_the_title();
        echo wp_get_attachment_image( $id, $size, false, [ 'class' => $class, 'alt' => esc_attr( $alt ) ] );
    }
}

/**
 * Récupère une couleur définie dans le Customizer
 */
function theme_get_color( $setting = 'theme_primary_color', $default = '#00155A' ) {
    return get_theme_mod( $setting, $default );
}

/**
 * Retourne une date formatée en français
 */
function theme_format_date( $date = null, $format = 'j F Y' ) {
    if ( ! $date ) {
        $date = get_the_date( 'Y-m-d' );
    }
    return date_i18n( $format, strtotime( $date ) );
}

/**
 * Vérifie si la page actuelle est une sous-page
 */
function theme_is_subpage( $parent_id = null ) {
    global $post;
    if ( is_page() && $post->post_parent ) {
        return $parent_id ? ( $post->post_parent == $parent_id ) : true;
    }
    return false;
}

/**
 * Raccourci pour debug (affiche une variable proprement)
 */
function theme_debug( $var, $display = true ) {
     if ( defined('WP_DEBUG') && WP_DEBUG ) {
         // Utiliser var_export() plutôt que print_r()
         $output = var_export( $var, true );
 
         if ( $display ) {
             echo '<pre style="background:#111;color:#0f0;padding:10px;border-radius:5px;font-size:13px;overflow:auto;">';
             echo esc_html( $output );
             echo '</pre>';
         } else {
             // Utiliser wp_debug_backtrace_summary() pour le contexte + error_log via _doing_it_wrong()
             _doing_it_wrong( __FUNCTION__, 'Debug output logged', '1.0.0' );
             trigger_error( $output, E_USER_NOTICE );
         }
     }
 }

