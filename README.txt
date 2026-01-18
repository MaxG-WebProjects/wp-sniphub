=== WPSnipHub ===
Contributors: @maxcgparis
Tags: hub, code snippets, scripts and styles management, dashboard customization, woocommerce.
Author: @maxcgparis
Author URI: https://maxgremez.com/
Plugin URI: https://github.com/MaxG-WebProjects/wp-sniphub
Version: 1.2.0
Stable tag: 1.2.0
Requires at least: 6.7
Tested up to: 6.9
Requires PHP: 8.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A dev-oriented central and modular hub for code snippets and utility functions of WordPress sites

=== Documentation ===

== Description ==

**WPSnipHub** is a modular WordPress plugin designed to centralize reusable snippets and utility functions in a clean, maintainable, and scalable way.

Each feature is packaged as an independent module that can be enabled or disabled from a dedicated administration screen.

Main features include:

- WordPress admin dashboard customization (logo, colors, footer, avatars)
- Custom login page styling
- Front-end and back-end scripts and styles management
- Custom post types and taxonomies registration
- Reusable shortcodes
- Security hardening and WordPress cleanup
- Helper utility functions shared across modules

The plugin follows WordPress coding standards and best practices.

> [!TIP]
>
> **WPSnipHub** is a modular hub for managing custom WordPress snippets.
> - Each feature lives in its own module and can be enabled or disabled independently from the Dashboard.
> - Developers or advanced users may also customize or comment out code directly inside a module if required.
> - This allows you to keep your site clean, lightweight, and fully tailored to your needs.
> - You can also create your own modules by following the [Module Creation Guidelines](#guidelines-for-wpsniphub-module-creation).

---

== Installation ==

1. Upload the `wp-sniphub-main` directory to `/wp-content/plugins/`
2. Activate the plugin through the WordPress admin panel
3. Open **WPSnipHub** from the admin menu
4. Enable or disable modules as needed
5. Save your configuration

---

== Changelog ==

See the full changelog in the dedicated file: [CHANGELOG.md](<a href="https://github.com/MaxG-WebProjects/wp-sniphub/blob/main/CHANGELOG.md" alt="link to file CHANGELOG.md">CHANGELOG.md</a>) for the complete history of changes.

---

== Objectives ==

The goal is to ensure:
- A centralized interface for functions
- Simple activation/deactivation of modules
- Improved code hierarchy and readability
- Easy addition of extra code
- Simplified maintenance
- Compliance with WordPress best practices

---

== Plugin structure ==

wp-sniphub/
│
├── _docs.php # Internal documentation (not loaded)
├── CHANGELOG.md # Internal documentation (not loaded)
├── README.md # Internal documentation (not loaded)
├── README.txt # Internal documentation (not loaded)
├── LICENSE # Internal documentation (not loaded)
│ 
├── wp-sniphub.php
│
├── inc/
│   ├── setup.php
│   ├── security.php
│   ├── custom-login.php
│   ├── custom-admin.php
│   ├── custom-favicon.php
│   ├── hooks.php
│   ├── scripts.php
│   ├── performance.php
│   ├── cleanup.php
│   ├── custom-post-types.php
│   ├── taxonomies.php
│   ├── media-setup.php
│   ├── image-size.php
│   ├── shortcodes.php
│   ├── publications.php
│   ├── woocommerce.php
│   ├── gravity-forms.php
│   ├── greenshift.php
│   └── helpers.php
│   
├── css/
│   ├── admin/
│   │   └── wpsh-admin.css
│   │   
│   ├── custom-login/
│   │   └── login-styles.css
│   │   
│   └── custom-admin-colors/
│       └── color-scheme.css
│   
└── img/
    ├── icon.svg
    ├── gravatar-icon-290x290px.png
    └── favicons/
        ├── favicon.ico
        ├── favicon.svg
        ├── favicon-16x16.png
        ├── favicon-32x32.png
        ├── favicon-96x96.png
        ├── apple-touch-icon.png
        ├── web-app-manifest-192x192.png
        ├── web-app-manifest-512x512.png
        ├── safari-pinned-tab.svg
        └── site.webmanifest
 
---

== Order of execution (priorities) ==

┌──────────────────────────┬────────────┬───────────────────────────────────────────┐
│ Modules                  │ Priorities │ Roles                                      │
├──────────────────────────┼────────────┼───────────────────────────────────────────┤
│ setup.php                │ 5          │ Initialisation                            │
│ security.php             │ 10         │ Security improvements                     │
│ custom-login.php         │ 45         │ Customizing the login                     │
│ custom-admin.php         │ 50         │ Admin customization                       │
│ custom-favicon.php       │ 15         │ Customizing the favicon                   │
│ hooks.php                │ 45         │ Custom hooks (actions/filters)            │
│ scripts.php              │ 40         │ Loading CSS/JS                            │
│ performance.php          │ 45         │ Performance improvements                  │
│ cleanup.php              │ 35         │ WordPress cleanup                         │
│ custom-post-types.php    │ 30         │ Declaration of Custom Post Types          │
│ taxonomies.php           │ 20         │ Declaration of taxonomies                 │
│ media-setup.php          │ 45         │ Added media types (svg, json)             │
│ image-size.php           │ 55         │ Adding image sizes                        │
│ shortcodes.php           │ 25         │ Declaration of shortcodes                 │
│ publications.php         │ 25         │ Adding features to articles               │
│ woocommerce.php          │ 25         │ Adding features to WooCommerce            │
│ gravity-forms.php        │ 45         │ Customizing the Gravity Forms plugin      │
│ greenshift.php           │ 35         │ Customizing the Greenshift plugin         │
│ helpers.php              │ 20         │ Utility functions                         │
│ ...                      │ ..         │ ...                                       │
│ ...                      │ ..         │ ...                                       │  
│ ...                      │ ..         │ ...                                       │
└──────────────────────────┴────────────┴───────────────────────────────────────────┘

## Guidelines for WPSnipHub module creation

### Philosophy
A module is **clean, isolated, and maintainable code** that conforms to WordPress.org standards.


### 1. Objective of these guidelines
To ensure that each module:

- adheres to security and quality standards
- never conflicts with other plugins or themes
- passes Plugin Check without critical errors
- facilitates easy adoption
- evolves without technical debt
- can be disabled via **WPSnipHub**
- is compatible with WordPress.org. Even though **WPSnipHub** is not intended to be published on the official plugin repository

---

### 2. Minimum Module Structure

> [!NOTE]
> Each module must be a single PHP file located in:
> /inc/module.php

Recommended header:
```php
<?php
/**
 * Module name
 * Short module description
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
```

---

### 3. Prefix everything that is global

> [!IMPORTANT]
> wpsh_

This prefix must be used consistently for:
```
┌─────────────────────┬─────────────────────────────┐
│ Type                │ Correct example             │
├─────────────────────┼─────────────────────────────┤
│ Fonction            │ wpsh_register_post_types()  │
│ Hook callback       │ wpsh_enqueue_assets()       │
│ Global variable     │ $wpsh_options               │
│ Constant            │ WPSH_OPTION_NAME            │
│ Class               │ WPSH_Module_Example         │
└─────────────────────┴─────────────────────────────┘
```
Plugin Check error cause:
```php
<?php
function enqueue_assets() {}
function my_custom_filter() {}
```

Solution :
```php
<?php
function wpsh_enqueue_assets() {}
function wpsh_custom_filter() {}
```

---

### 4. Hooks & filters
Plugin Check error cause:
```php
<?php
add_action( 'init', 'register_cpt' ); //Exemple pour CPT
```

Solution :
```php
<?php
add_action( 'init', 'wpsh_register_cpt' );

function wpsh_register_cpt() {
    // ...
}
```

---

### 5. Use of anonymous functions (closures)

> [!NOTE]
> Anonymous functions are only permitted for:
> - very simple filters
> - direct return (__return_true, etc.)

To avoid:
```php
<?php
add_action( 'init', function() {
    // complex logic
});
```

Recommended:
```php
<?php
add_action( 'init', 'wpsh_init_module' );

function wpsh_init_module() {
    // clear and testable logic
}
```

---

### 6. Internationalization (i18n)

> [!IMPORTANT]
> Always provide the text domain: wp-sniphub.

Incorrect:
```php
<?php
__( 'My string' );
```

Solution:
```php
<?php
__( 'My string', 'wp-sniphub' );
esc_html__( 'My string', 'wp-sniphub' );
```

---

### 7. Output safety (required escaping)
General rule: All HTML output must be escaped.
```
┌─────────────────────┬────────────────┐
│ Context             │ Function       │
├─────────────────────┼────────────────┤
│ Text                │ esc_html()     │
│ HTML Attribut       │ esc_attr()     │
│ URL                 │ esc_url()      │
│ Translated text     │ esc_html__()   │
└─────────────────────┴────────────────┘
```
Incorrect:
```php
<?php
_e( 'Largeur maximale', 'wp-sniphub' );
```

Solution:
```php
<?php
esc_html_e( 'Largeur maximale', 'wp-sniphub' );
```

---

### 8. Dates and times

Incorrect:
```php
<?php
date( 'Y' );
```

Solution:
```php
<?php
wp_date( 'Y' );
```

---

### 9. Best practices for third-party plugins

> [!IMPORTANT]
> - Always use the WPSH prefix, even in third-party hooks.
> - Never use the third-party plugin's text domain.

Incorrect:
```php
<?php
esc_html__( 'Error', 'gravityforms' ); //Exemple pour Gravity Forms
function who_change_error_message() {}
```

Solution:
```php
<?php
esc_html__( 'Error', 'wp-sniphub' );
function wpsh_change_gform_error_message() {}
```
---

### 10. Template module compliant
```php
<?php
/**
 * Module name
 *
 * Short description of the module.
 *
 * @package WPSnipHub
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/* ==========================================================
   Module Initialization
   ========================================================== */

/**
 * Initialize the module.
 *
 * @return void
 */
function wpsh_nom_module_init() {
    // Module Initialization
}
add_action( 'init', 'wpsh_nom_module_init' );

/* ==========================================================
   Main functions
   ========================================================== */

/**
 * Example of a utility function.
 *
 * @param string $value Valeur à traiter.
 * @return string
 */
function wpsh_nom_module_example( $value ) {
    return esc_html( $value );
}

/* ==========================================================
   Hooks / Filters
   ========================================================== */

/**
 * Example of a WordPress filter.
 *
 * @param string $content Contenu.
 * @return string
 */
function wpsh_nom_module_filter_example( $content ) {
    return $content;
}
add_filter( 'the_content', 'wpsh_nom_module_filter_example' );
