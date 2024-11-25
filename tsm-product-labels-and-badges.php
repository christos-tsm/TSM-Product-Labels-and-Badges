<?php
/*
Plugin Name: TSM Product Labels and Badges
Description: Add custom labels and badges to WooCommerce products.
Version: 1.0.0
Author: Christos TSM
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin path and URL constants
define('TPLB_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TPLB_PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Checks if WooCommerce is active. If not, it adds an admin notice
 * and safely deactivates the plugin.
 */
function tplb_check_woocommerce_active() {
    // Check if WooCommerce is active
    if (!class_exists('WooCommerce')) {
        add_action('admin_notices', 'tplb_woocommerce_inactive_notice');
        add_action('admin_init', 'tplb_deactivate_plugin'); // Deactivate the plugin safely
    }
}

/**
 * Outputs an admin notice if WooCommerce is not active.
 *
 * @since 1.0.0
 */
function tplb_woocommerce_inactive_notice() {
?>
    <div class="notice notice-error">
        <p>
            <?php esc_html_e('TSM Product Labels and Badges requires WooCommerce to be activated. Please activate WooCommerce to use this plugin.', 'tplb'); ?>
        </p>
    </div>
<?php
}

/**
 * Deactivates the TSM Product Labels and Badges plugin.
 *
 * @since 1.0.0
 */
function tplb_deactivate_plugin() {
    deactivate_plugins(plugin_basename(__FILE__));
}

add_action('plugins_loaded', 'tplb_initialize_plugin', 10);

/**
 * Initializes the plugin by checking if WooCommerce is active, and if so, 
 * bootstrapping the plugin by loading the initialization class and 
 * instantiating it.
 *
 * @since 1.0.0
 */
function tplb_initialize_plugin() {
    tplb_check_woocommerce_active();

    // If WooCommerce is active, proceed with plugin initialization
    if (class_exists('WooCommerce')) {
        require_once plugin_dir_path(__FILE__) . 'includes/class-tplb-init.php';

        function tplb_init() {
            return TPLB_Init::instance();
        }

        tplb_init();
    }
}
