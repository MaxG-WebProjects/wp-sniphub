<?php
/**
 * Plugin Name: WPSnipHub
 * Plugin URI: https://github.com/MaxG-WebProjects/wp-sniphub.git
 * Description: A dev-oriented central and modular hub for code snippets and utility functions of WordPress sites.
 * Version: 1.3.0
 * Stable tag: 1.3.0
 * Author: Max Gremez
 * Author URI: https://maxgremez.com/
 * Requires at least: 6.7
 * Tested up to: 7.1
 * Requires PHP: 8.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.fr.html
 * Text Domain: wp-sniphub
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ==========================================================
   Constants
   ========================================================== */

define( 'WPSH_VERSION', '1.3.0' );

define( 'WPSH_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPSH_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/* ==========================================================
   Load translations
   ========================================================== */

/**
 * Loads the plugin's translated strings.
 *
 * Hooked on `init` (not `plugins_loaded`) per WordPress guidance since 4.6,
 * to avoid the "_load_textdomain_just_in_time" notice for strings evaluated
 * before that hook fires.
 *
 * @return void
 */
function wpsh_load_textdomain() {
	load_plugin_textdomain( 'wp-sniphub', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'wpsh_load_textdomain' );

define( 'WPSH_INC_DIR', WPSH_PLUGIN_DIR . 'inc/' );
define( 'WPSH_CSS_URL', WPSH_PLUGIN_URL . 'css/' );
define( 'WPSH_IMG_URL', WPSH_PLUGIN_URL . 'img/' );

/* ==========================================================
   Module definitions (SINGLE SOURCE)
   ========================================================== */

/**
 * Get the list of available modules.
 *
 * @return array Array of module definitions.
 */
function wpsh_get_modules() {
	return apply_filters( 'wpsh_modules', [
		'setup.php' => [
			'title' => __( 'Base Configuration', 'wp-sniphub' ),
			'short_desc' => __( 'Initial site configuration and dependencies.', 'wp-sniphub' ),
			'long_desc' => __( 'Handles the site\'s basic settings, required dependencies, and global configuration.', 'wp-sniphub' ),
			'icon' => 'dashicons-admin-settings',
			'category' => 'foundations',
		],
		'scripts.php' => [
			'title' => __( 'Scripts', 'wp-sniphub' ),
			'short_desc' => __( 'Script management.', 'wp-sniphub' ),
			'long_desc' => __( 'Loads global JS files and optimizes their loading for specific pages.', 'wp-sniphub' ),
			'icon' => 'dashicons-media-code',
			'category' => 'assets',
		],
		'styles.php' => [
			'title' => __( 'Styles', 'wp-sniphub' ),
			'short_desc' => __( 'Style management.', 'wp-sniphub' ),
			'long_desc' => __( 'Loads CSS files and optimizes their loading for specific pages.', 'wp-sniphub' ),
			'icon' => 'dashicons-art',
			'category' => 'assets',
		],
		'custom-post-types.php' => [
			'title' => __( 'Custom Post Types', 'wp-sniphub' ),
			'short_desc' => __( 'Defines Custom Post Types (CPT).', 'wp-sniphub' ),
			'long_desc' => __( 'Adds and configures specific content types (e.g. Portfolio, Recipes, etc.).', 'wp-sniphub' ),
			'icon' => 'dashicons-admin-post',
			'category' => 'content',
		],
		'taxonomies.php' => [
			'title' => __( 'Custom Taxonomies', 'wp-sniphub' ),
			'short_desc' => __( 'Defines custom taxonomy types.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds and configures custom taxonomy types for Custom Post Types: categories and/or tags.', 'wp-sniphub' ),
			'icon' => 'dashicons-tag',
			'category' => 'content',
		],
		'shortcodes.php' => [
			'title' => __( 'Useful Shortcodes', 'wp-sniphub' ),
			'short_desc' => __( 'Create shortcodes whose output is displayed on the site.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds custom shortcodes (e.g. automatically display the current year in the footer).', 'wp-sniphub' ),
			'icon' => 'dashicons-shortcode',
			'category' => 'content',
		],
		'security.php' => [
			'title' => __( 'Backend / Frontend Hardening', 'wp-sniphub' ),
			'short_desc' => __( 'Adds backend / frontend security hardening.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds security measures not natively present in WordPress (e.g. blocking file editing).', 'wp-sniphub' ),
			'icon' => 'dashicons-shield',
			'category' => 'foundations',
		],
		'image-size.php' => [
			'title' => __( 'Custom Image Sizes', 'wp-sniphub' ),
			'short_desc' => __( 'Adds extra custom image sizes.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds image sizes not natively available in WordPress (e.g. Full HD size - 1920x1080px).', 'wp-sniphub' ),
			'icon' => 'dashicons-format-image',
			'category' => 'assets',
		],
		'cleanup.php' => [
			'title' => __( 'Disable Native Features', 'wp-sniphub' ),
			'short_desc' => __( 'Disables certain WordPress features.', 'wp-sniphub' ),
			'long_desc' => __( 'Disables features not needed by the site (e.g. disabling emojis, disabling Duotone SVG filters).', 'wp-sniphub' ),
			'icon' => 'dashicons-dismiss',
			'category' => 'assets',
		],
		'hooks.php' => [
			'title' => __( 'Custom Hooks and Filters', 'wp-sniphub' ),
			'short_desc' => __( 'Adds custom hooks and filters.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds custom PHP hooks and filters (e.g. browser tab notification).', 'wp-sniphub' ),
			'icon' => 'dashicons-admin-links',
			'category' => 'foundations',
		],
		'helpers.php' => [
			'title' => __( 'Utility Functions', 'wp-sniphub' ),
			'short_desc' => __( 'Adds reusable utility functions.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds reusable utility functions (e.g. retrieving a content excerpt).', 'wp-sniphub' ),
			'icon' => 'dashicons-admin-tools',
			'category' => 'foundations',
		],
		'woocommerce.php' => [
			'title' => __( 'WooCommerce Customization', 'wp-sniphub' ),
			'short_desc' => __( 'Adds functions to WooCommerce.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds/modifies WooCommerce functions (e.g. redirects, autofill).', 'wp-sniphub' ),
			'icon' => 'dashicons-cart',
			'category' => 'integrations',
		],
		'publications.php' => [
			'title' => __( 'Post Functions', 'wp-sniphub' ),
			'short_desc' => __( 'Adds functions to posts.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds/modifies post functions (e.g. copyright notice, maximum word count for post titles).', 'wp-sniphub' ),
			'icon' => 'dashicons-edit',
			'category' => 'content',
		],
		'custom-login.php' => [
			'title' => __( 'Login Page Customization', 'wp-sniphub' ),
			'short_desc' => __( 'Customizes the login page appearance.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds/modifies the login page appearance (e.g. background, colors, logo, etc.).', 'wp-sniphub' ),
			'icon' => 'dashicons-lock',
			'category' => 'appearance',
		],
		'custom-admin.php' => [
			'title' => __( 'Dashboard Interface Customization', 'wp-sniphub' ),
			'short_desc' => __( 'Customizes the Dashboard appearance.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds changes to the Dashboard (e.g. custom color palette, changing the Gravatar, footer text).', 'wp-sniphub' ),
			'icon' => 'dashicons-admin-appearance',
			'category' => 'appearance',
		],
		'media-setup.php' => [
			'title' => __( 'Additional Media Types', 'wp-sniphub' ),
			'short_desc' => __( 'Adds media types beyond jpeg, png, pdf, etc.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds media types not natively supported by WordPress (e.g. SVG, JSON).', 'wp-sniphub' ),
			'icon' => 'dashicons-admin-media',
			'category' => 'assets',
		],
		'gravity-forms.php' => [
			'title' => __( 'Gravity Forms Customization', 'wp-sniphub' ),
			'short_desc' => __( 'Customizes the Gravity Forms contact form plugin.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds/modifies plugin functions (e.g. disabling native CSS, fixing accessibility).', 'wp-sniphub' ),
			'icon' => 'dashicons-email-alt',
			'category' => 'integrations',
		],
		'favicon.php' => [
			'title' => __( 'Custom Favicon Management', 'wp-sniphub' ),
			'short_desc' => __( 'Customizes favicon formats.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds additional favicons (e.g. ICO, SVG, dark mode).', 'wp-sniphub' ),
			'icon' => 'dashicons-star-filled',
			'category' => 'appearance',
		],
		'performance.php' => [
			'title' => __( 'Performance Optimizations', 'wp-sniphub' ),
			'short_desc' => __( 'Adds performance optimizations.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds/modifies functions to improve loading performance (e.g. disabling Speculative Loading, preloading above-the-fold images to improve LCP).', 'wp-sniphub' ),
			'icon' => 'dashicons-performance',
			'category' => 'assets',
		],
		'greenshift.php' => [
			'title' => __( 'GreenShift Customization', 'wp-sniphub' ),
			'short_desc' => __( 'Adds functions to the GreenShift plugin.', 'wp-sniphub' ),
			'long_desc' => __( 'Adds/modifies GreenShift plugin functions (e.g. custom breakpoints, dark mode).', 'wp-sniphub' ),
			'icon' => 'dashicons-layout',
			'category' => 'integrations',
		],
	] );
}

/**
 * Get the ordered list of module categories used to group the settings screen.
 *
 * @return array Array of category titles keyed by category slug, in display order.
 */
function wpsh_get_module_categories() {
	return [
		'foundations'  => __( 'Foundations & Security', 'wp-sniphub' ),
		'content'      => __( 'Content', 'wp-sniphub' ),
		'appearance'   => __( 'Appearance & Interface', 'wp-sniphub' ),
		'assets'       => __( 'Assets & Performance', 'wp-sniphub' ),
		'integrations' => __( 'Third-Party Integrations', 'wp-sniphub' ),
		'other'        => __( 'Other', 'wp-sniphub' ),
	];
}

/* ==========================================================
   Loading active modules
   ========================================================== */

/**
 * Default enabled modules for a fresh install (no `wpsh_enabled_modules` option yet).
 *
 * All modules fail closed: none are enabled until the site owner explicitly opts in
 * from the WPSnipHub settings screen (constitution Principle III).
 *
 * @param array $wpsh_modules Array of module definitions, keyed by file name.
 * @return array Array of module file names enabled by default.
 */
function wpsh_get_default_enabled_modules( $wpsh_modules ) {
	return [];
}

/**
 * Load active modules.
 *
 * Reads the already-sanitized `wpsh_enabled_modules` option directly, without
 * calling `wpsh_get_modules()` — that array's translatable strings must not be
 * evaluated this early (`plugins_loaded`, before `init`), or WordPress logs a
 * "_load_textdomain_just_in_time" notice. `wpsh_sanitize_enabled_modules()`
 * already guarantees, at save time, that this option only ever contains known
 * module file names.
 *
 * @return void
 */
function wpsh_load_modules() {
	$enabled_modules = get_option( 'wpsh_enabled_modules', wpsh_get_default_enabled_modules( [] ) );

	foreach ( (array) $enabled_modules as $module_file ) {
		$path = WPSH_INC_DIR . $module_file;
		if ( file_exists( $path ) ) {
			require_once $path;
		}
	}
}
add_action( 'plugins_loaded', 'wpsh_load_modules' );

/**
 * Load core admin utilities that are always available, regardless of which
 * feature modules are enabled (e.g. settings backup/export/import).
 *
 * @return void
 */
function wpsh_load_core_utilities() {
	$path = WPSH_INC_DIR . 'settings-io.php';
	if ( file_exists( $path ) ) {
		require_once $path;
	}
}
add_action( 'plugins_loaded', 'wpsh_load_core_utilities' );

/* ==========================================================
   Settings API registration
   ========================================================== */

/**
 * Sanitizes the submitted list of enabled modules against the known module list.
 *
 * @param mixed $value Raw submitted value for the `wpsh_enabled_modules` option.
 * @return array Array of valid, known module file names.
 */
function wpsh_sanitize_enabled_modules( $value ) {
	$known_modules = array_keys( wpsh_get_modules() );
	$submitted     = is_array( $value ) ? array_map( 'sanitize_text_field', wp_unslash( $value ) ) : [];

	return array_values( array_intersect( $submitted, $known_modules ) );
}

/**
 * Registers the module-toggle setting and its admin settings section/fields.
 *
 * @return void
 */
function wpsh_register_settings() {
	$wpsh_modules = wpsh_get_modules();
	$categories   = wpsh_get_module_categories();

	register_setting(
		'wpsh_settings_group',
		'wpsh_enabled_modules',
		[
			'type'              => 'array',
			'description'       => __( 'Enabled WPSnipHub modules.', 'wp-sniphub' ),
			'sanitize_callback' => 'wpsh_sanitize_enabled_modules',
			'default'           => wpsh_get_default_enabled_modules( $wpsh_modules ),
		]
	);

	// Group modules by category so third-party modules added via the `wpsh_modules`
	// filter without a known 'category' still get displayed, under "Autres".
	$modules_by_category = [];
	foreach ( $wpsh_modules as $file => $module ) {
		$category = isset( $module['category'] ) && isset( $categories[ $module['category'] ] )
			? $module['category']
			: 'other';

		$modules_by_category[ $category ][ $file ] = $module;
	}

	foreach ( $categories as $category_slug => $category_title ) {
		if ( empty( $modules_by_category[ $category_slug ] ) ) {
			continue;
		}

		add_settings_section(
			'wpsh_modules_section_' . $category_slug,
			esc_html( $category_title ),
			'__return_false',
			'wpsh-helper'
		);

		foreach ( $modules_by_category[ $category_slug ] as $file => $module ) {
			$icon = isset( $module['icon'] ) ? $module['icon'] : 'dashicons-admin-generic';

			add_settings_field(
				'wpsh_module_' . sanitize_key( $file ),
				sprintf(
					'<span class="dashicons %s" aria-hidden="true"></span> %s',
					esc_attr( $icon ),
					esc_html( $module['title'] )
				),
				'wpsh_render_module_field',
				'wpsh-helper',
				'wpsh_modules_section_' . $category_slug,
				[
					'file'   => $file,
					'module' => $module,
				]
			);
		}
	}
}
add_action( 'admin_init', 'wpsh_register_settings' );

/**
 * Renders one module's settings-table field: enable/disable checkbox + descriptions.
 *
 * @param array $args Field arguments: 'file' (module file name) and 'module' (module definition).
 * @return void
 */
function wpsh_render_module_field( $args ) {
	$file    = $args['file'];
	$module  = $args['module'];
	$id      = 'wpsh-module-' . sanitize_title( $file );
	$enabled = get_option( 'wpsh_enabled_modules', wpsh_get_default_enabled_modules( wpsh_get_modules() ) );
	$checked = in_array( $file, (array) $enabled, true );

	echo '<label for="' . esc_attr( $id ) . '">';
	echo '<input type="checkbox" id="' . esc_attr( $id ) . '" name="wpsh_enabled_modules[]" value="' . esc_attr( $file ) . '" ' . checked( $checked, true, false ) . ' /> ';
	echo esc_html( $module['short_desc'] );
	echo '</label>';
	echo '<p class="description">' . esc_html( $module['long_desc'] ) . '</p>';
	echo '<p class="description wpsh-filename">' . esc_html( $file ) . '</p>';
}

/* ==========================================================
   Menu admin
   ========================================================== */

/**
 * Register admin menu.
 *
 * @return void
 */
function wpsh_register_admin_menu() {
	$icon_path = WPSH_PLUGIN_DIR . 'img/admin/icon.svg';
	$icon_svg = 'dashicons-admin-generic';

	if ( file_exists( $icon_path ) ) {
		// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local bundled plugin asset, not remote/user input; see compliance-exceptions.md.
		$icon_content = file_get_contents( $icon_path );
		if ( false !== $icon_content ) {
			// phpcs:ignore WordPress.PHP.DiscouragedPHPFunctions.obfuscation_base64_encode -- Encoding an SVG as a data URI, not obfuscating code; see compliance-exceptions.md.
			$icon_svg = 'data:image/svg+xml;base64,' . base64_encode( $icon_content );
		}
	}

	add_menu_page(
		'WPSnipHub',
		'WPSnipHub',
		'manage_options',
		'wpsh-helper',
		'wpsh_admin_page',
		$icon_svg,
		60
	);
}
add_action( 'admin_menu', 'wpsh_register_admin_menu' );

/* ==========================================================
   Page admin
   ========================================================== */

/**
 * Admin page callback.
 *
 * @return void
 */
function wpsh_admin_page() {
	// Verify permissions.
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have sufficient permissions to access this page.', 'wp-sniphub' ) );
	}

	echo '<div class="wrap wpsh-wrapper">';

	echo '<div class="wpsh-header-banner">';
	echo '<div class="wpsh-header-banner-left">';
	echo '<h1 class="wpsh-title">';
	echo '<span class="wpsh-title-text">';
	esc_html_e( 'WPSnipHub – Module Management', 'wp-sniphub' );
	echo '</span>';
	echo '<img src="' . esc_url( WPSH_IMG_URL . '/admin/wp-sniphub-logo.svg' ) . '" alt="' . esc_attr__( 'WPSnipHub Logo', 'wp-sniphub' ) . '" class="wpsh-title-image">';
	echo '</h1>';
	echo '<p class="wpsh-header-banner-description">';
	esc_html_e( 'A dev-oriented central and modular hub for code snippets and utility functions of WordPress sites.', 'wp-sniphub' );
	echo '</p>';
	echo '</div>';
	echo '</div>';

	echo '<div class="notice notice-warning inline"><p>';
	esc_html_e( 'Deleting WPSnipHub permanently removes its settings and all content created via its custom post types and taxonomies (portfolio, testimonials, events, categories, etc.) — this cannot be undone.', 'wp-sniphub' );
	echo '</p></div>';

	settings_errors( 'wpsh_enabled_modules' );

	echo '<form method="post" action="options.php">';
	settings_fields( 'wpsh_settings_group' );
	do_settings_sections( 'wpsh-helper' );
	submit_button( __( 'Save', 'wp-sniphub' ) );
	echo '</form>';

	// Rendered outside the form above: this section's own controls include a
	// <form> (import), and a <form> cannot be nested inside another <form>.
	do_settings_sections( 'wpsh-helper-io' );

	echo '</div>';
}

/* ==========================================================
   Styles admin
   ========================================================== */

/**
 * Enqueue admin styles.
 *
 * @param string $hook_suffix Current admin page hook suffix.
 * @return void
 */
function wpsh_enqueue_admin_styles( $hook_suffix ) {
	if ( 'toplevel_page_wpsh-helper' !== $hook_suffix ) {
		return;
	}

	// Ensure dashicons are loaded for module icons.
	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style(
		'wpsh-admin-style',
		WPSH_PLUGIN_URL . 'css/admin/wpsh-admin.css',
		[],
		apply_filters( 'wpsh_admin_css_version', WPSH_VERSION )
	);
}
add_action( 'admin_enqueue_scripts', 'wpsh_enqueue_admin_styles' );

