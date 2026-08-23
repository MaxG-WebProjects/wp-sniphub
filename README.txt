=== WPSnipHub ===
Contributors: maxcgparis
Tags: hub, snippets, dashboard, security, developer tools
Requires at least: 6.7
Tested up to: 7.1
Requires PHP: 8.0
Stable tag: 1.3.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dev-oriented central and modular hub for code snippets and utility functions of WordPress sites.

== Description ==

**WPSnipHub** is a modular WordPress plugin designed to centralize reusable snippets and utility functions in a clean, maintainable, and scalable way.

Each feature is packaged as an independent module. Every module is disabled by default — nothing runs until you explicitly enable it from the WPSnipHub settings screen.

Main features include:

* WordPress admin dashboard customization (logo, colors, footer, avatars)
* Custom login page styling
* Front-end and back-end scripts and styles management
* Custom post types and taxonomies registration
* Reusable shortcodes
* Security hardening and WordPress cleanup
* Helper utility functions shared across modules

The plugin follows the official WordPress Coding Standards.

Looking to contribute a new module? See `CONTRIBUTING.md` in the plugin's source repository for the module authoring guidelines and template.

== Installation ==

1. Upload the `wp-sniphub` directory to `/wp-content/plugins/`.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Open **WPSnipHub** from the admin menu.
4. Enable the modules you need — every module is disabled by default.
5. Save your configuration.

== Frequently Asked Questions ==

= Are all modules enabled after activation? =

No. Every module, including the security-hardening module, is disabled by default. You must explicitly enable each module you want from the WPSnipHub settings screen.

= Will disabling a module delete its settings? =

No. Disabling a module only stops it from running; its own stored data is kept and reapplied if you re-enable it later.

= Can I add my own modules? =

Yes. Modules are plain PHP files under `inc/`, and the module list is filterable via the `wpsh_modules` filter. See `CONTRIBUTING.md` for the module template and naming conventions.

= What happens to my data if I delete the plugin? =

Deleting WPSnipHub permanently removes its settings (which modules were enabled, the custom image-size options), a temporary flag it may have stored, and all content created through its custom post types and taxonomies (portfolio items, testimonials, events, and their categories). This cannot be undone — export a backup first if you want to keep this content.

= Can I back up my settings before updating or reinstalling? =

Yes. The "Settings Backup" section on the WPSnipHub settings screen lets you export your current settings to a JSON file and re-import them later.

== Changelog ==

= 1.3.0 =
* Every module, including the security-hardening module, is now disabled by default on a fresh install; enable the ones you need from the settings screen. Existing installations keep their saved configuration.
* Rebuilt the settings screen on the native WordPress Settings API.
* Fixed the Scripts and Styles modules, which were not actually enqueuing anything due to a documentation-comment bug.
* Brought the whole codebase up to WordPress Coding Standards.

= 1.2.5 =
* Added a dedicated Styles module, split from Scripts.
* Added a Dashicon to every module title.
* Documented external HTTP request hardening in the security module.
* Fixed the browser-tab-notification emoji rendering in some environments.

= 1.2.4 =
* Introduced `WPSH_VERSION` and `wpsh_get_modules()` as the single source of truth for modules.
* Made the module list extensible via the `wpsh_modules` filter.
* Refactored the module architecture to remove global-variable reliance.
* Hardened admin form handling (nonces, capability checks, sanitization).

= 1.2.0 =
* Established official module-authoring guidelines and a standard module template.
* Refactored all modules to consistently use the `wpsh_` prefix.
* Improved i18n (all strings use the `wp-sniphub` text domain) and output escaping across every module.

= 1.1.0 =
* Added a changelog file.
* Replaced settings checkboxes with toggle switches, with a module activation indicator.
* Fixed the toggle label always showing "Inactive" regardless of actual state.

= 1.0.0 =
* Initial release.

See `CHANGELOG.md` in the plugin's source repository for the complete history of changes.
