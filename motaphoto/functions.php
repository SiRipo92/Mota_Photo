<?php
/**
 * Theme Name: MotaPhoto
 * Version: 1.1
 * Author: Sierra Ripoche
 * Description: MotaPhoto is designed as a photography portfolio theme for artist Nathalie Mota, who does event photography, portraits, and more. The theme is designed to be simple and clean, with a focus on the images. It includes a custom post type for photo galleries, and a custom taxonomy for categorizing photos. The theme is fully compatible with the site editor, and takes advantage of new design tools introduced in WordPress 6.4.
 * Tested up to: 6.5
 * Requires PHP: 7.0
 * License: GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Tags: photography, responsive, custom-header, custom-menu, featured-images, future-blog, dynamic-filter
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Include required files.
 * --- menus.php (for registering theme menus with Nav Walker)
 * --- custom-banner.php (for adding a custom banner to the theme)
 * --- ajax-handlers.php (for handling AJAX requests for photo gallery functionality)
 */
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/custom-banner.php';
require_once get_template_directory() . '/inc/ajax-handlers.php';


/**
 * Enqueue theme stylesheets 
 * ---the required CSS file for WP Custom Theme (EMPTY)
 * --- a personalized CSS file compiled from SASS and deposited in the /assets/css/ directory.
 */
function add_motaphoto_styles() {
    wp_enqueue_style('motaphoto-styles', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-custom-styles', get_template_directory_uri() . '/assets/css/custom.css');
}
add_action('wp_enqueue_scripts', 'add_motaphoto_styles');

/// Enqueue theme scripts
function add_motaphoto_scripts() {
    // Enqueue jQuery
    wp_enqueue_script('jquery');

    // Enqueue Index.js script for homepage
    wp_enqueue_script('motaphoto-custom-script', get_template_directory_uri() . '/assets/js/index.js', array('jquery'), null, true);

    // Localize script with dynamic data for photo gallery
    if (is_singular('photo')) {
        $referenceID = get_field('Reference', get_the_ID());
        wp_add_inline_script('motaphoto-custom-script', 'const customData = ' . json_encode(array('referenceID' => $referenceID)) . ';', 'before');
    } else {
        wp_add_inline_script('motaphoto-custom-script', 'const customData = ' . json_encode(array('referenceID' => '')) . ';', 'before');
    }

    // Enqueue your custom scripts for AJAX
    wp_enqueue_script('motaphoto-photo-gallery-scripts', get_template_directory_uri() . '/assets/js/ajax-scripts.js', array('jquery'), null, true);

    // Generate nonces for AJAX requests
    $fetch_photos_nonce = wp_create_nonce('fetch_photos_nonce');
    $load_more_photos_nonce = wp_create_nonce('load_more_photos_nonce');
    $lightbox_fetch_photos_nonce = wp_create_nonce('lightbox_fetch_photos_nonce');

    // Localize ajax-scripts.js with nonces and data
    wp_localize_script('motaphoto-photo-gallery-scripts', 'ajax_pagination_data', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => $load_more_photos_nonce,
    ));

    wp_localize_script('motaphoto-photo-gallery-scripts', 'ajax_filter_sorting_data', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => $fetch_photos_nonce,
    ));

    // Prepare an array to hold photo data
    $photos_data = array();

    // Query custom posts (photos)
    $args = array(
        'post_type' => 'photo', 
        'posts_per_page' => -1, // Retrieve all posts
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Retrieve the data for each photo
            $photo_id = get_the_ID();
            $reference_id = get_field('Reference', $photo_id);
            $featured_image = get_the_post_thumbnail_url($photo_id, 'full');
            $categories = wp_get_post_terms($photo_id, 'categorie', array('fields' => 'names'));
            $formats = wp_get_post_terms($photo_id, 'format', array('fields' => 'names'));
            $published_date = get_the_date('Y', $photo_id);

            // Prepare data for each photo
            $photos_data[] = array(
                'id' => $photo_id,
                'reference_id' => $reference_id,
                'featured_image' => $featured_image,
                'categories' => $categories,
                'formats' => $formats,
                'published_date' => $published_date,
            );
        }
        wp_reset_postdata();
    }

    // Localize ajax-scripts.js with photosData
    wp_localize_script('motaphoto-photo-gallery-scripts', 'photosData', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'data' => $photos_data,
        'nonce' => $lightbox_fetch_photos_nonce,
    ));
}

add_action('wp_enqueue_scripts', 'add_motaphoto_scripts');


/**
 * Theme setup.
 */
function motaphoto_theme_setup() {
    // Custom Logo
    add_theme_support('custom-logo', array(
        'height'      => 'auto',
        'width'       => 'auto',
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
        'unlink-homepage-logo' => true,
    ));

    // Theme Menus
    register_nav_menus(array(
        'primary' => __('Primary Menu'),
        'footer'  => __('Footer Menu'),
        'mobile'  => __('Mobile Menu'),
    ));

    // Additional theme support
    add_theme_support('menus');
}
add_action('after_setup_theme', 'motaphoto_theme_setup');

/**
 * Register Nav Walker.
 */
function register_navwalker() {
    if (!file_exists(get_template_directory() . '/inc/menus.php')) {
        return;
    }
    require_once get_template_directory() . '/inc/menus.php';
}
add_action('after_setup_theme', 'register_navwalker');