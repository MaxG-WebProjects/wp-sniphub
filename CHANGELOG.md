# Changelog
All notable changes to **WPSnipHub** are documented in this file.  
This project follows WordPress.org coding standards and GitHub best practices.

## Credits
Thanks to all contributors who helped improve WPSnipHub.

---

## [1.3.0] – 2026-08-23
This release's WordPress guidelines-compliance refactor was carried out with the assistance of [Claude Code](https://claude.com/claude-code) and [GitHub Spec Kit](https://github.com/github/spec-kit).

### Added
- Proper internationalization: every user-facing string across the plugin (module titles/descriptions, CPT/taxonomy labels, admin notices, settings-backup UI, login-page customizations, etc.) is written in English and wrapped in `__()`/`_e()`/`esc_html__()`/`esc_html_e()`/`_x()`, matching official WordPress i18n guidance. Added `load_plugin_textdomain( 'wp-sniphub', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' )`, hooked on `init`, and a `Domain Path: /languages` plugin header. Added `languages/wp-sniphub.pot` (translation template) and `languages/wp-sniphub-fr_FR.mo`/`.po` (French translation, reproducing the plugin's original French wording) so the Dashboard renders in French for `fr_FR` sites and in English everywhere else.
- `CONTRIBUTING.md`: module-authoring guidelines, naming conventions, and compliant module template, extracted from `README.md`/`README.txt`.
- `composer.json` / `phpcs.xml.dist` and `package.json` / `.stylelintrc.json`: dev-only tooling to verify WordPress PHP and CSS coding-standard compliance going forward. `.gitignore` updated accordingly (`vendor/`, `node_modules/`, lockfiles, `.DS_Store`).
- `specs/001-wp-guidelines-compliance/compliance-exceptions.md`: documented, justified exceptions to the coding-standard/Stylelint checks, plus one Plugin Check warning (`load_plugin_textdomain()` discouraged) that only applies to plugins hosted on WordPress.org (this plugin is not, see `CONTRIBUTING.md`).
- New **settings backup** core utility (`inc/settings-io.php`): export the plugin's settings to a JSON file, and re-import a previously exported file, from a new section on the WPSnipHub settings screen. Always available — not gated behind a toggleable module, since it manages the plugin's own configuration rather than a site-facing feature.
- New `uninstall.php`: when the plugin is deleted from the Plugins screen, its own options (`wpsh_enabled_modules` and the image-size settings), its transient, the `admin_color` user-meta value it may have set, **and all content created through its custom post types and taxonomies** (portfolio items, testimonials, events, and their category/type terms) are permanently removed from the database.

### Changed
- **Behavior change**: deleting WPSnipHub now also permanently deletes all portfolio/testimonial/event content and its taxonomy terms, not just the plugin's own settings — once the plugin is gone, that content can no longer appear anywhere in the Dashboard anyway, so leaving it in the database would just be orphaned, inaccessible rows. `uninstall.php` temporarily re-registers the post types/taxonomies (reusing `wpsh_get_cpts_config()`/`wpsh_get_taxonomies_config()`, nothing to keep in sync manually) purely to safely delete every matching post (including drafts/auto-drafts) and term. The settings-screen notice and the README FAQ entry now warn about this instead of reassuring that content is preserved.
- Modules on the WPSnipHub settings screen are grouped into 5 categories (Foundations & Security, Content, Appearance & Interface, Assets & Performance, Third-Party Integrations) instead of a single flat list. Implemented with one native `add_settings_section()` per category — no JavaScript, no new markup. Third-party modules added via the `wpsh_modules` filter without a `category` key fall back to an "Other" section.
- Normalized comment/DocBlock structure across all 20 modules: one `/* === Title === */` section banner per function, a single `// via <URL>` line per external source, and English throughout DocBlocks. Fixed 3 copy-pasted banners left over from earlier edits that no longer matched their function, and one mixed-language banner title.
- Bumped `Tested up to` from 6.9 to 7.1 in `wp-sniphub.php`, `README.txt`, and `README.md`, reflecting this session's extensive live testing on a WordPress 7.1 site.
- Widened the module-title (`.form-table th`) column on the WPSnipHub settings screen from WordPress core's default 200px to 300px, for better readability of longer module titles. Scoped inside `@media screen and (min-width: 783px)` — matching core's own breakpoint for the form-table's stacked mobile layout — so it never overrides core's responsive behavior.
- Restored one "Objectives" bullet from the pre-1.3.0 `README-GitHub.md` that was dropped when this content moved to `CONTRIBUTING.md`: modules should be compatible with WordPress.org guidelines, even though WPSnipHub itself is not intended for the official directory.
- **Behavior change**: on a fresh install, every module — including the security-hardening module — is now disabled by default. Site owners must explicitly enable each module from the WPSnipHub settings screen. Existing installations keep their previously saved configuration unchanged.
- Rebuilt the WPSnipHub settings screen on the native WordPress Settings API (`register_setting()`/`add_settings_section()`/`add_settings_field()`/`do_settings_sections()`), replacing the custom card-grid layout with a standard `form-table`. Nonce and capability checks are now handled natively by `options.php` instead of a hand-rolled check.
- Every checkbox now sits inside a real `<label for>` (a proper accessible name) instead of a manual `aria-label`; tab order follows native DOM order.
- Reformatted `README.txt` and `README.md` to the standard WordPress readme structure (Description, Installation, FAQ, Changelog); moved the developer/module-authoring content to `CONTRIBUTING.md`.
- `wpsh_admin_footer_text()` now `return`s its filtered text instead of `echo`ing it, so the `admin_footer_text` filter chains correctly with other plugins (no visible change to the footer text itself).
- Brought all PHP and CSS files up to WordPress Coding Standards (WordPress-Extra ruleset) and the project's Stylelint configuration: consistent tab indentation, Yoda conditions, complete DocBlocks, i18n-wrapped strings, and native array/whitespace formatting.
- Consolidated 5 duplicated RSS-disabling closures in `cleanup.php` into a single `wpsh_disable_feed()` function.
- Simplified `_docs.php`, removing a duplicated plugin-structure tree that was already out of date (still listed `custom-favicon.php`) and bumping its version header to 1.3.0.

### Fixed
- Removed 3 stray `.DS_Store` files (root, `css/`, `img/`) that had been committed to the repository before `.gitignore` excluded them — flagged as `hidden_files` errors by the official Plugin Check tool.
- Sanitized `$_FILES['wpsh_import_file']['tmp_name']` (via `sanitize_text_field`/`wp_unslash`) before passing it to `file_get_contents()` in `wpsh_handle_import_settings()` — flagged by Plugin Check; no behavior change.
- **Loading translations too early caused a `_load_textdomain_just_in_time` notice on every request**: `wpsh_load_modules()` (hooked on `plugins_loaded`) called `wpsh_get_modules()` purely to read module file names, which as a side effect evaluated every module's `__()`-wrapped title/description before `load_plugin_textdomain()` (hooked on `init`) had run. Fixed by having `wpsh_load_modules()` read the already-sanitized `wpsh_enabled_modules` option directly, without touching `wpsh_get_modules()` at all.
- **Critical: enabling the WooCommerce module fataled every front-end page**: `wpsh_wc_remove_shop_breadcrumbs()` is hooked to `template_redirect` — a core WordPress action that fires on every front-end request regardless of which plugins are active — and called `is_shop()` unconditionally. With WooCommerce inactive, every page load threw an uncaught fatal error. Fixed by guarding the call with `function_exists( 'is_shop' )`.
- **Saving the module list silently did nothing**: the "Settings Backup" section's import control rendered a `<form>` nested inside the module-toggle `<form>`. HTML does not allow nested forms; the browser closed the outer form early, orphaning the "Save" button outside any form. Fixed by giving the backup section its own settings "page" (`wpsh-helper-io`), rendered after the module-toggle form is closed instead of inside it.
- Fixed inconsistent label/field spacing for the "Square Size" and "Full HD Size" fields on **Settings → Media**: wrapped them in a `<fieldset>`/`<legend class="screen-reader-text">`, matching core's own size-field markup so WordPress's `label { display: inline-block; width: 140px }` alignment applies.
- **`scripts.php` and `styles.php` were completely inert**: a missing DocBlock closing `*/` had accidentally commented out the entire `wpsh_enqueue_scripts()`/`wpsh_enqueue_styles()` functions (and their `add_action()` registration) since these modules were introduced.
- Fixed a duplicate `input[type="text"]:focus` selector and an unclosed CSS rule (stray extra `}`) in `css/custom-admin-colors/color-scheme.css`.
- Merged a duplicated `.wpsh-module-icon` CSS rule in `wpsh-admin.css` that silently overrode itself.
- Fixed a stale `custom-favicon.php` reference in the documentation (the actual module file is `favicon.php`) and removed a hook-priority table whose numbers no longer matched the code (e.g. `custom-post-types.php` and `taxonomies.php` priorities were swapped).

### Security
- Confirmed all user input is sanitized (`sanitize_text_field` + `wp_unslash`) and all dynamic output is escaped (`esc_html`/`esc_attr`/`esc_url`/`wp_kses_post`) across every module; no findings.

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
