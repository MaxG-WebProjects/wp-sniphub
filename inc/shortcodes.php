<?php
/**
 * Shortcodes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Afficher l’année en cours automatiquement (cf > Footer)
// via https://www.momofr.net/tips-tricks-afficher-lannee-en-cours-automatiquement/?sfw=pass1678445222
// + https://stackoverflow.com/questions/20370582/display-current-year-in-wordpress
// ou via https://www.moyens.net/guide-wp/comment-ajouter-une-date-droit-dauteur-dynamique-dans-votre-pied/#rb-utiliser-un-code-personnalise
// ou via https://hager.media/dynamic-copyright-date-current-year-in-wordpress/
*/
// shortcode à insérer : [year]
function display_year() {
	$year = date('Y');
	return $year;
}
add_shortcode('year', 'display_year');

////////////////////////////////////////////////////
