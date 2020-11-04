<?php
/**
 * Easy_Featured_Video Settings Page/Tab
 *
 * @author      Mantrabrain
 * @category    Admin
 * @package     Easy_Featured_Video/Admin
 * @version     1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!class_exists('Easy_Featured_Video_Admin_Settings_Base', false)) :

    /**
     * Easy_Featured_Video_Admin_Settings_Base.
     */
    abstract class Easy_Featured_Video_Admin_Settings_Base
    {

        /**
         * Setting page id.
         *
         * @var string
         */
        protected $id = '';

        /**
         * Setting page label.
         *
         * @var string
         */
        protected $label = '';

        /**
         * Constructor.
         */
        public function __construct()
        {
            add_filter('easy_featured_video_settings_tabs_array', array($this, 'add_settings_page'), 20);
            add_action('easy_featured_video_sections_' . $this->id, array($this, 'output_sections'));
            add_action('easy_featured_video_settings_' . $this->id, array($this, 'output'));
            add_action('easy_featured_video_settings_save_' . $this->id, array($this, 'save'));
        }

        /**
         * Get settings page ID.
         *
         * @return string
         * @since 1.0.0
         */
        public function get_id()
        {
            return $this->id;
        }

        /**
         * Get settings page label.
         *
         * @return string
         * @since 1.0.0
         */
        public function get_label()
        {
            return $this->label;
        }

        /**
         * Add this page to settings.
         *
         * @param array $pages
         *
         * @return mixed
         */
        public function add_settings_page($pages)
        {
            $pages[$this->id] = $this->label;

            return $pages;
        }

        /**
         * Get settings array.
         *
         * @return array
         */
        public function get_settings()
        {

            return apply_filters('easy_featured_video_get_settings_' . $this->id, array());
        }

        /**
         * Get sections.
         *
         * @return array
         */
        public function get_sections()
        {
            return apply_filters('easy_featured_video_get_sections_' . $this->id, array());
        }

        /**
         * Output sections.
         */
        public function output_sections()
        {
            global $current_section;

            $sections = $this->get_sections();

            if (empty($sections) || 1 === sizeof($sections)) {
                return;
            }

            echo '<ul class="subsubsub">';

            $array_keys = array_keys($sections);

            foreach ($sections as $id => $label) {
                echo '<li><a href="' . admin_url('admin.php?page=easy-featured-video-settings&tab=' . $this->id . '&section=' . sanitize_title($id)) . '" class="' . ($current_section == $id ? 'current' : '') . '">' . $label . '</a> ' . (end($array_keys) == $id ? '' : '|') . ' </li>';
            }

            echo '</ul><br class="clear" />';
        }

        /**
         * Output the settings.
         */
        public function output()
        {
            $settings = $this->get_settings();

            Easy_Featured_Video_Admin_Settings::output_fields($settings);
        }

        /**
         * Save settings.
         */
        public function save()
        {
            global $current_section;

            $settings = $this->get_settings();


            Easy_Featured_Video_Admin_Settings::save_fields($settings);

            if ($current_section) {
                do_action('easy_featured_video_update_options_' . $this->id . '_' . $current_section);
            }
        }
    }

endif;
