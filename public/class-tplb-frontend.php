<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class TPLB_Frontend {
    public function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_frontend_assets']);
        add_action('woocommerce_before_shop_loop_item_title', [$this, 'display_product_badge']);
    }

    public function enqueue_frontend_assets() {
        wp_enqueue_style('tplb-frontend-styles', TPLB_PLUGIN_URL . 'public/tplb-frontend-styles.css', [], '1.0.0');
        wp_enqueue_script('tplb-frontend-scripts', TPLB_PLUGIN_URL . 'public/tplb-frontend-scripts.js', [], '1.0.0', true);
    }

    /**
     * Displays the product badge based on the display option setting.
     *
     * @since 1.0.0
     */
    public function display_product_badge() {
        global $product;

        // Fetch settings and meta
        $badge_display_option = get_option('tplb_badge_display_option', 'all');
        $custom_badge_text = get_post_meta($product->get_id(), '_tplb_badge_text', true);
        $category_badge_texts = get_option('tplb_category_badge_texts', []);

        $badge_text = '';

        // Check if product meta overrides all badges
        if (!empty($custom_badge_text)) {
            $badge_text = $custom_badge_text;
        } elseif ($badge_display_option === 'all') {
            // Default badge text for all products
            $badge_text = __('Default Badge', 'tplb');
        } elseif ($badge_display_option === 'categories') {
            // Check categories for a badge
            $categories = wp_get_post_terms($product->get_id(), 'product_cat', ['fields' => 'ids']);
            foreach ($categories as $category_id) {
                if (isset($category_badge_texts[$category_id]) && !empty($category_badge_texts[$category_id])) {
                    $badge_text = $category_badge_texts[$category_id];
                    break; // Use the first matching category
                }
            }
        }

        // Output the badge if text is set
        if (!empty($badge_text)) {
            echo '<span class="tplb-badge bg-blue-600 text-white px-2 py-1 text-sm rounded">' . esc_html($badge_text) . '</span>';
        }
    }
}
