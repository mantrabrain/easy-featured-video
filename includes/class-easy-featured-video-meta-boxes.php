<?php

class Easy_Featured_Video_Meta_Boxes
{
	public function __construct()
	{
		add_action('add_meta_boxes', array($this, 'metabox'));
		add_action('save_post', array($this, 'save'), 10, 1);


	}

	public function metabox($post_type)
	{


		if (easy_featured_video_is_valid_post_type($post_type)) {
			add_meta_box('easy_featured_video_metabox', __('Featured Video', 'easy-featured-video'),
				array($this, 'video_upload'), $post_type, 'side', 'high'); // easy_featured_video_upload function

		}
	}

	public function video_upload($post)
	{

		wp_nonce_field('easy_featured_video_metabox_custom_nonce', 'easy_featured_video_metabox_nonce');


		$easy_featured_video_custom = get_post_meta($post->ID, 'easy_featured_video_custom', true);
		$easy_featured_video_url = get_post_meta($post->ID, 'easy_featured_video_url', true);

		echo '<input type="url" name="easy_featured_video_url" placeholder="Youtube video URL" value="' . esc_attr($easy_featured_video_url) . '"/>';
		echo '<h3>OR</h3>';
		$image = ' button">Upload Video';
		$display = 'none';
		// Attachment id of video is $value
		if ($media = wp_get_attachment_url($easy_featured_video_custom)) {  // getting video here
			$video = $media;
			$image = '"><video controls="" src="' . $video . '" style="max-width:95%;display:block;"></video>';
			$display = 'inline-block';
		}
		echo '
    <div><a href="#" class="upload_video_button' . $image . '</a>
    <input type="hidden" name="easy_featured_video_custom" id="easy_featured_video_custom" value="' . $easy_featured_video_custom . '" />
    <a href="#" class="remove_image" style="display:inline-block;display:' . $display . '">Remove Video</a>
    </div>';
		// getting current post id, and calling function of video uploading "easy_featured_video_uploader" with attachment id of video

	}

	public
	function save($post_id)
	{


		// Check if our nonce is set.
		if (!isset($_POST['easy_featured_video_metabox_nonce'])) {
			return $post_id;
		}
		if (!current_user_can('edit_post')) return;

		$nonce = $_POST['easy_featured_video_metabox_nonce'];

		// Verify that the nonce is valid.
		if (!wp_verify_nonce($nonce, 'easy_featured_video_metabox_custom_nonce')) {
			return $post_id;
		}

		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return $post_id;


		$easy_featured_video_custom = sanitize_text_field($_POST['easy_featured_video_custom']);
		$easy_featured_video_url = sanitize_text_field($_POST['easy_featured_video_url']);
		update_post_meta($post_id, 'easy_featured_video_custom', $easy_featured_video_custom);
		update_post_meta($post_id, 'easy_featured_video_url', $easy_featured_video_url);
		return $post_id;
	}
}

new Easy_Featured_Video_Meta_Boxes();
