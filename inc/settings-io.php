<?php
/**
 * Settings backup: export/import
 *
 * @package WPSnipHub
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * List of option names this plugin manages, eligible for export/import.
 *
 * @return array
 */
function wpsh_get_exportable_options() {
	return [
		'wpsh_enabled_modules',
		'square_size_w',
		'square_size_h',
		'fullhd_size_w',
		'fullhd_size_h',
	];
}

/**
 * Registers the "Backup" section on the WPSnipHub settings screen.
 *
 * Uses its own settings "page" slug (`wpsh-helper-io`), separate from the module
 * toggles' `wpsh-helper`, so `do_settings_sections()` renders it on its own — this
 * section's import control is itself a `<form>`, and HTML does not allow a `<form>`
 * nested inside another `<form>` (it silently closes the outer one early, breaking
 * its submit button). `wpsh_admin_page()` renders this section after closing the
 * module-toggle form, not inside it.
 *
 * @return void
 */
function wpsh_register_settings_io_section() {
	add_settings_section(
		'wpsh_settings_io_section',
		__( 'Settings Backup', 'wp-sniphub' ),
		'wpsh_render_settings_io_section',
		'wpsh-helper-io'
	);
}
add_action( 'admin_init', 'wpsh_register_settings_io_section' );

/**
 * Renders the export/import controls.
 *
 * @return void
 */
function wpsh_render_settings_io_section() {
	$export_url = wp_nonce_url(
		add_query_arg( 'action', 'wpsh_export_settings', admin_url( 'admin-post.php' ) ),
		'wpsh_export_settings'
	);
	?>
	<p>
		<?php esc_html_e( 'Export the current settings to a JSON file, or import a previously exported file.', 'wp-sniphub' ); ?>
	</p>
	<p>
		<a href="<?php echo esc_url( $export_url ); ?>" class="button">
			<?php esc_html_e( 'Export Settings', 'wp-sniphub' ); ?>
		</a>
	</p>
	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" enctype="multipart/form-data">
		<input type="hidden" name="action" value="wpsh_import_settings" />
		<?php wp_nonce_field( 'wpsh_import_settings' ); ?>
		<p>
			<label for="wpsh_import_file"><?php esc_html_e( 'Settings file (.json)', 'wp-sniphub' ); ?></label><br />
			<input type="file" name="wpsh_import_file" id="wpsh_import_file" accept="application/json" required="required" />
		</p>
		<?php submit_button( __( 'Import Settings', 'wp-sniphub' ), 'secondary', 'submit', false ); ?>
	</form>
	<?php
}

/**
 * Handles the settings export request: outputs a JSON file download.
 *
 * @return void
 */
function wpsh_handle_export_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to perform this action.', 'wp-sniphub' ) );
	}
	check_admin_referer( 'wpsh_export_settings' );

	$data = [];
	foreach ( wpsh_get_exportable_options() as $option_name ) {
		$data[ $option_name ] = get_option( $option_name );
	}

	nocache_headers();
	header( 'Content-Type: application/json; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="wpsniphub-settings-' . gmdate( 'Y-m-d' ) . '.json"' );
	echo wp_json_encode( $data, JSON_PRETTY_PRINT );
	exit;
}
add_action( 'admin_post_wpsh_export_settings', 'wpsh_handle_export_settings' );

/**
 * Handles the settings import request: validates and applies the uploaded JSON file.
 *
 * @return void
 */
function wpsh_handle_import_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to perform this action.', 'wp-sniphub' ) );
	}
	check_admin_referer( 'wpsh_import_settings' );

	$redirect_url = add_query_arg( 'page', 'wpsh-helper', admin_url( 'admin.php' ) );

	$has_upload = isset( $_FILES['wpsh_import_file']['tmp_name'], $_FILES['wpsh_import_file']['error'] )
		&& UPLOAD_ERR_OK === $_FILES['wpsh_import_file']['error'];

	$data = null;
	if ( $has_upload ) {
		$tmp_name = sanitize_text_field( wp_unslash( $_FILES['wpsh_import_file']['tmp_name'] ) );
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reading a just-uploaded temp file by its PHP-generated tmp_name, not a remote/user-supplied path; see compliance-exceptions.md.
		$contents = file_get_contents( $tmp_name );
		$data     = json_decode( $contents, true );
	}

	if ( ! is_array( $data ) ) {
		wp_safe_redirect( add_query_arg( 'wpsh_import', 'error', $redirect_url ) );
		exit;
	}

	$known_options = wpsh_get_exportable_options();

	foreach ( $data as $option_name => $value ) {
		if ( ! in_array( $option_name, $known_options, true ) ) {
			continue;
		}

		if ( 'wpsh_enabled_modules' === $option_name ) {
			$value = wpsh_sanitize_enabled_modules( $value );
		} else {
			$value = absint( $value );
		}

		update_option( $option_name, $value );
	}

	wp_safe_redirect( add_query_arg( 'wpsh_import', 'success', $redirect_url ) );
	exit;
}
add_action( 'admin_post_wpsh_import_settings', 'wpsh_handle_import_settings' );

/**
 * Displays an admin notice after an import attempt.
 *
 * @return void
 */
function wpsh_settings_io_admin_notice() {
	if ( ! isset( $_GET['wpsh_import'], $_GET['page'] ) ) {
		return;
	}

	$page = sanitize_text_field( wp_unslash( $_GET['page'] ) );
	if ( 'wpsh-helper' !== $page ) {
		return;
	}

	$status = sanitize_text_field( wp_unslash( $_GET['wpsh_import'] ) );

	if ( 'success' === $status ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings imported successfully.', 'wp-sniphub' ) . '</p></div>';
	} else {
		echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'Import failed: invalid file.', 'wp-sniphub' ) . '</p></div>';
	}
}
add_action( 'admin_notices', 'wpsh_settings_io_admin_notice' );
