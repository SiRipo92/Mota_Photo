<?php
/**
* Theme Name: Mota_Photo
* Version: 1.0
* Author: Sierra Ripoche
* Description: Mota_Photo is designed as a photography portfolio theme for artist Nathalie Mota, who does event photography, portraits, and more. The theme is designed to be simple and clean, with a focus on the images. It includes a custom post type for photo galleries, and a custom taxonomy for categorizing photos. The theme is fully compatible with the site editor, and takes advantage of new design tools introduced in WordPress 6.4.
* Tested up to: 6.5
* Requires PHP: 7.0
* Version: 1.1
* License: GNU General Public License v2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html
* Text Domain: Mota_Photo
* Tags: photography, clean, elegant, responsive, two-columns, custom-background, custom-header, custom-menu, featured-images
*/

// Load theme's styles and scripts

function mota_photo_styles(){
    // Load photo styles
    wp_enqueue_style('mota_photo_styles', get_stylesheet_uri());
    // Load Google Fonts
    wp_enqueue_style('mota_photo_google_fonts', 'https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
    // Load jQuery & custom scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('mota_photo_scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), null, true);
    // Load CSS Styles applied from Sass scripts
    wp_enqueue_style('mota_photo_sass', get_template_directory_uri() . '/assets/css/custom.css');
}
add_action('wp_enqueue_scripts', 'mota_photo_styles');