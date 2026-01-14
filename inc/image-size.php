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
   Add custom image sizes in WordPress
   ========================================================== */
/* 
// via https://wp-umbrella.com/fr/tutorials/wordpress-image-sizes/#how-to-add-custom-image-sizes-in-wordpress
+
// Display image size on the media library screen (NOT USED)
// via https://wordpress.stackexchange.com/questions/30894/display-image-size-in-media-library-screen
+
// READ THIS: https://wpmudev.com/blog/wordpress-image-sizes/
*/

// Saves custom settings
function wpsh_register_custom_image_sizes() {
	// On enregistre deux nouveaux réglages
	register_setting( 'media', 'square_size_w', array( 'type' => 'integer', 'default' => 160 ) );
	register_setting( 'media', 'square_size_h', array( 'type' => 'integer', 'default' => 160 ) );

	register_setting( 'media', 'fullhd_size_w', array( 'type' => 'integer', 'default' => 1920 ) );
	register_setting( 'media', 'fullhd_size_h', array( 'type' => 'integer', 'default' => 1080 ) );

	// Added the "Square Size" field
	add_settings_field(
		'square_size',
		__( 'Taille Carré', 'wp-sniphub' ),
		'wpsh_render_square_size_fields',
		'media',
		'default'
	);

	// Added the "Full HD Size" field
	add_settings_field(
		'fullhd_size',
		__( 'Taille Full HD', 'wp-sniphub' ),
		'wpsh_render_fullhd_size_fields',
		'media',
		'default'
	);
}
add_action( 'admin_init', 'wpsh_register_custom_image_sizes' );

/**
 * Displays the fields for the "Square" size
 */
function wpsh_render_square_size_fields() {
	$w = get_option( 'square_size_w', 160 );
	$h = get_option( 'square_size_h', 160 );
	?>
	<label for="square_size_w">
		<?php echo esc_html__( 'Largeur maximale', 'wp-sniphub' ); ?>
	</label>
	<input name="square_size_w" type="number" step="1" min="0" id="square_size_w" value="<?php echo esc_attr( $w ); ?>" class="small-text" />
	<br />
	<label for="square_size_h">
		<?php echo esc_html__( 'Hauteur maximale', 'wp-sniphub' ); ?>
	</label>
	<input name="square_size_h" type="number" step="1" min="0" id="square_size_h" value="<?php echo esc_attr( $h ); ?>" class="small-text" />
	<?php
}

/**
 * Displays fields for "Full HD" size
 */
function wpsh_render_fullhd_size_fields() {
	$w = get_option( 'fullhd_size_w', 1920 );
	$h = get_option( 'fullhd_size_h', 1080 );
	?>
	<label for="fullhd_size_w">
		<?php echo esc_html__( 'Largeur maximale', 'wp-sniphub' ); ?>
	</label>
	<input name="fullhd_size_w" type="number" step="1" min="0" id="fullhd_size_w" value="<?php echo esc_attr( $w ); ?>" class="small-text" />
	<br />
	<label for="fullhd_size_h">
		<?php echo esc_html__( 'Hauteur maximale', 'wp-sniphub' ); ?>
	</label>
	<input name="fullhd_size_h" type="number" step="1" min="0" id="fullhd_size_h" value="<?php echo esc_attr( $h ); ?>" class="small-text" />
	<?php
}

/**
 * Declares the sizes for use in add_image_size()
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