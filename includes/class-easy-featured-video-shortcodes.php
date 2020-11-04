<?php

class Easy_Featured_Video_Shortcodes
{

	public function __construct()
	{
		add_shortcode('easy_featured_video_show', array($this, "output_video_show"));
		add_shortcode('easy_featured_video_show_by_easy_post_id', array($this, "output_video_show_easy_post_id"));

	}

	public function output_video_show()
	{
		global $post;
		$type = $post->post_type; // current post type
		$easy_post_id = $post->ID;

		if (easy_featured_video_is_valid_post_type($type)) {
			return easy_featured_video_html($easy_post_id);
		}

	}

	public function output_video_show_easy_post_id($atts)
	{

		global $post;
		$easy_post_id = $atts['easy_post_id'];
		$type = $post->post_type; // current post type
		if (easy_featured_video_is_valid_post_type($type)) {
			return easy_featured_video_html($easy_post_id);
		}
	}


}

new Easy_Featured_Video_Shortcodes();
