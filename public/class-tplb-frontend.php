<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class TPLB_Frontend {
    public function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        // Add frontend styles and scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        // Add badge display on WooCommerce product
        add_action('woocommerce_before_shop_loop_item_title', [$this, 'display_product_badge']);
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style('tplb-frontend-styles', TPLB_PLUGIN_URL . 'public/tplb-frontend-styles.css', [], '1.0.0');
        wp_enqueue_script('tplb-frontend-scripts', TPLB_PLUGIN_URL . 'public/tplb-frontend-scripts.js', [], '1.0.0', true);
    }

    public function display_product_badge() {
        global $product;
        $badge_text = get_post_meta($product->get_id(), '_tplb_badge_text', true);

        if ($badge_text) {
            echo '<span class="tplb-badge">' . esc_html($badge_text) . '</span>';
        }
    }
}
