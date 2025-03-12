<div class="p-6 bg-gray-100 tpbl-admin-page">
    <h1 class="text-2xl font-bold text-slate-600">
        <?php esc_html_e('Product Labels & Badges', 'tplb'); ?>
    </h1>
    <div class="mt-4 max-w-[50vw] italic">
        <p class="text-gray-700 leading-7 text-base"><?php esc_html_e('Badges are displayed based on a priority order to ensure maximum flexibility.', 'tplb'); ?></p>
        <p class="text-gray-700 leading-7 text-base"><?php esc_html_e('First, if a product has a custom badge set via its meta field, that badge takes precedence and overrides any category-based settings.', 'tplb'); ?></p>
        <p class="text-gray-700 leading-7 text-base"><?php esc_html_e('If no custom badge is provided, then the display option set in the plugin determines the behavior.', 'tplb'); ?></p>
        <p class="text-gray-700 leading-7 text-base"><?php esc_html_e('When the option is set to "all," every product shows a default badge.', 'tplb'); ?></p>
        <p class="text-gray-700 leading-7 text-base"><?php esc_html_e('Alternatively, if the option is set to "categories," the plugin loops through all the product’s assigned categories and displays a badge for each category that has a badge text defined, using the specified color settings for each.', 'tplb'); ?></p>
        <p class="text-gray-700 leading-7 text-base"><?php esc_html_e('This structure allows for granular control where custom product badges override category badges, while still providing a fallback to global defaults or multiple category badges when needed.', 'tplb'); ?></p>
    </div>
    <form method="post" action="options.php" class="tpbl-admin-form">
        <?php
        settings_fields('tplb_settings');
        do_settings_sections('tplb');
        submit_button(__('Save Changes', 'tplb'));
        ?>
    </form>

</div>