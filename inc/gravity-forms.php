<?php
/**
 * Gravity Forms
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Gravity Forms: Disable native CSS
   ========================================================== */
/* 
// via https://docs.gravityforms.com/gform_disable_css/
add_filter( 'gform_disable_css', '__return_true' );
*/

/* ==========================================================
   Fixed an accessibility issue with Gravity Forms error messages
   ========================================================== */
/*
 * via JB Audras : https://whodunit.consulting/gravity-forms-rgaa-accessibilite/
 * Changes default error markup after form validation.
 * This especially replaces the H2 tag with P.
 */
function wpsh_change_gform_error_message( $message, $form ) {
     return '<p class="gform_submission_error hide_summary">' .
            '<span class="gform-icon gform-icon--close"></span>' .
            esc_html__( 'There was a problem with your submission. Please check the fields below.', 'wp-sniphub' ) .
            '</p>';
 }
 add_filter( 'gform_validation_message', 'wpsh_change_gform_error_message', 10, 2 );