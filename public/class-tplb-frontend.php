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
        wp_enqueue_style('tplb-frontend-styles', TPLB_PLUGIN_URL . 'build/css/frontendStyles.css', [], '1.0.0');
        wp_enqueue_script('tplb-frontend-scripts', TPLB_PLUGIN_URL . 'public/tplb-frontend-scripts.js', [], '1.0.0', true);
    }

    /**
     * Displays the product badge based on the display option setting.
     *
     * @since 1.0.0
     */
    public function display_product_badge() {
        global $product;

        $badge_display_option = get_option('tplb_badge_display_option', 'all');
        $default_badge_text = get_option('tplb_default_badge_text', __('Default Badge', 'tplb'));
        $default_colors = get_option('tplb_default_badge_colors', ['background' => '#000000', 'text' => '#FFFFFF']);
        $custom_badge_text = get_post_meta($product->get_id(), '_tplb_badge_text', true);
        $category_badge_texts = get_option('tplb_category_badge_texts', []);
        $category_badge_colors = get_option('tplb_category_badge_colors', []);

        $badge_text = '';
        $bg_color = $default_colors['background'];
        $text_color = $default_colors['text'];

        if (!empty($custom_badge_text)) {
            $badge_text = $custom_badge_text;
        } elseif ($badge_display_option === 'all') {
            $badge_text = $default_badge_text;
        } elseif ($badge_display_option === 'categories') {
            $categories = wp_get_post_terms($product->get_id(), 'product_cat', ['fields' => 'ids']);
            foreach ($categories as $category_id) {
                if (isset($category_badge_texts[$category_id]) && !empty($category_badge_texts[$category_id])) {
                    $badge_text = $category_badge_texts[$category_id];
                    $bg_color = $category_badge_colors[$category_id]['background'] ?? $bg_color;
                    $text_color = $category_badge_colors[$category_id]['text'] ?? $text_color;
                    break;
                }
            }
        }

        if (!empty($badge_text)) {
            echo '<span class="tplb-badge" style="background-color:' . esc_attr($bg_color) . '; color:' . esc_attr($text_color) . ';">' . esc_html($badge_text) . '</span>';
        }
    }
}
