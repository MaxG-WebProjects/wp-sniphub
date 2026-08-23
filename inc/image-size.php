<?php
/**
 * Images size
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Register custom image size settings and fields
   ========================================================== */
/*
// via https://wp-umbrella.com/fr/tutorials/wordpress-image-sizes/#how-to-add-custom-image-sizes-in-wordpress
// via https://wordpress.stackexchange.com/questions/30894/display-image-size-in-media-library-screen (not used)
// via https://wpmudev.com/blog/wordpress-image-sizes/
*/
/**
 * Registers the custom image size settings and their admin fields.
 *
 * @return void
 */
function wpsh_register_custom_image_sizes() {
	// On enregistre deux nouveaux réglages
	register_setting( 'media', 'square_size_w', array( 'type' => 'integer', 'default' => 160 ) );
	register_setting( 'media', 'square_size_h', array( 'type' => 'integer', 'default' => 160 ) );

	register_setting( 'media', 'fullhd_size_w', array( 'type' => 'integer', 'default' => 1920 ) );
	register_setting( 'media', 'fullhd_size_h', array( 'type' => 'integer', 'default' => 1080 ) );

	// Added the "Square Size" field
	add_settings_field(
		'square_size',
		__( 'Square Size', 'wp-sniphub' ),
		'wpsh_render_square_size_fields',
		'media',
		'default'
	);

	// Added the "Full HD Size" field
	add_settings_field(
		'fullhd_size',
		__( 'Full HD Size', 'wp-sniphub' ),
		'wpsh_render_fullhd_size_fields',
		'media',
		'default'
	);
}
add_action( 'admin_init', 'wpsh_register_custom_image_sizes' );

/* ==========================================================
   Render the "Square" size fields
   ========================================================== */
/**
 * Displays the fields for the "Square" size.
 *
 * @return void
 */
function wpsh_render_square_size_fields() {
	$w = get_option( 'square_size_w', 160 );
	$h = get_option( 'square_size_h', 160 );
	?>
	<fieldset>
		<legend class="screen-reader-text"><span><?php esc_html_e( 'Square Size', 'wp-sniphub' ); ?></span></legend>
		<label for="square_size_w"><?php esc_html_e( 'Maximum width', 'wp-sniphub' ); ?></label>
		<input name="square_size_w" type="number" step="1" min="0" id="square_size_w" value="<?php echo esc_attr( $w ); ?>" class="small-text" />
		<br />
		<label for="square_size_h"><?php esc_html_e( 'Maximum height', 'wp-sniphub' ); ?></label>
		<input name="square_size_h" type="number" step="1" min="0" id="square_size_h" value="<?php echo esc_attr( $h ); ?>" class="small-text" />
	</fieldset>
	<?php
}

/* ==========================================================
   Render the "Full HD" size fields
   ========================================================== */
/**
 * Displays fields for "Full HD" size.
 *
 * @return void
 */
function wpsh_render_fullhd_size_fields() {
	$w = get_option( 'fullhd_size_w', 1920 );
	$h = get_option( 'fullhd_size_h', 1080 );
	?>
	<fieldset>
		<legend class="screen-reader-text"><span><?php esc_html_e( 'Full HD Size', 'wp-sniphub' ); ?></span></legend>
		<label for="fullhd_size_w"><?php esc_html_e( 'Maximum width', 'wp-sniphub' ); ?></label>
		<input name="fullhd_size_w" type="number" step="1" min="0" id="fullhd_size_w" value="<?php echo esc_attr( $w ); ?>" class="small-text" />
		<br />
		<label for="fullhd_size_h"><?php esc_html_e( 'Maximum height', 'wp-sniphub' ); ?></label>
		<input name="fullhd_size_h" type="number" step="1" min="0" id="fullhd_size_h" value="<?php echo esc_attr( $h ); ?>" class="small-text" />
	</fieldset>
	<?php
}

/* ==========================================================
   Declare the sizes for use in add_image_size()
   ========================================================== */
/**
 * Declares the sizes for use in add_image_size().
 *
 * @return void
 */
function wpsh_add_custom_image_sizes() {
	// Square Size
	add_image_size(
		'square',
		intval( get_option( 'square_size_w', 160 ) ),
		intval( get_option( 'square_size_h', 160 ) ),
		true // Hard crop comme les miniatures
	);

	// Full HD Size
	add_image_size(
		'fullhd',
		intval( get_option( 'fullhd_size_w', 1920 ) ),
		intval( get_option( 'fullhd_size_h', 1080 ) ),
		false
	);
}
add_action( 'after_setup_theme', 'wpsh_add_custom_image_sizes' );
