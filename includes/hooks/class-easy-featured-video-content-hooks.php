<?php

class Easy_Featured_Video_Content_Hooks
{
    public function __construct()
    {
        $easy_featured_video_after_contents = get_option('easy_featured_video_after_contents');

        if ($easy_featured_video_after_contents == "yes") {

            add_filter('the_content', array($this, 'after_contents'));
        }

        $easy_featured_video_after_excerpt = get_option('easy_featured_video_after_excerpt');
        if ($easy_featured_video_after_excerpt == "yes") {
            add_filter('the_excerpt', array($this, 'excerpt'));
        }
        $easy_featured_video_replace_thumbnail = get_option('easy_featured_video_replace_thumbnail');
         if ($easy_featured_video_replace_thumbnail == "yes") {
            add_filter('post_thumbnail_html', array($this, 'post_thumbnail_html'), 10, 5);
        }
    }

    public function after_contents($content)
    {
        global $post;
        if ($post->post_type != "product") {
            if (is_single() || is_page()) {
                $content .= '<div class="easy-featured-video-wrap">' . do_shortcode('[easy_featured_video_show]') . '</div>';
            }
        }
        return $content;


    }

    public function excerpt($content)
    {
        global $post;
        if ($post->post_type != "product") {
            if (is_single() || is_page()) {
                $content .= '<div class="easy-featured-video-wrap">' . do_shortcode('[easy_featured_video_show]') . '</div>';

            }
        }
        return $content;
    }

    function post_thumbnail_html($html, $post_id, $post_thumbnail_id, $size, $attr)
    {
        $url_for_video = easy_featured_video_get_video_url($post_id);

         if (!is_null($url_for_video) && '' != $url_for_video) {

            return do_shortcode("[easy_featured_video_show]");
        }

        return $html;
    }
}

new Easy_Featured_Video_Content_Hooks();
