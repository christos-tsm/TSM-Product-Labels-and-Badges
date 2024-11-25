<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class TPLB_Admin {
    public function __construct() {
        $this->init_hooks();
    }

    private function init_hooks() {
        // Add admin menu
        add_action('admin_menu', [$this, 'add_admin_menu']);
        // Enqueue admin styles and scripts
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
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
        echo '<div class="wrap">';
        echo '<h1>' . esc_html__('Product Labels & Badges', 'tplb') . '</h1>';
        echo '<p>' . esc_html__('Manage your product labels and badges here.', 'tplb') . '</p>';
        // Admin UI will be built here
        echo '</div>';
    }

    public function enqueue_admin_assets($hook) {
        // Enqueue assets only for this plugin's admin page
        if ($hook === 'toplevel_page_tplb') {
            wp_enqueue_style('tplb-admin-styles', TPLB_PLUGIN_URL . 'admin/tplb-admin-styles.css', [], '1.0.0');
            wp_enqueue_script('tplb-admin-scripts', TPLB_PLUGIN_URL . 'admin/tplb-admin-scripts.js', ['jquery'], '1.0.0', true);
        }
    }
}
