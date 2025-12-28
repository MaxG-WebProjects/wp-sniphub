<?php
/**
 * Gravity Forms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Gravity Forms : désactiver les CSS natifs
// via https://docs.gravityforms.com/gform_disable_css/
add_filter( 'gform_disable_css', '__return_true' );
*/

/** Correction d’un problème d’accessibilité sur les messages d’erreurs de Gravity Forms
 * via JB Audras : https://whodunit.consulting/gravity-forms-rgaa-accessibilite/
 * Changes default error markup after form validation.
 * This especially replaces the H2 tag with P.
 */
function who_change_error_message( $message, $form ) {
	return '<p class="gform_submission_error hide_summary">' .
		   '<span class="gform-icon gform-icon--close"></span>' .
		   esc_html__( 'There was a problem with your submission.', 'gravityforms' ) .
		   '</p>';
}
add_filter( 'gform_validation_message', 'who_change_error_message', 10, 2 );

////////////////////////////////////////////////////