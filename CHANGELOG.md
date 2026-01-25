# Changelog
All notable changes to **WPSnipHub** are documented in this file.  
This project follows WordPress.org coding standards and GitHub best practices.

## Credits
Thanks to all contributors who helped improve WPSnipHub.

---

## [1.2.5] – 2026-01-25
### Added
- Styles module to manage CSS independently of the scripts.
- Dashicon for each module title.
- Instructions for external HTTP requests hardening - See it in security module (thanks to @ozgursar for his related LinkedIn's post).

### Changed
- Split the scripts module to begin the CSS styles.
- wp-sniphub.php and wpsh-admin.css to include and display Dashicons for each module title.
- All favicons files with **WPSnipHub** logo instead of my own site logo.

### Fixed
- Fixed an issue where the browser tab notification emoji was displayed incorrectly or as plain text in some environments (thanks to @valentin-grenier).
  - Improved reliability of the browser tab title animation when the page loses focus.

### Technical details
- Replaced a raw UTF-8 emoji in inline JavaScript with explicit Unicode escape sequences.
  - This prevents character encoding issues caused by PHP → JavaScript injection and ensures consistent rendering across browsers, servers, and build environments.

---

## [1.2.4] – 2026-01-24
### Added
- Introduced the `WPSH_VERSION` constant to centralize plugin version management.
- Added `wpsh_get_modules()` as the single source of truth for module definitions.
- Enabled extensibility of modules via the `wpsh_modules` filter.
- Added comprehensive PHPDoc blocks to improve readability and maintainability.

### Changed
- Refactored module architecture to remove reliance on global variables.
- Split the former “Scripts and styles” module into two distinct modules:
  - Scripts
  - Styles
- Improved admin menu icon loading with safer SVG handling.
- Centralized and standardized admin CSS versioning.
- Improved validation, sanitization, and permission checks across the admin interface.

### Fixed
- Resolved multiple Plugin Check warnings related to:
  - global namespace pollution
  - missing capability checks
  - insufficient data sanitization
  - i18n compliance
- Prevented potential file loading errors in admin assets.

### Security
- Hardened admin form handling using nonces and strict capability checks.
- Ensured all user inputs are properly sanitized before processing.

---

## [1.2.0] – 2026-01-14
### Added
- Official **module creation guidelines** (README.md):
  - Clear philosophy: clean, isolated, maintainable modules
  - Mandatory `wpsh_` prefix rules for all global symbols
  - WordPress.org–compliant escaping, i18n, and security practices
- Guidelines for **WPSnipHub** module creation:
  - Plugin Check compliance checklist
  - Naming conventions and common pitfalls
  - Validation steps before submitting a module
- Standardized **official module template** for WPSnipHub
- Plugin Check checklist added for contributors and maintainers

---

### Changed
- **Global refactor of all modules** to comply with Plugin Check and WordPress.org rules:
  - All global functions are now consistently prefixed with `wpsh_`
  - Removed third-party or generic prefixes (`theme_`, `my_`, `wpds_`, `woo_`, etc.)
- Improved **code readability and maintainability** across all modules:
  - Clear function naming aligned with module responsibilities
  - Consistent hook registration patterns
- Improved **internationalization (i18n)**:
  - All user-facing strings now use the `wp-sniphub` text domain
- Improved **date and time handling**:
  - Replaced deprecated or discouraged PHP functions with `wp_date()`

---

### Fixed
- Plugin Check errors across all modules, including:
  - `WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound`
  - `WordPress.Security.EscapeOutput.OutputNotEscaped`
- Output escaping issues:
  - All URLs now escaped with `esc_url()`
  - All HTML attributes escaped with `esc_attr()`
  - All visible text escaped with `esc_html()` / `esc_html__()`
- Admin notices and frontend outputs now fully WordPress.org compliant
- Shortcodes, helpers, WooCommerce, Gravity Forms, media, login, cleanup, and publication modules now pass Plugin Check without critical errors

---

### Security
- Hardened all modules against unsafe output:
  - No raw `echo` of dynamic data without proper escaping
- Restricted sensitive features (uploads, SVG, JSON, etc.) to administrator capabilities
- Ensured safe admin-only execution where required

---

### Developer Experience
- Modules are now:
  - Fully isolated and independently disable-able
  - Easier to audit, extend, and maintain
- Clear separation between:
  - Initialization logic
  - Business logic
  - Hooks and filters
- Reduced risk of conflicts with themes, plugins, or WordPress core

---

### Compatibility
- Fully compatible with:
  - WordPress.org Plugin Review guidelines
  - Plugin Check (no blocking issues)
  - Modern WordPress versions (including block editor environments)
- Safe integration with third-party plugins (WooCommerce, Gravity Forms, Greenshift, etc.)

---

## Notes
This release is primarily a **quality, compliance, and maintainability milestone**.  
No breaking changes for end users, but **significant internal improvements** to ensure long-term stability and WordPress.org compatibility. Even though **WPSnipHub** is not intended to be published on the official plugin repository


## [1.1.0] – 2026-01-04
### Added
- Added Changelog file
- Added indicator for module activation or deactivation

### Changed
- Toggle buttons replace checkboxes

### Fixed
- Fixed an issue where the switch button label always displayed "Inactive" regardless of its actual state.

## [1.0.0] – 2025-12-28
- Initial release
