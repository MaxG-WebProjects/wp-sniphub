<?php
/**
 * Améliorations de sécurité
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Supprime la version WordPress dans <head>
remove_action('wp_head', 'wp_generator');

////////////////////////////////////////////////////

// Bloque l’édition de fichiers via l’admin
// define('DISALLOW_FILE_EDIT', true);

////////////////////////////////////////////////////

// Désactive les RSS
add_action( 'do_feed', function() { wp_die('RSS désactivé'); }, 1 );
add_action( 'do_feed_rdf', function() { wp_die('RSS désactivé'); }, 1 );
add_action( 'do_feed_rss', function() { wp_die('RSS désactivé'); }, 1 );
add_action( 'do_feed_rss2', function() { wp_die('RSS désactivé'); }, 1 );
add_action( 'do_feed_atom', function() { wp_die('RSS désactivé'); }, 1 );

////////////////////////////////////////////////////

/* Ajouter un utilisateur administrateur dans WordPress
// via https://www.wpbeginner.com/wp-tutorials/25-extremely-useful-tricks-for-the-wordpress-functions-file/#adminuserftp

function wpb_admin_account(){
    }
add_action('init','wpb_admin_account');
*/

////////////////////////////////////////////////////