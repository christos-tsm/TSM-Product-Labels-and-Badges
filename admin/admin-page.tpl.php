<div class="p-6 bg-gray-100 tpbl-admin-page">
    <h1 class="text-2xl font-bold text-blue-600">
        <?php esc_html_e('Product Labels & Badges', 'tplb'); ?>
    </h1>
    <p class="mt-4 text-gray-700">
        <?php esc_html_e('Welcome to the TSM Product Labels & Badges plugin admin page.', 'tplb'); ?>
    </p>
    <form method="post" action="options.php" class="tpbl-admin-form">
        <?php
        // Output settings fields for this options page
        settings_fields('tplb_settings');
        do_settings_sections('tplb');
        submit_button(__('Save Changes', 'tplb'));
        ?>
    </form>

</div>