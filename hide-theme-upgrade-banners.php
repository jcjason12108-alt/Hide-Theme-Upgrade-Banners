<?php
/**
 * Plugin Name: Hide Theme Upgrade Banners
 * Plugin URI: https://github.com/jcjason12108-alt/Hide-Theme-Upgrade-Banners/
 * Description: Safely hides Ovation / Space Exploration upgrade banners in wp-admin and the logged-in admin bar.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Tested up to: 7.0
 * Requires PHP: 7.4
 * Author: Jason Cox
 * Author URI: https://github.com/jcjason12108-alt
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: hide-theme-upgrade-banners
 * Update URI: https://github.com/jcjason12108-alt/Hide-Theme-Upgrade-Banners/
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!defined('HTU_VERSION')) {
    define('HTU_VERSION', '1.1.0');
}

require_once __DIR__ . '/plugin-update-checker/plugin-update-checker.php';

function htu_configure_update_checker() {
    $update_checker = \YahnisElsts\PluginUpdateChecker\v5\PucFactory::buildUpdateChecker(
        'https://github.com/jcjason12108-alt/Hide-Theme-Upgrade-Banners/',
        __FILE__,
        'hide-theme-upgrade-banners'
    );

    $update_checker->setBranch('main');

    add_filter(
        $update_checker->getUniqueName('vcs_update_detection_strategies'),
        static function (array $strategies): array {
            return isset($strategies['branch']) ? ['branch' => $strategies['branch']] : $strategies;
        }
    );

    $github_token = htu_get_github_update_token();

    if (!empty($github_token)) {
        $update_checker->setAuthentication($github_token);
    }
}

function htu_get_github_update_token() {
    if (defined('HIDE_THEME_UPGRADE_BANNERS_GITHUB_TOKEN') && HIDE_THEME_UPGRADE_BANNERS_GITHUB_TOKEN !== '') {
        return trim((string) HIDE_THEME_UPGRADE_BANNERS_GITHUB_TOKEN);
    }

    $plugin_token = getenv('HIDE_THEME_UPGRADE_BANNERS_GITHUB_TOKEN');
    if (is_string($plugin_token) && trim($plugin_token) !== '') {
        return trim($plugin_token);
    }

    if (defined('PLUGIN_UPDATE_GITHUB_TOKEN') && PLUGIN_UPDATE_GITHUB_TOKEN !== '') {
        return trim((string) PLUGIN_UPDATE_GITHUB_TOKEN);
    }

    $shared_token = getenv('PLUGIN_UPDATE_GITHUB_TOKEN');
    return is_string($shared_token) ? trim($shared_token) : '';
}

htu_configure_update_checker();

function htu_hide_theme_upgrade_banner_css() {
    ?>
    <style>
        /*
         * Hide top admin toolbar promo link only.
         * This targets the actual admin bar item without hiding parent page containers.
         */
        #wpadminbar a[href*="ovationthemes.com/products/space-wordpress-theme"],
        #wpadminbar a[href*="ovationthemes.com/products/wordpress-bundle"],
        #wpadminbar a[href*="ovationthemes.com/products/ovation-elements-pro"] {
            display: none !important;
        }

        /*
         * Hide dashboard/admin notice promo boxes.
         */
        .notice:has(a[href*="ovationthemes.com/products/wordpress-bundle"]),
        .notice:has(a[href*="ovationthemes.com/products/space-wordpress-theme"]),
        .notice:has(a[href*="ovationthemes.com/products/ovation-elements-pro"]),
        .updated:has(a[href*="ovationthemes.com/products/wordpress-bundle"]),
        .updated:has(a[href*="ovationthemes.com/products/space-wordpress-theme"]),
        .updated:has(a[href*="ovationthemes.com/products/ovation-elements-pro"]) {
            display: none !important;
        }

        /*
         * Hide Appearance / OT Elements upsell links in admin menu.
         */
        #adminmenu a[href*="space-exploration-pro"],
        #adminmenu a[href*="ovation-elements-pro"],
        #adminmenu a[href*="ovationthemes.com/products/ovation-elements-pro"] {
            display: none !important;
        }

        /*
         * Hide red notification bubbles on OT Elements menu area.
         */
        #adminmenu li:has(a[href*="page=ovation_elements"]) .update-plugins,
        #adminmenu li:has(a[href*="page=ovation_elements"]) .awaiting-mod,
        #adminmenu li:has(a[href*="page=select-template"]) .update-plugins,
        #adminmenu li:has(a[href*="page=select-template"]) .awaiting-mod,
        #adminmenu li:has(a[href*="post_type=ova_elems"]) .update-plugins,
        #adminmenu li:has(a[href*="post_type=ova_elems"]) .awaiting-mod {
            display: none !important;
        }

        /*
         * Hide only the logged-in top admin bar upgrade link on the public site.
         * Do NOT hide generic div containers.
         */
        body.admin-bar #wpadminbar a[href*="ovationthemes.com/products/space-wordpress-theme"],
        body.admin-bar #wpadminbar a[href*="ovationthemes.com/products/wordpress-bundle"],
        body.admin-bar #wpadminbar a[href*="ovationthemes.com/products/ovation-elements-pro"] {
            display: none !important;
        }
    </style>
    <?php
}

add_action('admin_head', 'htu_hide_theme_upgrade_banner_css');

add_action('wp_head', function () {
    if (is_user_logged_in()) {
        htu_hide_theme_upgrade_banner_css();
    }
});
