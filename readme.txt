=== Hide Theme Upgrade Banners ===
Contributors: Jason Cox
Tags: admin, theme, banners, notices, upgrade banners
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Safely hides Ovation and Space Exploration upgrade banners in wp-admin and the logged-in admin bar.

== Description ==

Hide Theme Upgrade Banners adds narrowly targeted admin and front-end admin-bar CSS to hide Ovation / Space Exploration upgrade prompts without hiding broader WordPress admin containers.

Automatic updates are configured from:
https://github.com/jcjason12108-alt/Hide-Theme-Upgrade-Banners/

== Installation ==

1. Upload the `hide-theme-upgrade-banners` folder to `/wp-content/plugins/`.
2. Activate Hide Theme Upgrade Banners from the WordPress Plugins screen.

== Frequently Asked Questions ==

= Does this require GitHub Releases? =

No. Version 1.1.0 uses branch-only update checks directly from the `main` branch and does not require GitHub Releases.

= Can a private GitHub repository be used? =

Yes. Define `HIDE_THEME_UPGRADE_BANNERS_GITHUB_TOKEN` as a constant or environment variable. The generic `PLUGIN_UPDATE_GITHUB_TOKEN` constant or environment variable is also supported as a fallback.

== Changelog ==

= 1.1.0 =
* Added Plugin Update Checker 5.7 for automatic updates from GitHub.
* Configured branch-only update checks against the main branch.
* Added optional GitHub token support.
* Added complete plugin header metadata and `readme.txt`.
* Updated WordPress compatibility to 7.0.

= 1.0.3 =
* Initial release.
