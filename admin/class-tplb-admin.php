<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class TPLB_Admin {
    public function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        add_action('admin_menu', [$this, 'add_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_init', [$this, 'register_settings']);
        add_action('woocommerce_product_options_general_product_data', [$this, 'add_badge_text_meta_field']);
        add_action('woocommerce_process_product_meta', [$this, 'save_badge_text_meta_field']);
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Product Labels & Badges', 'tplb'),
            __('Labels & Badges', 'tplb'),
            'manage_options',
            'tplb',
            [$this, 'render_admin_page'],
            'dashicons-tag',
            25
        );
    }

    public function render_admin_page() {
        require_once TPLB_PLUGIN_PATH . 'admin/admin-page.tpl.php';
    }

    /**
     * Enqueues the admin styles and scripts for the plugin's admin page.
     *
     * @param string $hook The current admin page hook suffix.
     */
    public function enqueue_admin_assets($hook) {
        // Enqueue assets only for this plugin's admin page
        if ($hook === 'toplevel_page_tplb') {
            wp_enqueue_style('tplb-admin-styles', TPLB_PLUGIN_URL . 'build/css/adminStyles.css', [], '1.0.0');
            wp_enqueue_script('tplb-admin-scripts', TPLB_PLUGIN_URL . 'build/js/main.js', ['jquery'], '1.0.0', true);
        }
    }

    /**
     * Registers the plugin's settings and adds them to the WordPress settings API.
     *
     * This method registers the `tplb_badge_display_option` and `tplb_category_badge_texts` settings and
     * adds them to the `tplb_general_settings` section of the plugin's settings page.
     *
     * @since 1.0.0
     */
    public function register_settings() {
        // Register the badge display option
        register_setting('tplb_settings', 'tplb_badge_display_option');
        register_setting('tplb_settings', 'tplb_category_badge_texts');

        add_settings_section(
            'tplb_general_settings',
            __('Badge Display Settings', 'tplb'),
            null,
            'tplb'
        );

        add_settings_field(
            'tplb_badge_display_option',
            __('Badge Display Option', 'tplb'),
            [$this, 'badge_display_option_callback'],
            'tplb',
            'tplb_general_settings'
        );

        // Dynamically generate fields for each category
        foreach (get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]) as $category) {
            add_settings_field(
                "tplb_category_badge_text_{$category->term_id}",
                sprintf(__('Default Badge Text for %s', 'tplb'), $category->name),
                function () use ($category) {
                    $this->category_badge_text_callback($category);
                },
                'tplb',
                'tplb_general_settings'
            );
        }
    }

    public function badge_display_option_callback() {
        $options = [
            'all'       => __('All Products', 'tplb'),
            'meta'      => __('Products with Custom Meta', 'tplb'),
            'categories' => __('Specific Categories', 'tplb'),
        ];

        $current = get_option('tplb_badge_display_option', 'all');

        echo '<select id="tplb_badge_display_option" name="tplb_badge_display_option">';
        foreach ($options as $key => $label) {
            echo '<option value="' . esc_attr($key) . '" ' . selected($current, $key, false) . '>' . esc_html($label) . '</option>';
        }
        echo '</select>';
    }

    public function category_badge_text_callback($category) {
        $texts = get_option('tplb_category_badge_texts', []);
        $value = isset($texts[$category->term_id]) ? $texts[$category->term_id] : '';

        echo '<input type="text" id="tplb_category_badge_text_' . esc_attr($category->term_id) . '" name="tplb_category_badge_texts[' . esc_attr($category->term_id) . ']" value="' . esc_attr($value) . '" class="regular-text" />';
        echo '<p class="description">' . sprintf(__('Set the default badge text for %s category.', 'tplb'), $category->name) . '</p>';
    }


    public function add_badge_text_meta_field() {
        global $post;

        $value = get_post_meta($post->ID, '_tplb_badge_text', true);

        echo '<div class="options_group">';
        woocommerce_wp_text_input([
            'id'          => 'tplb_badge_text',
            'label'       => __('Badge Text', 'tplb'),
            'placeholder' => __('Enter custom badge text', 'tplb'),
            'desc_tip'    => true,
            'description' => __('Override the default badge text for this product.', 'tplb'),
            'value'       => esc_attr($value),
        ]);
        echo '</div>';
    }

    public function save_badge_text_meta_field($post_id) {
        if (isset($_POST['tplb_badge_text'])) {
            update_post_meta($post_id, '_tplb_badge_text', sanitize_text_field($_POST['tplb_badge_text']));
        }
    }
}
