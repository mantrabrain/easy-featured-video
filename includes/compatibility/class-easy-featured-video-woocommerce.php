<?php

class Easy_Featured_Video_WooCommerce
{
    public function __construct()
    {
        $this->includes();
    }

    public function includes()
    {
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/compatibility/woocommerce/class-easy-featured-video-wc-hooks.php';

    }
}

new Easy_Featured_Video_WooCommerce();