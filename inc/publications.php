<?php
/**
 * Publications
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Limiter le nombre maximum de mots pour vos titres de publications
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#18_Limiter_le_nombre_maximum_de_mots_pour_vos_titres_de_publications
*/
function maxWord($title){
global $post;
$title = $post->post_title;
if (str_word_count($title) >= 15 ) //set this to the maximum number of words
wp_die( __('Error: your post title is over the maximum word count.') );
}
add_action('publish_post', 'maxWord');

////////////////////////////////////////////////////

/** Définir le nombre minimum de mots sur les publications WordPress
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#19_Definir_le_nombre_minimum_de_mots_sur_les_publications_WordPress
*/
function minWord($content){
global $post;
$num = 1000; //set this to the minimum number of words
$content = $post->post_content;
if (str_word_count($content) < $num) wp_die( __('Error: your post is below the minimum word count.') ); } add_action('publish_post', 'minWord');

////////////////////////////////////////////////////

/** Ajouter du contenu personnalisé sous chaque article WordPress
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#20_Ajouter_du_contenu_personnalise_sous_chaque_article_WordPress
*/
function add_post_content($content) {
if(!is_feed() && !is_home()) {
$content .= '<p>This article is copyright &copy; ' . date('Y') . '&nbsp;' . get_bloginfo('name') . '</p>';
}
return $content;
}
add_filter('the_content', 'add_post_content');

////////////////////////////////////////////////////

/** Afficher un texte par défaut sur toutes vos publications WordPress
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#21_Afficher_un_texte_par_defaut_sur_toutes_vos_publications_WordPress
*/
add_filter( 'default_content', 'my_editor_content' );
function my_editor_content( $content ) {
$content = "This is some custom content I'm adding to the post editor because I hate re-typing it.";
return $content;
}

////////////////////////////////////////////////////

/** Rendre l’image mise en avant obligatoire avant de publier un article
// via https://tutoriels.lws.fr/wordpress/snippets-wordpress#24_Rendre_limage_mise_en_avant_obligatoire_avant_de_publier_un_article
*/
add_action('save_post', 'wpds_check_thumbnail');
add_action('admin_notices', 'wpds_thumbnail_error');
function wpds_check_thumbnail($post_id) {
    // change to any custom post type
    if(get_post_type($post_id) != 'post')
        return;
    if ( !has_post_thumbnail( $post_id ) ) {
        // set a transient to show the users an admin message
        set_transient( "has_post_thumbnail", "no" );
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'wpds_check_thumbnail');
        // update the post set it to draft
        wp_update_post(array('ID' => $post_id, 'post_status' => 'draft')); 
        add_action('save_post', 'wpds_check_thumbnail');
    } else {
        delete_transient( "has_post_thumbnail" );
    }
}
function wpds_thumbnail_error()
{
    // check if the transient is set, and display the error message
    if ( get_transient( "has_post_thumbnail" ) == "no" ) {
        echo "&lt;div id='message' class='error'&gt;&lt;p&gt;&lt;strong&gt;You must select Featured Image. Your Post is saved but it can not be published.&lt;/strong&gt;&lt;/p&gt;&lt;/div&gt;";
        delete_transient( "has_post_thumbnail" );
    } 
}