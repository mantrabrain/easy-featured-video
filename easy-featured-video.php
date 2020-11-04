<?php
/**
 * Plugin Name: Easy Featured Video
 * Description: Easy featured video
 * Version: 1.0.0
 * Author: Mantrabrain
 * Author URI: https://mantrabrain.com
 * License: GPLv3 or later
 * Text Domain: easy-featured-video
 * Domain Path: /languages/
 * @package Easy_Featured_Video
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


if (!defined('EASY_FEATURED_VIDEO_FILE')) {
    define('EASY_FEATURED_VIDEO_FILE', __FILE__);
}

// Define EASY_FEATURED_VIDEO_VERSION.
if (!defined('EASY_FEATURED_VIDEO_VERSION')) {
    define('EASY_FEATURED_VIDEO_VERSION', '1.0.2');
}

// Define EASY_FEATURED_VIDEO_PLUGIN_URI.
if (!defined('EASY_FEATURED_VIDEO_PLUGIN_URI')) {
    define('EASY_FEATURED_VIDEO_PLUGIN_URI', plugins_url('', EASY_FEATURED_VIDEO_FILE));
}

// Define EASY_FEATURED_VIDEO_PLUGIN_DIR.
if (!defined('EASY_FEATURED_VIDEO_PLUGIN_DIR')) {
    define('EASY_FEATURED_VIDEO_PLUGIN_DIR', plugin_dir_path(EASY_FEATURED_VIDEO_FILE));
}


// Include the main WooCommerce class.
if (!class_exists('Easy_Featured_Video')) {
    include_once dirname(__FILE__) . '/includes/class-easy-featured-video.php';
}


/**
 * Main instance of Easy_Featured_Video.
 *
 * Returns the main instance of Easy_Featured_Video to prevent the need to use globals.
 *
 * @return Easy_Featured_Video
 * @since  1.0.0
 */
function easy_featured_video()
{
    return Easy_Featured_Video::instance();
}

// Global for backwards compatibility.
$GLOBALS['easy_featured_video'] = easy_featured_video();
