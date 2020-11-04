<?php
/**
 * Easy_Featured_Video admin setup
 *
 * @package Easy_Featured_Video
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main Easy_Featured_Video_Admin Class.
 *
 * @class Easy_Featured_Video
 */
final class Easy_Featured_Video_Admin
{

    /**
     * The single instance of the class.
     *
     * @var Easy_Featured_Video_Admin
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main Easy_Featured_Video_Admin Instance.
     *
     * Ensures only one instance of Easy_Featured_Video_Admin is loaded or can be loaded.
     *
     * @return Easy_Featured_Video_Admin - Main instance.
     * @since 1.0.0
     * @static
     */
    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }


    /**
     * Easy_Featured_Video Constructor.
     */
    public function __construct()
    {
        $this->includes();
        $this->init_hooks();
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {

        add_action('admin_menu', array($this, 'admin_menu'));

    }


    function admin_menu()
    {


        $settings_page = add_submenu_page('options-general.php',
            'Easy Featured Video', 'Easy Featured Video',
            'administrator', 'easy-featured-video-settings',
            array($this, 'settings'));

        add_action('load-' . $settings_page, array($this, 'settings_page_init'));


    }

    public function settings()
    {
        Easy_Featured_Video_Admin_Settings::output();


    }

    public function settings_page_init()
    {
        global $current_tab, $current_section;

        // Include settings pages.
        Easy_Featured_Video_Admin_Settings::get_settings_pages();

        // Get current tab/section.
        $current_tab = empty($_GET['tab']) ? 'general' : sanitize_title(wp_unslash($_GET['tab'])); // WPCS: input var okay, CSRF ok.
        $current_section = empty($_REQUEST['section']) ? '' : sanitize_title(wp_unslash($_REQUEST['section'])); // WPCS: input var okay, CSRF ok.

        // Save settings if data has been posted.
        if ('' !== $current_section && apply_filters("easy_featured_video_save_settings_{$current_tab}_{$current_section}", !empty($_POST['save']))) { // WPCS: input var okay, CSRF ok.
            Easy_Featured_Video_Admin_Settings::save();
        } elseif ('' === $current_section && apply_filters("easy_featured_video_save_settings_{$current_tab}", !empty($_POST['save']))) { // WPCS: input var okay, CSRF ok.
            Easy_Featured_Video_Admin_Settings::save();
        }

        // Add any posted messages.
        if (!empty($_GET['easy_featured_video_error'])) { // WPCS: input var okay, CSRF ok.
            Easy_Featured_Video_Admin_Settings::add_error(wp_kses_post(wp_unslash($_GET['easy_featured_video_error']))); // WPCS: input var okay, CSRF ok.
        }

        if (!empty($_GET['easy_featured_video_message'])) { // WPCS: input var okay, CSRF ok.
            Easy_Featured_Video_Admin_Settings::add_message(wp_kses_post(wp_unslash($_GET['easy_featured_video_message']))); // WPCS: input var okay, CSRF ok.
        }

        do_action('easy_featured_video_settings_page_init');


    }


    /**
     * Include required core files used in admin.
     */
    public function includes()
    {
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/admin/class-easy-featured-video-admin-settings.php';
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/admin/class-easy-featured-video-admin-settings-base.php';
 

    }


}
