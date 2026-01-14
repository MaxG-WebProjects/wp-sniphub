<?php
/**
 * Shortcodes
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Display the current year automatically (see > Footer)
   ========================================================== */
/*
// via https://www.momofr.net/tips-tricks-afficher-lannee-en-cours-automatiquement/?sfw=pass1678445222
// + https://stackoverflow.com/questions/20370582/display-current-year-in-wordpress
// or via https://www.moyens.net/guide-wp/comment-ajouter-une-date-droit-dauteur-dynamique-dans-votre-pied/#rb-utiliser-un-code-personnalise
// or via https://hager.media/dynamic-copyright-date-current-year-in-wordpress/
* @return string
// >> Shortcode : [year]
*/
function wpsh_display_year() {
	return wp_date( 'Y' );
}
add_shortcode( 'year', 'wpsh_display_year' );