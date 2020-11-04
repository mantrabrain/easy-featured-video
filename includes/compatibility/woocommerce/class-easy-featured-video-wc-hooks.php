<?php

class Easy_Featured_Video_WC_Hooks
{
    public function __construct()
    {
        if (get_option('easy_featured_video_woocommerce_option')) {
            $hook = '';
            $easy_featured_video_woocommerce_option = get_option('easy_featured_video_woocommerce_option');

            if ($easy_featured_video_woocommerce_option == "short_description") {
                $hook = "woocommerce_before_add_to_cart_form";
            } else if ($easy_featured_video_woocommerce_option == "before_image_gallery") {
                $hook = "woocommerce_before_single_product_summary";
            } else if ($easy_featured_video_woocommerce_option == "after_add_to_cart_button") {
                $hook = "woocommerce_after_add_to_cart_button";
            } else if ($easy_featured_video_woocommerce_option == "after_summery") {
                $hook = "woocommerce_after_single_product_summary";
            }
            if ($easy_featured_video_woocommerce_option == "in_main_description") {
                add_action("the_content", array($this, "easy_featured_video_main_desc_for_pdt"));
            }


            $all_plugins = apply_filters('active_plugins', get_option('active_plugins'));
            if (stripos(implode($all_plugins), 'woocommerce.php')) {
                if ($hook != '') {
                    add_action($hook, array($this, 'add_text_after_excerpt_single_product'), 9);
                }
            }


        }


    }

    function add_text_after_excerpt_single_product()
    {
        global $product;
        echo '<div class="woocommerce-product-video" style="margin:10px auto;">';
        echo '<div style="clear:both">' . do_shortcode('[easy_featured_video_show]') . '</div>';
        echo "</div>";
    }

    function easy_featured_video_main_desc_for_pdt($content)
    {

        $easy_featured_video_vid_woo = '';
        $easy_featured_video_after_contents = get_option('easy_featured_video_after_contents');
        global $post;
        if ($post->post_type == "product") {
            $easy_featured_video_vid_woo .= '<div class="woocommerce-product-video" style="margin:10px auto;">';
            $easy_featured_video_vid_woo .= '<div style="clear:both">' . do_shortcode('[easy_featured_video_show]') . '</div>';
            $easy_featured_video_vid_woo .= "</div>";
        }
        return $content . $easy_featured_video_vid_woo;
    }



}

new Easy_Featured_Video_WC_Hooks();