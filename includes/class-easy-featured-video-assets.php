<?php

class Easy_Featured_Video_Assets
{

    public function __construct()
    {
        add_action('admin_enqueue_scripts', array($this, 'admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'scripts'));


    }

    public function admin_scripts($hooks)
    {
        wp_enqueue_media();

        /*  wp_enqueue_style(
              'easy-featured-video-admin-css',
              EASY_FEATURED_VIDEO_PLUGIN_URI . '/assets/admin/css/admin.css',
              array(),
              EASY_FEATURED_VIDEO_VERSION

          );*/
        wp_enqueue_script(
            'easy-featured-video-admin-js',
            EASY_FEATURED_VIDEO_PLUGIN_URI . '/assets/admin/js/admin.js',
            array('jquery'),
            EASY_FEATURED_VIDEO_VERSION

        );


    }


    public function scripts()
    {
        wp_register_script(
            'easy-featured-video-plyr-script',
            EASY_FEATURED_VIDEO_PLUGIN_URI . '/assets/lib/plyr/js/plyr.polyfilled.js', array(),
            EASY_FEATURED_VIDEO_VERSION);

        wp_register_style(
            'easy-featured-video-plyr-style',
            EASY_FEATURED_VIDEO_PLUGIN_URI . '/assets/lib/plyr/css/plyr.css', array(),
            EASY_FEATURED_VIDEO_VERSION);

        wp_enqueue_style(
            'easy-featured-video-style',
            EASY_FEATURED_VIDEO_PLUGIN_URI . '/assets/css/easy-featured-video.css',
            array('easy-featured-video-plyr-style'),
            EASY_FEATURED_VIDEO_VERSION

        );
        wp_enqueue_script(
            'easy-featured-video-script',
            EASY_FEATURED_VIDEO_PLUGIN_URI . '/assets/js/easy-featured-video.js',
            array('jquery', 'easy-featured-video-plyr-script'),
            EASY_FEATURED_VIDEO_VERSION

        );
    }
}

new Easy_Featured_Video_Assets();