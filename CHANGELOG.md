# Changelog
All notable changes to **WPSnipHub** are documented in this file.  
This project follows WordPress.org coding standards and GitHub best practices.

---

## [Unreleased] – 2026-01-17
### Changed
- The extension's visual appearance has been changed on the GitHub page. The logo has been replaced with a banner.

---

## [Unreleased] – 2026-01-16
### Fixed
- Fixed browser tab notification emoji encoding issue. Fixes an encoding issue where the emoji used in the browser tab notification
was rendered as plain text instead of an icon.

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
