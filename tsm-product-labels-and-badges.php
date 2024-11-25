<?php
/*
Plugin Name: TSM Product Labels and Badges
Description: Add custom labels and badges to WooCommerce products.
Version: 1.0.0
Author: Your Name
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Include the main plugin class
require_once plugin_dir_path(__FILE__) . 'includes/class-tplb-init.php';

// Initialize the plugin
function tplb_init() {
    return TPLB_Init::instance();
}
tplb_init();
