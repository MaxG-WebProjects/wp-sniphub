<?php
/**
 * Media Setup
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Core block assets
   ========================================================== */
/* Disable loading core block inline styles (05.07.2023)
// via https://www.spacedmonkey.com/2023/06/29/improve-front-end-performance-with-just-one-line-of-php/
// + via https://github.com/spacedmonkey/jonnyandtaylor/commit/dc2182c7f7fbbefe59afe515e9804185d6de2726
*/
add_filter( 'should_load_separate_core_block_assets', '__return_false' );
remove_theme_support( 'core-block-patterns' );

/* ==========================================================
   Allow additional MIME types
   ========================================================== */
/* Allow additional MIME types
// Use 'text/plain' instead of 'application/json' for JSON because of a current Wordpress core bug
// via https://mollychanel.com/blog/tech/web/how-to-upload-json-to-wordpress/#Edit-the-functions-file
*/
function wpsh_media_add_upload_mimes( $types ) {
	if ( current_user_can( 'administrator' ) ) {
		$types['json'] = 'text/plain';
	}
	return $types;
}
add_filter( 'upload_mimes', 'wpsh_media_add_upload_mimes' );

/* ==========================================================
   Allow SVG upload (admin only)
   ========================================================== */
/* Allow SVG >> IF IT DOESN'T WORK LOCALLY
// via https://wpengine.com/resources/enable-svg-wordpress/#Method_2_Manually_enable_SVG_file_uploads
add_filter(
	'wp_check_filetype_and_ext',
	function ( $data, $file, $filename, $mimes ) {
		// Vérifie si l'utilisateur est administrateur pour restreindre l'upload à ce rôle uniquement
		if ( ! current_user_can( 'administrator' ) ) {
			return $data;
		}
		// Vérifie la version de WordPress si nécessaire
		global $wp_version;
		if ( $wp_version !== '4.7.1' ) {	
			return $data;
		}

		$filetype = wp_check_filetype( $filename, $mimes );

		return [
			'ext'             => $filetype['ext'],
			'type'            => $filetype['type'],
			'proper_filename' => $data['proper_filename'],
		];
	},
	10,
	4
);

// Checks if the user is an administrator to restrict uploads to that role only.
function wpsh_media_allow_svg_mime( $mimes ) {
	if ( current_user_can( 'administrator' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}
add_filter( 'upload_mimes', 'wpsh_media_allow_svg_mime' );
*/

/* ==========================================================
   Fix SVG preview in admin
   ========================================================== */

function wpsh_media_fix_svg_admin_display() {
	echo '<style type="text/css">
		.attachment-266x266,
		.thumbnail img {
			width: 100% !important;
			height: auto !important;
		}
	</style>';
}
add_action( 'admin_head', 'wpsh_media_fix_svg_admin_display' );


////////////////////////////////////////////////////

/* Allow the import of SVG and WebP files
// via https://capitainewp.io/autoriser-svg-webp-wordpress/
// Hooks
add_filter( 'upload_mimes', 'capitaine_mime_types' );
add_filter( 'wp_check_filetype_and_ext', 'capitaine_file_types', 10, 4 );

// Allow the import of SVG and WEBP files
function capitaine_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	$mimes['webp'] = 'image/webp';
	return $mimes;
}

// Controlling the import of a WEBP file
function capitaine_file_types( $types, $file, $filename, $mimes ) {
	if ( false !== strpos( $filename, '.webp' ) ) {
		$types['ext'] = 'webp';
		   $types['type'] = 'image/webp';
	}
	return $types;
}
*/