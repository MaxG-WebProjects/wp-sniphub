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
  * Stable tag: 1.3.0
  * License: GPLv2 or later
  * License URI: http://www.gnu.org/licenses/gpl-2.0.html
  *
  * This file is used solely for plugin documentation.
  * It is not loaded by WordPress, but can be opened for reference.
  *
  * See README.txt / README.md for the plugin description, installation, and changelog.
  * See CONTRIBUTING.md for the plugin/module structure, naming conventions, and the
  * compliant module template — kept there instead of duplicated here so it can't drift
  * out of sync with the actual codebase.
  *
  * Module Management:
  * - The administrator enables/disables modules from the WPSnipHub settings screen.
  * - Every module is disabled by default; each module registers its own hooks at
  *   whatever priority it needs (there is no single, plugin-wide module ordering).
  *
  * Best Practices:
  * - Always prefix functions with `wpsh_` to avoid conflicts.
  * - Do not execute code directly in `_docs.php`.
  * - Use `require_once` to include modules from `wp-sniphub.php`.
  */
