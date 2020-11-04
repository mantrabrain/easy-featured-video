<?php
/**
 * Admin View: Settings
 *
 * @package EasyFeaturedVideo
 */

if (!defined('ABSPATH')) {
    exit;
}
$tab_exists = isset($tabs[$current_tab]) || has_action('easy_featured_video_sections_' . $current_tab) || has_action('easy_featured_video_settings_' . $current_tab) || has_action('easy_featured_video_settings_tabs_' . $current_tab);
$current_tab_label = isset($tabs[$current_tab]) ? $tabs[$current_tab] : '';



if (!$tab_exists) {
    wp_safe_redirect(admin_url('admin.php?page=easy-featured-video-settings'));
    exit;
}
?>
<div class="wrap easy-featured-video">
    <form method="<?php echo esc_attr(apply_filters('easy_featured_video_settings_form_method_tab_' . $current_tab, 'post')); ?>"
          id="mainform" action="" enctype="multipart/form-data">
        <nav class="nav-tab-wrapper easy-featured-video-nav-tab-wrapper">
            <?php

            foreach ($tabs as $slug => $label) {
                echo '<a href="' . esc_html(admin_url('admin.php?page=easy-featured-video-settings&tab=' . esc_attr($slug))) . '" class="nav-tab ' . ($current_tab === $slug ? 'nav-tab-active' : '') . '">' . esc_html($label) . '</a>';
            }

            do_action('easy_featured_video_settings_tabs');

            ?>
        </nav>
        <h1 class="screen-reader-text"><?php echo esc_html($current_tab_label); ?></h1>
        <?php
        do_action('easy_featured_video_sections_' . $current_tab);

        self::show_messages();

        do_action('easy_featured_video_settings_' . $current_tab);
        do_action('easy_featured_video_settings_tabs_' . $current_tab); // @deprecated hook. @todo remove in 4.0.
        ?>
        <p class="submit">
            <?php if (empty($GLOBALS['hide_save_button'])) : ?>
                <button name="save" class="button-primary easy-featured-video-save-button" type="submit"
                        value="<?php esc_attr_e('Save changes', 'easy-featured-video'); ?>"><?php esc_html_e('Save changes', 'easy-featured-video'); ?></button>
            <?php endif; ?>
            <?php wp_nonce_field('easy-featured-video-settings'); ?>
        </p>
    </form>
</div>
