<?php
/**
 * Media Setup
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Disable loading core block inline styles (05.07.2023)
// via https://www.spacedmonkey.com/2023/06/29/improve-front-end-performance-with-just-one-line-of-php/
// + via https://github.com/spacedmonkey/jonnyandtaylor/commit/dc2182c7f7fbbefe59afe515e9804185d6de2726
*/
add_filter( 'should_load_separate_core_block_assets', '__return_false' );
// + Remove core block patterns.
remove_theme_support( 'core-block-patterns' );

////////////////////////////////////////////////////

/* Allow additional MIME types
// Use 'text/plain' instead of 'application/json' for JSON because of a current Wordpress core bug
// via https://mollychanel.com/blog/tech/web/how-to-upload-json-to-wordpress/#Edit-the-functions-file
*/
function add_upload_mimes( $types ) {
	// Vérifie si l'utilisateur est administrateur pour restreindre l'upload à ce rôle uniquement
	if ( current_user_can( 'administrator' ) ) {
		$types['json'] = 'text/plain';
	}
	return $types;
}
add_filter( 'upload_mimes', 'add_upload_mimes' );

////////////////////////////////////////////////////

/* Allow SVG >> SI NE FONCTIONNE EN LOCAL
// via https://wpengine.com/resources/enable-svg-wordpress/#Method_2_Manually_enable_SVG_file_uploads */
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
	global $wp_version;
	
  // Vérifie si l'utilisateur est administrateur pour restreindre l'upload à ce rôle uniquement
  if ( !current_user_can( 'administrator' ) ) {
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
	  'proper_filename' => $data['proper_filename']
  ];

}, 10, 4 );

function cc_mime_types( $mimes ){
  // Vérifie si l'utilisateur est administrateur pour restreindre l'upload à ce rôle uniquement
  if ( current_user_can( 'administrator' ) ) {
	  $mimes['svg'] = 'image/svg+xml';
  }
  return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
  echo '<style type="text/css">
		.attachment-266x266, .thumbnail img {
			 width: 100% !important;
			 height: auto !important;
		}
		</style>';
}
add_action( 'admin_head', 'fix_svg' );

////////////////////////////////////////////////////

/* Autoriser l’import de fichiers SVG et WebP
// via https://capitainewp.io/autoriser-svg-webp-wordpress/

// Hooks
add_filter( 'upload_mimes', 'capitaine_mime_types' );
add_filter( 'wp_check_filetype_and_ext', 'capitaine_file_types', 10, 4 );

// Autoriser l'import des fichiers SVG et WEBP
function capitaine_mime_types( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	$mimes['webp'] = 'image/webp';
	return $mimes;
}

// Contrôle de l'import d'un WEBP
function capitaine_file_types( $types, $file, $filename, $mimes ) {
	if ( false !== strpos( $filename, '.webp' ) ) {
		$types['ext'] = 'webp';
		   $types['type'] = 'image/webp';
	}
	return $types;
}
*/