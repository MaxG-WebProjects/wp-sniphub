# Contributing to WPSnipHub

This guide is for developers who want to add or modify a WPSnipHub module. It is not
part of the plugin's end-user documentation (see `README.md` / `README.txt` for that).

The 1.3.0 WordPress guidelines-compliance refactor was carried out with the assistance
of [Claude Code](https://claude.com/claude-code) and [GitHub Spec Kit](https://github.com/github/spec-kit).

## Philosophy

A module is **clean, isolated, and maintainable code** that conforms to WordPress.org
coding standards.

### Objectives

Each module must:

- adhere to security and quality standards
- never conflict with other plugins or themes
- pass Plugin Check without critical errors
- facilitate easy adoption
- evolve without technical debt
- be independently enable-able/disable-able via WPSnipHub
- be compatible with WordPress.org guidelines, even though WPSnipHub is not intended to be published on the official plugin directory

---

## Plugin structure

```
wp-sniphub/
│
├── _docs.php              # Internal documentation (not loaded)
├── CHANGELOG.md
├── CONTRIBUTING.md
├── README.md
├── README.txt
├── LICENSE
│
├── wp-sniphub.php         # Bootstrap: module list, module loader, settings screen
├── uninstall.php          # DB cleanup on plugin deletion (options/transient/user meta + all CPT/taxonomy content)
│
├── inc/
│   ├── setup.php
│   ├── security.php
│   ├── custom-login.php
│   ├── custom-admin.php
│   ├── favicon.php
│   ├── hooks.php
│   ├── scripts.php
│   ├── styles.php
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
│   ├── helpers.php
│   └── settings-io.php    # Core utility, always loaded — not a toggleable module (see below)
│
├── css/
│   ├── admin/wpsh-admin.css
│   ├── custom-login/login-styles.css
│   └── custom-admin-colors/color-scheme.css
│
└── img/
    ├── admin/icon.svg
    ├── admin/wp-sniphub-logo.svg
    ├── gravatar-icon-290x290px.png
    └── favicons/...
```

Every module is disabled by default; a site owner must explicitly enable it from the
WPSnipHub settings screen. Each module registers its own hooks at whatever priority it
needs — there is no single, plugin-wide "module priority" ordering; check the module's
own file for the exact hooks and priorities it uses.

`inc/settings-io.php` is not a module: it is a **core utility** (settings backup/export/
import) loaded unconditionally by `wpsh_load_core_utilities()` in `wp-sniphub.php`, not
via the toggleable module list. Use this pattern only for functionality that manages the
plugin itself (not a site-facing feature) and that should always be available regardless
of which feature modules are enabled.

---

## 1. Minimum module structure

Each module must be a single PHP file located in:

```
/inc/module-name.php
```

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

## 2. Prefix everything that is global

`wpsh_` — used consistently for:

| Type            | Correct example              |
|------------------|------------------------------|
| Function         | `wpsh_register_post_types()` |
| Hook callback     | `wpsh_enqueue_assets()`      |
| Global variable   | `$wpsh_options`              |
| Constant          | `WPSH_OPTION_NAME`           |
| Class             | `WPSH_Module_Example`        |

Plugin Check error cause:

```php
function enqueue_assets() {}
function my_custom_filter() {}
```

Solution:

```php
function wpsh_enqueue_assets() {}
function wpsh_custom_filter() {}
```

---

## 3. Hooks & filters

Plugin Check error cause:

```php
add_action( 'init', 'register_cpt' ); // Example for a CPT.
```

Solution:

```php
add_action( 'init', 'wpsh_register_cpt' );

function wpsh_register_cpt() {
    // ...
}
```

---

## 4. Anonymous functions (closures)

Anonymous functions are only permitted for very simple filters or a direct return
(`__return_true`, etc.).

To avoid:

```php
add_action( 'init', function() {
    // complex logic
} );
```

Recommended:

```php
add_action( 'init', 'wpsh_init_module' );

function wpsh_init_module() {
    // clear and testable logic
}
```

---

## 5. Internationalization (i18n)

Always use the `wp-sniphub` text domain.

Incorrect:

```php
__( 'My string' );
```

Solution:

```php
__( 'My string', 'wp-sniphub' );
esc_html__( 'My string', 'wp-sniphub' );
```

---

## 6. Output safety (required escaping)

All HTML output must be escaped:

| Context          | Function       |
|-------------------|----------------|
| Text              | `esc_html()`   |
| HTML attribute     | `esc_attr()`   |
| URL                | `esc_url()`    |
| Translated text    | `esc_html__()` |

Incorrect:

```php
_e( 'Maximum width', 'wp-sniphub' );
```

Solution:

```php
esc_html_e( 'Maximum width', 'wp-sniphub' );
```

---

## 7. Dates and times

Incorrect:

```php
date( 'Y' );
```

Solution:

```php
wp_date( 'Y' );
```

---

## 8. Best practices for third-party plugin integrations

- Always use the `wpsh_` prefix, even for hooks belonging to a third-party plugin.
- Never use a third-party plugin's own text domain for your own strings.

Incorrect:

```php
esc_html__( 'Error', 'gravityforms' ); // Example for Gravity Forms.
function who_change_error_message() {}
```

Solution:

```php
esc_html__( 'Error', 'wp-sniphub' );
function wpsh_change_gform_error_message() {}
```

---

## 9. Compliant module template

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
function wpsh_module_name_init() {
    // Module initialization.
}
add_action( 'init', 'wpsh_module_name_init' );

/* ==========================================================
   Main functions
   ========================================================== */

/**
 * Example of a utility function.
 *
 * @param string $value Value to process.
 * @return string
 */
function wpsh_module_name_example( $value ) {
    return esc_html( $value );
}

/* ==========================================================
   Hooks / Filters
   ========================================================== */

/**
 * Example of a WordPress filter.
 *
 * @param string $content Content.
 * @return string
 */
function wpsh_module_name_filter_example( $content ) {
    return $content;
}
add_filter( 'the_content', 'wpsh_module_name_filter_example' );
```
