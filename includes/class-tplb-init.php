<?php

class TPLB_Init {
    private static $instance = null;

    public static function instance() {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->includes();
        add_action('init', [$this, 'init_hooks']);
    }

    private function includes() {
        require_once TPLB_PLUGIN_PATH . 'admin/class-tplb-admin.php';
        require_once TPLB_PLUGIN_PATH . 'public/class-tplb-frontend.php';
    }

    public function init_hooks() {
        // Initialize admin and public functionalities
        if (is_admin()) {
            new TPLB_Admin();
        } else {
            new TPLB_Frontend();
        }
    }
}
