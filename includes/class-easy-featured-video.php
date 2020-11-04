<?php
/**
 * Easy_Featured_Video setup
 *
 * @package Easy_Featured_Video
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main Easy_Featured_Video Class.
 *
 * @class Easy_Featured_Video
 */
final class Easy_Featured_Video
{

    /**
     * Easy_Featured_Video version.
     *
     * @var string
     */
    public $version = EASY_FEATURED_VIDEO_VERSION;
    /**
     * The single instance of the class.
     *
     * @var Easy_Featured_Video
     * @since 1.0.0
     */
    protected static $_instance = null;


    /**
     * Main Easy_Featured_Video Instance.
     *
     * Ensures only one instance of Easy_Featured_Video is loaded or can be loaded.
     *
     * @return Easy_Featured_Video - Main instance.
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
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cloning is forbidden.', 'easy-featured-video'), '1.0.0');
    }

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Unserializing instances of this class is forbidden.', 'easy-featured-video'), '1.0.0');
    }

    /**
     * Auto-load in-accessible properties on demand.
     *
     * @param mixed $key Key name.
     * @return mixed
     */
    public function __get($key)
    {
        if (in_array($key, array(''), true)) {
            return $this->$key();
        }
    }

    /**
     * Easy_Featured_Video Constructor.
     */
    public function __construct()
    {

        $this->define_constants();
        $this->includes();
        $this->init_hooks();


        do_action('easy_featured_video_loaded');
    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    private function init_hooks()
    {


        register_activation_hook(EASY_FEATURED_VIDEO_FILE, array('Easy_Featured_Video_Install', 'install'));

        add_action('init', array($this, 'init'), 0);


    }

    /**
     * Define Easy_Featured_Video Constants.
     */
    private function define_constants()
    {

        $this->define('EASY_FEATURED_VIDEO_ABSPATH', dirname(EASY_FEATURED_VIDEO_FILE) . '/');
        $this->define('EASY_FEATURED_VIDEO_BASENAME', plugin_basename(EASY_FEATURED_VIDEO_FILE));
    }

    /**
     * Define constant if not already set.
     *
     * @param string $name Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value)
    {
        if (!defined($name)) {
            define($name, $value);
        }
    }

    /**
     * What type of request is this?
     *
     * @param string $type admin, ajax, cron or frontend.
     * @return bool
     */
    private function is_request($type)
    {
        switch ($type) {
            case 'admin':
                return is_admin();
            case 'ajax':
                return defined('DOING_AJAX');
            case 'cron':
                return defined('DOING_CRON');
            case 'frontend':
                return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON') && !defined('REST_REQUEST');
        }
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes()
    {

        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/functions.php';
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/class-easy-featured-video-shortcodes.php';
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/class-easy-featured-video-meta-boxes.php';
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/class-easy-featured-video-hooks.php';
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/class-easy-featured-video-assets.php';
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/admin/class-easy-featured-video-admin.php';


        if ($this->is_request('admin')) {
            Easy_Featured_Video_Admin::instance();
        }

        if ($this->is_request('frontend')) {
            //Easy_Featured_Video_Frontend::instance();
        }

    }


    /**
     * Init Easy_Featured_Video when WordPress Initialises.
     */
    public function init()
    {
        // Before init action.
        do_action('before_easy_featured_video_init');

        // Set up localisation.
        $this->load_plugin_textdomain();


        // Init action.
        do_action('easy_featured_video_init');
    }

    /**
     * Load Localisation files.
     *
     * Note: the first-loaded translation file overrides any following ones if the same translation is present.
     *
     * Locales found in:
     *      - WP_LANG_DIR/easy-featured-video/easy-featured-video-LOCALE.mo
     *      - WP_LANG_DIR/plugins/easy-featured-video-LOCALE.mo
     */
    public function load_plugin_textdomain()
    {
        $locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
        $locale = apply_filters('plugin_locale', $locale, 'easy-featured-video');
        unload_textdomain('easy-featured-video');
        load_textdomain('easy-featured-video', WP_LANG_DIR . '/easy-featured-video/easy-featured-video-' . $locale . '.mo');
        load_plugin_textdomain('easy-featured-video', false, plugin_basename(dirname(EASY_FEATURED_VIDEO_FILE)) . '/i18n/languages');
    }

    /**
     * Ensure theme and server variable compatibility and setup image sizes.
     */
    public function setup_environment()
    {

        $this->define('EASY_FEATURED_VIDEO_TEMPLATE_PATH', $this->template_path());

    }

    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url()
    {
        return untrailingslashit(plugins_url('/', EASY_FEATURED_VIDEO_FILE));
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path()
    {
        return untrailingslashit(plugin_dir_path(EASY_FEATURED_VIDEO_FILE));
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path()
    {
        return apply_filters('easy_featured_video_template_path', 'easy-featured-video/');
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function plugin_template_path()
    {
        return apply_filters('easy_featured_video_plugin_template_path', $this->plugin_path() . '/templates/');
    }

    /**
     * Get Ajax URL.
     *
     * @return string
     */
    public function ajax_url()
    {
        return admin_url('admin-ajax.php', 'relative');
    }


}
