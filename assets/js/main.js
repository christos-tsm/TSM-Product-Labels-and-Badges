document.addEventListener('DOMContentLoaded', () => {
    const badgeDisplayOption = document.getElementById('tplb_badge_display_option');
    const categoryFields = document.querySelectorAll('[id^="tplb_category_badge_text_"], [id^="tplb_category_badge_color_"]');

    const toggleCategoryFields = () => {
        if (badgeDisplayOption.value === 'categories') {
            categoryFields.forEach(field => field.closest('tr').style.display = '');
        } else {
            categoryFields.forEach(field => field.closest('tr').style.display = 'none');
        }
    };

    badgeDisplayOption.addEventListener('change', toggleCategoryFields);
    toggleCategoryFields(); // Initial check
});
