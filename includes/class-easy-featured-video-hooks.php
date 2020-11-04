<?php

class Easy_Featured_Video_Hooks
{
    public function __construct()
    {
        $this->includes();
    }
    public function includes(){
        include_once EASY_FEATURED_VIDEO_ABSPATH . 'includes/hooks/class-easy-featured-video-content-hooks.php';

    }
}

new Easy_Featured_Video_Hooks();