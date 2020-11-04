<?php
/**
 * Easy_Featured_Video Miscellaneous Settings
 *
 * @package Easy_Featured_Video/Admin
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit;
}

if (class_exists('Easy_Featured_Video_Settings_General', false)) {
    return new Easy_Featured_Video_Settings_General();
}

/**
 * Easy_Featured_Video_Settings_General.
 */
class Easy_Featured_Video_Settings_General extends Easy_Featured_Video_Admin_Settings_Base
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->id = 'general';
        $this->label = __('General', 'easy-featured-video');

        parent::__construct();
    }

    /**
     * Get sections.
     *
     * @return array
     */
    public function get_sections()
    {
        $sections = array(
            '' => __('General', 'easy-featured-video'),
            'pages' => __('Pages', 'easy-featured-video'),
        );

        return apply_filters('easy_featured_video_get_sections_' . $this->id, $sections);
    }

    /**
     * Output the settings.
     */
    public function output()
    {
        global $current_section;

        $settings = $this->get_settings($current_section);

        Easy_Featured_Video_Admin_Settings::output_fields($settings);
    }

    /**
     * Save settings.
     */
    public function save()
    {
        global $current_section;

        $settings = $this->get_settings($current_section);
        Easy_Featured_Video_Admin_Settings::save_fields($settings);

        if ($current_section) {
            do_action('easy_featured_video_update_options_' . $this->id . '_' . $current_section);
        }
    }

    /**
     * Get settings array.
     *
     * @param string $current_section Current section name.
     * @return array
     */
    public function get_settings($current_section = '')
    {
        if ('pages' === $current_section) {
            $settings = apply_filters(
                'easy_featured_video_settings_general_pages',
                array(


                )
            );

        } else {
            $post_types = get_post_types(array('public' => true), 'objects');
            $post_type_arr = array();
            foreach ($post_types as $post_type_obj) {
                if ($post_type_obj->name == "attachment") {
                    continue;
                }
                $labels = get_post_type_labels($post_type_obj);
                $labels_name = $labels->name;
                $name = $post_type_obj->name;
                $post_type_arr[] = array(
                    'id' => $name,
                    'title' => $labels_name
                );
            }
            $settings = apply_filters(
                'easy_featured_video_settings_general_general',
                array(
                    array(
                        'title' => __('General Settings', 'easy-featured-video'),
                        'type' => 'title',
                        'desc' => '',
                        'id' => 'easy_featured_video_general_options',
                    ),
                    array(
                        'title' => '',
                        'desc' => __('Post', 'easy-featured-video'),
                        'id' => 'easy_featured_video_post_types',
                        'default' => true,
                        'type' => 'multicheckbox',
                        'options' => $post_type_arr
                    ),

                    array(
                        'title' => '',
                        'desc' => __('Automatically display after posts contents?', 'easy-featured-video'),
                        'id' => 'easy_featured_video_after_contents',
                        'default' => true,
                        'type' => 'checkbox',
                        'checkboxgroup' => 'start'
                    ),
                    array(
                        'title' => '',
                        'desc' => __('Automatically display video instaed of posts thumbnail?', 'easy-featured-video'),
                        'id' => 'easy_featured_video_replace_thumbnail',
                        'default' => true,
                        'type' => 'checkbox',
                        'checkboxgroup' => ''


                    ),
                    array(
                        'title' => '',
                        'desc' => __('Automatically display after posts excerpt?', 'easy-featured-video'),
                        'id' => 'easy_featured_video_after_excerpt',
                        'default' => true,
                        'type' => 'checkbox',
                        'checkboxgroup' => 'end'
                    ),
                    array(
                        'title' => 'WooCommerce',
                        'desc' => __('WooCommerce', 'easy-featured-video'),
                        'id' => 'easy_featured_video_woocommerce_option',
                        'default' => true,
                        'type' => 'radio',
                        'options' => array(
                            'short_description' => 'Short Description',
                            'in_main_description' => 'In main Description',
                            'before_image_gallery' => 'Before Image Gallery',
                            'after_add_to_cart_button' => 'After Add To Cart Button',
                            'after_summery' => 'After Summery Section',
                            'none' => 'No need to display automatically',

                        )
                    ),
                    array(
                        'type' => 'sectionend',
                        'id' => 'easy_featured_video_general_options',
                    ),

                )

            );
        }

        return apply_filters('easy_featured_video_get_settings_' . $this->id, $settings, $current_section);
    }
}

return new Easy_Featured_Video_Settings_General();
