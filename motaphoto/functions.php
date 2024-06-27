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
 * Enqueue theme stylesheets and scripts.
 */
function add_motaphoto_styles() {
    wp_enqueue_style('motaphoto-styles', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('motaphoto-custom-styles', get_template_directory_uri() . '/assets/css/custom.css');
}
add_action('wp_enqueue_scripts', 'add_motaphoto_styles');

function add_motaphoto_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('motaphoto-custom-script', get_template_directory_uri() . '/assets/js/index.js', array('jquery'), null, true);

    if (is_singular('photo')) {
        $referenceID = get_field('Reference', get_the_ID());
        wp_localize_script('motaphoto-custom-script', 'customData', array('referenceID' => $referenceID));
    } else {
        wp_localize_script('motaphoto-custom-script', 'customData', array('referenceID' => ''));
    }

    wp_enqueue_script('motaphoto-ajax-filter', get_template_directory_uri() .'/assets/js/ajax-filter.js', array('jquery'), null, true);
    wp_localize_script('motaphoto-ajax-filter', 'ajaxFilter', array('ajaxurl' => get_template_directory_uri() . '/inc/ajax-handlers.php'));

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
 * Include required files.
 */
require_once get_template_directory() . '/inc/ajax-handlers.php';
require_once get_template_directory() . '/inc/menus.php';
require_once get_template_directory() . '/inc/custom-banner.php';

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