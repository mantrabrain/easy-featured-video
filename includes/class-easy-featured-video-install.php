<?php
/**
 * Installation related functions and actions.
 *
 * @package Easy_Featured_Video/Classes
 */

defined('ABSPATH') || exit;

/**
 * Easy_Featured_Video_Install Class.
 */
class Easy_Featured_Video_Install
{

    private static $update_callbacks = array();

    /**
     * Hook in tabs.
     */
    public static function init()
    {
        add_action('init', array(__CLASS__, 'check_version'), 5);


    }

    /**
     * Check Easy_Featured_Video version and run the updater is required.
     *
     * This check is done on all requests and runs if the versions do not match.
     */
    public static function check_version()
    {
        if (!defined('IFRAME_REQUEST') && version_compare(get_option('easy_featured_video_version'), easy-featured-video()->version, '<')) {
            self::install();
            do_action('easy_featured_video_updated');
        }
    }


    /**
     * Install Easy_Featured_Video.
     */
    public static function install()
    {


        // Check if we are not already running this routine.
        if ('yes' === get_transient('easy_featured_video_installing')) {
            return;
        }
        // If we made it till here nothing is running yet, lets set the transient now.
        set_transient('easy_featured_video_installing', 'yes', MINUTE_IN_SECONDS * 10);
        $easy_featured_video_version = get_option('easy_featured_video_version');

        if (empty($easy_featured_video_version)) {
            self::create_options();
        }
        self::versionwise_update();

        self::update_easy_featured_video_version();
        delete_transient('easy_featured_video_installing');

        do_action('easy_featured_video_installed');
    }


    private static function versionwise_update()
    {
        $easy_featured_video_version = get_option('easy_featured_video_version', null);

        if ($easy_featured_video_version == '' || $easy_featured_video_version == null || empty($easy_featured_video_version)) {
            return;
        }
        if (version_compare($easy_featured_video_version, easy-featured-video()->version, '<')) {

            foreach (self::$update_callbacks as $version => $callbacks) {

                if (version_compare($easy_featured_video_version, $version, '<')) {

                    self::exe_update_callback($callbacks);
                }
            }
        }
    }

    private static function exe_update_callback($callbacks)
    {

        foreach ($callbacks as $callback) {
            if (is_callable($callback)) {
                call_user_func($callback);
            }

        }
    }

    /**
     * Update Easy_Featured_Video version to current.
     */
    private static function update_easy_featured_video_version()
    {
        delete_option('easy_featured_video_version');
        add_option('easy_featured_video_version', easy-featured-video()->version);
    }


    /**
     * Default options.
     *
     * Sets up the default options used on the settings page.
     */
    private static function create_options()
    {

        add_option('easy_featured_video_post_types', 'post');


    }



}

Easy_Featured_Video_Install::init();
