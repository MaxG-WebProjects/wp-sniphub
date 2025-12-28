<?php
/**
 * Personnalisation du login
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Ajouter des tailles d'images personnalisées dans WordPress
// via https://wp-umbrella.com/fr/tutorials/wordpress-image-sizes/#how-to-add-custom-image-sizes-in-wordpress
+
// Afficher la taille de l'image dans l'écran de la médiathèque (NON UTILISÉ)
// via https://wordpress.stackexchange.com/questions/30894/display-image-size-in-media-library-screen
+
// A LIRE : https://wpmudev.com/blog/wordpress-image-sizes/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enregistre les réglages personnalisés
 */
function wpsh_register_custom_image_sizes() {
	// On enregistre deux nouveaux réglages
	register_setting( 'media', 'square_size_w', array( 'type' => 'integer', 'default' => 160 ) );
	register_setting( 'media', 'square_size_h', array( 'type' => 'integer', 'default' => 160 ) );

	register_setting( 'media', 'fullhd_size_w', array( 'type' => 'integer', 'default' => 1920 ) );
	register_setting( 'media', 'fullhd_size_h', array( 'type' => 'integer', 'default' => 1080 ) );

	// Ajout du champ "Taille Carré"
	add_settings_field(
		'square_size',
		__( 'Taille Carré', 'mu-helper' ),
		'wpsh_render_square_size_fields',
		'media',
		'default'
	);

	// Ajout du champ "Taille Full HD"
	add_settings_field(
		'fullhd_size',
		__( 'Taille Full HD', 'mu-helper' ),
		'wpsh_render_fullhd_size_fields',
		'media',
		'default'
	);
}
add_action( 'admin_init', 'wpsh_register_custom_image_sizes' );

/**
 * Affiche les champs pour la taille "Carré"
 */
function wpsh_render_square_size_fields() {
	$w = get_option( 'square_size_w', 160 );
	$h = get_option( 'square_size_h', 160 );
	?>
	<label for="square_size_w"><?php _e( 'Largeur maximale', 'mu-helper' ); ?></label>
	<input name="square_size_w" type="number" step="1" min="0" id="square_size_w" value="<?php echo esc_attr( $w ); ?>" class="small-text" />
	<br />
	<label for="square_size_h"><?php _e( 'Hauteur maximale', 'mu-helper' ); ?></label>
	<input name="square_size_h" type="number" step="1" min="0" id="square_size_h" value="<?php echo esc_attr( $h ); ?>" class="small-text" />
	<?php
}

/**
 * Affiche les champs pour la taille "Full HD"
 */
function wpsh_render_fullhd_size_fields() {
	$w = get_option( 'fullhd_size_w', 1920 );
	$h = get_option( 'fullhd_size_h', 1080 );
	?>
	<label for="fullhd_size_w"><?php _e( 'Largeur maximale', 'mu-helper' ); ?></label>
	<input name="fullhd_size_w" type="number" step="1" min="0" id="fullhd_size_w" value="<?php echo esc_attr( $w ); ?>" class="small-text" />
	<br />
	<label for="fullhd_size_h"><?php _e( 'Hauteur maximale', 'mu-helper' ); ?></label>
	<input name="fullhd_size_h" type="number" step="1" min="0" id="fullhd_size_h" value="<?php echo esc_attr( $h ); ?>" class="small-text" />
	<?php
}

/**
 * Déclare les tailles pour l’utilisation dans add_image_size()
 */
function wpsh_add_custom_image_sizes() {
	// Taille Carré
	add_image_size(
		'square',
		intval( get_option( 'square_size_w', 160 ) ),
		intval( get_option( 'square_size_h', 160 ) ),
		true // Hard crop comme les miniatures
	);

	// Taille Full HD
	add_image_size(
		'fullhd',
		intval( get_option( 'fullhd_size_w', 1920 ) ),
		intval( get_option( 'fullhd_size_h', 1080 ) ),
		false
	);
}
add_action( 'after_setup_theme', 'wpsh_add_custom_image_sizes' );

////////////////////////////////////////////////////