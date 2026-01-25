<?php
 /**
  * WPSnipHub - Internal documentation
  *
  * Author: MaxG-WebProjects
  * Author URI: https://maxgremez.com/
  * Plugin URI: https://github.com/MaxG-WebProjects/wp-sniphub
  * Requires at least: 6.7
  * Tested up to: 6.9
  * Requires PHP: 8.0
  * Stable tag: 1.2.5
  * License: GPLv2 or later
  * License URI: http://www.gnu.org/licenses/gpl-2.0.html
  *
  * This file is used solely for plugin documentation.
  * It is not loaded by WordPress, but can be opened for reference.
  *
  * Plugin structure:
  * wp-sniphub/
  * │
  * ├── _docs.php # Internal documentation (not loaded)
  * ├── CHANGELOG.md # Internal documentation (not loaded)
  * ├── README.md # Internal documentation (not loaded)
  * ├── README.txt # Internal documentation (not loaded)
  * ├── LICENSE # Internal documentation (not loaded)
  * │ 
  * ├── wp-sniphub.php
  * │
  * ├── inc/
  * │   ├── setup.php
  * │   ├── security.php
  * │   ├── custom-login.php
  * │   ├── custom-admin.php
  * │   ├── custom-favicon.php
  * │   ├── hooks.php
  * │   ├── scripts.php
  * │   ├── styles.php
  * │   ├── performance.php
  * │   ├── cleanup.php
  * │   ├── custom-post-types.php
  * │   ├── taxonomies.php
  * │   ├── media-setup.php
  * │   ├── image-size.php
  * │   ├── shortcodes.php
  * │   ├── publications.php
  * │   ├── woocommerce.php
  * │   ├── gravity-forms.php
  * │   ├── greenshift.php
  * │   └── helpers.php
  * │   
  * ├── css/
  * │   ├── admin/
  * │   │   └── wpsh-admin.css
  * │   │   
  * │   ├── custom-login/
  * │   │   └── login-styles.css
  * │   │   
  * │   └── custom-admin-colors/
  * │       └── color-scheme.css
  * │   
  * └── img/
  *     ├── icon.svg
  *     ├── gravatar-icon-290x290px.png
  *     └── favicons/
  *         ├── favicon.ico
  *         ├── favicon.svg
  *         ├── favicon-16x16.png
  *         ├── favicon-32x32.png
  *         ├── favicon-96x96.png
  *         ├── apple-touch-icon.png
  *         ├── web-app-manifest-192x192.png
  *         ├── web-app-manifest-512x512.png
  *         ├── safari-pinned-tab.svg
  *         └── site.webmanifest
  * 
  * Description:
  * WPSnipHub is a modular WordPress plugin designed to centralize reusable snippets and utility functions in a clean, maintainable, and scalable way.
  * Each feature is packaged as an independent module that can be enabled or disabled from a dedicated administration screen.
  * Main features include:
  * - WordPress admin dashboard customization (logo, colors, footer, avatars)
  * - Custom login page styling
  * - Front-end and back-end scripts and styles management
  * - Custom post types and taxonomies registration
  * - Reusable shortcodes
  * - Security hardening and WordPress cleanup
  * - Helper utility functions shared across modules
  * The plugin follows WordPress coding standards and best practices.
  *
  * ---
  *
  * Summary table of modules
  * - The execution order is controlled via the hook's priority.
  *
  * Usage:
  * add_action( $hook, $function_to_add, $priority, $accepted_args );
  *
  * Example:
  * add_action( 'save_post', 'wpdocs_my_save_post', 10, 3 );
  * 
  * The smaller the number, the earlier the function is executed.
  * 
  * ┌──────────────────────────┬────────────┬───────────────────────────────────────────┐
  * │ Modules                  │ Priorities │ Roles                                     │
  * ├──────────────────────────┼────────────┼───────────────────────────────────────────┤
  * │ setup.php                │ 5          │ Initialisation                            │
  * │ security.php             │ 10         │ Security improvements                     │
  * │ custom-login.php         │ 45         │ Customizing the login                     │
  * │ custom-admin.php         │ 50         │ Admin customization                       │
  * │ custom-favicon.php       │ 15         │ Customizing the favicon                   │
  * │ hooks.php                │ 45         │ Custom hooks (actions/filters)            │
  * │ scripts.php              │ 40         │ Loading CSS/JS                            │
  * │ performance.php          │ 45         │ Performance improvements                  │
  * │ cleanup.php              │ 35         │ WordPress cleanup                         │
  * │ custom-post-types.php    │ 30         │ Declaration of Custom Post Types          │
  * │ taxonomies.php           │ 20         │ Declaration of taxonomies                 │
  * │ media-setup.php          │ 45         │ Added media types (svg, json)             │
  * │ image-size.php           │ 55         │ Adding image sizes                        │
  * │ shortcodes.php           │ 25         │ Declaration of shortcodes                 │
  * │ publications.php         │ 25         │ Adding features to articles               │
  * │ woocommerce.php          │ 25         │ Adding features to WooCommerce            │
  * │ gravity-forms.php        │ 45         │ Customizing the Gravity Forms plugin      │
  * │ greenshift.php           │ 35         │ Customizing the Greenshift plugin         │
  * │ helpers.php              │ 20         │ Utility functions                         │
  * │ ...                      │ ..         │ ...                                       │
  * │ ...                      │ ..         │ ...                                       │
  * │ ...                      │ ..         │ ...                                       │
  * └──────────────────────────┴────────────┴───────────────────────────────────────────┘
  *
  * Module Management:
  * - The administrator can enable/disable modules from the WPSnipHub menu.
  *
  * Best Practices:
  * - Always prefix functions with `wpsh_` to avoid conflicts.
  * - Do not execute code directly in `_docs.php`.
  * - Use `require_once` to include modules from `wp-sniphub.php`.
  *
  */
