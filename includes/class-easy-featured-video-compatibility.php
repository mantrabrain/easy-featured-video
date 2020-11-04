<?php

class Easy_Featured_Video_Compatibility
{
    public function __construct()
    {
        if (class_exists('WooCommerce')) {
            include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/compatibility/class-easy-featured-video-woocommerce.php';

        }
    }
}

new Easy_Featured_Video_Compatibility();


