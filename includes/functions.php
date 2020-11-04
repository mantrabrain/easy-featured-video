<?php

function easy_featured_video_get_video_url($post_id)
{
	$easy_featured_video_url = get_post_meta($post_id, 'easy_featured_video_url', true);

	if (!empty($easy_featured_video_url)) {
		return $easy_featured_video_url;
	}
	$easy_featured_video_url = wp_get_attachment_url(get_post_meta($post_id, 'easy_featured_video_custom', true));
	return $easy_featured_video_url;
}

function easy_featured_video_html($post_id, $args = array())
{
	$permalink = parse_url(get_permalink($post_id));
	$media = easy_featured_video_get_video_url($post_id);
	$featured_image_url = wp_get_attachment_url(get_post_thumbnail_id($post_id));

	$media_url = parse_url($media);
	$args = wp_parse_args(
		$args,
		array('width' => '100%',
			'height' => '500px')
	);
	if (!$media) {
		return null;
	}

	if (strtolower($permalink['host']) == strtolower($media_url['host'])) {
		return '<div class="easy-featured-video-wrap">
                    <video class="easy_featured_video easy-featured-video" id="easy_featured_video_' . $post_id . '"
                     data-poster="' . esc_attr($featured_image_url) . '"
                     data-plyr="true"
                     src="' . $media . '" style="width:' . $args['width'] . '; display:block;"></video>
                </div>';
	} else {
		preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $media, $match);
		$youtube_video_id = $match[1];
		$poster_html = '';
		if ('' != $featured_image_url) {
			$poster_html = '<div class="plyr__poster" style="background-size:cover;background-image: url(\'' . esc_url($featured_image_url) . '\');"></div>';
		}
		return '<div class="easy-featured-video-wrap" style="width:100%; max-width:100%;">
                    <div class="plyr__video-embed plyr__poster-enabled easy-featured-video"
                    id="easy_featured_video_' . $post_id . '"
                    data-poster="' . esc_attr($featured_image_url) . '"
                    data-plyr="true"
                    >
                        <iframe
                         width="' . esc_attr($args['width']) . '"
                        height="' . esc_attr($args['height']) . '"
                        src="https://www.youtube.com/embed/' . esc_attr($youtube_video_id) . '?origin=https://plyr.io&iv_load_policy=3&modestbranding=1&playsinline=1&showinfo=0&rel=0&enablejsapi=1"
                        allowfullscreen="1"
                        allowtransparency>
                      </iframe>
                      ' . $poster_html . '
                    </div>
                </div>';
	}

}

function easy_featured_video_is_valid_post_type($post_type = '')
{
	$available_post_types = get_option('easy_featured_video_post_types');

	if (!$available_post_types) {
		return false;
	}
	if (is_null($available_post_types)) {
		return false;
	}
	if (is_array($available_post_types)) {

		$post_types = array_keys($available_post_types);

		if (in_array($post_type, $post_types)) {
			return true;
		}
		return false;
	}
	return false;

}
