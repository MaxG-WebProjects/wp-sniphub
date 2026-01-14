<?php
/**
 * Publications
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Limit the maximum number of words for your publication titles
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#18_Limiter_le_nombre_maximum_de_mots_pour_vos_titres_de_publications
*/
function wpsh_limit_post_title_words( $post_id ) {

    $title = get_post_field( 'post_title', $post_id );

    if ( str_word_count( wp_strip_all_tags( $title ) ) > 15 ) {
        wp_die(
            esc_html__(
                'Error: your post title exceeds the maximum number of allowed words.',
                'wp-sniphub'
            ),
            esc_html__( 'Publishing error', 'wp-sniphub' ),
            [ 'back_link' => true ]
        );
    }
}
add_action( 'publish_post', 'wpsh_limit_post_title_words' );

/* ==========================================================
   Set the minimum number of words for WordPress posts
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#19_Definir_le_nombre_minimum_de_mots_sur_les_publications_WordPress
*/
function wpsh_minimum_post_content_words( $post_id ) {

    $content = get_post_field( 'post_content', $post_id );
    $minimum = 1000;

    if ( str_word_count( wp_strip_all_tags( $content ) ) < $minimum ) {
        wp_die(
            esc_html__(
                'Error: your post content does not meet the minimum word count.',
                'wp-sniphub'
            ),
            esc_html__( 'Publishing error', 'wp-sniphub' ),
            [ 'back_link' => true ]
        );
    }
}
add_action( 'publish_post', 'wpsh_minimum_post_content_words' );

/* ==========================================================
   Add custom content after post content.
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#20_Ajouter_du_contenu_personnalise_sous_chaque_article_WordPress
*/
function wpsh_add_post_content( $content ) {

    if ( ! is_feed() && ! is_home() ) {
        $content .= sprintf(
            '<p>%s &copy; %s&nbsp;%s</p>',
            esc_html__( 'This article is copyright', 'wp-sniphub' ),
            esc_html( wp_date( 'Y' ) ),
            esc_html( get_bloginfo( 'name' ) )
        );
    }

    return $content;
}
add_filter( 'the_content', 'wpsh_add_post_content' );

/* ==========================================================
   Set default editor content
   ========================================================== */
/** Display default text on all your WordPress posts
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#21_Afficher_un_texte_par_defaut_sur_toutes_vos_publications_WordPress
*/
function wpsh_editor_default_content( $content ) {
    return esc_html__(
        "This is some custom content I'm adding to the post editor because I hate re-typing it.",
        'wp-sniphub'
    );
}
add_filter( 'default_content', 'wpsh_editor_default_content' );

/* ==========================================================
   Enforce featured image before publishing a post
   ========================================================== */
/*
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#24_Rendre_limage_mise_en_avant_obligatoire_avant_de_publier_un_article
*/
function wpsh_check_featured_image( $post_id ) {

    if ( get_post_type( $post_id ) !== 'post' ) {
        return;
    }

    if ( ! has_post_thumbnail( $post_id ) ) {
        set_transient( 'wpsh_missing_featured_image', true );

        remove_action( 'save_post', 'wpsh_check_featured_image' );
        wp_update_post(
            [
                'ID'          => $post_id,
                'post_status' => 'draft',
            ]
        );
        add_action( 'save_post', 'wpsh_check_featured_image' );
    } else {
        delete_transient( 'wpsh_missing_featured_image' );
    }
}
add_action( 'save_post', 'wpsh_check_featured_image' );


/**
 * Display admin notice if featured image is missing.
 *
 * @return void
 */
function wpsh_featured_image_error_notice() {

    if ( get_transient( 'wpsh_missing_featured_image' ) ) {
        echo '<div class="notice notice-error"><p><strong>';
        esc_html_e(
            'You must select a Featured Image. The post has been saved as draft.',
            'wp-sniphub'
        );
        echo '</strong></p></div>';

        delete_transient( 'wpsh_missing_featured_image' );
    }
}
add_action( 'admin_notices', 'wpsh_featured_image_error_notice' );